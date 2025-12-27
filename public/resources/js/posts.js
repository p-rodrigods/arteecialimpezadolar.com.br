import { showErrorModal, showSuccessModal} from './utils.js';  

document.addEventListener('DOMContentLoaded', function(){

    const form = document.getElementById('form-criar-post');

    if(form){
        form.addEventListener('submit', function(e){
            e.preventDefault();

            const MAX_FILE_SIZE = 2 * 1024 * 1024; // 2MB
            const ALLOWED_FILE_TYPES = ['image/jpeg', 'image/png', 'image/gif'];

            const dados = {
                categorias: document.getElementById('categoria').value.trim(),
                titulo: document.getElementById('titulo').value.trim(),
                slug: document.getElementById('slug').value.trim(),
                status: document.getElementById('status').value,
                imagem_capa: document.getElementById('capa'),
                resumo: document.getElementById('resumo').value.trim(),
                conteudo: document.getElementById('conteudo').value.trim(),
            }

            if(!dados.categorias || dados.categorias === '0'){
                showErrorModal('Selecione uma categoria para o post.');
                return;
            }   

            if(!dados.titulo || dados.titulo.length < 5 || dados.titulo === ''){
                showErrorModal('Iinsira um título válido com pelo menos 5 caracteres.');
                return;
            }          
            
            const imagemCapa = dados.imagem_capa.files[0];

            if(!imagemCapa){
                 showErrorModal('Envie uma imagem de capa para o post.');
                return;
            }

            if(imagemCapa.size > MAX_FILE_SIZE){
                showErrorModal('A imagem de capa excede o tamanho máximo de 2MB.');
                return;
            }

            if(!ALLOWED_FILE_TYPES.includes(imagemCapa.type)){
                showErrorModal('Tipo de arquivo inválido para a imagem de capa. \n Use JPG, PNG ou GIF.');
                return;
            }
                
                   
            if(!dados.resumo || dados.resumo.length < 20 || dados.resumo === ''){
                showErrorModal('Insira um resumo válido com pelo menos 20 caracteres.');
                return;
            }  

            if(!dados.conteudo || dados.conteudo.length < 50 || dados.conteudo === ''){
            showErrorModal('Insira um conteúdo válido com pelo menos 50 caracteres.');
            return;
            }

            const formData = new FormData();

            formData.append('categorias', dados.categorias);
            formData.append('titulo', dados.titulo);
            formData.append('slug', dados.slug);
            formData.append('status', dados.status);
            formData.append('imagem_capa', imagemCapa);
            formData.append('resumo', dados.resumo);
            formData.append('conteudo', dados.conteudo);
            
            fetch('/posts/criar', {
                method: 'POST',
                body: formData
            }).then(response => response.text())
            .then(data => {
                if(data === 'sucesso'){
                    showSuccessModal('Post criado com sucesso!');
                    form.reset();
                } else {
                    showErrorModal('Erro ao criar o post. Tente novamente.');
                }
            }).catch(error => {
                console.error('Error: ', error);
                showErrorModal('Ocorreu um erro ao processar a solicitação');
            });
            
        });
    }
});