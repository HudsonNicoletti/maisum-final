<?php

namespace Frontend\Controllers;

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
     public function initialize()
     {

        $this->assets->addCss('assets/public/styles/main.css');

        $this->assets
             ->addJs('assets/public/scripts/jquery-1.11.3.min.js')
             ->addJs('assets/public/scripts/jquery.easing.1.3.js')
             ->addJs('assets/public/scripts/owl.carousel.min.js')
             ->addJs('assets/public/scripts/scrollIt.js')
             ->addJs('assets/public/scripts/jquery.mask.min.js')
             ->addJs('assets/public/scripts/functions.min.js');

        $this->view->ogdescription  = "A Mais Um é uma rede colaborativa que quer reunir pessoas e empresas para mudar o mundo !";
        $this->view->ogauthor       = "Rede MaisUm";
        $this->view->ogtitle        = "Rede MaisUm";
        $this->view->ogimage        = "http://".$this->request->getHttpHost()."/assets/public/images/logo/ogimage.jpg";
        $this->view->ogurl          = "http://".$this->request->getHttpHost().$this->request->getURI();
    }

    public function URLGenerator($str)
    {
        setlocale(LC_ALL, 'en_US.UTF8');
        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
        $clean = preg_replace("/[^a-zA-Z0-9\/_| -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_| -]+/", '-', $clean);

        return $clean;
    }

    public function isEmail($str)
    {
        return preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $str );
    }

}
