<?php require_once __DIR__ . '/../../partials/head.php'; ?>

<?php require_once __DIR__ . '/../../partials/header.php'; ?>

<div class="container">
	
	
	<main>
		
		<form class="js-picture-post"
		      action="<?php echo $vars[ 'BASE_URL' ] . '/api/pictures'; ?>"
		      method="post"
		      enctype="multipart/form-data">
			<fieldset>
				<input type="file" name="file" class="">
				<label>
					Alt text: <br>
					<input class="form-control" type="text" name="alt" value="meh">
				</label>
				<label >
					Product id: <br>
					<input type="number" name="productId" >
				</label>
			</fieldset>
			<button class="btn btn-primary btn-sm">Submit</button>
		</form>
	
	</main>
</div>

<?php require_once __DIR__ . '/../../partials/scripts.php'; ?>
<?php require_once __DIR__ . '/../../partials/foot.php'; ?>
