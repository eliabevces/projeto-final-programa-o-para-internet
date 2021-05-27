<?php

require "../../database/conexaoMysql.php";
$pdo = mysqlConnect();


try{
  $sql = <<<SQL
    SELECT nome
    FROM Pessoa as p, Medico as m
    WHERE m.codigo = p.codigo AND m.especialidade = ?
    SQL;

  $stmt = $pdo->prepare($sql);


} catch (Exception $e) {
  exit('Ocorreu uma falha: ' . $e->getMessage());
}

$especialidade = $_GET['especialidade'] ?? '';


class Medico
{
  public $nome;


  function __construct($nome)
  {
    $this->nome = $nome;

  }
}

$stmt->execute([$especialidade]);


$medicos = array();
while ($row = $stmt->fetch()) {
  array_push($medicos, new Medico($row['nome']));
}
echo json_encode($medicos);