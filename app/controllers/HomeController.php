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
        $events = $this->model('Event')->getAllEvents();
        return $this->view('event-detail', ['event' => $event, 'events' => $events]);
    }
    public function documents(){
        $documents = $this->model('Document')->getAllDocuments();
        $urls = $this->model('Uri')->getAllUris();
        return $this->view('documents', ['documents' => $documents, 'urls' => $urls]);
    }

}