<?php
require "../../database/conexaoMysql.php";
$pdo = mysqlConnect();

$cep = "";
if (isset($_GET["cep"]))
  $cep = $_GET["cep"];

try {

  $sql = <<<SQL
  DELETE FROM EnderecoAjax
  WHERE cep = ?
  LIMIT 1
  SQL;

  // Neste caso utilize prepared statements para prevenir
  // ataques do tipo SQL Injection, pois a declaração
  // SQL contem um parâmetro (cpf) vindo da URL
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$cep]);

  header("location: mostra-enderecos.php");
  exit();
} 
catch (Exception $e) {  
  exit('Falha inesperada: ' . $e->getMessage());
}
