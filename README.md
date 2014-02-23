austin-building-permits
=====

A scraper for downloading Austin Building Permits and loading them into a mysql database.

Getting Started
---------------

* abp.php is used to download the html files
* parse.php is used to load them into the database
* db/schema.sql contains the database table creation script
* geocode.php uses Texas A&M's geocoding API to geocode records
* db/geocode.sql contains the geocode table creation script
* copy geocode_api_key.php.sample to geocode_api_key.php and enter your API key to run the gecoder
