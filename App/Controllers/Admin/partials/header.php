<header>
	<?php require_once __DIR__ . '/nav.php'; ?>
	<?php require_once __DIR__ . '/breadcrumbs.php'; ?>
	
	<?php if ( $vars[ 'page_title' ] ): ?>
		<div class="container">
			<h1 class="text-muted mb-5 mt-5 display-3"><?php echo $vars[ 'page_title' ]; ?></h1>
		</div>
	<?php endif; ?>
</header>
