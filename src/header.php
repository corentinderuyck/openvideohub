<style type="text/css">     
@media (max-width: 800px) {
      header {
            flex-direction: column;
      }

      .search {
            width: 90%;
      }

      .logo_box {
            width: 100%;
      }

      .box_next {
            width: 100%;
      }
}

@media (min-width: 800px) {
      .search {
            width: 70%;
      }

      header {
            flex-direction: row;
      }

      .box_next {
            width: 70%;
      }
}

.logo {
      font-family: sans-serif;
      color: white;
      font-size: 2em;
      margin: 0.5em 1em 0.5em 1em;
}

.logo:hover {
      cursor: pointer;
}

.search {
      font-size: 1em;
      color: white;
      background-color: rgb(40,40,40);
      padding: 1em 1.5em 1em 1.5em;
      border-radius: 40px;
      border: 1px black solid;
      outline: none;
      margin: 0em 0.5em 0em 0.5em;
}

.connection {
      background-color: white;
      border-radius: 20px;
      padding: 0.5em 1em 0.5em 1em;
      margin: 0.5em;
}

.connection:hover {
      cursor: pointer;
      box-shadow: 0px 0px 5px white;
}

.status_co {
      margin: 0px;
      color: black;
      font-family: sans-serif;
      font-size: 1em;
}

.connection_name {
      background-color: white;
      border-radius: 50px;
      width: 3em;
      height: 3em;
      display: flex;
      flex-direction: row;
      justify-content: center;
      align-items: center;
      margin: 1em;
}

.connection_name:hover {
      cursor: pointer;
      box-shadow: 0px 0px 5px white;
}

.connection_name_p {
      margin: 0px;
      color: black;
      font-family: sans-serif;
      font-size: 1.5em;
}

.logo_box {
      display: flex;
      flex-direction: row;
      justify-content: center;
}

.box_next {
      display: flex;
      flex-direction: row;
      justify-content: space-between;
      align-items: center;
}

header {
      margin: 0.5em 0em 0.5em 0em;
      padding: 0px;
      display: flex;
      align-items: center;
      justify-content: space-between;
}
</style>
<header>
      <div class="logo_box">
            <h1 class="logo" onclick="load_menu()">OpenVideoHub</h1>
      </div>
      <div class="box_next">
            <input class="search" type="text" placeholder="Search" name="search">
            <?php
            if(isset($_SESSION['id'])) {
            ?>
                  <div onclick="document.location.href='/src/profile.php'" class="connection_name">
                        <p class='connection_name_p'><?php echo $_SESSION["name"][0]; ?></p>
                  </div>
            <?php
            } else {
            ?>
                  <div onclick="document.location.href='/src/connection.php'" class="connection">
                        <p class='status_co'>Connection</p>
                  </div>
            <?php } ?>
      </div>
</header>


