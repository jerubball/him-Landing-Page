
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
        
        randomInt(min, max) {
            if (max === undefined) {
                return Math.floor(Math.random() * min);
            } else {
                return Math.floor(Math.random() * (max - min)) + min;
            }
        },
        
    }),
    
    
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