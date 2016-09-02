<?php

namespace Frontend\Controllers;

use Frontend\Models\Posts  as Posts,
    Frontend\Models\Comments  as Comments;

use Phalcon\Forms\Form,
    Phalcon\Forms\Element\Text,
    Phalcon\Forms\Element\Textarea,
    Phalcon\Forms\Element\Hidden;

class BlogController extends ControllerBase
{
    public function IndexAction()
    {
      $form = new Form();

        $form->add(new Hidden( "security" ,[
            'name'  => $this->security->getTokenKey(),
            'value' => $this->security->getToken(),
        ]));

      $this->view->form = $form;
      $this->view->posts = Posts::find([
        'order' => "date DESC"
      ]);
    }

    public function PostAction()
    {
      $form = new Form();

        $form->add(new Hidden( "security" ,[
            'name'  => $this->security->getTokenKey(),
            'value' => $this->security->getToken(),
        ]));

        $form->add(new Text( "name" ,[
            'placeholder'  => "Nome Completo",
        ]));

        $form->add(new Textarea( "comment" ,[
            'placeholder'  => "Comentário",
        ]));

      $post = Posts::findFirstByUrlrequest( $this->dispatcher->getParam("urlrequest") );
      $comments = Comments::findByPost( $post->_ );

      $this->view->form = $form;
      $this->view->post = $post;
      $this->view->comments = $comments;

      $this->view->ogdescription  = substr(strip_tags($post->text),0,400);
      $this->view->ogtitle        = strip_tags($post->title);
      $this->view->ogimage        = "http://".$this->request->getHttpHost()."/assets/public/images/blog/".$post->image;
    }

    public function CommentAction()
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

      if($flags['status']):

        $c = new Comments;
          $c->post = Posts::findFirstByUrlrequest($this->dispatcher->getParam("urlrequest"))->_;
          $c->name = $this->request->getPost("name");
          $c->text = $this->request->getPost("comment");
          $c->date  = (new \DateTime())->format("Y-m-d H:i:s");
        if($c->save()):
          $flags['status'] = true ;
          $flags['title']  = "Comentário Salvo!";
          $flags['text']   = "Seu comentário foi cadastrado com sucesso!";
        else:
          $flags['status'] = false ;
          $flags['title']  = "Erro ao Commentar!";
          $flags['text']   = "Seu comentário não foi salvo! Tente novamente.";
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
}
