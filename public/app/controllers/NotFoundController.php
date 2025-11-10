<?php 

namespace app\controllers;

class NotFoundController {

    public function notFound(){
        require_once 'app/views/notfound/404.phtml';
    }

}