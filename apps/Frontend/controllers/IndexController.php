<?php

namespace Frontend\Controllers;

use Mustache_Engine as Mustache;

use Frontend\Models\Newsletter  as Newsletter;

use Phalcon\Forms\Form,
    Phalcon\Forms\Element\Text,
    Phalcon\Forms\Element\Password,
    Phalcon\Forms\Element\Hidden;

class IndexController extends ControllerBase
{
    public function indexAction()
    {
      $form = new Form();

        $form->add(new Hidden( "security" ,[
            'name'  => $this->security->getTokenKey(),
            'value' => $this->security->getToken(),
        ]));

      $this->view->form = $form;
    }

    public function ContactAction()
    {
      $this->response->setContentType("application/json");
      $flags = [
        'status'  => true,
        'title'   => false,
        'text'    => false
      ];

      if(!$this->request->isPost()):
        $flags['status'] = false ;
        $flags['title']  = "Erro ao Cadastrar!";
        $flags['text']   = "Metodo Inválido.";
      endif;

      if(!$this->security->checkToken()):
        $flags['status'] = false ;
        $flags['title']  = "Erro ao Cadastrar!";
        $flags['text']   = "Token de segurança inválido.";
      endif;

      if(!$this->isEmail($this->request->getPost("email"))):
        $flags['status'] = false ;
        $flags['title']  = "Erro ao Cadastrar!";
        $flags['text']   = "Endereço de E-Mail inválido!";
      endif;

      if($flags['status']):
        $this->mail->functions->From       = $this->request->getPost("email");
        $this->mail->functions->FromName   = $this->request->getPost("name");

        $this->mail->functions->addAddress($this->mail->email,  $this->mail->name);
        $this->mail->functions->addReplyTo($this->request->getPost("email"), $this->request->getPost("name"));

        $this->mail->functions->Subject = ucwords(strtolower($this->request->getPost("name"))).' entrou em contato pelo portal ! - '.$this->request->getPost("subject");

        $this->mail->functions->Body = (new Mustache)->render(file_get_contents($_SERVER['DOCUMENT_ROOT']."/templates/mail.tpl"), [
            'name'    => $this->request->getPost("name") ,
            'message' => $this->request->getPost("message"),
            'email'   => $this->request->getPost("email")
        ]);

        if($this->mail->functions->send()):
          $flags['status'] = true ;
          $flags['title']  = "Enviado com Sucesso!";
          $flags['text']   = "Formulário enviado com sucesso!";
        else:
          $flags['status'] = false ;
          $flags['title']  = "Erro ao Enviar!";
          $flags['text']   = "Erro ao enviar formulário!";
        endif;

        $this->mail->functions->ClearAddresses();
      endif;

      return $this->response->setJsonContent([
        "status" => $flags['status'] ,
        "title"  => $flags['title'] ,
        "text"   => $flags['text']
      ]);

      $this->response->send();
      $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
    }

    public function NewsletterAction()
    {
      $this->response->setContentType("application/json");
      $flags = [
        'status'  => true,
        'title'   => false,
        'text'    => false
      ];

      if(!$this->request->isPost()):
        $flags['status'] = false ;
        $flags['title']  = "Erro ao Cadastrar!";
        $flags['text']   = "Metodo Inválido.";
      endif;

      if(!$this->security->checkToken()):
        $flags['status'] = false ;
        $flags['title']  = "Erro ao Cadastrar!";
        $flags['text']   = "Token de segurança inválido.";
      endif;

      if(!$this->isEmail($this->request->getPost("email"))):
        $flags['status'] = false ;
        $flags['title']  = "Erro ao Cadastrar!";
        $flags['text']   = "Endereço de E-Mail inválido!";
      endif;

      if( Newsletter::findFirstByEmail($this->request->getPost("email"))->_ != NULL ):
        $flags['status'] = false ;
        $flags['title']  = "Erro ao Cadastrar!";
        $flags['text']   = "Endereço de E-Mail já cadastrado no sistema!";
      endif;

      if($flags['status']):

        $n = new Newsletter;
          $n->email = $this->request->getPost("email");
          $n->date  = (new \DateTime())->format("Y-m-d H:i:s");
        if($n->save()):
          $flags['status'] = true ;
          $flags['title']  = "Cadastrado Com Sucesso!";
          $flags['text']   = "Seu E-Mail foi cadastrado com sucesso!";
        else:
          $flags['status'] = false ;
          $flags['title']  = "Erro ao Cadastrar!";
          $flags['text']   = "Seu E-Mail  não foi cadastrado! Tente novamente.";
        endif;

      endif;

      return $this->response->setJsonContent([
        "status" => $flags['status'] ,
        "title"  => $flags['title'] ,
        "text"   => $flags['text']
      ]);

      $this->response->send();
      $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
    }

    public function Instagramaction()
    {
      $auth = "https://api.instagram.com/oauth/authorize/?client_id={$this->api->inst_id}&redirect_uri=mais-um.prod&response_type=token";

      $this->response->redirect($auth, true);

    }
}
