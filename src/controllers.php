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

$app->get('/add_movies', function (Request $request) use ($app){

  // 'movies' => $app['db']->fetchAll('SELECT * FROM movies');
  $data = array();
  // foreach ($movies as $movie) {
  //   $data[] = array(
  //     'id' => $movie->getID(),
  //     'movie_name' => $movie->getMovieName(),
  //     'omdb_id' => $movie->getOmdbId(),
  //     'omdb_poster' => $movie->getOmdbPoster(),
  //     'youtube' => $movie->getYoutube(),
  //     'playing_now' => $movie->getPlayingNow(),
  //     'upcoming' => $movie->getUpcoming(),
  //     'rating' => $movie->getRating(),
    // );
  // }

  return $app['twig']->render('add_movies.html.twig', array('movies' => $app['db']->fetchAll('SELECT * FROM movies')));
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

  return $app['twig']->render('movies.html.twig', array('movie' => $movie));
});

$app->get('/edit_movies', function (Application $app){
  return $app['twig']->render('edit_movies.html.twig', array());
});

$app->get('/edit_movies/movie.id', function (Application $app){
  return $app['twig']->render('edit_movies.html.twig', array());
});

$app->get('/delete_movies', function (Application $app){

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
