<?php
$baseUrl = $vars[ 'baseUrl' ];
?>
<?php require_once __DIR__ . '/../../partials/head.php'; ?>
<header>
	
	<nav class="row">
		<div class="col-12">
			
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?php echo $BASE_URL; ?>/">Accueil</a></li>
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


<ul class="row list-unstyled">
	<li class="bg-light mb-3 col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center align-items-center">
		<a href="<?php echo $BASE_URL; ?>/products/new" class="btn btn-primary btn-sm m-auto">+ Add product</a>
	</li>
	<?php foreach ( $vars[ 'products' ] as $product ): ?>
		<li class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
			<a href="<?php echo $BASE_URL; ?>/products/<?php echo $product -> id; ?>">
				<h3><?php echo $product -> name; ?></h3>
				<p><?php echo $product -> description; ?></p>
				<p><?php echo $product -> price; ?>€</p>
			</a>
		</li>
	<?php endforeach; ?>
</ul>


<?php require_once __DIR__ . '/../../partials/scripts.php'; ?>

<?php require_once __DIR__ . '/../../partials/foot.php'; ?>
