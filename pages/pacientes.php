<?php 
    include 'config/connect.php';
    $itemsPerPage = 10;
    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
    $offset = ($currentPage - 1) * $itemsPerPage;

    $query = "SELECT * FROM paciente LIMIT $offset, $itemsPerPage";
    $result = $connect->query($query);

    $totalItems = $result->num_rows;
    $totalPages = ceil($totalItems / $itemsPerPage);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitações Clínicas</title>
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
    <link rel="stylesheet" href="assets/styles/pacientes.css" />
</head>
<body class="page-content">
    <?php include 'includes/header.php' ?>
    <main class="container main-content">

        <form class="search-input--form">
            <i class="fas fa-search"></i>
            <input 
                type="text" 
                id="filter-patients"
                placeholder="Pesquisar..." 
                aria-label="Pesquisar paciente"
            >
        </form>
        
        <table class="table patients-table">
            <thead> 
                <tr>
                    <th scope="col">Paciente</th>
                    <th scope="col">Nascimento</th>
                    <th scope="col">CPF</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['nome'] . "</td>";
                        echo "<td>" . date('d/m/Y', strtotime($row['data_nascimento'])) . "</td>";
                        echo "<td>" . $row['cpf'] . "</td>";
                        echo "<td><a href='formulario.php?id=" . $row['id'] . "' class='btn btn-primary'>Preencher Formulário</a></td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>

    </main>
    <?php include 'includes/footer.php' ?>
    <script src="assets/scripts/search-bar.js" defer></script>
</body>
</html>
