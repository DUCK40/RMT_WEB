<?php
  ob_start();
  session_start();
  date_default_timezone_set("Asia/Bangkok");
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  include_once 'config/connection.php';
  include_once 'config/function.php';

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  $user_level = getUserLevel($_SESSION['user_code']);
  if(!isset($_SESSION['user_code']) || ($user_level == 1 || empty($user_level))){
    alertMsg('danger','ไม่พบหน้านี้ในระบบ','request.php');
  }

  $act = isset($_GET['act']) ? $_GET['act'] : 'index';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Document</title>
  <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="node_modules/@fortawesome/fontawesome-pro/css/all.min.css">
  <link rel="stylesheet" href="node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="node_modules/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="public/css/custom.css">
</head>
<body>
  <?php include_once 'inc/navbar.php' ?>

  <div class="container-fluid">
    <div class="row">
      <?php include_once 'inc/sidemenu.php' ?>

      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">

        <?php
          /*

          Index

          */
          if($act == 'index'):
            include_once 'inc/alert.php';
        ?>

        <nav>
          <ol class="breadcrumb bg-white border">
            <li class="breadcrumb-item">
              <a href="request.php"><i class="fas fa-home"></i></a>
            </li>
            <li class="breadcrumb-item active">
            รายการการแจ้งซ่อม
            </li>
          </ol>
        </nav>

        <div class="row justify-content-center">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h5 class="text-center">รายการการแจ้งซ่อม</h5>
              </div>



                <!-- Table -->
                <div class="row">
                  <div class="col-12">
                    <div class="table-responsive">
                      <table id="data2" name="data2" class="table table-bordered table-hover table-sm">
                        <thead>
                          <tr>
                            <th>ลำดับ</th>
                            <th>ชื่อผู้ใช้บริการ</th>
                            <th>Latijude</th>
                            <th>Longtijude</th>
                            <!-- <th>อำเภอ</th> -->
                            <th>สถานะ</th>

                            <th>จัดการ</th>



                          </tr>
                        </thead>

                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php
          endif;

          /*

          Add Item

          */

          if($act == 'edit'):
            include_once 'inc/alert.php';
            $sw_id = @$_GET['id'];

            $user_code = $_SESSION['user_code'];
            $stmt = getQueryUser($user_code);
            $row2 = $stmt->fetch();
              $a=$row2['dep_id'] ;


            $stmt = getOrderRepairDetail($sw_id);
            $row = $stmt->fetch();


        ?>
        <nav>
          <ol class="breadcrumb bg-white border">
            <li class="breadcrumb-item">
              <a href="request.php"><i class="fas fa-home"></i></a>
            </li>
            <li class="breadcrumb-item active">
              ขอใช้บริการ
            </li>
          </ol>
        </nav>

        <div class="row justify-content-center">

          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h5 class="text-center">ขอใช้บริการ</h5>
              </div>
              <div class="card-body">
                <form action="?act=insert" method="POST" enctype="multipart/form-data">
                  <div class="form-group row" style="/*display: none*/">
                    <label class="col-sm-4 col-form-label text-md-right">รหัสใบแจ้งซ่อม</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="req_user" readonly
                        value="<?php echo $row['order_id'] ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">ผู้ใช้บริการ</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" readonly
                        value="<?php echo $row['ct_name'] . ' ' .$row['ct_lastname']?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">ยางหน้า</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" readonly
                        value="<?php echo $row['order_rubberfont'] ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">ยางหลัง</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" readonly
                        value="<?php echo $row['order_rubberback'] ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">ละติจูด</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" readonly
                        value="<?php echo $row['order_lati'] ?>">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">ลองจิจูด</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" readonly
                        value="<?php echo $row['order_longti'] ?>">

                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">ช่างผู้ให้บริการ</label>
                    <div class="col-sm-4">
                      <select class="form-control form-control-sm" name="cat_id"
                        onChange="getServiceList(this.value);" required>
                        <option value="">--- เลือก หมวดหมู่  ---</option>

                        <?php

                        //อย่าลืม
                        $dep_id = $_SESSION['dep_id'];

                        $stmt = getTechnicain($dep_id);
                        $row1 = $stmt->fetchAll();
                        // $row1 = $stmt->fetch();


                        foreach($row1 as $user):
                          $id1 = ucfirst($user['tn_id']);

                          $name = ucfirst($user['tn_name']);
                          echo "<option value='{$user['tn_id']}'>{$id1}{$name}</option>";
                        endforeach;


                        // $stmt =getTechnicain(3);
                        // $row1 = $stmt->fetch();
                        //
                        //   foreach($row1 as $user):
                        //   //  $name = ucfirst($user['tn_name']);
                        //     echo "<option value=''>$user</option>";
                        //   endforeach;

                        ?>

                      </select>


                    </div>
                   </div>

                  </div>




                  <div class="form-group row justify-content-center">
                    <div class="col-sm-3 pb-2">
                      <button class="btn btn-success btn-sm btn-block" name="btnInsert">
                        <i class="fa fa-check pr-2"></i>ยืนยัน
                      </button>
                    </div>
                    <div class="col-sm-3 pb-2">
                      <a class="btn btn-danger btn-sm btn-block" href="manage1.php">
                        <i class="fa fa-arrow-left pr-2"></i>กลับหน้าหลัก
                      </a>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        <?php
          endif;

          /*

          Insert Item

          */
          if($act == 'insert'):
            if(!isset($_POST['btnInsert'])){
              header('Location: index.php');
              die();
            }

            // $req_user = $_POST['req_user'];
            // $service_id = $_POST['service_id'];
            // $service_name = getServiceName($service_id);
            // $req_file = $_FILES['req_file']['name'];
            // $req_text = $_POST['req_text'];
            // $req_create = date('Y-m-d H:i:s');
            // $req_year = date('Y');
            //
            // $data_check_last = [$req_year];
            // $sql = "SELECT req_last FROM ex_request
            // WHERE req_year = ?
            // ORDER BY req_last DESC
            // LIMIT 1";
            // $stmt = $dbcon->prepare($sql);
            // $stmt->execute($data_check_last);
            // $check_gen = $stmt->fetch();
            //
            // $req_last = STR_PAD(($check_gen['req_last']+1), 5, "0", STR_PAD_LEFT);
            // $req_gen  = $req_year.$req_last;
            //
            // $data = [$req_year,$req_last,$req_gen,$req_user,$service_id,$req_text,$req_create];

            // Check Service
            // if(empty($service_id)){
            //   alertMsg('danger','กรุณาเลือกบริการด้วยครับ','?act=add');
            // }

            // Check Extension
            // if($req_file){
            //   $file_name  = $_FILES['req_file']['name'];
            //   $file_tmpname  = $_FILES['req_file']['tmp_name'];
            //   $ext = pathinfo($file_name, PATHINFO_EXTENSION);
            //   $file_new_name = $req_gen.'.'.$ext;
            //   $path_file = "public/request/";
            //   $allow_extension = array('jpg','jpeg','png','xls','xlsx','doc','docx','pdf');
            //
            //   if(!in_array($ext, $allow_extension)):
            //     alertMsg('danger','กรุณาเลือกเฉพาะไฟล์รูป JPG PNG หรือไฟล์เอกสาร Excel Word PDF เท่านั้นครับ','?act=add');
            //   endif;
            // }
