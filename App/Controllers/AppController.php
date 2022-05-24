<?php

	namespace App\Controllers;

	//os recursos do miniframework
	use MF\Controller\Action;
	use MF\Model\Container;

	class AppController extends Action{

		public function timeline(){

			session_start();

			//testando se o susrio antes de entrar passou pelo processo de autenticação
			//se ele não tiver passado esses indices vão estar vazios porque ele não 
			//preencheu o formulario se estiver vazia o header vaidirecionar ele ao formulario de 
			//autenticação

			if($_SESSION['id'] != '' && $_SESSION['nome'] != '') {

				$this->render('timeline');
				
			}else {

				header('Location: /?login=erro');
			}

			
		}



		public function tweet(){


			session_start();

			//testando se o susrio antes de entrar passou pelo processo de autenticação
			//se ele não tiver passado esses indices vão estar vazios porque ele não 
			//preencheu o formulario se estiver vazia o header vaidirecionar ele ao formulario de 
			//autenticação

			if($_SESSION['id'] != '' && $_SESSION['nome'] != '') {

				echo "<pre>";
			    print_r($_POST);
			    echo "</pre>";
				
			}else {

				header('Location: /?login=erro');
			}




			
		}


	}
?>