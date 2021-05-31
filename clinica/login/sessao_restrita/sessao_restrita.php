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
    ?>


<!-- sessaso restrita page -->
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-CuOF+2SnTUfTwSZjCXf01h7uYhfOBuxIhGKPbfEJ3+FqH/s6cIFN9bGr1HmAg4fQ" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <?php
        session_start();
        if($_SESSION["usuarioMedico"]){
            echo <<<HTML
            <link rel="stylesheet" href="css/headerAndBodyrestritamed.css">
            HTML;
        }else{
            echo <<<HTML
            <link rel="stylesheet" href="css/headerAndBodyrestrita.css">
            HTML;
        }

    ?>
    <link rel="icon" href="../../images/logo.png">
    <script src="logout/js/script.js"></script>

    <title>Área Restrita</title>
</head>

<body>
    <header>

        <a href="sessao_restrita.php" class="logo_and_name">
            <img src="../../images/logo.png" alt="logo clinica" class="logo_image">
            <p class="clinic_name">Orale Clínica</p>
        </a>


    </header>

    <main>

        <a href="cadastramento_funcionario/cadastramento_funcionario.php">Novo Funcionário</a>
        <a href="cadastramento_paciente/cadastramento_paciente.php">Novo Paciente</a>
        <a href="listagem_funcionarios/listagem_funcionarios.php">Listar Funcionários</a>
        <a href="listagem_pacientes/listagem_pacientes.php">Listar Pacientes</a>
        <a href="listagem_enderecos/listagem_enderecos.php">Listar Endereços</a>
        <a href="listagem_agendamentos/listagem_agendamentos.php">Listar todos Agendamentos</a>
        <?php
            if($_SESSION["usuarioMedico"]){
                session_start();
                echo <<<HTML
                <a href="listagem_agendamentos_medico/listagem_agendamentos_medico.php">Listar meus Agendamentos</a>
                HTML;
            }
        ?>
        <a href="#" id="logout" >Sair</a>

    </main>

</body>


</html>



