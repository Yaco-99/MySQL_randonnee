<?php
require_once 'verification.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Ajouter une randonnée</title>
	<link rel="stylesheet" href="css/basics.css" media="screen" title="no title" charset="utf-8">
</head>
<body>
    <?php
require 'connect.php';
$id = $_GET['id'];
$variable = $pdo->prepare('SELECT * FROM hiking WHERE id=?');
$variable->execute(array($id));
while ($rows = $variable->fetch()) {
    $name = $rows['name'];
    $difficulty = $rows['difficulty'];
    $distance = $rows['distance'];
    $duration = $rows['duration'];
    $height = $rows['height_difference'];
    $available = $rows['available'];
}
$variable->closeCursor();
if (isset($_POST['button'])) {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $difficulty = filter_var($_POST['difficulty'], FILTER_SANITIZE_STRING);
    $distance = filter_var($_POST['distance'], FILTER_SANITIZE_STRING);
    $duration = preg_replace("([^0-9:])", "", $_POST['duration']);
    $height = filter_var($_POST['height_difference'], FILTER_SANITIZE_NUMBER_FLOAT);
    $available = filter_var($_POST['available'], FILTER_SANITIZE_STRING);
    $sql = 'UPDATE hiking
                    SET
                        name = "' . $name . '",
                        difficulty = "' . $difficulty . '",
                        distance = ' . $distance . ',
                        duration = "' . $duration . '",
                        height_difference =' . $height . ',
                        available = "' . $available . '"
                    WHERE
                        id=' . $id;

    $nb = $pdo->exec($sql);
    echo '<script>alert("hiking updated successfully")</script>';
}
?>
	<a href="/read.php">Liste des données</a>
	<h1>Ajouter</h1>
	<form action="" method="post">
		<div>
			<label for="name">Name</label>
			<input type="text" name="name" value="<?php echo $name ?>">
		</div>
		<div>
			<label for="difficulty">Difficulté</label>
			<select name="difficulty">
				<option value="très facile">Très facile</option>
				<option value="facile">Facile</option>
				<option value="moyen">Moyen</option>
				<option value="difficile">Difficile</option>
				<option value="très difficile">Très difficile</option>
			</select>
		</div>

		<div>
			<label for="distance">Distance</label>
			<input type="text" name="distance" value="<?php echo $distance ?>">
		</div>
		<div>
			<label for="duration">Durée</label>
			<input type="duration" name="duration" value="<?php echo $duration ?>">
		</div>
		<div>
			<label for="height_difference">Dénivelé</label>
			<input type="text" name="height_difference" value="<?php echo $height ?>">
		</div>
        <select name="available">
				<option value="true">true</option>
				<option value="false">false</option>
		</select>
		<button type="submit" name="button">Envoyer</button>
	</form>
</body>
</html>