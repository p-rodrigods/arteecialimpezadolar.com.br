document.addEventListener('DOMContentLoaded', function(){

    const form = document.getElementById('form-criar-post');

    if(form){
        form.addEventListener('submit', function(e){
            e.preventDefault();
            const dados = {
                categorias: document.getElementById('categoria').value.trim(),
                titulo: document.getElementById('titulo').value.trim(),
                slug: document.getElementById('slug').value.trim(),
                status: document.getElementById('status').value,
                imagem_capa: document.getElementById('imagem'),
                resumo: document.getElementById('resumo').value.trim(),
                conteudo: document.getElementById('conteudo').value.trim()
            }

            if(!dados.categorias){
                alert('Por favor, selecione uma categoria para o post.');
                return;
            }   

            if(!dados.titulo || dados.titulo.length < 5){
                alert('Por favor, insira um título válido com pelo menos 5 caracteres.');
                return;
            }          
        
            if(!dados.resumo || dados.resumo.length < 20){
                alert('Por favor, insira um resumo válido com pelo menos 20 caracteres.');
                return;
            }  
            
            if(!dados.conteudo || dados.conteudo.length < 50){
                alert('Por favor, insira um conteúdo válido com pelo menos 50 caracteres.');
                return;
            }
            const imagemCapa = dados.imagem_capa.files[0];

            if(!imagemCapa){
                alert('Por favor, envie uma imagem de capa para o post.');
                return;
            }
            const extensoesPermitidas = [".jpg", ".jpeg", ".png", ".gif"];
            const nomeArquivo = imagemCapa.name.toLowerCase();
            const valido = extensoesPermitidas.some(ext => nomeArquivo.endsWith(ext));
            if(!valido){
                alert('Formato de imagem inválido. Use JPG, JPEG, PNG ou GIF.');
                return;
            }  
            
            console.log('Dados do Post:', dados);
        });
    }
});