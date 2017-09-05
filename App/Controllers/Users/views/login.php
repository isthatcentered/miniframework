<?php require_once __DIR__ . '/../../../partials/head.php'; ?>


<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="<?php echo $vars[ 'BASE_URL' ]; ?>/">Accueil</a></li>
	<li class="breadcrumb-item active">Login</li>
</ol>
<main>
	
	<form class="js-auth-login" method="post" action="<?php echo $vars[ 'BASE_URL ' ] . '/authenticate'; ?>">
		<label class="form-group">
			<span class="form-control-label">Email:</span>
			<input class="form-control" name="name" type="email" value="booba@ourson.com" required>
		</label>
		<label class="form-group">
			<span class="form-control-label">Password</span>
			<input class="form-control" name="password" type="text" value="lepetitourson" required>
		</label>
		<button class="btn btn-primary" type="submit">Se logger</button>
	</form>
</main>

<?php require_once __DIR__ . '/../../../partials/scripts.php'; ?>
<?php require_once __DIR__ . '/../../../partials/foot.php'; ?>
