
const Script = {
    
    init: Core.init,
    
    mode: Core.Window.param.has('mode') ? Core.Window.param.get('mode') : 'sequence',
    charset: Core.Window.param.has('charset') ? Core.Window.param.get('charset') : 'Il|',
    min: Core.Window.param.has('min') ? parseInt(Core.Window.param.get('min')) : 0,
    max: Core.Window.param.has('max') ? parseInt(Core.Window.param.get('max'))+1 : 101,
    
    update(id) {
        var elem = document.getElementById(id);
        var size = Core.Math.randomInt(this.min, this.max);
        var result = '';
        for (var i = 0; i < size; i++) {
            result += this.charset.charAt(Core.Math.randomInt(this.charset.length));
        }
        elem.innerHTML = result;
    },
    
}.init(Core.None.__proto__);
