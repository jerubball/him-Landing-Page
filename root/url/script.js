
const isValidURL = function(url) {
    try {
        new URL(url);
        return true;
    } catch (_) {
        return false;  
    }
}

const submitForm = function() {
    var url = document.getElementById('form-url');
    var expires = document.getElementById('form-expires');
    var main = document.getElementById('main');
    var fail = document.getElementById('fail');
    var failBody = document.getElementById('fail-body');
    var success = document.getElementById('success');
    var successBody = document.getElementById('success-body');
    
    if (url.value == "") {
        main.hidden = true;
        failBody.innerHTML = "Please enter URL.";
        fail.hidden = false;
    } else if (url.value.charAt(0) != "/" && !isValidURL(url.value)) {
        main.hidden = true;
        failBody.innerHTML = "Please enter valid URL.";
        fail.hidden = false;
    } else {
        var expireParameter = "";
        if (expires.value != "") {
            expireParameter = "&expires=" + encodeURIComponent(expires.value);
        }
        var xmlhttp = new XMLHttpRequest ();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                alert(this.responseText);
            }
        };
        xmlhttp.open ("GET", "create.php?url=" + encodeURIComponent(url.value) + expireParameter, true);
        //xmlhttp.send ();
    }
}

const backToForm = function() {
    var main = document.getElementById('main');
    var fail = document.getElementById('fail');
    var failBody = document.getElementById('fail-body');
    
    fail.hidden = true;
    failBody.innerHTML = "";
    main.hidden = false;
}
