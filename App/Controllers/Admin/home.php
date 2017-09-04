<?php require_once __DIR__ . '/partials/head.php'; ?>

<header>
	<?php require_once __DIR__ . '/partials/nav.php'; ?>
</header>

<main class="container">
	
	<h1 class="mb-3">Puppy Co Admin</h1>
	
	<h2 class="mb-3"><a href="<?php echo $vars[ 'BASE_URL' ] . '/admin/products'; ?>">Products</a></h2>
	
	<table class="table">
		<thead>
		<tr>
			<th>#</th>
			<th>Nom</th>
			<th>Description</th>
			<th>Prix</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ( $vars[ 'products' ] as $product ): ?>
			<tr>
				<th scope="row"><?php echo $product -> id; ?></th>
				<td>
					<a href="<?php echo $vars[ 'BASE_URL' ] . '/admin/products/' . $product -> id; ?>">
						<?php echo $product -> name; ?>
					</a>
				</td>
				<td><?php echo $product -> description; ?></td>
				<td><?php echo $product -> price; ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	<a class="mb-3"><a href="<?php echo $vars[ 'BASE_URL' ] . '/admin/products'; ?>">Tous les produits</a></a>
</main>


<?php require_once __DIR__ . '/partials/scripts.php'; ?>
<?php require_once __DIR__ . '/partials/foot.php'; ?>
