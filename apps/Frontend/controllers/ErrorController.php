<?php

namespace Frontend\Controllers;

use Phalcon\Forms\Form,
    Phalcon\Forms\Element\Text,
    Phalcon\Forms\Element\Password,
    Phalcon\Forms\Element\Hidden;

class ErrorController extends ControllerBase
{

    public function NotFoundAction()
    {
        $this->view->page_title = "Página Não Encontrada | Agência dZoë";
        $this->view->page_desc  = "Fornecemos serviços para que sua empresa tenha a melhor visibilidade online alavancando seus negócios e aumentando suas vendas";
        $this->view->pick("error/404");

        $form = new Form();

          $form->add(new Hidden( "security" ,[
              'name'  => $this->security->getTokenKey(),
              'value' => $this->security->getToken(),
          ]));

        $this->view->form = $form;
    }

    public function ServerErrorAction()
    {
        $this->view->page_title = "Erro Interno | Agência dZoë";
        $this->view->page_desc  = "Fornecemos serviços para que sua empresa tenha a melhor visibilidade online alavancando seus negócios e aumentando suas vendas";
        $this->view->pick("error/500");

        $form = new Form();

          $form->add(new Hidden( "security" ,[
              'name'  => $this->security->getTokenKey(),
              'value' => $this->security->getToken(),
          ]));

        $this->view->form = $form;
    }

}
