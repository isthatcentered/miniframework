<?php require_once __DIR__ . '/../../partials/head.php'; ?>
<header>
	
	<nav class="row">
		<div class="col-12">
			
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?php echo $vars[ 'BASE_URL' ]; ?>/">Accueil</a></li>
				<li class="breadcrumb-item active">Products</li>
			</ol>
		</div>
	</nav>
	
	<div class="row">
		<div class="col-12">
			
			<h1 class="mb-5">Produits</h1>
			
			<h2 class="mb-3">Tous nos produits</h2>
		</div>
	</div>
</header>

<div class="row">
	<aside class="col-12 col-sm-4 col-md-3">
		<?php require_once __DIR__ . '/../../partials/basket.php'; ?>
	</aside>
</div>


<ul class="row list-unstyled">
	<?php foreach ( $vars[ 'products' ] as $product ): ?>
		<li class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
			<a href="<?php echo $vars[ 'BASE_URL' ]; ?>/products/<?php echo $product -> id; ?>">
				<h3><?php echo $product -> name; ?></h3>
				<p><?php echo $product -> description; ?></p>
				<p><?php echo $product -> price; ?>€</p>
			</a>
			
			<a href="#"
			   class="btn btn-outline-primary js-basket-add btn-sm btn-block"
			   data-product='<?php echo htmlspecialchars(json_encode($product), ENT_QUOTES, 'UTF-8'); ?>'>
				Ajouter au panier
			</a>
		</li>
	<?php endforeach; ?>
</ul>


<?php require_once __DIR__ . '/../../partials/scripts.php'; ?>

<?php require_once __DIR__ . '/../../partials/foot.php'; ?>
