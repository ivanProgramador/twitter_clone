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

            $query = "
            select 
               u.id,
               u.nome,
               u.email,
               (
                 select 
                   count(*)
                 from
                   usuarios_seguidores as us
                 where
                   us.id_usuario = :id_usuario and us.id_usuario_seguindo = u.id
               )as seguindo_sn 
            from 
                usuarios as u
            where
                u.nome like :nome and u.id != :id_usuario";

            $stmt  = $this->db->prepare($query);

            $stmt->bindValue(':nome','%'.$this->__get('nome').'%');

            $stmt->bindValue(':id_usuario',$this->__get('id'));

            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);

        }


        public function seguirUsuario($id_usuario_seguindo){
                    
            $query = "insert into usuarios_seguidores(id_usuario,id_usuario_seguindo)values(:id_usuario,:id_usuario_seguindo)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario',$this->__get('id'));
            $stmt->bindValue(':id_usuario_seguindo',$id_usuario_seguindo);
            $stmt->execute();

            return true;


        }

         public function deixarSeguirUsuario($id_usuario_seguindo){

            $query = "delete from usuarios_seguidores where id_usuario = :id_usuario and id_usuario_seguindo = :id_usuario_seguindo";

            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':id_usuario',$this->__get('id'));

            $stmt->bindValue(':id_usuario_seguindo',$id_usuario_seguindo);

            $stmt->execute();
          

            
        }


        public function removerTweet($id){


            $query = "delete from tweets where id_usuario = :id_usuario";
            $stmt  = $this->db->prepare($query);
            $stmt->bindValue('id_usuario', $id);
            $stmt->execute();

        }


        //Informações do usuario

        public function getInfoUsuario(){

            $query ="select from usuarios where id = :id_usuario";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario',$this->__get('id'));
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        //total de tweets

        public function getTotalTweets(){

            $query ="select count(*) as total_tweet from tweets  where id_usuario = :id_usuario";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario',$this->__get('id'));
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }


        //total de usuarios que estamos seguindo

        public function getTotalSeguindo(){

            $query ="select count(*) as total_seguindo from usuarios_seguidores  where id_usuario = :id_usuario";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario',$this->__get('id'));
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        //quantos estão me seguindo 

         public function getTotalSeguidores(){

            $query ="select count(*) as total_seguindo from usuarios_seguidores  where id_usuario = :id_usuario";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario',$this->__get('id'));
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }






   











  }

?>