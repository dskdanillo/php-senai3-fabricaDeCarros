document.addEventListener("DOMContentLoaded",()=>{

    const form=document.querySelector("form");
    if(!form) return;
    
    form.addEventListener("submit",(e)=>{
    
    const modeloRegex=/^[A-Za-zÀ-ÿ\s]{2,30}$/;
    const corRegex=/^[A-Za-zÀ-ÿ\s]{3,20}$/;
    
    document.querySelectorAll(".modelo").forEach(input=>{
     if(!modeloRegex.test(input.value)){
       alert("Modelo inválido!");
       input.focus();
       e.preventDefault();
     }
    });
    
    document.querySelectorAll(".cor").forEach(input=>{
     if(!corRegex.test(input.value)){
       alert("Cor inválida!");
       input.focus();
       e.preventDefault();
     }
    });
    
    });
    });