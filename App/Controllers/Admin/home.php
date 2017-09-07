<?php require_once __DIR__ . '/partials/head.php'; ?>

<?php require_once __DIR__ . '/partials/header.php'; ?>


<main class="container">
	<nav>
		<ul class="list-inline">
			<li class="list-inline-item">
				<a class="mb-3 _inline" href="<?php echo $vars[ 'BASE_URL' ] . '/admin/products'; ?>">Produits</a>
			</li>
			<li class="list-inline-item">
				<a class="mb-3 _inline" href="<?php echo $vars[ 'BASE_URL' ] . '/admin/pictures'; ?>">Images</a>
			</li>
			<li class="list-inline-item">
				<a class="mb-3 _inline" href="<?php echo $vars[ 'BASE_URL' ] . '/admin/users'; ?>">Utilisateurs</a>
			</li>
		</ul>
	</nav>

</main>


<?php require_once __DIR__ . '/partials/scripts.php'; ?>
<?php require_once __DIR__ . '/partials/foot.php'; ?>
