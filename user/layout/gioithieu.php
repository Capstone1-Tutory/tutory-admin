<h1> gioi thiệu</h1>

<button type="button" id="btnchat">CHAT</button>
<div id="chat">
	
</div>

<script src="../../static/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
	
	$("#btnchat").click(function(event) {
		$("#chat").load("../chat.php");
	});
</script>