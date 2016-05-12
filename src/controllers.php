<?php

use Silex\Application;
use helpers\TicketPurchase;
use Silex\Api\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

// Request::setTrustedProxies(array('127.0.0.1'));

  $app->get('/movie_list', function (Request $request) use ($app) {
    $data = array();

    return $app['twig']->render('movies.html.twig', array('movies' => $app['db']->fetchAll('SELECT * FROM movies')));
  });

  $app->get('/movie_times', function (Application $app) {
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
