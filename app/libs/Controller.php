<?php


class Controller{

    function __construct(){ }

    public function model($modelo){
        require_once("../app/models/".$modelo.".php");
        return new $modelo();
    }
    
    public function view($view, $data=[]){
        if(file_exists("../app/views/".$view.".php")){
            $session = new Session();
            $data['login']= $session->getAttribute('login');
            $data['nickname']=$session->getAttribute('nickname');
            $data['isAdmin']=$session->getAttribute('isAdmin');
            
            require_once("../app/views/".$view.".php");
        }else{
            die("No existe la vista");
        }
    }


}

?>