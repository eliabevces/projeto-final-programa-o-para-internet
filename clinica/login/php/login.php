<?php

class RequestResponse {
  public $success;
  public $destination;

  function __construct($success, $destination) {
    $this->success = $success;
    $this->destination = $destination;
  }
}

function checkLogin($pdo, $email, $senha)
{
  $sql = <<<SQL
    SELECT senha_hash
    FROM Funcionario as f, Pessoa as p
    WHERE p.codigo = f.codigo AND p.email = ?
    SQL;

  try {

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $row = $stmt->fetch();
    if (!$row)
      return false; 
    else
      return password_verify($senha, $row['senha_hash']);
  } 
  catch (Exception $e) {
    exit('Falha inesperada: ' . $e->getMessage());
  }
}

$errorMsg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  require "../../database/conexaoMysql.php";
  $pdo = mysqlConnect();

  $email = $senha = "";

  if (isset($_POST["email"]))
    $email = htmlspecialchars($_POST["email"]);
  if (isset($_POST["senha"]))
    $senha = htmlspecialchars($_POST["senha"]);

  if (checkLogin($pdo, $email, $senha)) {
    $requestResponse = new RequestResponse(true, "sessao_restrita.html");
  } else {
    $errorMsg = "Dados incorretos";
    $requestResponse = new RequestResponse(false, "");
  }

  echo json_encode($requestResponse);
}

?>