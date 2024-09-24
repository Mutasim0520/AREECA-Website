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

    public function contact(){
        return $this->view('contact');
    }

    public function message(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message'])){
                $inputs_rules = array(['field_name' => 'name', 'max_length' => 100, 'type' => 'string'],
                                ['field_name' => 'email', 'max_length' => 100, 'type' => 'email'],
                                ['field_name' => 'message', 'max_length' => 1000, 'type' => 'string']
                );
                $validation_result = $this->validateInputs($inputs_rules);
                if($validation_result['is_valid']){
                    $name = filter_var($_POST['name'], FILTER_SANITIZE_SPECIAL_CHARS);
                    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                    $message = filter_var($_POST['message'], FILTER_SANITIZE_SPECIAL_CHARS);

                    $to = "mutasimfuad0520@gmail.com";
                    $subject = "Test Email from PHP";
                    $headers = "From: ".$email;

                    // Send the email
                    if (mail($to, $subject, $message, $headers)) {
                        echo "Email sent successfully!";
                    } else {
                        echo "Failed to send the email.";
                    }
                } else{
                    $_SESSION['message'] = "Please fill up all required fields \n";
                    return $this->redirectBack();
                }
                
            }else{
                $_SESSION['message'] = $validation_result['message']. "\n";
                return $this->redirectBack();
            }
            
        }else{
            return $this->redirectBack();
        }
    }

}