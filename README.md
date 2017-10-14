# SteamAPI

This section provides a complete documentation for using the SteamAPI class.

#### Important

To use the SteamAPI, you need two things:

* A Steam api key. This key acts as your secret identifier when making requests to the API, so don't lose or share it. You have to request a key here: https://steamcommunity.com/dev/apikey.
* One or more Steam user(s) id(s). This id(s) will be used for making the requests for specific(s) user(s). You can use this site to find your or any Steam ID: https://steamidfinder.com.

With both this items, you can start to use this api.



## Methods


### Constructor

```php
public function __construct($steamids, $api_key)
```

The constructor method will set the ```$steamids``` and ```$api_key``` that will be used in the api.
(Note that this infos can be changed with anothers methods).

##### Example call
```php
  $steam_id = array(
    '76561198139216883', 
    '76561198113862941'
  );
  $api_key = 'XXXXXXXXXXXXXXXXXXXXXXX'; // here you set your own api key
  
  $steamAPI = new SteamAPI($steam_id, $api_key);
```


---------------------------------------------------------------------------------


### General methods

set_api_key( $api_key )
-

This method will reset your api key.

##### Example call
```php
...
$steamAPI = new SteamAPI($steam_id, $api_key);
$steamAPI->set_api_key('YYYYYYYYYYYYYYYYYYYYYYY');
```

add_steam_id( $id )
-

This method is called to add a steam id to your steam id's array.

##### Example call
```php
...
$steamAPI = new SteamAPI($steam_id, $api_key);
$steamAPI->add_steam_id('76561198139216883');
```


---------------------------------------------------------------------------------


### API methods

GetPlayerInfo()
-

Return the main information of the specified steam id(s).

###### Parameters

> This method receives no parameters.

##### Example call
```php
$steam_id = '76561198139216883';
$api_key = 'XXXXXXXXXXXXXXXXXXXXXXX';
$steamAPI = new SteamAPI($steam_id, $api_key);
$handler = $steamAPI->GetPlayerInfo();

echo "<pre>";
print_r($handler);
echo "</pre>";
```

The above call will print the following output:

```
Array
(
    [0] => Array
        (
            [steamid] => 76561198139216883
            [personaname] => Gustav
            [profileurl] => http://steamcommunity.com/id/Secco2112/
            [avatar] => https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/55/55001a1470250fd6755dec49f711da126c3d16d3.jpg
            [avatarmedium] => https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/55/55001a1470250fd6755dec49f711da126c3d16d3_medium.jpg
            [avatarfull] => https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/55/55001a1470250fd6755dec49f711da126c3d16d3_full.jpg
            [personastate] => Online
            [communityvisibilitystate] => FriendsOfFriends
            [profilestate] => 1
            [lastlogoff] => 10-13-2017 04:09:17
            [realname] => Gustavo Marmentini
            [commentpermission] => 1
            [primaryclanid] => 103582791456305602
            [timecreated] => 06-04-2014 18:42:59
            [loccountrycode] => BR
            [locstatecode] => 23
            [loccityid] => 7723
        )
)
```

GetPlayerLevel()
-

Return the player(s) level for specified steam id(s).

###### Parameters

> This method receives no parameters.

##### Example call
```php
$steam_id = '76561198139216883';
$api_key = 'XXXXXXXXXXXXXXXXXXXXXXX';
$steamAPI = new SteamAPI($steam_id, $api_key);
$handler = $steamAPI->GetPlayerLevel();

echo "<pre>";
print_r($handler);
echo "</pre>";
```

The above call will print the following output:

```
Array
(
    [0] => Array
        (
            [steamid] => 76561198139216883
            [level] => 42
        )
)
```

GetPlayerGames()
-

Return a list of games owned by the player(s) of specified steam id(s).

###### Parameters

> This method receives no parameters.

##### Example call
```php
$steam_id = '76561198139216883';
$api_key = 'XXXXXXXXXXXXXXXXXXXXXXX';
$steamAPI = new SteamAPI($steam_id, $api_key);
$handler = $steamAPI->GetPlayerGames();

echo "<pre>";
print_r($handler);
echo "</pre>";
```

The above call will print the following output:

