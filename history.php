<?php
// połącznie z bazą danych
try {
    $dbuser = 'root'; $dbpass = null;
    $db = new PDO("mysql:host=localhost;dbname=wprg_project", $dbuser, $dbpass, array(
        PDO::ATTR_PERSISTENT => true
    ));
    // zapytanie z bazy danych
    $znajdzWiersze = $db->prepare("SELECT * FROM games WHERE p1=? or p2=?;");
    $znajdzWiersze->execute(array($_COOKIE['player_one'], $_COOKIE['player_one']));
} catch (PDOException $PDOException) {
    print $PDOException;
}

echo "<h1>Witaj {$_COOKIE['player_one']}</h1>";
echo "<h2>Oto historia twoich rozgrywek</h2>";
?>
<!-- Dynamicznie generowana tabela na bazie wartości z bazy danych -->
<table>
    <tr>
        <th>Jako</th>
        <th>Przeciwnik</th>
        <th>Stan gry</th>
        <th>Data</th>
        <th>Plansza</th>
    </tr>
<?php
if (isset($znajdzWiersze)) {
    while($row = $znajdzWiersze->fetch()) {
        if($row['p1'] == $_COOKIE['player_one']){
            echo "
            <tr>    
                <td>X</td>
                <td>{$row['p2']}</td>
                <td>";
            switch ($row['result']){
                case 'w':
                    echo "Wygrana";
                    break;
                case 'l':
                    echo "Przegrana";
                    break;
                case 'd':
                    echo "Remis";
                    break;
            }
        } elseif ($row['p2'] == $_COOKIE['player_one']) {
            echo "
            <tr>    
                <td>O</td>
                <td>{$row['p1']}</td>
                <td>";
            switch ($row['result']){
                case 'w':
                    echo "Przegrana";
                    break;
                case 'l':
                    echo "Wygrana";
                    break;
                case 'd':
                    echo "Remis";
                    break;
            }
        }
        echo "
        </td>
         <td>{$row['datetime']}</td>
         <td>
            <table>
                <tr>
                    <td>{$row['f0']}</td>
                    <td>{$row['f1']}</td>
                    <td>{$row['f2']}</td>
                </tr>   
                <tr>
                    <td>{$row['f3']}</td>
                    <td>{$row['f4']}</td>
                    <td>{$row['f5']}</td>
                </tr>
                <tr>
                    <td>{$row['f6']}</td>
                    <td>{$row['f7']}</td>
                    <td>{$row['f8']}</td>
                </tr>
            </table>
        </td>
    </tr>";
    }
} else {
    echo "
        <tr>
            <td>NIE MOŻNA POBRAĆ DANYCH Z BAZY DANYCH</td>
            <td>Możliwe przyczyny: brak danych,</td>
            <td>błędne zapytanie lub</td>
            <td>brak połączenia z bazą.</td>
        </tr>";
}
?>
</table>
<br>
<a href="index.php?game=true">Rozpocznij grę</a>
<br>
<a class="logout" href="index.php?logout=true">Wyloguj</a>
