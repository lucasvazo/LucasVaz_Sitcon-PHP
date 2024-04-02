<?php 
    include 'config/connect.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $profissionalId = $_POST['profissional'];
        $tipoSolicitacaoId = $_POST['tipo_solicitacao'];
        $procedimentoId = $_POST['procedimentos'];
        $dataAgendamento = $_POST['data_agendamento'];
        $horarioAgendamento = $_POST['horario_agendamento'];
        $pacienteId = isset($_GET['id']) ? $_GET['id'] : 1;
        $pacienteId = (int) $pacienteId;

        $dataHoraAgendamento = $dataAgendamento . ' ' . $horarioAgendamento;

        $query = "INSERT INTO agendamento (data_agendamento, paciente_id, procedimento_id, profissional_id)
                  VALUES ('$dataHoraAgendamento', $pacienteId, $procedimentoId, $profissionalId)";
    }

    $currentPatientId = isset($_GET['id']) ? $_GET['id'] : 1;
    $currentPatientId = (int) $currentPatientId;

    $currentProfissionalId = isset($_GET['profissional']) ? $_GET['profissional'] : 1;
    $currentProfissionalId = (int) $currentProfissionalId;

    $currentTipoSolicitacaoId = isset($_GET['tipo_solicitacao']) ? $_GET['tipo_solicitacao'] : 1;
    $currentTipoSolicitacaoId = (int) $currentTipoSolicitacaoId;

    $patientQuery = "SELECT * FROM paciente WHERE id = $currentPatientId";
    $patientResult = $connect->query($patientQuery);
    $patient = $patientResult->fetch_assoc();

    $profissionalQuery = "SELECT * FROM profissional WHERE status = 'ativo'";
    $profissionalResult = $connect->query($profissionalQuery);

    $tipoSolicitacaoQuery = "SELECT DISTINCT ts.id, ts.descricao, pa.profissional_id FROM tipo_solicitacao ts 
                        INNER JOIN procedimento p ON ts.id = p.tipo_id 
                        INNER JOIN profissional_atende pa ON p.id = pa.procedimento_id
                        WHERE ts.status = 'ativo'";
    $tipoSolicitacaoResult = $connect->query($tipoSolicitacaoQuery);

    $procedimentoQuery = "SELECT p.id, p.descricao, ts.id as tipo_id FROM procedimento p 
                        INNER JOIN tipo_solicitacao ts ON p.tipo_id = ts.id 
                        WHERE p.status = 'ativo'";
    $procedimentoResult = $connect->query($procedimentoQuery);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Nova Solicitacao</title>
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
        <link rel="stylesheet" href="assets/styles/solicitar.css" />
    </head>
    <body class="page-content">
        <?php include 'includes/header.php' ?>

        <main class="container main-content">
            <form method="POST" class="appointment-form">
                <div class="form-row">
                    <a href="/" class="btn-primary btn-primary-outlined">Voltar</a>
                </div>
                <div class="form-row">
                    <div class="input-label">
                        <label for="nome">Nome</label>
                        <input disabled type="text" id="nome" name="nome" value="<?php echo $patient['nome']; ?>" readonly>
                    </div>
                    <div class="input-label">
                        <label for="data_nascimento">Data de Nascimento</label>
                        <input disabled type="text" id="data_nascimento" name="data_nascimento"
                            value="<?php echo date('d/m/Y', strtotime($patient['data_nascimento'])); ?>" readonly>
                    </div>
                    <div class="input-label">
                        <label for="cpf">CPF</label>
                        <input disabled type="text" id="cpf" name="cpf" value="<?php echo $patient['cpf']; ?>" readonly>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-row--warning">
                        <span>Atenção!</span> Os Campos com * devem ser preechidos obrigatóriamente.
                    </div>
                </div>
                <div class="form-row">
                    <div class="input-label">
                        <label for="profissional">Profissional *</label>
                        <select id="profissional" name="profissional" required>
                            <?php while ($profissional = $profissionalResult->fetch_assoc()) : ?>
                                <option value="<?php echo $profissional['id']; ?>" <?php echo $profissional['id'] == $currentProfissionalId ? 'selected' : ''; ?>>
                                    <?php echo $profissional['nome']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="input-label">
                        <label for="tipo_solicitacao">Tipo de Solicitação *</label>
                        <select id="tipo_solicitacao" name="tipo_solicitacao" placeholder="Selecione o Tipo de Solicitação" required>
                            <option value="">Selecione o Tipo de Solicitação</option>  
                            <?php 
                            $tipoSolicitacaoResult->data_seek(0);
                            while ($tipoSolicitacao = $tipoSolicitacaoResult->fetch_assoc()) : ?>
                                <option value="<?php echo $tipoSolicitacao['id']; ?>" <?php echo $tipoSolicitacao['id'] == $currentTipoSolicitacaoId ? 'selected' : ''; ?>>
                                    <?php echo $tipoSolicitacao['descricao']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="input-label">
                        <label for="procedimentos">Procedimentos *</label>
                        <select id="procedimentos" name="procedimentos" required>
                            <option value="">Selecione os Procedimentos</option>
                            <?php
                                $procedimentoQueryFiltered = "SELECT p.id, p.descricao FROM procedimento p 
                                WHERE p.status = 'ativo' AND p.tipo_id = $currentTipoSolicitacaoId";
                                $procedimentoResultFiltered = $connect->query($procedimentoQueryFiltered);
                                while ($procedimento = $procedimentoResultFiltered->fetch_assoc()) :
                            ?>
                                <option value="<?php echo $procedimento['id']; ?>">
                                    <?php echo $procedimento['descricao']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="input-label">
                        <label for="data_agendamento">Data *</label>
                        <input type="date" id="data_agendamento" name="data_agendamento" required>
                    </div>
                    <div class="input-label">
                        <label for="horario_agendamento">Hora *</label>
                        <input type="time" id="horario_agendamento" name="horario_agendamento" required>
                    </div>
                </div>
                <div class="form-row d-flex justify-content-end">
                    <button type="submit">Salvar</button>
                </div>
            </form>
        </main>
        <?php include 'includes/footer.php' ?>
    </body>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const profissionalDropdown = document.getElementById('profissional');
            const tipoSolicitacaoDropdown = document.getElementById('tipo_solicitacao');
            profissionalDropdown.addEventListener('change', function() {
                window.location.href = `?id=<?php echo $currentPatientId ?>&profissional=${this.value}`;
            });
            tipoSolicitacaoDropdown.addEventListener('change', function() {
                window.location.href = `?id=<?php echo $currentPatientId ?>&profissional=<?php echo $currentProfissionalId ?>&tipo_solicitacao=${this.value}`;
            });
        });
    </script>
</html>