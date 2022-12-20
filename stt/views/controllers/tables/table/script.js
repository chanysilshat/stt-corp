function addData(){
    if (document.querySelectorAll("form[stt-table-form]")){
        document.querySelectorAll("form[stt-table-form]").forEach(function(form){
            form.querySelector(".stt-table-btn").addEventListener("click", function(e){
                //e.preventDefault();
            })
        })
    }
}