<?php

namespace RwTheatre\Controller;

use Silex\Application;
use helpers\TicketPurchase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TicketController {

    public function getTicketAction(Request $request, Application $app) {

    return $app['twig']->render('buy_tickets.html.twig', array());
  }


    public function postTicketAction(Request $request, Application $app) {

    return $app['twig']->render('buy_tickets.html.twig', array());
  }


    public function getTicketDetailsAction(Request $request, Application $app) {

    return $app['twig']->render('ticket_details.html.twig', array('ticket_details' => $app['db']->fetchAll('SELECT * FROM ticket_details')));
  }

    public function addTicketDetailsAction(Request $request, Application $app) {

      $ticket_detail = array(
        'ticket_style' => $request->get('ticket_style'),
        'ticket_cost' => $request->get('ticket_cost'),
      );
      $app['db']->insert('ticket_details', $ticket_detail);

    return $app['twig']->render('manage_theatre.html.twig', array('ticket_detail' => $ticket_detail));
  }

    public function findTicketDetailsAction(Request $request, Application $app, $id) {
      $sql = "SELECT * FROM ticket_details WHERE id = ?";
      $ticket_detail = $app['db']->fetchAssoc($sql, array((int) $id));

    return $app['twig']->render('edit_ticket_detail.html.twig', array('ticket_detail' => $ticket_detail));
  }

    public function editTicketDetailsAction(Request $request, Application $app, $id) {
      $sql = "SELECT * FROM ticket_details WHERE id = ?";
      $app['db']->fetchAssoc($sql, array((int) $id));

        $id = $request->get('id');
        $ticket_style = $request->get('ticket_style');
        $ticket_cost = $request->get('ticket_cost');
        var_dump($ticket_style);
        var_dump($ticket_cost);

      $sql = "UPDATE ticket_details SET ticket_style = '$ticket_style' WHERE id = $id";
      $app['db']->executeUpdate($sql);

    return $app['twig']->render('ticket_details.html.twig', array('ticket_details' => $app['db']->fetchAll('SELECT * FROM ticket_details')));
  }

    public function deleteTicketDetailsAction(Request $request, Application $app, $id) {
      $sql = "DELETE FROM ticket_details WHERE id = $id";
      $ticket_detail = $app['db']->query($sql);

    return $app['twig']->render('ticket_details.html.twig', array('ticket_details' => $app['db']->fetchAll('SELECT * FROM ticket_details')));
  }


}
