<?php 
	
	header('Content-type:text/html;charset=utf-8');
	class calendar{

		private $year;
		private $month;

		public function __construct($year,$month){
			$this->year = $year;
			$this->month = $month;
			$this->day = date('d');
		}
 			
		private function getTitle(){

			$str = '<caption>';
			$str .= '<a href="?y='.$this->prevYear().'&m='.$this->month.'">上一年</a>';
			$str .= '<a href="rili.php?'.$this->prevMonth().'">上一月</a>';
			$str .= '<a>'.$this->year.'年</a>';
			$str .= '<a>'.$this->month.'月</a>';
			$str .= '<a href="rili.php?'.$this->nextMonth().'">下一月</a>';
			$str .= '<a href="?y='.$this->nextYear().'&m='.$this->month.'">下一年</a>';
			$str .= '</caption>';
			return $str;
		}


		/*下一个月*/
		private function nextMonth(){

			if ( $this->month+1 > 12 ){
				$m = 1;
				$y = $this->year+1;
			}else{
				$m =  $this->month+1;
				$y = $this->year;
			}

			return 'y='.$y.'&m='.$m;
		}


		/*上一个月*/
		private function prevMonth(){

			if( $this->month-1<1 ){
				$y = $this->year-1;
				$m = 12;
			}else{
				$y = $this->year;
				$m = $this->month-1;
			}
			return 'y='.$y.'&m='.$m;
		}

		/*下一年*/
		public function nextYear(){
			if( $this->year+1 > 2038 ){
				return $this->year;
			}

			return $this->year+1;
		}

		/*上一年*/
		public function prevYear(){

			if($this->year-1 < 1970){
				return $this->year;
			}
			return $this->year-1;

		}

		private function getWeek(){

			$week = array('星期日','星期一','星期二','星期三','星期四','星期五','星期六');

			$str = '<tr>';
			foreach($week as $v){
				$str .= '<td>'.$v.'</td>';
			}	
			$str .= '</tr>';
			return $str;
		}

		private function getDays(){
			$time = strtotime($this->year.'-'.$this->month.'-1');

			$days = date('t',$time);

			$str = '<tr>';
			/*前面空余的天数*/
			$weekNum = date('w',$time);


			for($k=0;$k<$weekNum;$k++){
				$str .= '<td></td>';
			}


			/*天数*/
			$k = 0;
			for($i=$weekNum+1;$i<=$days+$weekNum;$i++){
				$k++;

				if( $this->day == $k && date('Yn') ==$this->year.$this->month  ){
					$bgcolor = 'style="background:red;color:white;"';
				}else{
					$bgcolor = '';
				}
 


				$str .= '<td '.$bgcolor.'>'.$k.'</td>';

				if( $i%7 == 0 ){
					$str .='</tr><tr>';
				}

			}	

			return $str;

		}	


 		public function __toString(){

 			$str = '<table border=1>';
 			$str .= $this->getTitle();
 			$str .= $this->getWeek();
 			$str .= $this->getDays();
 			$str .= "</table>";
 			return $str;
 		}

	}

	$m = empty($_GET['m'])?date('m'):$_GET['m'];
	$y = empty($_GET['y'])?date('Y'):$_GET['y'];
	$cale = new calendar($y,$m);

	echo $cale;



	?>



	<style type="text/css">
		a{padding:5px;}
	</style>