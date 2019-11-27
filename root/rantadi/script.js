
const Script = Object.freeze({
    
    // set all qualifying CheckBox to state.
    setCheckBox(tag, type, tower, index, check) {
        var all = document.getElementsByTagName(tag);
        for (var i = 0; i < all.length; i++) {
            if (all[i].type == type && all[i].dataset['tower'] == tower && all[i].dataset['index'] == index) {
                all[i].checked = check;
            }
        }
    },
    
    // get CheckBox state from first matching CheckBox.
    getCheckBox(tag, type, tower, index) {
        var all = document.getElementsByTagName(tag);
        for (var i = 0; i < all.length; i++) {
            if (all[i].type == type && all[i].dataset['tower'] == tower && all[i].dataset['index'] == index) {
                return all[i].checked;
            }
        }
    },
    
    // update all mission related radio button.
    updateRadioButton(tag, type, tower) {
        var tables = document.getElementsByTagName('FORM');
        for (var i = 0; i < tables.length; i++) {
            var mission = tables[i].dataset['mission'], element = document.getElementById(mission);
            var all = tables[i].getElementsByTagName(tag);
            if (element != null) {
                if (mission == 'location') {
                    var state = false;
                    for (var j = 0; !state && j < all.length; j++) {
                        if (all[j].type == type && all[j].dataset['mission'] == mission && all[j].dataset['tower'] == tower) {
                            state = all[j].checked;
                        }
                    }
                    if (state) {
                        for (var j = 0; state && j < all.length; j++) {
                            if (all[j].type == type && all[j].dataset['mission'] == mission && all[j].dataset['tower'] == tower) {
                                state = all[j].checked;
                            }
                        }
                        if (state) {
                            element.checked = true;
                        }
                    }
                } else {
                    var state = true;
                    for (var j = 0; state && j < all.length; j++) {
                        if (all[j].type == type && all[j].dataset['mission'] == mission) {
                            state = all[j].checked;
                        }
                    }
                    if (state) {
                        element.checked = true;
                    }
                }
            }
        }
    },
    
    // Toggle all other CheckBox when CheckBox is clicked.
    toggleCheckBoxClicked(item) {
        var data = item.dataset;
        this.setCheckBox(item.nodeName, item.type, data['tower'], data['index'], item.checked);
        this.updateRadioButton(item.nodeName, item.type, data['tower']);
    },
    
    // Toggle all matching CheckBox when image is clicked.
    toggleImageClicked(item) {
        var tag = 'INPUT', type = 'checkbox', data = item.dataset;
        var check = !this.getCheckBox(tag, type, data['tower'], data['index']);
        this.setCheckBox(tag, type, data['tower'], data['index'], check);
        this.updateRadioButton(tag, type, data['tower']);
    },
    
    // Choose between functions.
    toggleClicked(item) {
        if (item.nodeName == 'INPUT' && item.type == 'checkbox') {
            this.toggleCheckBoxClicked(item);
        } else {
            this.toggleImageClicked(item);
        }
    },
    
});