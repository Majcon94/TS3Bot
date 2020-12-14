<?php
	unset($msg[0]);
	$txt = trim(implode(' ', $msg));
	$explode = explode('|', $txt, 2);
	if(empty($explode[0]) || empty($explode[1])){
		$this->sendMessage($invokerid, 'Coś źle podałeś/aś poprawna forma to !poke all lub id grup | Wiadomość');
	}else{
		if(trim($explode[0]) == 'all'){
			foreach($this->clientlist as $cl) {
				if($cl['client_unique_identifier'] != $invokeruid && $cl['client_type'] == 0){
					Bot::$tsAdmin->clientPoke($cl['clid'], $explode[1]);
				}
			}
			$this->sendMessage($invokerid, 'Wszyscy użytkownicy zostali puknięci');
		}else{
			$i = 0;
			$explode2 = array_filter(explode(',', str_replace([ ',', ' ' ], ',', trim($explode[0]))));
			foreach($this->clientlist as $cl){
				if($cl['client_unique_identifier'] != $invokeruid && $cl['client_type'] == 0 && array_intersect(explode(',', $cl['client_servergroups']), $explode2)){
					$i++;
					Bot::$tsAdmin->clientPoke($cl['clid'], $explode[1]);
				}
			}
			if($i == 0){
				$this->sendMessage($invokerid, 'Nie znaleziono użytkowników, którzy mogli zostać puknięci.');
			}else{
				$this->sendMessage($invokerid, 'Wszyscy użytkownicy z podanych grup zostali puknięci');
			}
		}
	}
?>