

/*class SttConstucrtView{
    constructor(params){
       
    }
    showEl(params){
        console.log(params);
    }
}
document.addEventListener("DOMContentLoaded", function(){
    // Create WebSocket connection.
    const socket = new WebSocket('ws://stt-project:8090/test.php');

    socket.onopen = function(){
        let body = document.querySelector(".result");
        body.append("СОЕДНИНЕНИЕ УСТАНОВЛЕНО");
    }

    socket.onerror = function(error){
        let body = document.querySelector(".result");
        body.append("ОШИБКА " + error.message);
    }
    socket.onclose = function(){
        let body = document.querySelector(".result");
        body.append("Соединение закрыто ");
    }
    socket.onmessage = function (event){
        var data = JSON.parse(event.data);

        let body = document.querySelector(".result");
        body.append(" " + data.type + " " + data.message);

    }
})


let SttConstucrtVieW = new SttConstucrtView();
SttConstucrtVieW.showEl(
    {
        "ITEM": {
            "element": "div",
            "attributes":{
                "id":"",
                "name":""
            }
        }
    }
);*/
console.log("ergergreg");
var tt=222;
function ss(){
    alert("Функция")
}
//ss();