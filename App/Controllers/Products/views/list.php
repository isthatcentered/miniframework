<?php require_once __DIR__ . '/../../../partials/head.php'; ?>

<?php require_once __DIR__ . '/../../../partials/header.php'; ?>

<div class="container">
	<div class="row">
		
		<main class="col-12 col-sm-8 col-md-9">
			
			<ul class="row list-unstyled">
				<?php foreach ( $vars[ 'products' ] as $product ): ?>
					<li class="col-12  col-md-6 col-lg-4 mb-4">
						<article class="-frame p-3 -shadow _rise d-flex flex-column align-items-stretch">
							
							<a href="<?php echo $vars[ 'BASE_URL' ]; ?>/products/<?php echo $product -> id; ?>">
								<h3><?php echo $product -> name; ?></h3>
								<p><?php echo $product -> description; ?></p>
								<p><?php echo $product -> price; ?>€</p>
							</a>
							
							<a href="#"
							   class="btn btn-outline-primary js-basket-add btn-sm btn-block mt-auto"
							   data-product='<?php echo htmlspecialchars( json_encode( $product ), ENT_QUOTES, 'UTF-8' ); ?>'>
								Ajouter au panier
							</a>
						</article>
					</li>
				<?php endforeach; ?>
			</ul>
		</main>
		
		<aside class="col-12 col-sm-4 col-md-3">
			<?php require_once __DIR__ . '/../../../partials/basket.php'; ?>
		</aside>
	</div>
</div>


<?php require_once __DIR__ . '/../../../partials/scripts.php'; ?>

<?php require_once __DIR__ . '/../../../partials/foot.php'; ?>
