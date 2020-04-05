
const Script = {
    
    init() {
        this.init = Core.init;
        return this.init(Core.None.__proto__);
    },
    
    start() {
        setInterval(this.receive, 1000);
    },
    
    send() {
        var input = document.getElementById('chat-input');
        var xmlhttp = new XMLHttpRequest ();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                alert(this.responseText);
            }
        };
        xmlhttp.open('GET', 'send.php?text=' + encodeURIComponent(input.value), true);
        xmlhttp.send();
        return false;
    },
    
    receive() {
        return false;
    },
    
}.init();
