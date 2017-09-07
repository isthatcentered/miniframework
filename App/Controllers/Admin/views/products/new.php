<?php require_once __DIR__ . '/../../partials/head.php'; ?>
<style>
	label {
		display: block;
	}
</style>
<?php require_once __DIR__ . '/../../partials/header.php'; ?>

<div class="container">
	
	
	<main>
		
		
		<form class="js-product-post mb-3"
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
			
			<a href="#" data-product-id="" class="mb-3 js-picture-add-form" style="display: inline-block;">Ajouter une image</a>
			<br>
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
