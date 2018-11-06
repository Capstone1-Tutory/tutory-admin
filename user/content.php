<?php 
include('module/config.php');
?>
    <div class="col-sm-8 "> 
     
     <div id="dangtin" style="padding-top: 10px;">
     	<textarea name="txtdangtin" rows="5" cols="120" placeholder="Bạn muốn đăng gì???"></textarea><br>
     	<div id="newsfooter" style="float:right; padding-right:50px;">
     		<select name="loaitin" class="dropdown">
     		<option class="dropdown-item" value="" selected>Tìm học viên</option>
     		<option class="dropdown-item" value="" selected>Tìm giảng viên</option>
     	</select>
     	<button type="submit" class="btn btn-primary">Đăng tin</button>
     	</div>
     </div>
     <br>
    
      <hr>
      <div class="row">
        <?php
          $sql="SELECT uf.NAME, uf.PHONE, uf.EMAIL ,news.NEWS_TITLE, news.DETAILS FROM `news` INNER JOIN editor_of_news en ON en.THING_ROLE_TYPE_ID_TO=news.NEWS_ID INNER JOIN editor ed ON ed.PARTY_ID=en.PARTY_ROLE_TYPE_ID_FROM INNER JOIN user_profile uf ON uf.ID_USER= ed.ID_USER";
              $result=mysqli_query($conn,$sql);
              if(mysqli_num_rows($result)>0)
                while ($row=mysqli_fetch_assoc($result)) {
          ?>
            <div class="col-sm-3 avatanews">
              <div>
                <p><?php echo $row["NAME"]?></p>
                <img src="bird.jpg" class="img-circle" height="55" width="55" alt="Avatar">
              </div>
           </div>
           <div class="col-sm-8 detailnews">
          <div>
            <h4><?php echo $row["NEWS_TITLE"]?></h4>
            <p><?php echo $row["DETAILS"]?></p>
            <br>
            <p>Số điện thoại: <?php echo $row["PHONE"] ?></p>
             <br>
             <p>EMAIL: <?php echo $row["EMAIL"] ?></p>
          </div>
          
        </div>
        <?php
          }
        ?>
      	<div class="col-sm-8 detailnews">
      		<div>
      			Thông tin chi tiết bảng tin
      		</div>
      		
      	</div>
      </div>
    
    </div>
    