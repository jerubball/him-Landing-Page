
const Script = {
    
    init() {
        this.init = Core.init;
        return this.init(Core.None.__proto__);
    },
    
    collapseAll(id, state) {
        document.querySelectorAll('#' + id + ' a.collapse-control').forEach(function(item) {
            if (item.classList.contains('collapsed') !== state) {
                item.click();
            }
        });
        return false;
    },
    
}.init();
