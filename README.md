# WPRG_projekt
## Kółko i krzyżyk 3x3 w PHP
### Projekt na zaliczenie Warsztatów Programowania na 4 semestrze PJATK w Gdańsku. 

Pole gry jest obsługiwane przez eventy JavaScript, co umożliwia manipulację polem gry przez klikanie. 

Logika gry również jest obsługiwana przez JS. 

Po ukończeniu rozgrywki możliwy jest zapis stanu gry do bazy danych. Dane z JS (rezultat i pole gry) są przekazywane do skryptu PHP przez query string. Skrypt PHP ma do nich automatyczny dostęp przez zmienną globalną $_GET. 

Skrypt PHP wykorzystuje ciasteczka do zarządzania "kontami". Imię gracza wpisanego w pierwszym polu formularza jest zmienną wykorzystywaną do pobierania danych z bazy danych. Właśnie taki mechanizm umożliwia podgląd historii przeszłych rozgrywek. 

Dodatkowo wysyłane zapytania są wykorzysywane do dynamicznego generowania strony przez skrypt w index.php. 

Ciastka pozwalają na "zalogowanie się" na swoje konto w celu pobrania danych z mySQL (tak naprawdę w ciastkach jest przechowywane jedynie imię pierwszego i drugiego gracza). 

Wykorzystałem program XAMPP do postawienia serwera lokalnego (Apache) oraz lokalnej bazy danych (MySQL, a dokładnie MariaDB). 

Dane do bazy znajdują się w skrypcie w index.php oraz history.php.