<?php 
  	
	namespace framework\classcore;

	class smarty{
		
		private $tplVar = array();
		public $leftTag = '{';
		public $rightTag = '}';
		private $cacheflag = false;
		private $config = array(
			'tplDir' => VIEW,
			'completeDir' => COMPLETE,
			'cache' => CACHE
		);

		public function __construct($config=array()){
			$this->config = array_merge($this->config,$config);

			$this->config['tplDir'] = rtrim($this->config['tplDir'],'/').'/';
			$this->config['completeDir'] = rtrim($this->config['completeDir'],'/').'/';
		}


		/*给前端分配值*/
		public function assign($name,$value){
			$this->tplVar[$name] = $value;
		}


		/*进行代码编译*/
		private function complete(){

			/*模板文件*/
			$tplFile = $this->config['tplDir'].$this->viewname;
			/*编译后的文件*/
	 		$completeFile = $this->config['completeDir'].$this->viewname;	
 

			if( !file_exists($completeFile) || filemtime($tplFile) > filemtime($completeFile) ){
				
				$content = file_get_contents($tplFile);

				$left = preg_quote($this->leftTag);
				$right = preg_quote($this->rightTag);

				$var = '([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)';

				$reg = array(
					'/'.$left.'\s*\$'.$var.'\s*'.$right.'/', //匹配变量输出
					'/'.$left.'\s*for\s+start=(\d+)\s+end=(\d+)\s*'.$right.'/',
					'/'.$left.'\/\S+/',
					'/'.$left.'\s*foreach\s+\$'.$var.'\s+as\s+\$'.$var.'=>\$'.$var.'\s*'.$right.'/',
	                '/'.$left.'\s*if\s+\$'.$var.'\s*(>|<|==|>=|<=|!=)\s*\$'.$var.'\s*'.$right.'/',
					'/'.$left.'\s*if\s+\$'.$var.'\s*(>|<|==|>=|<=|!=)\s*(\S+)\s*'.$right.'/',

					/*数组下标访问*/
					'/'.$left.'\s*\$'.$var.'\[(\S+)\]'.$right.'/',
				);

				$replace = array(
					'<?php echo $this->tplVar["${1}"];?>',
					'<?php for($i=${1};$i<=${2};$i++){ ?>',
					'<?php } ?>',
					'<?php foreach($this->tplVar["${1}"] as $this->tplVar["${2}"]=>$this->tplVar["${3}"]){ ?>',
					'<?php if($this->tplVar["${1}"] ${2} $this->tplVar["${3}"] ){ ?>',
					'<?php if($this->tplVar["${1}"] ${2} ${3} ){ ?>',
					'<?php echo $this->tplVar["${1}"][${2}]; ?>'

				);	

				$completeHtml = preg_replace($reg, $replace, $content);
				file_put_contents($completeFile,$completeHtml);
			}

			return $completeFile;

		}	


		public function cache($time){
			$this->cachetime = $time;  //缓存的时间 s
			$this->cacheflag = true;

			return $this;
		}

	 

		/*模版的渲染*/
		public function display($viewname=null){

			if( empty($viewname) ){ 
				$viewname =  basename($_SERVER['REQUEST_URI']);
				$arr = explode('.',$viewname);
				$viewname = $arr[0].'.html';
			 }
			 /*当前的模板*/
			 $this->viewname = $viewname;

			 if( $this->cacheflag ){

			 	$cachefile = $this->config['cache'].'/'. $this->viewname;

			 	if( !is_file($cachefile) || time()-filemtime($cachefile) > $this->cachetime ){

				 	ob_start();
				 	require $this->complete();

				 	$content = ob_get_clean();
				 	file_put_contents($cachefile, $content);
			 	}

			 	require $cachefile;


			 }else
				require $this->complete();
		}

	}

