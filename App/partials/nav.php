<nav class="navbar navbar-expand-sm navbar-light bg-primary">
	<div class="container">
		
		<a class="navbar-brand" href="<?php echo $vars[ 'BASE_URL' ] . '/'; ?>">
			<img src="<?php echo $vars[ 'BASE_URL' ] . '/public/images/logo.png'; ?>"
			     alt="logo de puppy & co"
			     style="max-width: 80px;">
		</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a href="<?php echo $vars[ 'BASE_URL' ] . '/products'; ?>" class="nav-link text-uppercase font-weight-bold">Produits</a>
				</li>
			</ul>
			<ul class="navbar-nav">
				
				<!-- If logged -->
				<?php if ( $vars[ 'IS_LOGGED_IN' ] ): ?>
					
					<li class="nav-item">
						<a href="<?php echo $vars[ 'BASE_URL' ] . '/logout'; ?>" class="nav-link">Se déconnecter</a>
					</li>
					
					<!-- & admin -->
					<?php if ( $vars[ 'IS_ADMIN' ] ): ?>
						
						<li class="nav-item">
							<a href="<?php echo $vars[ 'BASE_URL' ] . '/admin'; ?>" class="nav-link">Administration</a>
						</li>
					<?php endif; ?>
					
					<!-- Else -->
				<?php else: ?>
					
					<li class="nav-item">
						<a href="<?php echo $vars[ 'BASE_URL' ] . '/login'; ?>" class="nav-link">Se connecter</a>
					</li>
					
					<li class="nav-item">
						<a href="<?php echo $vars[ 'BASE_URL' ] . '/register'; ?>" class="nav-link">S'enregistrer</a>
					</li>
				<?php endif; ?>
			</ul>
		</div>
		
		<form class="form-inline">
		
		</form>
	</div>
</nav>
