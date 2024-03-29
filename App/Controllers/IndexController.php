<?php

 namespace App\Controllers;


//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;


    Class IndexController extends Action {
       

         
          public function index(){

            $this->view->login = isset($_GET['login'])?$_GET['login']:'';
          	$this->render('index');

          }



          public function inscreverse(){

            $this ->view->usuario = array(
                'nome' => '',
                'email' => '',
                'senha' => '',
                 );

              $this->view->erroCadastro = false;

          	$this->render('inscreverse');

          }




           public function registrar(){
            
           
            $usuario = Container::getModel('Usuario');

            $usuario->__set('nome',$_POST['nome']);
            $usuario->__set('email',$_POST['email']);
            
            // criptografando a senha de um usuario
            // a função md5() converte a senha em rash de 32 caracteres
            // por isso o campo senha no banco de dados tem 32 posições
            // quando essa função é usada tanto o registro tem que usar a md5
            //quanto a entrada(login) porque pra logar ele vai comparar rash com rash
            //para autenticar se ele comparar o resh com a senha vai dar erro 
            


            $usuario->__set('senha',md5($_POST['senha']));
            

            // validando se os dados inseridos no cadastro tem mais de 3 caracteres
             //validando se já existe um cadastro com o email inserido

            if ($usuario->validarCadastro() && count($usuario->getUsuarioPorEmail()) == 0){

              $usuario->salvar();

              $this->render('cadastro');            
             
              
            }else{

              //caso aconteça algum problema na validação ele vem pra cá

              // mantendo os valores na tela mesmo apos o erro para o cliente não precisar redigitar 
              //so corrigir 

              $this ->view->usuario = array(
                'nome' => $_POST['nome'],
                'email' => $_POST['email'],
                'senha' => $_POST['senha'],
                 );

              $this->view->erroCadastro = true;

              $this->render('inscreverse');


               

             }
            
 
          }


         
         

   }


?>