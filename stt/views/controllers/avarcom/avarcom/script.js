window.onload = function(){
    console.log(yandexID);
    let form = document.querySelector("form[avar-stat]");
    if (form){
        if (yandexID > 0){
            let input = document.createElement("input");
            input.setAttribute("name", "avar_stat[yandexID]");
            input.setAttribute("value", yandexID);
            input.setAttribute("type", "hidden");
            form.append(input);

        }
        let formData = new FormData(form);
        if (yandexID > 0){
            formData.append('yandexID', 0);
        }
        formData.append('header_mode', 0);
        let xhr = new XMLHttpRequest();
        xhr.open("POST", window.location.pathname + window.location.search);
        xhr.responseType = 'json';
        xhr.send(formData);
        xhr.onprogress = () => {
                
        }
        xhr.onload = () => {
            form.remove();
        }
    }
   
}