<?php

//addcmd.php
	$lang['error_give_name_cmd_addcmd'] = "Podaj nazwę komendy.";
	$lang['error_give_contents_cmd_addcmd'] = "Podaj treść komendy.";
	$lang['success_added_cmd_addcmd'] = "Komenda {1} została dodana";

//adminlog.php
	$lang['error_give_clidbid_adminlog'] = "Podaj cldbid lub uid.";
	$lang['error_wrong_format_adminlog'] = "Błędny format daty poprawna to: {1}";
	$lang['success_display_log_adminlog'] = "Ostatnie 25 akcji: {1}\n{2}";
	$lang['error_no_logs_adminlog'] = "Brak logów dla {1} z dnia {2}";

//banhistory.php
	$lang['row_banhistory'] = "[COLOR=#FF0000]\n~~~~~~~~[/COLOR]\n[B][COLOR=#A52A2A]ID:[/COLOR][/B] [COLOR=#2d2626]{1}[/COLOR]\n[B][COLOR=#A52A2A]IP:[/COLOR][/B] [COLOR=#2d2626]{2}[/COLOR]\n[B][COLOR=#A52A2A]UID:[/COLOR][/B] [COLOR=#2d2626]{3}[/COLOR]\n[B][COLOR=#A52A2A]CLDBID:[/COLOR][/B] [COLOR=#2d2626]{4}[/COLOR]\n[B][COLOR=#A52A2A]Ostani nick:[/COLOR][/B] [COLOR=#2d2626]{5}[/COLOR]\n[B][COLOR=#A52A2A]Ban od:[/COLOR][/B] [COLOR=#2d2626]{6}[/COLOR]\n[B][COLOR=#A52A2A]Ban do:[/COLOR][/B] [COLOR=#2d2626]{7}[/COLOR]\n[B][COLOR=#A52A2A]Powód:[/COLOR][/B] [COLOR=#2d2626]{8}[/COLOR]\n[B][COLOR=#A52A2A]Bana nadał:[/COLOR][/B] [COLOR=#2d2626]{9}[/COLOR]";
	$lang['error_give_cldbid_banhistory'] = "Podaj IP lub UID lub CLDBID.";

//channelowner.php
	$lang['error_channel_provided_unoccupied_channelowner'] = "Podany kanał jest wolny.";
	$lang['success_owner_changed_channelowner'] = "Właściciel kanału o ID:{1} został zmieniony na:{2}";
	$lang['error_channel_provided_unoccupied_sql_channelowner'] = "Podany kanał jest wolny lub nie istnieje w bazie danych.";
	$lang['error_is_owner_channelowner'] = "Podany użytkownik posiada już swój kanał.";
	$lang['error_give_channel_id_channelowner'] = "Podaj ID kanału.";
	$lang['error_give_client_id_channelowner'] = "Podaj DBID użytkownika lub jego unikalny identyfikator.";

//channelpin.php
	$lang['error_give_pin_channelpin'] = "Podaj PIN.";
	$lang['error_lack_of_channel_channelpin'] = "Nie znaleziono kanału dla podanego pinu.";
	$lang['lastip_users_channelpin'] = "\n[b][COLOR=#A52A2A]IP Właściciela:[/COLOR][/b] [COLOR=#3d3b3b]{1}[/COLOR]";
	$lang['success_channel_info_channelpin'] = "[b][COLOR=#A52A2A]Nazwa kanału:[/COLOR][/b] [COLOR=#3d3b3b]{1}[/COLOR]\n[b][COLOR=#A52A2A]ID Kanału:[/COLOR][/b] [COLOR=#3d3b3b]{2}[/COLOR]\n[b][COLOR=#A52A2A]DBID Właściciela:[/COLOR][/b] [COLOR=#3d3b3b]{3}[/COLOR]{4}";

//delcmd.php
	$lang['error_give_name_cmd_delcmd'] = "Podaj nazwę komendy.";
	$lang['success_deleted_cmd_delcmd'] = "Komenda {1} została usunięta.";

//delgroup.php
	$lang['success_deleted_group_delgroup'] = "Grupa została usunieta.";
	$lang['error_not_have_group_delgroup'] = "Nie posiadasz takiej grupy.";
	$lang['error_no_number_delgroup'] = "ID musi być liczbą.";
	$lang['row_group_delgroup'] = "{1} ID: ({2})\n";
	$lang['error_give_id_delgroup'] = "Podaj ID Grupy którą chcesz usunać.\nGrupy które możewsz usunąć\n{1}";

