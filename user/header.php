
<link rel="stylesheet" type="text/css" href="../static/vendor/bootstrap/css/bootstrap.min.css">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
      <div class="container">
        <a class="navbar-brand" href="#">Tutory</a>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item ">
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modallogin">Đăng Nhập</button>
               
              </a>
            </li>
            <li class="nav-item ">
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalregister">Đăng Kí</button>
            </li>
          </ul>
        </div>
      </div>
    </nav >	
  <!--Modal Login-->
  <form action="module/login/xuly.php" method="post" enctype="multipart/form-data">
    
    <div class="modal face" id="modallogin" role="login">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title">Đăng Nhập </h4>
        </div>
        <div class="modal-body">
          <div class="input-group">
               <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
               <input id="username" type="text" class="form-control" name="Login_username" placeholder="user name">
          </div>
          <div class="input-group">
               <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
               <input id="password" type="password" class="form-control" name="Login_password" placeholder="Password">
           </div>
        </div> 
        <div class="modal-footer">
           <button type="button" id="btndangnhap" class="btn btn-primary">Đăng Nhập</button>
           <button type="button" class="btn btn-primary" data-dismiss="modal">Thoát</button>
        </div>
     </div>
   </div>
 </div>
  </form>
  

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
              <input type="text" class="form-control" id="Re_username" placeholder="UserName" name="Re_username">
            </div>
         </div>
        <div class="input-group">
            <label class="control-label col-sm-4" for="email">Mật Khẩu:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="Re_password" placeholder="Password" name="Re_password">
            </div>
         </div>
         <div class="input-group">
            <label class="control-label col-sm-5" for="Re_enterpassword">Nhập Lại Mật Khẩu:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="Re_enterpassword" placeholder="Enter Password" name="Re_enterpassword">
            </div>
         </div>
      </div> 
     
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Đăng Kí</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Thoát</button>
      </div>
    </div>
 </div>   
</div>
<script src="../static/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="../static/vendor/jquery/jquery.min.js"></script>
