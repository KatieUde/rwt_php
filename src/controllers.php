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


$app->get('/about', function (Application $app){
  return $app['twig']->render('movies.html.twig', array());
});

$app->get('/add_movies', function (Application $app){
  return $app['twig']->render('add_movies.html.twig', array());
});

$app->post('/add_movies', function (Request $request) use ($app) {
    $movie = array(
      'movie_name' => $request->get('movie_name'),
      'omdb_id' => $request->get('omdb_id'),
      'omdb_poster' => $request->get('omdb_poster'),
      'youtube' => $request->get('youtube'),
      'playing_now' => $request->get('playing_now'),
      'upcoming' => $request->get('upcoming'),
      'rating' => $request->get('rating')
    );
    $app['db']->insert('movies', $movie);

        // $movie_id = $_POST['id'];
        // $name = $_POST['name'];
        // $omdb_id = $_POST['omdb_id'];
        // $omdb_poster = $_POST['omdb_poster'];
        // $youtube = $_POST['youtube'];
        // $playing_now= $_POST['playing_now'];
        // $upcoming = $_POST['upcoming'];
        // $rating = $_POST['rating'];
        // $movie = new Movie($movie_id, $name, $omdb_id, $omdb_poster, $youtube, $playing_now, $upcoming, $rating);
        // $movie->save();

  return $app['twig']->render('movies.html.twig', array('movie' => $movie));
});

$app->get('/manage_theatre', function (Application $app){
  return $app['twig']->render('manage_theatre.html.twig', array());
});

$app->get('/movies', function (Application $app){
  return $app['twig']->render('movies.html.twig', array());
});

$app->get('/auditorium', function (Application $app){
  return $app['twig']->render('auditorium.html.twig', array());
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
