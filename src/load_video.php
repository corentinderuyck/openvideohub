<?php
session_start();
require("../password.php");
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Video Streaming</title>
  <link rel="stylesheet" href="../css/load_video.css">
  <meta name="viewport" content="width=device-width"/>
</head>
  <body>
    <?php
      include("header.php");
    ?>
    <div id="main">
      <?php
					$id = $_GET['id'];
					try
			    {
			      $bdd = new PDO('mysql:host=localhost;dbname='.$bdd.';charset=utf8', $user, $password);
			    }
			    catch (Exception $e)
			    {
			      die('Erreur : ' . $e->getMessage());
			    }

			    //take the info of the video
			    $sqlQuery = "SELECT * FROM `videos` WHERE id=".$id;
			    $recipesStatement = $bdd->prepare($sqlQuery);
			    $recipesStatement->execute();
			    $recipes = $recipesStatement->fetchAll();

			    //increment the vieuw number
			    $sqlQuery = "UPDATE `videos` SET `views`='".(intval($recipes[0]['views'])+1)."' WHERE id='".$recipes[0]['id']."'";
			    $recipesStatement = $bdd->prepare($sqlQuery);
			    $recipesStatement->execute();
			?>
	    <div class='center_load'>
		    <div class='video_load'>
		    	<video class='video_item_load' controls autoplay>
		        <source src='../media/<?php echo $recipes[0]["id"]; ?>.mp4' type='video/mp4'>
		      </video>
		     	<div class='first_layer'>
		     		<p class='title_video_load'><?php echo $recipes[0]["name"]; ?></p>
		     		<div class='like_dont_like'>
		     			<?php
		     			if(isset($_SESSION['id'])){
		     				$sqlQuery = "SELECT * FROM `table_".$_SESSION["id"]."` WHERE id_video=".$id;
								$recipesStatement = $bdd->prepare($sqlQuery);
								$recipesStatement->execute();
								$recipesbis = $recipesStatement->fetchAll();
							  if($recipesbis==null) {
							  	$bg_like = "rgb(55,55,55);";
							  	$bg_dontlike = "rgb(55,55,55);";
							  } elseif(intval($recipesbis[0]["id_video_like"])==1) {
							  	$bg_like = "rgb(0, 180, 0);";
							  	$bg_dontlike = "rgb(55,55,55);";
							  } elseif(intval($recipesbis[0]["id_video_like"])==2) {
							  	$bg_like = "rgb(55,55,55);";
							  	$bg_dontlike = "rgb(180, 0, 0);";
							  } else {
							  	$bg_like = "rgb(55,55,55);";
							  	$bg_dontlike = "rgb(55,55,55);";
							  }
		     			} else {
			     			$bg_like = "rgb(55,55,55);";
							  $bg_dontlike = "rgb(55,55,55);";
							} ?>
			     			<p onclick='changelike(<?php echo $recipes[0]["id"]; ?>, 1)' style="background-color: <?php echo $bg_like; ?>" id="like_button" class='like_button'>&#128077; <?php echo $recipes[0]["likeButton"]; ?></p>
		     				<p onclick='changelike(<?php echo $recipes[0]["id"]; ?>, 2)' style="background-color: <?php echo $bg_dontlike; ?>;" id="dontlike_button" class='dont_like_button'>&#128078; <?php echo $recipes[0]["dontTlikeButton"]; ?></p>
		     		</div>
		     	</div>
		     	<div class="second_layer">
		     		<p class="number_views"><?php 
		     		if(intval($recipes[0]["views"]) == 1) {
		     			echo $recipes[0]["views"]." view";
		     		} else {
		     			echo $recipes[0]["views"]." views";
		     		} 
		     	?></p>
		     	</div>
		     	<div class="third_layer">
		     		<p class="description_title">Description :</p>
		     		<p class='description_video_load'><?php echo $recipes[0]["description"]; ?></p>
		     	</div>
		    </div>
			</div>
    </div>
  </body>
  <script type="text/javascript">
  	//load menu
    function load_menu() {
      let str = "../index.php";
      document.location.href=str; 
    }

    //changelike
    function changelike(id, type) {
    	var xmlhttp=new XMLHttpRequest();
		  xmlhttp.onreadystatechange=function() {
		    if (this.readyState==4 && this.status==200) {
		    	if(parseInt(this.responseText)==1) {
		    		document.getElementById("like_button").style.backgroundColor = "rgb(0, 180, 0)";
		    		document.getElementById("dontlike_button").style.backgroundColor = "rgb(55,55,55)";
		    	}
		    	if(parseInt(this.responseText)==2) {
		    		document.getElementById("like_button").style.backgroundColor = "rgb(55,55,55)";
		    		document.getElementById("dontlike_button").style.backgroundColor = "rgb(180, 0, 0)";
		    	}
		    	if(parseInt(this.responseText)==0) {
		    		document.getElementById("like_button").style.backgroundColor = "rgb(55,55,55)";
		    		document.getElementById("dontlike_button").style.backgroundColor = "rgb(55,55,55)";
		    	}
		    	if(parseInt(this.responseText)==3) {
		    		window.location.href = "connection.php";
		    	}
		    }
		  }
		  xmlhttp.open("GET","change_like.php?id="+id+"&type="+type,true);
		  xmlhttp.send();
    }
  </script>
</html>