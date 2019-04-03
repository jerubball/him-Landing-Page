
function setTitle(text) {
    var host = window.location.hostname;
    var prefix = "";
    if (host.includes("hasol.co")) {
        prefix = "hasol.co";
    } else if (host.includes("ddns.net")) {
        prefix = "him-NYIT";
    }
    document.title = prefix + ": " + text;
}

function setProtocol(proto, root) {
    if (root) {
        window.location.href = proto + "//" + window.location.hostname;
    } else if (window.location.protocol != proto) {
        window.location.protocol = proto;
    }
}

function toggleProtocol() {
    if (window.location.protocol == "http:") {
        window.location.protocol = "https:";
    } else if (window.location.protocol == "https:") {
        window.location.protocol = "http:";
    }
}

function setHostname(name, root) {
    if (root) {
        window.location.href = window.location.proto + "//" + name;
    } else if (window.location.hostname != name) {
        window.location.hostname = name;
    }
}

function setFullScreen(state) {
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

function toggleFullscreen() {
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