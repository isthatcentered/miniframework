<?php require_once __DIR__ . '/../../partials/head.php'; ?>

<?php require_once __DIR__ . '/../../partials/header.php'; ?>

<div class="container">
	
	<main>
		
		<a href="<?php echo $vars[ 'URL_ADMIN' ] . '/pictures/new'; ?>" class="btn btn-primary btn-sm mb-3">+ Ajouter une image</a>
		
		<div class="row">
			
			<?php foreach ( $vars[ 'items' ] as $item ): ?>
				<article>
					<figure class="col-6 col-sm-3 col-md-2 figure">
						<img src="<?php echo $vars[ 'BASE_URL' ] . '/public/uploads/images/' . $item -> url; ?>"
						     class="img-fluid"
						     alt="<?php echo $item -> alt; ?>">
						<figcaption class="figure-caption">
							<h3><?php echo $item->alt; ?></h3>
							<p>id: <?php echo $item->id; ?></p>
						</figcaption>
					</figure>
				</article>
				<hr>
			<?php endforeach; ?>
		</div>
	
	</main>
</div>

<?php require_once __DIR__ . '/../../partials/scripts.php'; ?>
<?php require_once __DIR__ . '/../../partials/foot.php'; ?>
