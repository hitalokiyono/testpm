<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/cadastrarcurso.css">
    <title>Policia Militar :: Novo Agendamento</title>
 
</head>


<style>


 form  {
margin-left: 10%;
    display:flex;
    background-color: #ffffff;
    width: 50%;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    align-items: center;
    justify-content: center;
}

h1.titulo {
    text-align: center;
    font-size: 24px;
    color:rgb(0, 0, 0);
    margin-bottom: 20px;
}

.container-form {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.row {
    display: flex;
    flex-wrap: wrap;
    margin-bottom: 12px;
}

.col {
    flex: 1;
    display: flex;
    flex-direction: column;
}

label {
    font-weight: bold;
    color: #555;
    margin-bottom: 8px;
}

input[type="text"],
input[type="number"],
input[type="submit"] {
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ddd;
    border-radius: 8px;
    outline: none;
    width: 100%;
    transition: all 0.2s ease-in-out;
}

input[type="text"]:focus,
input[type="number"]:focus {
    border-color:rgb(0, 0, 0);
    box-shadow: 0 0 5px rgba(0, 119, 204, 0.4);
}

input[type="submit"] {
    background-color:rgb(55, 167, 59);
    color: white;
    cursor: pointer;
    font-weight: bold;
    border: none;
}

input[type="submit"]:hover {
    background-color:rgb(8, 8, 8);
}

.agendamento-group {
    padding: 15px;
    background: #f3f3f3;
    border-radius: 8px;
    border: 1px solid #ddd;
}

.container-buttom {
    display: flex;
    justify-content: flex-end;
    margin-top: 10px;
}

button {
    padding: 8px 16px;
    font-size: 14px;
    background-color:rgb(55, 167, 59);
    color: #ffffff;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    margin-left: 10px;
}

button:hover {
    background-color:rgb(11, 11, 11);
}
.input-wrapper {
    display: flex;
    align-items: center;
}

.input-wrapper input[type="number"] {
    width: 100px;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ddd;
    border-radius: 8px;
    outline: none;
    margin-right: 8px;
}

.input-wrapper .input-unit {
    font-size: 16px;
    color: #555;
}


</style>

<body>
    <?php require_once("./menu.php"); ?>
    <h1 class="titulo">Novo Agendamento</h1>
    <form action="novo_agendamento_bd.php" method="post" enctype="multipart/form-data">
        <div class="container">
            <div class="step active" id="step-5">
                <div class="container-form" id="agendamentos-container">
                    <div class="agendamento-group">
                        <div class="row">
                            <div class="col">
                                <label for="nome_do_evento">Nome do Evento</label>
                                <input type="text" name="nome_do_evento[]" placeholder="Descreva o nome do evento" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="dt_inicio">Descricao</label>
                                <input type="text" name="descricao"  placeholder="descreva  a mensagem para envio do email"required>
                            </div>
                        </div>
                        <div class="col">
                   
    <label for="dt_termino">Data para checagem padrão, período para envio do e-mail</label>
    <div class="input-wrapper">
        <input type="number" name="dt_check" id="dt_check" required step="1" min="1" oninput="atualizarTextoMeses(this)">
        <span id="meses-label"></span>
    </div>
</div>


    <div class="row">
    <div class="col">
        <label for="unidades">Unidades</label>
        <div class="input-wrapper2">
            <input type="checkbox" name="unidades[]" value="all" id="todos" onclick="marcarTodos(this)"> Todos
            <input type="checkbox" name="unidades[]" value="0" id="unidade1" class="unidade"> soldado
            <input type="checkbox" name="unidades[]" value="2" id="unidade2" class="unidade"> p1
            <input type="checkbox" name="unidades[]" value="3" id="unidade3" class="unidade"> p2
            <input type="checkbox" name="unidades[]" value="4" id="unidade4" class="unidade"> p3
            <input type="checkbox" name="unidades[]" value="5" id="unidade5" class="unidade"> admin
        </div>
    </div>
</div>

<script>
function marcarTodos(source) {
    var checkboxes = document.querySelectorAll('.unidade');
    
    // Marca ou desmarca todos os checkboxes de unidades com base no "Todos"
    checkboxes.forEach(function(checkbox) {
        checkbox.checked = source.checked;
    });
    
    // Desmarcar o checkbox "Todos" se qualquer unidade for desmarcada
    var todosCheckbox = document.getElementById('todos');
    if (source.checked) {
        todosCheckbox.checked = true;
    }
    else {
        todosCheckbox.checked = false;
    }
}

// Verifica se algum checkbox foi desmarcado
var checkboxes = document.querySelectorAll('.unidade');
checkboxes.forEach(function(checkbox) {
    checkbox.addEventListener('change', function() {
        var todosCheckbox = document.getElementById('todos');
        
        // Se algum checkbox não estiver marcado, desmarcar "Todos"
        var algumDesmarcado = Array.from(checkboxes).some(function(cb) {
            return !cb.checked;
        });
        
        todosCheckbox.checked = !algumDesmarcado;
    });
});
    function atualizarTextoMeses(input) {
        const label = document.getElementById('meses-label');
        const valor = parseInt(input.value, 10);

        if (valor === 1) {
            label.textContent = "mês";
        } else {
            label.textContent = "meses";
        }
    }
</script>
                </div>
                <div class="container-buttom">
                    <div class="row">
                        <div class="col">
                            <input type="submit" value="FINALIZAR">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>

</html>
