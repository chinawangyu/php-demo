<?php 

	namespace framework\core;

	class framework{

		public static function start(){

			$controller = $_GET['m'];
			$method =  $_GET['c'];	

			$controller = "\\framework\\controller\\$controller";

			$obj = new $controller;
			$obj->$method();
		}

	}
