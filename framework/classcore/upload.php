<?php 

	
	namespace framework\classcore;

	class upload {
		private $dir;
		private $files;
		private $error = '';
		private $filenames = array();
		private $config = array(
			'maxSize' => 10240000,
			'rootPath' => './Uploads',
			'savePath' => '',
			'allowType' => array('jpg','png','jpeg','gif')
		);


		public function __construct($config=array()){

			$this->config = array_merge($this->config,$config);
 			
			$this->dir = rtrim($this->config['rootPath'],'/\\').'/'.rtrim($this->config['savePath'],'/\\').'/';	


			$this->files = $this->getFiles();

 		}

		public function upload(){
				

			foreach($this->files as $value){
				
				$this->fileSize = $value['size'];
				$this->fileType = $value['type'];
				$this->fileTmpName = $value['tmp_name'];
				$this->fileName = $value['name'];

				if( !$this->upload_exe() ){
					return false;
				}

			}

			return true;
		}


		private function upload_exe(){


			if( !$this->check() ){
				return false;
			}
 	
			// is_uploaded_file
			$bool = move_uploaded_file($this->fileTmpName,$this->dir.$this->fileName);

			if($bool){

				$this->filenames[] = $this->dir.$this->fileName;
				return true;
			}else{
				$this->error = '移动上传文件失败';
				return false;
			}	

		}

		/*获取上传的文件名*/
		public function getfilenames(){
			return $this->filenames;
		}


		private function check(){

			if(empty($this->files)){
				$this->error =  '上传文件为空';
				return false;
			}


			 /*检测文件大小*/
			if( !$this->checkSize() ){
				return false;
			} 

			/*检测文件类型*/
			if( !$this->checkType() ){
				return false;
			}


			/*检测上传目录是否存在*/
			if( !$this->checkDir() ){
				return false;
			}

			if( !$this->checkName() ){
				return false;
			}

			return true;
		}



		private function checkSize(){

			if( $this->fileSize > $this->config['maxSize'] ){
				$this->error = '文件超出规定大小';
				return false;
			}

			return true;

		}



		private function checkType(){

			$ext = pathinfo($this->fileName,PATHINFO_EXTENSION);

			if( !in_array($ext,$this->config['allowType']) ){
				$this->error = '上传文件类型不合法';
				return false;
			} 

			return true;
		}



		private function checkDir(){

			 if( !file_exists($this->dir) ){

			 	if (!mkdir($this->dir,777,true)){
			 		$this->error = '创建'.$this->dir.'失败';
			 		return false;
			 	}
			 }

			 return true;

		}	


		private function checkName(){

			if( file_exists($this->dir.$this->fileName) ){
				$this->error = '文件重名';
				return false;
			}

			return true;
		}		


		public function getError(){
			return $this->error;
		}

	 	private function getFiles(){

	 		$data = array();

		    foreach($_FILES as $k => $value){

		    	if( is_array($value['tmp_name']) ){

			   		$num = count($value['tmp_name']);				   	 
			   		for($i=0;$i<$num;$i++){
						foreach($value as $key => $v){
							$data[$k.$i][$key] = $v[$i];
						}
					}
				}else{
					$data = $_FILES;
				}
		   }
		 	
		   return $data;
	 	}


	}