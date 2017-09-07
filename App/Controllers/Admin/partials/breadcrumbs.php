<?php if ( isset($vars[ 'breadcrumbs' ]) ): ?>
	<nav class="bg-primarylight">
		<div class="container">
			<ol class="breadcrumb -sharp row ">
				<?php for ( $i = 0; $i <= count( $vars[ 'breadcrumbs' ] ) - 1; $i++ ): ?>
					<?php if ( $i !== count( $vars[ 'breadcrumbs' ] ) - 1 ): ?>
						<li class="breadcrumb-item">
							<a class="text-secondary"
							   href="<?php echo $vars[ 'URL_ADMIN' ] . $vars[ 'breadcrumbs' ][ $i ][ 'url' ]; ?>">
								<?php echo $vars[ 'breadcrumbs' ][ $i ][ 'link' ]; ?>
							</a>
						</li>
					<?php else: ?>
						<!-- Is last-->
						<li class="breadcrumb-item active"><?php echo $vars[ 'breadcrumbs' ][ $i ][ 'link' ]; ?></li>
					<?php endif; ?>
				<?php endfor; ?>
			</ol>
		</div>
	</nav>
<?php endif; ?>
