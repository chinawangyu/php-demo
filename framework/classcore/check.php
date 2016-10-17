<?php 

	namespace framework\classcore;

	class check{


		private static $config = array(
			'phone' => '/^1[3578]\d{9}$/',
			'noSpace' => '/^[^\s]+$/'
		);


		public static function __callStatic($method,$arg){
			
			$bool = array_key_exists($method, self::$config);
			if($bool){
				return (bool)preg_match(self::$config[$method], $arg[0]);
			}
			
		}

	}