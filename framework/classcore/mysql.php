<?php 

	namespace framework\classcore;
 

	class mysql{
		
		private static $res;
		private static $mysqli;
		private static $tableName;
		private $lastSql;

		private function __construct(){

			/*数据库连接代码*/
			self::$mysqli = mysqli_connect('localhost','root','','test') or exit('数据库连接失败');
			mysqli_query(self::$mysqli,'SET NAMES UTF8');

		}

		public static function link($tableName){
			
			if( empty(self::$res) ){
				self::$res = new self;	
			}

			self::$tableName = $tableName;
			return self::$res;

		}


		public function select(){


			$condition = $this->condition();


			$sql = ' select '.$this->field.' from '.self::$tableName.$condition;
			$this->lastSql = $sql;
			
			$res = mysqli_query(self::$mysqli,$sql);
			$data = mysqli_fetch_all($res,MYSQL_ASSOC);
			return $data;			 
		}


		public function update($data){

			$str = '';
			foreach( $data as $key=>$value ){
				$str .= $key.'="'.$value.'",';
			}
			$str = rtrim($str,',');


			$condition = $this->condition();
  			

			/* 条件, set数据 */
			$sql = 'update '.self::$tableName.' set '.$str.$condition;
			$this->lastSql = $sql;

 			$res = mysqli_query(self::$mysqli,$sql);

 			if($res){
 				return '更新数据成功';
 			}else{
 				return '更新数据失败';
 			}

		}
 	
		public function add($data){
 
 		 	$keys = implode(',',array_keys($data));

 		 	$values = '"'.implode('","',array_values($data)).'"';
 		  	
 		  	$this->lastSql = $sql = 'insert into '.self::$tableName.'('.$keys.')values('.$values.')';


 			$res = mysqli_query(self::$mysqli,$sql);

 			if( mysqli_affected_rows(self::$mysqli) > 0 ){
 				return true;
 			}else
 				return false;

		}

		public function delete(){


			$this->lastSql = $sql = 'delete from '.self::$tableName.$condition = $this->condition();

			$res = mysqli_query(self::$mysqli,$sql);

 			if( mysqli_affected_rows(self::$mysqli) > 0 ){
 				return true;
 			}else
 				return false;
		}


		/*相应字段*/
		public function field($field){

			$this->field = $field;
			return  $this;
		}


		/*条件查询*/
		public function where($condition){
			$this->where = $condition;
			return $this;
		}


		/*limit*/
		public function limit($line){
			$this->limit = $line;
			return $this;
		}


		/*排序*/
		public function order($order){
			$this->order = $order;
			return $this;
		}



		/*生成条件*/
		private function condition(){

			if( empty($this->field) ){ 
				$this->field = '*';
			}

			$condition = '';


			if( !empty($this->where) ){
				$condition .= ' where '.$this->where;
			}	
			
			if( !empty($this->order) ){
				$condition .= ' order by '.$this->order;
			}

			if( !empty($this->limit) ){
				$condition .= ' limit '.$this->limit;
			}

			return $condition;

		}


		// 计算数据的条数
		public function count(){

			$condition = $this->condition();

			$sql = 'select count(*) as a from '.self::$tableName.$condition;

			$res = mysqli_query(self::$mysqli,$sql);
			$data = mysqli_fetch_assoc($res);
			return $data['a'];

		}

		public function getLastSql(){
			return $this->lastSql.'<br/>';	
		}

	}

