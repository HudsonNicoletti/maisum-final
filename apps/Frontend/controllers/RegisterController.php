<?php

namespace Frontend\Controllers;

use Frontend\Models\Share  as Share,
    Frontend\Models\Invite  as Invite,
    Frontend\Models\Spread  as Spread,
    Frontend\Models\Support  as Support,
    Frontend\Models\Intrest  as Intrest;

class RegisterController extends ControllerBase
{
    public function ShareAction( $flags = [ "status" => true ] , $filename = null )
    {
      $this->response->setContentType("application/json");

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

        if($this->request->hasFiles()):
          foreach($this->request->getUploadedFiles() as $file)
          {
              $filename = substr(sha1(uniqid()), 0, 12).'.'.$file->getExtension();
              $file->moveTo("assets/public/images/form/{$filename}");
          }
        endif;

        $share = new Share;
          $share->name        = $this->request->getPost("name","string");
          $share->email       = $this->request->getPost("email","email");
          $share->phone       = $this->request->getPost("phone","string");
          $share->title       = $this->request->getPost("title","string");
          $share->description = $this->request->getPost("description","string");
          $share->date        = (new \Datetime($this->request->getPost("date","string")))->format("Y-m-d H:i:s");
          $share->facebook    = $this->request->getPost("facebook","string");
          $share->instagram   = $this->request->getPost("instagram","string");
          $share->image       = $filename;
        $share->save();

        foreach ($this->request->getPost("intrest") as $i)
        {
          $intrest = new Intrest;
            $intrest->belongstotable = 1 ;
            $intrest->belongstoid = $share->_ ;
            $intrest->intrest = $i ;
            $intrest->text    = ( $i == 8 ? $this->request->getPost("others") : "");
          $intrest->save();
        }

        $flags['status']  = true;
        $flags['title']  = "Cadastro Efeituado!";
        $flags['text']   = "Seu cadastro foi efeituado com sucesso!";

      endif;

      return $this->response->setJsonContent([
        "status" => $flags['status'] ,
        "title"  => $flags['title'] ,
        "text"   => $flags['text']
      ]);

      $this->response->send();
      $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
    }

    public function InviteAction( $flags = [ "status" => true ] )
    {
      $this->response->setContentType("application/json");

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

        $invite = new Invite;
          $invite->name        = $this->request->getPost("name","string");
          $invite->email       = $this->request->getPost("email","email");
          $invite->phone       = $this->request->getPost("phone","string");
          $invite->address     = $this->request->getPost("address","string");
          $invite->entity      = $this->request->getPost("entity","string");
          $invite->description = $this->request->getPost("description","string");
          $invite->facebook    = $this->request->getPost("facebook","string");
          $invite->instagram   = $this->request->getPost("instagram","string");
        $invite->save();

        foreach ($this->request->getPost("intrest") as $i)
        {
          $intrest = new Intrest;
            $intrest->belongstotable = 2 ;
            $intrest->belongstoid = $invite->_ ;
            $intrest->intrest = $i ;
            $intrest->text    = ( $i == 8 ? $this->request->getPost("others") : "");
          $intrest->save();
        }

        $flags['status']  = true;
        $flags['title']  = "Cadastro Efeituado!";
        $flags['text']   = "Seu cadastro foi efeituado com sucesso!";

      endif;

      return $this->response->setJsonContent([
        "status" => $flags['status'] ,
        "title"  => $flags['title'] ,
        "text"   => $flags['text']
      ]);

      $this->response->send();
      $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
    }

    public function SpreadAction( $flags = [ "status" => true ] )
    {
      $this->response->setContentType("application/json");

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

        $spread = new Spread;
          $spread->name        = $this->request->getPost("name","string");
          $spread->email       = $this->request->getPost("email","email");
          $spread->phone       = $this->request->getPost("phone","string");
          $spread->document    = $this->request->getPost("document","string");
          $spread->address     = $this->request->getPost("address","string");
          $spread->facebook    = $this->request->getPost("facebook","string");
          $spread->instagram   = $this->request->getPost("instagram","string");
        $spread->save();

        foreach ($this->request->getPost("intrest") as $i)
        {
          $intrest = new Intrest;
            $intrest->belongstotable = 3 ;
            $intrest->belongstoid = $spread->_ ;
            $intrest->intrest = $i ;
            $intrest->text    = ( $i == 8 ? $this->request->getPost("others") : "");
          $intrest->save();
        }

        foreach ($this->request->getPost("support") as $s)
        {
          $support = new Support;
            $support->belongstoid = $spread->_ ;
            $support->support = $s ;
          $support->save();
        }

        $flags['status']  = true;
        $flags['title']  = "Cadastro Efeituado!";
        $flags['text']   = "Seu cadastro foi efeituado com sucesso!";

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
