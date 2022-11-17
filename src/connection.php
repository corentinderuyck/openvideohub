<?php
 require("../password.php");
?>
<!doctype html>
<html lang="fr">
	<head>
	  <meta charset="utf-8">
	  <title>Video Streaming</title>
	  <link rel="stylesheet" href="../css/connection.css">
	  <meta name="viewport" content="width=device-width"/>
	</head>
	<body>
		<?php
			include("header.php");
		?>
		<div class="connection_div">
			<div class='center_connection_div'>
				<div class="menu_connection">
					<p onclick="load_connection()" id='connection_p'>CONNECTION</p>
					<p onclick="load_registration()" id='registration_p'>REGISTRATION</p>
				</div>
				<hr>
				<form id="form" method="post" action="connection_process.php?id=0">
					<input type="text" id="name" name="name" placeholder="public name"/><br>
		          	<input type="text" id="email" name="email" placeholder="email"/><br>
		          	<input type="password" id="password" name="password" placeholder="password"><br>
		          	<input id="sumbit" type="submit" class="submit" value="Connection"/>
		        </form>
		    </div>
		</div>
	</body>
	<script type="text/javascript">
		//load menu
	    function load_menu() {
	      let str = "../index.php";
	      document.location.href=str; 
	    }
	    
		function load_connection() {
			document.getElementById('connection_p').style.fontWeight = "bold";
			document.getElementById('registration_p').style.fontWeight = "normal";
			document.getElementById("form").action = "connection_process.php?id=0";
			document.getElementById("sumbit").value = "Connection";
			document.getElementById('name').style.display = "none";
		}

		function load_registration() {
			document.getElementById('connection_p').style.fontWeight = "normal";
			document.getElementById('registration_p').style.fontWeight = "bold";
			document.getElementById("form").action = "connection_process.php?id=1";
			document.getElementById("sumbit").value = "Registration";
			document.getElementById('name').style.display = "block";
		}
	</script>
</html>