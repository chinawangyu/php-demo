<?php 

	namespace framework\controller;
	use framework\model\user;

	class index extends \framework\classcore\smarty{

		public function index(){
				 
			$this->display();
		}

		public function reg(){

			$this->display('register.html');
		}


		/*上传文件*/
		public function upload(){

			$upload = new \framework\classcore\upload();
			if( $upload->upload() ) {
				echo $upload->getfilenames()[0];
			}else{
				echo false;
			}

		}


		/*注册一个用户*/
		public function reg_handle(){

		 	$user = new user();
		 	$res = $user->addUser($_POST);
 			

 			if($res){

 				 $message = array(
 				 	'code' => 200,
 				 	'msg'  => '注册成功'
 				 );

 			}else{

 				$message = array(
 					'code' => 400,
 					'mdg'  => '注册失败'
 				);
 			}

 			echo json_encode($message);

		}


		/*检查用户名唯一性*/
		public function checkRepeatUser(){

			$user = new user;
			$bool = $user->checkUserName($_POST['username']);
			
			echo $bool;
		}



	}
