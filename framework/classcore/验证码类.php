<?php 
	/*
		验证码 --
			数字中文运算 + 一堆点、线(干扰元素) (让机器读不出来,暴力破解)
	*/

	//$str = 'dasfsadfjjdf';		
	//echo $str{4};

	class vcode{
		private $image = null;
		private $code = '';
		private $config = array(
			'width' => 200,
			'height' => 60,
			'codeNum' => 4,
			'codeStr' => '23456789abcdefghigkmnpqABCK',
		);

		public function __construct($config=array()){
			$this->config = array_merge($this->config,$config);
			$this->buildCode();

			//strtoupper(string)
			$_SESSION['usercode'] = strtolower($this->code);
		}	


		/*绘制验证码*/
		private function makeImg(){

			/*创建个画布*/
			$this->image = imagecreatetruecolor($this->config['width'],$this->config['height']);

			$bgColor = imagecolorallocate($this->image, mt_rand(125,255), mt_rand(125,255), mt_rand(125,255));
			imagefill($this->image, 0, 0, $bgColor);


			for($i=0;$i<300;$i++){

				$color = imagecolorallocate($this->image, mt_rand(0,255), mt_rand(0,255),mt_rand(0,255));

				imagesetpixel($this->image, mt_rand(0,$this->config['width']), mt_rand(0,$this->config['height']), $color);				
			}

			for ($i=0; $i <5; $i++) { 

				$color = imagecolorallocate($this->image, mt_rand(0,255), mt_rand(0,255),mt_rand(0,255));

				imageline($this->image, mt_rand(0,$this->config['width']), mt_rand(0,$this->config['height']), mt_rand(0,$this->config['width']), mt_rand(0,$this->config['height']), $color);


				$cx = mt_rand(0,$this->config['width']);
				$cy = mt_rand(0,$this->config['height']);
				$width = mt_rand(10,$this->config['width']);
				$height = mt_rand(10,$this->config['height']);
				$start = mt_rand(0,90);
				$end = mt_rand(0,90);
				imagearc($this->image, $cx, $cy, $width, $height, $start, $end, $color);

			}


			/*绘制*/	
			$fontW = $this->config['width']/$this->config['codeNum'];
		 	for( $i=0;$i<$this->config['codeNum'];$i++ ){

		 		$color = imagecolorallocate($this->image, mt_rand(0,125), mt_rand(0,125), mt_rand(0,125));

		 		imagettftext($this->image, 30, mt_rand(-20,20), $i*$fontW+10, 40, $color, './1.ttf', $this->code{$i});
		 	}	

		}


		/*生成验证码*/
		private function buildCode(){

			$strNum = strlen($this->config['codeStr']);
			for($i=0;$i<$this->config['codeNum'];$i++){
				$index = mt_rand(0,$strNum-1);
				$this->code .= $this->config['codeStr']{$index};
			}

		}

		/*输出验证码*/
		public function output(){

			$this->makeImg();

			header('Content-type:image/png');
			imagepng($this->image);

			imagedestroy($this->image);
		}

	}		

	session_start();
	$vcode = new vcode();
	$vcode->output();