<?php 

	namespace framework\controller;
	use framework\model\shopData;

	class shop extends \framework\classcore\smarty{

		public function getShopList(){

			$lastId = empty($_GET['lastId'])?0:$_GET['lastId'];
			$limit  = empty($_GET['limit'])?3:$_GET['limit'];


			$shopdata = new shopData();
			$data = $shopdata->getShopData($lastId,$limit);

			header('Content-type:application/json;');
			echo json_encode($data);

		}

	}
