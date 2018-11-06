<?php
session_start();
?>
<link rel="stylesheet" type="text/css" href="../static/vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../static/css/css.css">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
      <div class="container">
        <a class="navbar-brand" id="logo" href="#">Tutory</a>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            
            <li class="nav-item">
              <label class="progress-bar" id="lbname" name="lbname" text="lablename">Chào: <?php echo $_SESSION['login_username'];?></label>
            </li>
            <li class="nav-item ">
              <button type="button" id="btndangnhapN" class="btn btn-primary" data-toggle="modal" data-target="#modallogin">Đăng Nhập</button>
            </li>
            <li class="nav-item ">
              <button type="button" class="btn btn-primary" id="btndangkiN" data-toggle="modal" data-target="#modalregister">Đăng Kí</button>
            </li>
            <li class="nav-item ">
              <button type="button" name="btndangxuatN" id="btndangxuatN" class="btn btn-primary" >Đăng xuất</button>
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
               <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
               <input id="txtL_username" type="text" class="form-control" placeholder="user name">
          </div>
          <div class="input-group">
               <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
               <input id="txtL_password" type="password" class="form-control" placeholder="Password">
           </div>
           <p id="response" style="color:red"></p>
        </div> 
        <div class="modal-footer">
           <button type="button" name="btndangnhap" id="btndangnhap" class="btn btn-primary">Đăng Nhập</button>
           <button type="button" class="btn btn-primary" data-dismiss="modal">Thoát</button>
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
        <button  type="button" id="btndangki" name="btndangki"class="btn btn-primary" >Đăng Kí</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Thoát</button>
      </div>
    </div>
 </div>   
</div>
 
<script
  src="https://code.jquery.com/jquery-2.2.4.min.js"
  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
  crossorigin="anonymous"></script>
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

<script type="text/javascript">
  $(document).ready(function() {
    $("#btndangxuatN").click(function() {
        var answer = confirm("Bạn có muốn đăng xuất????");
        if(answer)
        {
        location.href="module/login/xulylogout.php"; 
        }
    });
  });

</script>

<script type="text/javascript">

  $(document).ready(function() {
    $("#btndangki").click(function() {
      var user=$("#Re_username").val();
      var pass=$("#Re_password").val();
      var epass=$("#Re_enterpassword").val();
       $.post("module/login/xulydangki.php",{username:user, password:pass,enterpassword:epass}, function(data) {
         /*optional stuff to do after success */
         $("#RE_response").html(data);
       });
    });
  });
</script>


