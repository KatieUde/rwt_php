<?php

namespace RwTheatre\Controller;

use Silex\Application;
use helpers\TicketPurchase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
        // var_dump($ticket_style);
        // var_dump($ticket_cost);

      $sql = "UPDATE ticket_details SET ticket_style = '$ticket_style' WHERE id = $id";
      $app['db']->executeUpdate($sql);

    return $app['twig']->render('ticket_details.html.twig', array('ticket_details' => $app['db']->fetchAll('SELECT * FROM ticket_details')));
  }

    public function deleteTicketDetailsAction(Request $request, Application $app, $id) {
      $sql = "DELETE FROM ticket_details WHERE id = $id";
      $ticket_detail = $app['db']->query($sql);

    return $app['twig']->render('ticket_details.html.twig', array('ticket_details' => $app['db']->fetchAll('SELECT * FROM ticket_details')));
  }

    public function makeTicketPurchase(Request $request, Application $app) {

      $ticket_purchase = new TicketPurchase();
      // $ticket_purchase->setName();
      // $ticket_purchase->setEmail();

      $movies = $app['db']->fetchAll('SELECT * FROM movies WHERE playing_now = "1"');
      $movie_names = array();
      $movie_ids = array();
        foreach($movies as $movie) {
          array_push($movie_names, $movie['movie_name']);
          array_push($movie_ids, $movie['id']);
        }
        var_dump($movie_names);
        var_dump($movie_ids);
        // $movie_list = implode(", ", $movie_names);
        // echo ($movie_list);

        $tickets = $app['db']->fetchAll('SELECT * FROM ticket_details');
        $ticket_types = array();
        $ticket_ids = array();
          foreach ($tickets as $ticket) {
              array_push($ticket_types, $ticket['ticket_style']);
              array_push($ticket_ids, $ticket['id']);
          }
          // $ticket_list = implode(", ", $ticket_types);
          // var_dump($ticket_list);

      $form = $app['form.factory']->createBuilder(FormType::class, $ticket_purchase)
          ->add('name', TextType::class)
          ->add('email', EmailType::class)
          ->add('age_confirm')
          ->add('cc_number')
          ->add('cc_cvc')
          ->add('cc_exp')
          ->add('zip_code')
          ->add('movie', ChoiceType::class, array('choices' => array(
              $movie_names[0] => $movie_ids[0],
              $movie_names[1] => $movie_ids[1],
              $movie_names[2] => $movie_ids[2],
              $movie_names[3] => $movie_ids[3]
          )))
          ->add('showtime', ChoiceType::class)
          ->add('ticket_type', ChoiceType::class, array('choices' => array(
              $ticket_types[0] => $ticket_ids[0],
              $ticket_types[1] => $ticket_ids[1],
              $ticket_types[2] => $ticket_ids[2]
          )))

          ->getForm();

      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {

          $app['db']->insert('ticket_purchases', $ticket_purchase);
          return $app->redirect($this->generateURL('task_success'));
        }

          return $app['twig']->render('buy_tickets.html.twig', array('form' => $form->createView()));
      }

}
