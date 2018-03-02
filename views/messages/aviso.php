<!DOCTYPE html>
<html>
<head>
	<title>Aviso do Sistema</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="http://code.jquery.com/jquery-3.3.1.min.js" type="text/javascript"></script>
</head>
<body>
	<div class="container">
		<div style="margin: 30px;" class="alert alert-<?php echo $tipo;?>">
		  <strong>Aviso:</strong> 
		  	<?php 
				echo $msg;
			?>
		</div>
	</div>
</body>
</html><?php 