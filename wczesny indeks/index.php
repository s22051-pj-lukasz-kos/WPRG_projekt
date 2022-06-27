<?php
$dbuser = 'root'; $dbpass = null;
$db = new PDO("mysql:host=localhost;dbname=wprg_project", $dbuser, $dbpass, array(
    PDO::ATTR_PERSISTENT => true
));


if(!isset($_POST["start_game"])){
    include ("header.html");
    include ("form.html");
    include ("footer.html");
} elseif (isset($_POST["start_game"])){
    // zapis do bazy danych

    $zapis = $db->prepare("INSERT INTO games(p1, p2) VALUES (?, ?)");
    $zapis->execute(array($_POST["player_one"], $_POST["player_two"]));

    // wyświetlenie wyniku z bazy
    $znajdz = $db->prepare("SELECT ? FROM games");
    $znajdz->execute(['p2']);

    include ("header.html");
    echo "Witaj {$_POST['player_one']}";
    while($row = $znajdz->fetch()) {
        echo "Grałeś z $row";
        foreach ($row as $key => $value) {
            echo "$key => $value ";
        }

    }

    include ("footer.html");
}
