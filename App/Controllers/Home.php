<?php

namespace App\Controllers;

use Core\Controller;

class Home extends Controller{
    /**
     * Show the index page.
     *
     * @return void
     */
    public function indexAction() {
        echo "Hello from the index action in the Home controller";
    }


    protected function before() {
        echo "(Before)";
        return false;
    }

    protected function after() {
        echo "(After)";
    }
}