<?php

require "../../database/conexaoMysql.php";
$pdo = mysqlConnect();


try{
  $sql = <<<SQL
    SELECT distinct especialidade
    FROM Medico as m
    SQL;

  $stmt = $pdo->prepare($sql);


} catch (Exception $e) {
  exit('Ocorreu uma falha: ' . $e->getMessage());
}



class Medico_esp
{
  public $especialidade;


  function __construct($especialidade)
  {
    $this->especialidade = $especialidade;

  }
}

$stmt->execute();


$medico_esp = array();
while ($row = $stmt->fetch()) {
  array_push($medico_esp, new Medico_esp($row['especialidade']));
}
echo json_encode($medico_esp);