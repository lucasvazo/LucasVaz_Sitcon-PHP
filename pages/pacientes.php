    <?php 
        include 'config/connect.php';
        $itemsPerPage = 10;
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($currentPage - 1) * $itemsPerPage;

        $query = "SELECT * FROM paciente LIMIT $offset, $itemsPerPage";
        $result = $connect->query($query);

        $totalItems = $connect->query("SELECT COUNT(*) as total FROM paciente")->fetch_assoc()['total'];
        $totalPages = ceil($totalItems / $itemsPerPage);

        if ($currentPage < 1) {
            $currentPage = 1;
        } elseif ($currentPage > $totalPages) {
            $currentPage = $totalPages;
        }

        $query = "SELECT * FROM paciente LIMIT $offset, $itemsPerPage";
        $result = $connect->query($query);
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
            
            <table class="table patients-table box-shadow">
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
                        while ($row = $result-> fetch_assoc()) {
                            echo "<tr scope='row' >";
                            echo "<td>" . $row['nome'] . "</td>";
                            echo "<td>" . date('d/m/Y', strtotime($row['data_nascimento'])) . "</td>";
                            echo "<td>" . $row['cpf'] . "</td>";
                            echo "<td>
                                    <a href='/solicitar?id={$row['id']}' class='btn-primary btn-primary-orange'>
                                        Prosseguir
                                    </a>
                                </td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>

            <nav>
                <ul class="pagination justify-content-center">
                    <li class="page-item <?php echo $currentPage <= 1 ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $currentPage - 1; ?>" tabindex="-1" aria-disabled="true">
                            <i class="fa-solid fa-angle-left"></i>
                        </a>
                    </li>
                    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                        <li class="page-item <?php echo $i == $currentPage ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?php echo $currentPage >= $totalPages ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $currentPage + 1; ?>">
                            <i class="fa-solid fa-angle-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>

        </main>
        <?php include 'includes/footer.php' ?>
        <script src="assets/scripts/search-bar.js" defer></script>
    </body>
    </html>
