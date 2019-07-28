
const Script = Object.freeze({
    
    mode: Core.Window.param.has('mode') ? Core.Window.param.get('mode') : 'sequence',
    charset: Core.Window.param.has('charset') ? Core.Window.param.get('charset') : 'Il|',
    min: Core.Window.param.has('min') ? parseInt(Core.Window.param.get('min')) : 0,
    max: Core.Window.param.has('max') ? parseInt(Core.Window.param.get('max'))+1 : 101,
    
    update(id) {
        var elem = document.getElementById(id);
        var size = Core.Math.randomInt(Script.min, Script.max);
        var result = '';
        for (var i = 0; i < size; i++) {
            result += Script.charset.charAt(Core.Math.randomInt(Script.charset.length));
        }
        elem.innerHTML = result;
    },
    
});