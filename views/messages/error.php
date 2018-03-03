<!DOCTYPE html>
<html>
<head>
	<title>Erro no Sistema</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="http://code.jquery.com/jquery-3.3.1.min.js" type="text/javascript"></script>
</head>
<body>
	<div class="container">
		<div style="margin: 30px;" class="alert alert-danger">
		  <b>Erro</b>: <?php echo $ex->getMessage(); ?> <br>
		  <b>No Arquivo</b><?php echo $ex->getFile(); ?> <br>
		  <b>Na Linha</b>: <?php echo $ex->getLine(); ?>
		</div>
		<div style="margin: 30px;" class="alert alert-info">
		  	<?php
		  		foreach ($ex->getTrace() as $index => $log) {
    		?>
		  		<b>Chamada <?php  echo $index; ?></b>: Através de <b><?php echo $log['function']; ?>()</b> na linha <b><?php echo $log['line']; ?> do arquivo <b><?php echo $log['file'];?></b>.
		  		<br>
		  	<?php } ?>
		</div>
	</div>
</body>
</html>