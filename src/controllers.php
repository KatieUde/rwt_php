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


$app->get('/edit_movie/id', function (Application $app){


  return $app['twig']->render('edit_movie.html.twig', array());
});

$app->get('/delete_movies', function (Application $app){

});

$app->get('/manage_theatre', function (Application $app){
  return $app['twig']->render('manage_theatre.html.twig', array());
});

$app->get('/movies', function (Application $app){
  return $app['twig']->render('movies.html.twig', array());
});

$app->get('/viewing_rooms', function (Application $app){
  return $app['twig']->render('viewing_rooms.html.twig', array('viewing_rooms' => $app['db']->fetchAll('SELECT * FROM viewing_rooms')));
});

$app->post('/viewing_rooms', function (Request $request) use ($app) {
    $viewing_room = array(
      'room_number' => $request->get('room_number'),
      'seat_max' => $request->get('seat_max'),
    );
    $app['db']->insert('viewing_rooms', $viewing_room);

  return $app['twig']->render('manage_theatre.html.twig', array('viewing_room' => $viewing_room));
});

$app->get('/ticket_details', function (Application $app){
  return $app['twig']->render('ticket_details.html.twig', array('ticket_details' => $app['db']->fetchAll('SELECT * FROM ticket_details')));
});

$app->post('/ticket_details', function (Request $request) use ($app) {
    $ticket_detail = array(
      'ticket_style' => $request->get('ticket_style'),
      'ticket_cost' => $request->get('ticket_cost'),
    );
    $app['db']->insert('ticket_details', $ticket_detail);

  return $app['twig']->render('manage_theatre.html.twig', array('ticket_detail' => $ticket_detail));
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
