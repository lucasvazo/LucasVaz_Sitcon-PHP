<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<header class="container" >
    <ul class="container d-flex flex-row">
        <li <?php if($current_page === 'index.php') echo 'class="active"'; ?>>
            <a href="/">Solicitações Clínicas</a>
        </li>
        <li <?php if($current_page === 'solicitacoes.php') echo 'class="active"'; ?>>
            <a href="/solicitacoes">Listagem de Solicitações</a>
        </li>
    </ul>
</header>