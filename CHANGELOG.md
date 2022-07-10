# Changelog
## [4.2.0] - 10.07.2022
* Dodano nową funkcję clan() służy ona do zakładania kanałów gildyjnych. Aktualnie funkcja  jest w fazie beta i może nie działać prawidłowo.
* Dodano nową funkcję monitoringPublicChannels() służy ona do  monitorowania publicznych kanałów i w razie potrzeby dodaje kanał.
* Naprawiono kilka znanych błędów
* Przygotowanie kodu do wersji PHP 8

## [4.1.9] - 13.12.2020
* Dodano w channeMessege() możliwość wyboru czy ma dostawać poke czy wiadomość na PW, oraz bot nie będzie wysyłał już wiadomości po restarcie.
* Naprawa błędów.
* Dodanie możliwości wyboru języka (aktualnie jest tylko Polski, ale w przyszłości postaram się zrobić jeszcze Angielski).

## [4.1.8] - 07.11.2020
* Dodanie komendy !kobieta i !mezczyzna, która słóży do rejestracji.
* Naprawa błędów.

Aby zaktualizować bota należy użyć ./start.sh update, żeby dodać komendy do bazy oraz zaktualizować config_cmd.php.

## [4.1.7] - 17.10.2020
* Naprawa funkcji statusTwitch(), oraz usprawnienie.
* Naprawa błędu w channelCreate().
* Naprawa błędu w welcomeMessege().

## [4.1.6] - 28.06.2020
* Optymalizacja funkcji Lvl() od teraz zapytanie do bazy wykonuje się raz na minute.
* Zmiany w funkcji welcomeMessege() od teraz można użyć większej ilości zmiennych które są opisane w configu.
* Dodanie funkcji channeMessege(), która wysyła wiadomość po wejściu na dany kanał.
* Poprawki błędów oraz optymalizacja.

## [4.1.5] - 30.04.2020
* Dodano nową funkcję DdosInfo(), która wysyła wiadomość do podanych grup o tym, że prawdopodomnie jest przeprowadzany atak.
* Dodanie do komendy stats informacji o lvl oraz posiadanym expie.
* Naprawiono komendę usersinfo.
* Naprawa błędu w GroupOnline().
* Zabezpieczenie przed zbyt długim opisem w NewUser() od teraz będzie wyświetlać tylko 61 osób i w razie większej liczby osób dopisywać "oraz x innych".
* Od teraz WelcomeMessege nie będzie wysyłać wiadomości po restarcie bota.
* Powolne przejście z DBID na CUID.
* Optymalizacja bazy danych.

Aby zaktualizować bota należy wpisać ./start.sh update w razie błędu proszę sprawdzić czy w bazie danych w tabeli users nie ma duplikatów i je usunąć.
Zapytanie które pozwoli sprawdzić SELECT COUNT(cui), cui FROM users GROUP BY cui HAVING COUNT(cui)>1

## [4.1.5] - 30.04.2020
* Dodano nową funkcję DdosInfo(), która wysyła wiadomość do podanych grup o tym, że prawdopodomnie jest przeprowadzany atak.
* Dodanie do komendy stats informacji o lvl oraz posiadanym expie.
* Naprawiono komendę usersinfo.
* Naprawa błędu w GroupOnline().
* Zabezpieczenie przed zbyt długim opisem w NewUser() od teraz będzie wyświetlać tylko 61 osób i w razie większej liczby osób dopisywać "oraz x innych".
* Od teraz WelcomeMessege nie będzie wysyłać wiadomości po restarcie bota.
* Powolne przejście z DBID na CUID.
* Optymalizacja bazy danych.

Aby zaktualizować bota należy wpisać ./start.sh update w razie błędu proszę sprawdzić czy w bazie danych w tabeli users nie ma duplikatów i je usunąć.
Zapytanie które pozwoli sprawdzić SELECT COUNT(cui), cui FROM users GROUP BY cui HAVING COUNT(cui)>1

## [4.1.4] - 22.03.2020
* Zmiany w lvl.
* Poprawki błędów.

## [4.1.3] - 09.01.2020
* Aktualizacja API w funkcji statusTwitch() oraz dodanie możliwości włączenia wiadomości gdy zacznie się live.
* Naprawienie błędu z only_full_group_by.
* Poprawka kilku innych drobnych błędów.

