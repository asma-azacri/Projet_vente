<?php

function getAllDevisInfo($db) {
  $nums = array();
  $req = $db->prepare('SELECT * FROM Devis ORDER BY dateCreation');
  $req->execute();
  while($tuple = $req->fetch()) {
    $info = array();
    $info['devis']  = $tuple['num'];
    $info['date']   = strftime("%d/%m/%Y",strtotime($tuple['dateCreation']));
    $info['client'] = $tuple['client'];
    $info['status'] = $tuple['status'];
    $info['sign']   = strftime("%d/%m/%Y",strtotime($tuple['dateSign']));
		$nums[$tuple['num']] = $info;
  }
  return $nums;
}

function getLines($db, $devis) {
  $req = $db->prepare('SELECT * FROM LigneDevis l, Produit p
                       WHERE l.numDevis = :devis
                       AND p.modele = l.modele');
  $req->bindValue(':devis', $devis, PDO::PARAM_STR);
  $req->execute();
  $lines = array();
  while($tuple = $req->fetch())
    $lines[$tuple['modele']] = $tuple;
  return $lines;
}

function createDevis($db, $client) {
  
	$req = $db->prepare('SELECT COUNT(DISTINCT num) AS cpt,
                              EXTRACT(YEAR FROM CURRENT_DATE) as curyear,
                              CURRENT_DATE as curdate
                       FROM Devis
                       WHERE EXTRACT(YEAR FROM dateCreation) = EXTRACT(YEAR FROM CURRENT_DATE);');
	$req->execute();
  $tuple = $req->fetchAll()[0];
	$date = $tuple['curdate'];	
	$num = sprintf("D%s%2$05d",$tuple['curyear'],$tuple['cpt']+1);

	// On insère un nouveau tuple dans la base Devis
	$req = $db->prepare('INSERT INTO Devis(num,dateCreation,client,status) VALUES (:num,:date,:client,\'encours\');');
  $req->bindValue(':num', $num, PDO::PARAM_STR);
  $req->bindValue(':date', $date, PDO::PARAM_STR);
  $req->bindValue(':client', $client, PDO::PARAM_STR);
	$req->execute();
  return $num;
}

function updateClient($db, $devis, $client) {
  $req = $db->prepare('UPDATE Devis
                       SET client = :client
                       WHERE num = :devis;');
  $req->bindValue(':devis', $devis, PDO::PARAM_STR);
  $req->bindValue(':client', $client, PDO::PARAM_STR);
	$req->execute();
}

function signDevis($db, $devis) {

  $req = $db->prepare("UPDATE Devis SET status ='signe',dateSign =CURRENT_DATE WHERE num =:devis and status ='encours';"); 
  $req->bindValue(':devis', $devis, PDO::PARAM_STR);
  
  $req->execute();
  // Signe le devis, cad
  //   - fait passer l'attribut dateSign de NULL à CURRENT_DATE dans la BD
  //   - fait passer le status de 'encours' à 'signe'
  // Pre-condition : $devis est modifiable
}

function cancelDevis($db, $devis) {
  $req = $db->prepare("UPDATE Devis SET status ='annule',dateSign =CURRENT_DATE WHERE num =:devis and status ='encours' ;"); 
  $req->bindValue(':devis', $devis, PDO::PARAM_STR); 
  $req->execute();

}

function deleteDevisLine($db, $devis, $modele) {
  $req = $db->prepare("DELETE FROM LigneDevis WHERE  numDevis=:devis and modele =:model;"); 
  $req->bindValue(':devis', $devis, PDO::PARAM_STR);
  $req->bindValue(':model', $modele, PDO::PARAM_STR);
  $req->execute();

 
}

function updateDevisLine($db, $devis, $modele, $qt) {

  $req = $db->prepare("UPDATE LigneDevis SET quantite= :qt  WHERE numDevis =:devis and quantite > 0 and modele=:model ;"); 
  $req->bindValue(':devis', $devis, PDO::PARAM_STR);
  $req->bindValue(':qt', $qt, PDO::PARAM_STR);
  $req->bindValue(':model', $modele, PDO::PARAM_STR);

  $req->execute();


  
}

function addDevisLine($db, $devis, $modele, $qt) {
  $req = $db->prepare('INSERT INTO LigneDevis(numDevis,modele,quantite) VALUES (:devis,:modele,:qt);');
  $req->bindValue(':devis', $devis, PDO::PARAM_STR);
  $req->bindValue(':modele', $modele, PDO::PARAM_STR);
  $req->bindValue(':qt', $qt, PDO::PARAM_STR);
  $req->execute();
  
}

function isModel($db, $modele) {
  // Retourne s'il existe un produit dont le modele est $modele
  return false;
}


