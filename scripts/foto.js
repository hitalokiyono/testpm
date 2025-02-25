const fotoInput = document.getElementById('foto');
const thumb = document.getElementById('thumb');

// Não há mais necessidade de verificar o localStorage

fotoInput.addEventListener('change', (event) => {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            thumb.src = e.target.result; // Atualiza a imagem para a visualização
        };
        reader.readAsDataURL(file);
    }
});