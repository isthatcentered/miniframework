<?php require_once __DIR__ . '/../../partials/head.php'; ?>

<?php require_once __DIR__ . '/../../partials/header.php'; ?>

<div class="container">
	
	<main>
		<table class="table">
			<thead>
			<tr>
				<th>#</th>
				<th>Email</th>
			</tr>
			</thead>
			<tbody>
			<?php foreach ( $vars[ 'items' ] as $item ): ?>
				<tr>
					<th scope="row"><?php echo $item -> id; ?></th>
					<td>
						<a href="<?php echo $vars[ 'BASE_URL' ] . '/admin/users/' . $item -> id; ?>">
							<?php echo $item -> name; ?>
						</a>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</main>
</div>

<?php require_once __DIR__ . '/../../partials/scripts.php'; ?>
<?php require_once __DIR__ . '/../../partials/foot.php'; ?>
