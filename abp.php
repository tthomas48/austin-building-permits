#!/usr/bin/env php
<?php
require 'vendor/autoload.php';

$downloader = new ABP\Downloader("data");
$downloader->download("01/01/2004");
