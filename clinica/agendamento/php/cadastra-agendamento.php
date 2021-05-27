<?php

  require "../../database/conexaoMysql.php";
  $pdo = mysqlConnect();


  if (isset($_POST["nomeMedico"])) $nomeMedico = $_POST["nomeMedico"];
  if (isset($_POST["dataConsulta"])) $dataConsulta = $_POST["dataConsulta"];
  if (isset($_POST["horarioConsulta"])) $horarioConsulta = $_POST["horarioConsulta"];
  if (isset($_POST["nomePaciente"])) $nomePaciente = $_POST["nomePaciente"];
  if (isset($_POST["email"])) $email = $_POST["email"];
  if (isset($_POST["sexoPaciente"])) $sexoPaciente = $_POST["sexoPaciente"];

  try {




    $sql = <<<SQL
    INSERT INTO Agenda (codigo_medico, data, horario, nome, sexo, email)
    VALUES ((SELECT m.codigo
    FROM Pessoa as p, Medico as m
    WHERE p.codigo = m.codigo AND p.nome =?), ?, ?, ?, ?, ?)
    SQL;
  


    $stmt = $pdo->prepare($sql);
    $stmt->execute([
      $nomeMedico, $dataConsulta, $horarioConsulta, $nomePaciente, $sexoPaciente, $email
    ]);
  
    header("location: ../agendamento.html");
    exit();
  } 
  catch (Exception $e) {  
    if ($e->errorInfo[1] === 1062)
      exit('Dados duplicados: ' . $e->getMessage());
    else
      exit('Falha ao cadastrar os dados: ' . $e->getMessage());
  }

?>