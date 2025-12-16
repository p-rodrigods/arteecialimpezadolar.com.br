document.addEventListener('DOMContentLoaded', function () {
    const auth = document.getElementById('authentication-form');

    if (auth) {
        auth.addEventListener('submit', function (e) {
            e.preventDefault(); 
        
            const dados = {
                usuario: document.getElementById('usuario').value.trim(),
                senha: document.getElementById('senha').value.trim()
            };  

            if (!dados.usuario || !dados.senha) {
                document.getElementById('error').style.display = 'block';
                return;
            }

            // Validar formato de email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!emailRegex.test(dados.usuario)) {
                document.getElementById('error').style.display = 'block';
                return;
            }

            // Validar comprimento mínimo da senha
            if (dados.senha.length < 8) {
                document.getElementById('error').style.display = 'block';
                return;
            }

            const formBody = new URLSearchParams(dados).toString(); 

            fetch('/admin-authenticate', {
                method: 'POST',
                headers: {     
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: formBody
            }).then(response => response.text())
            .then(data => {
                if (data === 'success') { 
                    window.location.href = '/dashboard';
                } else {
                    document.getElementById('error').style.display = 'block';
                }   
            }).catch(error => {
                console.error('Erro na autenticação:', error);
                document.getElementById('error').style.display = 'block';
            });     
       });   
    }

});
