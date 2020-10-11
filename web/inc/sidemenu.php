<nav class="col-xl-2 col-md-3 d-none d-md-block sidebar">
  <div class="sidebar-sticky">
    <ul class="nav flex-column">
      <li class="nav-item">
        <img class="nav-link img-fluid picture-profile mx-auto d-block"
          src="public/images/users/<?php echo getUserPicture($_SESSION['user_code']) ?>" alt="">
      </li>
      <li class="nav-item">
        <h4 class="nav-link text-center">
          <?php echo getUserNickname($_SESSION['user_code']) ?>
        </h4>
      </li>
      <?php
        $request = strpos($_SERVER['PHP_SELF'], "request.php");
        $view = strpos($_SERVER['PHP_SELF'], "view.php");
        $manage = strpos($_SERVER['PHP_SELF'], "manage.php");
        $category = strpos($_SERVER['PHP_SELF'], "category.php");
        $service = strpos($_SERVER['PHP_SELF'], "service.php");
        $status = strpos($_SERVER['PHP_SELF'], "status.php");
        $dashboard = strpos($_SERVER['PHP_SELF'], "dashboard.php");
        $profile = strpos($_SERVER['PHP_SELF'], "profile.php");
        $chgpwd = strpos($_SERVER['PHP_SELF'], "change_pwd.php");
        $departments = strpos($_SERVER['PHP_SELF'], "departments.php");
        $log = strpos($_SERVER['PHP_SELF'], "log.php");
        $users = strpos($_SERVER['PHP_SELF'], "users.php");
        $computers = strpos($_SERVER['PHP_SELF'], "computers.php");
        $software = strpos($_SERVER['PHP_SELF'], "software.php");
        $system = strpos($_SERVER['PHP_SELF'], "system.php");
        $check_level = getUserLevel($_SESSION['user_code']);
      ?>
      <?php if($check_level == 1 || $check_level == 1): ?>
        <li class="nav-item">
          <a class="nav-link" data-toggle="collapse" href="#sub_dashboard2">
            <i class="fas fa-box px-2"></i>
             จัดการข้อมูลอะไหล่
            <i class="fas fa-angle-<?php echo ($profile || $chgpwd ? 'down' : 'left') ?> px-3"></i>
          </a>
          <div id="sub_dashboard2" class="collapse <?php if($profile || $chgpwd) echo ''; ?>">
            <ul class="nav flex-column">
              <li class="nav-item <?php if($profile) echo 'active' ?>">
                <a class="nav-link sub-menu" href="Manageparts.php">
                  <small>
                    <i class="fas fa-clipboard-check px-2"></i>
                    ตรวจสอบคลังอะไหล่
                  </small>
                </a>
              </li>
              <li class="nav-item <?php if($chgpwd) echo 'active' ?>">
                <a class="nav-link sub-menu" href="software.php">
                  <small>
                    <i class="fas fa-list px-2"></i>
                    จัดการข้อมูลอะไหล่
                  </small>
                </a>
              </li>

              <!-- <li class="nav-item <?php if($chgpwd) echo 'active' ?>">
                   <a class="nav-link sub-menu" href="change_pwd.php">
                     <small>
                       <i class="fas fa-th px-2"></i>
                       จัดการข้อมูลประเภทอะไหล่
                     </small>
                   </a>
                 </li>  -->


            </ul>
          </div>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#sub_dashboard">
              <i class="fas fa-users px-2"></i>
              จัดการข้อมูลผู้ใช้
              <i class="fas fa-angle-<?php echo ($profile || $chgpwd ? 'down' : 'left') ?> px-3"></i>
            </a>
            <div id="sub_dashboard" class="collapse <?php if($profile || $chgpwd) echo ''; ?>">
              <ul class="nav flex-column">
                <li class="nav-item <?php if($profile) echo 'active' ?>">
                  <a class="nav-link sub-menu" href="users.php">
                    <small>
                      <i class="fas fa-user px-2"></i>
                      จัดการข้อมูลบุคคล
                    </small>
                  </a>
                </li>

              



                <li class="nav-item <?php if($chgpwd) echo 'active' ?>">
                  <a class="nav-link sub-menu" href="customer.php">
                    <small>
                      <i class="fas fa-user-circle px-2"></i>
                      จัดการข้อมูลลูกค้า
                    </small>
                  </a>
                </li>
                <li class="nav-item <?php if($chgpwd) echo 'active' ?>">
                  <a class="nav-link sub-menu" href="departments.php">
                    <small>
                      <i class="fas fa-city px-2"></i>
                      จัดการข้อมูลสาขา
                    </small>
                  </a>
                </li>
              </ul>
            </div>
          </li>
        </li>

        <li class="nav-item <?php if($computers || $software) echo 'active' ?>">
          <a class="nav-link" href="profile.php">
            <i class="fas fa-user-cog px-2"></i>
            จัดการข้อมูลส่วนตัว
          </a>
        </li>
        <li class="nav-item <?php if($computers || $software) echo 'active' ?>">
          <a class="nav-link" href="log.php">
            <i class="fas fa-scroll px-2"></i>
            log
          </a>
        </li>
        <li class="nav-item <?php if($computers || $software) echo 'active' ?>">
          <a class="nav-link" href="change_pwd.php">
            <i class="fas fa-cogs px-2"></i>
            เปลี่ยนรหัสผ่าน
          </a>
        </li>
        <li class="nav-item <?php if($computers || $software) echo 'active' ?>">
          <a class="nav-link" href="logout.php">
            <i class="fas fa-sign-out-alt px-2"></i>
            ออกจากระบบ
          </a>
        </li>
      <?php endif ?>


      <?php if($check_level == 69 || $check_level == 99): ?>

        <li class="nav-item">

          <li class="nav-item <?php if($computers || $software) echo 'active' ?>">
            <a class="nav-link" href="manage1.php">
              <i class="fas fa-user-cog px-2"></i>
              รายการการแจ้งซ่อม
            </a>
          </li>


          <a class="nav-link" data-toggle="collapse" href="#sub_dashboard2">
            <i class="fas fa-box px-2"></i>
             จัดการข้อมูลอะไหล่
            <i class="fas fa-angle-<?php echo ($profile || $chgpwd ? 'down' : 'left') ?> px-3"></i>
          </a>
          <div id="sub_dashboard2" class="collapse <?php if($profile || $chgpwd) echo ''; ?>">
            <ul class="nav flex-column">
              <li class="nav-item <?php if($profile) echo 'active' ?>">
                <a class="nav-link sub-menu" href="Manageparts.php">
                  <small>
                    <i class="fas fa-clipboard-check px-2"></i>
                    ตรวจสอบคลังอะไหล่
                  </small>
                </a>
              </li>
              <li class="nav-item <?php if($chgpwd) echo 'active' ?>">
                <a class="nav-link sub-menu" href="software.php">
                  <small>
                    <i class="fas fa-list px-2"></i>
                    จัดการข้อมูลอะไหล่
                  </small>
                </a>
              </li>

              <!-- <li class="nav-item <?php if($chgpwd) echo 'active' ?>">
                   <a class="nav-link sub-menu" href="change_pwd.php">
                     <small>
                       <i class="fas fa-th px-2"></i>
                       จัดการข้อมูลประเภทอะไหล่
                     </small>
                   </a>
                 </li>  -->

              <li class="nav-item <?php if($chgpwd) echo 'active' ?>">
                <a class="nav-link sub-menu" href="addparts1.php">
                  <small>
                    <i class="fas fa-plus-square px-2"></i>
                    เติมอะไหลในคลัง
                  </small>
                </a>
              </li>
            </ul>
          </div>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#sub_dashboard">
              <i class="fas fa-users px-2"></i>
              จัดการข้อมูลผู้ใช้
              <i class="fas fa-angle-<?php echo ($profile || $chgpwd ? 'down' : 'left') ?> px-3"></i>
            </a>
            <div id="sub_dashboard" class="collapse <?php if($profile || $chgpwd) echo ''; ?>">
              <ul class="nav flex-column">


           

                <?php if( $check_level == 69): ?>


                <li class="nav-item <?php if($profile) echo 'active' ?>">
                <a class="nav-link sub-menu" href="addtechnicain.php">
                  <small>
                    <i class="fas fa-user px-2"></i>
                    เพิ่มข้อมูลช่าง
                  </small>
                </a>
              </li>
