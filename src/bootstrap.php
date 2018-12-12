<?php
declare(strict_types=1);

use Symfony\Component\Console\Application;
use Wolfpup\SbazarScraper\Commands\ScrapeCommand;

require(__DIR__.'/../vendor/autoload.php');

$app = new Application('SBazarScraper', '0.0.1');

$app->add(new ScrapeCommand());

return $app;
