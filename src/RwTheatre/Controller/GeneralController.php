<?php

namespace RwTheatre\Controller;

use Silex\Application;
use helpers\TicketPurchase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GeneralController {

  public function indexAction(Request $request, Application $app) {

      return $app['twig']->render('index.html.twig', array());

    }

  public function aboutAction(Request $reqest, Application $app) {

      return $app['twig']->render('about.html.twig', array());

    }

  public function manageTheatreAction(Request $request, Application $app) {

      return $app['twig']->render('manage_theatre.html.twig', array());

    }

  }
