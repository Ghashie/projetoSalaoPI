<?php

namespace App\Model;

class UsuarioDao {

    public function localizar(Usuario $u){

        $sql = 'SELECT * FROM usuario WHERE email_usuario = ?';
    
        $stmt = Conexao::getConn()->prepare($sql);
        $stmt->bindValue(1,$u->getEmailU());
    
        $stmt->execute();
    
        if($stmt->rowCount() == 1){  // se for encontrado
    
            if($row = $stmt->fetch()){
            
                $id_usuario = $row["id_usuario"];
                $cpf_usuario = $row["cpf_usuario"];
                $nome_usuario = $row["nome_usuario"];
                $telefone_usuario = $row["telefone_usuario"];
                $email_usuario = $row["email_usuario"];

                $usuario_result = new Usuario();
                $usuario_result->setIdU($id_usuario);
                
                $hashed_password = $row["senha_usuario"]; // pega a senha criptografada da tabela
                if(password_verify($u->getSenhaU(), $hashed_password)){ // testa se é igual a digitada pelo usuario
                    return $id_usuario;
                }
            }
        }
    }

    public function create(Usuario $u){

       //testar se já existe um usuário com este cpf_usuario
       $sql = 'SELECT * FROM usuario WHERE cpf_usuario = ?';
       $stmt = Conexao::getConn()->prepare($sql);
       $stmt->bindValue(1,$u->getCpfU());
   
       $stmt->execute();
   
       if($stmt->rowCount() == 1){  // se for encontrado
         $retorno = "ok";
         return $retorno;
       } else {
      
           $sql = 'INSERT INTO usuario (nome_usuario, cpf_usuario, telefone_usuario, email_usuario, senha_usuario, nivel) VALUES (?,?,?,?,?,?)';
      
           $stmt = Conexao::getConn()->prepare($sql); 
           $stmt->bindValue(1, $u->getNomeU());
           $stmt->bindValue(2, $u->getCpfU());
           $stmt->bindValue(3, $u->getTelefoneU());
           $stmt->bindValue(4, $u->getEmailU());
           $stmt->bindValue(5, $u->getSenhaU());
           $stmt->bindValue(6, $u->getNivel());
           $stmt->execute();
       }    
   }

   public function buscarNivel(Usuario $u){

    $sql = 'SELECT * FROM usuario WHERE email_usuario = ?';

    $stmt = Conexao::getConn()->prepare($sql);
    $stmt->bindValue(1,$u->getEmailU());

    $stmt->execute();

    if($stmt->rowCount() == 1){  // se for encontrado

        if($row = $stmt->fetch()){
            $resultado = $row["nivel"]; 
            return $resultado;
        }
    }
  }


   

}



?>