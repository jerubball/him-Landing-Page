
const Script = {
    
    init() {
        this.init = Core.init;
        return this.init(Core.None.__proto__);
    },
    
    isValidEmail(email) {
        var ans = email.match(/^[a-zA-Z0-9_.+-]+@([a-zA-Z0-9-]+\.)+[a-zA-Z]+$/);
        return ans != null && ans.length > 0;
    },
    
    failMessage(message, ...targets) {
        var fail = document.getElementById('fail');
        var failBody = document.getElementById('fail-body');
        for (let target of targets) {
            target.hidden = true;
        }
        if (targets.length > 0) {
            fail.dataset.target = targets[0].id;
        }
        failBody.innerHTML = message;
        fail.hidden = false;
    },
    
    successMessage(message, ...targets) {
        var success = document.getElementById('success');
        var successBody = document.getElementById('success-body');
        for (let target of targets) {
            target.hidden = true;
        }
        successBody.innerHTML = message;
        success.hidden = false;
    }
    
    backToTarget(elem) {
        elem.hidden = true;
        if (elem.dataset.target != undefined || elem.dataset.target.length > 0) {
            var target = document.getElementById(elem.dataset.target);
            target.hidden = false;
        }
    },
    
    submitEmail() {
        var main = document.getElementById('main');
        var wait = document.getElementById('wait');
        var email = document.getElementById('form-main-email');
        
        email.value = email.value.trim();
        if (email.value == '') {
            this.failMessage('Please enter email.', main);
        } else if (!this.isValidEmail(email.value)) {
            this.failMessage('Please enter valid email.', main);
        } else {
            document.cookie = 'email='+email.value+';max-age=604800;path=/;secure;samesite';
            var xmlhttp = new XMLHttpRequest ();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4) {
                    if (this.status == 200) {
                        if (this.response && this.response instanceof Object) {
                            if (this.response['code'] === 0) {
                                wait.hidden = true;
                                Script.backToTarget(main);
                            } else {
                                Script.failMessage(this.response['status'], main, wait);
                            }
                        } else {
                            Script.failMessage('Unknown error occurred.', main, wait);
                        }
                    } else {
                        Script.failMessage('Internal server error occurred.', main, wait);
                    }
                } else {
                    main.hidden = true;
                    wait.hidden = false;
                }
            };
            xmlhttp.responseType = 'json';
            xmlhttp.open('GET', 'request.php', true);
            xmlhttp.send();
        }
        return false;
    },
    
    submitCode() {
        var auth = document.getElementById('auth');
        var wait = document.getElementById('wait');
        var code = document.getElementById('form-auth-code');
        
        code.value = code.value.trim();
        if (code.value == '') {
            this.failMessage('Please enter authentication code.', auth);
        } else {
            var xmlhttp = new XMLHttpRequest ();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4) {
                    if (this.status == 200) {
                        if (this.response && this.response instanceof Object) {
                            if (this.response['code'] === 0) {
                                wait.hidden = true;
                                Script.backToTarget(auth);
                            } else {
                                Script.failMessage(this.response['status'], auth, wait);
                            }
                        } else {
                            Script.failMessage('Unknown error occurred.', auth, wait);
                        }
                    } else {
                        Script.failMessage('Internal server error occurred.', auth, wait);
                    }
                } else {
                    auth.hidden = true;
                    wait.hidden = false;
                }
            };
            xmlhttp.responseType = 'json';
            xmlhttp.open('GET', 'submit.php?code=' + encodeURIComponent(code.value), true);
            xmlhttp.send();
        }
        return false;
    },
    
}.init();
