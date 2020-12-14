<?php

	class Poke extends Command {

		private static $time_users_poke = [];
		private static $time_admin_poke = [];

		public function execute(): void
		{
			$admin_after_poke = [];
			foreach(self::$time_admin_poke as $key => $value){
				if($value <= time()){
					unset(self::$time_admin_poke[$key]);
				}else{
					$admin_after_poke[] = $key;
				}
			}
			$user_after_poke = [];
			foreach(self::$time_users_poke as $key => $value){
				if($value <= time()){
					unset(self::$time_users_poke[$key]);
				}else{
					$user_after_poke[] = $key;
				}
			}
			$online_on_channel = [];
			foreach($this->config['functions_Poke']['cid'] as $channel => $value){
				$channelClientList = self::$tsAdmin->getElement('data', self::$tsAdmin->channelClientList($channel, '-groups -uid'));
				if(!empty($channelClientList)){
					$admin_online = [];
					$nick_msg = [];
					$nick_poke = [];
					foreach($channelClientList as $ccl){
						if(empty(array_intersect(explode(',', $ccl['client_servergroups']), $value['gid']))){
							$online_on_channel[] = $ccl['clid'];
							$nick_msg[] =  $this->bot->getUrlName($ccl['client_database_id'], $ccl['client_unique_identifier'], $ccl['client_nickname']);
							$nick_poke[] =  $ccl['client_nickname'];
						}else{
							$admin_online[] = $ccl['clid'];
						}
					}
					$admin_list = [];
					foreach($this->bot->getClientList() as $cl) {
						if(!empty(array_intersect(explode(',', $cl['client_servergroups']), $value['gid'])) && empty(array_intersect(explode(',', $cl['client_servergroups']), $value['anty_gid'])) && !in_array($cl['cid'], $value['cidafk']) && (($value['input_muted'] == 1 && $cl['client_input_muted'] == 0) || $value['input_muted'] == 0) && (($value['output_muted'] == 1 && $cl['client_output_muted'] == 0) || $value['output_muted'] == 0) && (($value['away'] == 1 && $cl['client_away'] == 0) || $value['away'] == 0)){
							$admin_list[] = $cl['clid'];
						}
					}
					$user_to_poke = array_diff($online_on_channel, $user_after_poke);
					if(empty($admin_online)){
						if(!empty($admin_list)){
							$admin_to_poke = array_diff($admin_list, $admin_after_poke);
							if(!empty($admin_to_poke)){
								$channelInfo = self::$tsAdmin->getElement('data', self::$tsAdmin->channelInfo($channel));
								$channel =  $this->bot->getUrlChannel($channel, $channelInfo['channel_name']);
								$nick_poke = implode(', ', $nick_poke);
								$nick_msg = implode(', ', $nick_msg);
								foreach($admin_to_poke as $atp){
									if($value['info_admin'] == 1){
										self::$tsAdmin->clientPoke($atp, self::$l->sprintf(self::$l->success_admin_poke, $nick_poke));
									}
									self::$tsAdmin->sendMessage(1, $atp, self::$l->sprintf(self::$l->success_admin_msg, $nick_msg, $channel));
									self::$time_admin_poke[$atp] = time()+$this->config['functions_Poke']['admin_time'];
								}
								if(!empty($user_to_poke)){
									foreach($user_to_poke as $utp){
										if($value['info_user'] == 1){
											self::$tsAdmin->clientPoke($utp, self::$l->success_he_was_informed_poke);
										}else{
											self::$tsAdmin->sendMessage(1, $utp, self::$l->success_he_was_informed_poke);
										}
										self::$time_users_poke[$utp] = time()+$this->config['functions_Poke']['user_time'];
									}
								}
							}else{
								if(!empty($user_to_poke) && !empty($admin_list)){
									foreach($user_to_poke as $utp){
										if($value['info_user'] == 1){
											self::$tsAdmin->clientPoke($utp, self::$l->error_admin_before_poke);
										}else{
											self::$tsAdmin->sendMessage(1, $utp, self::$l->error_admin_before_poke);
										}
										self::$time_users_poke[$utp] = time()+$this->config['functions_Poke']['user_time'];
									}
								}
							}
						}else{
							foreach($user_to_poke as $utp){
								if($value['info_user'] == 1){
									self::$tsAdmin->clientPoke($utp, self::$l->error_admin_offline_poke);
								}else{
									self::$tsAdmin->sendMessage(1, $utp, self::$l->error_admin_offline_poke);
								}
								self::$time_users_poke[$utp] = time()+$this->config['functions_Poke']['user_time'];
							}
						}
					}
				}
			}
		}
	}

?>