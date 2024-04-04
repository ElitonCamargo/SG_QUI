document.write('<script src="/front/router/rotas.js"></script>');
const rotear = (rotaUrl = window.location.pathname)=>{
    return rotas.find(rota => rota.path.toLowerCase() == rotaUrl.toLowerCase());
}

$(document).ready(function() {
    let rota = rotear();
    if(rota){
        $("#root").load(rota.component);
    }
    else{
        $("#root").load('/front/page/erro.html');
    }   
});