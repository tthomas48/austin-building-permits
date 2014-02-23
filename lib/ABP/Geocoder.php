<?php
namespace ABP;

class Geocoder
{

    private $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function geocode($apiKey)
    {
        $dbh = $this->database->initDatabase();
        
        $insertSql = "insert ignore into geocode (permit_number, date_issued, permit_location, latitude, longitude, 
            census_block, census_block_group, census_tract,
            census_county_fips, census_state_fips, census_cbsa_fips, census_cbsa_micro, census_mcd_fips, census_met_div_fips,
            census_msa_fips, census_place_fips) values (:permit_number, :date_issued, :permit_location, :latitude, :longitude, 
            :census_block, :census_block_group, :census_tract,
            :census_county_fips, :census_state_fips, :census_cbsa_fips, :census_cbsa_micro, :census_mcd_fips, :census_met_div_fips,
            :census_msa_fips, :census_place_fips)";
        $insertSth = $dbh->prepare($insertSql);
        
        // we should probably ensure they're not already in the gecode table
        $sql = "select permit_number, 
                       date_issued, 
                       permit_location 
                  from austin_building_permits abp 
                 where work_type like 'Demo%' 
                  and status in ('Final', 'Pending', 'Pending Permit') 
                  and sub_type like 'R- %' 
                  and not exists (select 'x' from geocode g where abp.permit_number = g.permit_number)";
        
        $insertedRows = 0;
        $sth = $dbh->prepare($sql);
        $sth->execute();
        while($row = $sth->fetch(\PDO::FETCH_ASSOC)) {
            $augmentedRow = $this->augmentRow($apiKey, $row);
            $insertedRows += $insertSth->execute($augmentedRow);
        }
        \cli\line("Inserted $insertedRows\n");
    }    
    
    public function augmentRow($apiKey, $row) {
                
        $query = http_build_query(array(
            'apiKey' => $apiKey,
            'version' => "4.01" ,
            'streetAddress' => $row["permit_location"],
            'city' => 'austin',
            'state' => 'tx',
            'census' => 'true',
            'censusYear' => '2010',
            'format' => 'xml',
            'notStore' => 'false',
        ));
        $client = new \Guzzle\Http\Client();
        $request = $client->get('http://geoservices.tamu.edu/Services/Geocode/WebService/GeocoderWebServiceHttpNonParsed_V04_01.aspx?' . $query, array());
        $response = $request->send();
        $gdata = new \SimpleXMLElement($response->getBody(true));
        $gc = $gdata->OutputGeocodes->OutputGeocode[0];
        $cv = $gc->CensusValues->CensusValue[0];
        
        $response = array(
            ":permit_number" => $row["permit_number"],
            ":date_issued" => $row["date_issued"],
            ":permit_location" => $row["permit_location"],
            ":latitude" => $gc->Latitude->__toString(), 
            ":longitude" => $gc->Longitude->__toString(),
            ":census_block" => $cv->CensusBlock->__toString(), 
            ":census_block_group" => $cv->CensusBlockGroup->__toString(), 
            ":census_tract" => $cv->CensusTract->__toString(),
            ":census_county_fips" => $cv->CensusCountyFips->__toString(), 
            ":census_state_fips" => $cv->CensusStateFips->__toString(), 
            ":census_cbsa_fips" => $cv->CensusCbsaFips->__toString(), 
            ":census_cbsa_micro" => $cv->CensusCbsaMicro->__toString(), 
            ":census_mcd_fips" => $cv->CensusMcdFips->__toString(), 
            ":census_met_div_fips" => $cv->CensusMetDivFips->__toString(),
            ":census_msa_fips" => $cv->CensusMsaFips->__toString(), 
            ":census_place_fips" => $cv->CensusPlaceFips->__toString(),
        );
        return $response;
    } 
}

