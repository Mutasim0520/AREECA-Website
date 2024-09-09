<?php

class HomeController extends Controller {

    public function index() {
        $this->view('index', []);
    }

    public function events() {
        $this->view('events', []);
    }
}