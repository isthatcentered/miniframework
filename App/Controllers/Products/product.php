<?php
$product = $vars[ 'product' ];
?>
<?php require_once __DIR__ . '/../../partials/head.php'; ?>
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="<?php echo $BASE_URL; ?>/">Accueil</a></li>
	<li class="breadcrumb-item"><a href="<?php echo $BASE_URL; ?>/products">Products</a></li>
	<li class="breadcrumb-item active"><?php echo $product -> name; ?></li>
</ol>

<nav>
	<ul class="nav nav-pills">
<!--		<li class="nav-item"><a href="#" class="nav-link">Editer</a></li>-->
		<li class="nav-item">
			<a href="#"
			   class="nav-link js-products-delete"
			   data-product-id="<?php echo $product->id; ?>">Supprimer</a>
		</li>
	</ul>
</nav>
<h1><?php echo $product -> name; ?></h1>
<p class="lead"><?php echo $product -> description; ?></p>
<p><?php echo $product -> price; ?>€</p>

<?php require_once __DIR__ . '/../../partials/scripts.php'; ?>
<?php require_once __DIR__ . '/../../partials/foot.php'; ?>
