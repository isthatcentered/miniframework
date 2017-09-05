<?php

$product = $vars[ 'product' ];
require_once __DIR__ . '/../../partials/head.php';
?>


<header>
	<?php require_once __DIR__ . '/../../partials/nav.php'; ?>
</header>


<div class="container">
	
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="<?php echo $vars[ 'URL_ADMIN' ]; ?>">Accueil</a></li>
		<li class="breadcrumb-item"><a href="<?php echo $vars[ 'URL_ADMIN' ] . '/products'; ?>">Produits</a></li>
		<li class="breadcrumb-item active"><?php echo $product -> name; ?></li>
	</ol>
	
	<main class="row">
		<div class="col-12">
			<a href="" class="btn btn-danger mb-3 js-products-delete" data-product-id="<?php echo $product -> id; ?>">Supprimer</a>
			<h2 class="mb-3"><?php echo $product -> name; ?></h2>
			<p><?php echo $product -> description; ?></p>
			<p><?php echo $product -> price; ?></p>
		</div>
	</main>
	
	<?php require_once __DIR__ . '/../../partials/scripts.php'; ?>
</div>
<?php require_once __DIR__ . '/../../partials/foot.php'; ?>

