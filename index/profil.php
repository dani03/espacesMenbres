<?php
session_start();
try {
  $bdd = new PDO('mysql:host=localhost;dbname=espaceMenbres;charset=utf8','phpmyadmin','root');
} catch (Exception $e) {
  die($e->getMessage());
}
if(isset($_GET['id']) AND $_GET['id'] > 0)
{
  $getid = intval($_GET['id']);
  $recup_pseudo = $bdd->prepare('SELECT * FROM menbres WHERE id= ?');
  $recup_pseudo->execute(array($getid));
  $info_user = $recup_pseudo->fetch();
}


 ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1 ">
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link  href="http://fonts.googleapis.com/css?family=lato" rel= "stylesheet" type="text/css">
  <link rel="stylesheet" type='text/css' href="../css/style.css">

  <title>connexion</title>
</head>
  <body>
    <div class="container">
      <div class="diviseur"></div>
      <div class="row">
        <p>creation du compte: <?php echo $info_user['date_inscription'] ?></p>
        <h2> bienvenue sur votre profil <strong><?php echo $info_user['pseudo'] ; ?></strong> </h2>
        <p>votre email est le suivant : <?php echo $info_user['email'] ; ?></p>
        <?php
        if ($info_user['id'] == $_SESSION['id'])
         {
            echo '<a  class="btn btn-info" href= #>editer profile </a>';
            echo '<a class="btn btn-default" href= deconnexion.php> deconnexion</a>';
         }


         ?>
      </div>
    </div>
  </body>
</html>
