<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Romaneio</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/estilo.css">
    <link rel="stylesheet" href="../css/inicial.css">
    <link rel="stylesheet" href="./pm.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    .btn-laranja {
    background-color: #ff8000 !important;
    color: white !important;
    border: none;
}
html,body{
    background-color:rgb(246, 246, 246); 
}
.hidden {
    display: none;
}
.tabela-container3{
min-width:30%;
} 
.tabela-container3 thead {
    min-width: 100%;}

  
    .direita{
        text-align: right;
  }


</style>
<body>
<?php require_once("./menu.php");

if (!isset($_SESSION)) {
    session_start();
}

?>

    <h1 class="titulo">Alocação de veiculo </h1>
    <div id="container" class="d-flex justify-content-around p-3"> 

    <!-- Tabela Funcionários -->
    <div class="tabela-container" id="tabela-container"  style=" display: block;">
        <div class="pesquisar" style="margin-left: 10px; display: flex;">
            <input type="text" id="buscaPatrimonio" class="form-control mb-3" placeholder="Digite o RE...">
            <button type="button" class="btn btn-primary" style="margin-left: 10px; height: 36px;" onclick="buscarRegistro()">Pesquisar</button>
            </div>
        <div class="titulo" style="margin-left:20px; font-family: Arial, sans-serif;">Funcionários</div>
            <table class="table table-striped">
                <thead>
            <tr>
                    <th>Nome Completo</th>
                    <th>RE</th>
                    <th>Passageiro</th>
                    <th>Responsável</th>
            </tr>
                </thead>
                <tbody id="tabelaResultados">
                    <?php require_once("./material_viewveiculo.php"); ?>
                </tbody>
            </table>
            <?php if ($_SESSION["permissao"] == 5): ?>
    <p><strong>Responsável selecionado:</strong> <span id="responsavelSelecionado">Nenhum</span></p>
    <p><strong>pms selecionados no checkbox:</strong> <span id="pmsselecionado">Nenhum</span></p>
    <button class="btn btn-warning" onclick="salvarSelecionados()">Salvar</button>
<?php endif; ?>
        </div>

        <div class="tabela-container2" id="tabela-container2" style=" display: block;" >
        <div class="pesquisar" style="  margin-left: 10px; display: flex;">
            <input type="text" id="buscaPatrimonio2" class="form-control mb-3" placeholder="Digite a placa da viatura...">
            <button type="button" style="margin-left: 10px; height: 36px;" class="btn btn-primary" onclick="buscarRegistro2()">Pesquisar</button>
            </div>
            <div class="titulo"  style="margin-left:20px;  font-family: Arial, sans-serif;; ">controle de alocação viatura</div>
            <table class="table table-striped">
                <thead>
        
            <tr>
                    <th>Placa</th>
                    <th>Prefixo</th>
                    <th>Numero de patrimonio </th>
                    <th>Selecionar</th>
            </tr>
                </thead>
          
                <tbody id="tabelaResultados2">
                    <?php require_once("./material_viewveiculo2.php"); 
                    ?>
                </tbody>
            </table>
            <?php if ($_SESSION["permissao"] == 5): ?>
    <p><strong>viatura selecionado:</strong> <span id="viatura">Nenhum</span></p>
<?php endif; ?>
        </div>

