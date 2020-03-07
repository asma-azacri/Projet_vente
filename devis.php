<?php   

require_once 'Modeles/config.php';
require_once 'Modeles/Devis/queries.php';
require_once 'Controleurs/Devis/checks.php';
require_once 'Vues/page.php';

// Initialisation du tableau des erreurs
$errors = array();

// Connexion à la base de données et entrée en transaction (atomicité de la construction de la page)
$db = dbConnect();
$db->beginTransaction();

// Traitement de la variable $GET et initialisation des variables

/// Récupération des informations concernant tous les devis
$devisInfo = getAllDevisInfo($db);

/// Information du devis $_GET[$devis] s'il est demandé
$devis = null;
$info = null;
$lignes = null;
$modifiable = false;
if (isset($_GET['devis'])) {
  $devis = $_GET['devis'];
  if (isset($devisInfo[$devis])) {
    $info = $devisInfo[$devis];
    $lignes = getLines($db, $devis);
    $modifiable = ($info['status'] == 'encours');
  } else {
    $errors[] = "Le devis n°" . $devis . " n'existe pas";
    $devis = null;
  }
}

/// Lorsqu'une action concerne un client
$client = null;
if (isset($_GET['client']) && ($_GET['client'] != ''))
  $client = $_GET['client'];

/// Lorsqu'une action concerne une ligne
$modele = null;
$qt = null;
$todo = null;
if (isset($_GET['modele']) && ($_GET['modele'] != ''))
  $modele = $_GET['modele'];
if (isset($_GET['qt']) && ($_GET['qt'] != ''))
  $qt = $_GET['qt'];
if (isset($_GET['todo']) && ($_GET['todo'] != ''))
  $todo = $_GET['todo'];


// Traitement des actions
$letsgo = true;
if (isset($_GET['action'])) {
  switch($_GET['action']) {
    case 1: // Création d'un nouveau devis
      if (checkCreateDevis($errors, $client)) {
        $devis = createDevis($db, $client);
        $db->commit();
        header('Location: ?devis='.$devis);
      }
      break;
    case 2: // Modification du client 
      if (checkUpdateClient($errors, $devis, $modifiable, $client, $info)) {
        updateClient($db, $devis, $client);
        $db->commit();
        header('Location: ?devis='.$devis);
      }
      break;
    case 3: // Annulation du devis
      if (checkCancelSignDevis($errors, $devis, $modifiable)) {
        cancelDevis($db, $devis);
        $db->commit();
        header('Location: ?devis='.$devis);
      }
      break;
    case 4: // Signature du devis
      if (checkCancelSignDevis($errors, $devis, $modifiable)) {
        signDevis($db, $devis);
        $db->commit();
        header('Location: ?devis='.$devis);
      }
      break;
    case 5: // Modification/Suppression d'une ligne
      if (checkDeleteUpdateDevisLine($errors, $devis, $modifiable, $todo, $modele, $lignes, $qt)) {
        if ($todo == 0) deleteDevisLine($db, $devis, $modele);
        if ($todo == 1) updateDevisLine($db, $devis, $modele, $qt);
        $db->commit();
        header('Location: ?devis='.$devis);
      }
      break;
    case 6: // Ajout d'une ligne
      if (checkAddDevisLine($errors, $db, $devis, $modifiable, $modele, $lignes, $qt)) {
        addDevisLine($db, $devis, $modele, $qt);
        $db->commit();
        header('Location: ?devis='.$devis);
      }
      break;
    default:
      $errors[] = "Action " . $_GET['action'] . " non-implémentée";
  }
}

// Sortie de la transaction (dans tous les cas rollBack car les actions réussies redirigent avec header)
$db->rollBack();


// Page
page_header('Gestion des devis', $errors);

if (!is_null($info))
  include 'Vues/Devis/detail.php';

include 'Vues/Devis/liste_devis.php';

page_footer();

