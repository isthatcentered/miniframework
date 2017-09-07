<nav class="navbar navbar-expand-sm navbar-light bg-primary">
	<div class="container">
		
		<a class="navbar-brand" href="<?php echo $vars[ 'BASE_URL' ] . '/admin'; ?>">
			<img src="<?php echo $vars[ 'BASE_URL' ] . '/public/images/logo-admin.png'; ?>"
			     alt="logo de puppy & co"
			     style="max-width: 80px;">
		</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a href="<?php echo $vars[ 'BASE_URL' ] . '/admin/products'; ?>" class="nav-link text-uppercase font-weight-bold">Produits</a>
				</li>
				<li class="nav-item">
					<a href="<?php echo $vars[ 'BASE_URL' ] . '/admin/pictures'; ?>" class="nav-link text-uppercase font-weight-bold">Images</a>
				</li>
				<li class="nav-item">
					<a href="<?php echo $vars[ 'BASE_URL' ] . '/admin/users'; ?>" class="nav-link text-uppercase font-weight-bold">Utilisateurs</a>
				</li>
			</ul>
			<ul class="navbar-nav">
				
				<li class="nav-item">
					<a href="<?php echo $vars[ 'BASE_URL' ] . '/logout'; ?>" class="nav-link">Se déconnecter</a>
				</li>
				<li class="nav-item">
					<a href="<?php echo $vars[ 'BASE_URL' ] . '/'; ?>" class="nav-link">Store</a>
				</li>
			</ul>
		</div>
	</div>
</nav>
