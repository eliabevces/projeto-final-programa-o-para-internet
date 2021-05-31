<?php

  require "../../database/conexaoMysql.php";
  $pdo = mysqlConnect();

  $cep = $logradouro = $bairro = "";
  $cidade = $estado = "";

  if (isset($_POST["cep"])) $cep = $_POST["cep"];
  if (isset($_POST["logradouro"])) $logradouro = $_POST["logradouro"];
  if (isset($_POST["cidade"])) $cidade = $_POST["cidade"];
  if (isset($_POST["estado"])) $estado = $_POST["estado"];

  try {

    $sql = <<<SQL
    -- Repare que a coluna Id foi omitida por ser auto_increment
    INSERT INTO EnderecoAjax (cep, logradouro, cidade, estado)
    VALUES (?, ?, ?, ?)
    SQL;
  
    // Neste caso utilize prepared statements para prevenir
    // ataques do tipo SQL Injection, pois precisamos
    // cadastrar dados fornecidos pelo usuário 
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
      $cep, $logradouro, $cidade, $estado
    ]);

    echo "<script>
    alert('Endereço cadastrado com sucesso!');
    window.location.href='../cadastrar_endereco.html';
    </script>";

    exit();
  } 
  catch (Exception $e) {  
    //error_log($e->getMessage(), 3, 'log.php');
    if ($e->errorInfo[1] === 1062)
      exit('Dados duplicados: ' . $e->getMessage());
    else
      exit('Falha ao cadastrar os dados: ' . $e->getMessage());
  }

?>