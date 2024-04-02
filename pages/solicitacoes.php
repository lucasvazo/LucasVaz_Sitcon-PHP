<?php 
    include 'config/connect.php';
    $itemsPerPage = 10;
    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
    $offset = ($currentPage - 1) * $itemsPerPage;

    $query = "SELECT agendamento.id, paciente.nome AS nome_paciente, paciente.cpf, tipo_solicitacao.descricao AS tipo_solicitacao, 
                procedimento.descricao AS procedimentos, agendamento.data_agendamento
                FROM agendamento
                INNER JOIN paciente ON agendamento.paciente_id = paciente.id
                INNER JOIN tipo_solicitacao ON agendamento.procedimento_id = tipo_solicitacao.id
                INNER JOIN procedimento ON agendamento.procedimento_id = procedimento.id";
          
    $result = $connect->query($query);

    if (!$result) {
        trigger_error('Invalid query: ' . $connect->error);
    }

    $totalItems = $connect->query("SELECT COUNT(*) as total FROM agendamento")->fetch_assoc()['total'];
    $totalPages = ceil($totalItems / $itemsPerPage);

    if ($currentPage < 1) {
        $currentPage = 1;
    } elseif ($currentPage > $totalPages) {
        $currentPage = $totalPages;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamentos</title>
    <meta name="author" content="Lucas Vaz">
    <link rel="icon" href="./assets/images/sitcon-logo.ico">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"
    />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" 
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" 
        crossorigin="anonymous" referrerpolicy="no-referrer" 
    />
    <!-- Styles -->
    <link rel="stylesheet" href="assets/styles/reset.css" />
    <link rel="stylesheet" href="assets/styles/global.css" />
    <link rel="stylesheet" href="assets/styles/agendamentos.css" />
</head>
<body class="page-content">
    <?php include 'includes/header.php' ?>
    <main class="container main-content">
        <table class="table agendamentos-table box-shadow">
            <thead> 
                <tr>
                    <th scope="col">Nome Paciente</th>
                    <th scope="col">CPF</th>
                    <th scope="col">Tipo de Solicitação</th>
                    <th scope="col">Procedimento</th>
                    <th scope="col">Data e Hora</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    while ($row = $result-> fetch_assoc()) {
                        echo "<tr scope='row' >";
                        echo "<td>" . $row['nome_paciente'] . "</td>";
                        echo "<td>" . $row['cpf'] . "</td>";
                        echo "<td>" . $row['tipo_solicitacao'] . "</td>";
                        echo "<td>" . $row['procedimentos'] . "</td>";
                        echo "<td>" . date('d/m/Y H:i', strtotime($row['data_agendamento'])) . "</td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
        <?php include 'includes/pagination.php' ?>
    </main>
    <?php include 'includes/footer.php' ?>
</body>
</html>
