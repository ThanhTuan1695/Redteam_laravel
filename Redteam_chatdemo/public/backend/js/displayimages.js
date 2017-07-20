var selDiv = "";
        
    document.addEventListener("DOMContentLoaded", init, false);
    
    function init() {
        document.querySelector('#files').addEventListener('change', handleFileSelect, false);
        selDiv = document.querySelector("#selectedFiles");
    }
        
    function handleFileSelect(e) {
        
        if(!e.target.files || !window.FileReader) return;
        
        selDiv.innerHTML = "";
        
        var files = e.target.files;
        var filesArr = Array.prototype.slice.call(files);
        filesArr.forEach(function(f) {
            if(!f.type.match("image.*")) {
                return;
            }
    
            var reader = new FileReader();
            reader.onload = function (e) {
                var html = "<div class=\"" + "col-sm-4" + "\">" + "<img src=\"" + e.target.result + "\"" + "style=\""+"width:300px;height:200px;margin-bottom:10px;"+"\">" + "</div>";
                selDiv.innerHTML += html;               
            }
            reader.readAsDataURL(f); 
            
        });
        
        
    }