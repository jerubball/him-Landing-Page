
const isValidURL = function(url) {
    try {
        new URL(url);
        return true;
    } catch (_) {
        return false;  
    }
}

const failAction = function(message) {
    var main = document.getElementById('main');
    var wait = document.getElementById('wait');
    var fail = document.getElementById('fail');
    var failBody = document.getElementById('fail-body');
    main.hidden = true;
    wait.hidden = true;
    failBody.innerHTML = message;
    fail.hidden = false;
}

const successAction = function(message) {
    var main = document.getElementById('main');
    var wait = document.getElementById('wait');
    var success = document.getElementById('success');
    var successBody = document.getElementById('success-body');
    main.hidden = true;
    wait.hidden = true;
    successBody.innerHTML = message;
    success.hidden = false;
}

const submitForm = function() {
    var url = document.getElementById('form-url');
    var expires = document.getElementById('form-expires');
    var main = document.getElementById('main');
    var wait = document.getElementById('wait');
    
    if (url.value == "") {
        failAction("Please enter URL.");
    } else if (url.value.charAt(0) != "/" && !isValidURL(url.value)) {
        failAction("Please enter valid URL.");
    } else {
        var expireParameter = "";
        if (expires.value != "") {
            expireParameter = "&expires=" + encodeURIComponent(expires.value);
        }
        var xmlhttp = new XMLHttpRequest ();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4) {
                if (this.status == 200) {
                    if (this.responseText.length > 2) {
                        var response = this.responseText.substring(2);
                        if (this.responseText.charAt(0) == '0') {
                            successAction(window.location.origin + '/url?' + response);
                        } else {
                            failAction(response);
                        }
                    } else {
                        failAction("Unknown error occurred.");
                    }
                    console.log(this.responseText);
                } else {
                    failAction("Internal server error occurred.");
                }
            } else {
                main.hidden = true;
                wait.hidden = false;
            }
        };
        xmlhttp.open ("GET", "create.php?url=" + encodeURIComponent(url.value) + expireParameter, true);
        xmlhttp.send ();
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

const copyToClipboard = function() {
    var successBody = document.getElementById('success-body');
    var selection = window.getSelection();
    var restore = [];
    for (var index = 0; index < selection.rangeCount; index++) {
        restore[index] = selection.getRangeAt(index);
    }
    selection.selectAllChildren(successBody);
    document.execCommand("copy");
    selection.removeAllRanges();
    for (var index = 0; index < restore.length; index++) {
        selection.addRange(restore[index]);
    }
}

const goToURL = function() {
    var successBody = document.getElementById('success-body');
    window.location.href = successBody.innerHTML;
}
