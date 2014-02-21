#!/usr/bin/env php
<?php
require 'vendor/autoload.php';

$downloader = new ABP\Parse("data");
$downloader->parse("01/01/2004");