//gamble.php
	$lang['error_give_points_gamble'] = "Podaj liczbę lub all jeżeli chcesz postawić wszystkie punkty.";
	$lang['success_defea_all_gamble'] = "Postawiłeś wszystkie punkty i przegrałeś :)";
	$lang['success_defea_gamble'] = "Właśnie przegrałeś {1} punktów";
	$lang['success_win_gamble'] = "Gratulacje wygrałeś {1} punktów";
	$lang['error_no_points_gamble'] = "Nie masz wystarczająco punktów";

//give.php
	$lang['error_give_clidbid_give'] = "Podaj cldbid lub uid";
	$lang['error_give_points_give'] = "Podaj liczbę punktów jaką chcesz przekazać.";
	$lang['error_lack_of_cldbid_give'] = "Podany użytkownik nie istnieje";
	$lang['error_no_points_give'] = "Nie masz wystarczająco punktów";
	$lang['success_you_gave_points_give'] = "Przesłałeś {1} punktów dla {2}";
	$lang['success_gave_points_give'] = "Użytkownik {1} podarował Ci {2} punktów";

//givegroup.php
	$lang['success_add_group_givegroup'] = "Grupa została przyznana.";
	$lang['error_limit_givegroup'] = "Osiągnąłeś już limit grup.";
	$lang['error_it_has_group_givegroup'] = "Posiadasz już podaną grupe.";
	$lang['error_no_number_givegroup'] = "ID musi być liczbą.";
	$lang['row_group_givegroup'] = "{1} ID: ({2})\n";
	$lang['list_group_givegroup'] = "\n[b]{1}[/b][b] Limit:[/b] {2}\n{3}";
	$lang['title_givegroup'] = "Aby otrzymać grupę musisz podać jej ID\nDostępne grup wraz z ich limitem";

//groupcmd.php
	$lang['error_give_command_groupcmd'] = "Podaj komendę lub jej alias.";
	$lang['error_give_grupy_groupcmd'] = "Podaj grupy.";
	$lang['error_lack_of_command_groupcmd'] = "Komenda nie istnieje.";
	$lang['success_change_groupcmd'] = "Lista grup, które mają dostęp do komendy {1} została zmieniona na {2}.";

//help.php
	$lang['list_of_commands_help'] = "Lista dostępnych komend dla Ciebie\n\{1}";
	$lang['error_no_description_help'] = "Brak opisu.";
	$lang['error_no_syntax_help'] = "(Brak składni).";

//kobieta.php
	$lang['success_add_group_kobieta'] = "UDAŁO SIĘ! Od teraz jesteś zarejestrowana :)";
	$lang['error_it_has_group_kobieta'] = "Ej jesteś już zarejestrowana";
	$lang['error_it_has_group_m_kobieta'] = "Posiadasz inną grupę która blokuje możliwość Twojej rejestracji :)";

//mezczyzna.php
	$lang['success_add_group_mezczyzna'] = "UDAŁO SIĘ! Od teraz jesteś zarejestrowany :)";
	$lang['error_it_has_group_mezczyzna'] = "Ej jesteś już zarejestrowany";
	$lang['error_it_has_group_k_mezczyzna'] = "Posiadasz inną grupę która blokuje możliwość Twojej rejestracji :)";

//poke.php
	$lang['error_give_group_poke'] = "Coś źle podałeś/aś poprawna forma to !poke all lub id grup | Wiadomość.";
	$lang['error_to_long_poke'] = "Wiadomość jest za długa! Maksymalnie możesz użyć 100 znaków.";
	$lang['error_is_no_user_poke'] = "Nie znaleziono użytkowników, którzy mogli zostać puknięci.";
	$lang['success_all_poke'] = "Wszyscy użytkownicy zostali puknięci.";
	$lang['success_group_poke'] = "Wszyscy użytkownicy z podanych grup zostali puknięci.";

//staff.php
	$lang['error_give_dbid_staff'] = "Aby nadać dostęp do komend bota musisz podać jego unique identifier oraz staff jaki ma posiadać";
	$lang['error_not_the_number_staff'] = "Staff musi być liczba od 0 do 10.";
	$lang['error_lack_of_user_staff'] = "Podany użytkownik nie istnieje.";
	$lang['success_change_staff'] = "Staff dla {1} został zmieniony na {2}";

