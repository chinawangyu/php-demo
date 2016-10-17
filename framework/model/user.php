<?php 

	namespace framework\model;
	use \framework\classcore\check;

	class user{

		/*检测用户是否登陆成功*/
		public function checkLogin($data){
			$condition = 'username="'.$data['username'].'" and password="'.md5($data['password']).'"';
			$res = \M('user')->where($condition)->select();

			if($res){
				$_SESSION['uid'] = $res[0]['id'];
				$_SESSION['islogin'] = 1;
				$_SESSION['username'] = $_POST['username'];
				
				return true;
			}else{
				return false;
			}

		}



		public function getInfo(){
 
			if(! $data = S('student_data') ){
				$data = \M('student')->limit(13)->select();
				S('student_data',$data,10);
			}

			return $data;
		}

 		
		/*添加用户*/
		public function addUser($data){

			 
			if( check::noSpace($data['username']) && check::noSpace($data['password']) && check::phone($data['phone']) && !$this->checkUserName($data['username']) ){

				$data['password'] = md5($data['password']);
				$res = \M('user')->add($data);
			}else{
				$res = false;
			}	

			return $res;
		}



		public function checkUserName($username){
			$data = \M('user')->where('username= "'.$username.'"')->select();
			return (bool)$data;
		}


	}