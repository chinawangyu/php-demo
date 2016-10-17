<?php 

	namespace framework\model;
	 
	class shopData{

		/*获取记录*/
	 	public function getShopData($lastId,$limit){

	 		$data = \M('shop')->where('id >'.$lastId)->limit($limit)->select();


	 		$response = array(
	 			'data' => $data,
	 			'lastId' => end($data)['id']
	 		);

	 		return $response;	

	 	}


	}