
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
        var request = new XMLHttpRequest ();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if (this.response && this.response instanceof Object) {
                    if (this.response['code'] === 0) {
                        input.value = '';
                    } else {
                        alert(this.response['status']);
                        console.log(this.response);
                    }
                }
            }
        };
        request.responseType = 'json';
        request.open('GET', 'send.php?text=' + data, true);
        request.send();
        return false;
    },
    
    receive() {
        var request = new XMLHttpRequest ();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if (this.response && this.response instanceof Object) {
                    if (this.response['code'] === 0) {
                        Script.append(this.response['data']);
                    } else {
                        //alert(this.response['status']);
                        console.log(this.response);
                    }
                }
            }
        };
        request.responseType = 'json';
        request.open('GET', 'receive.php', true);
        request.send();
        return false;
    },
    
    append(data) {
        if (data.length > 0) {
            var chatarea = document.getElementById('chat-area');
            for (var i = 0; i < data.length && data[i].length == 4; i++) {
                //var parts = data[i].trim().split('\t');
                //if (parts.length == 4) {
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
                name.innerHTML = data[i][2] + " (....) @ " + data[i][0];
                col.appendChild(name);
                var entry = document.createElement('p');
                entry.classList.add('chat-text', 'px-1', 'm-0', 'mr-2');
                entry.innerText = data[i][3];
                col.appendChild(entry);
                //}
            }
        }
    },
    
}.init();
