<?php

class HomeController extends Controller {

    public function index() {
        $this->view('index', []);
    }

    public function events() {
        $events = $this->model('Event')->getAllEvents();
        // print_r($events);
        $this->view('events', ['events' => $events]);
    }

}