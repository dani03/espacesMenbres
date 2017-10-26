<?php
session_start();
try {
  $bdd = new PDO('mysql:host=localhost;dbname=espaceMenbres;charset=utf8','phpmyadmin','root');
} catch (Exception $e) {
  die($e->getMessage());
}

if(isset($_POST['submitedConnect']))
{
  $firstnameConnect = htmlspecialchars($_POST['firstnameConnect']);
  $emailConnect = htmlspecialchars($_POST['emailConnect']);
  $mdpConnect = sha1($_POST['passConnect']);
  if(!empty($emailConnect) && !empty($mdpConnect))
  {
      $recherche_user = $bdd->prepare('SELECT * FROM menbres WHERE email= ? AND motDePasse= ?');
      $recherche_user->execute(array($emailConnect, $mdpConnect));
      $user_exist = $recherche_user->rowCount();
      if($user_exist == 1)
      {
        $info_user = $recherche_user->fetch();
        $_SESSION['id'] = $info_user['id'];
        $_SESSION['pseudo'] = $info_user['pseudo'];
        header("location: profil.php?id=".$_SESSION['id']);
      }
      else
      {
        $erreur = " mot de passe ou email incorrect";
      }

  }
  else
  {
    $erreur = "tous les champs doivent être completés";
  }
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
      <h1 align="center">connectez vous!</h1>
      <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
          <form class="formulaire" action="" method="post" id='contact-form' role='form'>
            <div class="row">
              <div class="col-md-6">
                <label for="firstname"> pseudo: <span class="blue">*</span></label>
                <input type="text" name="firstnameConnect" id="firstname" class="form-control" value='<?php if(isset($firstname)){ echo $firstname ;} ?>' placeholder="votre pseudo" >
                <p class="comments"></p>
              </div>
              <div class="col-md-6">
                <label for="email"> email :<span class="blue">*</span></label>
                <input type="email" name="emailConnect" id="email" class="form-control" value="<?php if(isset($email)){ echo $email;} ?>" placeholder="visiteur@gmail.com" >
                <p class="comments"></p>
              </div>
              <div class="col-md-6">
                <label for="pass">mot de passe :<span class="blue">*</span></label>
                <input type="password" name="passConnect" id="pass" class="form-control" value="" placeholder="mot de passe" >
                <p class="comments"></p>
              </div>
                    <p class="blue"><strong>*ces champs sont requis</strong> </p>
              </div>
              <div class="col-md-12">
              <input type="submit" class="envoyer" name="submitedConnect" value="connexion">
              </div>
              <p><?php if(isset($erreur)){
                echo $erreur ;
              }?>
              </p>
              <p>il est acctuellement <?php echo date('H:i')?></p>
            </div>
            <p class="merci" style="display:none"> inscription reussis.</p>
          </form>

        </div>

      </div>
    </div>
  </body>
</html>
