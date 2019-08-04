<?php

class Programs
{
    use Singleton;

    public function getPrograms()
    {
        $stmt = SQL::i()->conn()->prepare('SELECT * FROM Programs');
        $stmt->execute();
        $res = $stmt->fetchAll();
        return $res;
    }

    public function isLive($id)
    {
        // TODO check if id is live
    }

    public function newProgram($name, $host, $small, $desc, $icon, $when)
    {
        if(empty($name) || empty($host) || empty($small) || empty($desc) || empty($icon) || empty($when)){
            return false;
        }
        $stmt = SQL::i()->conn()->prepare('INSERT INTO Programs(`Name`, Host, SmallDescription, `Description`, Icon, `When`) VALUES (:name, :host, :small, :desc, :icon, :when)');
        $stmt->bindParam(':name',$name);
        $stmt->bindParam(':host',$host);
        $stmt->bindParam(':small',$small);
        $stmt->bindParam(':desc',$desc);
        $stmt->bindParam(':icon',$icon);
        $stmt->bindParam(':when',$when);
        return $stmt->execute();
    }

    public function getProgramData($id)
    {
        $stmt = SQL::i()->conn()->prepare('SELECT * FROM Programs WHERE ID = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

}