<?php

  namespace App\Models;
  use MF\Model\Model;

  class Usuario extends Model{
          
        private $id;
        private $nome;
        private $email;
        private $senha;


        public function __get($atributo){

        	return $this -> $atributo;

        }


        public function __set($atributo,$valor){

        	$this->$atributo = $valor;

        }


        //salvar 
        public function salvar(){

        	//colocando a query que eu desejo executar na veiavel $query
        	//com os valores de entrada como variveis bind

        	$query = "insert into usuarios(nome,email,senha)values(:nome,:email,:senha)";

        	//chamando o objeto $stmt passando pra ele o valor do atributo db da classe Model
        	// e usando a função prepare para ele preparar a query para execução

        	$stmt = $this->db->prepare($query);

        	//definindo os valores que serão enviados as variveis binds da querie
        	//usando os metodos __get() para pegar os valores do objeto corrente

        	$stmt -> bindValue(':nome',$this->__get('nome'));
        	$stmt -> bindValue(':email',$this->__get('email'));
        	$stmt -> bindValue(':senha',$this->__get('senha'));

        	// executando o metodo execute do objeto $stmt para executar a querye no banco

        	$stmt->execute();

        	//retornando o objeto apos a execução

        	return $this;
        }


        // validar se um usuario pode ser cadastrado 
        // A regra é que nome , emial, senha não podem ter menos que 3 caracteres

        public function validarCadastro(){

            $valido = true;

            if (strlen($this->__get('nome')) < 3) {

                $valido = false;
                
            }

            if (strlen($this->__get('email')) < 3) {

                $valido = false;
                
            }

            if (strlen($this->__get('senha')) < 3) {

                $valido = false;
                
            }

            return $valido;




        }

        //recuperar um usuario por email
        //esse metodo retorna um array com os resutltados presentes no banco de dados
        //se o rersultado for 1 e poruq eja exite o emial eo sistema nçao pode deixar cadastrar


        public function getUsuarioPorEmail(){

            $query="SELECT * FROM `usuarios` WHERE email = :email";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':email',$this->__get('email'));
            $stmt->execute();
            
            //Retornando resultado como array associativo 
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);

        }

        

        

        public function autenticar(){

            //buscando o usuario no banco pelo emial e pela senha

            $query ="SELECT `id`, `nome`, `email`, `senha` FROM `usuarios` WHERE email = :email AND senha = :senha";

            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':email',$this->__get('email'));

            $stmt->bindValue(':senha',$this->__get('senha'));

            $stmt->execute();

            $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);

            if ($usuario['id'] != '' && $usuario['nome'] != ''){
                
                $this->__set('id',$usuario['id']);
                $this->__set('nome',$usuario['nome']);

            }

            return $this;
        }


        public function getAll(){

            $query = "select id,nome,email from usuarios where nome like :nome";
            $stmt  = $this->db->prepare($query);
            $stmt->bindValue(':nome','%'.$this->__get('nome').'%');
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);

        }









  }

?>