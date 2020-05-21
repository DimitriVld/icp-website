<?php

/* Si le formulaire est envoyé alors on fait les traitements */
if (isset($_POST['envoye']))
{
  /* Récupération des valeurs des champs du formulaire */
  $nom = $_POST['nom'];
  $entreprise = $_POST['entreprise'];
  $telephone = $_POST['telephone']; 
  $expediteur = $_POST['email']; 
  $sujet = $_POST['sujet']; 
  $message = $_POST['message'];

  /* Expression régulière permettant de vérifier si le 
  * format d'une adresse e-mail est correct */
  $regex_mail = '/^[-+.\w]{1,64}@[-.\w]{1,64}\.[-.\w]{2,6}$/i';
 
  /* Expression régulière permettant de vérifier qu'aucun 
  * en-tête n'est inséré dans nos champs */
  $regex_head = '/[\n\r]/';

  if($_SERVER['HTTP_REFERER'] != 'http://icp-plomberie.fr/contact.php')
  {
    header('Location: http://icp-plomberie.fr');
  } elseif (
    empty($nom)
    || empty($expediteur) 
    || empty($sujet) 
    || empty($message)
  )
  {
    $alert = 'error';
    $alertMessage = 'Tous les champs requis doivent être renseignés';
  } elseif (!preg_match($regex_mail, $expediteur))
  {
    $alert = 'error';
    $alertMessage = 'L\'adresse '.$expediteur.' n\'est pas valide';
  } elseif (preg_match($regex_head, $expediteur) 
    || preg_match($regex_head, $nom) 
    || preg_match($regex_head, $sujet))
  {
    $alert = 'error';
    $alertMessage = 'En-têtes interdites dans les champs du formulaire';
  } elseif (!isset($_COOKIE['sent']))
  {
    /* Destinataire (votre adresse e-mail) */
    $to = 'Icp.entreprise.contact@gmail.com';
      
    /* Construction du message */
    $msg  = 'Bonjour,'."\r\n\r\n";
    $msg .= 'Ce mail a été envoyé depuis Icp-plomberie.fr par '.$nom."\r\n\r\n";
    $msg .= 'Voici le message qui vous est adressé :'."\r\n";
    $msg .= "\r\n";
    $msg .= $message."\r\n";
    $msg .= "\r\n";

    /* En-têtes de l'e-mail */
    $headers = 'From: '.$nom.' <contact@icp-plomberie.fr>'."\r\n\r\n";

    /* Envoi de l'e-mail */
    if (mail($to, $sujet, $msg, $headers))
    {
      $alert = 'success';
      $alertMessage = 'E-mail envoyé avec succès';

      setcookie("sent", "1", time() + 120);

      unset($_POST);
    }
    else
    {
      $alert = 'error';
      $alertMessage = 'Erreur d\'envoi de l\'e-mail';
    }
  } else
  {
    unset($_POST);
  }
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, user-scalable=no" />
    <meta name=”description” content="Faire appel à l'entreprise ICP plomberie c'est l'assurance d'un plombier certifié, nous nous intervenons sur votre plomberie, chauffage et climatisation ! n'hesitez pas à nous contacter">
    <meta name="author" content="Dimitri Vildina">
    <meta name="keywords" content="web,design,html,css,html5,development">
    <meta name="robots" content="index, follow" />   
    <title>ICP</title>
    <link rel="icon" type="image/png" href="./logo.png" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles.css">
  </head>
  <body class="contact-page">
    <!-- NAV -->
    <div class="nav_container"></div>

    <!-- HEADER -->
    <div class="header-contact">
      <h1>Contact</h1>
    </div>

    <!-- SECTION CONTACT -->
    <section class="section-contact container-dft">
      <!-- Formulaire -->
      <form action="contact.php" method="POST">
        <h2>Formulaire de contact</h2>
        <div class="points"></div>
        <h3>Parlez-nous de vos besoins</h3>
        <p>
          Un renseignement ? Une demande de devis ? Nous aurons toujours une solution adaptée à vos besoins. Nous vous recontacterons très rapidement. 
        </p>

        <fieldset>
          <label for="nom">Nom (requis)*</label>
          <input id="nom" name="nom" type="text" placeholder="Nom ..." required>
        </fieldset>

        <fieldset>
          <label for="entreprise">Entreprise</label>
          <input id="entreprise" name="entreprise" type="text" placeholder="Entreprise ...">
        </fieldset>

        <fieldset>
          <label for="telephone">Telephone</label>
          <input id="telephone" name="telephone" type="number" placeholder="Telephone ...">
        </fieldset>

        <fieldset>
          <label for="email">Email (requis)*</label>
          <input id="email" name="email" type="email" placeholder="Email ..." required>
        </fieldset>

        <fieldset>
          <label for="sujet">Sujet (requis)*</label>
          <input id="sujet" name="sujet" type="text" placeholder="Sujet ..." required>
        </fieldset>

        <fieldset>
          <label for="message">Message (requis)*</label>
          <textarea name="message" id="message" cols="30" rows="10" placeholder="Message ..." required></textarea>
        </fieldset>

        <p class="message-form <?=$alert?>"><?php echo $alertMessage ?></p>

        <input type="submit" name="envoye" value="Envoyer"/>
      </form>

      <!-- Right contact -->
      <div class="right-contact">
        <div class="bg-img"></div>
        <div class="points"></div>
        <h3>I.C.P Installateur Chauffage Plomberie</h3>
        <div class="adress">
          <img src="./icons/home-icon.svg" alt="home icon">
          <p>36 Rue de l’isle-adam, 95520 Mery sur Oise</p>
        </div>
        <a href="mailto:Icp.entreprise.contact@gmail.com" class="tel">
          <img src="./icons/mail-icon.svg" alt="mail icon">
          <p>Icp.entreprise.contact@gmail.com</p>
        </a>
      </div>
    </section>

    <!-- FOOTER -->
    <div class="footer_container"></div>
    <script src="script.js"></script>
    <script>
      function openNav() {
        document.querySelector('.nav').classList.toggle('active');
        document.querySelector('.burger-icon').classList.toggle('active');
      }
    </script>
  </body>
</html>