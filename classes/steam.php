<?php

class Steam{

    use Singleton;

  
    public function getAPI()
    {
        return '3E0881F16409C026007E0E53AC381909';
    }

    public function getProfilePicture($id)
    {
        $url = file_get_contents('https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key='.$this->getAPI().'&steamids='.$this->getSteamID64($id)) or die("Failed"); 
        $content = json_decode($url, true);
        return $content['response']['players'][0]['avatarfull'];
    }

    public function getSteamID64($id) {
        if (preg_match('/^STEAM_/', $id)) {
            $parts = explode(':', $id);
            return bcadd(bcadd(bcmul($parts[2], '2'), '76561197960265728'), $parts[1]);
        } elseif (is_numeric($id) && strlen($id) < 16) {
            return bcadd($id, '76561197960265728');
        } else {
            return $id; // We have no idea what this is, so just return it.
        }
    }

    public function parseInt($string) {
        //return intval($string);
        if(preg_match('/(\d+)/', $string, $array)) {
            return $array[1];
        } else {
            return 0;
        }
    }

    public function getSteamId32($id){
        // Convert SteamID64 into SteamID
 
        $subid = substr($id, 4); // because calculators are fags
        $steamY = parseInt($subid);
        $steamY = $steamY - 1197960265728; //76561197960265728
 
        if ($steamY%2 == 1){
        $steamX = 1;
        } else {
        $steamX = 0;
        }
 
        $steamY = (($steamY - $steamX) / 2);
        $steamID = "STEAM_0:" . (string)$steamX . ":" . (string)$steamY;
        return $steamID;
    }
    public function toCommunityID($id) {
        if (preg_match('/^STEAM_/', $id)) {
            $parts = explode(':', $id);
            return bcadd(bcadd(bcmul($parts[2], '2'), '76561197960265728'), $parts[1]);
        } elseif (is_numeric($id) && strlen($id) < 16) {
            return bcadd($id, '76561197960265728');
        } else {
            return $id; // We have no idea what this is, so just return it.
        }
    }

}