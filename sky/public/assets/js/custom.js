//-----------------------------------------------------------------
//adiconar produto ao carrinho
function adicionar_carrinho(id_produto) {
    axios.defaults.withCredentials = true;
    axios.get('?a=adicionar_carrinho&id_produto=' + id_produto)
        .then(function (response) {
            var total_produtos = response.data;
            document.getElementById('carrinho').innerText = total_produtos;

        });

}
//-----------------------------------------------------------------
function limpar_carrinho() {
    var e = document.getElementById('confirmar_limpar_carrinho');
    e.style.display = 'inline';
}

function limpar_carrinho_off() {
    var e = document.getElementById('confirmar_limpar_carrinho');
    e.style.display = 'none';

}
//-----------------------------------------------------------------
function usar_morada_alternativa() {
    //mostrar ou esconder o espaço para morada alternativa
    var e = document.getElementById('check_morada_alternativa');
    if (e.checked == true) {
        //mostra o campo para definir morada alternativa
        document.getElementById('morada_alternativa').style.display = 'block';

    } else {
        //esconde o quadro para definir morada alternativa
        document.getElementById('morada_alternativa').style.display = 'none';
    }


}
//-----------------------------------------------------------------
function morada_alternativa() {
    //
    axios(
        {
            method: 'post',
            url: '?a=morada_alternativa',
            data: {
                text_morada: document.getElementById('text_morada_alternativa').value,
                text_cidade: document.getElementById('text_cidade_alternativa').value,
                text_email: document.getElementById('text_email_alternativo').value,
                text_telefone: document.getElementById('text_telefone_alternativo').value,
            }
        }
    ).
        the(function (response) {
            

        });

}