$id=$_POST["req_user"];
$idtech=$_POST["cat_id"];

            $data = [$idtech,$id];
            $sql1 = "UPDATE `order` SET `order_user_id` = ?, `order_status` = '2' WHERE `order`.`order_id` = ?;";


            // $sql = "INSERT INTO ex_request(req_year,req_last,req_gen,req_user,service_id,req_text,req_create)
            //   VALUES(?,?,?,?,?,?,?)";
            $stmt = $dbcon->prepare($sql1);
            $result = $stmt->execute($data);
            if ($result) {
            alertMsg('success','จ่ายงานเสร็จสิ้น','manage1.php');
            }
endif;
            // $last_id = $dbcon->lastInsertId();

            // Update Picture
            // if($req_file):
            //   if($ext == 'xls' || $ext == 'xlsx' || $ext == 'doc' || $ext == 'docx' || $ext == 'pdf'){
            //     @move_uploaded_file($file_tmpname, iconv('UTF-8','TIS-620', $path_file.$file_new_name));
            //   }

              // if($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png'){
              //   @$pictureSize   = getimagesize($file_tmpname);
              //   $pictureWidth   = 1000;
              //   @$pictureHeight = round($pictureWidth*$pictureSize[1]/$pictureSize[0]);
              //   $pictureType    = $pictureSize[2];
              //
              //   if($pictureType == IMAGETYPE_PNG){
              //
              //     $pictureResource = imagecreatefrompng($file_tmpname);
              //     $pictureX = imagesx($pictureResource);
              //     $pictureY = imagesy($pictureResource);
              //     $pictureTarget = imagecreatetruecolor($pictureWidth, $pictureHeight);
              //     imagecopyresampled($pictureTarget, $pictureResource, 0, 0, 0, 0, $pictureWidth, $pictureHeight, $pictureX, $pictureY);
              //     imagepng($pictureTarget, iconv('UTF-8','TIS-620',$path_file.$file_new_name));
              //
              //   } else {
              //
              //     $pictureResource = imagecreatefromjpeg($file_tmpname);
              //     $pictureX = imagesx($pictureResource);
              //     $pictureY = imagesy($pictureResource);
              //     $pictureTarget = imagecreatetruecolor($pictureWidth, $pictureHeight);
              //     imagecopyresampled($pictureTarget, $pictureResource, 0, 0, 0, 0, $pictureWidth, $pictureHeight, $pictureX, $pictureY);
              //     imagejpeg($pictureTarget, iconv('UTF-8','TIS-620',$path_file.$file_new_name));
              //
              //   }
              // }

              // $data_picture = [$file_new_name,$last_id];
              //
              // $sql = "UPDATE ex_request SET
              //   req_file = ?
              //   WHERE req_id = ?";
              // $stmt = $dbcon->prepare($sql);
              // $stmt->execute($data_picture);

            // endif;

            // if($result){
            //   $stmt = getSystem();
            //   $row = $stmt->fetch();
            //
            //   $user_gmail = "{$row['gmail_username']}";
            //   $pass_gmail = "{$row['gmail_password']}";
            //   $email_send = "{$row['gmail_username']}";
            //   $name_send  = "{$row['gmail_name']}";
            //   $email_receive = getUserEmail($req_user);
            //   $name_receive = getUserFullname($req_user);
            //   $date_send = date('d/m/Y');
            //   $time_send = date('H:i');
            //   $line_token = "{$row['line_token']}";

              // Load Composer's autoloader
              // require 'vendor/autoload.php';
              //
              // try {
              //   $mail = new PHPMailer(true);
              //
              //   //Server settings
              //   $mail->SMTPDebug = 0;                                 // Enable verbose debug output
              //   $mail->isSMTP();                                      // Set mailer to use SMTP
              //   $mail->Host = "smtp.gmail.com";                       // Specify main and backup SMTP servers
              //   $mail->SMTPAuth = true;                               // Enable SMTP authentication
              //   $mail->Username = "{$user_gmail}";                    // SMTP username
              //   $mail->Password = "{$pass_gmail}";                    // SMTP password
              //   $mail->SMTPSecure = "tls";                            // Enable TLS encryption, `ssl` also accepted
              //   $mail->Port = 587;                                    // TCP port to connect to
              //   $mail->CharSet = "UTF-8";                             // CharSet UTF-8
              //
              //   $mail->SMTPOptions = array(
              //     'ssl' => array(
              //       'verify_peer' => false,
              //       'verify_peer_name' => false,
              //       'allow_self_signed' => true
              //     )
              //   );

                // //Recipients
                // $mail->setFrom("{$email_send}", "{$name_send}");
                // $mail->addAddress("{$email_receive}", "{$name_receive}");
                //
                // //Content
                // $mail->isHTML(true);
                // $mail->Subject = "ระบบแจ้งขอใช้บริการ";
                // $mail->Body  = "เรียน คุณ {$name_receive} <br><br>";
                // $mail->Body .= "ระบบได้รับเรื่องการแจ้งขอใช้บริการเรียบร้อยแล้วครับ<br><br>";
                // $mail->Body .= "ขอใช้บริการ<br>";
                // $mail->Body .= "บริการ : {$service_name}<br>";
                // $mail->Body .= "รายละเอียด : {$req_text}<br>";
                // $mail->Body .= "วันที่ : {$date_send}<br>";
                // $mail->Body .= "เวลา : {$time_send} น.<br>";
                // $mail->send();

