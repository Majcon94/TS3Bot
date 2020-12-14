<?php
	$clientInfo = Bot::$tsAdmin->getElement('data', Bot::$tsAdmin->clientInfo($invokerid));
	$explode = explode(',', $clientInfo['client_servergroups']);
	if(!in_array($this->configcmd['functions_mezczyzna']['gid'], $explode)){
		if(!array_intersect($explode, $this->configcmd['functions_mezczyzna']['bgid'])){
			$serverGroupAddClient = Bot::$tsAdmin->serverGroupAddClient($this->configcmd['functions_mezczyzna']['gid'], $clientInfo['client_database_id']);
			$this->sendMessage($invokerid, Bot::$l->success_add_group_mezczyzna);
		}else{
			$this->sendMessage($invokerid, Bot::$l->error_it_has_group_k_mezczyzna);
		}
	}else{
		$this->sendMessage($invokerid, Bot::$l->error_it_has_group_mezczyzna);
	}
?>