<?php

// url  ,  controller  ,  metodo da controller
Router::get('/', 'DefaultController', 'index');

// url base  ,  controller
	// metodo, resto da url, metodo da controller
Router::group('/elore', 'EloreController', array(
	array('get', '/autoriza/:cpf', 'verifica_cpf')
));