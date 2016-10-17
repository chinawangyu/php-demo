<?php 
	
	namespace test;

	require 'mysql.php';
	require 'functions.php';
	


	class page{

		private $allNum;
		public $pageNum;
		public $firstRow;
		public $theme = "%FIRST% %PREV% %LIST% %NEXT% %LAST%";


		public function __construct($allNum,$pageNum){
			$this->allNum = $allNum;
			$this->pageNum = $pageNum;

			$this->nowpage = empty($_GET['page']) ? 1 : $_GET['page'];
			$this->firstRow = ($this->nowpage-1)*$this->pageNum;


			echo $this->nowpage;

			/* floor round ceil 总的页数 */
			$this->allPage = ceil($allNum / $pageNum);
		}


		/*生成页码*/
		public function pageList(){

			/*获取页码偏移数*/
			$offset = $this->pageFirstLast();
			

			$str = '';
			for($i=$offset['start'];$i<=$offset['last'];$i++){

				if( $i==$this->nowpage ){
					$style = " style='background:blue;color:white' ";
				}else{
					$style = '';
				}

				$str .= '<a class="page" '.$style.' href="?page='.$i.'">'.$i.'</a>';
			} 


			return $str;
		}

		/*首页*/
		public function firstPage(){

			$str = '<a class="page" href="?page=1">首页</a>';
			return $str;
		}

		/*尾页*/
		public function lastPage(){
			$str = '<a class="page" href="?page='.$this->allPage.'">尾页</a>';
			return $str;
		}


		/*上一页*/
		public function prevPage(){

			 if( $this->nowpage == 1 ){
			 	$jumppage = $this->nowpage;
			 }else{
			 	$jumppage = $this->nowpage - 1;
			 }



			$str = '<a class="page" href="?page='.$jumppage.'">上一页</a>';
			return $str;

		}


		/*下一页*/
		public function nextPage(){

			if( ($this->nowpage+1) > $this->allPage ){
				$jumppage = $this->allPage;
			}else{
				$jumppage = $this->nowpage+1;
			}

			$str = '<a class="page" href="?page='.$jumppage.'">下一页</a>';
			return $str;
		}


		private function pageFirstLast(){

			$startPage = $this->nowpage-3;

			if( $startPage<1 ) $startPage = 1;

			$lastPage = $startPage+6;
			if($lastPage > $this->allPage){
				$lastPage = $this->allPage;
				$startPage = $this->allPage-6;
			}	

			return array('start'=>$startPage,'last'=>$lastPage);
		}



		public function show(){
			
			$list = $this->pageList();
			$first = $this->firstPage();
			$last = $this->lastPage();
			$nextPage = $this->nextPage();
			$prevPage = $this->prevPage();


			$search = array('%FIRST%','%PREV%','%LIST%','%NEXT%','%LAST%');
			$replace = array($first,$prevPage,$list,$nextPage,$last);

			echo str_replace($search,$replace,$this->theme);

		}


	}



	/*查询总的条数*/	
	$allNum = M('student')->count();

	/*new page,传入总的条数和每页显示的条数*/
	$page = new page($allNum,2);


	//%FIRST% %PREV% %LIST% %NEXT% %LAST%

	//$page->theme = '%PREV% %LIST% %LAST%';

	// 数据查询
	$data = M('student')->limit("$page->firstRow,$page->pageNum")->select();
	/*var_dump($data);*/


?>


<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		.page{
			border:1px solid blue;
			padding:2px 8px;
			margin:10px;
			border-radius:6px;
			text-decoration:none;
			font-size:15px;
			color:#333;
		}
		#main{
			width:700px;
			margin:30px auto;
		}
		#main table{
			width:100%;
			text-align: center;
		}
	</style>
</head>
<body>

	<div id="main">
			<table border=1>
				<tr>
					<th>编号</th>
					<th>用户名</th>
					<th>年龄</th>
					<th>性别</th>
				</tr>

				<?php foreach($data as $value){ ?>
			
				<tr>
					<td><?php echo $value['id']; ?></td>
					<td><?php echo $value['name']; ?></td>
					<td><?php echo $value['age']; ?></td>
					<td><?php echo $value['sex']; ?></td>
				</tr>

				<?php } ?>

			</table>

			<div style="margin:40px auto;text-align: center;">
			<?php
				/*分页list输出*/
				$page->show();
			?>
			</div>
	</div>



</body>
</html>