<div class="tabela-container3"  id="tabela-container3" style=" display: block;" > 
<div class="tabela-container3">
        <div class="titulo" style="margin-left:20px; font-family: Arial, sans-serif;">Função viatura</div>
            <table class="table table-striped">
                <thead>
            <tr>
                    <th class="hidden">id_funcao</th>
                    <th>funcao</th>
                    <th>selecionar</th>
            </tr>
                </thead>
                <tbody id="tabelaResultados">
                    <?php 
                    $comandoSQL = "select * from p4_funcao
                    ";
                    $stmt = $conexao->prepare($comandoSQL);
                    $stmt->execute();
                    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    if (count($dados) > 0) {
                        foreach ($dados as $row) {
                            echo "<tr id='linha-{$row['id_funcao']}'>
                                    <td class='hidden'>{$row['id_funcao']}</td>
                                    <td>{$row['funcao']}</td>";  
                        
                        if ($_SESSION["permissao"] == 5) {
                            echo "<td class='direita'>
                <button  class='btn btn-primary marcar-funcao' onclick='marcarfuncao({$row['id_funcao']})'>Marcar</button>
                
                                  </td>";
                        }
                        echo "</tr>";
                    }
                   }
                    ?>
                </tbody>
            </table>
            <?php if ($_SESSION["permissao"] == 5): ?>
                <p><strong>Função selecionada:</strong> <span id="id_funcao">Nenhum</span></p>

<?php endif; ?>
</div>
</div>

