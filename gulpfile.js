// gulp gulp-load-plugins browser-sync gulp-clean gulp-wait gulp-sass gulp-debug gulp-autoprefixer gulp-sourcemaps gulp-plumber gulp-pug

const gulp = require( 'gulp' ),
	path = require( 'path' ),
	$ = require( 'gulp-load-plugins' )(),
	bsync = require( 'browser-sync' )


const ROOT = {
		SRC: 'src/',
		DIST: 'dist/'
	},
	DIST = ROOT.DIST, // ./dist
	STYLES = ROOT.SRC + 'styles/', // src/styles/**/*
	TEMPLATES = ROOT.SRC, // src/**/*
	ASSETS = ROOT.SRC + 'public/' // src/public/**/*


// Clean ============================================================================================
gulp.task( 'clean', () =>
	gulp.src( [ DIST ], { read: false } )
		.pipe( $.clean() ) )


// Sass ============================================================================================
gulp.task( 'styles', () =>
	gulp.src( STYLES + '/**/*.scss', { base: 'src' } ) // {base: "./src"} allows us to maintain folders path starting at ./src
	// .pipe( $.wait( 500 ) ) // needed when working with vscode, otherwise you get a file not working error
		.pipe( $.sass().on( 'error', $.sass.logError ) )
		.pipe( $.debug( { title: 'Styles:' } ) ) // Log parsed files
		.pipe( $.autoprefixer( { browsers: [ 'last 2 versions', '> 5%' ] } ) ) // autoprefixer has to be piped before sourcemaps
		.pipe( $.sourcemaps.init() ) // Allowing tracking of class origin with sourcemaps
		.pipe( $.sass().on( 'error', $.sass.logError ) )
		.pipe( $.sourcemaps.write() ) // Write sourcemaps for browser
		.pipe( gulp.dest( DIST ) ) )

gulp.task( 'styles:watch', [ 'styles' ], () =>
	gulp.watch( STYLES + '**/*.scss', [ 'styles' ] ) )


// Pug ============================================================================================
gulp.task( 'templates', () =>
	gulp.src( TEMPLATES + '**/*.pug', { base: 'src' } ) // {base: "./src"} allows us to maintain folders path starting at ./src
		.pipe( $.plumber() ) // Allows watch to continue on error
		.pipe( $.pug( {} ) )
		.pipe( $.plumber.stop() ) // Allows watch to continue on error
		.pipe( gulp.dest( DIST ) ) )

gulp.task( 'templates:watch', [ 'templates' ], () =>
	gulp.watch( TEMPLATES + '**/*.pug', [ 'templates' ] ) )


// Assets ============================================================================================
gulp.task( 'assets', () =>
	gulp.src( ASSETS + '**/*.*', { base: 'src' } ) // {base: "./src"} allows us to maintain folders path starting at ./src
		.pipe( gulp.dest( DIST ) ) )

gulp.task( 'assets:watch', [ 'assets' ], () =>
	gulp.watch( ASSETS + '**/*.*', [ 'assets' ] ) )


// Server ============================================================================================
gulp.task( 'server', [], () => {

	bsync.init( {

		files: [ 'index.{php,html}', '{App,Api,Core}/**/*.{php,html,js}' ], // Refresh browser when your see a change in one of those files
		// notify: false, // Don't log
		//port: 3000,
		ui: false,
		proxy: 'http://localhost:8888/puppy_commerce/'
	} )
} )

// Command ============================================================================================
gulp.task( 'command', [], () => {
	return $.run( 'php Api/index.php' ).exec()
		.pipe( $.plumber() ) // Allows watch to continue on error
		.pipe( $.plumber.stop() ) // Allows watch to continue on error

} )
gulp.task( 'command:watch', [ 'command' ], () =>
	gulp.watch( [ 'index.{php,html}', '{App,Api,Core}/**/*.php' ], [ 'command' ] ) )

/**
 * Serve
 */
gulp.task( 'default', [ 'styles:watch', 'templates:watch', 'assets:watch', 'server' ] )