<?php
  ob_start();
  session_start();
  date_default_timezone_set("Asia/Bangkok");
  include_once 'config/connection.php';
  include_once 'config/function.php';

  $user_level = getUserLevel($_SESSION['user_code']);
  if(!isset($_SESSION['user_code']) || ($user_level == 1 || empty($user_level))){
    alertMsg('danger','ไม่พบหน้านี้ในระบบ','request.php');
  }

  $user_code = $_SESSION['user_code'];
  $stmt = getQueryUser($user_code);
  $row = $stmt->fetch();


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
  <link rel="stylesheet" href="public/css/custom.css">
</head>
<body>
  <?php include_once 'inc/navbar.php' ?>

  <div class="container-fluid">
    <div class="row">
      <?php include_once 'inc/sidemenu.php' ?>

      <main role="main" class="col-xl-10 col-md-9 ml-sm-auto px-4">

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
            <li class="breadcrumb-item">
              <a href="computers.php"><i class="fas fa-desktop"></i></a>
            </li>
            <li class="breadcrumb-item active">
              จัดการข้อมูลช่างในสาขา

            </li>
          </ol>
        </nav>







        <div class="row justify-content-center">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h5 class="text-center">เพิ่มข้อมูลช่างประจำสาขา</h5>
              </div>
              <div class="card-body">
              <?php

              if($user_level == 69){ ?>
                <div class="row justify-content-end">
                  <div class="col-xl-3 col-md-6 mb-2">
                    <a href="?act=add" class="btn btn-success btn-sm btn-block">
                      <i class="fas fa-plus mr-2"></i>เพิ่ม
                    </a>
                  </div>
                </div>
            <?php  }else { ?>

            <?php  }
               ?>


                <!-- Table -->
                <div class="row justify-content-center">
                  <div class="col-12">
                    <div class="table-responsive">
                      <table id="data" class="table table-bordered table-hover table-sm">
                        <thead>
                          <tr>
                            <th>ลำดับ</th>
                            <th>ชื่อ</th>
                            <th>นามสกุล</th>
                            <th>สาขา</th>
                            <th>ชื่อใช้งานในระบบ</th>
                            <th>เบอร์โทร</th>
                            
    <?php if($check_level == 69): ?>
                            <th>จัดการ</th>

  <?php endif ?>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $result = getTechnicain1();
                            foreach($result as $key => $row):
                          ?>
                          <tr>
                            <td><?php echo $key+1 ?></td>
                            <td class="text-left"><?php echo $row['tn_name'] ?></td>
                            <td class="text-left"><?php echo $row['tn_lastname'] ?></td>
                            <td class="text-left"><?php echo $row['dep_name'] ?></td>
                            <td class="text-left"><?php echo $row['tn_userid'] ?></td>
                            <td class="text-left"><?php echo $row['tn_phone'] ?></td>
                             </td>


    <?php if($check_level == 69): ?>


                            <td>
                              <a href="?act=edit&id=<?php echo $row['tn_id'] ?>" class="btn btn-info btn-sm">
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
                            unset($row);
                          ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="col-sm-3 pb-2">
                    <a class="btn btn-danger btn-sm btn-block" href="dashboard.php">
                      <i class="fa fa-arrow-left pr-2"></i>กลับหน้าหลัก
                    </a>
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
              <a href="index.php"><i class="fas fa-home"></i></a>
            </li>
            <li class="breadcrumb-item">
              <a href="computers.php"><i class="fas fa-desktop"></i></a>
            </li>
            <li class="breadcrumb-item active">
              เพิ่มข้อมูลช่างในสาขา
            </li>
          </ol>
        </nav>

       <div class="row justify-content-center">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h5 class="text-center">เพิ่มข้อมูลช่างในสาขา</h5>
              </div>
              <div class="card-body">
                <form action="?act=insert" method="POST">
                  <div class="form-group row">
                    <!-- <label class="col-sm-4 col-form-label text-md-right">ขนาดยาง</label>
                    <div class="col-sm-6"> -->

                    <label class="col-sm-4 col-form-label text-md-right">ชื่อ</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="tn_name" required>
                    </div>

                   

                      <!-- ค้นหา -->
                      <!-- <select name="txtPermission2ShowStatus" id="txtPermission2ShowStatus" style=""> -->
                     
  <!-- </div> -->


