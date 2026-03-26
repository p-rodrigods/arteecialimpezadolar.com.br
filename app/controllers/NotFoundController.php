<?php 

namespace app\controllers;

class NotFoundController {

    public function notFound(){
        require_once __DIR__ . '/../views/notfound/404.phtml';
    }

}