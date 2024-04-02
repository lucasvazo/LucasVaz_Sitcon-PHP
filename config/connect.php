<?php 
    include 'config.php';

    $connect = new mysqli($db_host, $db_user, $db_password, $db_name);

    if ($connect->connect_error) {
        die("Erro na conexão com o banco de dados: " . $connect->connect_error);
    }
?>