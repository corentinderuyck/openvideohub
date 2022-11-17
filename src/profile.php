<?php
session_start();
require("../password.php");

if(isset($_SESSION['id'])==false) {
	header('Location: connection.php');
  	exit();
}
?>
<!doctype html>
<html lang="fr">
	<head>
	  <meta charset="utf-8">
	  <title>Video Streaming</title>
	  <link rel="stylesheet" href="../css/profile.css">
	  <meta name="viewport" content="width=device-width"/>
	</head>
	<body>
		<?php
			include("header.php");
		?>
		<div class="first_layer">
			<h1 class="name_profile">Hi, <?php echo $_SESSION["name"]; ?></h1>
			<p onclick="document.location.href='/src/logout.php'" class="logout">Logout</p>
		</div>
		<hr>
		<div class="seconde_layer">
			<h1 class="file_title">Upload a video</h1>
		</div>
		<div class="three_layer">
			<form enctype="multipart/form-data" action="upload_video_process.php" method="post">
				<input required type="text" id="title" name="title" placeholder="video name"><br>
				<input required type="text" id="description" name="description" placeholder="video description"><br>

				<label for="video">Upload video file &#11015;</label>
				<span id="file_chosen">No file chosen</span><br>
				<input hidden required type="file" id="video" name="video" accept="video/*">

				<label for="video_desc">Upload image for thumbnail &#11015;</label>
				<span id="file_chosen_desc">No file chosen</span>
				<input hidden required type="file" id="video_desc" name="video_desc" accept=".jpg"><br>
				<input type="submit" class="press_button" value="Submit">
			</form>
		</div>
		<hr>
		<div class="four_layer">
			<h1 class="info_title">My videos</h1>
		</div>
		<div class="five_layer">
			<?php
				try
				{
				$bdd = new PDO('mysql:host=localhost;dbname='.$bdd.';charset=utf8', $user, $password);
				}
				catch (Exception $e)
				{
				die('Erreur : ' . $e->getMessage());
				}

				//we check if the email exists
				$sqlQuery = "SELECT * FROM `table_".$_SESSION['id']."` WHERE id_video_like=0";
				$recipesStatement = $bdd->prepare($sqlQuery);
				$recipesStatement->execute();
				$videos = $recipesStatement->fetchAll();

				echo "<div class='wrapper'>";
				echo "<div class='cont'>";
					echo "<p class='title_grid' style='grid-column: 1; grid-row: 1;'>Video</p>";
				echo "</div>";
				echo "<div class='cont'>";
					echo "<p class='title_grid' style='grid-column: 2; grid-row: 1;'>Name</p>";
				echo "</div>";
				echo "<div class='cont'>";
					echo "<p class='title_grid' style='grid-column: 3; grid-row: 1;'>Like</p>";
				echo "</div>";
				echo "<div class='cont'>";
					echo "<p class='title_grid' style='grid-column: 4; grid-row: 1;'>Don't like</p>";
				echo "</div>";
				echo "<div class='cont'>";
					echo "<p class='title_grid' style='grid-column: 5; grid-row: 1;'>Views</p>";
				echo "</div>";
  				$i = 2;
				foreach ($videos as $video) {
					$sqlQuery = "SELECT * FROM `videos` WHERE id=".$video["id_video"];
					$recipesStatement = $bdd->prepare($sqlQuery);
					$recipesStatement->execute();
					$recipe = $recipesStatement->fetchAll();

					echo "<div style='grid-column: 1; grid-row: ".$i.";' onclick='loadvideo(".$recipe[0]["id"].")' class='video'>";
		              echo "<img class='img_item' src='../media/".$recipe[0]["id"].".jpg'>";
		            echo "</div>";

		            echo "<div style='grid-column: 2; grid-row: ".$i.";' class='cont'>";
		            	echo "<p class='name'>".$recipe[0]["name"]."</p>";
  					echo "</div>";

  					echo "<div style='grid-column: 3; grid-row: ".$i.";' class='cont'>";
		            	echo "<p class='like'>".$recipe[0]["likeButton"]."</p>";
  					echo "</div>";


  					echo "<div style='grid-column: 4; grid-row: ".$i.";' class='cont'>";
		            	echo "<p class='dontlike'>".$recipe[0]["dontTlikeButton"]."</p>";
  					echo "</div>";


  					echo "<div class='cont' style='grid-column: 5; grid-row: ".$i.";'>";
		            	echo "<p class='views'>".$recipe[0]["views"]."</p>";
  					echo "</div>";
		            $i = $i + 1;
				}
				echo "</div>";
			?>
		</div>
	</body>
	<script type="text/javascript">
		//load menu
	    function load_menu() {
	      let str = "../index.php";
	      document.location.href=str; 
	    }

		//load video
	    function loadvideo(id) {
	      let str = "load_video.php?id="+id.toString();
	      document.location.href=str; 
	    }

	    //upload video
	    const actualBtn = document.getElementById('video');

		const fileChosen = document.getElementById('file_chosen');

		actualBtn.addEventListener('change', function(){
		  fileChosen.textContent = this.files[0].name
		})

	    //upload image
	    const actualBtndesc = document.getElementById('video_desc');

		const fileChosendesc = document.getElementById('file_chosen_desc');

		actualBtndesc.addEventListener('change', function(){
		  fileChosendesc.textContent = this.files[0].name
		})
	</script>
</html>