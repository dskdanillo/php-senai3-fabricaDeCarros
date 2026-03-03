// ===============================
// VALIDAÇÃO FORMULÁRIO CARROS
// ===============================

// Espera a página carregar
document.addEventListener("DOMContentLoaded", function () {

    const form = document.querySelector("form");

    if (!form) return;

    form.addEventListener("submit", function (event) {

        let valido = true;

        // REGEX
        const regexModelo = /^[A-Za-z0-9\s]{2,30}$/;
        // letras + números + espaço (2 a 30 caracteres)

        const regexCor = /^[A-Za-zÀ-ÿ\s]{3,20}$/;
        // somente letras (aceita acentos)

        // pega todos inputs modelo
        const modelos = document.querySelectorAll("input[name^='modelo']");
        const cores = document.querySelectorAll("input[name^='cor']");

        // ===============================
        // VALIDAR MODELOS
        // ===============================
        modelos.forEach(input => {

            limparErro(input);

            if (!regexModelo.test(input.value.trim())) {
                mostrarErro(input, "Modelo inválido (apenas letras e números)");
                valido = false;
            }
        });

        // ===============================
        // VALIDAR CORES
        // ===============================
        cores.forEach(input => {

            limparErro(input);

            if (!regexCor.test(input.value.trim())) {
                mostrarErro(input, "Cor inválida (somente letras)");
                valido = false;
            }
        });

        // impede envio se erro
        if (!valido) {
            event.preventDefault();
        }
    });
});


// ===============================
// MOSTRAR ERRO
// ===============================
function mostrarErro(input, mensagem) {

    input.style.border = "2px solid red";

    const erro = document.createElement("small");
    erro.className = "erro-js";
    erro.style.color = "red";
    erro.innerText = mensagem;

    input.parentNode.appendChild(erro);
}


// ===============================
// LIMPAR ERRO
// ===============================
function limparErro(input) {

    input.style.border = "";

    const erro = input.parentNode.querySelector(".erro-js");
    if (erro) erro.remove();
}