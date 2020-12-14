<?php
	if(!empty($msg[1])){
		if(is_numeric($msg[1])){
			$gid = $msg[1];
			$clientInfo = Bot::$tsAdmin->getElement('data', Bot::$tsAdmin->clientInfo($invokerid));
			$explode = explode(',', $clientInfo['client_servergroups']);
			if(!in_array($gid, $explode)){
                if($this->configcmd['functions_givegroup']['global_limit'] !=0){
                    $count = 0;
                    foreach($this->configcmd['functions_givegroup']['limit'] as $value){
                        $count += count(array_intersect($explode, $value['gid']));
                    }
                    if($count < $this->configcmd['functions_givegroup']['global_limit']){
                        foreach($this->configcmd['functions_givegroup']['limit'] as $value){
                            if(in_array($gid, $value['gid'])){
                                if(count(array_intersect($explode, $value['gid'])) < $value['limit']){
                                    $serverGroupAddClient = Bot::$tsAdmin->serverGroupAddClient($gid, $clientInfo['client_database_id']);
                                    $this->sendMessage($invokerid, Bot::$l->success_add_group_givegroup);
                                }else{
                                    $this->sendMessage($invokerid, Bot::$l->error_limit_givegroup.count(array_intersect($explode, $value['gid']))." ".$limit);
                                }
                                break;
                            }
                        }
                    }else{
                        $this->sendMessage($invokerid, Bot::$l->error_limit_givegroup);
                    }
                }else{
                    foreach($this->configcmd['functions_givegroup']['limit'] as $value){
                        if(in_array($gid, $value['gid'])){
                            if(count(array_intersect($explode, $value['gid'])) < $value['limit']){
                                $serverGroupAddClient = Bot::$tsAdmin->serverGroupAddClient($gid, $clientInfo['client_database_id']);
                                $this->sendMessage($invokerid, Bot::$l->success_add_group_givegroup);
                            }else{
                                $this->sendMessage($invokerid, Bot::$l->error_limit_givegroup);
                            }
                            break;
                        }
                    }
                }
			}else{
				$this->sendMessage($invokerid, Bot::$l->error_it_has_group_givegroup);
			}
		}else{
			$this->sendMessage($invokerid, Bot::$l->error_no_number_givegroup);
		}
	}else{
		$group = NULL;
		$this->sendMessage($invokerid, Bot::$l->title_givegroup);
		foreach($this->configcmd['functions_givegroup']['limit'] as $value){
            $name = NULL;
	    	$serverGroupList = Bot::$tsAdmin->getElement('data', Bot::$tsAdmin->serverGroupList());
			foreach($serverGroupList as $sgl){
		    	if(in_array($sgl['sgid'], $value['gid'])){
                    $name .= Bot::$l->sprintf(Bot::$l->row_group_givegroup, $sgl['name'], $sgl['sgid']);
				}
			}
			$this->sendMessage($invokerid, Bot::$l->sprintf(Bot::$l->list_group_givegroup, $value['name'], $value['limit'], $name));
        }
	}
?>