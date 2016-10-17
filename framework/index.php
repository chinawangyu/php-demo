<?php 

	namespace framework;	
 	
	header('Content-type:text/html;charset=utf-8;');
	require './core/load.php';
	require './functions/function.php';

	
	session_start();

	$_GET['m'] = empty($_GET['m'])?'index':$_GET['m'];	
	$_GET['c'] = empty($_GET['c'])?'index':$_GET['c'];

	define('ROOT', __DIR__.'/');
	define('VIEW',ROOT.'view/'.$_GET['m']);
	define('COMPLETE',ROOT.'view/complete/'.$_GET['m']);
	define('CACHE',ROOT.'view/cache/'.$_GET['m']);


	core\framework::start();


