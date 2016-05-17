<?php

namespace RwTheatre\Controller;

use Silex\Application;
use helpers\TicketPurchase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ViewingController {

    public function getViewingRoomAction(Application $app) {

    return $app['twig']->render('viewing_rooms.html.twig', array('viewing_rooms' => $app['db']->fetchAll('SELECT * FROM viewing_rooms')));

  }

    public function addViewingRoomAction(Request $request, Application $app) {
      $viewing_room = array(
        'room_number' => $request->get('room_number'),
        'seat_max' => $request->get('seat_max'),
      );
      $app['db']->insert('viewing_rooms', $viewing_room);

    return $app['twig']->render('viewing_rooms.html.twig', array('viewing_room' => $app['db']->fetchAll('SELECT * FROM viewing_rooms')));
  }

    public function findViewingRoomAction(Request $request, Application $app, $id){
      $sql = "SELECT * FROM viewing_rooms WHERE id = ?";
      $viewing_room = $app['db']->fetchAssoc($sql, array((int) $id));

    return $app['twig']->render('edit_viewing_room.html.twig', array('viewing_room' => $viewing_room));
  }

    public function editViewingRoomAction(Request $request, Application $app, $id){
      $sql = "SELECT * FROM viewing_rooms WHERE id = ?";
      $app['db']->fetchAssoc($sql, array((int) $id));

        $id = $request->get('id');
        $room_number = $request->get('room_number');
        $seat_max = $request->get('seat_max');

      $sql = "UPDATE viewing_rooms SET room_number = $room_number, seat_max = $seat_max WHERE id = $id";
      $app['db']->executeUpdate($sql, array((int) $id));

    return $app['twig']->render('viewing_rooms.html.twig', array('viewing_rooms' => $app['db']->fetchAll('SELECT * FROM viewing_rooms')));
  }

    public function deleteViewingRoomAction(Request $request, Application $app, $id) {
      $sql = "DELETE FROM viewing_rooms WHERE id = $id";
      $viewing_room = $app['db']->query($sql);

    return $app['twig']->render('viewing_rooms.html.twig', array('viewing_rooms' => $app['db']->fetchAll('SELECT * FROM viewing_rooms')));
  }

    public function getViewingsAction(Request $request, Application $app) {

      $viewing_rooms = $app['db']->fetchAll('SELECT * FROM viewing_rooms');
      $movies = $app['db']->fetchAll('SELECT * FROM movies');

    return $app['twig']->render('viewings.html.twig', array('viewing_rooms' => $viewing_rooms, 'movies' => $movies));
  }

    public function addViewingsAction(Request $request, Application $app) {
      $viewing = array(
        'movie_id' => $request->get('movie_id'),
        'viewing_id' => $request->get('viewing_id'),
        'view_time' => $request->get('view_time'),
        'view_date' => $request->get('view_date')
      );
      $app['db']->insert('viewings', $viewing);

    return $app['twig']->render('viewings.html.twig', array('viewings' => $app['db']->fetchAll('SELECT * FROM viewings')));
  }

}
