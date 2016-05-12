<?php

namespace RwTheatre\Controller;

use Silex\Application;
use helpers\TicketPurchase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MovieController {

    public function getMoviesAction(Request $request, Application $app) {

    return $app['twig']->render('add_movies.html.twig', array('movies' => $app['db']->fetchAll('SELECT * FROM movies')));
  }

    public function addMoviesAction(Request $request, Application $app) {
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
  }

    public function findMovieAction(Request $request, Application $app, $id) {
      $sql = "SELECT * FROM movies WHERE id = ?";
      $movie = $app['db']->fetchAssoc($sql, array((int) $id));

      return $app['twig']->render('movie_detail.html.twig', array('movie' => $movie));
  }

    public function editMovieAction(Request $request, Application $app, $id) {
      $sql = "SELECT * FROM movies WHERE id = ?";
      $movie = $app['db']->fetchAssoc($sql, array((int) $id));

      return $app['twig']->render('edit_movie.html.twig', array('movie' => $movie));
  }

    public function postEditMovieAction(Request $request, Application $app) {
      $movie = array(
        'id' => $request->get('id'),
        'movie_name' => $request->get('movie_name'),
        'omdb_id' => $request->get('omdb_id'),
        'omdb_poster' => $request->get('omdb_poster'),
        'youtube' => $request->get('youtube'),
        'playing_now' => $request->get('playing_now'),
        'upcoming' => $request->get('upcoming'),
        'rating' => $request->get('rating')
      );
      $app['db']->update('movie', $movie);

    return $app['twig']->render('add_movies.html.twig');
  }

    public function deleteMovieAction(Request $request, Application $app, $id) {
      $sql = "DELETE FROM movies WHERE id = $id";
      $movie = $app['db']->query($sql);

      return $app['twig']->render('add_movies.html.twig', array('movies' => $app['db']->fetchAll('SELECT * FROM movies')));
    }

}
