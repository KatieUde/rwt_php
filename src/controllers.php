<?php

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

//Request::setTrustedProxies(array('127.0.0.1'));

$app->get('/', function (Application $app) {
    return $app['twig']->render('index.html.twig', array());
})
->bind('homepage');


$app->get('/about', function() use ($app){
  return "This is a quick & dirty about page.";
    phpinfo();
});

$app->get('/add_movies', function (Application $app){
  return $app['twig']->render('add_movies.html.twig', array());
});

$app->post('/add_movies', function (Request $request){
  $db = pg_connect('host=localhost dbname=rwtheatre port=8888')

  $movie_id = pg_escape_string($_POST['id']);
  $movie_name = pg_escape_string($_POST['name']);
  $movie_omdb_id = pg_escape_string($_POST['omdb_id']);
  $movie_omdb_poster = pg_escape_string($_POST['omdb_poster']);

  return $app['twig']->render('movies.html.twig', array());
});

$app->get('/manage_theatre', function (Application $app){
  return $app['twig']->render('manage_theatre.html.twig', array());
});

$app->get('/movies', function (Application $app){
  return $app['twig']->render('movies.html.twig', array());
});

$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    // 404.html, or 40x.html, or 4xx.html, or error.html
    $templates = array(
        'errors/'.$code.'.html.twig',
        'errors/'.substr($code, 0, 2).'x.html.twig',
        'errors/'.substr($code, 0, 1).'xx.html.twig',
        'errors/default.html.twig',
    );

    return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code);
});
