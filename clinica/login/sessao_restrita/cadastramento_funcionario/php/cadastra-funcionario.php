<?php

  require "../../../../database/conexaoMysql.php";
  $pdo = mysqlConnect();

  $nomeFuncionario = $sexoFuncionario = $email = "";
  $telefone = $cep = $logradouro = "";
  $cidade = $estado = $DataInicioContrato = "";
  $salario = $senha = "";

  if (isset($_POST["nomeFuncionario"])) $nomeFuncionario = $_POST["nomeFuncionario"];
  if (isset($_POST["sexoFuncionario"])) $sexoFuncionario = $_POST["sexoFuncionario"];
  if (isset($_POST["email"])) $email = $_POST["email"];
  if (isset($_POST["telefone"])) $telefone = $_POST["telefone"];
  if (isset($_POST["cep"])) $cep = $_POST["cep"];
  if (isset($_POST["logradouro"])) $logradouro = $_POST["logradouro"];
  if (isset($_POST["cidade"])) $cidade = $_POST["cidade"];
  if (isset($_POST["estado"])) $estado = $_POST["estado"];
  if (isset($_POST["DataInicioContrato"])) $DataInicioContrato = $_POST["DataInicioContrato"];
  if (isset($_POST["salario"])) $salario = $_POST["salario"];
  if (isset($_POST["senha"])) $senha = $_POST["senha"];


  $hashsenha = password_hash($senha, PASSWORD_DEFAULT);

  $sql1 = <<<SQL
  INSERT INTO Pessoa (nome, sexo, email, telefone, cep, logradouro, cidade, estado)
  VALUES (?, ?, ?, ?, ?, ?, ?, ?)
  SQL;

  $sql2 = <<<SQL
  INSERT INTO Funcionario (codigo, data_contrato, salario, senha_hash)
  VALUES ((
    select codigo
    from Pessoa
    where codigo = ?
  ), ?, ?, ?)
  SQL;

  $sql3 = <<<SQL
  INSERT INTO Medico (codigo, especialidade, crm)
  VALUES ((
    select codigo
    from Funcionario
    where codigo = ?
  ), ?, ?)
  SQL;

  try {
    $pdo->beginTransaction();
  
    $stmt1 = $pdo->prepare($sql1);
    if (!$stmt1->execute([
      $nomeFuncionario, $sexoFuncionario, $email, $telefone,
      $cep, $logradouro, $cidade, $estado
    ])) throw new Exception('Falha na primeira inserção');
    $idNovaPessoa = $pdo->lastInsertId();


    $stmt2 = $pdo->prepare($sql2);
    if (!$stmt2->execute([
      $idNovaPessoa, $DataInicioContrato, $salario, $hashsenha
    ])) throw new Exception('Falha na segunda inserção');
  


    if(isset($_POST['medicocheck'])){
      if (isset($_POST["especialidade"])) $especialidade = $_POST["especialidade"];
      if (isset($_POST["crm"])) $crm = $_POST["crm"];
      $stmt3 = $pdo->prepare($sql3);
      if (!$stmt3->execute([
        $idNovaPessoa, $especialidade, $crm
      ])) throw new Exception('Falha na terceira inserção');    
    }
    $pdo->commit();

    echo "<script>
    alert('Funcionário cadastrado com sucesso!');
    window.location.href='../cadastramento_funcionario.php';
    </script>";

    exit();
  } 
  catch (Exception $e) {  
    //error_log($e->getMessage(), 3, 'log.php');
    $pdo->rollBack();
    if ($e->errorInfo[1] === 1062)
      exit('Dados duplicados: ' . $e->getMessage());
    else
      exit('Falha ao cadastrar os dados: ' . $e->getMessage());
  }

?>