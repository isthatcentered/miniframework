<?php require_once __DIR__ . '/../../partials/head.php'; ?>

<header>
	<?php require_once __DIR__ . '/../../partials/nav.php'; ?>
</header>

<div class="container">
	
	<h1 class="mb-3">New pic</h1>
	
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="<?php echo $vars[ 'URL_ADMIN' ]; ?>">Accueil</a></li>
		<li class="breadcrumb-item"><a href="<?php echo $vars[ 'URL_ADMIN' ] . '/pictures'; ?>">Pictures</a></li>
		<li class="breadcrumb-item active">New</li>
	</ol>
	
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
			</fieldset>
			<button class="btn btn-primary btn-sm">Submit</button>
		</form>
	
	</main>
</div>

<?php require_once __DIR__ . '/../../partials/scripts.php'; ?>
<?php require_once __DIR__ . '/../../partials/foot.php'; ?>
