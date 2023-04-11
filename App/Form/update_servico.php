<?php

    require_once '..\Model\conexao.php';
    require_once '..\Model\servico.php';
    require_once '..\Model\servicoDao.php';

    $id = intval($_GET['id_servico']);
    $servico = new \App\Model\servico();
    $servicoDao = new \App\Model\servicoDao();
   
 
    if(count($_POST) > 0) {

        $erro = false;
        $tipo = $_POST['tipo'];
        $serv = $_POST['servico'];
        $descricao = $_POST['descricao'];
        $valor = $_POST['valor'];
        
    
        if($_POST['tipo']!='cabelos' && $_POST['tipo']!='maquiagem' && $_POST['tipo']!='estetica' && $_POST['tipo']!='cilios e sobrancelhas' && $_POST['tipo']!='pes e maos' && $_POST['tipo']!='depilacao') {
            $erro = "Insira um tipo de serviço válido";
        } else if(empty($serv)) {
            $erro = "Preencha o nome do serviço";
        } else if(empty($descricao)) {
            $erro = "Preencha a descrição do serviço";
        } else if(empty($valor) || $valor<0) {
            $erro = "Preencha a descrição do serviço";
        }

        if($erro) {
            echo "<p><b>ERRO: $erro</b></p>";
        } else {

            $servico->setIdS($id);
            $servico->setTipo($tipo);
            $servico->setServico($serv);
            $servico->setDescricao($descricao);
            $servico->setValor($valor);
            
            $servicoDao->update($servico);

            echo "<p><b>Serviço atualizado com sucesso!!!</b></p>";
            unset($_POST);
        }
    } 
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous" defer></script>
    <title>Editar Serviço</title>
</head>
<body>
    
    <div class="container">
    
    <form method="POST" action="">
    <?php
       foreach ($servicoDao->readUpdate($id) as $servico): ?>
         <p>
            <label >Tipo de Serviço:</label><br>
            <select name="tipo" class="form-control">
                <option value='cabelos'>Cabelos</option>
                <option value='maquiagem'>Maquiagem</option>
                <option value='estetica'>Estética</option>
                <option value='cilios e sobrancelhas'>Cílios e Sobrancelhas</option>
                <option value='pes e maos'>Pés e Mãos</option>
                <option value='depilacao'>Depilação</option>
            </select>
        </p>
        <p>
            <label>Serviço:</label><br>
            <input name="servico" type="text" size="40">
        </p>
        <p>
            <label>Descrição:</label><br>
            <textarea name="descricao" rows="3" cols="40"></textarea>
        </p>
        <p class="lead">
            <label>Valor:</label><br>
            <input name="valor" type="number" size="20">
        </p>
    <?php
        endforeach;
    ?>
        <button type="submit" class="btn btn-light" title="Gravar atualização">Salvar Alterações</button>
        <a href="read_servico.php"><button type="button" class="btn btn-light" title="Produtos">Voltar</button></a>
        </p>
        
       
    </form>
    </div>
</body>
</html>