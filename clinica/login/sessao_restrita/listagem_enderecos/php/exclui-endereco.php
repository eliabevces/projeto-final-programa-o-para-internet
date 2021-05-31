<?php
require "../../../../database/conexaoMysql.php";
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

  $stmt = $pdo->prepare($sql);
  $stmt->execute([$cep]);

  header("location: ../listagem_enderecos.php");
  exit();
} 
catch (Exception $e) {  
  exit('Falha inesperada: ' . $e->getMessage());
}
