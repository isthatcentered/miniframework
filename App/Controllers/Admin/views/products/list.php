<?php require_once __DIR__ . '/../../partials/head.php'; ?>

<?php require_once __DIR__ . '/../../partials/header.php'; ?>

<div class="container">
	
	
	<main>
		
		<a href="<?php echo $vars[ 'URL_ADMIN' ] . '/products/new'; ?>"
		   class="btn btn-primary btn-sm mb-5">
			+ Ajouter un produit
		</a>
		
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
	</main>
</div>

<?php require_once __DIR__ . '/../../partials/scripts.php'; ?>
<?php require_once __DIR__ . '/../../partials/foot.php'; ?>
