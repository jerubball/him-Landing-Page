
const Script = {
    
    init() {
        
        this.init = Core.init;
        return this.init(Core.None.__proto__);
    },
    
    roundFive(num) {
        return Math.round(num / 5) * 5;
    },
    
    getItems(hour, minute) {
        var items = {};
        
        let num = this.roundFive(minute > 30 ? 60 - minute : minute);
        if (minute > 30) {
            hour++;
            items['to'] = true;
        } else {
            items['past'] = true;
        }
        if (num == 0) {
            items['clock'] = true;
        } else if (num == 30) {
            items['half'] = true;
        } else if (num == 15) {
            items['quarter'] = true;
        } else {
            items['minutes'] = true;
            if (num == 10) {
                items['ten'] = true;
            } else {
                if (num == 20 || num == 25) {
                    items['twenty'] = true;
                }
                if (num == 5 || num == 25) {
                    items['five'] = true;
                }
            }
        }
        
        let num = hour < 12 ? hour : hour - 12;
        if (hour < 12) {
            items['am'] = true;
        } else {
            items['pm'] = true;
        }
        if (num == 0) {
            items[12] = true;
        } else {
            items[num] = true;
        }
        return items;
    },
    
    setup() {
        var words = {
            'it': document.getElementById('item-it'),
            'is': document.getElementById('item-is'),
            'half': document.getElementById('item-half'),
            'quarter': document.getElementById('item-quarter'),
            'ten': document.getElementById('item-ten'),
            'twenty': document.getElementById('item-twenty'),
            'five': document.getElementById('item-five'),
            'minutes': document.getElementById('item-minutes'),
            'to': document.getElementById('item-to'),
            'past': document.getElementById('item-past'),
            1: document.getElementById('item-1'),
            2: document.getElementById('item-2'),
            3: document.getElementById('item-3'),
            4: document.getElementById('item-4'),
            5: document.getElementById('item-5'),
            6: document.getElementById('item-6'),
            7: document.getElementById('item-7'),
            8: document.getElementById('item-8'),
            9: document.getElementById('item-9'),
            10: document.getElementById('item-10'),
            11: document.getElementById('item-11'),
            12: document.getElementById('item-12'),
            'noon': document.getElementById('item-noon'),
            'midnight': document.getElementById('item-midnight'),
            'clock': document.getElementById('item-clock'),
            'am': document.getElementById('item-am'),
            'pm': document.getElementById('item-pm'),
        };
        let lastItems = {};
        var timer = setInterval(function () {
            if (!words['it'].classList.contains('active') {
                words['it'].classList.add('active');
            }
            if (!words['is'].classList.contains('active') {
                words['is'].classList.add('active');
            }
            let now = new Date();
            let newItems = Script.getItems(now.getHours(), now.getMinutes());
            for (let item in lastItems) {
                if (!(item in newItems)) {
                    item.classList.remove('active');
                    delete lastItems[item];
                }
            }
            for (let item in newItems) {
                if (!(item in newItems)) {
                    item.classList.add('active');
                    lastItems[item] = true;
                }
            }
        }, 250);
    },
    
}.init();
