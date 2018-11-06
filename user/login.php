<table>
	<tr>
		<th>user name:
          <td><input type="text" id="txtU" name="" value="" placeholder="username....."></td>
		</th>
	</tr>
	<tr>
		<th>user name:
          <td><input type="password" id="txtP" name="" value="" placeholder="password....."></td>
		</th>
	</tr>
</table>
<p id="nhacloi"></p>
<button type="button" id="btnlogin">LOGIN</button>
<script src="../static/vendor/jquery/jquery.min.js"></script>

<script type="text/javascript">
	
	$(document).ready(function() {
		$("#btnlogin").click(function(event) {
			
			var u= $("#txtU").val();
			var p=$("#txtP").val();
            $.post('module/login/xulylogin.php', {myusername:u,mypassword:p}, function(data) {
            	 $("#nhacloi").html(data);
            });
		});
	});
</script>