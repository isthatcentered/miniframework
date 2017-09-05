<?php require_once __DIR__ . '/../../partials/head.php'; ?>
<style>
	label {
		display: block;
	}
</style>
<header>
	<?php require_once __DIR__ . '/../../partials/nav.php'; ?>
</header>

<div class="container">
	
	<h1 class="mb-3">Produits</h1>
	
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="<?php echo $vars[ 'URL_ADMIN' ]; ?>">Accueil</a></li>
		<li class="breadcrumb-item"><a href="<?php echo $vars[ 'URL_ADMIN' ] . '/products'; ?>">Produits</a></li>
		<li class="breadcrumb-item active">Nouveau</li>
	</ol>
	
	<main>
		
		<form class="js-product-post"
		      action="/"
		      method="post">
			
			<label class="form-group">
				<span class="form-control-label">Nom:</span>
				<input class="form-control" name="name" type="text" placeholder="Medor's tastyest postman leg" required>
			</label>
			
			<label class="form-group">
				<span class="form-control-label">Description:</span>
				<textarea class="form-control" name="description" placeholder="One not too bloddy postman leg for your dog to chew on when it feels blue" required></textarea>
			</label>
			
			<label class="form-group">
				<span class="form-control-label">Prix:</span>
				<input type="number" name="price" placeholder="100" required>
			</label>
			
			<!--	<label class="form-group">-->
			<!--		<span class="form-control-label">Image:</span>-->
			<!--		<input type="file" name="img">-->
			<!--	</label>-->
			
			<button class="btn btn-primary" type="submit">Ajouter le produit</button>
		</form>
	</main>
</div>

<?php require_once __DIR__ . '/../../partials/scripts.php'; ?>
<?php require_once __DIR__ . '/../../partials/foot.php'; ?>
