<?php
// Campo que fez requisição
$campo = $_GET['campo'];
// Valor do campo que fez requisição
$valor = $_GET['valor'];
// Verificando o campo login
if ($campo == "nome" || $campo == "nome_pai" || $campo == "nome_mae" || $campo == "nome_de_guerra") {
    if ($valor == "" || $valor === null) {
        echo "(Preencha o campo com o nome)";
    } elseif (strlen($valor) < 3) {
        echo "(O nome deve ter no mínimo 3 caracteres)";
    } elseif (!preg_match("/^[\p{L}\p{M} ]+$/u", $valor)) { // Verifica se há apenas letras (incluindo acentos) e espaços
        echo "(O nome deve conter apenas letras, espaços e caracteres válidos)";
    } elseif (strlen($valor) > 60) { // Verifica se o nome é muito longo
        echo "(O nome deve ter no máximo 60 caracteres)";
    }
}


// Verificando o campo CPF
if ($campo == "cpf") {
    if (!preg_match("/^\d{3}\.\d{3}\.\d{3}-\d{2}$/", $valor)) {
        echo "(Digite um CPF válido)";
    }
}
// Verificando o campo RG
if ($campo == "rg") {
    // Formato: 1.234.567 ou 12.345.678-9 (permite números com ou sem pontos e hífen opcional)
    if (!preg_match("/^\d{1,2}\.?\d{3}\.?\d{3}-?\d{0,1}$/", $valor)) {
        echo "(Digite um RG válido)";
    }
}
// Verificando o campo data de nascimento
if ($campo == "data_nascimento" || $campo == "validade" || $campo == "data_nascimento_conjuge" || $campo == "data_admissao" || $campo == "data_apresentacao") {
    // Verifica se o formato está correto (yyyy-mm-dd)
    if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $valor)) {
        echo "Digite uma data válida no formato dia-mês-ano";
    } else {
        // Separa ano, mês e dia
        list($ano, $mes, $dia) = explode('-', $valor);

        // Verifica se a data é válida
        if (!checkdate($mes, $dia, $ano)) {
            echo "Data inválida.";
        }
    }
}

// // Verificando o campo CNH no PHP
// if ($campo == "cnh") {
//     // Verifica se a CNH tem exatamente 11 dígitos e se é válida (com uma função similar à do JS)
//     if (!preg_match("/^\d{11}$/", $valor)) {
//         echo "Digite um número de CNH válido com 11 dígitos.";
//     } else if (!validarCNH($valor)) {
//         echo "CNH inválida.";
//     }
// }

// Função de validação da CNH em PHP (similar ao algoritmo JS)
// function validarCNH($cnh)
// {
//     // Verifica se todos os dígitos são iguais (CNH inválida)
//     if (preg_match("/^(\d)\1{10}$/", $cnh)) {
//         return false;
//     }

//     // Passo 1: Cálculo do primeiro dígito verificador
//     $sum = 0;
//     for ($i = 0; $i < 9; $i++) {
//         $sum += $cnh[$i] * (10 - $i);
//     }
//     $digit1 = $sum % 11;
//     if ($digit1 >= 10) $digit1 = 0;

//     // Passo 2: Cálculo do segundo dígito verificador
//     $sum = 0;
//     for ($i = 0; $i < 9; $i++) {
//         $sum += $cnh[$i] * (11 - $i);
//     }
//     $sum += $digit1 * 2;
//     $digit2 = $sum % 11;
//     if ($digit2 >= 10) $digit2 = 0;

//     // Valida os dígitos verificadores
//     return ($digit1 == $cnh[9] && $digit2 == $cnh[10]);
// }


// Verificando os campos select
if (
    $campo == "estadocivil" || $campo == "categoriacnh" || $campo == "sexo_policial" || $campo == "logradouro" || $campo == "uf" || $campo == "cidade"
    || $campo == "tiposanguineo" || $campo == "categoria_cnh" || $campo == "posto" || $campo == "cidadenatal" || $campo == "ufnatal"
) {
    // Verifica se foi selecionada alguma opção válida (diferente da opção padrão)
    if (empty($valor)) {
        echo "Por favor, selecione uma opção válida.";
    }
}

// Verificando o campo Endereço
if ($campo == "endereco") {
    // Endereço pode ter letras, números e espaços (mínimo de 5 caracteres)
    if (!preg_match("/^[a-zA-Z0-9\s]{5,}$/", $valor)) {
        echo "(Digite um endereço válido - mínimo de 5 caracteres)";
    }
}

// Verificando o campo Número da Casa
if ($campo == "numero") {
    // Número da casa pode ser de 1 até 5 dígitos numéricos
    if (!preg_match("/^\d{1,5}$/", $valor)) {
        echo "(Digite um número de casa válido - até 5 dígitos)";
    }
}

// Verificando o campo Bairro
if ($campo == "bairro") {
    // Bairro pode conter letras, espaços e até acentos (mínimo de 3 caracteres)
    if (!preg_match("/^[a-zA-ZÀ-ú\s]{3,}$/", $valor)) {
        echo "(Digite um bairro válido - mínimo de 3 letras)";
    }
}

// Verificando o campo CEP
if ($campo == "cep") {
    // CEP no formato 12345-678 ou 12345678 (com ou sem hífen)
    if (!preg_match("/^\d{5}-?\d{3}$/", $valor)) {
        echo "(Digite um CEP válido - formato 12345-678 ou 12345678)";
    }
}

// Verificando o campo Celular
if ($campo == "telefone1") {
    // Celular no formato (XX) XXXXX-XXXX ou (XX) XXXX-XXXX
    if (!preg_match("/^\(\d{2}\)\s?\d{4,5}-\d{4}$/", $valor)) {
        echo "(Digite um celular válido - formato (XX) XXXXX-XXXX ou (XX) XXXX-XXXX)";
    }
}

// Verificando o campo RE
if ($campo == "re") {
    // Formato: 6 dígitos seguidos de um hífen e 1 dígito
    if (!preg_match("/^\d{6}-\d{1}$/", $valor)) {
        echo "(Digite um RE válido no formato xxxxxx-x)";
    }
}


// Acentuação
// header("Content-Type: text/html; charset=ISO-8859-1", true);