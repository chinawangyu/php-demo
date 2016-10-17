<?php 
	
	namespace framework\core;

	class load{

		public static  function loadPHP($filename){

			$arr = explode('\\', $filename);
			array_shift($arr);
			$filename = implode('/',$arr);
	 		require ROOT.$filename.'.php'; 
		}

	}

	 
	spl_autoload_register("\\framework\\core\\load::loadPHP");