<div class="tabela-container4" id="tabela-container4" style="display: none;">
    <div class="pesquisar" style="margin-left: 10px; display: flex;">
        <input type="text" id="buscaPatrimonio4" class="form-control mb-3" placeholder="Digite o número de patrimônio do material...">
        <button type="button" style="margin-left: 10px; height: 36px;" class="btn btn-primary" onclick="buscarRegistro4()">Pesquisar</button>
    </div>

    <div class="titulo" style="margin-left:20px; font-family: Arial, sans-serif;">Controle de Alocação de Materiais</div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th class="hidden">ID</th>
                <th>Número de Patrimônio</th>
                <th>Modelo</th>
                <th>Tipo</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody id="tabelaResultados4">
            <?php 
            // SQL + preenchimento da tabela
            $comandoSQL = "
             SELECT 
                inv.id AS inventario_id, 
                inv.numerodepatrimonio,
                inv.idTipo_tabela,
                mo.modelo,
                tt.tipo,
                sta.estado
            FROM p4_inventario AS inv
            INNER JOIN p4_status AS sta ON sta.idStatus = inv.idStatus
            INNER JOIN p4_tipo_tabelas AS tt ON tt.id_tabela = inv.idTipo_tabela
            LEFT JOIN p4_tpd AS tpd ON tpd.numerodepatrimonio = inv.numerodepatrimonio
            LEFT JOIN p4_taser AS taser ON taser.numerodepatrimonio = inv.numerodepatrimonio
            LEFT JOIN p4_ht AS ht ON ht.numerodepatrimonio = inv.numerodepatrimonio
            LEFT JOIN p4_material AS material ON material.numerodepatrimonio = inv.numerodepatrimonio
            LEFT JOIN p4_modelos AS mo ON mo.idModelo = 
                COALESCE(tpd.idModelo, taser.idModelo, ht.idModelo, material.idModelo)
            WHERE 
                COALESCE(tpd.idModelo, taser.idModelo, ht.idModelo, material.idModelo) IS NOT NULL;
            ";
            $stmt = $conexao->prepare($comandoSQL);
            $stmt->execute();
            $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($dados) > 0) {
                foreach ($dados as $row) {
                    echo "<tr id='linha-{$row['inventario_id']}'>
                            <td class='hidden'>{$row['inventario_id']}</td>
                            <td>{$row['numerodepatrimonio']}</td>
                            <td>{$row['modelo']}</td>
                            <td>{$row['tipo']}</td>
                            <td>{$row['estado']}</td>";

                    if ($_SESSION["permissao"] == 5  && $row['estado'] == 'Baixado' ) {
                        echo "<td class='direita'>
                              <button class='btn btn-primary marcar-materiais' onclick='marcarmaterias(this, {$row['inventario_id']})'>Marcar</button>

                              </td>";
                    } else {
                        echo "<td>-</td>";
                    }

                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>

    <p><strong>Material selecionado(s):</strong> <span id="id_material">Nenhum</span></p>

    <?php if ($_SESSION["permissao"] == 5): ?>
        <button class="btn btn-warning" onclick="salvarSelecionados4()">Salvar</button>
    <?php endif; ?>
</div>
<div class="tabela-container5" id="tabela-container5"  style="display: none;">
    <div class="titulo" style="margin-left:20px; font-family: Arial, sans-serif;">marcar setor selecionado</div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>numero do setor</th>
                <th>ações</th>
            </tr>
        </thead>
        <tbody id="tabelaResultados5">
            <?php for ($i = 1; $i <= 20; $i++): ?>
                <tr>
                    <td><?= $i ?></td>
                    <td class='direita'>
                        <button class='btn btn-primary marcar-setor' onclick='marcarsetor(<?= $i ?>)'>Marcar</button>
                    </td>
                </tr>
            <?php endfor; ?>
        </tbody>
    </table>
    <?php if ($_SESSION["permissao"] == 5): ?>
        <p><strong>setor selecionado:</strong> <span id="id_setor">Nenhum</span></p>
    <?php endif; ?>
</div>
</div>
    <script>
const materiaisSelecionados = new Set();
    let setorSelecionado = null;

    let selecionados = new Set(); // Para guardar PMs selecionados
let responsavel = null;

    function marcarsetor(id) {
        setorSelecionado = id;
        document.getElementById("id_setor").innerText = `Setor ${id}`; // <- Corrigido aqui!

        // Resetar todos os botões
        document.querySelectorAll(".marcar-setor").forEach(botao => {
            botao.innerText = "Marcar";
            botao.classList.remove("btn-success");
            botao.classList.add("btn-primary");
        });

        // Destacar o botão clicado
        let botaoSelecionado = document.querySelector(`button[onclick='marcarsetor(${id})']`);
        if (botaoSelecionado) {
            botaoSelecionado.innerText = "Marcado";
            botaoSelecionado.classList.remove("btn-primary");
            botaoSelecionado.classList.add("btn-success");
        }
    }



function marcarmaterias(botao, id) {
    const linha = document.getElementById(`linha-${id}`);
    const spanMaterial = document.getElementById("id_material");

    if (!linha || !botao || !spanMaterial) {
        console.warn("Elemento necessário não encontrado:", { linha, botao, spanMaterial, id });
        return;
    }

    const jaMarcado = linha.classList.contains("marcado");

    if (jaMarcado) {
        linha.classList.remove("marcado");
        botao.innerText = "Marcar";
        botao.classList.remove("btn-laranja");
        botao.classList.add("btn-primary");
        materiaisSelecionados.delete(id);
    } else {
        linha.classList.add("marcado");
        botao.innerText = "Marcado";
        botao.classList.remove("btn-primary");
        botao.classList.add("btn-laranja");
        materiaisSelecionados.add(id);
    }

    spanMaterial.innerText =
        materiaisSelecionados.size > 0
            ? "ID " + Array.from(materiaisSelecionados).join(", ")
            : "Nenhum";
}

function buscarRegistro2() {
    let placa = document.getElementById("buscaPatrimonio2").value.trim();
    
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./material_viewveiculo2.php", true); // Altere o caminho se necessário
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById("tabelaResultados2").innerHTML = xhr.responseText;
            reaplicarSelecoes(); // Se necessário para checkboxes ou ações
        }
    };

    xhr.send("viaturafiltro=" + encodeURIComponent(placa));
}
   


document.addEventListener("DOMContentLoaded", () => {
    document.addEventListener("change", (event) => {
        if (event.target.classList.contains("selecionarPM")) {
            let id = event.target.value;
            if (event.target.checked) {
                selecionados.add(id);
            } else {
                selecionados.delete(id);
            }
            atualizarListaPMs();
        }
    });
});

function buscarRegistro() {
    let re = document.getElementById("buscaPatrimonio").value.trim();
    
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./material_viewveiculo.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById("tabelaResultados").innerHTML = xhr.responseText;
            reaplicarSelecoes(); // Reaplica checkboxes e botões após atualização
        }
    };

    xhr.send("re=" + encodeURIComponent(re));
}

