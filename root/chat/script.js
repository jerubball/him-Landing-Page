
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
        var data = encodeURIComponent(input.value);
        var xmlhttp = new XMLHttpRequest ();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText.length > 0) {
                    if (this.responseText[0] != '0') {
                        alert(this.responseText.substr(2));
                    } else {
                        input.value = '';
                    }
                }
            }
        };
        xmlhttp.open('GET', 'send.php?text=' + data, true);
        xmlhttp.send();
        return false;
    },
    
    receive() {
        var xmlhttp = new XMLHttpRequest ();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText.length > 0) {
                    if (this.responseText[0] != '0') {
                        console.log(this.responseText.substr(2));
                    } else {
                        Script.append(this.responseText);
                    }
                }
            }
        };
        xmlhttp.open('GET', 'receive.php', true);
        xmlhttp.send();
        return false;
    },
    
    append(data) {
        if (data.length > 0) {
            var chatarea = document.getElementById('chat-area');
            var lines = data.split('\n');
            for (var i = 1; i < lines.length && lines[i].length > 0; i++) {
                var parts = lines[i].trim().split('\t');
                if (parts.length == 4) {
                    // process successful entry [timestamp, ip, name, text]
                    var row = document.createElement('div');
                    row.id = chatarea.childElementCount;
                    row.classList.add('row');
                    chatarea.appendChild(row);
                    var col = document.createElement('div');
                    col.classList.add('col-md-12');
                    row.appendChild(col);
                    var name = document.createElement('p');
                    name.classList.add('m-0');
                    name.innerHTML = parts[2] + " (....) @ " + parts[0];
                    col.appendChild(name);
                    var entry = document.createElement('p');
                    entry.classList.add('chat-text', 'px-1', 'm-0', 'mr-2');
                    entry.innerText = parts[3];
                    col.appendChild(entry);
                }
            }
        }
    },
    
}.init();
