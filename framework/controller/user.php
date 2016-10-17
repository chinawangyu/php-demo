<?php 
	
	namespace framework\controller;

	class user extends \framework\classcore\smarty{
		

		public function index(){

			$this->display();	
		}

		/*检测用户是否在登陆状态*/
		public function checkUser(){

			if( !empty($_SESSION['username']) && $_SESSION['islogin']==1 ){
				echo json_encode(array('code'=>200,'username'=>$_SESSION['username']));
			}else{
				echo json_encode(array('code'=>400));
			}

		}

		public function login(){
 			
 			$user = new \framework\model\user();
 		 	$res = $user->checkLogin($_POST);

 		 	if($res){ 		 		
 		 		echo json_encode(array('code'=>200,'msg'=>'登陆成功'));
 		 	}else{
 		 		echo json_encode(array('code'=>400,'msg'=>'登陆失败'));
 		 	}

		}

		/*退出登陆*/
		public function logout(){
			session_destroy();
			echo json_encode(array('code'=>200,'msg'=>'OK'));
		}



		public function userList(){

			$lastId = empty($_GET['lastId'])?0:$_GET['lastId'];
			$lastId = (int)$lastId;

			$data = M('user')->where('id>'.$lastId)->limit($_GET['limit'])->select();

			$data = array(
				'lastId' => end($data)['id'],
				'data' => $data
			);

			header('Content-type:application/json;');
			echo json_encode($data);

		}

	}
