<?php
  ob_start();
  session_start();
  date_default_timezone_set("Asia/Bangkok");
  include_once 'config/connection.php';
  include_once 'config/function.php';

  $user_level = getUserLevel($_SESSION['user_code']);
  // if(!isset($_SESSION['user_code']) || ($user_level == 1 || empty($user_level))){
  //   alertMsg('danger','ไม่พบหน้านี้ในระบบ','request.php');
  // }

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
              ตรวจสอบข้อมูลอะไหล่
            </li>
          </ol>
        </nav>

        <div class="row justify-content-center">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h5 class="text-center">ตรวจสอบข้อมูลอะไหล่</h5>
              </div>
              <div class="card-body " >
                <!-- Button -->

                <!-- ค้นหา -->

                <?php if($check_level == 99): ?>
                <div class="card-body col-3" >
                <select id="selectB" class="form-control form-control-sm" name="txtPermission2ShowStatus">

                  <option value="">--- กรุณาเลือก ---</option>


                 <?php
                   $stmt = getDepartment();
                    $result = $stmt->fetchAll();

                   foreach($result as $user):
                      $name = ucfirst($user['dep_name']);
                      echo "<option value='{$user['dep_name']}'>{$name}</option>";
                    endforeach;

                 ?>
                </select>
              </div>
              <?php endif ?>


                <!-- Table -->
                <div class="row justify-content-center">
                  <div class="col-12">
                    <div class="table-responsive">
                      <table id="data2" class="table table-bordered table-hover table-sm">
                        <thead>
                          <tr>
                            <th>ลำดับ</th>
                            <th>ชื่ออะไหล่</th>
                            <th>จำนวน</th>
                            <th>สาขา</th>




                          </tr>
                        </thead>
                        <?php if($check_level == 69): ?>
                        <tbody>
                          <?php
                            $result = getInproduct();
                            foreach($result as $key => $row):
                          ?>
                          <tr>
                            <td><?php echo $key+1 ?></td>
                            <td class="text-left"><?php echo $row['sw_name'] ?></td>
                            <td class="text-left"><?php echo $row['part_d_sec_use'] ?></td>
                            <td class="text-left"><?php echo $row['dep_name'] ?></td>


                          </tr>
                          <?php
                            endforeach;
                            unset($row);
                          ?>
                        </tbody>
                        <?php endif ?>

                        <?php if($check_level == 99): ?>
                        <tbody>
                          <?php
                            $result = getInproduct1();
                            foreach($result as $key => $row):
                          ?>
                          <tr>
                            <td><?php echo $key+1 ?></td>
                            <td class="text-left"><?php echo $row['sw_name'] ?></td>
                            <td class="text-left"><?php echo $row['part_d_sec_use'] ?></td>
                            <td class="text-left"><?php echo $row['dep_name'] ?></td>


                          </tr>
                          <?php
                            endforeach;
                            unset($row);
                          ?>
                        </tbody>
                        <?php endif ?>


                      </table>
                    </div>
                  </div>
                  <div class="col-sm-3 pb-2">
                    <a class="btn btn-danger btn-sm btn-block" href="manage1.php">
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
              เพิ่มอะไหล่ในคลัง
            </li>
          </ol>
        </nav>

        <div class="row justify-content-center">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h5 class="text-center">เพิ่มอะไหล่ในคลัง</h5>
              </div>
              <div class="card-body">
                <form action="?act=insert" method="POST">
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">ขนาดยาง</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="sw_name" required>
                    </div>
                  </div>
                  <div class="form-group row justify-content-center">
                    <div class="col-sm-3 pb-2">
                      <button class="btn btn-success btn-sm btn-block" name="btnInsert">
                        <i class="fa fa-check pr-2"></i>ยืนยัน
                      </button>
                    </div>
                    <div class="col-sm-3 pb-2">
                      <a class="btn btn-danger btn-sm btn-block" href="software.php">
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

            $sw_name = $_POST['sw_name'];
            $sw_create = date('Y-m-d H:i:s');

            $data = [$sw_name,$sw_create];

            $sql = "INSERT INTO ex_software(sw_name,sw_create)
              VALUES(?,?)";
            $stmt = $dbcon->prepare($sql);
            $result = $stmt->execute($data);

            if($result) {
              alertMsg('success','เพิ่มข้อมูลเรียบร้อยแล้วครับ','software.php');
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
            $stmt = getQuerySoftware($sw_id);
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
              แก้ไขข้อมูลอะไหล่
            </li>
          </ol>
        </nav>

        <div class="row justify-content-center">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h5 class="text-center">แก้ไขข้อมูลอะไหล่</h5>
              </div>
              <div class="card-body">
                <form action="?act=update" method="POST">
                  <div class="form-group row" style="display: none">
                    <label class="col-sm-4 col-form-label text-md-right">ID</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="sw_id"
                        value="<?php echo $row['sw_id'] ?>" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">ชื่อ</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="sw_name"
                        value="<?php echo $row['sw_name'] ?>" required>
                    </div>
                  </div>

                  <!--ทดลอง textbox 2-->


                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">ประเภทอะไหล่</label>
                    <div class="form-check form-check-inline">
                      <label class="form-check-label mx-3">
                        <input class="form-check-input" type="radio" name="sw_type" value="ประเภทยางหน้า"
                          <?php if($row['sw_type'] == '1') echo 'checked' ?>>ประเภทยางหน้า
                      </label>
                      <label class="form-check-label mx-3">
                        <input class="form-check-input" type="radio" name="sw_type" value="ประเภทยางหลัง"
                          <?php if($row['sw_type'] == '2') echo 'checked' ?>>ประเภทยางหลัง
                      </label>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">สถานะ</label>
                    <div class="form-check form-check-inline">
                      <label class="form-check-label mx-3">
                        <input class="form-check-input" type="radio" name="sw_status" value="1"
                          <?php if($row['sw_status'] == '1') echo 'checked' ?>>เปิดการใช้งาน
                      </label>
                      <label class="form-check-label mx-3">
                        <input class="form-check-input" type="radio" name="sw_status" value="2"
                          <?php if($row['sw_status'] == '2') echo 'checked' ?>>ปิดการใช้งาน
                      </label>
                    </div>
                  </div>
                  <div class="form-group row justify-content-center">
                    <div class="col-sm-3 pb-2">
                      <button class="btn btn-success btn-sm btn-block" name="btnUpdate">
                        <i class="fa fa-check pr-2"></i>ยืนยัน
                      </button>
                    </div>
                    <div class="col-sm-3 pb-2">
                      <a class="btn btn-danger btn-sm btn-block" href="software.php">
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

          if($act == 'update'):
            if(!isset($_POST['btnUpdate'])){
              header('location: index.php');
              die();
            }

            $sw_id = $_POST['sw_id'];
            $sw_name = $_POST['sw_name'];
            $sw_status = $_POST['sw_status'];
            $sw_type = $_POST['sw_type'];

            $data = [$sw_name,$sw_status,$sw_type,$sw_id];

            $sql = "UPDATE ex_software SET
              sw_name = ?,
              sw_status = ?,
              sw_type = ?
              WHERE sw_id = ?";
            $stmt = $dbcon->prepare($sql);
            $result = $stmt->execute($data);

            if($result) {
              alertMsg('success','แก้ไขข้อมูลเรียบร้อยแล้วครับ','software.php');
            } else {
              alertMsg('danger','ระบบมีปัญหา, กรุณาลองใหม่อีกครั้งครับ',"?act=edit&id={$sw_id}");
            }

            $stmt = null;
          endif;

          /*

          Delete Item

          */

          if($act == 'delete'):
            $sw_id = @$_GET['id'];
            $sw_status = 2;

            $data = [$sw_status,$sw_id,$sw_type];

            $sql = "UPDATE ex_software SET
              sw_status = ?,
              sw_type = ?
              WHERE sw_id = ?";
            $stmt = $dbcon->prepare($sql);
            $result = $stmt->execute($data);

            if($result) {
              alertMsg('success','ปิดการใช้งานเรียบร้อยแล้วครับ','software.php');
            } else {
              alertMsg('danger','ระบบมีปัญหา, กรุณาลองใหม่อีกครั้งครับ','software.php');
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


      $('#data2').DataTable({
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

      var tablePermission2Master = $('#data2').DataTable();

      $('#selectB').on( 'change', function () {
            tablePermission2Master
                .columns( 3 )
                .search( this.value )
                .draw();
        });
    });


  </script>
</body>
</html>
