
const Script = {
    
    init() {
        this.init = Core.init;
        return this.init(Core.None.__proto__);
    },
    
    updateInfo(elem) {
        var info = document.getElementById('info');
        if (elem.selectionStart == elem.selectionEnd) {
            info.innerHTML = elem.selectionStart + '/' + elem.textLength;
        } else {
            info.innerHTML = elem.selectionStart + '-' elem.selectionEnd + '/' + elem.textLength;
        }
    },
    
}.init();
