<?php
// Formularz logowania. Pojawia się przy braku ciastek lub przy wylogowaniu.
if(!isset($_POST["start_game"]) || !isset($_COOKIE['player_one']) || isset($_GET['logout'])) {
//    unset($_POST['start_game']);
    unset($_POST['player_one']);
    unset($_POST['player_two']);
    setcookie('player_one', '', 0);
    setcookie('player_two', '', 0);
    unset($_COOKIE['player_one']);
    unset($_COOKIE['player_two']);
    include("header.html");
    include("form.html");
    include("footer.html");
} // Jeśli reset gry zawiera result to pchaj do db
elseif (isset($_GET['reset']) && isset($_GET['result'])) {
    push_to_db();
    include("header.html");
    include("game.html");
    include("footer.html");
} // Reset gry
elseif (isset($_GET['reset'])) {
    include("header.html");
    include("game.html");
    include("footer.html");
} // Gra.
elseif (isset($_POST["start_game"])) {
    set_game_cookies();
    include("header.html");
    include("game.html");
    include("footer.html");
} // Zakończenie gry. Wyświetlany jest panel gracza z historią.
//elseif (isset($_COOKIE['player_one']) || isset($_GET['end_game'])) {
//    include ("header.html");
//    include ("history.html");
//    include ("footer.html");
//}

// funkcja do zapisywania graczy do ciasteczek
function set_game_cookies() {
    setcookie('player_one', $_POST['player_one']);
    setcookie('player_two', $_POST['player_two']);
}

// funkcja do umieszczania wyników w bazie danych
function push_to_db() {
    try {
        $dbuser = 'root'; $dbpass = null;
        $db = new PDO("mysql:host=localhost;dbname=wprg_project", $dbuser, $dbpass, array(
            PDO::ATTR_PERSISTENT => true
        ));
        $zapis = $db->prepare("INSERT INTO games(p1, p2, result, f0, f1, f2, f3, f4, f5, f6, f7, f8) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
        $zapis->execute(array($_COOKIE['player_one'], $_COOKIE['player_two'], $_COOKIE['result'],
            $_COOKIE['f0'], $_COOKIE['f1'], $_COOKIE['f2'], $_COOKIE['f3'], $_COOKIE['f4'],
            $_COOKIE['f5'], $_COOKIE['f6'], $_COOKIE['f7'], $_COOKIE['f8']));
    } catch (PDOException $PDOException) {
        print $PDOException;
    }
}
