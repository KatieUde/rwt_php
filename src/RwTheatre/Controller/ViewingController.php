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

    return $app['twig']->render('manage_theatre.html.twig', array('viewing_room' => $viewing_room));
  }

    public function findViewingRoomAction(Request $request, Application $app, $id){
      $sql = "SELECT * FROM viewing_rooms WHERE id = ?";
      $viewing_room = $app['db']->fetchAssoc($sql, array((int) $id));

    return $app['twig']->render('edit_viewing_room.html.twig', array('viewing_room' => $viewing_room));
  }



}
