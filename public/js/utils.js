
// Função para exibir modal de erro

export function showErrorModal(message) {
    const errorModal = document.getElementById('errorModal');
    const errorModalMessage = document.getElementById('errorModalMessage');

    if (!errorModal || !errorModalMessage) {
        console.error('Error modal elements not found in the DOM.');
        return;
    }

    errorModalMessage.innerHTML = message.replace(/\n/g, '<br>');
    errorModal.style.display = 'block';

    // Ocultar o modal automaticamente após 5 segundos
    setTimeout(() => {
        errorModal.style.display = 'none';
    }, 5000);
}

// Função para exibir modal de sucesso

export function showSuccessModal(message) {
    const successModal = document.getElementById('showSuccessModal');
    const successModalMessage = document.getElementById('successModalMessage');

    if (!successModal || !successModalMessage) {
        console.error('Success modal elements not found in the DOM.');
        return;
    }

    successModalMessage.innerHTML = message.replace(/\n/g, '<br>');
    successModal.style.display = 'block';

    // Ocultar o modal automaticamente após 5 segundos
    setTimeout(() => {
        successModal.style.display = 'none';
    }, 5000);
}

// Função para resetar os campos do formulário

export function resetCampos() {

        document.getElementById('qtdRoupasPassar').value = "";
        document.getElementById('qtdHorasCuidador').value = '';
        document.getElementById('qtdSala').value = 0;
        document.getElementById('qtdQuarto').value = 0;
        document.getElementById('qtdCozinha').value = 0;
        document.getElementById('qtdBanheiro').value = 0;
        document.getElementById('qtdVaranda').value = 0;
        document.getElementById('qtdAreaServico').value = 0;
        document.getElementById('qtdGaragem').value = 0;
}