```
Array
(
    [0] => Array
        (
            [steamid] => 76561198139216883
            [game_count] => 547
            [games] => Array
                (
                    [0] => Array
                        (
                            [appid] => 3920
                            [name] => Sid Meier's Pirates!
                            [playtime_minutes] => 0
                            [playtime_hours] => 0.00
                            [app_icon_url] => https://steamcdn-a.akamaihd.net/steamcommunity/public/images/apps/3920/eeb9384067131b98cd71308aeded180dd9538951.jpg
                            [app_logo_url] => https://steamcdn-a.akamaihd.net/steamcommunity/public/images/apps/3920/cffb2b01c41681c3f74d76d83926d4b4a1e66890.jpg
                        )

                    [1] => Array
                        (
                            [appid] => 4000
                            [name] => Garry's Mod
                            [playtime_minutes] => 3480
                            [playtime_hours] => 58.00
                            [has_community_visible_stats] => 1
                            [community_stats_url] => http://steamcommunity.com/profiles/76561198139216883/stats/4000
                            [app_icon_url] => https://steamcdn-a.akamaihd.net/steamcommunity/public/images/apps/4000/4a6f25cfa2426445d0d9d6e233408de4d371ce8b.jpg
                            [app_logo_url] => https://steamcdn-a.akamaihd.net/steamcommunity/public/images/apps/4000/93c9364c3942223ab66195182fe1982af8a16584.jpg
                        )

                    [2] => Array
                        (
                            [appid] => 2520
                            [name] => Gumboy: Crazy Adventures
                            [playtime_minutes] => 0
                            [playtime_hours] => 0.00
                            [app_icon_url] => https://steamcdn-a.akamaihd.net/steamcommunity/public/images/apps/2520/4bfadc9f40092feaa1787c0e6fbf1280646db091.jpg
                            [app_logo_url] => https://steamcdn-a.akamaihd.net/steamcommunity/public/images/apps/2520/a7d8c1d46e446a6282338410b8b72d02ea2604e5.jpg
                        )
                        ...
                )

        )

)
```

GetRecentPlayedGames( $limit=3 )
-

Return a list with the recently games played by the specified steam id(s).

###### Parameters

> ```$limit``` - number of games that will be listed (default = 3)

##### Example call
```php
$steam_id = '76561198139216883';
$api_key = 'XXXXXXXXXXXXXXXXXXXXXXX';
$steamAPI = new SteamAPI($steam_id, $api_key);
$handler = $steamAPI->GetRecentPlayedGames();

echo "<pre>";
print_r($handler);
echo "</pre>";
```

The above call will print the following output:

```
Array
(
    [0] => Array
        (
            [steamid] => 76561198139216883
            [total_count] => 2
            [games] => Array
                (
                    [0] => Array
                        (
                            [appid] => 252950
                            [name] => Rocket League
                            [playtime_minutes] => 6945
                            [playtime_hours] => 115.75
                            [playtime_2weeks_minutes] => 464
                            [playtime_2weeks_hours] => 7.73
                            [app_icon_url] => https://steamcdn-a.akamaihd.net/steamcommunity/public/images/apps/252950/9ad6dd3d173523354385955b5fb2af87639c4163.jpg
                            [app_logo_url] => https://steamcdn-a.akamaihd.net/steamcommunity/public/images/apps/252950/3854e40582bc14b8ba3c9ee163a0fa64bc538def.jpg
                        )

                    [1] => Array
                        (
                            [appid] => 218620
                            [name] => PAYDAY 2
                            [playtime_minutes] => 66146
                            [playtime_hours] => 1,102.43
                            [playtime_2weeks_minutes] => 108
                            [playtime_2weeks_hours] => 1.80
                            [app_icon_url] => https://steamcdn-a.akamaihd.net/steamcommunity/public/images/apps/218620/a6abc0d0c1e79c0b5b0f5c8ab81ce9076a542414.jpg
                            [app_logo_url] => https://steamcdn-a.akamaihd.net/steamcommunity/public/images/apps/218620/4467a70648f49a6b309b41b81b4531f9a20ed99d.jpg
                        )

                )

        )

)
```

> Note that even though the limit is 3, the number of games shown was 2, limited by the API itself.


GetFriendsList()
-

Return a list with the friends of specified steam id(s).

###### Parameters

> This method receives no parameters.

##### Example call
```php
$steam_id = '76561198139216883';
$api_key = 'XXXXXXXXXXXXXXXXXXXXXXX';
$steamAPI = new SteamAPI($steam_id, $api_key);
$handler = $steamAPI->GetFriendsList();

echo "<pre>";
print_r($handler);
echo "</pre>";
```

The above call will print the following output:

