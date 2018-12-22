<?php 
include('../module/config.php');
?>
   
     
     <div id="dangtin" style="padding-top: 10px;">
     	<textarea id="txtdangtin" rows="5" cols="120" placeholder="Bạn muốn đăng gì???" required></textarea><br>
     	<div id="newsfooter" style="float:right; padding-right:50px;">
     		<select id="categorytype" class="dropdown">
          <?php
          $sqltype="SELECT * FROM news_category_type";
          $kq=mysqli_query($conn,$sqltype);
          while ($row=mysqli_fetch_assoc($kq)) {
          ?>
            <option class="dropdown-item" value="<?php echo $row['NEWS_CATEGORY_TYPE_ID'] ?>" ><?php echo $row['NEWS_CATEGORY_TYPE_NAME']  ?></option>
         <?php
           } 
          ?>
     	</select>
      <select id="newstaitel" class="dropdown" >
        <option class="dropdown-item" value="Tìm học Viên">Tìm học viên</option>
        <option class="dropdown-item" value="Tìm giảng viên">Tìm giảng viên</option>
  
      </select>
     	<button type="button" id="btndangtin" class="btn btn-primary"><i class="fas fa-pencil-alt" style="margin-right: 5px"></i>Đăng tin</button>
     	</div>
     </div>
     <br>
    
      <hr>
     
        <?php
          $sql="SELECT n.NEWS_ID,uf.NAME,uf.URL_AVATAR, uf.PHONE, uf.EMAIL ,n.NEWS_TITLE, n.DETAILS,en.FROM_DATE FROM news n INNER JOIN editor_of_news en ON en.THING_ROLE_TYPE_ID_TO=n.NEWS_ID INNER JOIN editor ed ON ed.PARTY_ID=en.PARTY_ROLE_TYPE_ID_FROM INNER JOIN user_profile uf ON uf.ID_USER= ed.ID_USER WHERE n.STATUS= 1 ORDER BY en.FROM_DATE DESC ";
              $result=mysqli_query($conn,$sql);
              if(mysqli_num_rows($result)>0)
                while ($row=mysqli_fetch_assoc($result)) {
          ?>
           <div class="row">
            <div class="col-sm-3 avatanews">
              <div>
                <p><?php echo $row["NAME"]?></p>
                <img src="../image/imageUSER/<?php echo $row["URL_AVATAR"] ?>" class="img-circle" height="100px" width="100px" alt="Avatar">
              </div>
           </div>
           <div class="col-sm-8 detailnews">
          <div>
            <h4><?php echo $row["NEWS_TITLE"]?></h4>
            <p><?php echo $row["DETAILS"]?></p> 
            <p>Số điện thoại: <?php echo $row["PHONE"] ?></p>
            <p>EMAIL: <?php echo $row["EMAIL"] ?></p>
            <p>Ngày đăng tin: <?php echo $row['FROM_DATE'] ?></p>
          </div>  
        </div>
       </div>
       
       <hr>
           <script type="text/javascript">
                 $("#btnloadcomment<?php echo $row['NEWS_ID']?>").click(function(event) {
                /* Act on the event */
                var idnews = $("#btnloadcomment<?php echo $row['NEWS_ID']?>").val();
                $("#comment<?php echo $row['NEWS_ID']?>").load('module/bangtin/loadcomment.php?idnews='+idnews);
              });
            
             
            </script>
        <?php
          }
        ?>
   


  <script src="../../static/vendor/jquery/jquery.min.js"></script>
  <!-- dang tin-->

  <script type="text/javascript">
  	$(document).ready(function() {
  		$("#btndangtin").click(function(){
           var taitel = $("#newstaitel").val();
           var idtype =$("#categorytype").val();
           var detail =$("#txtdangtin").val();
           var d = new Date();
           var strDate = d.getFullYear() + "/" + (d.getMonth()+1) + "/" + d.getDate(); 
           if(detail=="")
           {
            alert("bạn cần nhập nội dung tin");
           }
           else
           {
           $.get('module/bangtin/dangtin.php',{taitel:taitel, detail:detail,type:idtype,date:strDate}, function(data) {
                var answer= confirm(data);
                 if(answer)
                 {
                  window.history.back();
                 }
              });
             }
      });
  	});
     
  </script>

 