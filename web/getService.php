<?php
  include_once 'config/connection.php';

  if($_POST["cat_id"]){

    $data = [$_POST['cat_id']];

    $sql = "SELECT * FROM ex_service WHERE cat_id = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute($data);
    $result = $stmt->fetchAll();
    
      echo "<option value=''>--- กรุณาเลือก บริการ ---</option>";
    if($result){
      foreach($result as $serv) {
        echo "<option value='{$serv['service_id']}'>{$serv['service_name']}</option>";
      }
    } else {
      echo "<option value=''>--- ไม่มีบริการ ---</option>";
    }
  }
?>