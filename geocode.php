#!/usr/bin/env php
<?php
require 'vendor/autoload.php';
require_once 'geocode_api_key.php';

$geocoder = new ABP\Geocoder("geocode");
$geocoder->geocode($GEOCODE_API_KEY);
