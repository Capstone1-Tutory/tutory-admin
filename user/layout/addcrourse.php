<?php 
  include('../module/config.php');
  $sqlmajor="SELECT ID_MAJOR, MAJOR_NAME FROM major";
 ?>

<link rel="stylesheet" type="text/css" href="../../static/vendor/bootstrap/css/bootstrap.min.css">

                <div class="form-group">
                <label>Chuyên ngành</label>
                <select class="form-control title" id="slmajor">
                <option value="">--Vui lòng chọn chuyện ngành--</option>
                <?php 
                   $resultmajor= mysqli_query($conn,$sqlmajor);
                   while ($row=mysqli_fetch_assoc($resultmajor)) {
                      ?>
                       <option value="<?php echo $row["ID_MAJOR"] ?>"><?php echo $row["MAJOR_NAME"] ?></option>
                      <?php
                   }
                 ?>
                
                </select>
                </div>
                </div>

                <div class="form-group">
                <label>Số lượng học viên</label>
                <select class="form-control title" id="quantity_add_course">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
                </div>
                <div class="form-group">
                <label>Chọn ngày:</label>
                <label> Từ</label>
                <input type="date" class="form-control-inline title" id="start_day_add_course">
                
                <label> Đến</label>
                
                <input type="date" class="form-control-inline title" id="end_day_add_course">
                </div>
                <div class="form-group">
                <div class="form-inline">
                <a href="" class="btn btn-default" style="color:red">
                <span class="glyphicon glyphicon-arrow-left" style="color:red"></span> Hủy
                </a>
                
                <a class="btn btn-primary">Xác nhận</a> 
                </div>
                </div>
               
                
<script src="../../static/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="../../static/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#slmajor").change(function(event) {
            var idmajor= $("#slmajor").val();
            $.get('sltutor.php',{idmajor:idmajor}, function(data) {
                $("#slgiasu").html(data);
            });
        });
        $("#sltinhtp").change(function(event) {
        var idtinh = $("#sltinhtp").val();
        $.post('huyen.php', {idtinh:idtinh}, function(data) {
          $("#slhuyen").html(data);   
        });
      });
       $("#slhuyen").change(function(event) {
       var idhuyen= $("#slhuyen").val();
       $.post('xa.php', {idhuyen:idhuyen}, function(data) {
         $("#slxa").html(data);
       });
     });
    });
</script>
