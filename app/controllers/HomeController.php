<?php

class HomeController extends Controller {

    public function index() {
        $dom = $this->model('DomElements')->getAllDoms();
        return $this->view('index', ['doms' => $dom]);
    }

    public function events() {
        $events = $this->model('Event')->getAllEvents();
        $dom = $this->model('DomElements')->getAllDoms();

        return $this->view('events', ['events' => $events, 'doms' => $dom]);
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