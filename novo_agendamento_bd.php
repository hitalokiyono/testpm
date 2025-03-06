<?php
try {
    require_once("./conexao/conexao.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nomeEventos = $_POST['nome_do_evento'];
        $descricao = $_POST['descricao'];
        $dtCheck = $_POST['dt_check'];
        $unidades = $_POST['unidades']; // Unidades selecionadas

        var_dump($dtCheck, $unidades);

        // Validação simples
        if (!empty($nomeEventos) && !empty($descricao) && !empty($dtCheck)) {
            foreach ($nomeEventos as $nomeEvento) {
                // Verifica se foi marcado "todos" ou unidades específicas
                if (in_array('all', $unidades)) {
                    // Inserir para todas as unidades
                    $postos = [0, 2, 3, 4, 5];
                } else {
                    // Inserir para as unidades específicas selecionadas
                    $postos = $unidades;
                }

                // Insere o agendamento para cada unidade
                foreach ($postos as $posto) {
                    // Inserir o agendamento na tabela 'agendamentos'
                    $sql = "INSERT INTO agendamentos (nome, descricao, datapadrao, posto) 
                            VALUES (:nome_evento, :descricao, :dt_check, :posto)";
                    $stmt = $conexao->prepare($sql);
                    $stmt->bindParam(':nome_evento', $nomeEvento);
                    $stmt->bindParam(':descricao', $descricao);
                    $stmt->bindParam(':dt_check', $dtCheck, PDO::PARAM_STR);
                    $stmt->bindParam(':posto', $posto, PDO::PARAM_INT);

                    if ($stmt->execute()) {
                        // Após inserir o agendamento, pegar o id do agendamento inserido
                        $idAgendamento = $conexao->lastInsertId();

                        // Consultar os PMs que têm permissão para o posto selecionado
                        $sqlPms = "SELECT p.id, pm.id_pm
                                   FROM p1 p
                                   LEFT JOIN permissoes pm ON p.id = pm.id_pm
                                   WHERE pm.permissao = :posto AND p.status = 1";
                        $stmtPms = $conexao->prepare($sqlPms);
                        $stmtPms->bindParam(':posto', $posto, PDO::PARAM_INT);
                        $stmtPms->execute();

                        // Verificar se há PMs que têm permissão para o posto
                        while ($row = $stmtPms->fetch(PDO::FETCH_ASSOC)) {
                            $idPm = $row['id_pm'];

                            // Pegar a data atual para o campo Data (agendamento)
                            $dataAtual = date('Y-m-d'); // Somente data (sem hora)

                            // Inserir na tabela data_agendamento para o PM autorizado
                            $sqlDataAgendamento = "INSERT INTO data_agendamento (id_pm, tipo_agendamento, entregue, Data)
                                                   VALUES (:id_pm, :tipo_agendamento, 0, :data_agendamento)";
                            $stmtData = $conexao->prepare($sqlDataAgendamento);

                            // A data do agendamento será a data atual
                            $stmtData->bindParam(':id_pm', $idPm, PDO::PARAM_INT); // Utilizando o id_pm da tabela de permissões
                            $stmtData->bindParam(':tipo_agendamento', $idAgendamento, PDO::PARAM_INT); // Atribuindo o id_agenda ao tipo_agendamento
                            $stmtData->bindParam(':data_agendamento', $dataAtual, PDO::PARAM_STR); // A data atual será inserida aqui

                            $stmtData->execute();
                        }
                    }
                }
            }

            // Redireciona após inserir os dados
            header("Location: ./novo_agendamento.php");
        } else {
            echo "Preencha todos os campos.";
        }
    }
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>
