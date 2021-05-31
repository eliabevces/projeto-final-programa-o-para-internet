<?php

session_start();

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
    if ($row){
      if(password_verify($senha, $row['senha_hash'])){
        return $row['senha_hash'];
      }
    }

    return NULL; 
  } 
  catch (Exception $e) {
    exit('Falha inesperada: ' . $e->getMessage());
  }
}

function checkMedico($pdo, $email)
{
  $sql = <<<SQL
    SELECT especialidade
    FROM Medico as m, Pessoa as p
    WHERE p.codigo = m.codigo AND p.email = ?
    SQL;

  try {

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $row = $stmt->fetch();
    if ($row){
      return true;
    }

    return false; 
  } 
  catch (Exception $e) {
    exit('Falha inesperada: ' . $e->getMessage());
  }
}

if($_SESSION["emailUsuario"] && $_SESSION["loginString"]){
  $requestResponse = new RequestResponse(false, "LOGADO");
} else {
  $errorMsg = "";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require "../../database/conexaoMysql.php";
    $pdo = mysqlConnect();

    $email = $senha = "";

    if (isset($_POST["email"]))
      $email = htmlspecialchars($_POST["email"]);
    if (isset($_POST["senha"]))
      $senha = htmlspecialchars($_POST["senha"]);

    $senhaHash = checkLogin($pdo, $email, $senha);
    if ($senhaHash) {
      if(checkMedico($pdo, $email)){
        $_SESSION["usuarioMedico"] = true;
      }

      $_SESSION["emailUsuario"] = $email;
      $_SESSION["loginString"] = hash('sha512', $senhaHash, $_SERVER['HTTP_USER_AGENT']);
      

      $requestResponse = new RequestResponse(true, "sessao_restrita/sessao_restrita.php");
    } else {
      $errorMsg = "Dados incorretos";
      $requestResponse = new RequestResponse(false, "");
    }
  }
}

echo json_encode($requestResponse);

?>