<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

<script>
	// Need to pass this to the app
	const APP_URL = '<?php echo $vars[ 'BASE_URL' ]; ?>'
	const APP_ADMIN_URL = '<?php echo $vars[ 'BASE_URL' ] . '/admin'; ?>'
	const API_URL = APP_URL + '/api'
	const API_ENDPOINTS= {
		PRODUCTS: API_URL + '/products'
	}
</script>
<script src="<?php echo $vars['BASE_URL']; ?>/app/bundle.js"></script>
