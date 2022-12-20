class SttAdminPanel{

    constructor(){
       this.js = {};
       this.jsSrc = {};
    }


    //Вызов административной части
    showPanelTemplate(){
        var thisClass = this;
        document.addEventListener('DOMContentLoaded', function(){
            document.querySelector('body').innerHTML = "";
            let formData = new FormData();
            formData.append('header_mode', 0);
            formData.append('get_menu_items', 'main_menu');
            let xhr = new XMLHttpRequest();
            xhr.open("POST", '/admin/ajax_settings.php');
            xhr.responseType = 'json';
            xhr.send(formData);
    
            xhr.onprogress = () => {
                
            }
            xhr.onload = () => {
                if (xhr.response){
                    thisClass.projectParams = xhr.response;
                    if (thisClass.projectParams.user_authorized == "y"){
                        thisClass.constructPanelTemplate();
                        document.querySelector('body').append(thisClass.stt_panel);
                    } else {
                        thisClass.contructAutorizeForm();
                        document.querySelector('body').append(thisClass.stt_form_block);
                        
                    }
                }
            }   
            setInterval(() => {thisClass.getProjectParams()}, 5000);
        })
    }

    //Получение информации о проекте
    getProjectParams(){

        var thisClass = this;

        let formData = new FormData();
        formData.append('header_mode', 0);
        let xhr = new XMLHttpRequest();
        xhr.open("POST", '/admin/ajax_settings.php');
        xhr.responseType = 'json';
        xhr.send(formData);

        xhr.onprogress = () => {
            
        }
        xhr.onload = () => {
            if (xhr.response){

                if (thisClass.projectParams.user_authorized != xhr.response.user_authorized){
                    document.querySelector('body').innerHTML = "";
                    thisClass.projectParams = xhr.response;

                    if (xhr.response.user_authorized == "y"){
                        thisClass.constructPanelTemplate();
                        document.querySelector('body').append(thisClass.stt_panel);
                    } else {
                        thisClass.contructAutorizeForm();
                        document.querySelector('body').append(thisClass.stt_form_block);  
                    }
                }

                thisClass.projectParams = xhr.response;
            }
        }     
    }

    //Построение админ панели
    constructPanelTemplate(){
        var thisClass = this;
        let stt_panel = document.createElement('div');
        let stt_panel_menu = document.createElement('div');
        let stt_panel_page = document.createElement('div');
        let stt_panel_page_head = document.createElement('div');
        let stt_panel_page_block = document.createElement('div');
        
        stt_panel.classList.add("stt_panel");
        stt_panel_menu.classList.add("stt_panel_menu");
        stt_panel_page.classList.add("stt_panel_page");
        stt_panel_page_head.classList.add("stt_panel_page_head");
        stt_panel_page_block.classList.add("stt_panel_page_block");

        stt_panel.append(stt_panel_menu, stt_panel_page);
        stt_panel_menu.append(this.constuctMenuPanel(stt_panel_menu));


        stt_panel_page_head.append(this.constructHeadPanel(stt_panel_page_head));

        /**Загрузка страницы */
        let formData = new FormData();
        formData.append('header_mode', 0);
        formData.append('load_script', 1);
        formData.append('load_css', 1);
        let xhr = new XMLHttpRequest();
        xhr.open("POST", window.location.pathname + window.location.search);
        xhr.responseType = 'html';
        xhr.send(formData);

        xhr.onprogress = () => {
            
        }

        xhr.onload = () => {
            stt_panel_page_block.innerHTML = xhr.response;

            this.editDynamicsHref(stt_panel_page_block);

            var ST = new SttTables(); 
            ST.setSttAdminProject(thisClass);
            ST.searchTables();

        }


        stt_panel_page.append(stt_panel_page_head, stt_panel_page_block);
        this.stt_panel = stt_panel;

    }

    /**
     * Получает ответ от страницы. 
     * Ведет поиск ссылок по странице
     * Все ссылки с атрибутом stt-admin переделывает в динамические
     */
    editDynamicsHref(stt_panel_page_block){

        var thisClass = this;

        stt_panel_page_block.querySelectorAll("a[stt-admin]").forEach(function(a){
            a.addEventListener("click", function(e){
                e.preventDefault();

                Object.keys(thisClass.js).forEach(function(index){
                    if (typeof thisClass.js[index] === 'object'){
                        thisClass.js[index].remove();
                    }
                })

                thisClass.js = {};

                updateURL(this.getAttribute("href"));

                let formData = new FormData();
                formData.append('header_mode', 0);
                formData.append('load_script', 1);
                formData.append('load_css', 1);
                let xhr = new XMLHttpRequest();
                xhr.open("POST", this.getAttribute("href"));
                xhr.responseType = 'html';
                xhr.send(formData);

                xhr.onprogress = () => {
                    
                }

                xhr.onload = () => {

                    if (xhr.response){
                        document.querySelector('.stt_panel_page_block').innerHTML = "";
                        let page = document.createElement('div');
                        page.innerHTML = xhr.response;
                        document.querySelector('.stt_panel_page_block').append(page);

                        let scripts = page.querySelectorAll("script");
                        if (scripts){
                            scripts.forEach(function(item, index){
                                if (item.hasAttribute("src")){
                                    let url = item.getAttribute("src");
                                    let scriptsList = document.querySelectorAll('head script');
                                    scriptsList.forEach(function(itemScript, index){
                                        if (itemScript.getAttribute("src") == url){
                                            item.remove();
                                        }
                                    })
                                    
                                    
                                } else {

                                    thisClass.js[index] = item;
                                    item.remove();
                                }
                            })
                        }
                        scripts = page.querySelectorAll("script");
                       
                        if (scripts.length > 0){
                            scripts.forEach(function(item, index){
                                if (item.hasAttribute("src")){
                                    thisClass.loadScript(item.getAttribute("src"), thisClass.callbackLoadedScript);
                                    item.remove();
                                }
                            })
                            
                        } else {
                            thisClass.callbackLoadedScript(thisClass);
                        }
                        
                        
                        var ST = new SttTables(); 
                        ST.setSttAdminProject(thisClass);
                        ST.searchTables();
                        thisClass.editDynamicsHref(document.querySelector('.stt_panel_page_block'));
                    }
                }
            })
        })
    }

    //Построение шапки
    constructHeadPanel(){
        var thisClass = this;
        console.log(thisClass.projectParams);
        let head_block = document.createElement("div");
        let head_logo_block = document.createElement("div");
        let head_search_block = document.createElement("div");
        let head_user_href = document.createElement("div");

        head_block.classList.add('head_block');
        head_logo_block.classList.add('head_logo_block');
        head_search_block.classList.add('head_search_block');
        head_user_href.classList.add('head_user_href');

        head_block.append(head_logo_block, head_search_block, head_user_href);
        return head_block;
    }

    //Построение главного меню админ панели
    constuctMenuPanel(stt_panel_menu){

        let main_menu_block = document.createElement('div');
        let menu_logo_block = document.createElement('div');
        let menu_item_block = document.createElement('div');
        let menu_icon_open = document.createElement('img');
        let menu_icon_close = document.createElement('img');

        menu_icon_open.classList.add('menu_icon_open');
        menu_icon_open.setAttribute('src', '/upload/panel/main-menu.svg');
        menu_icon_close.classList.add('menu_icon_close');
        menu_icon_close.setAttribute('src', '/upload/panel/main-menu-close.svg');


        menu_icon_open.addEventListener('click', function(){
            document.querySelector('body').classList.add('menu-open')
        });

        menu_icon_close.addEventListener('click', function(){
            document.querySelector('body').classList.remove('menu-open')
        });

        main_menu_block.classList.add('main_menu_block');
        menu_logo_block.classList.add('menu_logo_block');
        menu_item_block.classList.add('menu_item_block');

        menu_logo_block.append(menu_icon_open, menu_icon_close);
        main_menu_block.append(menu_logo_block, menu_item_block);

        this.constructMenuItem(menu_item_block, this.projectParams.MAIN_MENU);
        //updateURL();
        return main_menu_block;
    }

    //Построение элемента главного меню
    constructMenuItem(menu_item_block, menu_array){
        var thisClass = this;
        if (menu_array){
            Object.keys(menu_array).forEach(function(index){
                let menu_item = document.createElement('div');
                let menu_href = document.createElement('a');
                let menu_logo = document.createElement('img');
                let menu_name = document.createElement('span');
    
                menu_item.classList.add('menu_item');
                menu_href.classList.add('menu_href');
                menu_logo.classList.add('menu_logo');
                menu_name.classList.add('menu_name');
    
                menu_href.setAttribute('href', menu_array[index].PATH);
                menu_logo.setAttribute('src', menu_array[index].LOGO);
                menu_name.textContent = menu_array[index].NAME
                
                menu_href.addEventListener('click', function(e){

                    e.preventDefault();
                    Object.keys(thisClass.js).forEach(function(index){
                        if (typeof thisClass.js[index] === 'object'){
                            thisClass.js[index].remove();
                        }
                    })
                    thisClass.js = {};
                    /*Object.keys(thisClass.js).forEach(function(index){
                        thisClass.jsSrc[index].remove();
                    })*/
            
                    document.querySelectorAll('.menu_href').forEach(function(item){
                        item.classList.remove('active');
                    })
                    this.classList.add('active');
                    updateURL(menu_array[index].PATH);
    
                    let formData = new FormData();
                    formData.append('header_mode', 0);
                    formData.append('load_script', 1);
                    formData.append('load_css', 1);
                    let xhr = new XMLHttpRequest();
                    xhr.open("POST", window.location.pathname);
                    xhr.responseType = 'html';
                    xhr.send(formData);
            
                    xhr.onprogress = () => {
                        
                    }
            
                    xhr.onload = () => {
                   
                        if (xhr.response){
                            document.querySelector('.stt_panel_page_block').innerHTML = "";
                            let page = document.createElement('div');
                            page.innerHTML = xhr.response;
                            document.querySelector('.stt_panel_page_block').append(page);

                            let scripts = page.querySelectorAll("script");
                            if (scripts){
                                scripts.forEach(function(item, index){
                                    if (item.hasAttribute("src")){
                                        let url = item.getAttribute("src");
                                        let scriptsList = document.querySelectorAll('head script');
                                        scriptsList.forEach(function(itemScript, index){
                                            if (itemScript.getAttribute("src") == url){
                                                item.remove();
                                            }
                                        })
                                        
                                        
                                    } else {

                                        thisClass.js[index] = item;
                                        item.remove();
                                    }
                                })
                            }
                            scripts = page.querySelectorAll("script");
                           
                            if (scripts.length > 0){
                                scripts.forEach(function(item, index){
                                    if (item.hasAttribute("src")){
                                        thisClass.loadScript(item.getAttribute("src"), thisClass.callbackLoadedScript);
                                        item.remove();
                                    }
                                })
                                
                            } else {
                                thisClass.callbackLoadedScript(thisClass);
                            }
                            
                            
                            var ST = new SttTables(); 
                            ST.setSttAdminProject(thisClass);
                            ST.searchTables();

                            thisClass.editDynamicsHref(document.querySelector('.stt_panel_page_block'));
                        }
                    }
                })
                if (window.location.pathname == menu_array[index].PATH){
                    menu_href.classList.add('active');
                }
                menu_href.append(menu_logo, menu_name);
                menu_item.append(menu_href);
                menu_item_block.append(menu_item);
            });
        }
      
        
    }

    callbackLoadedScript(thisClass){
        if (thisClass.js){
            Object.keys(thisClass.js).forEach(function(index){
                document.getElementsByTagName("head")[0].appendChild(thisClass.js[index]);
                eval(thisClass.js[index].textContent);
            })
        }
    }

    //Построение формы авторизации
    contructAutorizeForm(){

        var thisClass = this;
        let stt_form_block = document.createElement('div');
        let stt_form = document.createElement('form');
        let stt_form_head = document.createElement('div');
        let stt_form_head_span = document.createElement('span');
        let stt_form_login = document.createElement('div');
        let stt_form_password = document.createElement('div');
        let stt_form_submit = document.createElement('div');
        let stt_form_login_head = document.createElement('div');
        let stt_form_password_head = document.createElement('div');
        let stt_form_login_input = document.createElement('input');
        let stt_form_password_input = document.createElement('input');
        let stt_form_submit_input = document.createElement('input');

        stt_form_block.classList.add('stt_form_block');
        stt_form.classList.add('stt_form');
        stt_form_head.classList.add('stt_form_head');
        stt_form_head_span.classList.add('stt_form_head_span');
        stt_form_login.classList.add('stt_form_login');
        stt_form_password.classList.add('stt_form_password');
        stt_form_submit.classList.add('stt_form_submit');
        stt_form_login_head.classList.add('stt_form_login_head');
        stt_form_password_head.classList.add('stt_form_password_head');
        stt_form_login_input.classList.add('stt_form_login_input');
        stt_form_password_input.classList.add('stt_form_password_input');
        stt_form_submit_input.classList.add('stt_form_submit_input');

        stt_form_head_span.textContent = "Авторизация";
        stt_form_login_head.textContent = "Логин";
        stt_form_password_head.textContent = "Пароль";

        stt_form_login_input.setAttribute('type', 'text');
        stt_form_login_input.setAttribute('name', 'login');

        stt_form_password_input.setAttribute('type', 'password');
        stt_form_password_input.setAttribute('name', 'password');

        stt_form_submit_input.setAttribute('type', 'submit');
        stt_form_submit_input.setAttribute('value', 'Авторизоваться');

        stt_form_submit_input.addEventListener('click', function(e){
            e.preventDefault();
            let formData = new FormData(stt_form);
            formData.append('header_mode', 0);
            let xhr = new XMLHttpRequest();
            xhr.open("POST", '/admin/ajax_settings.php');
            xhr.responseType = 'json';
            xhr.send(formData);
    
            xhr.onprogress = () => {
                
            }
            xhr.onload = () => {
                if (xhr.response){
                    thisClass.projectParams = xhr.response;
                    if (thisClass.projectParams.user_authorized == "y"){
                        updateURL(window.location.pathname);
                        document.querySelector('body').innerHTML = "";
                        thisClass.constructPanelTemplate();
                        document.querySelector('body').append(thisClass.stt_panel);
                    } else {
                        //thisClass.contructAutorizeForm();
                        //document.querySelector('body').append(thisClass.stt_form_block);
                        
                    }
                }
            }       
        })

        stt_form_block.append(stt_form);
        stt_form.append(stt_form_head, stt_form_login, stt_form_password, stt_form_submit);
        stt_form_head.append(stt_form_head_span);
        stt_form_login.append(stt_form_login_head, stt_form_login_input);
        stt_form_password.append(stt_form_password_head, stt_form_password_input);
        stt_form_submit.append(stt_form_submit_input);

        this.stt_form_block = stt_form_block;
    }

    //Загрузка скиптров со страниц
    loadScript(url,callback){
        let thisClass = this;
        var script = document.createElement("script")
        script.type = "text/javascript";
        if (script.readyState){  //IE
            script.onreadystatechange = function(){
                if (script.readyState == "loaded" ||
                        script.readyState == "complete"){
                    script.onreadystatechange = null;
                    //script.parentNode.removeChild( script );
                    callback(thisClass);
    
                }
            };
        } else {  //Others
            script.onload = function(){
                //this.parentNode.removeChild(this);
                callback(thisClass);
            };
        }
        script.src = url;
        document.getElementsByTagName("head")[0].appendChild(script);
        eval(script);
    }
}


function updateURL(url) {
    if (history.pushState) {
        var baseUrl = window.location.protocol + "//" + window.location.host + url;
        history.pushState(null, null, baseUrl);
    }
    else {
        console.warn('History API не поддерживает ваш браузер');
    }
}

var SAP = new SttAdminPanel();
SAP.showPanelTemplate();


//loadScript("/stt/js/script.js", tt)

function loadScript(url,callback = null) {
    var script = document.createElement("script")
    script.type = "text/javascript";
    if (script.readyState){  //IE
        script.onreadystatechange = function(){
            if (script.readyState == "loaded" ||
                    script.readyState == "complete"){
                script.onreadystatechange = null;
    	        //script.parentNode.removeChild( script );
                //callback();
 
            }
        };
    } else {  //Others
        script.onload = function(){
         //this.parentNode.removeChild(this);
         //callback();
        };
    }
   	script.src = url;
   	document.getElementsByTagName("head")[0].appendChild(script);
    eval(script);
    //ss();
}
function tt(){
    //ss();
}
window.onload = function(){
    document.querySelectorAll("script").forEach(function(item){
        //item.remove();
    })
    
}