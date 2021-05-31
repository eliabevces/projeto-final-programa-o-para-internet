<?php

session_start();

if($_SESSION["emailUsuario"] && $_SESSION["loginString"]){
    $requestResponse = true;
} else {
    $requestResponse = false;
}

if(! $requestResponse){

    echo <<<HTML
    <h1>Não autorizado</h1>
    HTML;

    exit();
}

require "../../../database/conexaoMysql.php";
$pdo = mysqlConnect();

try {

  $sql = <<<SQL
  SELECT P.codigo, P.nome, P.telefone, P.cep, F.data_contrato
  FROM Funcionario F
  INNER JOIN Pessoa P ON P.codigo = F.codigo
  SQL;


  $stmt = $pdo->query($sql);
} 
catch (Exception $e) {
  //error_log($e->getMessage(), 3, 'log.php');
  exit('Ocorreu uma falha: ' . $e->getMessage());
}
?>

<!-- listagem de funcionarios page -->

<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-CuOF+2SnTUfTwSZjCXf01h7uYhfOBuxIhGKPbfEJ3+FqH/s6cIFN9bGr1HmAg4fQ" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <?php
        session_start();
        if($_SESSION["usuarioMedico"]){
            echo <<<HTML
            <link rel="stylesheet" href="../css/headerAndBodyrestritamed.css">
            HTML;
        }else{
            echo <<<HTML
            <link rel="stylesheet" href="../css/headerAndBodyrestrita.css">
            HTML;
        }

    ?>
    <link rel="icon" href="../../../images/logo.png">
    <script src="js/script.js"></script>
    <title>Listagem de funcionarios</title>

</head>

<body>

    <header>


        <a href="../sessao_restrita.php" class="logo_and_name">
            <img src="../../../images/logo.png" alt="logo clinica" class="logo_image">
            <p class="clinic_name">Orale Clínica</p>
        </a>
        <div class="nav_buttons">
            <a href="../cadastramento_funcionario/cadastramento_funcionario.php">Novo Funcionário</a>
            <a href="../cadastramento_paciente/cadastramento_paciente.php">Novo Paciente</a>
            <a href="listagem_funcionarios.php">Listar Funcionários</a>
            <a href="../listagem_pacientes/listagem_pacientes.php">Listar Pacientes</a>
            <a href="../listagem_enderecos/listagem_enderecos.php">Listar Endereços</a>
            <a href="../listagem_agendamentos/listagem_agendamentos.php">Listar todos Agendamentos</a>
            <?php
                if($_SESSION["usuarioMedico"]){
                    session_start();
                    echo <<<HTML
                    <a href="../listagem_agendamentos_medico/listagem_agendamentos_medico.php">Listar meus Agendamentos</a>
                    HTML;
                }
            ?>
            <a href="#" id="logout" >Sair</a>
        </div>

    </header>

    <main>
        <div class="container">
            <h3>Funcionários cadastrados</h3>
            </br>
            <table class="table table-striped table-hover">
                <tr>
                    <th></th>
                    <th>Código</th>
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th>CEP</th>
                    <th>Dt. Início contrato</th>
                </tr>

                <?php
                    while ($row = $stmt->fetch()) {

                        // Limpa os dados produzidos pelo usuário
                        // com possibilidade de ataque XSS
                        $codigo = $row['codigo'];
                        $nome = htmlspecialchars($row['nome']);
                        $cep = htmlspecialchars($row['cep']);
                        $telefone = htmlspecialchars($row['telefone']);
                        $dataContrato = htmlspecialchars($row['data_contrato']);

                        echo <<<HTML
                            <tr>
                            <td><a href="php/exclui-funcionario.php?codigo=$codigo">
                                <img src="../../../images/delete.png"></a>
                            </td> 
                            <td>$codigo</td>
                            <td>$nome</td>
                            <td>$telefone</td> 
                            <td>$cep</td>
                            <td>$dataContrato</td>
                            </tr>      
                        HTML;
                    }
                ?>

            </table>
        </div>
    </main>

</body>

</html>