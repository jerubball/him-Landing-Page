
const Script = {
    
    init() {
        
        this.init = Core.init;
        return this.init(Core.None.__proto__);
    },
    
    getHourNumber(hour) {
        if (hour > 1 && hour < 12) {
            return hour;
        } else {
            let num = hour % 12;
            return num == 0 ? 12 : num;
        }
    },
    
    setup() {
        var words = {
            "it": document.getElementById("item-it"),
            "is": document.getElementById("item-is"),
            "half": document.getElementById("item-half"),
            "quarter": document.getElementById("item-quarter"),
            "ten": document.getElementById("item-ten"),
            "twenty": document.getElementById("item-twenty"),
            "five": document.getElementById("item-five"),
            "minutes": document.getElementById("item-minutes"),
            "to": document.getElementById("item-to"),
            "past": document.getElementById("item-past"),
            1: document.getElementById("item-1"),
            2: document.getElementById("item-2"),
            3: document.getElementById("item-3"),
            4: document.getElementById("item-4"),
            5: document.getElementById("item-5"),
            6: document.getElementById("item-6"),
            7: document.getElementById("item-7"),
            8: document.getElementById("item-8"),
            9: document.getElementById("item-9"),
            10: document.getElementById("item-10"),
            11: document.getElementById("item-11"),
            12: document.getElementById("item-12"),
            "noon": document.getElementById("item-noon"),
            "midnight": document.getElementById("item-midnight"),
            "clock": document.getElementById("item-clock"),
            "am": document.getElementById("item-am"),
            "pm": document.getElementById("item-pm"),
        };
        var timer = setInterval(function () {
            let now = new Date();
            words[Script.getHourNumber(now.getHours())].classList.add("active");
        }, 250);
    },
    
}.init();
