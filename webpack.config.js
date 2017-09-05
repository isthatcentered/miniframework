const path = require( 'path' )

module.exports = {
	entry: path.resolve( __dirname, 'App/scriptz/index.ts' ),
	output: {
		filename: 'bundle.js',
		path: path.resolve( __dirname, 'App/' )
	},
	module: {
		rules: [
			{
				enforce: 'pre',
				test: /\.js$/, //test: [ /\.js$/, /\.tsx?$/],
				loader: 'source-map-loader'
			},
			{
				enforce: 'pre',
				test: /\.tsx?$/,
				use: 'source-map-loader'
			},
			{
				test: /\.tsx?$/,
				loader: 'ts-loader',
				exclude: /node_modules/,
				options: {
					transpileOnly: true,
					silent: true
				}
			}
		]
	},
	resolve: {
		extensions: [ '.tsx', '.ts', '.js' ]
	},
	devtool: 'inline-source-map',
}