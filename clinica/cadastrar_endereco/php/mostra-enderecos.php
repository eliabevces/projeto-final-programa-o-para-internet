<?php

require "../database/conexaoMysql.php";
$pdo = mysqlConnect();

try {

  $sql = <<<SQL
  SELECT cep, logradouro, cidade, estado
  FROM EnderecoAjax
  SQL;

  // Neste exemplo não é necessário utilizar prepared statements
  // porque não há possibilidade de injeção de SQL, 
  // pois nenhum parâmetro é utilizado na query SQL
  $stmt = $pdo->query($sql);
} 
catch (Exception $e) {
  //error_log($e->getMessage(), 3, 'log.php');
  exit('Ocorreu uma falha: ' . $e->getMessage());
}
?>
<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Endereços</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-CuOF+2SnTUfTwSZjCXf01h7uYhfOBuxIhGKPbfEJ3+FqH/s6cIFN9bGr1HmAg4fQ" crossorigin="anonymous">

  <style>
    body {
      padding-top: 2rem;
    }
    img {
      width: 15px;
      height: 15px;
    }
  </style>
</head>

<body>

  <div class="container">
    <h3>Endereços cadastrados</h3>
    <table class="table table-striped table-hover">
      <tr>
        <th></th>
        <th>CEP</th>
        <th>Logradouro</th>
        <th>Cidade</th>
        <th>Estado</th>
      </tr>

      <?php
      while ($row = $stmt->fetch()) {

        // Limpa os dados produzidos pelo usuário
        // com possibilidade de ataque XSS
        $cep = htmlspecialchars($row['cep']);
        $logradouro = htmlspecialchars($row['logradouro']);
        $cidade = htmlspecialchars($row['cidade']);
        $estado = htmlspecialchars($row['estado']);

        echo <<<HTML
          <tr>
            <td><a href="exclui-endereco.php?cep=$cep">
              <img src="../../images/delete.png"></a>
            </td> 
            <td>$cep</td>
            <td>$logradouro</td>
            <td>$cidade</td> 
            <td>$estado</td>
          </tr>      
        HTML;
      }
      ?>

    </table>
  </div>

</body>

</html>