<?php

  require "../../../../database/conexaoMysql.php";
  $pdo = mysqlConnect();

  $nomePaciente = $sexoPaciente = $email = "";
  $telefone = $cep = $logradouro = "";
  $cidade = $estado = $DataInicioContrato = "";
  $salario = $senha = "";

  if (isset($_POST["nomePaciente"])) $nomePaciente = $_POST["nomePaciente"];
  if (isset($_POST["sexoPaciente"])) $sexoPaciente = $_POST["sexoPaciente"];
  if (isset($_POST["email"])) $email = $_POST["email"];
  if (isset($_POST["telefone"])) $telefone = $_POST["telefone"];
  if (isset($_POST["cep"])) $cep = $_POST["cep"];
  if (isset($_POST["logradouro"])) $logradouro = $_POST["logradouro"];
  if (isset($_POST["cidade"])) $cidade = $_POST["cidade"];
  if (isset($_POST["estado"])) $estado = $_POST["estado"];
  if (isset($_POST["peso"])) $peso = $_POST["peso"];
  if (isset($_POST["altura"])) $altura = $_POST["altura"];
  if (isset($_POST["tipo_sanguineo"])) $tipo_sanguineo = $_POST["tipo_sanguineo"];

  $hashsenha = password_hash($senha, PASSWORD_DEFAULT);

  $sql1 = <<<SQL
  INSERT INTO Pessoa (nome, sexo, email, telefone, cep, logradouro, cidade, estado)
  VALUES (?, ?, ?, ?, ?, ?, ?, ?)
  SQL;

  $sql2 = <<<SQL
  INSERT INTO Paciente (codigo, peso, altura, tipo_sanguineo)
  VALUES (?, ?, ?, ?)
  SQL;

  try {
    $pdo->beginTransaction();
  
    $stmt1 = $pdo->prepare($sql1);
    if (!$stmt1->execute([
      $nomePaciente, $sexoPaciente, $email, $telefone,
      $cep, $logradouro, $cidade, $estado
    ])) throw new Exception('Falha na primeira inserção');
  
    $idNovaPessoa = $pdo->lastInsertId();
    $stmt2 = $pdo->prepare($sql2);
    if (!$stmt2->execute([
      $idNovaPessoa, $peso, $altura, $tipo_sanguineo
    ])) throw new Exception('Falha na segunda inserção');
  
    // Efetiva as operações
    $pdo->commit();

    echo "<script>
    alert('Paciente cadastrado com sucesso!');
    window.location.href='../cadastramento_paciente.php';
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