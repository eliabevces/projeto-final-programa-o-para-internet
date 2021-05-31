<?php
require "../../../../database/conexaoMysql.php";
$pdo = mysqlConnect();

$codigo = "";
if (isset($_GET["codigo"]))
  $codigo = $_GET["codigo"];

try {

  $sql = <<<SQL
  DELETE FROM Agenda
  WHERE codigo = ?
  LIMIT 1
  SQL;

  // Neste caso utilize prepared statements para prevenir
  // ataques do tipo SQL Injection, pois a declaração
  // SQL contem um parâmetro (cpf) vindo da URL
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$codigo]);

  header("location: ../listagem_agendamentos.php");
  exit();
} 
catch (Exception $e) {  
  exit('Falha inesperada: ' . $e->getMessage());
}
