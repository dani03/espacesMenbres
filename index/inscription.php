<?php
try {
  $bdd = new PDO('mysql:host=localhost;dbname=espaceMenbres;charset=utf8','phpmyadmin','root');
} catch (Exception $e) {
  die($e->getMessage());
}

if(isset($_POST['submited'])){
  $firstname = htmlspecialchars($_POST['firstname']);
  $mail = htmlspecialchars($_POST['email']);
  $mot_de_passe = sha1($_POST['pass']);
  $mot_de_passe2 = sha1($_POST['pass2']);
  $date = date('Y/m/d');
  $firstnameTaille = strlen($firstname);
  if(!empty($_POST['firstname']) && !empty($_POST['email']) && !empty($_POST['pass']) && !empty($_POST['pass2']))
  {

      if($firstnameTaille > 10)
      {
        $erreur ="votre pseudo ne doit pas depasser 10 caractères";
      }
      else
        {
          if(filter_var($mail, FILTER_VALIDATE_EMAIL))
          {
            $mail_different = $bdd->prepare('SELECT * FROM menbres WHERE email = ?');
            $mail_different->execute(array($mail));
            $mailExist = $mail_different->rowCount();
            if($mailExist == 0)
            {
              if($mot_de_passe == $mot_de_passe2)
              {
                $insertion = $bdd->prepare('INSERT INTO menbres(pseudo, email, motDePasse, date_inscription) VALUES(?,?,?,?)');
                $insertion->execute(array($firstname, $mail, $mot_de_passe, $date));
                $erreur = "votre compte a été crée <a href=connexion.php> connectez -vous</a>";

              }
              else
                {
                  $erreur = "mots de passe diferents";
                }
            }
            else
              {
               $erreur =" cette email existe deja";
              }
          }
          else
           {
             $erreur = "votre email est invalide";
           }

        }
  }
  else
  {
    $erreur = "tous les champs doivent etre complétés";
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

  <title>inscription</title>
</head>
  <body>
    <div class="container">
      <div class="diviseur"></div>
      <h1 align="center">inscription</h1>
      <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
          <form class="formulaire" action="" method="post" id='contact-form' role='form'>
            <div class="row">
              <div class="col-md-6">
                <label for="firstname"> pseudo: <span class="blue">*</span></label>
                <input type="text" name="firstname" id="firstname" class="form-control" value='<?php if(isset($firstname)){ echo $firstname ;} ?>' placeholder="votre pseudo" >
                <p class="comments"></p>
              </div>
              <div class="col-md-6">
                <label for="email"> email :<span class="blue">*</span></label>
                <input type="email" name="email" id="email" class="form-control" value="<?php if(isset($email)){ echo $email;} ?>" placeholder="visiteur@gmail.com" >
                <p class="comments"></p>
              </div>
              <div class="col-md-6">
                <label for="pass">mot de passe :<span class="blue">*</span></label>
                <input type="password" name="pass" id="pass" class="form-control" value="" placeholder="mot de passe" >
                <p class="comments"></p>
              </div>
              <div class="col-md-6">
                <label for="pass2"> retapper votre mot de passe :<span class="blue">*</span></label>
                <input type="password" name="pass2" id="pass2" class="form-control" value="" placeholder="mot de passe" >
                <p class="comments"></p>
              </div>
              <div class="col-md-12">
                    <p class="blue"><strong>*ces champs sont requis</strong> </p>
              </div>
              <div class="col-md-12">
              <input type="submit" class="envoyer" name="submited" value="insciption">
              </div>
              <p><?php if(isset($erreur)){
                echo $erreur ;
              }?>
              </p>
              <p>il est acctuellement <?php echo date('H:i')?></p>
            </div>
            <p class="merci"><a href="connexion.php">vous avez deja un compte ? connectez vous</a></p>
          </form>

        </div>

      </div>
    </div>
  </body>
</html>
