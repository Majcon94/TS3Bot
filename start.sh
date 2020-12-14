#!/bin/bash

	COL_GREEN="\x1b[32;01m"
	COL_RED="\x1b[31;02m"
	function text {
		echo -e "\x1b[$1 $2\e[0m"
	}

	function start {
		if ! screen -list | grep -q "botphp1"; then
			screen -AdmS botphp1 php bot.php -i 1
			text "32;01m" "Pomyslnie uruchomiono bota nr 1!"
		else
			text "31;02m" "Bot nr 1 jest juz uruchomiony!"
		fi
		if ! screen -list | grep -q "botphp2"; then
			screen -AdmS botphp2 php bot.php -i 2
			text "32;01m" "Pomyslnie uruchomiono bota nr 2!"
		else
			text "31;02m" "Bot nr 2 jest juz uruchomiony!"
		fi
		if ! screen -list | grep -q "botphp3"; then
			screen -AdmS botphp3 php bot.php -i 3
			text "32;01m" "Pomyslnie uruchomiono bota nr 3!"
		else
			text "31;02m" "Bot nr 2 jest juz uruchomiony!"
		fi
	}

	function stop {
		if ! screen -list | grep -q "botphp1"; then
			text "31;02m" "Bot nr 1 nie był uruchomiony więc nie został zatrzymany"
		else
			text "32;01m" "Pomyslnie zatrzymano bota  nr 1!"
			screen -X -S botphp1 stuff "^C"
		fi
		if ! screen -list | grep -q "botphp2"; then
			text "31;02m" "Bot nr 2 nie był uruchomiony więc nie został zatrzymany"
		else
			text "32;01m" "Pomyslnie zatrzymano bota nr 2!"
			screen -X -S botphp2 stuff "^C"
		fi
		if ! screen -list | grep -q "botphp3"; then
			text "31;02m" "Bot nr 3 nie był uruchomiony więc nie został zatrzymany"
		else
			text "32;01m" "Pomyslnie zatrzymano bota nr 3!"
			screen -X -S botphp3 stuff "^C"
		fi
	}

	function restart {
		if ! screen -list | grep -q "botphp1"; then
			text "31;02m" "Bot nr 1 nie był uruchomiony"
		else
			text "32;01m" "Pomyslnie zatrzymano bota nr 1!"
			screen -X -S botphp1 stuff "^C"
		fi
		if ! screen -list | grep -q "botphp2"; then
			text "31;02m" "Bot nr 2 nie był uruchomiony"
		else
			text "32;01m" "Pomyslnie zatrzymano bota nr 2!"
			screen -X -S botphp2 stuff "^C"
		fi
		if ! screen -list | grep -q "botphp3"; then
			text "31;02m" "Bot nr 3 nie był uruchomiony"
		else
			text "32;01m" "Pomyslnie zatrzymano bota nr 3!"
			screen -X -S botphp3 stuff "^C"
		fi
		screen -AdmS botphp1 php bot.php -i 1
		text "32;01m" "Pomyslnie uruchomiono bota nr 1!"
		screen -AdmS botphp2 php bot.php -i 2
		text "32;01m" "Pomyslnie uruchomiono bota nr 2!"
		screen -AdmS botphp3 php bot.php -i 3
		text "32;01m" "Pomyslnie uruchomiono bota nr 3!"
	}

	function status {
		if ! screen -list | grep -q "botphp1"; then
			text "32;01m" "Bot nr 1 nie jest uruchomiony!"
		else
			text "31;02m" "Bot nr 1 jest uruchomiony!"
		fi
		if ! screen -list | grep -q "botphp2"; then
			text "32;01m" "Bot nr 2 nie jest uruchomiony!"
		else
			text "31;02m" "Bot nr 2 jest uruchomiony!"
		fi
		if ! screen -list | grep -q "botphp3"; then
			text "32;01m" "Bot nr 3 nie jest uruchomiony!"
		else
			text "31;02m" "Bot nr 2 jest uruchomiony!"
		fi
	}

	function update {
		php install/upgrade.php
	}

	clear
	text "32;01m" "
 _______ _____ ____    ____        _     _             __  __       _                 
|__   __/ ____|___ \  |  _ \      | |   | |           |  \/  |     (_)                
   | | | (___   __) | | |_) | ___ | |_  | |__  _   _  | \  / | __ _ _  ___ ___  _ __  
   | |  \___ \ |__ <  |  _ < / _ \| __| | '_ \| | | | | |\/| |/ \` | |/ __/ _ \| '_ \ 
   | |  ____) |___) | | |_) | (_) | |_  | |_) | |_| | | |  | | (_| | | (_| (_) | | | |
   |_| |_____/|____/  |____/ \___/ \__| |_.__/ \__, | |_|  |_|\__,_| |\___\___/|_| |_|
                                                __/ |             _/ |                
                                               |___/             |__/                 
	"
	text "32;01m" "Jeżeli chcesz mnie wspomóc możesz wysłać donejta ;)
	Paypal: https://www.paypal.me/Majcon
	Inne płatności: https://tipanddonation.com/majcon"
	
	case "$1" in
		"start")
			start
		;;

		"stop")
			stop
		;;

		"restart")
			restart
		;;

		"status")
			status
		;;

		"update")
			update
		;;

		*)
			echo -e 'Uzyj start | stop | restart | status | update'
		;; 
	esac

