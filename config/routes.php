<?php

// Route Syntax -> url  ,  controller  ,  controller method 
Router::get('/', 'DefaultController', 'index'); // -> calls DefaultController->index() when url is yourserver.com and http method is GET
Router::post('/', 'DefaultController', 'index'); // -> calls DefaultController->index() when url is yourserver.com and http method is POST


// GROUP Routing Syntax -> url base, controller
	// Route Syntax -> http method, url remain, controller method

Router::group('/example', 'DefaultController', array(
	array('get', '/', 'test'), // -> calls DefaultController->test() when url is yourserver.com/example and method GET
	array('get', '/test', 'test_all'), // -> calls DefaultController->test_all() when url is yourserver.com/example/test and method GET
	array('get', '/test/:id', 'test_id'), // -> calls DefaultController->test_id([id]) when url is yourserver.com/example/test/{id} and method GET
));