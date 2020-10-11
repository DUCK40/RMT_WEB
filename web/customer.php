<?php

  ob_start();
  session_start();
  date_default_timezone_set("Asia/Bangkok");
  include_once 'config/connection.php';
  include_once 'config/function.php';

  // $user_level = getUserLevel($_SESSION['user_code']);
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
              <a href="users.php"><i class="fas fa-users"></i></a>
            </li>
            <li class="breadcrumb-item active">
              จัดการข้อมูลลูกค้า
            </li>
          </ol>
        </nav>

        <div class="row justify-content-center">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h5 class="text-center">จัดการข้อมูลลูกค้า</h5>
              </div>
              <div class="card-body">
                <!-- Button -->


                <!-- Table -->
                <div class="row justify-content-center">
                  <div class="col-12">
                    <div class="table-responsive">
                      <table id="data" class="table table-bordered table-hover table-sm">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>ชื่อลูกค้า</th>
                            <th>USERID</th>
                            <th>เบอร์โทรศัพท์</th>
                            <th>สถานะ</th>
                            <?php if($check_level == 99): ?>
                            <th>จัดการ</th>
                            <?php endif ?>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $result = getcustomer();
                            foreach($result as $key => $row):
                          ?>
                          <tr>
                            <td><?php echo $key+1 ?></td>
                            <td class="text-left"><?php echo $row['ct_name'] ?> &nbsp <?php echo $row['ct_lastname'] ?></td>
                            <td class="text-left"><?php echo $row['ct_userid'] ?></td>
                            <td class="text-left"><?php echo $row['ct_phone'] ?></td>
                       
                            <td>
                              <?php echo ($row['ct_status'] == 1
                                ? '<i class="fas fa-check text-success"></i>'
                                : '<i class="fas fa-times-circle text-danger"></i>')
                              ?>
                            </td>
                            <?php if($check_level == 99): ?>
                            <td>
                              <?php echo $row['ct_id'] ?>
                              <a href="?act=edit&id=<?php echo $row['ct_id'] ?>" class="btn btn-info btn-sm">
                                <i class="fas fa-search-plus"></i>
                              </a>
                              <a class="btn btn-danger btn-sm" href="?act=delete&id=<?php echo $row['ct_id'] ?>"
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
                    <a class="btn btn-danger btn-sm btn-block" href="users.php">
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
              <a href="users.php"><i class="fas fa-users"></i></a>
            </li>
            <li class="breadcrumb-item">
              <a href="departments.php"><i class="fas fa-building mr-2"></i></a>
            </li>
            <li class="breadcrumb-item active">
              เพิ่มสาขา
            </li>
          </ol>
        </nav>

        <div class="row justify-content-center">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h5 class="text-center">เพิ่มสาขา</h5>
              </div>
              <div class="card-body">
                <form action="?act=insert" method="POST">
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">ชื่อสาขา</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="dep_name" required>
                    </div>
                  </div>
                  <div class="form-group row justify-content-center">
                    <div class="col-sm-3 pb-2">
                      <button class="btn btn-success btn-sm btn-block" name="btnInsert">
                        <i class="fa fa-check pr-2"></i>ยืนยัน
                      </button>
                    </div>
                    <div class="col-sm-3 pb-2">
                      <a class="btn btn-danger btn-sm btn-block" href="departments.php">
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

            $dep_name = $_POST['dep_name'];
            $dep_create = date('Y-m-d H:i:s');

            $data = [$dep_name,$dep_create];

            $sql = "INSERT INTO ex_department(dep_name,dep_create)
              VALUES(?,?)";
            $stmt = $dbcon->prepare($sql);
            $result = $stmt->execute($data);

            if($result) {
              alertMsg('success','Add Successfully','departments.php');
            } else {
              alertMsg('danger','Error, Please try again.','?act=add');
            }

            $stmt = null;
          endif;

          /*

          Edit Item

          */
          if($act == 'edit'):
            include_once 'inc/alert.php';

            $ct_id = @$_GET['id'];
            $stmt = getcustomer($ct_id);
            $row = $stmt->fetch();
        ?>
        <nav>
          <ol class="breadcrumb bg-white border">
            <li class="breadcrumb-item">
              <a href="index.php"><i class="fas fa-home"></i></a>
            </li>
            <li class="breadcrumb-item">
              <a href="users.php"><i class="fas fa-users"></i></a>
            </li>
            <li class="breadcrumb-item">
              <a href="departments.php"><i class="fas fa-building mr-2"></i></a>
            </li>
            <li class="breadcrumb-item active">
              แก้ไขข้อมูลลูกค้า
            </li>
          </ol>
        </nav>

        <div class="row justify-content-center">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h5 class="text-center">แก้ไขข้อมูลลูกค้า</h5>
              </div>
              <div class="card-body">
                <form action="?act=update" method="POST">
                  <div class="form-group row" style="display: none">
                    <label class="col-sm-4 col-form-label text-md-right">ID</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="ct_id"
                        value="<?php echo $row['ct_id'] ?>" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">ชื่อลูกค้า</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="ct_name"
                        value="<?php echo $row['ct_name'] ?>" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">นามสกุล</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="ct_lastname"
                        value="<?php echo $row['ct_lastname'] ?>" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">เบอร์โทรศัพท์</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="ct_phone"
                        value="<?php echo $row['ct_phone'] ?>" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">สถานะ</label>
                    <div class="form-check form-check-inline">
                      <label class="form-check-label mx-3">
                        <input class="form-check-input" type="radio" name="ct_status" value="1"
                          <?php if($row['ct_status'] == '1') echo 'checked' ?>>เปิดการใช้งาน
                      </label>
                      <label class="form-check-label mx-3">
                        <input class="form-check-input" type="radio" name="ct_status" value="2"
                          <?php if($row['ct_status'] == '2') echo 'checked' ?>>ปิดการใช้งาน
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
                      <a class="btn btn-danger btn-sm btn-block" href="customer.php">
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

            
            $ct_name = $_POST['ct_name'];
            $ct_lastname = $_POST['ct_lastname'];
            $ct_phone = $_POST['ct_phone'];

            $ct_status = $_POST['ct_status'];
            $ct_id = $_POST['ct_id'];

            $data = [$ct_name,$ct_lastname,$ct_phone,$ct_status,$ct_id];

            $sql = "UPDATE ex_customer SET
              ct_name = ?,
              ct_lastname = ?,
               ct_phone = ?,
                ct_status = ?
              WHERE ct_id = ?";
            $stmt = $dbcon->prepare($sql);
            $result = $stmt->execute($data);

            if($result) {
              alertMsg('success','Update Successfully','customer.php');
            } else {
              alertMsg('danger','Error, Please try again.',"?act=edit&id={$dep_id}");
            }

            $stmt = null;
          endif;

          /*

          Delete Item

          */

          if($act == 'delete'):
            $dep_id = @$_GET['id'];
            $dep_status = 2;

            $data = [$dep_status,$dep_id];

            $sql = "UPDATE ex_customer SET
             ct_status = ?
              WHERE ct_id = ?";
            $stmt = $dbcon->prepare($sql);
            $result = $stmt->execute($data);

            if($result) {
              alertMsg('success','Disable Successfully','customer.php');
            } else {
              alertMsg('danger','Error, Please try again.','customer.php');
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
    });
  </script>
</body>
</html>
