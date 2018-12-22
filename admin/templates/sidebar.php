<div class="list-group list-group-flush col-md-3">
    <li class="list-group-item list-group-item-info">
        <center>QUẢN TRỊ VIÊN</center>  
    </li>
    <ul class="list-group-item">
        <div class="media">
            <a class="pull-left">
                <img class="media-object"src="
                <?php
                        // URL ảnh đại diện tài khoản
                if ($data_user['URL_AVATAR'] == '') {
                    echo $_DOMAIN . 'images/profile.png';
                } else {
                    echo 'http://localhost/tutory-admin/' . $data_user['URL_AVATAR'];
                }
                ?>
                " alt="Picture profie of <?php 
                                        echo $data_user['NAME'];
                                        ?>" width="64" height="64">
            </a>
            <div class="media-body">

                <h4 class="media-heading"><?php
                                            echo $data_user['NAME']; ?></h4>
                <sub><i><?php
                        echo $data_user['EMAIL']; ?>
            </i></sub></br></br>
            </div>
        </div>
    </ul>
<a class="list-group-item active" href="<?php echo $_DOMAIN; ?>">
    <span class="glyphicon glyphicon-home"></span> Trang chủ
</a>
<a class="list-group-item " href="<?php echo $_DOMAIN; ?>profile">
    <span class="glyphicon glyphicon-user"></span> Hồ sơ cá nhân
</a>
<a class="list-group-item " href="<?php echo $_DOMAIN; ?>account">
    <span class="glyphicon glyphicon-check"></span> Quản lý tài khoản
</a>
<a class="list-group-item " href="<?php echo $_DOMAIN; ?>course">
    <span class="glyphicon glyphicon-edit"></span> Quản lý khóa học
    <span class="badge badge-primary badge-pill"><?php echo $db->num_rows("SELECT * FROM course WHERE COURSE_STATUS = '0'"); ?></span>
</a>
<a class="list-group-item " href="<?php echo $_DOMAIN; ?>topic">
    <span class="glyphicon glyphicon-tasks"></span> Quản lý bài viết
    <span class="badge badge-primary badge-pill"><?php echo $db->num_rows("SELECT * FROM news WHERE STATUS = '0'"); ?></span>
</a>
<a class="list-group-item " href="<?php echo $_DOMAIN; ?>schedule">
    <span class="glyphicon glyphicon-list-alt"></span> Quản lý thời gian biểu
</a>
<a class="list-group-item " href="<?php echo $_DOMAIN; ?>signout.php" style="color:red">
    <span class="glyphicon glyphicon-off" style="color:red"></span> Đăng xuất
</a>
</div><!-- div.sidebar -->