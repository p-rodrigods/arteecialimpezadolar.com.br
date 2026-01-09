import { showErrorModal, showSuccessModal, resetCampos } from './utils.js';

document.addEventListener('DOMContentLoaded', function () {

    // FUNÇÃO PARA VALIDAR OS DADOS RECEBIDOS

    function dadosRecebidosCategoria() {
        const dados = {
            id: document.getElementById('id') ? document.getElementById('id').value : null,
            nome: document.getElementById('nome').value.trim(),
            slug: document.getElementById('slug').value.trim(),
            status: document.querySelector('input[name="status"]:checked') ? document.querySelector('input[name="status"]:checked').value : null,
            descricao: document.getElementById('descricao').value.trim()
        }
        
        if (!dados.nome || !dados.slug || !dados.status || !dados.descricao) {
                showErrorModal('Por favor, preencha todos os campos obrigatórios.');
                return;
        }

        return dados;
    }

    function rotaPageCategoria(page, mensagemErro, mensagemSucesso) {
        
        const dados = dadosRecebidosCategoria();
        
        if (!dados) {
            return;
        }

        const formBody = new URLSearchParams(dados).toString();
        
        fetch(page, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: formBody
        }).then(response => response.text())
            .then(data => {
                if (data === 'sucesso') {
                    showSuccessModal(mensagemSucesso);
                } else {
                    showErrorModal(mensagemErro);
                }
            })
            .catch(error => {
                console.error('Error: ', error);
                showErrorModal(mensagemErro);
            }
        );
    }

    const form = document.getElementById('form-categoria');

    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            rotaPageCategoria('/categorias/criar', 'Erro ao criar a categoria. Tente novamente.', 'Categoria criada com sucesso!');

        });
    }
    
    const formEdit = document.getElementById('form-editar-categoria');

    if (formEdit) {
        formEdit.addEventListener('submit', function (e) {
            e.preventDefault();
            rotaPageCategoria('/categorias/atualizar', 'Erro ao atualizar a categoria. Tente novamente.', 'Categoria atualizada com sucesso!');
        });
    }
    
    const formDelete = document.getElementById('form-deletar-categoria');
    
    if (formDelete) {
        formDelete.addEventListener('submit', function (e) {
            e.preventDefault();
            const categoriaId = document.getElementById('id').value;
            fetch('/categorias/excluir', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: categoriaId })
            }).then(response => response.text())
                .then(data => {
                    if (data === 'sucesso') {
                        showSuccessModal('Categoria excluída com sucesso!');
                        setTimeout(() => {
                            window.location.href = '/categorias';
                        }, 2000);
                    } else {
                        showErrorModal('Erro ao excluir a categoria. Tente novamente.');
                    }
                }).catch(error => {
                    console.error('Error: ', error);
                    showErrorModal('Ocorreu um erro ao processar a solicitação');
                }
            );
        });
    }
});