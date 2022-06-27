<?php
// połącznie z bazą danych
try {
    $dbuser = 'root'; $dbpass = null;
    $db = new PDO("mysql:host=localhost;dbname=wprg_project", $dbuser, $dbpass, array(
        PDO::ATTR_PERSISTENT => true
    ));
} catch (PDOException $PDOException) {
    print $PDOException;
}

//// do manipulacji DOM
//$doc_game = new DOMDocument;
//$doc_game->validateOnParse = true;
//$doc_game->loadHTMLFile('game.html');


if(!isset($_POST["start_game"])){

    include ("header.html");
    include ("form.html");
    include ("footer.html");
} elseif (isset($_POST["start_game"])){
    set_game_cookies();
    include ("header.html");
    include("game.html");
    include ("footer.html");
} elseif (isset($_COOKIE['result'])) {
    include ("header.html");
    var_dump($_COOKIE);
    include ("footer.html");
}

// funkcja do zapisywania graczy do ciasteczek
function set_game_cookies() {
    setcookie('player_one', $_POST['player_one']);
    setcookie('player_two', $_POST['player_two']);
}

//// funkcja od wyświetlania komunikatów
//function displayMessage($doc_game) {
//    $game_status = $doc_game->getElementById('queue')->getAttribute('game-status');
//    $inner_HTML = $doc_game->getElementById('queue');
//    if($game_status === 'wx') {
//        $inner_HTML->textContent = "WYGRAŁ {$_POST['player_one']}!!!";
//    } elseif ($game_status === 'wo') {
//        $inner_HTML->textContent = "WYGRAŁ {$_POST['player_two']}!!!";
//    } elseif ($game_status === 'draw') {
//        $inner_HTML->textContent = "Remis";
//    } elseif ($game_status === 'x') {
//        $inner_HTML->textContent = "Teraz gra {$_POST['player_one']}";
//    } elseif ($game_status === 'o') {
//        $inner_HTML->textContent = "Teraz gra {$_POST['player_two']}";
//    }
//    $doc_game->saveHTMLFile("game.html");
//}
