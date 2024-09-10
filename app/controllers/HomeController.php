<?php

class HomeController extends Controller {

    public function index() {
        return $this->view('index', []);
    }

    public function events() {
        $events = $this->model('Event')->getAllEvents();
        return $this->view('events', ['events' => $events]);
    }

    public function viewEvent($id){
        $event = $this->model('Event')->getEventByID($id);
        return $this->view('event-detail', ['event' => $event]);
    }
    public function documents(){
        $documents = $this->model('Document')->getAllDocuments();
        return $this->view('documents', ['documents' => $documents]);
    }

}