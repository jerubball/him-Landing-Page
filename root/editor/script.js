
const Script = {
    
    init() {
        this.init = Core.init;
        return this.init(Core.None.__proto__);
    },
    
    setListeners() {
        var elem = document.getElementById('text');
        var info = document.getElementById('info');
        var listener = (e) => {
            this.updateInfo(elem, info);
        };
        elem.onchange = listener;
        elem.oninput = listener;
        elem.oncopy = listener;
        elem.oncut = listener;
        elem.onpaste = listener;
        elem.onkeydown = listener;
        elem.onkeypress = listener;
        elem.onkeyup = listener;
        elem.onmousedown = listener;
        elem.onclick = listener;
        elem.onmouseup = listener;
        elem.onmousemove = listener;
    }
    
    updateInfo(elem, info) {
        if (elem == undefined) {
            elem = document.getElementById('text');
        }
        if (info == undefined) {
            info = document.getElementById('info');
        }
        if (elem.selectionStart == elem.selectionEnd) {
            info.innerHTML = elem.selectionStart + '/' + elem.textLength;
        } else {
            info.innerHTML = elem.selectionStart + '-' + elem.selectionEnd + '/' + elem.textLength;
        }
    },
    
}.init();
