<?php 

	header('Content-type:text/html;charset=utf-8;');
 
	 
	 $arr = [12,3,21,2,43];


	/*快速排序*/ 

/*	function quick_sort($arr) {
    //先判断是否需要继续进行
    $length = count($arr);
    if($length <= 1) {
        return $arr;
    }
    //如果没有返回，说明数组内的元素个数 多余1个，需要排序
    //选择一个标尺
    //选择第一个元素
    $base_num = $arr[0];
    //遍历 除了标尺外的所有元素，按照大小关系放入两个数组内
    //初始化两个数组
    $left_array = array();//小于标尺的
    $right_array = array();//大于标尺的
    for($i=1; $i<$length; $i++) {
        if($base_num > $arr[$i]) {
            //放入左边数组
            $left_array[] = $arr[$i];
        } else {
            //放入右边
            $right_array[] = $arr[$i];
        }
    }
    //再分别对 左边 和 右边的数组进行相同的排序处理方式
    //递归调用这个函数,并记录结果
    $left_array = quick_sort($left_array);
    $right_array = quick_sort($right_array);
    return array_merge($left_array, array($base_num), $right_array);
}
*/



	function quick_sort($arr){

		$length = count($arr);

		if( $length<=1 ){
			return $arr;
		}

		$base_num = $arr[0];

		$left_array = array();
		$right_array = array();

		for($i=1;$i<$length;$i++){
			if( $base_num>$arr[$i] ){
				$left_array[] = $arr[$i];
			}else{
				$right_array[] = $arr[$i];
			}
		}
		

 	 	$left_array = quick_sort($left_array);
     	$right_array = quick_sort($right_array);

   		return array_merge($left_array, array($base_num), $right_array);

	}

	$arr = quick_sort($arr);

 	var_dump($arr);



	/*插入排序*/

	/*$num = count($arr);

	for( $i=0;$i<$num;$i++ ){

		for($j=$i+1;$j<$num;$j++){
			if($arr[$i]>$arr[$j]){
				$temp = $arr[$i];
				$arr[$i] = $arr[$j];
				$arr[$j] = $temp;
 			}
		}

	}

	var_dump($arr);*/


	/*选择排序*/
/*	$num = count($arr);
	for($i=0;$i<$num;$i++){
		
		$p = $i;

		for($j=$i+1;$j<$num;$j++){

			if($arr[$p]>$arr[$j]){
				$p = $j;
			}

		}

		if( $p!=$i ){
			$temp = $arr[$p];
			$arr[$p] = $arr[$i];
			$arr[$i] = $temp;
		}

	}

	var_dump($arr);
*/
/*
	 $arrNum = count($arr);
	 for($i=0;$i<$arrNum;$i++){

	 	for($j=0;$j<$arrNum-$i-1;$j++){

	 		if($arr[$j]>$arr[$j+1]){
	 			$temp = $arr[$j+1];
	 			$arr[$j+1] = $arr[$j];
	 			$arr[$j] = $temp;
	 			$flag = true; 
	 		}

	 	}

	 	//如果没交换,终止交换
	 	if(!$flag) break;

	 }

	 var_dump($arr);*/