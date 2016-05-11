<?php

namespace helpers;

class TicketPurchase {

  protected $movie;
  protected $showtimes;
  protected $ticketType;
  protected $name;
  protected $email;

  public function getMovie() {

    return $this->movie;

  }

  public function setMovie($movie) {

    $this->movie = $movie;
  }

  public function getShowtimes() {

    return $this->showtimes;

  }

  public function setShowtimes($showtimes) {

    $this->showtimes = $showtimes;
  }


  public function getTicketType() {

    return $this->ticketType;

  }

  public function setTicketType($ticketType) {
    $this->ticketType = $ticketType;
  }

  public function getName() {

    return $this->name;

  }

  public function setName($name) {

    $this->name = $name;
  }

  public function getEmail() {

    return $this->email;

  }

  public function setEmail($email) {

    $this->email = $email;
  }

}