<?php endif ?>



                <li class="nav-item <?php if($profile) echo 'active' ?>">
                  <a class="nav-link sub-menu" href="users.php">
                    <small>
                      <i class="fas fa-user px-2"></i>
                      จัดการข้อมูลบุคคล
                    </small>
                  </a>
                </li>

             



                <li class="nav-item <?php if($chgpwd) echo 'active' ?>">
                  <a class="nav-link sub-menu" href="customer.php">
                    <small>
                      <i class="fas fa-user-circle px-2"></i>
                      จัดการข้อมูลลูกค้า
                    </small>
                  </a>
                </li>
                <?php if($check_level == 69 || $check_level == 99): ?>

                <li class="nav-item <?php if($chgpwd) echo 'active' ?>">
                  <a class="nav-link sub-menu" href="departments.php">
                    <small>
                      <i class="fas fa-city px-2"></i>
                      จัดการข้อมูลสาขา
                    </small>
                  </a>
                </li>
              <?php endif ?>

              </ul>
            </div>
          </li>
        </li>

        <li class="nav-item <?php if($computers || $software) echo 'active' ?>">
          <a class="nav-link" href="profile.php">
            <i class="fas fa-user-cog px-2"></i>
            จัดการข้อมูลส่วนตัว
          </a>
        </li>
        <li class="nav-item <?php if($computers || $software) echo 'active' ?>">
          <a class="nav-link" href="log.php">
            <i class="fas fa-scroll px-2"></i>
            log
          </a>
        </li>
        <li class="nav-item <?php if($computers || $software) echo 'active' ?>">
          <a class="nav-link" href="change_pwd.php">
            <i class="fas fa-cogs px-2"></i>
            เปลี่ยนรหัสผ่าน
          </a>
        </li>
        <li class="nav-item <?php if($computers || $software) echo 'active' ?>">
          <a class="nav-link" href="logout.php">
            <i class="fas fa-sign-out-alt px-2"></i>
            ออกจากระบบ
          </a>
        </li>
      <?php
        endif;
        if($check_level == 99):
      ?>
      <?php endif; ?>


    </ul>
  </div>
</nav>
