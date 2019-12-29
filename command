#!/usr/bin/env php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Commands\ProducerCommand;
use App\Commands\ConsumerCommand;
use Symfony\Component\Console\Application;
 
$app = new Application();
$app->add(new ProducerCommand());
$app->add(new ConsumerCommand());
$app->run();