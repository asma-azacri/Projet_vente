<?php
function price($num) { return number_format($num, 2, ',', ' '); }
?>

<h2>Devis n°<b><?php echo $devis; ?></b></h2>

<ul>
  <li>
<?php if ($modifiable) { ?>
    <form>
      <input type="hidden" value="2" name="action" />
      <input type="hidden" value="<?php echo $devis; ?>" name="devis" />
      Client :
      <input type="text" value="<?php echo $info['client']; ?>" name="client" />
      <input type="submit" value="Modifier" />
    </form>
<?php } else { ?>
    <p>Client : <b><?php echo $info['client']; ?></b></p>
<?php	} ?>
  </li>
  <li><p>Date de création : <b><?php echo $info['date']; ?></b></p></li>
  <li>
<?php switch ($info['status']) {
  case 'annule': echo '<p>Etat : <b>Annulé</b></p>'; break;
	case 'signe': echo '<p>Etat : <b>Signé le '.$info['sign'].'</b></p>'; break;
	case 'encours':
    echo '<p>Etat : <b>En cours</b>';
    echo '<form method="get">';
		echo '<input type="hidden" value="3" name="action" />';
		echo '<input type="hidden" value="'.$devis.'" name="devis" />';
    echo '<button type="submit">Annuler</button>';
		echo '</form>';
    echo '<form method="get">';
		echo '<input type="hidden" value="4" name="action" />';
		echo '<input type="hidden" value="'.$devis.'" name="devis" />';
    echo '<button type="submit">Signer</button>';
		echo '</form></p>';
		break;
	}
?>
  </li>
  <li>
    <p>Détails :</p>
    <table width="85%" border="1px" align="center">
      <tr>
        <td width="10%">Modèle</td>
        <td>Description</td>
        <td width="10%">Quantité</td>
        <td width="10%">Prix unitaire</td>
<?php if ($modifiable) { ?>
        <td width="15%"></td>
<?php } ?>
      </tr>

<?php
$tot = 0;

foreach($lignes as $ligne) {
  echo '<tr>';
  if ($modifiable) {
    echo '<form>';
    echo '<input type="hidden" value="'.$devis.'" name="devis" />';
    echo '<input type="hidden" value="'.$ligne['modele'].'" name="modele" />';
    echo '<input type="hidden" value="5" name="action" />';
  }
  echo '<td>'.$ligne['modele'].'</td>';
  echo '<td>'.$ligne['type'].' produit par le fabricant '.$ligne['fabricant'].'</td>';
  if ($modifiable)
    echo '<td><input style="width: 100%;" type="text" name="qt" value="'.$ligne['quantite'].'" /></td>';
  else
    echo '<td>'.$ligne['quantite'].'</td>';
  echo '<td>'.price($ligne['prix']).'</td>';
  if ($modifiable) {
    echo '<td><button type="submit" style="width: 50%;" value="1" name="todo">Mod.</button>';
    echo '<button type="submit" style="width: 50%;" value="0" name="todo">Supp.</button></td>';
    echo '</form>';
  }
  echo '</tr>';
  $tot += $ligne['quantite'] * $ligne['prix'];
}
?>

<?php if ($modifiable) { ?>
      <tr><form>
				<input type="hidden" value="<?php echo $devis; ?>" name="devis" />
				<input type="hidden" value="6" name="action" />
        <td><input style="width: 100%;" type="text" name="modele" value="" /></td>
				<td></td>
				<td><input style="width: 100%;" type="text" name="qt" value="1" /></td>
				<td></td>
				<td><input type="submit" style="width: 100%;" value="Ajouter" name="todo" /></td>
			</form></tr>
<?php } ?>
    </table>
  </li>

  <li><p>Total HT : <b><?php echo price($tot); ?>€</b></p></li>
  
  <li><p>Total TTC : <b><?php echo price($tot * 120.0 / 100.0); ?>€</b></p></li>
  
</ul>

