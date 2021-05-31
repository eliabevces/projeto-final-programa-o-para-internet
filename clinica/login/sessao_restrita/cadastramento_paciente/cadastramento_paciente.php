<?php
    session_start();
    
    if($_SESSION["emailUsuario"] && $_SESSION["loginString"]){
        $requestResponse = true;
    } else {
        $requestResponse = false;
    }

    if($requestResponse){
        echo <<<HTML
            <!-- cadastramento de paciente page -->
            <!DOCTYPE html>
            <html lang="pt-BR">

            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-CuOF+2SnTUfTwSZjCXf01h7uYhfOBuxIhGKPbfEJ3+FqH/s6cIFN9bGr1HmAg4fQ" crossorigin="anonymous">
                <link rel="stylesheet" href="css/style.css">
                <link rel="stylesheet" href="../css/headerAndBodyrestrita.css">
                <link rel="icon" href="../../../images/logo.png">
                <script src="js/script.js"></script>


                <title>Cadastrar paciente</title>
            </head>

            <body>
                <header>


                    <a href="../sessao_restrita.php" class="logo_and_name">
                        <img src="../../../images/logo.png" alt="logo clinica" class="logo_image">
                        <p class="clinic_name">Orale Clínica</p>
                    </a>
                    <div class="nav_buttons">
                        <a href="../cadastramento_funcionario/cadastramento_funcionario.php">Novo Funcionário</a>
                        <a href="cadastramento_paciente.php">Novo Paciente</a>
                        <a href="../listagem_funcionarios/listagem_funcionarios.php">Listar Funcionários</a>
                        <a href="../listagem_pacientes/listagem_pacientes.php">Listar Pacientes</a>
                        <a href="../listagem_enderecos/listagem_enderecos.php">Listar Endereços</a>
                        <a href="../listagem_agendamentos/listagem_agendamentos.php">Listar todos Agendamentos</a>
                        <a href="../listagem_agendamentos_medico/listagem_agendamentos_medico.php">Listar meus Agendamentos</a>
                        <a href="#" id="logout" >Sair</a>
                    </div>

                </header>


                <main>
                    <h3>Cadastro de paciente</h3>
                    <form action="php/cadastra-agendamento.php" method="POST" class="row g-3">
                        <!-- nome, sexo, email, telefone, CEP, logradouro, cidade, estado, data de início do contrato de trabalho, salário e senha. -->
                        <div class="col-sm-9">
                            <label for="nomePaciente" class="form-label">Nome do paciente</label>
                            <input type="input" name="nomePaciente" class="form-control" id="nomePaciente">
                        </div>
                        <div class="col-sm-3">
                            <label for="sexoPaciente" class="form-label">Sexo do paciente</label>
                            <select type="select" name="sexoPaciente" class="form-select" id="sexoPaciente">
                                <option value="masculino">Masculino</option>
                                <option value="feminino">Feminino</option>
                                <option value="outro">Outro</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" name="email" class="form-control" id="email">
                        </div>
                        <div class="col-sm-6">
                            <label for="telefone" class="form-label">Telefone do funcionario</label>
                            <input type="input" name="telefone" class="form-control" id="telefone">
                        </div>
                        <div class="col-sm-6">
                            <label for="cep" class="form-label">CEP</label>
                            <input type="text" name="cep" class="form-control" id="cep">
                        </div>
                        <div class="col-sm-6">
                            <label for="logradouro" class="form-label">Logradouro</label>
                            <input type="text" name="logradouro" class="form-control" id="logradouro">
                        </div>
                        <div class="col-sm-6">
                            <label for="cidade" class="form-label">Cidade</label>
                            <input type="text" name="cidade" class="form-control" id="cidade">
                        </div>
                        <div class="col-sm-6">
                            <label for="estado" class="form-label">Estado</label>
                            <input type="text" name="estado" class="form-control" id="estado">
                        </div>
                        <div class="col-sm-4">
                            <label for="peso" class="form-label">Peso</label>
                            <input type="number" step="0.01" min="0" name="peso" class="form-control" id="peso">
                        </div>
                        <div class="col-sm-4">
                            <label for="altura" class="form-label">Altura</label>
                            <input type="number" step="0.01" min="0" name="altura" class="form-control" id="altura">
                        </div>
                        <div class="col-sm-4">
                            <label for="tipoSanguineo" class="form-label">Tipo sanguíneo</label>
                            <select type="select" name="tipoSanguineo" class="form-select" id="tipoSanguineo">
                                <option value="aPos">A+</option>
                                <option value="aNeg">A-</option>
                                <option value="bPos">B+</option>
                                <option value="bNeg">B-</option>
                                <option value="abPos">AB+</option>
                                <option value="abNeg">AB-</option>
                                <option value="oPos">O+</option>
                                <option value="oNeg">O-</option>
                            </select> </div>
                        <div class="col-sm-12 d-grid">
                            <button class="btn btn-primary btn-block">Cadastrar</button>
                        </div>
                    </form>
                </main>

            </body>


            </html>

        HTML;
    } else {
        echo <<<HTML
        <h1>Não autorizado</h1>
        HTML;
        
    }

?>