<?php
	$clientInfo = Bot::$tsAdmin->getElement('data', Bot::$tsAdmin->clientInfo($invokerid));
	$explode = explode(',', $clientInfo['client_servergroups']);
	if(!empty($msg[1])){
		if(is_numeric($msg[1])){
			$gid = $msg[1];
			if(in_array($gid, $explode)){
				if(in_array($gid, $this->configcmd['functions_delgroup']['gid'])){
					Bot::$tsAdmin->serverGroupDeleteClient($gid, $clientInfo['client_database_id']);
					$this->sendMessage($invokerid, "Grupa została usunieta.");
				}
			}else{
				$this->sendMessage($invokerid, "Nie posiadasz takiej grupy");
			}
		}else{
			$this->sendMessage($invokerid, "ID musi być liczbą.");
		}
	}else{
		$ai = array_intersect($explode, $this->configcmd['functions_delgroup']['gid']);
		$serverGroupList = Bot::$tsAdmin->getElement('data', Bot::$tsAdmin->serverGroupList());
		$name = NULL;
		foreach($serverGroupList as $sgl){
			if(in_array($sgl['sgid'], $ai)){
			   $name .= "({$sgl['sgid']}) {$sgl['name']}\n";
			}
		 }
		$this->sendMessage($invokerid, "Podaj ID Grupy którą chcesz usunać.\nGrupy które możewsz usunąć\n{$name}");
	}
?>