<?php
namespace ABP;

class Database
{

    public function initDatabase()
    {
        $dbh = new \PDO('mysql:host=localhost;dbname=abp', "abp", "abp");
        $dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $dbh->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        return $dbh;
    }
}