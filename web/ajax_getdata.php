<?php
		header("Content-type:text/html; charset=UTF-8");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		//include'connect_db.php';
		//require_once("../connect2.php");
    include_once 'config/connection.php';
    include_once 'config/function.php';

    $result = getOrderRepair();
    foreach($result as $key => $row):
      $dataoutput[]= $row;
    endforeach;
    unset($req);



  //
	// 		$getdata = "SELECT order_id,cus.cus_name,order_lati,order_longti,order_status
  //         FROM `order` as ora
  //   		  ,customer as cus
  //
  // WHERE ora.order_cusid = cus.cus_id";
  //
	// 		$getdata_query=$dbcon->query($getdata) ;
	// 		while($datarow=mysqli_fetch_array($getdata_query, MYSQLI_ASSOC)){
	// 			$dataoutput[]= $datarow;
	// 		}
			// echo $getdata;
			print(json_encode($dataoutput));



		?>
