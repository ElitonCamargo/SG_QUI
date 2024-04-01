const alertaPersonalizado = (tipo, titulo, msg)=>{
    return `<div class="alert alert-${tipo} alert-dismissible fade show" role="alert">
                <strong>${titulo}</strong> 
                ${msg}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`;
}


const req_POST = async (url = "", data = {})=> {
    const response = await fetch(url, {
      method: "POST", 
      mode: "cors", 
      cache: "no-cache", 
      credentials: "omit", 
      headers: {
        "Content-Type": "application/json",          
      },
      redirect: "follow",
      referrerPolicy: "no-referrer",
      body: JSON.stringify(data), 
    });
    return response.json(); 
}


const req_GET = async (url = "") => {
    const response = await fetch(url, {
        method: "GET",
        mode: "cors",
        cache: "no-cache",
        credentials: "omit",
        headers: {
            "Content-Type": "application/json",
        },
        redirect: "follow",
        referrerPolicy: "no-referrer",
    });
    return response.json();
}