function carregarPagina(pagina) {
    let xhr = new XMLHttpRequest();
    xhr.open("GET", `./material_viewveiculo.php?pagina=${pagina}`, true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById("tabelaResultados").innerHTML = xhr.responseText;
            reaplicarSelecoes(); // Mantém seleções ao mudar de página
        }
    };

    xhr.send();
}

function marcarResponsavel(id) {
    // Desmarcar o antigo responsável e reabilitar seu checkbox
    if (responsavel !== null && responsavel !== id) {
        let antigoCheckbox = document.getElementById(`check-${responsavel}`);
        if (antigoCheckbox) {
            antigoCheckbox.disabled = false;
            antigoCheckbox.checked = false;
            selecionados.delete(responsavel); // <- Remove da lista se estava marcado
        }
    }

    // Atualiza o novo responsável
    responsavel = id;
    document.getElementById("responsavelSelecionado").innerText = `ID ${id}`;

    // Desabilita o checkbox do novo responsável
    let checkbox = document.getElementById(`check-${id}`);
    if (checkbox) {
        checkbox.checked = false; // Garante que ele não fique marcado
        checkbox.disabled = true;
        selecionados.delete(id); // Remove da lista de passageiros se estiver
    }

    // Atualiza a visualização dos botões
    document.querySelectorAll(".marcar-responsavel").forEach(botao => {
        botao.innerText = "Marcar";
        botao.classList.remove("btn-success");
        botao.classList.add("btn-info");
    });

    let botaoSelecionado = document.querySelector(`button[onclick='marcarResponsavel(${id})']`);
    if (botaoSelecionado) {
        botaoSelecionado.innerText = "Marcado";
        botaoSelecionado.classList.remove("btn-info");
        botaoSelecionado.classList.add("btn-success");
    }

    atualizarListaPMs(); // ✅ Atualiza a lista visual no final
}

function atualizarListaPMs() {
    document.getElementById("pmsselecionado").innerText = selecionados.size > 0 
        ? `Selecionados: ${Array.from(selecionados).join(", ")}`
        : "Nenhum";
}

function reaplicarSelecoes() {
    selecionados.forEach(id => {
        let checkbox = document.getElementById(`check-${id}`);
        if (checkbox) checkbox.checked = true;
    });

    if (responsavel) {
        let botaoSelecionado = document.querySelector(`button[onclick='marcarResponsavel(${responsavel})']`);
        let checkbox = document.getElementById(`check-${responsavel}`);
        if (botaoSelecionado) {
            botaoSelecionado.innerText = "Marcado";
            botaoSelecionado.classList.remove("btn-info");
            botaoSelecionado.classList.add("btn-success");
        }
        if (checkbox) {
            checkbox.checked = false;
            checkbox.disabled = true;
        }
    }
}



