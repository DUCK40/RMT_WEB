<?php

  function getCompany(){
    global $dbcon;
    $sql = "SELECT company_name FROM ex_system";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch();
    $get = $row['company_name'];
    return $get;
  }

  function getIP(){
    $get = $_SERVER['REMOTE_ADDR'];
    return $get;
  }

  function getHost(){
    $ip   = $_SERVER['REMOTE_ADDR'];
    $get  = gethostbyaddr($ip);
    return $get;
  }

  function getMonth(){
    $data = [
      '1' => 'มกราคม','2' => 'กุมภาพันธ์','3' => 'มีนาคม',
      '4' => 'เมษายน','5' => 'พฤษภาคม','6' => 'มิถุนายน',
      '7' => 'กรกฎาคม','8' => 'สิงหาคม','9' => 'กันยายน',
      '10' => 'ตุลาคม','11' => 'พฤศจิกายน','12' => 'ธันวาคม'
    ];
    return $data;
  }

  function getYear(){
    $data = range(date('Y')+1,2018);
    return $data;
  }

  function getCountTodate(){
    global $dbcon;
    $todate = date('Y-m-d');
    $data = [$todate];
    $sql = "SELECT COUNT(req_id) AS countTodate FROM ex_request
      WHERE DATE(req_create) = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute($data);
    $row = $stmt->fetch();
    $get = $row['countTodate'];
    return $get;
  }

  function getCountMonth(){
    global $dbcon;
    $year = date('Y');
    $month = date('m');
    $data = [$year,$month];
    $sql = "SELECT COUNT(req_id) AS countMonth FROM ex_request
      WHERE YEAR(req_create) = ? AND MONTH(req_create) = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute($data);
    $row = $stmt->fetch();
    $get = $row['countMonth'];
    return $get;
  }

  function getCountYear(){
    global $dbcon;
    $year = date('Y');
    $data = [$year];
    $sql = "SELECT COUNT(req_id) AS countYear FROM ex_request
      WHERE YEAR(req_create) = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute($data);
    $row = $stmt->fetch();
    $get = $row['countYear'];
    return $get;
  }

  function getCountAll(){
    global $dbcon;
    $sql = "SELECT COUNT(req_id) AS countAll FROM ex_request";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch();
    $get = $row['countAll'];
    return $get;
  }

  function getCountUser(){
    global $dbcon;
    $sql = "SELECT COUNT(user_id) AS countAll FROM ex_user";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch();
    $get = $row['countAll'];
    return $get;
  }

  function getCountComputer(){
    global $dbcon;
    $sql = "SELECT COUNT(hw_id) AS countAll FROM ex_hardware";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch();
    $get = $row['countAll'];
    return $get;
  }

  // function getCountCategory(){
  //   global $dbcon;
  //   $sql = "SELECT COUNT(cat_id) AS countAll FROM ex_category";
  //   $stmt = $dbcon->prepare($sql);
  //   $stmt->execute();
  //   $row = $stmt->fetch();
  //   $get = $row['countAll'];
  //   return $get;
  // }

  function getCountService(){
    global $dbcon;
    $sql = "SELECT COUNT(service_id) AS countAll FROM ex_service";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch();
    $get = $row['countAll'];
    return $get;
  }

  function getMonthChart($month){
    global $dbcon;
    $year = date('Y');
    $data = [$year,$month];
    $sql = "SELECT COUNT(req_id) AS countMonth FROM ex_request
      WHERE YEAR(req_create) = ?
      AND MONTH(req_create) = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute($data);
    $row = $stmt->fetch();
    $get = $row['countMonth'];
    return $get;
  }

  function getDepartmentChart($dep){
    global $dbcon;
    $year = date('Y');
    $data = [$year,$dep];
    $sql = "SELECT COUNT(req_id) AS countDep
      FROM ex_request req
      LEFT JOIN ex_user user
      ON req.req_user = user.user_code
      WHERE YEAR(req_create) = ?
      AND dep_id = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute($data);
    $row = $stmt->fetch();
    $get = $row['countDep'];
    return $get;
  }

  function getYearChart($year){
    global $dbcon;
    $data = [$year];
    $sql = "SELECT COUNT(req_id) AS countYear FROM ex_request
      WHERE YEAR(req_create) = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute($data);
    $row = $stmt->fetch();
    $get = $row['countYear'];
    return $get;
  }

  function getUserPicture($code){
    global $dbcon;
    $data = [$code];
    $sql = "SELECT user_picture FROM ex_user WHERE user_code = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute($data);
    $row = $stmt->fetch();
    $get = $row['user_picture'];
    return $get;
  }

  function getUserNickname($code){
    global $dbcon;
    $data = [$code];
    $sql = "SELECT user_nickname FROM ex_user WHERE user_code = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute($data);
    $row = $stmt->fetch();
    $get = $row['user_nickname'];
    return $get;
  }

  function getUserEmail($code){
    global $dbcon;
    $data = [$code];
    $sql = "SELECT user_email FROM ex_user WHERE user_code = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute($data);
    $row = $stmt->fetch();
    $get = $row['user_email'];
    return $get;
  }

  // function getDepartment($code){
  //   global $dbcon;
  //   $data = [$code];
  //   $sql = "SELECT user_email FROM ex_user WHERE user_code = ?";
  //   $stmt = $dbcon->prepare($sql);
  //   $stmt->execute($data);
  //   $row = $stmt->fetch();
  //   $get = $row['user_email'];
  //   return $get;
  // }

  function getUserLevel($code){
    global $dbcon;
    $data = [$code];
    $sql = "SELECT user_level FROM ex_user WHERE user_code = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute($data);
    $row = $stmt->fetch();
    $get = $row['user_level'];
    return $get;
  }

  function getUserLevelName($code){
    switch ($code) {
      case '99':
        echo 'ผู้ดูแลระบบ';
        break;
      case '69':
        echo 'ผู้จัดการสาขา';
        break;
      //
      // default:
      //   echo 'ผู้ใช้ระบบ';
      //   break;
    }
  }

  function getCodeFormEmail($email){
    global $dbcon;
    $data = [$email];
    $sql = "SELECT user_code FROM ex_user WHERE user_email = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute($data);
    $row = $stmt->fetch();
    $get = $row['user_code'];
    return $get;
  }

  function getUsernameFormCode($code){
    global $dbcon;
    $data = [$code];
    $sql = "SELECT user_username FROM ex_login WHERE user_code = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute($data);
    $row = $stmt->fetch();
    $get = $row['user_username'];
    return $get;
  }

  function alertMsg($alert,$msg,$return){
    $_SESSION['alert']  = $alert;
    $_SESSION['msg']    = $msg;
    header("location: {$return}");
    die();
  }

  function getDepartment(){
    global $dbcon;
    $sql = "SELECT * FROM ex_department";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute();
    return $stmt;
  }

  function getQueryDepartment($id){
    global $dbcon;
    $data = [$id];
    $sql = "SELECT * FROM ex_department WHERE dep_id = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  function getDepartmentName($id){
    global $dbcon;
    $data = [$id];
    $sql = "SELECT dep_name FROM ex_department WHERE dep_id = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute($data);
    $row = $stmt->fetch();
    $get = $row['dep_name'];
    return $get;
  }

  function getCategory(){
    global $dbcon;
    $sql = "SELECT * FROM ex_category";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute();
    return $stmt;
  }

  function getCategoryName($id){
    global $dbcon;
    $data = [$id];
    $sql = "SELECT cat_name FROM ex_category WHERE cat_id = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute($data);
    $row = $stmt->fetch();
    $get = $row['cat_name'];
    return $get;
  }

  function getQueryCategory($id){
    global $dbcon;
    $data = [$id];
    $sql = "SELECT * FROM ex_category WHERE cat_id = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  function getService(){
    global $dbcon;
    $sql = "SELECT * FROM ex_service";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute();
    return $stmt;
  }

  function getQueryService($id){
    global $dbcon;
    $data = [$id];
    $sql = "SELECT * FROM ex_service WHERE service_id = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  function getFilterService($cat){
    global $dbcon;
    $filter_cat = ($cat ? '= '.$cat : 'IS NOT NULL');
    $sql = "SELECT *
      FROM ex_service
      WHERE cat_id $filter_cat
      ORDER BY cat_id ASC,service_id ASC";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute();
    return $stmt;
  }

  function getServiceName($serv_id){
    global $dbcon;
    $data = [$serv_id];
    $sql = "SELECT service_name FROM ex_service WHERE service_id = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute($data);
    $row = $stmt->fetch();
    $get = $row['service_name'];
    return $get;
  }

  function getUser(){
    global $dbcon;
    $sql = "SELECT * FROM ex_user WHERE user_status = 1";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute();
    return $stmt;
  }

