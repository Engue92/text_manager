<html>

<head>
  <title>Text manager</title>
  <link rel="stylesheet" href="https://unpkg.com/mustard-ui@latest/dist/css/mustard-ui.min.css">
</head>

<body>

  <header style="height: 200px;">
    <h1>Text manager</h1>
  </header>

  <?php
   
    if(isset($_POST["URL"])) {
      $URL = $_POST["URL"];
      if($URL !== "") {
        $texte = file_get_contents($URL);
      }
    }

    if(isset($_POST["recherche"])) {
      $recherche = $_POST["recherche"];
    }

  ?>

  <br>
  <div class="row">
    <div class="col col-sm-5">
      <div class="panel">
        <div class="panel-body">

          <h2>1. Get text</h2>

          <form action="index.php" method="post">
            <input type="text" name="URL"  placeholder="Renceigner l'URL" value="<?=$URL?>" />
            <br>
            <button type="submit" class="appliquer">Fetch text</button>
          </form>

          <h2>2. Find keywords</h2>

          <form action="index.php" method="post">
            <input type="hidden" name="URL" value="<?=$URL?>" />
            <input type="text" name="recherche" value="<?=$recherche?>"/>
            <br>
            <button type="submit" class="appliquer" placeholder="Renceigner l'URL">Search text</button>
          </form>

          <?php
            if($recherche !== "")
            {
              $mot_recherche = preg_split('/\s+/', $recherche);
              echo "<h2>3. Check results</h2>
              <br>
              <div class='stepper'>";

              foreach($mot_recherche as $mot) 
              {
                $sortie = 0;
                $nombre = 0;

                while($sortie < strlen($texte) && stripos($texte, $mot, $sortie) !== false) 
                {
                  $position = stripos($texte, $mot, $sortie);
                  $nombre++;
                  $mot_trouve = substr($texte, $position, strlen($mot));

                  $replacement = "<mark id='$mot-$nombre'>$mot_trouve</span>";
                  $texte = substr_replace($texte, $replacement, $position, strlen($mot));
                  $sortie = $position + strlen($replacement);
                }

                echo "<div class='step'>
                <p class='step-number'>$nombre</p>
                <p class='step-title'>mot_recherche: $mot</p>";
                
                for($i = 1; $i <= $nombre; $i++) 
                {
                  echo "<a href='#$mot-$i'>$i</a> ";
                }
                echo "</div>";
              }
              echo "</div>";
            }
          ?>
        </div>
      </div>
    </div>

    <div class="col col-sm-7" style="padding-left: 25px;">
      <pre><code><?=$texte?></code></pre>
    </div>
  </div>

</body>
</html>