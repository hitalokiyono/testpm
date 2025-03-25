<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Materiais Bélicos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/estilo.css">
    <link rel="stylesheet" href="../css/inicial.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>


/* Resetando o body para o padrão */
body,html {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background-color:rgb(35, 34, 34); /* Cor padrão do Bootstrap */
    color:rgb(0, 0, 0); /* Cor padrão do texto */
}

/* Estilização do título */
.titulo {
    text-align: center;
    margin-top: 20px;
    font-size: 24px;
    font-weight: bold;
    color:rgb(0, 0, 0); /* Azul Bootstrap */
}

/* Centralizando o seletor de tabelas */
#selecaoTabela {
    display: block;
    width: 50%;
    margin: 20px auto;
    
    font-size: 16px;
    border: 1px solid #ced4da;
    border-radius: 5px;
}

/* Container principal */
#container {
    margin-bottom: 39px;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 20px;
}

/* Estilização do formulário */
#formulario {
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    width: 50%;
}

/* Títulos dentro do formulário */
#formulario h3 {
    text-align: center;
    color: #343a40;
    margin-bottom: 20px;
}

/* Inputs e selects estilizados */
#formulario input,
#formulario select {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ced4da;
    border-radius: 5px;
}

/* Botão de envio */
#formulario button {
    width: 100%;
    padding: 10px;
    background-color: #28a745; /* Verde Bootstrap */
    color: white;
    font-size: 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
}

#formulario button:hover {
    background-color: #218838;
}

/* Estilização do container da foto */
#foto-container {
    text-align: center;
    margin-top: 20px;
}

/* Espaço fixo para a pré-visualização da imagem */
#preview {
    width: 150px;
    height: 150px;
    border: 2px dashed #007bff;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    background-color: #f8f9fa;
    margin: 0 auto 10px auto;
}

/* Imagem ajustada dentro do preview */
#preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: none;
}

/* Ícone abaixo do label */
#foto-label {
    display: block;
    text-align: center;
    cursor: pointer;
    font-size: 16px;
    color: #007bff;
}

#foto-label i {
    font-size: 30px;
    margin-top: 5px;
}

    </style>


<body>

    <?php require_once("./menu.php"); ?>
  

    <h1 class="titulo">Cadastro de Materiais Bélicos</h1>

    
    <select id="selecaoTabela" onchange="carregarFormulario()">
        <option value="">-- Escolha uma tabela --</option>
        <option value="1">Armas</option>
        <option value="2">Coletes</option>
        <option value="3">TPD</option>
        <option value="4">Munições</option>
        <option value="5">Taser</option>
        <option value="6">Algemas</option>
        <option value="7">HT</option>
    </select>

    <div id="container">
        <div id="formulario">
            <h3>Formulário de Cadastro</h3>
            <div id="conteudoFormulario">Selecione uma tabela...</div>
        </div>
    </div>

    <script>
        function carregarFormulario() {
            var tipoTabela = document.getElementById("selecaoTabela").value;

            if (tipoTabela) {
                fetch("./material_belicoview.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: new URLSearchParams({ tipo_tabela: tipoTabela })
                })
                .then(response => response.text())
                .then(data => {
                    document.getElementById("conteudoFormulario").innerHTML = data;
                })
                .catch(error => console.error("Erro ao carregar o formulário:", error));
            } else {
                document.getElementById("conteudoFormulario").innerHTML = "Selecione uma tabela...";
            }
        }
       
function previewImagem(event) {
    var reader = new FileReader();
    reader.onload = function() {
        var output = document.getElementById('preview');
        output.src = reader.result;
        output.style.display = 'block';
    };
    reader.readAsDataURL(event.target.files[0]);
}


    </script>

</body>
</html>