<br>
<br>
                    <label class="col-sm-4 col-form-label text-md-right">นามสกุล</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="tn_lastname" required>
                    </div>

                    


<br>
<br>
<label class="col-sm-4 col-form-label text-md-right">ชื่อผู้ใช้งานในระบบ</label>
<div class="col-sm-6">
  <input type="text" class="form-control" name="tn_userid" required>
</div>


<br>
<br>
<label class="col-sm-4 col-form-label text-md-right">รหัสผ่าน</label>
<div class="col-sm-6">
  <input type="text" class="form-control" name="tn_pass" required>
</div>


<br>
<br>

                    <label class="col-sm-4 col-form-label text-md-right">เบอร์โทรศัพท์</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" name="tn_phone" required>

                    </div>


                    <br>
                    <br>




                      <!-- <input type="text" class="form-control" name="sw_name" required> -->




                  </div>
                  <div class="form-group row justify-content-center">
                    <div class="col-sm-3 pb-2">
                      <button class="btn btn-success btn-sm btn-block" name="btnInsert">
                        <i class="fa fa-check pr-2"></i>ยืนยัน
                      </button>
                    </div>
                    <div class="col-sm-3 pb-2">
                      <a class="btn btn-danger btn-sm btn-block" href="dashboard.php">
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
              header('location: index.php');
              die();
            }
            $tn_name = $_POST['tn_name'];
            $tn_lastname = $_POST['tn_lastname'];
            $tn_userid = $_POST['tn_userid'];

            $tn_pass = $_POST['tn_pass'];
            $tn_phone = $_POST['tn_phone'];




           


  $dep_id =   $_SESSION['dep_id'];

              $data1 = [ $tn_name,$tn_lastname,$tn_userid,$tn_pass, $tn_phone, $dep_id ];
              $sql1 = "INSERT INTO `ex_technician` ( `tn_name`, `tn_lastname`, `tn_userid`, `tn_pass`, `tn_phone`, `dep_id`) 
              VALUES ( ?,?,?, ?, ?, ?);";

            $stmt = $dbcon->prepare($sql1);
            $result = $stmt->execute($data1);

            if($result) {
              alertMsg('success','เพิ่มข้อมูลเรียบร้อยแล้วครับ','addtechnicain.php');
            } else {
              alertMsg('danger','ระบบมีปัญหา, กรุณาลองใหม่อีกครั้งครับ','?act=add');
            }

            $stmt = null;
          endif;

          /*

          Edit Item

          */

          if($act == 'edit'):
            include_once 'inc/alert.php';

            $sw_id = @$_GET['id'];
            $sw_idd = @$_GET['part_d_id'];

            $stmt = getTechnicain1($sw_id);
            $row = $stmt->fetch();
        ?>
        <nav>
          <ol class="breadcrumb bg-white border">
            <li class="breadcrumb-item">
              <a href="index.php"><i class="fas fa-home"></i></a>
            </li>
            <li class="breadcrumb-item">
              <a href="software.php"><i class="fas fa-desktop"></i></a>
            </li>
            <li class="breadcrumb-item active">
              แก้ไขข้อมูลช่างประจำสาขา
            </li>
          </ol>
        </nav>

        <div class="row justify-content-center">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h5 class="text-center">แก้ไขข้อมูลช่างประจำสาขา</h5>
              </div>
              <div class="card-body">
                <form action="?act=update" method="POST">
                <div class="form-group row">
                <label class="col-sm-4 col-form-label text-md-right">ชื่อ</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" name="txtname" id="txtname"
                    value="<?php echo $row['tn_name'] ?>" required>
                </div>
              </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">นามสกุล</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="txtlname" id="txtlname"
                        value="<?php echo $row['tn_lastname'] ?>" required>
                    </div>
                  </div>

                  <!--ทดลอง textbox 2-->

                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">ชื่อผู้ใช้งานในระบบ</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="sec_use"
                        value="<?php echo $row['tn_userid'] ?>" required readonly>
                    </div>

                    <!--  -->
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">รหัสผ่าน</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="passwordold" id="passwordold"
                        value="" >
                    </div>


                    </div>

                    <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">รหัสผ่านใหม่</label>
                    <div class="col-sm-4">
                    <input type="password" class="form-control" name="new_password" id="new_password">
                    </div>


                    </div>


                    <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">ยืนยัน รหัสผ่านใหม่</label>
                    <div class="col-sm-4">
                    <input type="password" class="form-control" name="new_password_again" id="new_password_again">
                    </div>


                    </div>
                    <div class="form-group row">
                    <label class="col-sm-4"></label>
                    <div id="checkPassword"></div>
                  </div>

                    <!-- <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">รหัสผ่านใหม่</label>
                    <div class="col-sm-4">
                      <input type="password" class="form-control" name="new_password" id="new_password">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">ยืนยัน รหัสผ่านใหม่</label>
                    <div class="col-sm-4">
                      <input type="password" class="form-control" name="new_password_again" id="new_password_again">
                    </div>
                  </div> -->
                  
                    <!--  -->
                  <input type="hidden" id="sw_id" name="sw_id" value="<?php echo $sw_id ?>">
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">เบอร์โทรศัพท์</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="txttel" id="txttel"
                        value="<?php echo $row['tn_phone'] ?>" required>
                    </div>

                    <!--  -->
                  </div>


                  <!-- <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">สถานะ</label>
                    <div class="form-check form-check-inline">
                      <label class="form-check-label mx-3">
                        <input class="form-check-input" type="radio" name="sw_status" value="1"
                       </*?php if($row['sw_status'] == '1') echo 'checked' ?>>เปิดการใช้งาน
                      </label>
                      <label class="form-check-label mx-3">
                        <input class="form-check-input" type="radio" name="sw_status" value="2"
                          </*?php if($row['sw_status'] == '2') echo 'checked' ?>>ปิดการใช้งาน
                      </label>
                    </div>
                  </div> -->



                  <div class="form-group row justify-content-center">
                    <div class="col-sm-3 pb-2">
                      <button class="btn btn-success btn-sm btn-block" name="btnUpdate" id="btnUpdate">
                        <i class="fa fa-check pr-2"></i>ยืนยัน
                      </button>
                    </div>
                    <div class="col-sm-3 pb-2">
                      <a class="btn btn-danger btn-sm btn-block" href="addparts1.php">
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
          $stmt = null;
          endif;

          /*

          Update Item

          */



          //////////////////////////////////////////////////////////////////////////////////////

         

          if($act == 'update'):
            if(!isset($_POST['btnUpdate'])){
              header('location: index.php');
              die();
            }
            $sw_id = $_POST['sw_id'];

            $user_code = $_POST['user_code'];
            $user_password = $_POST['passwordold'];
            $new_password = $_POST['new_password'];
            $hash_password = $new_password;

            $data_check = [$sw_id];

            $sql = "SELECT tn_pass
              FROM `ex_technician`
              WHERE tn_id = ?";
            $stmt = $dbcon->prepare($sql);
            $stmt->execute($data_check);
            $row = $stmt->fetch();

            $tops =   $row['tn_pass'];
            // echo
            // echo $user_password;

            // if($row['tn_pass'] != $user_password){
            //   alertMsg('danger','รหัสผ่านเก่าไม่ถูกต้อง . กรุณาลองใหม่อีกครั้งครับ','addtechnicain.php?idold='.''.$tops.''.'&old2='.''.$user_password.'');
            // }else{
            //   alertMsg('danger','ถูกต้อง กรุณาลองใหม่อีกครั้งครับ','addtechnicain.php');
              
            // }

            // $check_verify = password_verify($user_password,$row['tn_pass']);

            // if(!$check_verify){
            //   alertMsg('danger','รหัสผ่านเก่าไม่ถูกต้อง กรุณาลองใหม่อีกครั้งครับ','addtechnicain.php');
            // }

            if($_POST['passwordold']==""){
// txttel txtlname txtname
              $data_update = [$_POST['txtname'], $_POST['txtlname'], $_POST['txttel'], $sw_id];

              $sql = "UPDATE ex_technician SET
                tn_name = ?,
                tn_lastname = ?,
                tn_phone = ?
                WHERE tn_id = ?";
              $stmt = $dbcon->prepare($sql);
              $result = $stmt->execute($data_update);
  
              if($result){
                alertMsg('success','แก้ไขเรียบร้อยแล้วครับ','addtechnicain.php'.''.$sw_id.'');
              } else {
                alertMsg('danger','ระบบมีปัญหา, กรุณาลองใหม่อีกครั้งครับ','addtechnicain.php?act=edit&id='.''.$sw_id.'');
              }
            }else{
              if($row['tn_pass'] != $user_password){
                alertMsg('danger','รหัสผ่านเก่าไม่ถูกต้อง . กรุณาลองใหม่อีกครั้งครับ','addtechnicain.php?act=edit&id='.''.$sw_id.'');
              }else{
                // alertMsg('danger','ถูกต้อง กรุณาลองใหม่อีกครั้งครับ','addtechnicain.php?act=edit&id='.''.$sw_id.'');       
                $data_update = [$_POST['txtname'], $_POST['txtlname'], $_POST['txttel'], $_POST['new_password'], $sw_id];

                $sql = "UPDATE ex_technician SET
                  tn_name = ?,
                  tn_lastname = ?,
                  tn_phone = ?,
                  tn_pass = ?
                  WHERE tn_id = ?";
                $stmt = $dbcon->prepare($sql);
                $result = $stmt->execute($data_update);
    
                if($result){
                  alertMsg('success','แก้ไขเรียบร้อยแล้วครับ','addtechnicain.php');
                } else {
                  alertMsg('danger','ระบบมีปัญหา, กรุณาลองใหม่อีกครั้งครับ','addtechnicain.php?act=edit&id='.''.$sw_id.'');
                }  
              }
           
            }


            $stmt = null;
          endif;


          ////////////////////////////////////////////////////////////////////////////////////////

        /*  if($act == 'update'):
            if(!isset($_POST['btnUpdate'])){
              header('location: index.php');
              die();
            }

            $sw_id = $_POST['sw_id'];
            $sw_name = $_POST['price'];
            // $sw_status = $_POST['sw_total'];
            $sw_total = $_POST['sec_use'];

            $data = [$sw_name ,$sw_total,$sw_id];

            if($_POST['new_passwordold']==""){

            }else{

            }

            $sql = "UPDATE ex_software_datail SET
              part_d_price = ?,
              part_d_sec_use = ?
              WHERE part_d_id = ?";
            $stmt = $dbcon->prepare($sql);
            $result = $stmt->execute($data);

            if($result) {
              alertMsg('success','แก้ไขข้อมูลเรียบร้อยแล้วครับ',"addparts1.php?id={$sw_id}");
            } else {
              alertMsg('danger','ระบบมีปัญหา, กรุณาลองใหม่อีกครั้งครับ',"?act=edit&id={$sw_id}");
            }

            $stmt = null;
          endif;*/

          /*

          Delete Item

          */

          if($act == 'delete'):
            $sw_idd = @$_GET['id'];
            // echo $sw_idd;
            // $sw_status = 2;
            //
            $data = [$sw_idd];

            $sql = "DELETE FROM `ex_software_datail` WHERE `ex_software_datail`.`part_d_id` = ?";
            $stmt = $dbcon->prepare($sql);
            $result = $stmt->execute($data);

            if($result) {
              alertMsg('success','ปิดการใช้งานเรียบร้อยแล้วครับ ','addparts1.php');
            } else {
              alertMsg('danger','ระบบมีปัญหา, กรุณาลองใหม่อีกครั้งครับ','addparts1.php');
            }

            $stmt = null;
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
      var tablePermission2Master = $('#data').DataTable();

      $('#txtPermission2ShowStatus').on( 'change', function () {
                      tablePermission2Master
                          .columns( 0 )
                          .search( this.value )
                          .draw();
                  });
    });
  </script>

<script>$(document).ready(function() {
    // Alert Password Match
    $('#new_password_again').keyup(function(){
     // alert("Hello! I am an alert box!!");
      var new_password  = $('#new_password').val();
      var new_password_again = $('#new_password_again').val();
      $('#checkPassword').html(new_password == new_password_again 
        ? "<span class='text-success'>รหัสผ่านใหม่ตรงกัน</span>" 
        : "<span class='text-danger'>รหัสผ่านใหม่ไม่ตรงกัน</span>");
    });

    // Enable Password Match
    $('#new_password_again').keyup(function(){
      //alert("Hello! I am an alert box!!");
      var new_password  = $('#new_password').val();
      var new_password_again = $('#new_password_again').val();
      if (new_password !== new_password_again ){
         $('#btnUpdate').attr('disabled', true);
      } else {
         $('#btnUpdate').removeAttr('disabled');
      }
    }); });
  </script>
</body>
</html>
