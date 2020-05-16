<?php

/* Récupération des valeurs des champs du formulaire */
$nom = $_POST['nom'];
$entreprise = $_POST['entreprise'];
$telephone = $_POST['telephone']; 
$expediteur = $_POST['email']; 
$sujet = $_POST['sujet']; 
$message = $_POST['message'];

/* Destinataire (votre adresse e-mail) */
$to = 'dimitri.vildina@gmail.com';
 
/* Construction du message */
$msg  = 'Bonjour,'."\r\n\r\n";
$msg .= 'Ce mail a été envoyé depuis monsite.com par'.$nom."\r\n\r\n";
$msg .= 'Voici le message qui vous est adressé :'."\r\n";
$msg .= '***************************'."\r\n";
$msg .= $message."\r\n";
$msg .= '***************************'."\r\n";
 
/* En-têtes de l'e-mail */
$headers = 'From: '.$nom.' <'.$expediteur.'>'."\r\n\r\n";
 
/* Envoi de l'e-mail */
$result = mail($to, $sujet, $msg, $headers);

/* Test de mail */
if(!$result)
{
    echo "Error";
} else 
{
    header('Location: '.$_SERVER['HTTP_REFERER']);
}
