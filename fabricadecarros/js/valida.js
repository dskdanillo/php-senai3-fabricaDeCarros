document.addEventListener("DOMContentLoaded", function(){
const form = document.getElementById("menuform");

if (form){
    form.addEventListener("submit", function(event){
        const button = event.submiter || document.activeElement;
        const acao = button ? button.value : "desconhecida";

        const confirmar = window.confirm("Confirma a ação: " + acao + "?" );

        if(!confirmar){
            event.preventDefault();
            console.log("Envio cancelado");
        }else {
            console.log("Envio confirmado para o PHP");
        }
    })
}
})
