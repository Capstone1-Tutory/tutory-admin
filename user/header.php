<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.5.0/css/all.css' integrity='sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU' crossorigin='anonymous'>
  <link rel="stylesheet" type="text/css" href="../static/vendor/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../static/css/css.css">

  <title></title>
  <link rel="stylesheet" href="">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
      <div class="container">
        <a class="navbar-brand" id="logo" href="#">Tutory</a>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            
            <li class="nav-item">
              <label class="progress-bar" id="lbname" name="lbname" text="lablename">Chào: <?php echo $_SESSION['login_username'];?></label>
            </li>
            <li class="nav-item ">
              <button type="button" id="btndangnhapN" class="btn btn-primary" data-toggle="modal" data-target="#modallogin"><span class="fas fa-sign-in-alt"></span>Đăng Nhập</button>
            </li>
            <li class="nav-item ">
              <button type="button" class="btn btn-primary" id="btndangkiN" data-toggle="modal" data-target="#modalregister"><span class="  fa fa-edit"></span>Đăng Kí</button>
            </li>
            
        <li class="nav-item dropdown"id="btndangxuatN">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="layout/profile.php"><span class='fas fa-user-alt' style="margin-right: 5px"></span>Xem Thông Tin</a>
            
          <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalchangepassword"><span class="fas fa-key" style="margin-right: 5px"></span> Đổi Mật Khẩu</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="module/login/xulylogout.php" style="color:red"><span class="fas fa-sign-out-alt" style="margin-right: 5px; "></span>Đăng Xuất</a>
        </div>
      </li>


            <?php
             if(!isset($_SESSION['login_username']))
             {
            ?>
                 <style type="text/css" media="screen">
                   #btndangnhapN
                   {
                    display:block;
                   }
                   #btndangxuatN
                   {
                    display:none;
                   }
                   #btndangkiN
                   {
                    display: block;
                   }
                   #lbname
                   {
                    display: none;
                   }
                 </style>
              <?php
              }
                else
                {
              ?>
                <style type="text/css" media="screen">
                   #btndangnhapN
                   {
                    display:none;
                   }
                   #btndangxuatN
                   {
                    display: block;
                   }
                   #btndangkiN
                   {
                    display: none;
                   }
                   #lbname
                   {
                    display: block;
                   }
                 </style>
            <?php 
                }
             
            ?>
          </ul>
        </div>
      </div>
    </nav > 
  <!--Modal Login-->  
  <div class="modal face" id="modallogin" role="login">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title">Đăng Nhập </h4>
        </div>
        <div class="modal-body">
          <div class="input-group">
                
               <input id="txtL_username" type="text" class="form-control" placeholder="user name" required>
          </div>
          <div class="input-group">
              
               <input id="txtL_password" type="password" class="form-control" placeholder="Password" required>
           </div>
           <p id="response" style="color:red"></p>
        </div> 
        <div class="modal-footer">
           <button type="submit" name="btndangnhap" id="btndangnhap" class="btn btn-primary"><span class="fas fa-sign-in-alt"></span> Đăng Nhập</button>
           <button type="button" class="btn" style="color: red" data-dismiss="modal"><i class="fas fa-undo"></i>Thoát</button>
        </div>
     </div>
   </div>
 </div>
 <!-- modal change password-->

 <div class="modal face" id="modalchangepassword" role="changepassword">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title">Thay đổi mật khẩu </h4>
        </div>
        <div class="modal-body">
          <div class="input-group">
               <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
               <input id="txtC_pass" type="password" class="form-control" placeholder="mật khẩu củ...." required>
          </div>
          <div class="input-group">
               <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
               <input id="txtC_passnew" type="password" class="form-control" placeholder="mật khẩu mới....">
           </div>
           <div class="input-group">
               <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
               <input id="txtC_enterpassnew" type="password" class="form-control" placeholder="nhập lại mật khẩu mới.....">
           </div>
           <p id="C_response" style="color:red"></p>
        </div> 
        <div class="modal-footer">
           <button type="submit" id="btndoimatkhau" class="btn btn-primary"><i class="fas fa-lock"></i>OK</button>
           <button type="button" class="btn" data-dismiss="modal" style="color: red" ><i class="fas fa-undo"></i>Thoát</button>
        </div>
     </div>
   </div>
 </div>
 <!--Modal đăng kí-->
  <div class="modal face" id="modalregister" role="register">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"> Đăng Kí</h4>
      </div>
      <div class="modal-body">
         <div class="input-group">

            <label class="control-label col-sm-4" for="email">Tên Đăng Nhập:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="Re_username" placeholder="UserName">
              <p id="ERusername" style="color:red"></p>
            </div>
         </div>
        <div class="input-group">
            <label class="control-label col-sm-4" for="email">Mật Khẩu:</label>
            <div class="col-sm-10">
              <input type="password" class="form-control" id="Re_password" placeholder="Password">
              <p id="ERpassword" tyle="color:red"></p>
          </div>
         </div>
         <div class="input-group">
            <label class="control-label col-sm-5" for="Re_enterpassword">Nhập Lại Mật Khẩu:</label>
            <div class="col-sm-10">
              <input type="password" class="form-control" id="Re_enterpassword" placeholder="Enter Password">
              <p id="ERenterpassword" tyle="color:red"></p>
            </div>
         </div>
         <p id="RE_response" style="color:red; text-align:center;"></p>
      </div> 
     
      <div class="modal-footer">
        <button  type="button" id="btndangki" name="btndangki"class="btn btn-primary" ><i class=" fa fa-edit"></i>Đăng Kí</button>
        <button type="button" class="btn" data-dismiss="modal" style="color: red"><i class="fas fa-undo"></i>Thoát</button>
      </div>
    </div>
 </div>   