```
Array
(
    [0] => Array
        (
            [my_steamid] => 76561198139216883
            [friends] => Array
                (
                    [0] => Array
                        (
                            [steamid] => 76561197961367772
                            [relationship] => friend
                            [friend_since] => 02-04-2017 17:03:55
                        )

                    [1] => Array
                        (
                            [steamid] => 76561197991468535
                            [relationship] => friend
                            [friend_since] => 11-05-2016 18:51:35
                        )

                    [2] => Array
                        (
                            [steamid] => 76561198011577723
                            [relationship] => friend
                            [friend_since] => 03-08-2015 02:00:18
                        )
                    ...
                )

        )

)
```


GetGamePrice( $appid, $currency=[] )
-

Returns a list containing the specified game price for the specified currencies.

###### Parameters

> ```$appid``` - id of the game that you want a price's list. You can get a list of Steam app ids [here](https://steamdb.info/apps/).
>
> ```$currency``` - one or more specified currency(ies) for show the list. By default, this array parameter is empty. But in the method, the same will receive the value of all the avaiable Steam currencies.


##### Example call 1 (with specifieds currencies)
```php
$steam_id = '76561198139216883';
$api_key = 'XXXXXXXXXXXXXXXXXXXXXXX';
$steamAPI = new SteamAPI($steam_id, $api_key);
$handler = $steamAPI->GetGamePrice(730, array('br', 'us')); // appid for CS-GO and currencies for Brazilian Real and American Dollar

echo "<pre>";
print_r($handler);
echo "</pre>";
```

The above call will print the following output:

```
Array
(
    [0] => Array
        (
            [currency] => BRL
            [initial] => 2499
            [final] => 2499
            [discount_percent] => 0
        )

    [1] => Array
        (
            [currency] => USD
            [initial] => 1499
            [final] => 1499
            [discount_percent] => 0
        )

)
```

> *It is highly recommended that the function be called with a specified list of currencies..*


GetPlayerBans()
-

Returns Community, VAC, and Economy ban statuses for given players.

###### Parameters

> This method receives no parameters.

##### Example call
```php
$steam_id = '76561198139216883';
$api_key = 'XXXXXXXXXXXXXXXXXXXXXXX';
$steamAPI = new SteamAPI($steam_id, $api_key);
$handler = $steamAPI->GetPlayerBans();

echo "<pre>";
print_r($handler);
echo "</pre>";
```

The above call will print the following output:

```
Array
(
    [players] => Array
        (
            [0] => Array
                (
                    [SteamId] => 76561198139216883
                    [CommunityBanned] => 
                    [VACBanned] => 
                    [NumberOfVACBans] => 0
                    [DaysSinceLastBan] => 0
                    [NumberOfGameBans] => 0
                    [EconomyBan] => none
                )

        )

)
```


GetGameNumberOfPlayers( $appid )
-

Returns just a integer with the total number of players currently active in the specified app on Steam.

###### Parameters

> ```$appid``` - app id that we're getting user count for. You can get a list of Steam app ids [here](https://steamdb.info/apps/).

##### Example call
```php
$steam_id = '76561198139216883';
$api_key = 'XXXXXXXXXXXXXXXXXXXXXXX';
$steamAPI = new SteamAPI($steam_id, $api_key);
$handler = $steamAPI->GetGameNumberOfPlayers(730); // appid for CS-GO game

echo "<pre>";
print_r($handler);
echo "</pre>";
```

The above call will print the following output:

```
240707
```


GetPlayerBadges()
-

Returns the badges that are owned by a specific user(s). Also, return the player xp, level, xp needed to level up and xp needed to get current level.

###### Parameters

> This method receives no parameters.

##### Example call
```php
$steam_id = '76561198139216883';
$api_key = 'XXXXXXXXXXXXXXXXXXXXXXX';
$steamAPI = new SteamAPI($steam_id, $api_key);
$handler = $steamAPI->GetPlayerBadges();

echo "<pre>";
print_r($handler);
echo "</pre>";
```

The above call will print the following output:

```
Array
(
    [0] => Array
        (
            [steamid] => 76561198139216883
            [player_xp] => 11460
            [player_level] => 42
            [player_xp_needed_to_level_up] => 40
            [player_xp_needed_current_level] => 11000
            [badges] => Array
                (
                    [0] => Array
                        (
                            [badgeid] => 13
                            [level] => 460
                            [completion_time] => 09-20-2017 17:53:39
                            [xp] => 710
                            [scarcity] => 367216
                        )

                    [1] => Array
                        (
                            [badgeid] => 2
                            [level] => 2
                            [completion_time] => 06-14-2017 05:15:41
                            [xp] => 200
                            [scarcity] => 9042065
                        )
                    ...
                )

        )

)
```
