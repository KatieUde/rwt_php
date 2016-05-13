<?php

use Silex\Application;
use helpers\TicketPurchase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

$app->get('/', 'RwTheatre\Controller\GeneralController::indexAction')
    ->bind('homepage');
$app->get('/about', 'RwTheatre\Controller\GeneralController::aboutAction');
$app->get('/manage_theatre', 'RwTheatre\Controller\GeneralController::manageTheatreAction');

$app->get('/movies', 'RwTheatre\Controller\MovieController::getMoviesAction');
$app->post('/movies', 'RwTheatre\Controller\MovieController::addMoviesAction');
$app->get('/movie/{id}', 'RwTheatre\Controller\MovieController::findMovieAction');
$app->get('/movie_list', 'RwTheatre\Controller\MovieController::getMovieListAction');
$app->get('/movie/{id}/edit', 'RwTheatre\Controller\MovieController::editMovieAction');
$app->post('/movie/{id}/edit', 'RwTheatre\Controller\MovieController::postEditMovieAction');
$app->delete('/movie/{id}/delete', 'RwTheatre\Controller\MovieController::deleteMovieAction');


$app->get('/tickets', 'RwTheatre\Controller\TicketController::getTicketAction');
$app->post('/tickets', 'RwTheatre\Controller\TicketController::postTicketAction');

$app->get('/ticket_details', 'RwTheatre\Controller\TicketController::getTicketDetailsAction');
$app->post('/ticket_details', 'RwTheatre\Controller\TicketController::addTicketDetailsAction');
$app->get('/ticket_detail/{id}/edit', 'RwTheatre\Controller\TicketController::findTicketDetailsAction');
$app->post('/ticket_detail/{id}/edit', 'RwTheatre\Controller\TicketController::editTicketDetailsAction');
$app->get('/ticket_detail/{id}/delete', 'RwTheatre\Controller\TicketController::deleteTicketDetailsAction');

$app->get('/viewing_rooms', 'RwTheatre\Controller\ViewingController::getViewingRoomAction');
$app->post('/viewing_rooms', 'RwTheatre\Controller\ViewingController::addViewingRoomAction');
$app->get('/viewing_room/{id}/edit', 'RwTheatre\Controller\ViewingController::findViewingRoomAction');
$app->post('/viewing_room/{id}/edit', 'RwTheatre\Controller\ViewingController::editViewingRoomAction');
$app->get('/viewing_room/{id}/delete', 'RwTheatre\Controller\ViewingController::deleteViewingRoomAction');

$app->get('/movie_times', 'RwTheatre\Controller\ViewingController::getViewingsAction');
