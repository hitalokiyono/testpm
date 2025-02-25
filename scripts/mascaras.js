function mascaraCPF(input) {
    let cpf = input.value;

    // Remove tudo que não é número
    cpf = cpf.replace(/\D/g, '');

    // Aplica a máscara
    cpf = cpf.replace(/^(\d{3})(\d)/, "$1.$2");
    cpf = cpf.replace(/^(\d{3})\.(\d{3})(\d)/, "$1.$2.$3");
    cpf = cpf.replace(/\.(\d{3})(\d)/, ".$1-$2");

    input.value = cpf; // Define o valor formatado no campo de CPF
}

function mascaraTelefone(input) {
    let telefone = input.value;

    // Remove tudo que não é número
    telefone = telefone.replace(/\D/g, '');

    // Limita a quantidade de números a 11 dígitos (2 para o DDD e 9 para o número)
    if (telefone.length > 11) {
        telefone = telefone.slice(0, 11);
    }

    // Aplica a máscara (xx) xxxxx-xxxx
    if (telefone.length > 6) {
        telefone = telefone.replace(/^(\d{2})(\d{5})(\d{4})/, "($1) $2-$3");
    } else if (telefone.length > 2) {
        telefone = telefone.replace(/^(\d{2})(\d{0,5})/, "($1) $2");
    } else {
        telefone = telefone.replace(/^(\d*)/, "$1");
    }

    input.value = telefone; // Define o valor formatado no campo de telefone
}

function mascaraRG(input) {
    let rg = input.value;

    // Remove tudo que não é número ou letra (caso o dígito verificador seja X)
    rg = rg.replace(/[^0-9Xx]/g, '');

    // Limita a quantidade de caracteres a 9 (podendo ser números ou o dígito verificador X)
    if (rg.length > 9) {
        rg = rg.slice(0, 9);
    }

    // Aplica a máscara: XX.XXX.XXX-X ou X.XXX.XXX-X (dependendo do número de dígitos)
    if (rg.length > 6) {
        rg = rg.replace(/^(\d{1,2})(\d{3})(\d{3})([0-9Xx])$/, "$1.$2.$3-$4");
    } else if (rg.length > 3) {
        rg = rg.replace(/^(\d{1,3})(\d{3})(\d{1,3})$/, "$1.$2.$3");
    } else if (rg.length > 1) {
        rg = rg.replace(/^(\d{1,2})(\d{3})$/, "$1.$2");
    }

    input.value = rg; // Define o valor formatado no campo de RG
}

function mascaraCEP(input) {
    let cep = input.value;

    // Remove tudo que não for número
    cep = cep.replace(/\D/g, '');

    // Limita a quantidade de números a 8 dígitos
    if (cep.length > 8) {
        cep = cep.slice(0, 8);
    }

    // Aplica a máscara
    cep = cep.replace(/^(\d{5})(\d)/, "$1-$2");

    input.value = cep; // Define o valor formatado no campo de CEP
}

function mascaraRE(input) {
    let re = input.value;

    // Remove tudo que não for número
    re = re.replace(/\D/g, '');

    // Limita a quantidade de números a 7 dígitos
    if (re.length > 7) {
        re = re.slice(0, 7);
    }

    // Aplica a máscara no formato `xxxxxx-x`
    re = re.replace(/^(\d{6})(\d)/, "$1-$2");

    input.value = re; // Define o valor formatado no campo de RE
}