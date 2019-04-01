
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