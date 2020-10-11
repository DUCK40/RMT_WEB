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
              รายงานการขอใช้บริการ
            </li>
          </ol>
        </nav>

        <div class="row justify-content-center">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h5 class="text-center">การขอใช้บริการ</h5>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-xl-3 col-md-6 mb-2">
                    <select class="form-control form-control-sm"
                      onChange="location = this.options[this.selectedIndex].value;">
                      <option value="manage.php?year=&month=<?php echo @$_GET['month'] ?>&cat=<?php echo @$_GET['cat'] ?>&serv=<?php echo @$_GET['serv'] ?>&stat=<?php echo @$_GET['stat'] ?>"
                        <?php if(empty(@$_GET['year'])) echo 'selected' ?>>--- ค้นหา ปี ---</option>
                      <?php
                        $years = getYear();
                        foreach($years as $year) :
                      ?>
                      <option value="manage.php?year=<?php echo $year ?>&month=<?php echo @$_GET['month'] ?>&cat=<?php echo @$_GET['cat'] ?>&serv=<?php echo @$_GET['serv'] ?>&stat=<?php echo @$_GET['stat'] ?>" <?php if(@@$_GET['year'] == $year) echo 'selected' ?>><?php echo $year ?></option>
                      <?php
                        endforeach;
                      ?>
                    </select>
                  </div>
                  <div class="col-xl-3 col-md-6 mb-2">
                    <select class="form-control form-control-sm"
                      onChange="location = this.options[this.selectedIndex].value;">
                      <option value="manage.php?year=<?php echo @$_GET['year'] ?>&month=&cat=<?php echo @$_GET['cat'] ?>&serv=<?php echo @$_GET['serv'] ?>&stat=<?php echo @$_GET['stat'] ?>"
                        <?php if(empty(@$_GET['month'])) echo 'selected' ?>>--- ค้นหา เดือน ---</option>
                      <?php
                        $months = getMonth();
                        foreach($months as $key => $month) :
                      ?>
                      <option value="manage.php?year=<?php echo @$_GET['year'] ?>&month=<?php echo $key ?>&cat=<?php echo @$_GET['cat'] ?>&serv=<?php echo @$_GET['serv'] ?>&stat=<?php echo @$_GET['stat'] ?>" <?php if(@@$_GET['month'] == $key) echo 'selected' ?>><?php echo $month ?></option>
                      <?php
                        endforeach;
                      ?>
                    </select>
                  </div>
                  <div class="col-xl-3 col-md-6 mb-2">
                    <select class="form-control form-control-sm"
                      onChange="location = this.options[this.selectedIndex].value;">
                      <option value="manage.php?year=<?php echo @$_GET['year'] ?>&month=<?php echo @$_GET['month'] ?>&cat=&serv=<?php echo @$_GET['serv'] ?>&stat=<?php echo @$_GET['stat'] ?>"
                        <?php if(empty(@$_GET['cat'])) echo 'selected' ?>>--- ค้นหา หมวดหมู่ ---</option>
                      <?php
                        $categorys = getCategory();
                        foreach($categorys as $cat) :
                      ?>
                      <option value="manage.php?year=<?php echo @$_GET['year'] ?>&month=<?php echo @$_GET['month'] ?>&cat=<?php echo $cat['cat_id'] ?>&serv=<?php echo @$_GET['serv'] ?>&stat=<?php echo @$_GET['stat'] ?>" <?php if(@@$_GET['cat'] == $cat['cat_id']) echo 'selected' ?>><?php echo $cat['cat_name'] ?></option>
                      <?php
                        endforeach;
                      ?>
                    </select>
                  </div>
                  <div class="col-xl-3 col-md-6 mb-2">
                    <select class="form-control form-control-sm"
                      onChange="location = this.options[this.selectedIndex].value;">
                      <option value="manage.php?year=<?php echo @$_GET['year'] ?>&month=<?php echo @$_GET['month'] ?>&cat=<?php echo @$_GET['cat'] ?>&serv=&stat=<?php echo @$_GET['stat'] ?>"
                        <?php if(empty(@$_GET['serv'])) echo 'selected' ?>>--- ค้นหา บริการ ---</option>
                      <?php
                        $services = getService();
                        foreach($services as $serv) :
                      ?>
                      <option value="manage.php?year=<?php echo @$_GET['year'] ?>&month=<?php echo @$_GET['month'] ?>&cat=<?php echo @$_GET['cat'] ?>&serv=<?php echo $serv['service_id'] ?>&stat=<?php echo @$_GET['stat'] ?>" <?php if(@@$_GET['serv'] == $serv['service_id']) echo 'selected' ?>><?php echo $serv['service_name'] ?></option>
                      <?php
                        endforeach;
                      ?>
                    </select>
                  </div>
                  <div class="col-xl-3 col-md-6 mb-2">
                    <select class="form-control form-control-sm"
                      onChange="location = this.options[this.selectedIndex].value;">
                      <option value="manage.php?year=<?php echo @$_GET['year'] ?>&month=<?php echo @$_GET['month'] ?>&cat=<?php echo @$_GET['cat'] ?>&serv=<?php echo @$_GET['serv'] ?>&stat="
                        <?php if(empty(@$_GET['stat'])) echo 'selected' ?>>--- ค้นหา สถานะ ---</option>
                      <?php
                        $statuses = getStatus();
                        foreach($statuses as $status) :
                      ?>
                      <option value="manage.php?year=<?php echo @$_GET['year'] ?>&month=<?php echo @$_GET['month'] ?>&cat=<?php echo @$_GET['cat'] ?>&serv=<?php echo @$_GET['serv'] ?>&stat=<?php echo $status['status_id'] ?>" <?php if(@@$_GET['stat'] == $status['status_id']) echo 'selected' ?>><?php echo $status['status_name'] ?></option>
                      <?php
                        endforeach;
                      ?>
                    </select>
                  </div>
                  <div class="col-xl-3 col-md-6 mb-2">
                    <a href="report_request.php?year=<?php echo @$_GET['year'] ?>&month=<?php echo @$_GET['month'] ?>&cat=<?php echo @$_GET['cat'] ?>&serv=<?php echo @$_GET['serv'] ?>&stat=<?php echo @$_GET['stat'] ?>" target="_blank"
                      class="btn btn-danger btn-sm btn-block">
                      <i class="fas fa-file-pdf mr-2"></i>รายงาน
                    </a>
                  </div>
                </div>

                <!-- Table -->
                <div class="row">
                  <div class="col-12">
                    <div class="table-responsive">
                      <table id="data" class="table table-bordered table-hover table-sm">
                        <thead>
                          <tr>
                            <th>ลำดับ</th>
                            <th>ชื่อผู้ใช้บริการ</th>
                            <th>Latijude</th>
                            <th>Longtijude</th>
                            <th>อำเภอ</th>
                            <th>สถานะ</th>

    <?php if($check_level == 99): ?>
                            <th>จัดการ</th>

  <?php endif ?>

                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $result = getOrderRepair();
                            foreach($result as $key => $row):
                          ?>


                          <tr>
                            <td><?php echo $key+1 ?></td>
                                        <td class="text-left"><?php echo $row['cus_name'] ?></td>
                                        <td class="text-left"><?php echo $row['order_lati'] ?></td>
                                        <td class="text-left"><?php echo $row['order_longti'] ?></td>
                                        <td class="text-left"><?php echo $row['cus_name'] ?></td>
                                        <td class="text-left"><?php echo $row['order_status'] ?></td>


                <?php if($check_level == 99): ?>


                                        <td>
                                          <a href="?act=edit&id=<?php echo $row['part_d_id'] ?>" class="btn btn-info btn-sm">
                                            <i class="fas fa-edit"></i>
                                          </a>
                                          <a class="btn btn-danger btn-sm" href="?act=delete&id=<?php echo $row['part_d_id'] ?>"
                                              onClick="return confirm('Are you sure?');">

                                              <i class="fas fa-trash-alt"></i>
                                          </a>
                                        </td>
                                      <?php endif ?>

                          </tr>
                          <?php
                            endforeach;
                            unset($req);
                          ?>
                        </tbody>
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

          if($act == 'add'):
            include_once 'inc/alert.php';
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
                  <div class="form-group row" style="display: none">
                    <label class="col-sm-4 col-form-label text-md-right">รหัสผู้ใช้บริการ</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="req_user" readonly
                        value="<?php echo $row['user_code'] ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">ผู้ใช้บริการ</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" readonly
                        value="<?php echo getUserFullname($row['user_code']) ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">หมวดหมู่</label>
                    <div class="col-sm-3">
                      <select class="form-control form-control-sm" name="cat_id"
                        onChange="getServiceList(this.value);" required>
                        <option value="">--- เลือก หมวดหมู่ ---</option>
                        <?php
                          $result = getCategory();
                          foreach($result as $cat) :
                        ?>
                        <option value="<?php echo $cat['cat_id'] ?>"><?php echo $cat['cat_name'] ?></option>
                        <?php
                          endforeach;
                          unset($cat);
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">บริการ</label>
                    <div class="col-sm-6">
                      <select class="form-control form-control-sm" name="service_id" id="service_list"
                        onChange="getBranch(this.value);" required>
                        <option value="">--- กรุณาเลือก บริการ ---</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">ไฟล์หรือรูปประกอบ</label>
                    <div class="col-sm-4">
                      <input type="file" class="form-control" name="req_file">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">รายละเอียดเพิ่มเติม</label>
                    <div class="col-sm-6">
                      <textarea name="req_text" class="form-control" rows="5" required></textarea>
                    </div>
                  </div>
                  <div class="form-group row justify-content-center">
                    <div class="col-sm-3 pb-2">
                      <button class="btn btn-success btn-sm btn-block" name="btnInsert">
                        <i class="fa fa-check pr-2"></i>ยืนยัน
                      </button>
                    </div>
                    <div class="col-sm-3 pb-2">
                      <a class="btn btn-danger btn-sm btn-block" href="request.php">
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

            $req_user = $_POST['req_user'];
            $service_id = $_POST['service_id'];
            $service_name = getServiceName($service_id);
            $req_file = $_FILES['req_file']['name'];
            $req_text = $_POST['req_text'];
            $req_create = date('Y-m-d H:i:s');
            $req_year = date('Y');

            $data_check_last = [$req_year];
            $sql = "SELECT req_last FROM ex_request
            WHERE req_year = ?
            ORDER BY req_last DESC
            LIMIT 1";
            $stmt = $dbcon->prepare($sql);
            $stmt->execute($data_check_last);
            $check_gen = $stmt->fetch();

            $req_last = STR_PAD(($check_gen['req_last']+1), 5, "0", STR_PAD_LEFT);
            $req_gen  = $req_year.$req_last;

            $data = [$req_year,$req_last,$req_gen,$req_user,$service_id,$req_text,$req_create];

            // Check Service
            if(empty($service_id)){
              alertMsg('danger','กรุณาเลือกบริการด้วยครับ','?act=add');
            }

            // Check Extension
            if($req_file){
              $file_name  = $_FILES['req_file']['name'];
              $file_tmpname  = $_FILES['req_file']['tmp_name'];
              $ext = pathinfo($file_name, PATHINFO_EXTENSION);
              $file_new_name = $req_gen.'.'.$ext;
              $path_file = "public/request/";
              $allow_extension = array('jpg','jpeg','png','xls','xlsx','doc','docx','pdf');

              if(!in_array($ext, $allow_extension)):
                alertMsg('danger','กรุณาเลือกเฉพาะไฟล์รูป JPG PNG หรือไฟล์เอกสาร Excel Word PDF เท่านั้นครับ','?act=add');
              endif;
            }

            $sql = "INSERT INTO ex_request(req_year,req_last,req_gen,req_user,service_id,req_text,req_create)
              VALUES(?,?,?,?,?,?,?)";
            $stmt = $dbcon->prepare($sql);
            $result = $stmt->execute($data);

            $last_id = $dbcon->lastInsertId();

            // Update Picture
            if($req_file):
              if($ext == 'xls' || $ext == 'xlsx' || $ext == 'doc' || $ext == 'docx' || $ext == 'pdf'){
                @move_uploaded_file($file_tmpname, iconv('UTF-8','TIS-620', $path_file.$file_new_name));
              }

              if($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png'){
                @$pictureSize   = getimagesize($file_tmpname);
                $pictureWidth   = 1000;
                @$pictureHeight = round($pictureWidth*$pictureSize[1]/$pictureSize[0]);
                $pictureType    = $pictureSize[2];

                if($pictureType == IMAGETYPE_PNG){

                  $pictureResource = imagecreatefrompng($file_tmpname);
                  $pictureX = imagesx($pictureResource);
                  $pictureY = imagesy($pictureResource);
                  $pictureTarget = imagecreatetruecolor($pictureWidth, $pictureHeight);
                  imagecopyresampled($pictureTarget, $pictureResource, 0, 0, 0, 0, $pictureWidth, $pictureHeight, $pictureX, $pictureY);
                  imagepng($pictureTarget, iconv('UTF-8','TIS-620',$path_file.$file_new_name));

                } else {

                  $pictureResource = imagecreatefromjpeg($file_tmpname);
                  $pictureX = imagesx($pictureResource);
                  $pictureY = imagesy($pictureResource);
                  $pictureTarget = imagecreatetruecolor($pictureWidth, $pictureHeight);
                  imagecopyresampled($pictureTarget, $pictureResource, 0, 0, 0, 0, $pictureWidth, $pictureHeight, $pictureX, $pictureY);
                  imagejpeg($pictureTarget, iconv('UTF-8','TIS-620',$path_file.$file_new_name));

                }
              }

              $data_picture = [$file_new_name,$last_id];

              $sql = "UPDATE ex_request SET
                req_file = ?
                WHERE req_id = ?";
              $stmt = $dbcon->prepare($sql);
              $stmt->execute($data_picture);

            endif;

            if($result){
              $stmt = getSystem();
              $row = $stmt->fetch();

              $user_gmail = "{$row['gmail_username']}";
              $pass_gmail = "{$row['gmail_password']}";
              $email_send = "{$row['gmail_username']}";
              $name_send  = "{$row['gmail_name']}";
              $email_receive = getUserEmail($req_user);
              $name_receive = getUserFullname($req_user);
              $date_send = date('d/m/Y');
              $time_send = date('H:i');
              $line_token = "{$row['line_token']}";

              // Load Composer's autoloader
              require 'vendor/autoload.php';

              try {
                $mail = new PHPMailer(true);

                //Server settings
                $mail->SMTPDebug = 0;                                 // Enable verbose debug output
                $mail->isSMTP();                                      // Set mailer to use SMTP
                $mail->Host = "smtp.gmail.com";                       // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                $mail->Username = "{$user_gmail}";                    // SMTP username
                $mail->Password = "{$pass_gmail}";                    // SMTP password
                $mail->SMTPSecure = "tls";                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 587;                                    // TCP port to connect to
                $mail->CharSet = "UTF-8";                             // CharSet UTF-8

                $mail->SMTPOptions = array(
                  'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                  )
                );

                //Recipients
                $mail->setFrom("{$email_send}", "{$name_send}");
                $mail->addAddress("{$email_receive}", "{$name_receive}");

                //Content
                $mail->isHTML(true);
                $mail->Subject = "ระบบแจ้งขอใช้บริการ";
                $mail->Body  = "เรียน คุณ {$name_receive} <br><br>";
                $mail->Body .= "ระบบได้รับเรื่องการแจ้งขอใช้บริการเรียบร้อยแล้วครับ<br><br>";
                $mail->Body .= "ขอใช้บริการ<br>";
                $mail->Body .= "บริการ : {$service_name}<br>";
                $mail->Body .= "รายละเอียด : {$req_text}<br>";
                $mail->Body .= "วันที่ : {$date_send}<br>";
                $mail->Body .= "เวลา : {$time_send} น.<br>";
                $mail->send();

$line_text = "
แจ้งเตือนการขอใช้บริการ
คุณ {$name_receive}
ขอใช้บริการ
บริการ : {$service_name}
รายละเอียด : {$req_text}
วันที่ : {$date_send}
เวลา : {$time_send} น.";

                echo lineNotify($line_text,$line_token);

                alertMsg('success','แจ้งขอใช้บริการเรียบร้อยแล้วครับ','request.php');

              } catch (Exception $e) {
                alertMsg('danger','ระบบมีปัญหา, กรุณาลองใหม่อีกครั้งครับ','request.php');
              }

            } else {
              alertMsg('danger','ระบบมีปัญหา, กรุณาลองใหม่อีกครั้งครับ','request.php');
            }

          endif;
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
</body>
</html>
