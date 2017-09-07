<header>
	
	<?php require_once __DIR__ . '/nav.php'; ?>
	
	<?php require_once __DIR__ . '/breadcrumbs.php'; ?>

	
	<?php if ( $vars[ 'page_title' ] ): ?>
		<div class="container">
			<h1 class="display-4 mb-5 mt-5 text-muted"><?php echo $vars[ 'page_title' ]; ?></h1>
		</div>
	<?php endif; ?>
</header>