Aby zaktualizować bota należy zrobić backupa, pobrać pliki, nadpisać oraz wpisać ./start.sh update
W razie błędu przy aktualizacji należy ponowanie skonfigurować bota


## [4.1.2] - 15.09.2019
* Naprawa kilku błędów
* Od teraz w większości komend zamiast dbid lub uid można podać nick ( żeby nick zadziałał osoba ta musi być online i jeżeli nick osoby składa się z kilku członów należy go podać w "" przykładowo "Andrzej Grabowski"
* Dodałem komendę !give która pozwala przekazać monety

## [4.1.1] - 06.06.2019
* Dodanie funkcji banhistory(), która zapisuje w bazie wszystkie bany co pozwala sprawdzić komendą !banhistory czy użytkownik o podanym DBID lub UID miał wcześniej bana.
* Dodanie funkcji lvl(), która pozwala zdobywać exp oraz awansować na wyższy lvl. Bot może też nadawać rangi po wbiciu lvl.
* Dodanie funkcji points(), która pozwala zdobywać punkty za siedzenie na ts. Punkami można sprawdzić za pomocą komendy !punkty oraz można nimi grać za pomocą komendy !gamble.
* Dodanie funkcji visit(), która ustawia w nazwie kanału liczbę osób, które odwiedziły serwer.
* Dodatkowo poprawiona została funkcja statusTwitch() oraz dodano możliwość ustawienia w nazwię czy strim jest online czy też offline.
* Poprawienie kilku drobnych błędów.

Aktualizacja wymaga ponownego konfigurowania bota lub dodanie brakujących opcji w configu oraz wykonania pliku update2.php jeżeli aktualizujesz bota z poprzedniej wersji.

## [4.0.0] - 05.04.2019
* Przebudowa silnika.
* Przejście z sqlite na MySql.
* Dodanie funkcji adminLog(), która zapisuje logi podanych grup.
* Dodanie funkcji limitIp(), która wywala z serwera po przekroczeniu liczby osób z tego samego IP.
* Dodano komendę adminlog, która wyświetla ostatnie akcje użytkownika o podanych ID.
* Poprawienie kilku drobnych błędów.

## [3.0.0] - 05.04.2018
* Podzieliłem bota na dwie instancje, żeby uniknąć laga.
* Zmiany w odbieraniu wiadomości wysłanych do bota. Od teraz oba boty, które wchodzą na serwer są w stanie odbierać wiadomości, co prawda nie działa to jeszcze, aż tak dobrze, jak powinno, ale działa i będę starał się to poprawić.
* Nowe komendy
    * addcmd - dodaje komendy tekstowe do bota.
    * channelowner - służy do oddania owera kanału prywatnego (wymaga dodatkowej konfiguracji w pliku config_cmd.php).
    * channelpin - pozwala odzyskać kanał właścicielowi, jeżeli np. zmieni uid (wymaga podania pinu, który jest wysyłany przy zakładaniu kanału można to wyłączyć w config.php).
    * delcmd - usuwa komendę tekstową.
    * delgroup - pozwala zabrać sobie grupy.
    * givegroup - pozwala nadać sobie grupę (wymaga podania grup możliwych do nadania w config_cmd.php).
    * groupcmd - pozwala ustawić wymaganą grupę do użycia komendy.
    * help - wyświetla listę dostępnych komendy.
    * poke - puka użytkowników z podanej grupy lub wszystkich, którzy znajdują się na ts.
    * staff - pozwala nadać indywidualne uprawnienia do komend podanemu użytkownikowi.
    * staffcmd - pozwala ustawić wymagane indywidualne uprawnienia do użycia podanej komendy.
    * staffcmdtxt - pozwala ustawić wymagane indywidualne uprawnienia do użycia podanej komendy tekstowej.
    * stats - wyświetla nasze statystki lub podanego użytkownika.
    * serinfo - wyświetla szczegółowe informacje o użytkowniku (wymaga dodatkowej konfiguracji w pliku config_cmd.php).
* Kilka drobnych poprawek.

Aktualizacja wymaga ponownego konfigurowania bota lub dodanie brakujących opcji w configu oraz wykonania pliku update.php.

## [2.9.0] - 07.10.2018
* Dodanie funkcji banList(), która w opisie kanału ustawia listę osób zbanowanych.
* Dodanie funkcji clearImg(), która usuwa zakazane linki w tagu [img].
* Dodanie daty pobicia rekordu w opisie kanału.
* Dodanie drugiej instalacji, która służy do komend [BETA].

## [2.8.0] - 12.04.2018
* Dodanie funkcji delInfoChannel() funkcja ustawia w opisie kanału listę kanałów, które zostaną usunięte w najbliższym czasie.
* Przebudowa funkcji poke() co sprawiło lepsze działanie oraz konfiguracje.
* Naprawiono błąd, przez który ucinało topki.
* Kilka drobnych poprawek oraz zmian w konfiguracji bota.

## [2.7.2] - 01.03.2018
* Dodanie funkcji delPermissions(), która zabiera prywatne uprawnienia.
* Dodanie licznika do funkcji newUse().
* Dodanie awataru do funkcji statusYt().
* Zastępiono ostatniego ss z gry awatarem w funkcji statusTwitch().
* Naprawiono błąd w funkcji sprchannel(), który powodował, że sprawdzało oraz zmieniało tylko jeden podkanał.


## [2.7.0] - 27.02.2018
* Rozbicie funkcji na dwa pliki.
* Dodano funckję moveAfk() do przenoszenia osób nieaktywnych na kanał o podanym ID
* Dodano funkcję newUser(), która w opisie kanału ustawia osoby zarejestrowane w przeciągu 24h (Czas można ustawić w configu).
* Dodatkowa konfiguracja bota w config.php
* Poprawka kilku błedów złgoszonych przez Bloodthirster 

Aktualizacja wymaga ponownego konfigurowania bota lub dodanie brakujących opcji w configu oraz wykonania pliku update.php.
Wystarczy wpisać php update.php.

## [2.3.4] - 15.12.2017
* Zmiana funkcji admins_ts_online() na groupOnline()
* Poprawienie kilku drobnych błędów.

## [2.2.1] - 04.12.2017
* Dodanie funkcji statusYt(), która ustawia w opisie kanału takie informacje jak liczba subskrypcji, liczba wyświetleń oraz zmienia nazwę kanału na nick z liczbą subskrypcji.
* Poprawienie kilku drobnych błędów.

## [2.1.1] - 17.09.2017
* Dodanie funkcji sendAd(), która wysyła losową wiadomość.
* Dodanie funkcji statusTwitch(), która ustawia w opisie status na kanale twitch.
* Dodano TOP 10 najdłuższe połączenie oraz TOP 10 najwięcej połączeń.
* Zmiana API do AntyVPN.
* Kilka drobnych poprawek.

Aktualizacja wymaga ponownego konfigurowania bota lub dodanie brakujących opcji w konfigu oraz wykonania pliku update.php.
Wystarczy wpisać php update.php.

## [2.0.6] - 25.06.2017
* Dodanie funkcji addrank(), która ustawia rangę po wejściu na kanał.
* Dodanie możliwości ustawienia opisu kanału można podać %CLIENT_NICKNAME% - Nick właściciela %DATE% - Data założenia %HOUR% - Godzina założenia.
* Dodano możliwość wyboru czy ma pukać administratora czy wysyłać prywatną wiadomość.
* Poprawienie błędu, gdzie podczas zakładania kanału nie dodawało sub kanału.
* Poprawienie błędu z odświeżaniem administracji online podziękowania za zgłoszenie dla Pir3x.
* Poprawienie błędu z numerowaniem kanałów prywatnych podziękowanie za zgłoszenie dla Majako.
* Inne drobne poprawki.
Aktualizacja wymaga ponownego konfigurowania bota lub dodanie brakujących opcji w konofitu.

## [2.0.4] - 17.06.2017
* Poprawki w kodzie - dodanie elementów statycznych.
* Naprawa błędu w funkcji sprchannel wynikającego z błędnego klucza.
Aktualizacja ta wymaga nadpisania config.php lub edycji linijki 149 mianowicie zamiany 'cid' na 'pid'.


## [2.0.3] - 12.06.2017

* Dodano funkcję ChannelNumber (), która ustawia numer kanału w razie jego braku.
* Zmniejszenie spamu, który wywoływała funkcja admits_ts_online().