//ทดสอบ
function getB(){
  global $dbcon;
  $sql = "SELECT dep_id,dep_name FROM `ex_department`";
  $stmt = $dbcon->prepare($sql);
  $stmt->execute();
  return $stmt;
}


//ทดสอบ
function getRubber(){
  global $dbcon;
  $sql = "SELECT sw_id,sw_name FROM `ex_software`";
  $stmt = $dbcon->prepare($sql);
  $stmt->execute();
  return $stmt;
}






//ทดสอบ
function getC(){
  global $dbcon;
  $sql = "SELECT user_id,user_name FROM `ex_user` where user_level = 1";
  $stmt = $dbcon->prepare($sql);
  $stmt->execute();
  return $stmt;
}

  function getFilterUser($dep){
    global $dbcon;
    $filter_dep = ($dep ? '= '.$dep : 'IS NOT NULL');
    $sql = "SELECT *
      FROM ex_user user
      LEFT JOIN ex_login login
      ON user.user_code = login.user_code
      WHERE dep_id $filter_dep
      ORDER BY user_status DESC,user_level DESC,user_id ASC";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute();
    return $stmt;
  }

  function getQueryUser($id){
    global $dbcon;
    $data = [$id];
    $sql = "SELECT *
      FROM ex_user user
      INNER JOIN ex_login login
      ON user.user_code = login.user_code
      WHERE user.user_code = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  function getUserFullname($code){
    global $dbcon;
    $data = [$code];
    $sql = "SELECT user_name,user_surname FROM ex_user WHERE user_code = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute($data);
    $row = $stmt->fetch();
    $get = ucfirst($row['user_name']).' '.ucfirst($row['user_surname']);
    return $get;
  }

  function getFilterLog($status){
    global $dbcon;
    $filter_status = ($status ? '= '.$status : 'IS NOT NULL');
    $sql = "SELECT *
      FROM ex_log
      WHERE log_status $filter_status
      ORDER BY log_id DESC";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute();
    return $stmt;
  }

  function getSoftware(){
    global $dbcon;
    $sql1 ="SELECT depart.dep_name ,sw.sw_name
			,SUM(sfwd.part_d_sec_use) AS qty
FROM ex_user AS users
		,ex_software_datail AS sfwd
		,ex_department AS depart
        ,ex_software as sw
WHERE users.dep_id=depart.dep_id
			AND sfwd.part_d_userid=users.user_id AND sw.sw_id=sfwd.part_id
GROUP BY depart.dep_id";


    $sql = "SELECT * FROM ex_software ORDER BY sw_id ASC";
    $stmt = $dbcon->prepare($sql1);
    $stmt->execute();
    return $stmt;
  }

 /* function getSoftware1(){
    global $dbcon;
    $sql1 ="SELECT depart.dep_name ,sw.sw_name
			,SUM(sfwd.part_d_sec_use) AS qty
FROM ex_user AS users
		,ex_software_datail AS sfwd
		,ex_department AS depart
        ,ex_software as sw
WHERE users.dep_id=depart.dep_id
			AND sfwd.part_d_userid=users.user_id AND sw.sw_id=sfwd.part_id
GROUP BY depart.dep_id";


    $sql = "SELECT * FROM ex_software ORDER BY sw_id ASC";
    $stmt = $dbcon->prepare($sql1);
    $stmt->execute();
    return $stmt;
  }*/


  function getSoftware1(){
    global $dbcon;


    $sql = "SELECT * FROM ex_software ORDER BY sw_id ASC";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute();
    return $stmt;
  }

  function getInproduct(){
    global $dbcon;
    $depid = $_SESSION['dep_id'];

    $sql = "SELECT aw.sw_id,a.part_d_id,aw.sw_name,sum(a.part_d_sec_use)as part_d_sec_use,a.part_d_price,bb.dep_name,us.user_name,a.part_d_inproduct
FROM ex_software_datail as a
		,ex_software as aw
        ,ex_department as bb
        ,ex_user as us
WHERE a.part_id = aw.sw_id and a.part_d_userid=us.user_id and bb.dep_id = us.dep_id and a.part_d_depname ='".$depid."' 
GROUP by aw.sw_name
ORDER BY aw.sw_name  ASC";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute();
    return $stmt;
  }

  function getInproduct1(){
    global $dbcon;
    $depid = $_SESSION['dep_id'];

    $sql = "SELECT aw.sw_id,a.part_d_id,aw.sw_name,a.part_d_sec_use,a.part_d_price,bb.dep_name,us.user_name,a.part_d_inproduct
FROM ex_software_datail as a
		,ex_software as aw
        ,ex_department as bb
        ,ex_user as us
WHERE a.part_id = aw.sw_id and a.part_d_userid=us.user_id and bb.dep_id = us.dep_id 

ORDER BY aw.sw_name  ASC";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute();
    return $stmt;
  }


  function getTechnicain1(){
    global $dbcon;
    $depid = $_SESSION['dep_id'];
    $sql = "SELECT th.tn_id,th.tn_name,th.tn_lastname,th.tn_userid,th.tn_pass,th.tn_phone,de.dep_name FROM `ex_technician` as th, ex_department as de
    WHERE th.dep_id = de.dep_id and th.dep_id = '".$depid."' ";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute();
    return $stmt;
  }




  function getOrderRepair(){
    global $dbcon;

    session_start();
    $depid = $_SESSION['dep_id'];

    $sql = "SELECT @n := @n + 1 AS  runnumber,order_id,cus.ct_name,order_lati,order_longti,order_status
        FROM `order` as ora
  		  ,`ex_customer` as cus
        ,(SELECT @n :=0) AS r

  WHERE ora.order_cusid = cus.ct_id AND order_depart= '".$depid."' and order_status = '1'";
  
  // WHERE ora.order_cusid = cus.ct_id";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute();
    return $stmt;
  }


  //กำลังทำ
  function getOrderRepairDetail($id){
    global $dbcon;
    $data = [$id];

    $sql = "SELECT *
        FROM `order` as ora
  		  ,`ex_customer` as cus
        ,(SELECT @n :=0) AS r

WHERE ora.order_cusid = cus.ct_id AND order_id=?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  function getTechnicain($id){
    global $dbcon;
    $data = [$id];
    

    $sql = "SELECT sw_id,sw_name FROM `ex_software`";
    $sql1 = "SELECT tn_id, tn_name, tn_lastname, tn_userid, tn_pass, tn_phone, tn_status, tn.dep_id,br.dep_name
            FROM oktsxyz_duck.ex_technician as tn,oktsxyz_duck.ex_department as br
            WHERE  tn.dep_id = ?
            GROUP BY tn_id";

    $stmt = $dbcon->prepare($sql1);
    $stmt->execute($data);
    // return $stmt;
    // $row = $stmt->fetch();
    // $get = $row['tn_name'];

    return $stmt;
  }

  function getSoftwareName($id){
    global $dbcon;
    $data = [$id];
    $sql = "SELECT sw_name FROM ex_software WHERE sw_id = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute($data);
    $row = $stmt->fetch();
    $get = $row['sw_name'];
    return $get;
  }

  function getQuerySoftware($id){
    global $dbcon;
    $data = [$id];
    $sql = "SELECT * FROM ex_software WHERE sw_id = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  function getQuerySoftwareDetail($id){
    global $dbcon;
    $data = [$id];
    $sql = "SELECT * FROM ex_software_datail WHERE part_d_id = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }


  function getcustomer(){
    global $dbcon;
    $sql = "SELECT * FROM ex_customer";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute();
    return $stmt;
  }

  function getFilterComputer($dep){
    global $dbcon;
    $filter_dep = ($dep ? '= '.$dep : 'IS NOT NULL');
    $sql = "SELECT hw.*,user.dep_id
      FROM ex_hardware hw
      LEFT JOIN ex_user user
      ON hw.user_code = user.user_code
      WHERE dep_id $filter_dep
      ORDER BY hw_id ASC";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute();
    return $stmt;
  }

  function getQueryComputer($id){
    global $dbcon;
    $data = [$id];
    $sql = "SELECT * FROM ex_hardware WHERE hw_id = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  function getQueryComputerDetail($id){
    global $dbcon;
    $data = [$id];
    $sql = "SELECT * FROM ex_hardware_detail WHERE hw_id = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  function getSystem(){
    global $dbcon;
    $id = 1;
    $data = [$id];
    $sql = "SELECT * FROM ex_system WHERE system_id = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  function getPasswordDefault(){
    global $dbcon;
    $sql = "SELECT password_default FROM ex_system";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute($data);
    $row = $stmt->fetch();
    $get = $row['password_default'];
    return $get;
  }

  function getQueryRequest($req){
    global $dbcon;
    $data = [$req];
    $sql = "SELECT * FROM ex_request WHERE req_id = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  function getFilterRequest($year,$month,$cat,$serv,$stat,$user){
    global $dbcon;
    $filter_year = ($year ? '= '.$year : 'IS NOT NULL');
    $filter_month = ($month ? '= '.$month : 'IS NOT NULL');
    $filter_cat = ($cat ? '= '.$cat : 'IS NOT NULL');
    $filter_serv = ($serv ? '= '.$serv : 'IS NOT NULL');
    $filter_stat = ($stat ? '= '.$stat : 'IS NOT NULL');
    $filter_user = ($user ? '= '.$user : 'IS NOT NULL');
    $sql = "SELECT req.*,cat.cat_name
      FROM ex_request req
      LEFT JOIN ex_service serv
      ON req.service_id = serv.service_id
      LEFT JOIN ex_category cat
      ON serv.cat_id = cat.cat_id
      WHERE req_user $filter_user
      AND serv.cat_id $filter_cat
      AND req.service_id $filter_serv
      AND req_status $filter_stat
      AND MONTH(req_create) $filter_month
      AND YEAR(req_create) $filter_year
      ORDER BY req_status,req_id DESC";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute();
    return $stmt;
  }

  function getCategoryFromService($serv_id){
    global $dbcon;
    $data = [$serv_id];
    $sql = "SELECT cat_name
      FROM ex_category cat
      LEFT JOIN ex_service serv
      ON cat.cat_id = serv.cat_id
      WHERE service_id = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute($data);
    $row = $stmt->fetch();
    $get = $row['cat_name'];
    return $get;
  }

  function convertDate($value){
    $date = date('d', strtotime($value));
    $month = date('n', strtotime($value));
    $year = date('Y', strtotime($value));
    $year_th = $year + 543;
    $array_month_th = [
      '','มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน',
      'กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'
    ];
    $month_th = $array_month_th[$month];
    $get = $date.' '.$month_th.' '.$year_th;
    return $get;
  }

  function getStatus(){
    global $dbcon;
    $sql = "SELECT * FROM ex_status";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute();
    return $stmt;
  }

  function getStatusName($status){
    global $dbcon;
    $data = [$status];
    $sql = "SELECT * FROM ex_status WHERE status_id = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute($data);
    $row = $stmt->fetch();
    $get = $row['status_name'];
    return $get;
  }

  function getQueryStatus($req){
    global $dbcon;
    $data = [$req];
    $sql = "SELECT * FROM ex_status WHERE status_id = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  function getManageStatus(){
    global $dbcon;
    $sql = "SELECT * FROM ex_status WHERE status_id != 1";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  function getQueryManage($req){
    global $dbcon;
    $data = [$req];
    $sql = "SELECT * FROM ex_manage WHERE req_id = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  function colorStatus($code){
    switch ($code) {
      case '2':
        echo 'text-primary';
        break;
      case '3':
        echo 'table-light';
        break;
      case '4':
        echo 'text-success';
        break;
      case '5':
        echo 'text-danger';
        break;
      default:
        echo 'text-info';
        break;
    }
  }

  function getDateEnd($req){
    global $dbcon;
    $data = [$req];
    $sql = "SELECT manage_date_end FROM ex_manage
      WHERE req_id = ? ORDER BY manage_id DESC LIMIT 1";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute($data);
    $row = $stmt->fetch();
    $get = $row['manage_date_end'];
    return $get;
  }

  function lineNotify($text,$token) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://notify-api.line.me/api/notify");
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "message=$text");
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $headers = array("Content-type: application/x-www-form-urlencoded", "Authorization: Bearer $token", );
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
  }
?>
