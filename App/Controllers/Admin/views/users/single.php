<?php

$item = $vars[ 'item' ];
require_once __DIR__ . '/../../partials/head.php';
?>

<?php require_once __DIR__ . '/../../partials/header.php'; ?>



<div class="container">
	<main class="row">
		<div class="col-12">
<!--			<a href="" class="btn btn-danger mb-3 js-products-delete" data-product-id="--><?php //echo $item -> id; ?><!--">Supprimer</a>-->
			<h2 class="mb-3"><?php echo $item -> name; ?></h2>
		</div>
	</main>
	
	<?php require_once __DIR__ . '/../../partials/scripts.php'; ?>
</div>
<?php require_once __DIR__ . '/../../partials/foot.php'; ?>

