<?php

function checkCreateDevis(&$errors, $client) {
  $letsgo = true;
  if (is_null($client)) {
    $errors[] = "Un nom de client est attendu pour la création de devis";
    $letsgo = false;
  }
  return $letsgo;
}

function checkUpdateClient(&$errors, $devis, $modifiable, $client, &$info) {
  $letsgo = true;
  if (is_null($devis)) {
    $errors[] = "Un numéro de devis est attendu pour la modification d'un client";
    $letsgo = false;
  }
  if (!$modifiable) {
    $errors[] = "Le devis n°" . $devis . " n'est plus modifiable";
    $letsgo = false;
  }
  if (is_null($client)) {
    $errors[] = "Un nouveau nom de client est attendu pour la modification du client d'un devis";
    $letsgo = false;
  }
  if ($client == $info['client']) {
    $errors[] = "Attention nouveau nom de client identique à l'ancien";
    $letsgo = false;
  }
  return $letsgo;
}

function checkCancelSignDevis(&$errors, $devis, $modifiable) {
  $letsgo = true;
  if (is_null($devis)) {
    $errors[] = "Un numéro de devis est attendu";
    $letsgo = false;
  }
  if (!$modifiable) {
    $errors[] = "Le devis n°" . $devis . " n'est plus modifiable";
    $letsgo = false;
  }
  return $letsgo;  
}

function checkDeleteUpdateDevisLine(&$errors, $devis, $modifiable, $todo, $modele, &$lignes, $qt) {
  $letsgo = true;
  if (is_null($devis)) {
    $errors[] = "Un numéro de devis est attendu";
    $letsgo = false;
  }
  if (!$modifiable) {
    $errors[] = "Le devis n°" . $devis . " n'est plus modifiable";
    $letsgo = false;
  }
  if (($todo!=0) && ($todo!=1)) {
    $errors[] = "Supprimer (0) ou modifier (1) uniquement";
    $letsgo = false;
  }
  if (!isset($lignes[$modele])) {
    $errors[] = "Aucune ligne correspondant au modèle " . $modele . " dans le devis n°" . $devis;
    $letsgo = false;
  }
  if (($todo==1) && ((!is_numeric($qt)) || ($qt != intval($qt)) || ($qt <= 0))) {
    $errors[] = "La quantité doit être une valeur entière strictement positive";
    $letsgo = false;
  }
  return $letsgo;  
}

function checkAddDevisLine(&$errors, $db, $devis, $modifiable, $modele, &$lignes, $qt) {
  $letsgo = true;
  if (is_null($devis)) {
    $errors[] = "Un numéro de devis est attendu";
    $letsgo = false;
  }
  if (!$modifiable) {
    $errors[] = "Le devis n°" . $devis . " n'est plus modifiable";
    $letsgo = false;
  }
  if (isset($lignes[$modele])) {
    $errors[] = "Une ligne concernant le modèle " . $modele . " est déjà présente dans le devis n°" . $devis;
    $letsgo = false;
  }
  if (!isModel($db, $modele)) {
    $errors[] = "Aucun produit ayant pour modèle " . $modele;
    $letsgo = false;
  }
  if ((!is_numeric($qt)) || ($qt != intval($qt)) || ($qt <= 0)) {
    $errors[] = "La quantité doit être une valeur entière strictement positive";
    $letsgo = false;
  }
  return $letsgo;  
}

