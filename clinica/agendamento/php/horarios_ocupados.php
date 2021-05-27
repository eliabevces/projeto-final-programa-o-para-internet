<?php



class Horario
{
  public $ocupado;


  function __construct($ocupado)
  {
    $this->ocupado = $ocupado;

  }
}


function checkhorarios($pdo, $nome_medico, $data_consulta)
{
  $sql = <<<SQL
    SELECT horario
    FROM Agenda as a, Pessoa as p
    WHERE p.nome = :nome AND a.data = :data AND a.codigo_medico = p.codigo
    SQL;

  try {

    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':nome' => $nome_medico, ':data' => $data_consulta));
    $horarios = array();

    while ($row = $stmt->fetch()) {
      array_push($horarios, new Horario($row['horario']));
    }

    return $horarios;

  } 
  catch (Exception $e) {
    //error_log($e->getMessage(), 3, 'log.php');
    exit('Falha inesperada: ' . $e->getMessage());
  }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  require "../../database/conexaoMysql.php";
  $pdo = mysqlConnect();

  $nome_medico = $data_consulta = "";

  $nome_medico = $_POST["nomeMedico"];
  
  $data_consulta = $_POST["dataConsulta"];
  

  // $stmt->execute([$nome_medico, $data_consulta]);



  echo json_encode(checkhorarios($pdo, $nome_medico, $data_consulta));
}

?>