function marcarviaturas(id) {
    const linha = document.getElementById(`linha-${id}`);
    const botao = document.querySelector(`button[onclick='marcarviaturas(${id})']`);
    const spanViatura = document.getElementById("viatura");

    const jaMarcada = linha.classList.contains("marcado");

    // Limpa todas marcações
    document.querySelectorAll("#tabelaResultados2 tr").forEach(row => row.classList.remove("marcado"));
    document.querySelectorAll(".marcar-viatura").forEach(btn => {
        btn.innerText = "Marcar";
        btn.classList.remove("btn-laranja");
        btn.classList.add("btn-warning");
    });

    if (!jaMarcada) {
        linha.classList.add("marcado");
        botao.innerText = "Marcado";
        botao.classList.remove("btn-warning");
        botao.classList.add("btn-laranja");
        spanViatura.innerText = `ID ${id}`;
    } else {
        linha.classList.remove("marcado");
        botao.innerText = "Marcar";
        botao.classList.remove("btn-laranja");
        botao.classList.add("btn-warning");
        spanViatura.innerText = "Nenhum";
    }
}
function marcarfuncao(id) {
    const linha = document.getElementById(`linha-${id}`);
    const botao = document.querySelector(`button[onclick='marcarfuncao(${id})']`);
    const spanFuncao = document.getElementById("id_funcao");

    const jaMarcada = linha.classList.contains("marcado");

    // Limpa todas marcações
    document.querySelectorAll("#tabelaResultados tr").forEach(row => row.classList.remove("marcado"));
    document.querySelectorAll(".marcar-funcao").forEach(btn => {
        btn.innerText = "Marcar";
        btn.classList.remove("btn-success", "btn-primary");
        btn.classList.add("btn-primary");
    });

    if (!jaMarcada) {
        linha.classList.add("marcado");
        botao.innerText = "Marcado";
        botao.classList.remove("btn-primary");
        botao.classList.add("btn-success");
        spanFuncao.innerText = id;
    } else {
        linha.classList.remove("marcado");
        botao.innerText = "Marcar";
        botao.classList.remove("btn-success");
        botao.classList.add("btn-primary");
        spanFuncao.innerText = "Nenhum";
    }
}




function salvarSelecionados() {
    const viatura = document.getElementById('viatura').textContent;
    const responsavel = document.getElementById('responsavelSelecionado').textContent;
    const pmsSelecionados = document.getElementById('pmsselecionado').textContent;
    const funcao = document.getElementById('id_funcao').textContent;
    console.log('Viatura selecionada:', viatura);
    console.log('Responsável selecionado:', responsavel);
    console.log('PMs selecionados no checkbox:', pmsSelecionados);
    console.log('funcao', funcao);

    const container1 = document.getElementById('tabela-container');
    container1.style.display = "none";

     const container2 = document.getElementById('tabela-container2');
    container2.style.display = "none";

    const container3 = document.getElementById('tabela-container3');
    container3.style.display = "none";

    const container4 = document.getElementById('tabela-container4');
    container4.style.display = "block";

    const container5 = document.getElementById('tabela-container5');
    container5.style.display = "block";

}

 function salvarSelecionados4(){

    const viaturaText = document.getElementById('viatura').textContent.trim();
const responsavelText = document.getElementById('responsavelSelecionado').textContent.trim();
const pmsSelecionadosText = document.getElementById('pmsselecionado').textContent.trim();
const funcaoText = document.getElementById('id_funcao').textContent.trim();
const materialText = document.getElementById('id_material').textContent.trim();
const setorText = document.getElementById('id_setor').textContent.trim();

// Extrair apenas número da viatura (ex: "ID 10" => 10)
const viaturaMatch = viaturaText.match(/\d+/);
const viatura = viaturaMatch ? parseInt(viaturaMatch[0]) : null;

// Responsável
const responsavel = parseInt(responsavelText.replace(/\D/g, '')) || null;

// Passageiros
let pmsSelecionados = [];
const passageirosMatch = pmsSelecionadosText.match(/\d+/g);
if (passageirosMatch) {
    pmsSelecionados = passageirosMatch.map(Number);
    if (responsavel !== null) {
        pmsSelecionados = pmsSelecionados.filter(pm => pm !== responsavel);
    }
}

// Função
const funcao = parseInt(funcaoText.replace(/\D/g, '')) || null;

// Material — agora tratado como array
let material = [];
const materialMatch = materialText.match(/\d+/g);
if (materialMatch) {
    material = materialMatch.map(Number);
}

// Setor
const setor = parseInt(setorText.replace(/\D/g, '')) || null;

// Objeto final
const dadosParaEnviar = {
    viatura,
    responsavel,
    passageiros: pmsSelecionados,
    funcao,
    material,
    setor
};

console.log(dadosParaEnviar);



}

    </script>

</body>
</html>
