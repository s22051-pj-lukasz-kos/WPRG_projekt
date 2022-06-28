// tabela zawierająca wszelkie możliwości wygranej
const winningConditions = [
    [0, 1, 2],
    [3, 4, 5],
    [6, 7, 8],
    [0, 3, 6],
    [1, 4, 7],
    [2, 5, 8],
    [0, 4, 8],
    [2, 4, 6]
];
// komórki pola gry
const cells = document.querySelectorAll('.field')

// Miejsce do wyświetlania komunikatów z gry.
const gameStatus = document.querySelector(".queue");

// tabela zawierająca aktualny stan gry
let gameState = ["", "", "", "", "", "", "", "", ""];

// aktualny gracz
let currentPlayer = "x";

// Czy gra jest aktywna
let gameActive = true;

// zmienne zawierające nazwę graczy i PHPSESSID
let playerOne;
let playerTwo;
let phpsessid;

// zmienna do czytania ciasteczek
let cookies = document.cookie;
let cookiesArray = document.cookie.split(";");
// nazwa pierwszego i drugiego gracza oraz PHPSESSID
for (let i = 0; i < cookiesArray.length; i++) {
    if(cookiesArray[i].includes("player_one")) {
        playerOne = cookiesArray[i].match("(?<=player_one=).*");
    } else if (cookiesArray[i].includes("player_two")) {
        playerTwo = cookiesArray[i].match("(?<=player_two=).*");
    } else if (cookiesArray[i].includes("PHPSESSID")) {
        phpsessid = cookiesArray[i].match("(?<=PHPSESSID=).*");
    }
}

// funkcja do zarządzania klliknięciem
function handleClick(cellEvent) {
    const clickedCell = cellEvent.target;
    const clickedCellIndex = parseInt(clickedCell.getAttribute('cell-index'));

    // Warunki, kiedy komórka jest nieaktywna
    if (gameState[clickedCellIndex] !== '' || !gameActive) {
        return;
    }

    drawSymbol(clickedCell, clickedCellIndex);
    winningValidation();
}

// funkcja do rysowania symbolu
function drawSymbol(clickedCell, clickedCellIndex) {
    gameState[clickedCellIndex] = currentPlayer;
    // wstawia rysunek w zależności od gracza
    if (currentPlayer === 'x') {
        let cross = document.createElement("img");
        cross.setAttribute("src", "images/krzyzyk.jpg");
        clickedCell.appendChild(cross);
    } else {
        let circle = document.createElement("img");
        circle.setAttribute("src", "images/kolko.jpg");
        clickedCell.appendChild(circle);
    }
}
/*
Funkcja do sprawdzenia czy gracz wygrał.
Jeśli nie, zmieniany jest gracz.
Jednocześnie w wypadku wygranej lub remisu
przekazuje wynik do atrybutu HTML oraz
usuwa EventListiner na pola gry.
*/
function winningValidation() {
    let win = false;
    for (let i = 0; i < winningConditions.length; i++) {
        const condition = winningConditions[i];
        let a = gameState[condition[0]];
        let b = gameState[condition[1]];
        let c = gameState[condition[2]];
        if (a === '' || b === '' || c === '') {
            continue;
        }
        if (a === b && b === c) {
            win = true;
            break;
        }
    }

    if (win) {
        if (currentPlayer === 'x') {
            gameStatus.innerHTML = "WYGRYWA " + playerOne + "!!!";
            writeResultToCookies('w');
        } else {
            gameStatus.innerHTML = "WYGRYWA " + playerTwo + "!!!";
            writeResultToCookies('l')
        }
        gameActive = false;
        return;
    }
    let draw = !gameState.includes("");
    if (draw) {
        gameStatus.innerHTML = "Remis";
        writeResultToCookies('d');
        gameActive = false;
        return;
    }
    changePlayer();
}
/*
Funkcja do zapisywania stanu gry do cookies.
Funkcja w pierwszej kolejności tworzy ciasteczka
operując na zmiennej, by potem zapisać całość.
*/
function writeResultToCookies(result) {
    // PHPSESSID, player_one, player_two
    cookies = 'PHPSESSID=' + phpsessid + '; player_one=' + playerOne + '; player_two=' + playerTwo + '; ';
    // gameState (jako f1, f2)
    for (let i = 0; i < gameState.length; i++) {
        cookies = cookies + "; f" + i + "=" + gameState[i];
    }
    // result (w, l, d)
    cookies = cookies + "; result=" + result;
    // time (hh:mm:ss)
    // let date = new Date();
    // cookies = cookies + '; time=' + date.toLocaleTimeString();
    // zapis ciasteczek
    document.cookie = cookies;
}

// Funkcja do zmiany gracza (kolejki).
function changePlayer() {
    currentPlayer = currentPlayer === 'x' ? 'o' : 'x';
    displayMessage();
}

// Wyświetl komunikat kolejki
function displayMessage() {
    if (currentPlayer === 'x') {
        gameStatus.innerHTML = "Teraz gra " + playerOne;
    } else {
        gameStatus.innerHTML = "Teraz gra " + playerTwo;
    }
}

// funkcja do resetowania gry
function resetGame() {
    // reset gry i kolejki
    gameActive = true;
    currentPlayer = "x";
    displayMessage();
    // reset tabeli stanu gry
    for (let i = 0; i < gameState.length; i++) {
        gameState[i] = '';
    }
    
    // usunięcie symboli
    const fields = document.getElementsByClassName("field");
    for (const field of fields) {
        while(field.lastElementChild) {
            field.removeChild(field.lastElementChild);
        }
    }
}

//wyświetl komunikat o kolejce
displayMessage();
// Event listener na komórki pola gry
cells.forEach(cell => cell.addEventListener('click', handleClick));

// event listener na przycisk do resetowania
const resetButton = document.querySelector(".resetButton");
resetButton.addEventListener('click', resetGame);
