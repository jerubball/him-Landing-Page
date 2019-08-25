
const Core = Object.freeze({
    
    
    Window: Object.freeze({
        
        setTitle(text) {
            var host = location.hostname;
            var prefix = '';
            if (host.includes('localhost')) {
                prefix = 'localhost';
            } else if (host.includes('hasol.co')) {
                prefix = 'hasol.co';
            } else if (host.includes('ddns.net')) {
                prefix = 'him-NYIT';
            } else {
                prefix = 'him';
            }
            document.title = prefix + ': ' + text;
        },
        
        setProtocol(proto, root) {
            if (root) {
                location.href = proto + '//' + location.hostname;
            } else if (location.protocol != proto) {
                location.protocol = proto;
            }
        },
        
        getSSLmode() {
            return location.protocol == 'https:';
        },
        
        setSSLindicator(item) {
            if (Core.Window.getSSLmode()) {
                item.classList.add('active');
                item.setAttribute('aria-pressed', true);
            }
        },
        
        toggleProtocol() {
            if (location.protocol == 'http:') {
                location.protocol = 'https:';
            } else if (location.protocol == 'https:') {
                location.protocol = 'http:';
            }
        },
        
        setHostname(name, root) {
            if (root) {
                location.href = location.protocol + '//' + name;
            } else if (location.hostname != name) {
                location.hostname = name;
            }
        },
        
        setFullScreen(state) {
            var current = document.fullscreen || document.mozFullScreenElement || document.webkitFullscreenElement || document.msFullscreenElement;
            if (state && !current) {
                if (document.documentElement.requestFullscreen) {
                    document.documentElement.requestFullscreen();
                } else if (document.documentElement.mozRequestFullScreen) {
                    document.documentElement.mozRequestFullScreen();
                } else if (document.documentElement.webkitRequestFullscreen) {
                    document.documentElement.webkitRequestFullscreen();
                } else if (document.documentElement.msRequestFullscreen) {
                    document.documentElement.msRequestFullscreen();
                }
            } else if (!state && current) {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                } else if (document.mozCancelFullScreen) {
                    document.mozCancelFullScreen();
                } else if (document.webkitExitFullscreen) {
                    document.webkitExitFullscreen();
                } else if (document.msExitFullscreen) {
                    document.msExitFullscreen();
                }
            }
        },
        
        toggleFullscreen() {
            if (document.fullscreen || document.mozFullScreenElement || document.webkitFullscreenElement || document.msFullscreenElement) {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                } else if (document.mozCancelFullScreen) {
                    document.mozCancelFullScreen();
                } else if (document.webkitExitFullscreen) {
                    document.webkitExitFullscreen();
                } else if (document.msExitFullscreen) {
                    document.msExitFullscreen();
                }
            } else {
                if (document.documentElement.requestFullscreen) {
                    document.documentElement.requestFullscreen();
                } else if (document.documentElement.mozRequestFullScreen) {
                    document.documentElement.mozRequestFullScreen();
                } else if (document.documentElement.webkitRequestFullscreen) {
                    document.documentElement.webkitRequestFullscreen();
                } else if (document.documentElement.msRequestFullscreen) {
                    document.documentElement.msRequestFullscreen();
                }
            }
        },
        
        param: new URLSearchParams(location.search),
        
    }),
    
    
    Math: Object.freeze({
        
        randomInt(min, max, inclusive) {
            if (max === undefined) {
                return Math.floor(Math.random() * min);
            } else {
                if (inclusive === true) {
                    max += 1;
                }
                return Math.floor(Math.random() * (max - min)) + min;
            }
        },
        
    }),
    
    
    Util: Object.freeze({
        
        arrayIndex (arr, item) {
            for (var i = 0; i < arr.length; i++) {
                if (arr[i] === item) {
                    return i;
                }
            }
        },
        
        objectIndex (obj, item) {
            var keys = Object.keys(obj);
            for (var i = 0; i < keys.length; i++) {
                if (obj[keys[i]] === item) {
                    return keys[i];
                }
            }
        },
        
        strnatcasecmp (a, b) {
            return a.localeCompare(b, undefined, {numeric: true, sensitivity: 'base'});
        },
        
        sortTable(elem) {
            if (elem.tagName.toLowerCase() != "th") {
                return; // stop if not head
            }
            var table = elem.parentElement.parentElement.parentElement;
            if (table.tagName.toLowerCase() != "table" || !table.classList.contains('sortable')) {
                return; // stop if not table or not sortable
            }
            var head = table.tHead.rows[0];
            var column = Core.Util.arrayIndex(elem.parentElement.cells, elem);
            if (elem.classList.contains('sorted')) {
                elem.classList.replace('asc', 'desc') || elem.classList.replace('desc', 'asc') || elem.classList.add('asc');
            } else {
                for (var i = 0; i < head.children.length; i++) {
                    head.children[i].classList.remove('sorted');
                }
                elem.classList.add('sorted');
            }
            var mode = elem.classList.contains('asc') ? 1 : cell.classList.contains('desc') ? -1 : 0;
            var sorter = function(a, b) {
                return mode * Core.Util.strnatcasecmp(a['data'], b['data']);
            };
            var getData = function(body) {
                var arr = [];
                for (var i = 0; i < body.rows.length; i++) {
                    arr.push({'index': i, 'html': body.rows[i].innerHTML,'data': body.rows[i].cells[column].dataset['sort']});
                }
                return arr;
            };
            for (var i = 0; i < table.tBodies.length; i++) {
                var data = getData(table.tBodies[i]);
                data.sort(sorter);
                for (var j = 0; j < data.length; i++) {
                    table.tBodies[i].rows[j].innerHTML = data[i]['html'];
                }
            }
            return false;
        },
        
    }),
    
    
    Script: {},
    
    Local: {},
    
    Data: {},
    
});


/*
const Super = class {};
const Super = function() {};
class Super {
    static #Sub = class {
    };
    static get Sub() {
        return Super.#Sub;
    }
}
const Super = Object.freeze({Sub: class{},});
Object.defineProperties(Super, {Sub: {value: class{}, writable: false, enumerable: false, configurable: false}, Subs: {value: function(){}}});
*/