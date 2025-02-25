// Função para adicionar mais campos de curso com datas de início e término
function addCurso() {
    const cursosContainer = document.getElementById('cursos-container');
    const cursoGroup = document.createElement('div');
    cursoGroup.className = 'curso-group';
    cursoGroup.innerHTML = `
            <div class="row">
                <div class="col">
                    <label for="nome_do_curso">Nome do curso</label>
                    <input type="text" name="nome_do_curso[]" placeholder="Descreva o nome do curso.">
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="dt_inicio">Data de início</label>
                    <input type="date" name="dt_inicio[]" placeholder="Insira a data de início">
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="dt_termino">Data de término</label>
                    <input type="date" name="dt_termino[]" placeholder="Insira a data de término">
                </div>
            </div>
        `;
    cursosContainer.appendChild(cursoGroup);
}