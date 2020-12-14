<?php
	$clientInfo = Bot::$tsAdmin->getElement('data', Bot::$tsAdmin->clientInfo($invokerid));
	$explode = explode(',', $clientInfo['client_servergroups']);
	if(!in_array($this->configcmd['functions_kobieta']['gid'], $explode)){
		if(!array_intersect($explode, $this->configcmd['functions_kobieta']['bgid'])){
			$serverGroupAddClient = Bot::$tsAdmin->serverGroupAddClient($this->configcmd['functions_kobieta']['gid'], $clientInfo['client_database_id']);
			$this->sendMessage($invokerid, Bot::$l->success_add_group_kobieta);
		}else{
			$this->sendMessage($invokerid, Bot::$l->error_it_has_group_m_kobieta);
		}
	}else{
		$this->sendMessage($invokerid, Bot::$l->error_it_has_group_kobieta);
	}
?>