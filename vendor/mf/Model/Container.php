<?php 

namespace mf\Model;

use app\Connection;

class Container{

    public static function getModel($model){

       $model = "\\app\\models\\".ucfirst($model);
        $conn = Connection::getDb();
        return new $model($conn);

    }

}   
