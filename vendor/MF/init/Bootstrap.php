<?php

  namespace MF\Init;

  // classes abstratas não podem ser instanciadas somente herdadas a classe Route vai
  // extender a classe bootstrap e isso vai permitir que ela use os metodos 
  // que pertencem a ela 

  abstract class Bootstrap{

		  	private $routes;


		  	abstract protected function initRoutes();

		   //construtor 

		   public function __construct(){

		      $this->initRoutes();
		      $this->run($this->getUrl());

		   }

		  // gets e sets

		    public function getRoutes(){

		      return $this->routes;

		    }

		    public function setRoutes(array $routes){

		        $this->routes = $routes;

		    }


		  //------------------



		    protected function run($url){

		        foreach ($this->getRoutes() as $key => $route) {

		           if($url == $route['route']){

		              $class = "App\\Controllers\\".ucfirst($route['controller']);

		              $controller  = new $class;

		              $action =  $route['action'];

		              $controller->$action();


		             
		           }
		          

		        }


		      }



			//esse metodo captura as informações da url solicitada pelo cliente
			protected function getUrl(){

			     	return parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH); 
			     }


  }



?>