// $line_text = "
// แจ้งเตือนการขอใช้บริการ
// คุณ {$name_receive}
// ขอใช้บริการ
// บริการ : {$service_name}
// รายละเอียด : {$req_text}
// วันที่ : {$date_send}
// เวลา : {$time_send} น.";
//
//                 echo lineNotify($line_text,$line_token);
//
//                 alertMsg('success','แจ้งขอใช้บริการเรียบร้อยแล้วครับ','request.php');

            //   } catch (Exception $e) {
            //     alertMsg('danger','ระบบมีปัญหา, กรุณาลองใหม่อีกครั้งครับ','request.php');
            //   }
            //
            // } else {
            //   alertMsg('danger','ระบบมีปัญหา, กรุณาลองใหม่อีกครั้งครับ','request.php');
            // }

        //   endif;
         ?>
      </main>
    </div>
  </div>


  <script src="node_modules/jquery/dist/jquery.min.js"></script>
  <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="node_modules/popper.js/dist/umd/popper.min.js"></script>
  <script src="node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="node_modules/select2/dist/js/select2.min.js"></script>
  <script src="public/js/main.min.js"></script>

  <script>
    $(document).ready(function() {
      $.fn.dataTable.ext.errMode = 'none';
      $('#data').DataTable({
        "oLanguage": {
          "sLengthMenu": "แสดง _MENU_ ลำดับ ต่อหน้า",
          "sZeroRecords": "ไม่พบข้อมูลที่ค้นหา",
          "sInfo": "แสดง _START_ ถึง _END_ ของ _TOTAL_ ลำดับ",
          "sInfoEmpty": "แสดง 0 ถึง 0 ของ 0 ลำดับ",
          "sInfoFiltered": "(จากทั้งหมด _MAX_ ลำดับ)",
          "sSearch": "ค้นหา :",
          "oPaginate": {
                "sFirst":    "หน้าแรก",
                "sLast":    "หน้าสุดท้าย",
                "sNext":    "ถัดไป",
                "sPrevious": "ก่อนหน้า"
            }
        }
      });
    });

    function getServiceList(val) {
      $.ajax({
        type: "POST",
        url: "getService.php",
        data:'cat_id='+val,
        success: function(data){
          $("#service_list").html(data);
        }
      });
    }
  </script>
  <script type="text/javascript">
    //data
    $(document).ready(function() {
      /*
      var tablePropertygroup1 = $('#data').DataTable();
	    tablePropertygroup1.ajax.reload();
      alert("reload");
      */
      //  $('#data').data.reload();

      // $( "#btntest" ).click(function() {
      //   alert( "Handler for .click() called." );
      //   //$('#data').data.reload();
      //   var tablePropertygroup1 = $('#data').DataTable();
  	  //   tablePropertygroup1.ajax.reload();
      // });

      // var table = $('#data').DataTable( {
      //     ajax: "data.json"
      // } );
      //
      // setInterval( function () {
      //     table.ajax.reload();
      //     alert( "Handler for .click() called." );
      // }, 30000 );


    });
  </script>
  <script type="text/javascript" language="javascript" >
        $(document).ready(function(){
          var tablePropertygroup1 =$('#data2').dataTable({
                    "ajax": {
                        "url":"ajax_getdata.php",
                        "dataSrc": "",
                        "bPaginate":true,
                        "bProcessing": true
                    },
                    //nexpang แสงหน้าต่อไป
                    "paging": true, //false, // เปิด/ปิดสถานะให้สามารถเปลียนหน้าเพจของdatatabelได้
                    "iDisplayLength": 15,//กำหนดแถวข้อมูลที่จะแสดง
                    "aLengthMenu": [[15, 20], [15, 20]],//กำหนดdropdownว่าจะให้แสดงได้กี่แถวบ้าง
                    "bFilter" : false,
                    "bLengthChange": false,
                    //end nexpang แสงหน้าต่อไป
                    "searching": true,
                    "select": true,
                    "fixedHeader": true,
                    "language": {
                    "emptyTable":"My Custom Message On Empty Table"
                    },
                    "select": {
                        "rows": {
                            "_": "",
                            "0": "",
                            "1": ""
                        }
                    },
                    "oLanguage": {
                    "sEmptyTable":"My Custom Message On Empty Table"
                    },
                    "columns": [
                        { "data": "runnumber" },
                        { "data": "ct_name" },
                        { "data": "order_lati" },
                        { "data": "order_longti" },
                        // { "data": "order_longti" },
                        { "data": "order_status" },
                        //แก้ไข ลบ
                        { "data": "order_id",render: function (data, type, row) {
                                return '<a href=?act=edit&id='+row.order_id+' class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a> <a href=?act=delete&id='+row.order_id+' class="btn btn-info btn-sm"><i class="fas fa-trash-alt"></i></a>';
                        }},
                    ],
                    "oLanguage": {
                    "sProcessing":   "กำลังดำเนินการ...",
                    "sLengthMenu":   "แสดง _MENU_ แถว",
                    "sZeroRecords":  "ไม่พบข้อมูล",
                    "sInfo":         "แสดง _START_ ถึง _END_ จาก _TOTAL_ แถว",
                    "sInfoEmpty":    "แสดง 0 ถึง 0 จาก 0 แถว",
                    "sInfoFiltered": "(กรองข้อมูล _MAX_ ทุกแถว)",
                    "sInfoPostFix":  "",
                    "sSearch":       "ค้นหา: ",
                    "sUrl":          "",
                    "oPaginate": {
                        "sFirst":    "หน้าแรก",
                        "sPrevious": "ก่อนหน้า",
                        "sNext":     "ถัดไป",
                        "sLast":     "หน้าสุดท้าย"
                    }
                    },

            });

        });
      setInterval(function () {
        var data2 = $('#data2').DataTable();
	        data2.ajax.reload();
        console.log("รีโหลด");
      }, 3600);//กำหนดเวลารีโหลด
    </script>
</body>
</html>
