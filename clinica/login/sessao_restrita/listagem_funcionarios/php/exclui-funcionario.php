<?php
require "../../../../database/conexaoMysql.php";
$pdo = mysqlConnect();

$codigo = "";
if (isset($_GET["codigo"]))
  $codigo = $_GET["codigo"];

try {

  $sql = <<<SQL
  DELETE FROM Funcionario
  WHERE codigo = ?
  LIMIT 1
  SQL;

  $sql2 = <<<SQL
  DELETE FROM Pessoa
  WHERE codigo = ?
  LIMIT 1
  SQL;

  // Neste caso utilize prepared statements para prevenir
  // ataques do tipo SQL Injection, pois a declaração
  // SQL contem um parâmetro (cpf) vindo da URL
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$codigo]);

  $stmt2 = $pdo->prepare($sql2);
  $stmt2->execute([$codigo]);

  header("location: ../listagem_funcionarios.php");
  exit();
} 
catch (Exception $e) {  
  exit('Falha inesperada: ' . $e->getMessage());
}
