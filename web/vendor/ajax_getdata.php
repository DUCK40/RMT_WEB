
	<?php
		header("Content-type:text/html; charset=UTF-8");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		//include'connect_db.php';
		//require_once("../connect2.php");






			$getdata = "SELECT @n := @n + 1 AS  runnumber, propertygroup_id, propertygroup_code, propertygroup_name, propertygroup_nameEN, propertygroup_remark, propertygroup_img FROM propertygroup_tbl , (SELECT @n :=0) AS r
			ORDER BY propertygroup_tbl.propertygroup_id  DESC";

			$getdata_query=$conn->query($getdata) ;
			while($datarow=mysqli_fetch_array($getdata_query, MYSQLI_ASSOC)){
				$dataoutput[]= $datarow;
			}
			// echo $getdata;
			print(json_encode($dataoutput));



		?>
