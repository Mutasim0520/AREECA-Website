<?php

class HomeController extends Controller {

    public function index() {
        $doms = $this->model('DomElements')->getAllDomByPageName('index_page');
        $main_slider = $this->filterDomElement($doms, 'index-page-main-slider');
        $text_dom_sections = $this->filterDomElement($doms, 'index-page-content');
        $partner_dom_sections = $this->filterDomElement($doms, 'index-page-partners-section');
        return $this->view('index', ['main_slider' => $main_slider, 'text_dom_sections' => $text_dom_sections, 'partner_dom_section' => $partner_dom_sections]);
    }

    public function events() {
        $events = $this->model('Event')->getAllEvents();
        $doms = $this->model('DomElements')->getAllDomByPageName('event_page');
        $text_dom_sections = $this->filterDomElement($doms, 'event-page-content');
        return $this->view('events', ['events' => $events, 'text_dom_sections' => $text_dom_sections]);
    }

    public function viewEvent($id){
        $event = $this->model('Event')->getEventByID($id);
        $events = $this->model('Event')->getAllEvents();
        return $this->view('event-detail', ['event' => $event, 'events' => $events]);
    }
    public function documents(){
        $documents = $this->model('Document')->getAllDocuments();
        $urls = $this->model('Uri')->getAllUris();

        $doms = $this->model('DomElements')->getAllDomByPageName('documents_page');
        $text_dom_sections_doc = $this->filterDomElement($doms, 'documents-page-document-text-section');
        $text_dom_sections_link = $this->filterDomElement($doms, 'documents-page-document-link-text-section');
        return $this->view('documents', ['documents' => $documents, 'urls' => $urls, 'text_dom_sections_doc' => $text_dom_sections_doc, 'text_dom_sections_link' => $text_dom_sections_link]);
    }

    private function filterDomElement($doms,$target_dom_id){
        $matching_dom_elemnts = array();

        //filter the matching dom indexs
        foreach ($doms as $index => $element) {
            if ($element['dom_id'] == $target_dom_id) {
                $matching_dom_elemnts[] = $element;
            }
        }

        return $matching_dom_elemnts;

    }

}