<h2>Liste des devis</h2>

<?php // Affichage de la liste des devis dans un menu déroulant ?>

<p>
  <form method="get">
    <select name="devis" onChange="this.form.submit();">
      <option value="" selected="selected">-- Choix d'un devis --</option>
<?php foreach($devisInfo as $num => $info)
        if ($num != $devis) {
?>
      <option value="<?php echo $num; ?>"><?php echo $num; ?></option>
<?php } ?>
    </select>
  </form>
</p>

<p>ou</p>

<?php // Affichage d'un bouton permettant la création d'un nouveau devis ?>

<p>
  <form method="get">
    <input type="hidden" value="1" name="action" />
    <input type="submit" value="-- Création d'un devis --" />
    pour
    <input type="text" name="client" />
  </form>
</p>
