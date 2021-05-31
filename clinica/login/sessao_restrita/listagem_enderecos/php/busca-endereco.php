<?php

require "../../../../database/conexaoMysql.php";
$pdo = mysqlConnect();

class Endereco
{
  public $logradouro;
  public $estado;
  public $cidade;

  function __construct($logradouro, $estado, $cidade)
  {
    $this->logradouro = $logradouro;
    $this->estado = $estado; 
    $this->cidade = $cidade;
  }
}

$cep = $_GET['cep'] ?? '';

$sql = <<<SQL
    SELECT logradouro, estado, cidade 
    FROM EnderecoAjax
    WHERE cep = ?
    SQL;

try{
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$cep]);
  $row = $stmt->fetch();
} catch (Exception $e) {
  //error_log($e->getMessage(), 3, 'log.php');
  exit('Ocorreu uma falha: ' . $e->getMessage());
}

if($row){
  $logradouro = htmlspecialchars($row['logradouro']);
  $estado = htmlspecialchars($row['estado']);
  $cidade = htmlspecialchars($row['cidade']);

  $endereco = new Endereco($logradouro, $estado, $cidade);
} else {
  $endereco = new Endereco('', '', '');
}

echo json_encode($endereco);