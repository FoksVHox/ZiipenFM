<?php
// This file connects to your sql database. You don't need to touch this, and probably shouldn't
class SQL
{
    use Singleton;

    private $dbConn = array();
    private $config = [];

    // On class construction, get the SQL config from the Config class
    public function __construct(){
        $this->config = Config::i()->getSQL();
    }

    public function conn($connName = null)
    {
        // If no connection name is supplied to the function, set it to be the default database.
        if(!$connName){
            $connName = $this->config['default_database'];
        }

        // If a connection already exists, return that.
        if (isset($this->dbConn[$connName]) && !empty($this->dbConn[$connName])) {
            return $this->dbConn[$connName];
        }

        // Create new MySQL-PDO connection
        $DB = new PDO('mysql:host=127.0.0.1;dbname=' . $connName . ';port=3306;charset=utf8mb4', $this->config['user'], $this->config['pass']);
        $DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Cache the connection for this view
        $this->dbConn[$connName] = $DB;

        return $DB;
    }

    public function MakeTable($sql)
    {
        $stmt = $this->conn(NULL)->prepare($sql);
        return $stmt->execute();
    }

    // Get the columns of any table. Just a useful function you might need idk
    public function getColumns($table, $connName = null){
		$stmt = $this->conn($connName)->prepare("DESCRIBE ".$table);
		$stmt->execute();
		$columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
		return $columns;
	}
}
