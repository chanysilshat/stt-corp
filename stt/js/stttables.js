class SttTables{

    constructor(){
        
    }

    searchTables(){
        
     

        let tables = document.querySelectorAll("table.stt-table");
        this.contructEditPanel();
        if (tables){
            tables.forEach(function(table, tableIndex){

                if (!table.hasAttribute("stt-table")){

                    table.setAttribute("stt-table", "");
                    
                    let tr = table.querySelectorAll("tr");
                
                    tr.forEach(function(trItem, trIndex){
        
                        let td = document.createElement('td');
                        let checkbox = document.createElement('input');
                        checkbox.setAttribute('type', 'checkbox');
                        td.append(checkbox);
                        trItem.prepend(td);
                        if (trIndex == 0){
                            checkbox.addEventListener('change', function(){
                                table.querySelectorAll('input[type=checkbox]').forEach(function(input, inputIndex){
                                    if (inputIndex > 0){
                                        input.checked = checkbox.checked;
                                    }
                                })
                            })
                        } 
                        checkbox.addEventListener('change', function(){
                            if (this.checked){
                                document.querySelector("[stt-editPanel]").classList.add("active");
                            } else {
                                document.querySelector("[stt-editPanel]").classList.remove("active");
                            }
                        })
                    })
                }
                
            })
        }
    
    }
    
    setSttAdminProject(sttAdmin){
        this.sttAdmin = sttAdmin;
    }

    contructEditPanel(){
        
        var sttAdmin = this.sttAdmin;

        if (document.querySelector(".editPanel[stt-editPanel]")){
            var editPanel = document.querySelector(".editPanel[stt-editPanel]");
        } else {
            var editPanel = document.createElement("div");
            var editElem = document.createElement("div");
            var deleteElem = document.createElement("div");
            editElem.textContent = "Редактировать запись";
            editElem.setAttribute("stt-editElem", "");
            deleteElem.textContent = "Удалить запись";
            deleteElem.setAttribute("stt-deleteElem", "");

            editPanel.setAttribute("stt-editPanel", "");
            editPanel.append(editElem, deleteElem);
            document.querySelector(".stt_panel_page_block").append(editPanel);

            editPanel.classList.add("editPanel");

            deleteElem.addEventListener("click", function(e){
                document.querySelectorAll('table[stt-table] input[type="checkbox"]').forEach(function(check){
                    if (check.checked){
                        if (check.closest("tr").hasAttribute("entry-id")){
                            let entryId = check.closest("tr").getAttribute("entry-id");
                            let table = check.closest("table").getAttribute("table-code");
                            let formData = new FormData();
                            formData.append('header_mode', 0);
                            formData.append('load_script', 1);
                            formData.append('load_css', 1);
                            formData.append('table-handler[handler]', 'delete');
                            formData.append('table-handler[table]', table);
                            formData.append('table-handler[data][id]', entryId);
                            let xhr = new XMLHttpRequest();
                            xhr.open("POST", window.location.pathname + window.location.search);
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
        
                                                sttAdmin.js[index] = item;
                                                item.remove();
                                            }
                                        })
                                    }
                                    scripts = page.querySelectorAll("script");
                                   
                                    if (scripts.length > 0){
                                        scripts.forEach(function(item, index){
                                            if (item.hasAttribute("src")){
                                                sttAdmin.loadScript(item.getAttribute("src"), thisClass.callbackLoadedScript);
                                                item.remove();
                                            }
                                        })
                                        
                                    } else {
                                        sttAdmin.callbackLoadedScript(sttAdmin);
                                    }
                                    
                                    
                                    var ST = new SttTables(); 
                                    ST.setSttAdminProject(sttAdmin);
                                    ST.searchTables();
        
                                    sttAdmin.editDynamicsHref(document.querySelector('.stt_panel_page_block'));
                                }
                            }
                        }
                    }
                })
            })

        }

        
        return editPanel;
    }
    editTable(table){

    }

    contructTable(){

    }

    
}
