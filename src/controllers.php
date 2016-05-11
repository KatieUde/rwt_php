<?php


use Silex\Application;
use helpers\TicketPurchase;
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

  });

  $app->get('/movie_list', function (Request $request) use ($app){
    $data = array();

    return $app['twig']->render('movies.html.twig', array('movies' => $app['db']->fetchAll('SELECT * FROM movies')));
  });

  $app->get('/movies', function (Request $request) use ($app){

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

  $app->post('/movies', function (Request $request) use ($app) {
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

    return $app['twig']->render('add_movies.html.twig', array('movies' => $app['db']->fetchAll('SELECT * FROM movies')));
  });

  $app->get('/movie/{id}', function ($id) use ($app){
    $sql = "SELECT * FROM movies WHERE id = ?";
    $movie = $app['db']->fetchAssoc($sql, array((int) $id));

    return $app['twig']->render('movie_detail.html.twig', array('movie' => $movie));
  });


  $app->get('/movie/{id}/edit', function ($id) use ($app){
    $sql = "SELECT * FROM movies WHERE id = ?";
    $movie = $app['db']->fetchAssoc($sql, array((int) $id));

    // $sql= "UPDATE movies WHERE id = ?";
    // $movie = $app['db']->update($sql, array((int) $id));

    return $app['twig']->render('edit_movie.html.twig', array('movie' => $movie));
  });

  $app->post('/movie/{id}/edit', function (Request $request) use ($app){
    $movie = array(
      'movie_name' => $request->get('movie_name'),
      'omdb_id' => $request->get('omdb_id'),
      'omdb_poster' => $request->get('omdb_poster'),
      'youtube' => $request->get('youtube'),
      'playing_now' => $request->get('playing_now'),
      'upcoming' => $request->get('upcoming'),
      'rating' => $request->get('rating')
    );
    $app['db']->update('movie', $movie);

    return $app['twig']->render('add_movies.html.twig', array('movie' => $movie));
  });

  $app->get('/movie/{id}/delete', function ($id) use ($app){
    $sql = "DELETE FROM movies WHERE id = $id";
    $movie = $app['db']->query($sql);

    return $app['twig']->render('add_movies.html.twig', array('movies' => $app['db']->fetchAll('SELECT * FROM movies')));
  });


  $app->get('/manage_theatre', function (Application $app){
    return $app['twig']->render('manage_theatre.html.twig', array());
  });

  $app->get('/movies', function (Application $app){
    return $app['twig']->render('movies.html.twig', array());
  });

  $app->get('/tickets', function (Application $app){
    return $app['twig']->render('buy_tickets.html.twig', array());
  });


  $app->post('/tickets', function (Request $request) use ($app){
    return $app['twig']->render('buy_tickets.html.twig', array());
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

  $app->get('/viewing_room/{id}/edit', function (Application $app){
    return $app['twig']->render('edit_movie.html.twig', array('viewing_room_id' => $app['db']->fetchAll('SELECT viewing_room.id FROM viewing_rooms')));
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

  $app->get('/ticket_detail/{id}/edit', function (Application $app){
    return $app['twig']->render('edit_ticket_detail.html.twig', array());
  });

  $app->get('/movie_times', function (Application $app){
    return $app['twig']->render('viewings.html.twig', array('viewing_rooms' => $app['db']->fetchAll('SELECT * FROM viewing_rooms')));
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

    class NewForm {

      public function makeTicketPurchase(Request $request) {

        $ticket_purchase = new TicketPurchase();
        $ticket_purchase->setMovie();
        $ticket_purcahse->setShowtimes();
        $ticket_purcahse->setTicketType();
        $ticket_purcahse->setName();
        $ticket_purcahse->setEmail();

        $form = $this->createFormBuilder($ticket_purchase)
            ->add('movie', 'text')
            ->add('showtime', 'datetime')
            ->add('ticketType', 'text')
            ->add('name', 'text')
            ->add('email', 'text')
            ->add('save', 'submit', array('label' => 'Purchase Ticket'))
            ->getForm();

            // $form->handleRequest($request);
            //
            // if ($form->isSubmitted() && $form->isValid()) {
            //
            //     $app['db']->insert('ticket_purchases', $ticket_purchase);
            //     return $this->redirect($this->generateURL('task_success'));
            // }

            return $this->render('buy_tickets.html.twig', array('form' => $form->createView(),
          ));
        }
      }
