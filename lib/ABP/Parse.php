<?php
namespace ABP;

class Parse
{

    private $dataDirectory;

    public function __construct($dataDirectory)
    {
        $this->dataDirectory = $dataDirectory;
    }

    public function initDatabase()
    {
        $dbh = new \PDO('mysql:host=localhost;dbname=abp', "abp", "abp");
        $dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $dbh->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        return $dbh;
    }

    public function parse()
    {
        $dbh = $this->initDatabase();
        $sql = "insert ignore into austin_building_permits (permit_number, sub_type, work_type, permit_location, date_issued, work_description, `status`, 
                folder_owner, folder_owner_addrhouse, folder_owner_addrstreet, folder_owner_addrstreettype, folder_owner_addrunittype, folder_owner_addrunit, 
                folder_owner_addrcity, folder_owner_addrprovince, folder_owner_addrpostal, folder_owner_phone, property_owner, property_owner_addrhouse, 
                property_owner_addrstreet, property_owner_addrstreettype, property_owner_addrunittype, property_owner_addrunit, property_owner_addrcity, 
            property_owner_addrprovince, property_owner_addrpostal, property_owner_phone, total_existing_bldg_footage, total_new_add_footage, total_valuation_remodel, 
            total_job_valuation, remodel_repair_footage, number_of_units, usage_category, legal_description) 
            values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
                    ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
                    ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
                    ?, ?, ?, ?, ?)";
        $sth = $dbh->prepare($sql);
        
        $inserted = 0;
        $files = scandir($this->dataDirectory);
        foreach ($files as $file) {
            if (preg_match("/^\.\.?$/", $file)) {
                continue;
            }
            $html = \SimpleHtmlDom\file_get_html($this->dataDirectory . "/" . $file);
            foreach ($html->find('tr') as $element) {
                $td = array();
                foreach ($element->find('td') as $row) {
                    $td[] = $row->plaintext;
                }
                if(count($td)) {
                    $inserted += $sth->execute($td);
                }
            }
            \cli\line("Inserted " . $inserted. " records from $file");
        }
        
    }
}