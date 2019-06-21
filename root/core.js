
const setTitle = function(text) {
    var host = window.location.hostname;
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
}

const setProtocol = function(proto, root) {
    if (root) {
        window.location.href = proto + '//' + window.location.hostname;
    } else if (window.location.protocol != proto) {
        window.location.protocol = proto;
    }
}

const getSSLmode = function() {
    return window.location.protocol == 'https:';
}

const setSSLindicator = function(item) {
    if (getSSLmode()) {
        item.classList.add('active');
        item.setAttribute('aria-pressed', true);
    }
}

const toggleProtocol = function() {
    if (window.location.protocol == 'http:') {
        window.location.protocol = 'https:';
    } else if (window.location.protocol == 'https:') {
        window.location.protocol = 'http:';
    }
}

const setHostname = function(name, root) {
    if (root) {
        window.location.href = window.location.protocol + '//' + name;
    } else if (window.location.hostname != name) {
        window.location.hostname = name;
    }
}

const setFullScreen = function(state) {
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
}

const toggleFullscreen = function() {
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
}
