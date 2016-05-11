<?php

use Silex\Provider\FormServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\VarDumperServiceProvider;
use Silex\Provider\WebProfilerServiceProvider;
use Silex\Provider\DoctrineServiceProvider;

// include the prod configuration
require __DIR__.'/prod.php';

// enable the debug mode
$app['debug'] = true;

// $dbconn = \pg_connect("host=localhost port=8888 dbname=rwtheatre");

$app->register(new FormServiceProvider());

$app->register(new VarDumperServiceProvider());

$app->register(new ValidatorServiceProvider());

$app->register(new DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver' => 'pdo_mysql',
        'host' => 'localhost',
        'dbname' => 'rwtheatre',
        'user' => 'root',
        'password' => '',
        'charset' => 'utf8',
    ),
));


$app->register(new MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__.'/../var/logs/silex_dev.log',
));

$app->register(new WebProfilerServiceProvider(), array(
    'profiler.cache_dir' => __DIR__.'/../var/cache/profiler',
));
