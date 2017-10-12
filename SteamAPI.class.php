<?php
	
	class SteamAPI {


		const version = '0.2.1';
		private $ids = '';
		private $token;
		private $pre_url = 'https://api.steampowered.com/';


		public function __construct($steamids, $token){
			if(is_array($steamids)){
				foreach ($steamids as $i => $id) {
					$this->ids .= ($i==0? $id: ','.$id);
				}
			} else {
				$this->ids = $steamids;
			}

			if(!empty($token)){
				$this->token = $token;
			}

			echo "<script>
				console.log('SteamAPI v." . self::version . " successfully loaded!');
			</script>";

		}


		public function set_token($token){
			$this->token = $token;
		}


		private function get_content($uri){
			try{
				$content = file_get_contents($uri);
				$content = json_decode($content, true);
				return $content;
			} catch(Exception $e){
				echo $e->getMessage();
			}
			
		}


		private function array_steamids($steamids){
			$steamids = explode(',', $steamids);
			return $steamids;
		}


		public function GetPlayerInfo(){
			$url = $this->pre_url . 'ISteamUser/GetPlayerSummaries/v0002/?key=' . $this->token . '&steamids=' . $this->ids;
			$contents = $this->get_content($url);
			$contents = $contents['response']['players'];

			$visibility = array(
				"1" => "Private",
				"2" => "FriendsOnly",
				"3" => "FriendsOfFriends",
				"4" => "UsersOnly",
				"5" => "Public"
			);

			$status = array(
				"0" => "Offline",
				"1" => "Online",
				"2" => "Busy",
				"3" => "Away",
				"4" => "Snooze",
				"5" => "LookingToTrade",
				"6" => "LookingToPlay"
			);

			$players = array();

			foreach ($contents as $it => $p) {
				$player = [];
				$player['steamid'] = $p['steamid'];
				$player['personaname'] = $p['personaname'];
				$player['profileurl'] = $p['profileurl'];
				$player['avatar'] = $p['avatar'];
				$player['avatarmedium'] = $p['avatarmedium'];
				$player['avatarfull'] = $p['avatarfull'];
				$player['personastate'] = $status[$p['personastate']];
				$player['communityvisibilitystate'] = $visibility[$p['communityvisibilitystate']];
				$player['profilestate'] = $p['profilestate'];
				$player['lastlogoff'] = gmdate("m-d-Y H:i:s", $p['lastlogoff']);
				if(!empty($p['realname'])) $player['realname'] = $p['realname'];
				if(!empty($p['commentpermission'])) $player['commentpermission'] = $p['commentpermission'];
				if(!empty($p['primaryclanid'])) $player['primaryclanid'] = $p['primaryclanid'];
				if(!empty($p['timecreated'])) $player['timecreated'] = gmdate("m-d-Y H:i:s", $p['timecreated']);
				if(!empty($p['gameid'])) $player['gameid'] = $p['gameid'];
				if(!empty($p['gameserverip'])) $player['gameserverip'] = $p['gameserverip'];
				if(!empty($p['gameextrainfo'])) $player['gameextrainfo'] = $p['gameextrainfo'];
				if(!empty($p['cityid'])) $player['cityid'] = $p['cityid'];
				if(!empty($p['loccountrycode'])) $player['loccountrycode'] = $p['loccountrycode'];
				if(!empty($p['locstatecode'])) $player['locstatecode'] = $p['locstatecode'];
				if(!empty($p['loccityid'])) $player['loccityid'] = $p['loccityid'];
				array_push($players, $player);		
			}

			return $players;
		}


		public function GetPlayerLevel(){
			$steamids = $this->array_steamids($this->ids);

			$players = array();

			foreach ($steamids as $it => $id) {
				$player = [];
				$url = $this->pre_url . 'IPlayerService/GetSteamLevel/v1/?key=' . $this->token . '&steamid=' . $id;
				$handler = $this->get_content($url);

				$player['steamid'] = $id;
				$player['level'] = $handler['response']['player_level'];
				array_push($players, $player);
			}

			return $players;
		}


		public function GetPlayerGames(){
			$steamids = $this->array_steamids($this->ids);

			$return = [];

			foreach ($steamids as $id) {
				$player = [];
				$url = $this->pre_url . 'IPlayerService/GetOwnedGames/v0001/?key=' . $this->token . '&steamid=' . $id . '&format=json&include_appinfo=1';
				$handler = $this->get_content($url);

				foreach ($handler as $h) {
					$player['steamid'] = $id;
					$player['game_count'] = $h['game_count'];
					$player['games'] = [];
					foreach ($h['games'] as $g) {
						$game = [];
						$game['appid'] = $g['appid'];
						$game['name'] = $g['name'];
						$game['playtime_minutes'] = $g['playtime_forever'];
						$game['playtime_hours'] = number_format($g['playtime_forever']/60, 2);
						if(!empty($g['playtime_2weeks'])) $game['playtime_2weeks_minutes'] = $g['playtime_2weeks'];
						if(!empty($g['playtime_2weeks'])) $game['playtime_2weeks_hours'] = number_format($g['playtime_2weeks']/60, 2);
						if(!empty($g['has_community_visible_stats'])){
							$game['has_community_visible_stats'] = $g['has_community_visible_stats'];
							$game['community_stats_url'] = 'http://steamcommunity.com/profiles/' . $id . '/stats/' . $g['appid'];
						}
						if(!empty($g['img_icon_url'])) $game['app_icon_url'] = 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/apps/' . $g['appid'] . '/' . $g['img_icon_url'] . '.jpg';
						if(!empty($g['img_logo_url'])) $game['app_logo_url'] = 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/apps/' . $g['appid'] . '/' . $g['img_logo_url'] . '.jpg';
 						array_push($player['games'], $game);
					}
				}

				array_push($return, $player);
			}

			return $return;
		}


		public function GetRecentPlayedGames($limit=3){
			$steamids = $this->array_steamids($this->ids);

			$return = [];

			foreach ($steamids as $id) {
				$player = [];
				$url = $this->pre_url . 'IPlayerService/GetRecentlyPlayedGames/v0001/?key=' . $this->token . '&steamid=' . $id . '&format=json&count=' . $limit;
				$handler = $this->get_content($url);

				foreach ($handler as $h) {
					$player['steamid'] = $id;
					$player['total_count'] = $h['total_count'];
					$player['games'] = [];
					foreach ($h['games'] as $g) {
						$game = [];
						$game['appid'] = $g['appid'];
						$game['name'] = $g['name'];
						$game['playtime_minutes'] = $g['playtime_forever'];
						$game['playtime_hours'] = number_format($g['playtime_forever']/60, 2);
						if(!empty($g['playtime_2weeks'])) $game['playtime_2weeks_minutes'] = $g['playtime_2weeks'];
						if(!empty($g['playtime_2weeks'])) $game['playtime_2weeks_hours'] = number_format($g['playtime_2weeks']/60, 2);
						if(!empty($g['has_community_visible_stats'])){
							$game['has_community_visible_stats'] = $g['has_community_visible_stats'];
							$game['community_stats_url'] = 'http://steamcommunity.com/profiles/' . $id . '/stats/' . $g['appid'];
						}
						if(!empty($g['img_icon_url'])) $game['app_icon_url'] = 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/apps/' . $g['appid'] . '/' . $g['img_icon_url'] . '.jpg';
						if(!empty($g['img_logo_url'])) $game['app_logo_url'] = 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/apps/' . $g['appid'] . '/' . $g['img_logo_url'] . '.jpg';
 						array_push($player['games'], $game);
					}
				}

				array_push($return, $player);
			}

			return $return;
		}


		public function GetFriendsList(){
			$steamids = $this->array_steamids($this->ids);

			$return = [];

			foreach ($steamids as $id) {
				$player = [];
				$url = $this->pre_url . 'ISteamUser/GetFriendList/v0001/?key=' . $this->token . '&steamid=' . $id . '&format=json&relationship=friend';
				$handler = $this->get_content($url);

				foreach ($handler as $h) {
					$player = [];
					$player['my_steamid'] = $id;
					$player['friends'] = [];
					foreach ($h['friends'] as $f) {
						$friend = [];
						$friend['steamid'] = $f['steamid'];
						$friend['relationship'] = $f['relationship'];
						$friend['friend_since'] = gmdate("m-d-Y H:i:s", $f['friend_since']);
						array_push($player['friends'], $friend);
					}
				}

				array_push($return, $player);
			}

			return $return;
		}


		public function GetGamePrice($appid, $currency=[]){
			$country_codes = array(
				'ae', 'au', 'br', 'cn', 'dk', 'es', 'gb', 'hr', 'ie', 'ir', 'jp', 'lt', 'ly', 'mx', 'no', 'ph', 'pt', 'rs', 'se', 'sk', 'tw', 'ar',
				'be', 'ca', 'cz', 'dz', 'fi', 'gr', 'hu', 'il', 'is', 'kr', 'lu', 'mk', 'my', 'nz', 'pk', 're', 'ru', 'sg', 'th', 'ua', 'za', 'at',
				'bg', 'cl', 'de', 'ee', 'fr', 'hk', 'id', 'in', 'it', 'kz', 'lv', 'mo', 'nl', 'pe', 'pl', 'ro', 'sa', 'si', 'tr', 'us', 'by'
			);

			$array_countries = [];


			if(!empty($currency) && is_array($currency)){
				$array_countries = $currency;
			} else {
				$array_countries = $country_codes;
			}

			$prices = [];
			foreach ($array_countries as $code) {
				$url = 'http://store.steampowered.com/api/appdetails?appids=' . $appid . '&filters=price_overview&cc=' . $code;
				$handler = $this->get_content($url);
				
				if($handler[$appid]['success']){
					foreach ($handler[$appid]['data'] as $h) {
						$price = [];
						$price['currency'] = $h['currency'];
						$price['initial'] = $h['initial'];
						$price['final'] = $h['final'];
						$price['discount_percent'] = $h['discount_percent'];
						array_push($prices, $price);
					}
				}
			}

			return $prices;
		}


		public function GetPlayerBans(){
			$url = $this->pre_url . 'ISteamUser/GetPlayerBans/v1?key=' . $this->token . '&steamids=' . $this->ids;
			$bans = $this->get_content($url);
			return $bans;
		}


		public function GetGameNumberOfPlayers($appid){
			$url = $this->pre_url . 'ISteamUserStats/GetNumberOfCurrentPlayers/v1?appid=' . $appid;
			$count = $this->get_content($url);

			if($count) {
				return $count['response']['result']? $count['response']['player_count']: false;
			}
			return false;
		}


		public function GetPlayerBadges(){
			$steamids = $this->array_steamids($this->ids);

			foreach ($steamids as $id) {
				$url = $this->pre_url . 'IPlayerService/GetBadges/v1?key=' . $this->token . '&steamid=' . $id;
			}
		}

	}
	
?>