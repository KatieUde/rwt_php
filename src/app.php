<?php

use Silex\Application;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;

$app = new Application();
$app->register(new ServiceControllerServiceProvider());
$app->register(new AssetServiceProvider());
$app->register(new TwigServiceProvider(), array(
  'twig.form.templates' => array('bootstrap_3_horizontal_layout.html.twig'),
));
$app->register(new HttpFragmentServiceProvider());
$app['twig'] = $app->extend('twig', function (\Twig_Environment $twig, Application $app) {
    // add custom globals, filters, tags, ...

    return $twig;
});

return $app;
