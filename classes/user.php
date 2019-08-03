<?php
// This class contains all of our user-handling, like logging in, getting userdata and so on.
class User
{
    use Singleton;

    // Log in the user with either their session or their logintoken. You can change this as much as you want.
    public function login()
    {
        if (isset($_SESSION['APP_STEAMID']) && !empty($_SESSION['APP_STEAMID'])) { // If the user is logged in using the session
            return true;
        } else { // If the user is not logged in yet
            // If the token is somehow not set, we'll display this error
            if (!isset($_GET['token']) || empty($_GET['token'])) {
                Layout::i()->error('Login error', 'No login token was provided by client');
                exit;
            }

            // Get the playerdata from the token
            $Login = SxAPI::i()->getPlayerData($_GET['token']);

            // If we couldn't login the user, display a nice error message
            if (!$Login['success']) {
                Layout::i()->error('Login error', 'Login failed with code ' . $Login['error']);
                exit;
            }

            // Prepare a new SQL query to see if the user exists
            $stmt = SQL::i()->conn()->prepare('SELECT * FROM Users WHERE SteamID = :SteamID');

            // Bind the parameters to the query, so that we can use the parameters without worrying about SQL injections.
            $stmt->bindParam(':SteamID', $Login['SteamID']);

            // Execute the SQL query
            $stmt->execute();
            $DBUser = $stmt->fetch();

            if (isset($DBUser, $DBUser['SteamID'])) { // Existing users
                // Prepare new SQL query to update the users data
                $stmt = SQL::i()->conn()->prepare('UPDATE Users SET Name = :Name, VIP = :VIP, Rank = :Rank, GangID = :GangID, LastSeen = NOW() WHERE SteamID = :SteamID');

                // Bind the parameters to the query, so that we can use the parameters without worrying about SQL injections.
                $stmt->bindParam(':SteamID', $Login['SteamID']);
                $stmt->bindParam(':Name', $Login['Name']);
                $stmt->bindParam(':VIP', $Login['VIP']);
                $stmt->bindParam(':Rank', $Login['Rank']);
                $stmt->bindParam(':GangID', $Login['GangID']);
                
                // Execute the SQL query
                $stmt->execute();
            } else { // New users
                // Prepare new SQL query to create the user in our local database
                $stmt = SQL::i()->conn()->prepare('INSERT INTO Users (SteamID, Name, VIP, Rank, GangID) VALUES(:SteamID, :Name, :VIP, :Rank, :GangID)');

                // Same as above
                $stmt->bindParam(':SteamID', $Login['SteamID']);
                $stmt->bindParam(':Name', $Login['Name']);
                $stmt->bindParam(':VIP', $Login['VIP']);
                $stmt->bindParam(':Rank', $Login['Rank']);
                $stmt->bindParam(':GangID', $Login['GangID']);
                
                $stmt->execute();
            }

            // Caching of frequently-used variables
            $_SESSION['APP_CACHE_NAME'] = $Login['Name'];
            $_SESSION['APP_CACHE_RANK'] = $Login['Rank'];
            $_SESSION['APP_CACHE_VIP'] = $Login['VIP'];
            $_SESSION['APP_CACHE_GANGID'] = $Login['GangID'];

            // Insert steamid into the session, actually completing the login
            $_SESSION['APP_STEAMID'] = $Login['SteamID'];
            $_SESSION['APP_LOGINTIME'] = time();

            return true;
        }
    }

    // Get data belonging to a specific user
    public function getUserData($SteamID = null)
    {
        // If no SteamID is passed to the function, we'll just use the SteamID of the currently signed-in user
        $SteamID = isset($SteamID) ? $SteamID : $this->getSteamID();

        // Prepare the SQL command
        $stmt = SQL::i()->conn()->prepare('SELECT * FROM Users WHERE SteamID = :SteamID');
        // Bind the SteamID parameter, so we can use it safely in our query
        $stmt->bindParam(':SteamID', $SteamID);
        // Execute SQL
        $stmt->execute();

        $res = $stmt->fetch();

        // Make sure its saved and it has been updated within the last 2 days. We don't really want any outdated info
        if(isset($res, $res['Name']) && strtotime($res['LastSeen']) + (60 * 60 * 24 * 2) > time()){
            return $res;
        }

        // If we haven't already saved the user to our database, ask the Stavox api for new data
        $res = SxApi::i()->getPlayerDataFromSteamID($SteamID);

        if(!$res['success']){
            return [];
        }

        return $res;
    }

    // Get the SteamID of the currently logged in user
    public function getSteamID()
    {
        return $_SESSION['APP_STEAMID'];
    }

    // Get the RP name of the currently logged in user
    public function getName($SteamID = null)
    {
        $SteamID = isset($SteamID) ? $SteamID : $this->getSteamID();
        if($SteamID === $this->getSteamID()){
            return $_SESSION['APP_CACHE_NAME'];
        }

        return $this->getUserData($SteamID)['Name'];
    }

    // Get the in-game rank of the currently logged in user
    public function getRank($SteamID = null)
    {
        $SteamID = isset($SteamID) ? $SteamID : $this->getSteamID();
        if($SteamID === $this->getSteamID()){
            return $_SESSION['APP_CACHE_RANK'];
        }

        return $this->getUserData($SteamID)['Rank'];
    }

    // Get the VIP status of the currently logged in user
    public function getVIP($SteamID = null)
    {
        $SteamID = isset($SteamID) ? $SteamID : $this->getSteamID();
        if($SteamID === $this->getSteamID()){
            return $_SESSION['APP_CACHE_VIP'];
        }
        
        return $this->getUserData($SteamID)['Vip'];
    }

    // Gets the GangID of a player
    public function getGangID($SteamID = null)
    {
        $SteamID = isset($SteamID) ? $SteamID : $this->getSteamID();
        if($SteamID === $this->getSteamID()){
            return $_SESSION['APP_CACHE_GANGID'];
        }

        return $this->getUserData($SteamID)['GangID'];
    }
}
