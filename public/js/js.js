function selecionarChip(el) {
    document.querySelectorAll('.servico-chip').forEach(c => c.classList.remove('ativo'));
    el.classList.add('ativo');
}

function cotar() {
    const tipo = document.querySelector('.servico-chip.ativo')?.dataset.tipo || '';
    const tamanho = document.getElementById('tamanho').value;
    const data = document.getElementById('data').value;
    const horario = document.getElementById('horario').value;

    if (!tamanho || !data || !horario) {
        alert('Por favor, preencha tamanho do imóvel, data e horário para continuar.');
        return;
    }

    alert(`✅ Ótimo! Recebemos seu pedido.\n\nServiço: ${tipo}\nImóvel: ${tamanho}\nData: ${data} às ${horario}\n\nEm breve entraremos em contato pelo WhatsApp para confirmar!`);
}

// Define data mínima como hoje
const hoje = new Date().toISOString().split('T')[0];
document.getElementById('data').setAttribute('min', hoje);


const steps = document.querySelectorAll('.step');
const obs = new IntersectionObserver(entries => {
    entries.forEach(e => {
        if (e.isIntersecting) e.target.classList.add('visivel');
    });
}, { threshold: 0.2 });
steps.forEach(s => obs.observe(s));

// Tabela de preços por m²
const precos = {
    60: { padrao: 149, profunda: 249, obra: 349, comercial: 199 },
    90: { padrao: 199, profunda: 319, obra: 449, comercial: 259 },
    130: { padrao: 259, profunda: 399, obra: 549, comercial: 329 },
    999: { padrao: 329, profunda: 499, obra: 699, comercial: 429 },
};

function filtrar(btn) {
    document.querySelectorAll('.filtro-btn').forEach(b => b.classList.remove('ativo'));
    btn.classList.add('ativo');
    const m = parseInt(btn.dataset.m);
    const p = precos[m];
    document.getElementById('preco-padrao').innerHTML = `<sup>R$</sup>${p.padrao}`;
    document.getElementById('preco-profunda').innerHTML = `<sup>R$</sup>${p.profunda}`;
    document.getElementById('preco-obra').innerHTML = `<sup>R$</sup>${p.obra}`;
    document.getElementById('preco-comercial').innerHTML = `<sup>R$</sup>${p.comercial}`;
}

function selecionarOpcao(el) {
    document.querySelectorAll('.opcao-chip').forEach(c => c.classList.remove('ativo'));
    el.classList.add('ativo');
}

function agendar(servico) {
    const tamanho = document.querySelector('.filtro-btn.ativo').textContent;
    alert(`✅ Ótimo escolha!\n\nServiço: ${servico}\nTamanho: ${tamanho}\n\nVocê será redirecionado para o agendamento!`);
}

// Scroll reveal
const cards = document.querySelectorAll('.card');
const obs2 = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visivel'); });
}, { threshold: 0.1 });
cards.forEach(c => obs2.observe(c));