<?php
/**
 * Created by Two Developers - Sven Motz und Jens Averkamp GbR
 * http://www.two-developers.com
 *
 * Developer: Jens Averkamp
 * Date: 06.03.2015
 * Time: 14:15
 */

$file = __DIR__.'/../vendor/autoload.php';
if (!file_exists($file)) {
    throw new \RuntimeException('Install dependencies to run test suite.');
}
$autoload = require_once $file;
