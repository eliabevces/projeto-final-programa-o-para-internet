<?php

session_start();

if($_SESSION["emailUsuario"] && $_SESSION["loginString"]){
    $requestResponse = true;
} else {
    $requestResponse = false;
}

if(! $requestResponse || !$_SESSION["usuarioMedico"]){

    echo <<<HTML
    <h1>Não autorizado</h1>
    HTML;

    exit();
}


require "../../../database/conexaoMysql.php";
$pdo = mysqlConnect();


$email = $_SESSION['emailUsuario'];

try {

    $sql = <<<SQL
    SELECT a.codigo, a.codigo_medico, a.data, a.horario, a.nome, a.sexo, a.email
    FROM Agenda as a, Pessoa as p, Medico as m
    WHERE m.codigo = p.codigo AND m.codigo = a.codigo_medico AND  p.email = ?
    SQL;


    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-CuOF+2SnTUfTwSZjCXf01h7uYhfOBuxIhGKPbfEJ3+FqH/s6cIFN9bGr1HmAg4fQ" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="../css/headerAndBodyrestritamed.css">
    <link rel="icon" href="../../../images/logo.png">
    <script src="js/script.js"></script>
    <title>Listagem de agendamentos</title>

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
            <a href="../listagem_funcionarios/listagem_funcionarios.php">Listar Funcionários</a>
            <a href="../listagem_pacientes/listagem_pacientes.php">Listar Pacientes</a>
            <a href="../listagem_enderecos/listagem_enderecos.php">Listar Endereços</a>
            <a href="../listagem_agendamentos/listagem_agendamentos.php">Listar todos Agendamentos</a>
            <a href="../listagem_agendamentos_medico/listagem_agendamentos_medico.php">Listar meus Agendamentos</a>
            <a href="#" id="logout" >Sair</a>
        </div>

    </header>

    <main>
        <div class="container">
            <h3>Agendamentos cadastrados</h3>
            </br>
            <table class="table table-striped table-hover">
                <tr>
                    <th></th>
                    <th>Código Agendamento</th>
                    <th>Código Médico</th>
                    <th>Nome</th>
                    <th>Sexo</th>
                    <th>Email</th>
                    <th>Data</th>
                    <th>Horário</th>
                </tr>

                <?php
                    while ($row = $stmt->fetch()) {

                        // Limpa os dados produzidos pelo usuário
                        // com possibilidade de ataque XSS
                        $codigoAgenda = $row['codigo'];
                        $codigoMedico = $row['codigo_medico'];
                        $data = $row['data'];
                        $horario = $row['horario'];
                        $nome = htmlspecialchars($row['nome']);
                        $sexo = htmlspecialchars($row['sexo']);
                        $email = htmlspecialchars($row['email']);

                        echo <<<HTML
                            <tr>
                            <td><a href="php/exclui-agendamento.php?codigo=$codigoAgenda">
                                <img src="../../../images/delete.png"></a>
                            </td> 
                            <td>$codigoAgenda</td>
                            <td>$codigoMedico</td>
                            <td>$nome</td> 
                            <td>$sexo</td>
                            <td>$email</td>
                            <td>$data</td>
                            <td>$horario</td>

                            </tr>      
                        HTML;
                    }
                ?>

            </table>
        </div>
    </main>


</body>

</html>
