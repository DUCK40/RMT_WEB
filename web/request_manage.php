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
  <link rel="stylesheet" href="node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
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

            $req_id = @$_GET['id'];
            $stmt = getQueryRequest($req_id);
            $row = $stmt->fetch();
        ?>
        <nav>
          <ol class="breadcrumb bg-white border">
            <li class="breadcrumb-item">
              <a href="request.php"><i class="fas fa-home"></i></a>
            </li>
            <li class="breadcrumb-item active">
              รายละเอียดการขอใช้บริการ
            </li>
          </ol>
        </nav>

        <div class="row justify-content-center">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h5 class="text-center">รายละเอียดการขอใช้บริการ</h5>
              </div>
              <div class="card-body">
                <form action="?act=update" method="POST" enctype="multipart/form-data">
                  <div class="form-group row" style="display: none">
                    <label class="col-sm-4 col-form-label text-md-right">รหัสผู้ใช้บริการ</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" name="req_id" readonly
                        value="<?php echo $row['req_id'] ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">เลขที่บริการ</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" name="req_gen" readonly
                        value="<?php echo $row['req_gen'] ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">ผู้ใช้บริการ</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" readonly
                        value="<?php echo getUserFullname($row['req_user']) ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">บริการ</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" value="<?php echo getServiceName($row['service_id']) ?>" readonly>
                    </div>
                  </div>
                  <?php
                    $req_file = $row['req_file'];
                    $file_ext = pathinfo($req_file, PATHINFO_EXTENSION);

                    if(!empty($req_file)):
                      if($file_ext == 'jpg' || $file_ext == 'jpeg' || $file_ext == 'png'){
                  ?>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">รูปประกอบ</label>
                    <div class="col-sm-3">
                      <a href="public/request/<?php echo $row['req_file'] ?>" target="_blank">
                        <img src="public/request/<?php echo $row['req_file'] ?>" class="img-fluid">
                      </a>
                    </div>
                  </div>
                  <?php } else { ?>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">เอกสารประกอบ</label>
                    <div class="col-sm-4">
                      <a href="public/request/<?php echo $row['req_file'] ?>" target="_blank">
                        <?php echo $row['req_file'] ?>
                      </a>
                    </div>
                  </div>
                  <?php 
                      }
                    endif; 

                    if($row['req_status'] == 1 || $row['req_status'] == 2):
                  ?>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">
                      <?php echo !empty($req_file) ? 'เปลี่ยนเอกสารหรือรูปประกอบ' : 'เพิ่มเอกสารหรือรูปประกอบ' ?>
                    </label>
                    <div class="col-sm-4">
                      <input type="file" class="form-control" name="req_file">
                    </div>
                  </div>
                  <?php endif; ?>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">รายละเอียดเพิ่มเติม</label>
                    <div class="col-sm-6">
                      <textarea name="req_text" class="form-control" rows="5" <?php echo ($row['req_status'] == 1 || $row['req_status'] == 2) ? 'required' : 'readonly' ?>><?php echo $row['req_text'] ?></textarea>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">วันที่ใช้บริการ</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" value="<?php echo convertDate($row['req_create']) ?>" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">สถานะ</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" value="<?php echo getStatusName($row['req_status']) ?>" readonly>
                    </div>
                  </div>
                  <?php
                    $stmt = getQueryManage($row['req_id']);
                    $manages = $stmt->fetchAll();
                    if($manages):
                  ?>
                  <div class="form-group row">
                    <span class="text-primary">การดำเนินการ</span>
                    <div class="table-responsive w-100">
                      <table class="table table-bordered table-hover table-sm">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>วันที่รับเรื่อง</th>
                            <th>รายละเอียด</th>
                            <th>วันที่แล้วเสร็จ</th>
                            <th>ผู้ดำเนินการ</th>
                            <th>ไฟล์เอกสาร</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            foreach($manages as $key => $manage):
                          ?>
                          <tr>
                            <td><?php echo $key+1 ?></td>
                            <td><?php echo convertDate($manage['manage_date_start']) ?></td>
                            <td class="text-left"><?php echo $manage['manage_text'] ?></td>
                            <td><?php echo convertDate($manage['manage_date_end']) ?></td>
                            <td><?php echo getUserFullname($manage['manage_user']) ?></td>
                            <td>
                              <?php if($manage['manage_file']) { ?>
                              <a href="public/manage/<?php echo $manage['manage_file'] ?>" target="_blank">
                                <?php echo $manage['manage_file'] ?>
                              </a>
                              <?php } else { echo '-'; } ?>
                            </td>

                            
                          </tr>
                          <?php 
                            endforeach; 
                            unset($manage);
                          ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <?php endif; ?>
                  <div class="form-group row justify-content-center">
                    <?php if($row['req_status'] == 1 || $row['req_status'] == 2 || $row['req_status'] == 3): ?>
                    <div class="col-sm-3 pb-2">
                      <button class="btn btn-primary btn-sm btn-block" type="button" data-toggle="modal" data-target="#addManage">
                        <i class="fas fa-plus pr-2"></i>เพิ่มการดำเนินการ
                      </button>
                    </div>
                    <?php
                      endif;

                      if($row['req_status'] == 1 || $row['req_status'] == 2):
                    ?>
                    <div class="col-sm-3 pb-2">
                      <button class="btn btn-success btn-sm btn-block" name="btnUpdate">
                        <i class="fas fa-check pr-2"></i>แก้ไขข้อมูล
                      </button>
                    </div>
                    <?php endif; ?>
                    <div class="col-sm-3 pb-2">
                      <a class="btn btn-danger btn-sm btn-block" href="manage.php">
                        <i class="fas fa-arrow-left pr-2"></i>กลับหน้าหลัก
                      </a>
                    </div>
                    <div class="col-sm-3 pb-2">
                      <a class="btn btn-info btn-sm btn-block" href="print.php?id=<?php echo $row['req_id'] ?>">
                        <i class="fa fa-print pr-2"></i>พิมพ์เอกสาร
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

          Update Item

          */
          if($act == 'update'):
            if(!isset($_POST['btnUpdate'])){
              header('Location: index.php');
              die();
            }

            $req_id = $_POST['req_id'];
            $req_gen = $_POST['req_gen'];
            $req_file = $_FILES['req_file']['name'];
            $req_text = $_POST['req_text'];

            $data = [$req_text,$req_id];

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

            $sql = "UPDATE ex_request SET
              req_text = ?
              WHERE req_id = ?";
            $stmt = $dbcon->prepare($sql);
            $result = $stmt->execute($data);

            // Update Picture
            if($req_file):
              $data_old_picture = [$req_id];
              $sql = "SELECT req_file FROM ex_request WHERE req_id = ?";
              $stmt   = $dbcon->prepare($sql);
              $stmt->execute($data_old_picture);
              $check_picture_old  = $stmt->fetch();
              @unlink("public/request/".$check_picture_old['req_file']);

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
                
              $data_picture = [$file_new_name,$req_id];

              $sql = "UPDATE ex_manage SET
                req_file = ?
                WHERE req_id = ?";
              $stmt = $dbcon->prepare($sql);
              $stmt->execute($data_picture);
            endif;

            if($result) {
              alertMsg('success','แก้ไขข้อมูลเรียบร้อยแล้วครับ',"?id={$req_id}");
            } else {
              alertMsg('danger','ระบบมีปัญหา, กรุณาลองใหม่อีกครั้งครับ',"?id={$req_id}");
            }

            $stmt = null;
          endif;
        ?>

        <!-- Modal Add Manage -->
        <div class="modal fade" id="addManage">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">เพิ่มการดำเนินการ</h5>
              </div>
              <?php
                $req_id = @$_GET['id'];
                $stmt = getQueryRequest($req_id);
                $row = $stmt->fetch();
              ?>
              <div class="modal-body">
                <form action="?act=insert" method="POST" enctype="multipart/form-data">
                  <div class="form-group row" style="display: none">
                    <label class="col-sm-4 col-form-label text-md-right">ลำดับบริการ</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="req_id" readonly
                        value="<?php echo $row['req_id'] ?>">
                    </div>
                  </div>
                  <div class="form-group row" style="display: none">
                    <label class="col-sm-4 col-form-label text-md-right">รหัสบริการ</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="req_gen" readonly
                        value="<?php echo $row['req_gen'] ?>">
                    </div>
                  </div>
                  <div class="form-group row" style="display: none">
                    <label class="col-sm-4 col-form-label text-md-right">ผู้ดำเนินการ</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="user_code" readonly
                        value="<?php echo $_SESSION['user_code'] ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">เลขที่บริการ</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="req_gen" readonly
                        value="<?php echo $row['req_gen'] ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">รายละเอียด</label>
                    <div class="col-sm-8">
                      <textarea name="manage_text" class="form-control" rows="3" required></textarea>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">กำหนดแล้วเสร็จ</label>
                    <div class="col-sm-6">
                      <input type="text" class="readonly form-control" name="manage_date_end" id="date_end" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">เอกสาร</label>
                    <div class="col-sm-8">
                      <input type="file" class="form-control" name="manage_file" accept=".xlsx,.xls,.doc,.docx,.pdf">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">สถานะรายการ</label>
                    <div class="col-sm-8">
                      <select name="req_status" class="form-control form-control-sm" required>
                        <option value="">--- กรุณาเลือกสถานะรายการ ---</option>
                        <?php
                          $result = getManageStatus();
                          foreach($result as $status):
                        ?>
                        <option value="<?php echo $status['status_id'] ?>"><?php echo $status['status_name'] ?></option>
                        <?php
                          endforeach;
                          unset($status);
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row justify-content-center">
                    <div class="col-sm-5 mb-2">
                      <button class="btn btn-success btn-sm btn-block" name="btnInsert">
                        <i class="fa fa-check mr-2"></i>ยืนยัน
                      </button>
                    </div>
                    <div class="col-sm-5 mb-2">
                      <button class="btn btn-danger btn-sm btn-block" type="button" data-dismiss="modal">
                        <i class="fas fa-times mr-2"></i>ยกเลิก
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        <?php
          if($act == 'insert'):
            $req_id = $_POST['req_id'];
            $req_gen = $_POST['req_gen'];
            $user_code = $_POST['user_code'];
            $manage_text = $_POST['manage_text'];
            $manage_date_start = date('Y-m-d');
            $manage_date_end = str_replace('/', '-', $_POST['manage_date_end']);
            $conv_date_end = date('Y-m-d', strtotime($manage_date_end));
            $manage_file = $_FILES['manage_file']['name'];
            $req_status = $_POST['req_status'];

            if(empty($req_status)){
              alertMsg('danger','กรุณาเลือกสถานะด้วยครับ',"?id={$req_id}");
            }

            // Check Extension
            if($manage_file){
              $file_name  = $_FILES['manage_file']['name'];
              $file_tmpname  = $_FILES['manage_file']['tmp_name'];
              $ext = pathinfo($file_name, PATHINFO_EXTENSION);
              $file_new_name = $req_gen.'.'.$ext;
              $path_file = "public/manage/";
              $allow_extension = array('xls','xlsx','doc','docx','pdf');

              if(!in_array($ext, $allow_extension)):
                alertMsg('danger','กรุณาเลือกเฉพาะไฟล์เอกสาร Excel Word PDF เท่านั้นครับ',"?id={$req_id}");
              endif;
            }

            $data_manage = [$req_id,$user_code,$manage_text,$manage_date_start,$conv_date_end];
            $data_request = [$req_status,$req_id];

            $sql = "INSERT INTO ex_manage(req_id,manage_user,manage_text,manage_date_start,manage_date_end)
              VALUES(?,?,?,?,?)";
            $stmt = $dbcon->prepare($sql);
            $result = $stmt->execute($data_manage);

            $last_id = $dbcon->lastInsertId();

            $sql = "UPDATE ex_request SET
              req_status = ?
              WHERE req_id = ?";
            $stmt = $dbcon->prepare($sql);
            $stmt->execute($data_request);

            if($manage_file){
              @move_uploaded_file($file_tmpname, iconv('UTF-8','TIS-620', $path_file.$file_new_name));

              $data_picture = [$file_new_name,$last_id];

              $sql = "UPDATE ex_manage SET
                manage_file = ?
                WHERE manage_id = ?";
              $stmt = $dbcon->prepare($sql);
              $stmt->execute($data_picture);
            }

            if($result) {
              alertMsg('success','เพิ่มข้อมูลเรียบร้อยแล้วครับ','manage.php');
            } else {
              alertMsg('danger','ระบบมีปัญหา, กรุณาลองใหม่อีกครั้งครับ',"?id={$req_id}");
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
  <script src="node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <script src="node_modules/bootstrap-datepicker/dist/locales/bootstrap-datepicker.th.min.js"></script>
  <script src="public/js/main.min.js"></script>
  <script>
    $('#date_end').datepicker({
      format: 'dd/mm/yyyy',
      language: 'th',
      todayHighlight: true,
      startDate: new Date(),
      daysOfWeekDisabled: [0,6]
    });

    $(".readonly").keydown(function(e){
      e.preventDefault();
    });
  </script>
</body>
</html>