</div>

</body>
<script src="../static/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="../static/vendor/jquery/jquery.min.js"></script>

<!--scrip login-->
<script>
  $(document).ready(function() {
    
    $("#btndangnhap").click(function() {
      var user= $("#txtL_username").val();
      var pass=$("#txtL_password").val();
      
      $.post("module/login/xulylogin.php", {myusername:user, mypassword:pass}, function(data) {        
          if(data==0)
          {
            $("#response").html("**Tên đăng nhập hoặc mật khẩu không đúng");
          }  
          else
          {
              window.location.href='index.php';
          }
      });
    });
  });
</script>

</script>

<script type="text/javascript">
   
  $(document).ready(function() {
    $("#btndangki").click(function() {
      var user=$("#Re_username").val();
      var pass=$("#Re_password").val();
      var epass=$("#Re_enterpassword").val();
      var nameRegex = /^[A-Za-z][0-9_\.]{6,32}$/;
      var passRegex=/^([A-Za-z0-9])([\w_\.!@#$%^&*()]+){5,31}$/;
      if(user==""||pass==""||epass=="")
      {
        $("#RE_response").html("Vui lòng nhập đầy đủ thông tin");
      }
      else
        if (!user.match(nameRegex)) {
            $("#RE_response").html("Tên đăng nhập không đúng định dạng <br>Phải bắt đầu bằng chữ từ 6-32 kí tự");
        }
        else
          if (!pass.match(passRegex)) {
            $("#RE_response").html("Mật khẩu không đúng định dạng <br>Mật khẩu bao gồm các ký chữ cái, chữ số, ký tự đặc biệt, dấu chấm <br>Độ dài 6-32 ký tự");
          }
          else
        if (pass!=epass) {
           $("#RE_response").html("Xác nhận mật khẩu không đúng");
        }
      else
      {
       $.post("module/login/xulydangki.php",{username:user, password:pass,enterpassword:epass}, function(data) {
         /*optional stuff to do after success */
         $("#RE_response").html(data);
       });
     }
    });
  });
</script>
<script type="text/javascript">
  
  $(document).ready(function() {

    $("#btndoimatkhau").click(function(event) {
      var passold= $("#txtC_pass").val();
      var passnew=$("#txtC_passnew").val();
      var passRegex=/^([A-Za-z0-9])([\w_\.!@#$%^&*()]+){5,31}$/;
      var enterpassnew =$("#txtC_enterpassnew").val();
      if(!passnew.match(passRegex))
      {
        $("#C_response").html("Mật khẩu không đúng định dạng <br>Mật khẩu bao gồm các ký chữ cái, chữ số, ký tự đặc biệt, dấu chấm <br>Độ dài 6-32 ký tự");
      }else
      if(passnew!=enterpassnew)
      {
        $("#C_response").html("Mật khẩu không trùng khớp");
      }
      else
      {
        $.get('module/login/doimk.php',{ollpass:passold, newpass:passnew},function(data) {
          
          $("#C_response").html(data);
        });
      }
    });
  });
</script>


</html>



 

