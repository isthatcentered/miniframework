<?php require_once __DIR__ . '/../../partials/head.php'; ?>


<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="<?php echo $BASE_URL; ?>/">Accueil</a></li>
	<li class="breadcrumb-item"><a href="<?php echo $BASE_URL; ?>/products">Products</a></li>
	<li class="breadcrumb-item active">Nouveau</li>
</ol>
<main>
	
	<form method="post" action="<?php echo $BASE_URL . '/authenticate'; ?>">
		<label class="form-group">
			<span class="form-control-label">Email:</span>
			<input class="form-control" name="username" type="text" required>
		</label>
		<label class="form-group">
			<span class="form-control-label">Password</span>
			<input class="form-control" name="password" type="text" required>
		</label>
		<button class="btn btn-primary" type="submit">Se logger</button>
	</form>
</main>

<?php require_once __DIR__ . '/../../partials/scripts.php'; ?>
<?php require_once __DIR__ . '/../../partials/foot.php'; ?>
