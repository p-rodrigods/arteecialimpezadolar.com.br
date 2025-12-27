import { showErrorModal, showSuccessModal } from './utils.js';


document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('form-recrutamento');

        if (form) {
                form.addEventListener('submit', function (e) {
                        e.preventDefault();

                        const dados = {
                                nome: document.getElementById('nome').value.trim(),
                                email: document.getElementById('email').value.trim(),
                                contato: document.getElementById('contato').value.trim(),
                                arquivo: document.getElementById('curriculo')
                        };

                        if (!dados.nome || dados.nome.length < 8) {
                                showErrorModal('Por favor, insira seu Nome e Sobrenome');
                                return;
                        }
                        if (!/^[A-Za-zÀ-ÿ\s'-]{2,}$/.test(dados.nome)) {
                                showErrorModal('Por favor, insira seu Nome e Sobrenome');
                                return;
                        }
                        if (!dados.email) {
                                showErrorModal('Por favor, insira seu email.');
                                return;
                        }
                        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        if (!emailRegex.test(dados.email)) {
                                showErrorModal('Por favor, insira um email válido.');
                                return;
                        }
                        if (!dados.contato) {
                                showErrorModal('Por favor, insira seu telefone.');
                                return;
                        }

                       if (!/^\(?\d{2}\)?\s?\d{4,5}-?\d{4}$/.test(dados.contato)) {
                                showErrorModal('Telefone inválido. Use o formato (99) 99999-9999.');
                                return;
                        }


                        const curriculo = dados.arquivo.files[0];

                        if (!curriculo) {
                                showErrorModal('Envie seu currículo (PDF, DOC, ou DOCX).');
                                return;
                        }

                        // Extensões Permitidas
                        const extensoesPermitidas = [".doc", ".docx", ".pdf"];

                        // Pega o nome em minúsculo e veridica a extensão
                        const nome_aquivo = curriculo.name.toLowerCase();
                        const valido = extensoesPermitidas.some(ext => nome_aquivo.endsWith(ext));

                        if (!valido) {
                                showErrorModal('Formato de arquivo inválido. Use PDF, DOC ou DOCX.');
                                return;
                        }

                        if (curriculo.size > 5 * 1024 * 1024) {
                                showErrorModal('Arquivo muito grande. Máximo 5MB.');
                                return;
                        }

                       const formData = new FormData();

                       formData.append('nome', dados.nome);
                       formData.append('email', dados.email);
                       formData.append('contato', dados.contato);
                       formData.append('arquivo', curriculo);

                        fetch('/recrutamento-insert', {
                                method: 'POST',
                                body: formData
                        })
                        .then(response => response.text())
                        .then(data => {
                                if (data == 'sucesso') {
                                        showSuccessModal("Enviando seus dados, isso pode levar alguns segundos...");
                                        setTimeout(() => {
                                                window.open("/recrutamento-sucesso", "_self");
                                        }, 3000);
                                } else {
                                        showErrorModal('Ocorreu um erro ao processar a solicitação');
                                }
                        })
                        .catch(error => {
                                console.error('Error: ', error);
                                showErrorModal('Ocorreu um erro ao processar a solicitação');
                        });

                });
        }
});


