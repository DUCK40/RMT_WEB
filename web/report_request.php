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

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="stylesheet" href="public/css/custom.css">
  <title>Report Users</title>
  <style>
    body {
      font-family: 'ANGSA';
    }
    table {
      width: 100%;
    }
    table, td {
      border: 1px solid #000;
      border-collapse: collapse;
      text-align: center;
    }
    .text-left {
      text-align: left;
    }
  </style>
</head>
<body>

  <div style="text-align: center">
    <span style="font-size: 2em;">รายงานการขอใช้บริการ</span><br/>
  </div>

  <table>
    <thead>
      <tr>
        <td width="3%">#</td>
        <td>เลขที่บริการ</td>
        <td>ผู้ใช้บริการ</td>
        <td>รายละเอียด</td>
        <td>วันที่แจ้ง</td>
        <td>วันที่เสร็จ</td>
        <td>สถานะ</td>
      </tr>
    </thead>
    <tbody>
      <?php
        $getYear = @$_GET['year'];
        $getMonth = @$_GET['month'];
        $getCat = @$_GET['cat'];
        $getServ = @$_GET['serv'];
        $getStat = @$_GET['stat'];
        $requests = getFilterRequest($getYear,$getMonth,$getCat,$getServ,$getStat,$getUser);
        foreach($requests as $key => $req):
          $date_end = getDateEnd($req['req_id']);
      ?>
      <tr>
        <td><?php echo $key+1 ?></td>
        <td><?php echo $req['req_gen'] ?></td>
        <td class="text-left"><?php echo getUserFullname($req['req_user']) ?></td>
        <td class="text-left"><?php echo $req['req_text'] ?></td>
        <td><?php echo convertDate($req['req_create']) ?></td>
        <td><?php echo ($date_end ? convertDate($date_end) : '-') ?></td>
        <td class="<?php echo colorStatus($req['req_status']) ?>">
          <?php echo getStatusName($req['req_status']) ?>
        </td>
      </tr>
      <?php 
        endforeach; 
        unset($req);
      ?>
    </tbody>
  </table>

</body>
</html>
<?php
  $html = ob_get_contents();
  ob_end_clean();

  require_once 'vendor/autoload.php';

  $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8']);

  $today = date('Ymd');
  $date = date('d/m/Y');
  $time = date('H:i');

  $fileName = "Report_Request_{$today}.pdf";

  $footer = "<span style='font-weight: normal; font-size: 1.3em;'>วันที่ {$date} เวลา {$time} น.</span>";

  $mpdf->WriteHTML($html);

  $mpdf->SetFooter($footer);

  $mpdf->Output();
?>