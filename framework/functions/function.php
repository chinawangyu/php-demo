<?php 

	function M($tablename){
		return \framework\classcore\mysql::link($tablename);
	}



	/*
		S('username'); 
		S(array('username','sex'));

		S('username','demo',5)

		S('username',null);  delete
	*/
	function S($name,$value='',$time=0){

		$memcache = new \Memcache;	
		$memcache->pconnect('127.0.0.1');

		if( is_null($value) ){
			$data = $memcache->delete($name);
		}

		if( is_array($name) || empty($value) ){
			$data = $memcache->get($name);
		}else{
			$data = $memcache->set($name,$value,false,$time);
		}

		return $data;
	}