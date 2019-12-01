
const Script = {
    
    init() {
        this.init = Core.init;
        return this.init(Core.None.__proto__);
    },
    
    isValidURL(url) {
        try {
            new URL(url);
            return true;
        } catch (_) {
            return false;  
        }
    },
    
    failAction(message) {
        var main = document.getElementById('main');
        var wait = document.getElementById('wait');
        var fail = document.getElementById('fail');
        var failBody = document.getElementById('fail-body');
        main.hidden = true;
        wait.hidden = true;
        failBody.innerHTML = message;
        fail.hidden = false;
    },
    
    successAction(message) {
        var main = document.getElementById('main');
        var wait = document.getElementById('wait');
        var success = document.getElementById('success');
        var successBody = document.getElementById('success-body');
        main.hidden = true;
        wait.hidden = true;
        successBody.innerHTML = message;
        success.hidden = false;
    },
    
    backToForm() {
        var main = document.getElementById('main');
        var wait = document.getElementById('wait');
        var success = document.getElementById('success');
        var successBody = document.getElementById('success-body');
        var fail = document.getElementById('fail');
        var failBody = document.getElementById('fail-body');
        wait.hidden = true;
        success.hidden = true;
        successBody.innerHTML = '';
        fail.hidden = true;
        failBody.innerHTML = '';
        main.hidden = false;
    },
    
    copyToClipboard() {
        var successBody = document.getElementById('success-body');
        var successInfo = document.getElementById('success-info');
        var successLabel = document.getElementById('success-label');
        var selection = window.getSelection();
        var restore = [];
        for (var index = 0; index < selection.rangeCount; index++) {
            restore[index] = selection.getRangeAt(index);
        }
        selection.selectAllChildren(successBody);
        document.execCommand('copy');
        selection.removeAllRanges();
        for (var index = 0; index < restore.length; index++) {
            selection.addRange(restore[index]);
        }
        successInfo.hidden = false;
        successLabel.innerHTML = 'Copied to clipboard!';
    },
    
    goToURL() {
        var successBody = document.getElementById('success-body');
        window.location.href = successBody.innerHTML;
    },
    
    submitForm() {
        var url = document.getElementById('form-url');
        var expires = document.getElementById('form-expires');
        var main = document.getElementById('main');
        var wait = document.getElementById('wait');
        
        if (url.value == '') {
            this.failAction('Please enter URL.');
        } else if (url.value.charAt(0) != '/' && !this.isValidURL(url.value)) {
            this.failAction('Please enter valid URL.');
        } else {
            var expireParameter = '';
            if (expires.value != '') {
                expireParameter = '&expires=' + encodeURIComponent(expires.value);
            }
            var xmlhttp = new XMLHttpRequest ();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4) {
                    if (this.status == 200) {
                        if (this.responseText.length > 2) { // response is 0 or 1 followed by message.
                            var response = this.responseText.substring(2);
                            if (this.responseText.charAt(0) == '0') {
                                Script.successAction(window.location.origin + '/url?' + response);
                                Script.copyToClipboard();
                            } else {
                                Script.failAction(response);
                            }
                        } else {
                            Script.failAction('Unknown error occurred.');
                        }
                    } else {
                        Script.failAction('Internal server error occurred.');
                    }
                } else {
                    main.hidden = true;
                    wait.hidden = false;
                }
            };
            xmlhttp.open('GET', 'create.php?url=' + encodeURIComponent(url.value) + expireParameter, true);
            xmlhttp.send();
        }
        return false;
    },
    
}.init();
