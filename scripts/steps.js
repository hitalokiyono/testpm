var currentStep = 0;
const steps = document.querySelectorAll(".step");
// Função para salvar os dados de cada step no localStorage
function saveStepData(step) {
    const inputFields = steps[step].querySelectorAll('input, select, datalist');
    let stepData = {};

    inputFields.forEach(field => {
        stepData[field.id] = field.value;
    });
    localStorage.setItem('step' + step, JSON.stringify(stepData));
}

// Função para carregar os dados de um step a partir do localStorage
function loadStepData(step) {
    const storedData = localStorage.getItem('step' + step);

    if (storedData) {
        const stepData = JSON.parse(storedData);
        Object.keys(stepData).forEach(id => {
            const field = document.getElementById(id);
            if (field) {
                field.value = stepData[id];
            }
        });
    }
}

function showStep(step) {
    // Verifica se há algum erro de validação (mensagens dentro das spans com classe 'validacao')
    let valid = true;

    document.querySelectorAll('.validacao' + currentStep).forEach(span => {
        if (span.innerHTML.trim() !== '') {
            valid = false;  // Se houver mensagem de erro, não deixa avançar
        }
    });

    if (!valid) {
        alert('Corrija os erros antes de avançar.');
        return;  // Impede o avanço se houver erros
    }

    // Verifica se todos os campos estão preenchidos
    // Caso o Step for -1 (reset) não valida os campos obrigatórios, do contrário Step for 1 (próximo) valida os campos
    if (step != -1) {
        let check = true;
        let inputFields = steps[currentStep].querySelectorAll('input[required], select[required], datalist[required]');

        for (var i = 0; i < inputFields.length; i++) {
            let campo = inputFields[i].id.replace("campo_", "");
            validarDados(campo, document.getElementById(campo).value);

            // Verifica se o valor do campo está vazio ou contém apenas espaços em branco
            if (inputFields[i].value.trim() === '') {
                check = false;
                break; // Para o loop assim que encontrar um campo vazio
            }
        }
        if (!check) {
            alert('Preencha todos os campos obrigatórios antes de continuar.');
            return;
        }
    }
    // Avança para o próximo step
    steps[currentStep].classList.remove("active");

    currentStep += step;

    if (currentStep < 0) {
        currentStep = 0;
    }
    if (currentStep >= steps.length) {
        currentStep = steps.length - 1;
    }

    // Carrega os dados salvos no localStorage para o step atual
    steps[currentStep].classList.add("active");
}
// Eventos para os botões "VOLTAR" e "PRÓXIMO"


document.querySelectorAll('.voltar-btn').forEach(button => {
    button.addEventListener('click', () => showStep(-1));
});

document.querySelectorAll('input[type="button"]').forEach(button => {
    button.addEventListener('click', () => showStep(1));
});