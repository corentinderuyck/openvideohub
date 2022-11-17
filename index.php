<?php
session_start();
require("password.php");
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Video Streaming</title>
  <link rel="stylesheet" href="css/index.css">
  <meta name="viewport" content="width=device-width"/>
</head>
  <body>
    <?php
      include("src/header.php");
    ?>
    <div id="main">
      <h1>Top videos</h1>
      <div class="videos">
        <?php
          try
          {
            $bdd = new PDO('mysql:host=localhost;dbname='.$bdd.';charset=utf8', $user, $password);
          }
          catch (Exception $e)
          {
            die('Erreur : ' . $e->getMessage());
          }

          $sqlQuery = "SELECT * FROM `videos` ORDER BY views LIMIT 25";
          $recipesStatement = $bdd->prepare($sqlQuery);
          $recipesStatement->execute();
          $recipes = $recipesStatement->fetchAll();

          $tmp = 0;
          foreach ($recipes as $video) {
            echo "<div onclick='loadvideo(".$video["id"].")' class='video'>";
              echo "<div id='box_video'>";
                echo "<img id='img_".$tmp."' class='img_for_video' src='media/".$video["id"].".jpg'>";
                echo "<video style='display:none;' class='video_item' id='video_".$tmp."' muted loop>
                      <source src='media/".$video["id"].".mp4'
                              type='video/mp4'>
                    </video>";
              echo "</div>";
              echo "<p class='title_video'>".$video["name"]."</p>";
              echo "<p class='autor_video'>".$video["autor_name"]."</p>";
              echo "<p class='views_video'>".$video["views"]." views</p>";
            echo "</div>";
            $tmp = $tmp + 1;
          }
        ?>
      </div>
    </div>
  </body>
  <script type="text/javascript">
    //set listener video
    window.onload = function() {
      load_listener();
    }

    //load video
    function loadvideo(id) {
      let str = "src/load_video.php?id="+id.toString();
      document.location.href=str; 
    }

    //load menu
    function load_menu() {
      let str = "index.php";
      document.location.href=str; 
    }

    //play-pause video mouseover
    function load_listener() {
      for (var i = 0; i < <?php echo count($recipes); ?>; i++) {
        let str_video = "video_"+i.toString();
        let str_img = "img_"+i.toString();
        document.getElementById(str_img).addEventListener('mouseover',()=>{
            document.getElementById(str_img).style.display = "none";
            document.getElementById(str_video).style.display = "block";
            document.getElementById(str_video).play();
        });
        document.getElementById(str_video).addEventListener('mouseout',()=>{
          document.getElementById(str_video).pause();
          document.getElementById(str_video).currentTime = 0;
          document.getElementById(str_video).style.display = "none";
          document.getElementById(str_img).style.display = "block";
        });
      }
    }


  </script>
</html>