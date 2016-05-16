<?php

namespace helpers;

class TicketPurchase {

  protected $name;
  protected $email;
  protected $age_confirm;
  protected $cc_number;
  protected $cc_cvc;
  protected $cc_exp;
  protected $ticket_type;
  protected $zip_code;
  protected $movie;
  protected $showtime;


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


  public function getAgeConfirm() {

    return $this->age_confirm;

  }

  public function setAgeConfirm($age_confirm) {

    $this->age_confirm = $age_confirm;

  }

  public function getCCNumber() {

    return $this->cc_number;

  }

  public function setCCNumber($cc_number) {

    $this->cc_number = $cc_number;

  }

  public function getCcCvc() {

    return $this->cc_cvc;

  }

  public function setCcCVC($cc_cvc) {

    $this->cc_cvc = $cc_cvc;

  }

  public function getCcExp() {

    return $this->cc_exp;

  }

  public function setCcExp($cc_exp) {

    $this->cc_exp = $cc_exp;

  }

  public function getTicketType() {

    return $this->ticket_type;

  }

  public function setTicketType($ticket_type) {

    $this->ticket_type = $ticket_type;

  }

  public function getZipCode() {

    return $this->zip_code;

  }

  public function setZipCode($zip_code) {

    $this->movie = $zip_code;

  }

  public function getMovie() {

    return $this->movie;

  }

  public function setMovie($movie) {

    $this->movie = $movie;
  }

  public function getShowtime() {

    return $this->showtime;

  }

  public function setShowtime($showtime) {

    $this->showtime = $showtime;

  }

}