//staffcmd.php
	$lang['error_give_command_staffcmd'] = "Podaj komendę lub jej alias.";
	$lang['error_give_staff_staffcmd'] = "Podaj staff.";
	$lang['error_lack_of_command_staffcmd'] = "Komenda nie istnieje.";
	$lang['success_change_staffcmd'] = "Zmieniasz dostęp do komendy {1} na staff {2}";

//staffcmdtxt.php
	$lang['error_give_command_staffcmdtxt'] = "Podaj komendę lub jej alias.";
	$lang['error_give_staff_staffcmdtxt'] = "Podaj staff.";
	$lang['error_lack_of_command_staffcmdtxt'] = "Komenda nie istnieje.";
	$lang['success_change_staffcmdtxt'] = "Zmieniasz dostęp do komendy {1} na staff {2}";

//stats.php
	$lang['success_info_from_stats'] = "[b][color=olive]Statystyki[/color]
	
	📌  Ilość połączeń: [color=brown]{1}[/color]
	[color=silver]—————————————————————————[/color]
	📌  Poziom: [color=brown]{7}[/color]
	[color=silver]—————————————————————————[/color]
	📌  Doświadczenie: [color=brown]{8}/{9} {10}%[/color]
	[color=silver]—————————————————————————[/color]
	📌  Czas aktywności: [color=brown]{3}[/color] 
	[color=silver]—————————————————————————[/color]
	📌  Najdłuższe połączenie: [color=brown]{5}[/color] 
	
	[color=olive]Ranking[/color]
	
	🏆  Miejsce w TOP połączeń: [color=brown]{2}[/color]
	[color=silver]—————————————————————————[/color]
	🏆  Miejsce w TOP Czas przebywania: [color=brown]{4}[/color]
	[color=silver]—————————————————————————[/color]
	🏆  Miejsce w TOP Najdłuższych połączeń: [color=brown]{6}[/color]
	[color=silver]—————————————————————————[/color]
	🏆  Miejsce w TOP Posiadane doświadczenie: [color=brown]{11}[/color][/b]";

	$lang['success_info_user_stats'] = "[b][color=olive]Statystyki {1}[/color]
	
	📌  Ilość połączeń: [color=brown]{2}[/color]
	[color=silver]—————————————————————————[/color]
	📌  Poziom: [color=brown]{8}[/color]
	[color=silver]—————————————————————————[/color]
	📌  Doświadczenie: [color=brown]{9}/{10} {11}%[/color]
	[color=silver]—————————————————————————[/color]
	📌  Czas aktywności: [color=brown]{4}[/color] 
	[color=silver]—————————————————————————[/color]
	📌  Najdłuższe połączenie: [color=brown]{6}[/color] 
	
	[color=olive]Ranking[/color]

	🏆  Miejsce w TOP połączeń: [color=brown]{3}[/color]
	[color=silver]—————————————————————————[/color]
	🏆  Miejsce w TOP Czas przebywania: [color=brown]{5}[/color]
	[color=silver]—————————————————————————[/color]
	🏆  Miejsce w TOP Najdłuższych połączeń: [color=brown]{7}[/color]
	[color=silver]—————————————————————————[/color]
	🏆  Miejsce w TOP Posiadane doświadczenie: [color=brown]{12}[/color][/b]";

//userinfo.php
	$lang['error_give_clidbid_userinfo'] = "Podaj cldbid lub uid";
	$lang['error_lack_of_cldbid_userinfo'] = "Podany użytkownik nie istnieje";
	$lang['online_users_info_userinfo'] = "[B]Status:[/B] [COLOR=#00FF00]Online[/color]\n[B]Kanał:[/B] {1}\n[B]Wersja TS:[/B] {2}\n[B]Platforma:[/B] {3}\n[B]Kraj:[/B] {4}\n[B]MyTeamSpeak ID:[/B] {5}";
	$lang['offline_users_info_userinfo'] = "[B]Status:[/B] [COLOR=#FF0000]Offline[/color]";
	$lang['lastip_users_userinfo'] = "\n[b]Ostatnie IP:[/b] {1}";
	$lang['success_info_user_userinfo'] = "Informacje o użytkowniku\n[b]Nick:[/b] {1}\n[b]Client unique identifier:[/b] {2}\n[b]Client database id:[/b] {3}\n[b]Posiadane grupy:[/b] {4}\n{5}\n[b]Data rejestracji:[/b] {6}\n[b]Ostatnio połączony:[/b] {7}{8}\n[b]Kanał prywatny:[/b]{9}\n[b]Ilość połączeń:[/b] {10}\n[b]Czas aktywności:[/b] {11}\n[b]Najdłuższe połączenie:[/b] {12}";

?>