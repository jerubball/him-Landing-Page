
const Script = {
    
    init() {
        this.init = Core.init;
        return this.init(Core.None.__proto__);
    },
    
    colorful(target=document.body, interval=10) {
        var color = {red: 255, green: 0, blue: 0, dec: 'red', inc: 'green', next: 'blue'};
        var next = function() {
            target.style = 'background-color: rgb(' + color.red + ',' + color.green + ',' + color.blue + ');';
            color[color.inc]++;
            color[color.dec]--;
            if (color[color.inc] === 255 || color[color.dec] === 0) {
                var prev = color.dec;
                color.dec = color.inc;
                color.inc = color.next;
                color.next = prev;
            }
        };
        return setInterval(next, interval);
    },
    
}.init();
