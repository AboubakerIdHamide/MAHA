let errorSpan=document.getElementById("error"),
    codeInp=document.getElementById("code"),
    resendBtn=document.getElementById("resend"),
    submitBtn=document.getElementById("sbmtBtn");

codeInp.addEventListener("keyup", ()=>{
    errorSpan.textContent="";
    if(codeInp.value.length>6){
        errorSpan.textContent="Code invalide (6 chiffres)";
    }
})
submitBtn.addEventListener("click", (e)=>{
    errorSpan.textContent="";
    if(codeInp.value.length!=6){
        e.preventDefault();
        errorSpan.textContent="Code invalide (6 chiffres)";
    }
});
