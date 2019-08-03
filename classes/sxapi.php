<?php
// This class contains the functions used to call the Stavox API. You don't need to touch this at all.
// Documentation of all API functionality is located on https://github.com/emoyly/Stavox-Tablet-App-Boilerplate/wiki
class SxApi
{
    use Singleton;
    private $apiKey;

    // On class construction, get the API key from the Config class
    public function __construct()
    {
        $this->apiKey = Config::i()->getSXApiKey();
    }

    // Internal function used to make API calls. Probably don't touch this.
    private function call($Function, $Method, $Params)
    {
        if ($Method == 'GET') {
            // Initiate a new curl instance
            $Request = curl_init();

            // Set options for the newly created curl instance
            curl_setopt_array($Request, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => 'https://stavox.dk/tablet/apps/appstore/api/' . $Function .'?'. http_build_query($Params),
                CURLOPT_USERAGENT => 'Stavox Tablet App v1',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: ' . $this->apiKey,
                ),
            ));

            // Execute the curl request
            $resp = curl_exec($Request);
            curl_close($Request);

            // Return the JSON-encoded data
            return json_decode($resp, true);
        } elseif ($Method == 'POST') {
            // Initiate a new curl instance
            $Request = curl_init();

            // Set options for the newly created curl instance
            curl_setopt_array($Request, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => 'https://stavox.dk/tablet/apps/appstore/api/' . $Function,
                CURLOPT_USERAGENT => 'Stavox Tablet App v1',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: ' . $this->apiKey,
                ),
                CURLOPT_POSTFIELDS => http_build_query($Params),
                CURLOPT_POST => 1,
            ));

            // Execute the curl request
            $resp = curl_exec($Request);
            curl_close($Request);

            // Return the JSON-encoded data
            return json_decode($resp, true);
        }
    }

    // Get information about a player from specified playertoken. Used for logging in the user by default.
    public function getPlayerData($Token)
    {
        return $this->call('getplayerdata', 'GET', [
            'playertoken' => $Token,
        ]);
    }

    // Get information about a player from specified SteamID
    public function getPlayerDataFromSteamID($SteamID)
    {
        // Call the api with the required arguments
        return $this->call('getsteamiddata', 'GET', [
            'steamid' => $SteamID,
        ]);
    }

    // Send a notification to the player.
    public function sendNotification($SteamID, $Title, $Text)
    {
        // Call the api with the required arguments
        return $this->call('createnotification', 'POST', [
            'steamid' => $SteamID,
            'title' => $Title,
            'text' => $Text,
        ]);
    }

    // Give money to a player
    public function giveMoney($SteamID, $Amount)
    {
        // Call the api with the required arguments
        return $this->call('givemoney', 'POST', [
            'steamid' => $SteamID,
            'amount' => $Amount
        ]);
    }

    // Get data from a gang
    public function getGang($GangID)
    {
        return $this->call('getgang', 'GET', [
            'gangid' => $GangID,
        ]);
    }

    // This function is used to validate any webhook calls from the Stavox webserver.
    // Currently, the only webhook available, is the one sent by the moneyRequest api.
    public function validateWebhookCall()
    {
        // If the webhook was called with an invalid method, throw an error
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            die(json_encode([
                'success' => false,
                'error' => 'invalid_method',
            ]));
        }

        // If the webhook was called without any auth header, throw another error
        if (!isset($_SERVER['HTTP_AUTHORIZATION']) || empty($_SERVER['HTTP_AUTHORIZATION'])) {
            die(json_encode([
                'success' => false,
                'error' => 'no_auth_header',
            ]));
        }

        if($_SERVER['HTTP_AUTHORIZATION'] != Config::i()->getSXApiKey()){
            die(json_encode([
                'success' => false,
                'error' => 'invalid_auth',
            ]));
        }
    }
}
