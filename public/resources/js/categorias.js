import { showErrorModal, showSuccessModal, resetCampos } from './utils.js';

document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('form-categoria');

    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const dados = {
                nome: document.getElementById('nome').value.trim(),
                slug: document.getElementById('slug').value.trim(),
                status: document.querySelector('input[name="status"]:checked').value,
                descricao: document.getElementById('descricao').value.trim()
            }

            if (!dados.nome || !dados.slug || !dados.status || !dados.descricao) {
                showErrorModal('Por favor, preencha todos os campos obrigatórios.');
                return;
            }

            const formBody = new URLSearchParams(dados).toString();
            fetch('/categorias/salvar', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: formBody
            }).then(response => response.text())
                .then(data => {
                    if (data === 'sucesso') {
                        showSuccessModal('Categoria salva com sucesso!');
                    } else {
                        showErrorModal('Erro ao salvar a categoria. Tente novamente.');
                    }
                })
                .catch(error => {
                    console.error('Error: ', error);
                    showErrorModal('Erro ao salvar a categoria. Tente novamente.');
                }
                );
        });
    }
});