async function buscarCEP() {
    const cepInput = document.getElementById("cep");
    const enderecoInput = document.getElementById("endereco");
    const bairroInput = document.getElementById("bairro");
    const cidadeInput = document.getElementById("cidade");
    const ufInput = document.getElementById("uf");

    const cep = cepInput.value.replace(/\D/g, ""); // Remove caracteres não numéricos

    // Verifica se o CEP possui exatamente 8 caracteres
    if (cep.length !== 8) {
        alert("Por favor, digite um CEP válido.");
        return;
    }

    try {
        const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
        if (!response.ok) throw new Error("Erro ao buscar o CEP.");

        const data = await response.json();

        // Verifica se o CEP retornou erro
        if (data.erro) {
            alert("CEP não encontrado!");
            return;
        }

        // Preenche os campos com os dados da API
        enderecoInput.value = data.logradouro || "";
        bairroInput.value = data.bairro || "";
        cidadeInput.value = data.localidade || "";
        ufInput.selectedIndex = [...ufInput.options].findIndex(o=>o.text === data.uf);

    } catch (error) {
        console.error("Erro ao buscar CEP:", error);
        alert("Erro ao buscar o CEP. Tente novamente.");
    }
}
