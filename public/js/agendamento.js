import { showErrorModal, showSuccessModal, resetCampos } from './utils.js';

document.addEventListener('DOMContentLoaded', function () {
        const servico = document.getElementById('servico');

        if (servico) {
                servico.addEventListener('change', function () {
                        let servicoSelecionado = this.value;
                        let roupasPassarContainer = document.getElementById('roupasPassarContainer');
                        let cuidadorIdososContainer = document.getElementById('cuidadorIdososContainer');
                        let comodosContainer = document.getElementById('comodosContainer');

                        comodosContainer.style.display = 'none';
                        roupasPassarContainer.style.display = 'none';
                        cuidadorIdososContainer.style.display = 'none';

                        // Exibe o campo apropriado com base na seleção
                        if (servicoSelecionado === 'Passadeira') {
                                roupasPassarContainer.style.display = 'block';
                                resetCampos();

                        } else if (servicoSelecionado === 'Cuidador de Idosos') {
                                cuidadorIdososContainer.style.display = 'block';
                                resetCampos();

                        } else if (servicoSelecionado === "") {
                                comodosContainer.style.display = 'none';
                                roupasPassarContainer.style.display = 'none';
                                cuidadorIdososContainer.style.display = 'none';
                                resetCampos();
                        }
                        else {
                                comodosContainer.style.display = 'block';
                                resetCampos();
                        }
                });
        }

        const form_agendamento = document.getElementById('form-agendamento');

        if (form_agendamento) {
                form_agendamento.addEventListener('submit', function (e) {
                        e.preventDefault();

                        const dados = {
                                nome: document.getElementById('nome').value.trim(),
                                contato: document.getElementById('contato').value.trim(),
                                tipoResidencia: document.getElementById('tipoResidencia').value.trim(),
                                servico: document.getElementById('servico').value.trim(),
                                qtdRoupasPassar: document.getElementById('qtdRoupasPassar').value.trim(),
                                qtdHorasCuidador: document.getElementById('qtdHorasCuidador').value.trim(),
                                qtdSalas: document.getElementById('qtdSala').value.trim(),
                                qtdQuartos: document.getElementById('qtdQuarto').value.trim(),
                                qtdCozinhas: document.getElementById('qtdCozinha').value.trim(),
                                qtdBanheiros: document.getElementById('qtdBanheiro').value.trim(),
                                qtdVarandas: document.getElementById('qtdVaranda').value.trim(),
                                qtdAreaServico: document.getElementById('qtdAreaServico').value.trim(),
                                qtdGaragem: document.getElementById('qtdGaragem').value.trim(),
                                frequencia: document.getElementById('frequencia').value.trim(),
                                maisInformacoes: document.getElementById('maisInformacoes').value.trim()
                        };

                        if (!dados.nome || dados.nome.length < 8) {
                                showErrorModal('Por favor, insira seu Nome e Sobrenome');
                                return;
                        }

                        if (!/^[A-Za-zÀ-ÿ\s'-]{2,}$/.test(dados.nome)) {
                                showErrorModal('Por favor, insira seu Nome e Sobrenome');
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

                        if (!dados.tipoResidencia) {
                                showErrorModal('Por favor, selecione o tipo de residência.');
                                return;
                        }

                        if (!dados.servico) {
                                showErrorModal('Por favor, selecione o serviço desejado.');
                                return;
                        }

                        if (dados.servico === "Passadeira") {
                                if (dados.qtdRoupasPassar === "") {
                                        showErrorModal('Por favor, insira a quantidade de roupas para passar.');
                                        return;
                                }
                        }

                        if (dados.servico === "Cuidador de Idosos") {
                                if (dados.qtdHorasCuidador === "") {
                                        showErrorModal('Por favor, insira a quantidade de horas para o cuidador de idosos.');
                                        return;
                                }
                        }

                        if (!dados.frequencia) {
                                showErrorModal('Por favor, selecione a frequência do serviço.');
                                return;
                        }

                        let mensagem = '';

                        if (dados.servico === "Passadeira") {
                                mensagem = `Olá! Gostaria de agendar o serviço de *Passadeira* com os seguintes dados: \n\n*Nome:* ${dados.nome} \n*Contato:* ${dados.contato} \n\n*Tipo de Residência:* ${dados.tipoResidencia} \n*Quantidade de Roupas para Passar:* ${dados.qtdRoupasPassar} \n\n*Frequência:* ${dados.frequencia} \n*Mais Informações:* ${dados.maisInformacoes}`;

                        } else if (dados.servico === "Cuidador de Idosos") {
                                mensagem = `Olá! Gostaria de agendar o serviço de *Cuidador de Idosos* com os seguintes dados:\n\n*Nome:* ${dados.nome} \n*Contato:* ${dados.contato} \n\n*Tipo de Residência:* ${dados.tipoResidencia} \n*Quantidade de Horas do Cuidador:* ${dados.qtdHorasCuidador}\n*Frequência:* ${dados.frequencia}\n*Mais Informações:* ${dados.maisInformacoes}`;
                        } else {
                                mensagem = `Olá! Gostaria de saber mais sobre o serviço de faxina com os seguintes dados: \n\n*Nome:* ${dados.nome} \n*Contato:* ${dados.contato} \n\n*Tipo de imóvel:* ${dados.tipoResidencia} \n*Quantidade de cômodos:* ${dados.qtdSalas} Sala(s), ${dados.qtdQuartos} Quarto(s), ${dados.qtdCozinhas} Cozinha(s), ${dados.qtdBanheiros} Banheiro(s), ${dados.qtdVarandas} Varanda(s), ${dados.qtdAreaServico} Área(s) de Serviço, ${dados.qtdGaragem} Garagem. \n\n*Frequência:* ${dados.frequencia} \n*Mais Informações:* ${dados.maisInformacoes}`;
                        }

                        const textoWhatsapp = encodeURIComponent(mensagem);


                        const formBody = new URLSearchParams(dados).toString();

                        fetch('/agendamento-insert', {
                                method: 'POST',
                                headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded'
                                },
                                body: formBody
                        })
                        .then(response => response.text())
                        .then(data => {

                                if (data == 'sucesso') {
                                        showSuccessModal('Redirecionando para o WhatsApp...');
                                        setTimeout(() => {
                                                window.open(`https://web.whatsapp.com/send/?phone=5579999311107&text=${textoWhatsapp}`, "_blank");
                                        }, 3000);
                                } else {
                                        showErrorModal('Ocorreu um erro ao processar a solicitação');
                                }
                        })
                        .catch(error => {
                                console.error('Error: ', error);
                                showErrorModal('Ocorreu um erro ao processar a solicitação');
                        })



                });
        }

});



