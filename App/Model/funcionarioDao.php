<?php


namespace App\Model;


# Dentro da classe a seguir, temos o nosso CRUD
# Create, Read, Update e Delete


class FuncionarioDao {

   # função para ler os registros
   public function read(){
   
        $sql = 'SELECT * FROM funcionario';
        $stmt = Conexao::getConn()->prepare($sql);
        $stmt->execute();

        // verificar se a consulta retornou resulatdo
        if($stmt->rowCount() > 0): 
        // Se existe pelo menos uma linha (registro)
            $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC); 
            // insere em resultado o conteúdo
            return $resultado; 
            // retorna a variavel resultado
        else:
            return []; 
            // retorna um array vazio caso não encontre
        endif;
   }


   # função para atualizar (alterar)
   public function update(Funcionario $f){

     $sql = 'UPDATE funcionario SET nome_funcionario = ?, telefone_funcionario = ?, funcao = ?, cpf_funcionario = ?, email_funcionario = ?, senha_funcionario = ?, endereco = ?, nivel = ?  WHERE id_funcionario = ?';

     $stmt = Conexao::getConn()->prepare($sql);
     $stmt->bindValue(1,$f->getNomeF());
     $stmt->bindValue(2,$f->getTelefoneF());
     $stmt->bindValue(3,$f->getFuncao());
     $stmt->bindValue(4,$f->getCpfF());
     $stmt->bindValue(5,$f->getEmailF());
     $stmt->bindValue(6,$f->getSenhaF());
     $stmt->bindValue(7,$f->getEndereco());
     $stmt->bindValue(8,$f->getNivel());
     $stmt->bindValue(9,$f->getIdF());

     $stmt->execute();

   }

    # função para ler os registros
    public function readUpdate($f){
        $sql = 'SELECT * FROM funcionario WHERE id_funcionario = ?';
        $stmt = Conexao::getConn()->prepare($sql);
        $stmt->bindValue(1,$f);
        $stmt->execute();
    
        // verificar se a consulta retornou resulatdo
        if($stmt->rowCount() > 0): 
        // Se existe pelo menos uma linha (registro)
            $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC); 
            // insere em resultado o conteúdo
            return $resultado; 
            // retorna a variavel resultado
        else:
            return []; 
            // retorna um array vazio caso não encontre
        endif;    
    }

   # função para apagar registro
   public function delete($id){

        $sql = 'DELETE FROM funcionario WHERE id_funcionario = ?';
        $stmt = Conexao::getConn()->prepare($sql);
        $stmt->bindValue(1,$id);
        $stmt->execute();
   }
   

   public function localizarF(Funcionario $f){

    $sql = 'SELECT * FROM funcionario WHERE email_funcionario = ?';

    $stmt = Conexao::getConn()->prepare($sql);
    $stmt->bindValue(1,$f->getEmailF());

    $stmt->execute();

    if($stmt->rowCount() == 1){  // se for encontrado

        if($row = $stmt->fetch()){
           
            $hashed_password = $row["senha_funcionario"]; // pega a senha criptografada da tabela
            if(password_verify($f->getSenhaF(), $hashed_password)){ // testa se é igual a digitada pelo usuario
                $resultado = "ok";
                return $resultado;
            }
        }
    }
}

public function createF(Funcionario $f){

   //testar se já existe um funcionario com este cpf_funcionario
   $sql = 'SELECT * FROM funcionario WHERE cpf_funcionario = ?';
   $stmt = Conexao::getConn()->prepare($sql);
   $stmt->bindValue(1,$f->getCpfF());

   $stmt->execute();

   if($stmt->rowCount() == 1){  // se for encontrado
     $retorno = "ok";
     return $retorno;
   } else {
  
       $sql = 'INSERT INTO funcionario (nome_funcionario, telefone_funcionario, funcao, data_nascimento_funcionario, cpf_funcionario, email_funcionario, senha_funcionario, endereco, nivel) VALUES (?,?,?,?,?,?,?,?,?)';
  
       $stmt = Conexao::getConn()->prepare($sql); 
       $stmt->bindValue(1, $f->getNomeF());
       $stmt->bindValue(2, $f->getTelefoneF());
       $stmt->bindValue(3, $f->getFuncao());
       $stmt->bindValue(4, $f->getDataF());
       $stmt->bindValue(5, $f->getCpfF());
       $stmt->bindValue(6, $f->getEmailF());
       $stmt->bindValue(7, $f->getSenhaF());
       $stmt->bindValue(8, $f->getEndereco());
       $stmt->bindValue(9, $f->getNivel());
       $stmt->execute();
   }    
}

public function buscarNivel(Funcionario $f){

$sql = 'SELECT * FROM funcionario WHERE email_funcionario = ?';

$stmt = Conexao::getConn()->prepare($sql);
$stmt->bindValue(1,$f->getEmailF());

$stmt->execute();

if($stmt->rowCount() == 1){  // se for encontrado

    if($row = $stmt->fetch()){
        $resultado = $row["nivel"]; 
        return $resultado;
    }
}
}

    /*public function obterDados() {
       $conn = Conexao::getConn(); // Obtém a instância da conexão PDO
 
       try {
          $sql = "SELECT * FROM funcionario"; // Substitua "tabela" pelo nome da sua tabela
          $stmt = Conexao::getConn()->prepare($sql); //$conn->query($sql);
          $stmt->execute();
          $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
          
          return $result;
          //var_dump($result);
       } catch(\PDOException $e) {
          echo "Erro ao obter dados da tabela: " . $e->getMessage();
          return null;
       }
    
    public function obterDados(){
        $conn = Conexao::getConn(); // Obtém a instância da conexão PDO
        //$msg = "oi";
       //return $msg;
     
        $query = "SELECT id_funcionario, nome_funcionario FROM funcionario";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
     }
 
}*/
}


?>