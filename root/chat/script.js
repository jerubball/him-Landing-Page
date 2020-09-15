
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
                        Script.updateInfo(this.response['users']);
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
    
    updateInfo(users) {
        var info = document.getElementById('info');
        info.innerHTML = users + ' online';
    },
    
    append(data) {
        if (data.length > 0) {
            var chatarea = document.getElementById('chat-area');
            for (var i = 0; i < data.length; i++) {
                // && data[i].length > 0
                //var parts = data[i].trim().split('\t');
                //if (parts.length == 4) {
                // process successful entry [timestamp, ip, name, text]
                var row = document.createElement('div');
                row.id = chatarea.childElementCount;
                row.classList.add('row');
                row.classList.add('mr-0');
                row.classList.add('pl-1');
                chatarea.appendChild(row);
                var col = document.createElement('div');
                col.classList.add('col-md-12');
                row.appendChild(col);
                var name = document.createElement('p');
                name.classList.add('m-0');
                name.innerHTML = data[i]['name'] + ' (' + data[i]['ip'] + ') @ ' + new Date(data[i]['time'] * 1000).toLocaleString();
                col.appendChild(name);
                var entry = document.createElement('p');
                entry.classList.add('chat-text', 'px-1', 'm-0', 'mr-2');
                if (data[i]['text'] && data[i]['text'].trim().length > 0) {
                    entry.innerText = data[i]['text'];
                } else {
                    entry.innerText = '\u00A0';
                }
                col.appendChild(entry);
                //}
            }
        }
    },
    
}.init();
