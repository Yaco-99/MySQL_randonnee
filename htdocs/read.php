<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/basics.css" media="screen" title="no title" charset="utf-8">
</head>
<body>
<a href="create.php">add new</a>
    <table>
    <tr>
        <th>Name</th>
        <th>Difficulty</th>
        <th>Distance</th>
        <th>Duration</th>
        <th>Height Difference</th>
        <th>available</th>
    </tr>
    <?php
        require 'connect.php';
        $sql= $pdo->query('SELECT * FROM hiking');
        while($rows = $sql->fetch()){
            echo '<tr><td><a href="update.php?id='.$rows['id'].'">'.$rows['name'].'</a></td><td>'.$rows['difficulty'].'</td><td>'.$rows['distance'].'</td><td>'.$rows['duration'].'</td><td>'.$rows['height_difference'].'</td><td>'.$rows['available'].'</td><td><a class="button" href="delete.php?id='.$rows['id'].'">DELETE</a></td>';
        }
        $sql->closeCursor();
    ?>
    </table>
</body>
</html>