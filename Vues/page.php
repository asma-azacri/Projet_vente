<?php 

function page_header($title, $errors) {?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
  	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="Content-Language" content="fr" />
		<title><?php echo $title; ?></title>
	</head>
	<body>
<?php if (!empty($errors)) {
  echo '<p>Erreurs :<p>';
  echo '<ul>';
  foreach($errors as $error) {
    echo '<li><p><it>' . $error . '</it></p></li>';
  }
  echo '</ul>';
}
?>
    <h1><?php echo $title; ?></h1>
<?php }


function page_footer() {?>
	</body>
</html>
<?php }
