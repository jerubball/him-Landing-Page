
const Script = {
    
    init() {
        this.space = this.convertHTML(Core.Window.param.get('space'), '');
        this.line = this.convertHTML(Core.Window.param.get('line'), '<br>');
        
        /** process span parameter for duration */
        this.timelapse = ((input) => {
            if (input != null && input != '') {
                if (!isNaN(input)) {
                    return parseInt(input) * 1000 - this.timestamp;
                } else if (input == 'shorter') {
                    return 2355555600000;
                } else if (input == 'short') {
                    return 2755555560000;
                } else if (input == 'long') {
                    return 3155555556000;
                } else if (input == 'longer') {
                    return 3555555555600;
                } else {
                    var arr = input.split(' ');
                    if (arr.length == 2 && !isNaN(arr[0])) {
                        var result = this.convertTimeUnit(arr[1]);
                        if (result != null) {
                            return parseInt(arr[0]) * result;
                        }
                    }
                    var date = new Date(input);
                    if (!isNaN(date)) {
                        return date.getTime() - this.timestamp;
                    }
                }
            }
            return 3155555556000;
        })(Core.Window.param.get('span')) + this.timestamp;
        
        /** process unit parameter for display unit */
        this.timefactor = ((input) => {
            if (input != null && input != '') {
                if (!isNaN(input)) {
                    var result = parseInt(input);
                    if (result > 0) {
                        return result;
                    }
                } else {
                    var result = this.convertTimeUnit(input);
                    if (result != null) {
                        return result;
                    }
                }
            }
            return 3600000;
        })(Core.Window.param.get('unit'));
        
        /** process digit parameter */
        this.digit = ((input) => {
            if (input != null && input != '' && !isNaN(input)) {
                return parseInt(input);
            }
            if (this.mode == 'unix') {
                return 0;
            }
            if (this.timefactor > 1E9) {
                return 6;
            } else if (this.timefactor > 1E7) {
                return 5;
            } else if (this.timefactor > 1E6) {
                return 4;
            } else {
                return 3;
            }
        })(Core.Window.param.get('digit'));
        
        this.font = (() => {
            if (this.mode == 'unix' || this.mode == 'single') {
                if (this.base > 8) {
                    return '9vw';
                } else if (this.base > 4) {
                    return '8vw';
                } else if (this.base > 2) {
                    return '7vw';
                } else {
                    return '4vw';
                }
            } else if (this.mode == 'countdown' || this.mode == 'countup') {
                if (this.timefactor > 3E6) {
                    return '9vw';
                } else if (this.timefactor > 3E4) {
                    return '8vw';
                } else {
                    return '7vw';
                }
            } else if (this.mode == 'simple') {
                return '7vw';
            } else if (this.mode == 'plain') {
                return '7vw';
            } else {
                return '5vw';
            }
        })();
        
        /** format time as the format */
        this.timeFormat = function(now) {
            var item1 = now.getFullYear() + this.space + now.toLocaleString(this.locale, {month: 'short'}).toUpperCase() + this.space + now.toLocaleString(this.locale, {day: '2-digit'}) + this.space + now.toLocaleString(this.locale, {weekday: 'short'}).toUpperCase() + this.space;
            var timezone = now.toLocaleTimeString(this.locale, {timeZoneName: 'short'});
            timezone = timezone.substring(timezone.length - 3).toUpperCase();
            var item2 = this.space + Core.Math.formatLeading(now.getHours(), 2) + this.space + Core.Math.formatLeading(now.getMinutes(), 2) + this.space + timezone + this.space + Core.Math.formatLeading(now.getSeconds(), 2);
            return item1 + item2;
            //var item = now.toLocaleString(this.locale, format).toUpperCase();
            //return item.substring(13,17) + this.space + item.substring(5,8) + this.space + item.substring(9,11) + this.space + item.substring(0,3) + this.space + item.substring(19,21) + this.space + item.substring(22,24) + this.space + item.substring(28,31) + this.space + item.substring(25,27);
        };
        
        this.update = (() => {
            if (this.mode == 'unix') {
                return (now) => Core.Math.formatTrailing(Core.Math.round(now.getTime() / 1000, this.digit, this.base, Math.floor), this.digit, this.base).toUpperCase();
            } else if (this.mode == 'single') {
                return (now) => this.leastSignificantNumber(Math.round(now.getTime() / 1000), this.base).toUpperCase();
            } else if (this.mode == 'countdown') {
                return (now) => Core.Math.formatTrailing(Core.Math.round((this.timelapse - now.getTime()) / this.timefactor, this.digit), this.digit);
            } else if (this.mode == 'countup') {
                return (now) => Core.Math.formatTrailing(Core.Math.round((now.getTime() - this.timestamp) / this.timefactor, this.digit), this.digit);
            } else if (this.mode == 'simple') {
                return (now) => now.toLocaleDateString() + this.line + now.toLocaleTimeString();
            } else if (this.mode == 'plain') {
                return (now) => now.toLocaleString(locale, this.format_date).toUpperCase() + this.line + now.toLocaleTimeString(locale, this.format_time).toUpperCase();
            } else if (this.mode == 'custom') {
                return (now) => this.convertHTML(this.dateFormat(now, this.format, this.locale));
            } else if (this.mode == 'him') {
                return (now) => this.timeFormat(now);
            }
            return (now) => this.timeFormat(now);
        })();
        
        this.init = Core.init;
        return this.init(Core.None.__proto__);
    },
    
    //format_extra: { localeMatcher: 'best fit', formatMatcher: 'best fit', timeZone: 'UTC', },
    //format_all: { era: 'short', year: 'numeric', month: 'short', day: '2-digit', weekday: 'short', hour12: 'false', hourCycle: 'h23', hour: '2-digit', minute: '2-digit', second: '2-digit', timeZoneName: 'short' },
    format_date: { era: 'short', year: 'numeric', month: 'short', day: '2-digit', weekday: 'short' },
    format_time: { hour: '2-digit', minute: '2-digit', second: '2-digit', timeZoneName: 'short' },
    
    locale: 'en-US',
    
    style: function(input) {
        if (input != null && input != '') {
            return input.split(' ');
        }
        return [];
    }(Core.Window.param.get('style')),
    
    mode: function(input) {
        return input == null ? '' : input;
    }(Core.Window.param.get('mode')),
    
    format: function(input) {
        return input == null ? 'YMdDHiTs' : input.replace(/\\n/g, '\n').replace(/\\t/g, '\t');
    }(Core.Window.param.get('format')),
    
    /** process time parameter for start time */
    timestamp: function(input) {
        if (input != null && input != '') {
            if (!isNaN(input)) {
                return parseInt(input) * 1000;
            } else {
                var date = new Date(input);
                if (!isNaN(date)) {
                    return date.getTime();
                }
            }
        }
        return 855814500000;
    }(Core.Window.param.get('time')),
    
    /** process base parameter */
    base: function(input) {
        if (input != null && input != '') {
            if (!isNaN(input)) {
                var result = parseInt(input);
                if (result > 1 && result < 37) {
                    return result;
                }
            } else if (input == 'binary' || input == 'bin') {
                return 2;
            } else if (input == 'octal' || input == 'oct') {
                return 8;
            } else if (input == 'decimal' || input == 'dec') {
                return 10;
            } else if (input == 'hexadecimal' || input == 'hex') {
                return 16;
            }
        }
        return 10;
    }(Core.Window.param.get('base')),
    
    /** process input to escape for HTML */
    convertHTML(input, value) {
        if (input != null) {
            input = input.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
            return input.replace(/\\n|\n/g, '<br>').replace(/\\t|\t/g, '&emsp;').replace(/\\[a-z]|/g, '');
        }
        return value;
    },
    
    /** process time unit to milliseconds */
    convertTimeUnit(input) {
        if (input == 'second' || input == 'sec') {
            return 1000;
        } else if (input == 'minute' || input == 'min') {
            return 60000;
        } else if (input == 'hour' || input == 'hr') {
            return 3600000;
        } else if (input == 'day') {
            return 86400000;
        } else if (input == 'week' || input == 'wk') {
            return 604800000;
        } else if (input == 'month' || input == 'mo') {
            return 2629743833;
        } else if (input == 'year' || input == 'yr') {
            return 31556926000;
        }
        return null;
    },
    
    /** convert date to php style date format */
    dateFormat(now, str, locale) {
        var result = "";
        for (var i = 0; i < str.length; i++) {
            switch (str[i]) {
                // Day
                case 'd': // Day of the month, 2 digits with leading zeros
                    result += now.toLocaleString(locale, {day: '2-digit'});
                    break;
                case 'D': // A textual representation of a day, three letters
                    result += now.toLocaleString(locale, {weekday: 'short'});
                    break;
                case 'j': // Day of the month without leading zeros
                    result += now.toLocaleString(locale, {day: 'numeric'});
                    break;
                case 'l': // A full textual representation of the day of the week
                    result += now.toLocaleString(locale, {weekday: 'short'});
                    break;
                case 'N': // ISO-8601 numeric representation of the day of the week
                    var num = now.getDay()
                    result += num == 0 ? 7 : num;
                    break;
                case 'S': // English ordinal suffix for the day of the month, 2 characters
                    var num = now.getDate();
                    var temp = num % 10;
                    result += num >= 11 && num <= 13 ? 'th' : temp == 1 ? 'st' : temp == 2 ? 'nd' : temp == 3 ? 'rd' : 'th';
                    break;
                case 'w': // Numeric representation of the day of the week
                    result += now.getDay();
                    break;
                case 'z': // The day of the year, starting from 0
                    result += (Date.UTC(now.getFullYear(), now.getMonth(), now.getDate()) - Date.UTC(now.getFullYear(), 0, 1)) / this.convertTimeUnit('day');
                    break;
                // Week
                case 'W': // ISO-8601 week number of year, weeks starting on Monday
                    break;
                // Month
                case 'F': // A full textual representation of a month, such as January or March
                    result += now.toLocaleString(locale, {month: 'long'});
                    break;
                case 'm': // Numeric representation of a month, with leading zeros
                    result += now.toLocaleString(locale, {month: '2-digit'});
                    break;
                case 'M': // A short textual representation of a month, three letters
                    result += now.toLocaleString(locale, {month: 'short'});
                    break;
                case 'n': // Numeric representation of a month, without leading zeros
                    result += now.toLocaleString(locale, {month: 'numeric'});
                    break;
                case 't': // Number of days in the given month
                    var num = now.getMonth();
                    if (num === 1) {
                        if (new Date(now.getFullYear(), 1, 29).getMonth() === 1) {
                            result += '28';
                        } else {
                            result += '29';
                        }
                    } else if (num === 3 || num === 5 || num === 8 || num === 10) {
                        result += '30';
                    } else if (num === 0 || num === 2 || num === 4 || num === 6 || num === 7 || num === 9 || num === 11) {
                        result += '31';
                    }
                    break;
                // Year
                case 'L': // Whether it's a leap year
                    result += (2 - new Date(now.getFullYear(), 1, 29).getMonth());
                    break;
                case 'o': // ISO-8601 week-numbering year. This has the same value as Y, except that if the ISO week number (W) belongs to the previous or next year, that year is used instead.
                    break;
                case 'Y': // A full numeric representation of a year, 4 digits
                    result += now.toLocaleString(locale, {year: 'numeric'});
                    break;
                case 'y': // A two digit representation of a year
                    result += now.toLocaleString(locale, {year: '2-digit'});
                    break;
                // Time
                case 'a': // Lowercase Ante meridiem and Post meridiem
                    result += now.toLocaleString(locale, {hour12: true, hour: 'numeric'}).split(' ')[1].toLowerCase();
                    break;
                case 'A': // Uppercase Ante meridiem and Post meridiem
                    result += now.toLocaleString(locale, {hour12: true, hour: 'numeric'}).split(' ')[1];
                    break;
                case 'B': // Swatch Internet time
                    var num = Math.floor((now.getMilliseconds() / 1000 + now.getSeconds() + now.getMinutes() * 60 + now.getHours() * 3600) / 86.4);
                    result += Core.Math.formatLeading(num, 3);
                    break;
                case 'g': // 12-hour format of an hour without leading zeros
                    result += now.toLocaleString(locale, {hour12: true, hour: 'numeric'}).split(' ')[0];
                    break;
                case 'G': // 24-hour format of an hour without leading zeros
                    //result += now.toLocaleString(locale, {hour12: false, hour: 'numeric'});
                    result += now.getHours();
                    break;
                case 'h': // 12-hour format of an hour with leading zeros
                    result += now.toLocaleString(locale, {hour12: true, hour: '2-digit'}).split(' ')[0];
                    break;
                case 'H': // 24-hour format of an hour with leading zeros
                    result += now.toLocaleString(locale, {hour12: false, hour: '2-digit'});
                    break;
                case 'i': // Minutes with leading zeros
                    result += now.toLocaleString(locale, {minute: '2-digit'});
                    break;
                case 's': // Seconds with leading zeros
                    //result += now.toLocaleString(locale, {second: '2-digit'});
                    var num = now.toLocaleString(locale, {second: '2-digit'});
                    result += num.length === 1 ? '0' + num : num;
                    break;
                case 'u': // Microseconds
                    break;
                case 'v': // Milliseconds
                    result += now.getMilliseconds();
                    break;
                // Timezone
                case 'e': // Timezone identifier
                    var num = now.toLocaleString(locale).length;
                    result += now.toLocaleString(locale, {timeZoneName: 'long'}).substr(num + 1);
                    break;
                case 'I': // Whether or not the date is in daylight saving time
                // 1 or 0
                
                    break;
                case 'O': // Difference to Greenwich time (GMT) in hours
                    var num = -now.getTimezoneOffset() / 0.6;
                    result += Core.Math.formatLeading(num, 4, undefined, true);
                    break;
                case 'P': // Difference to Greenwich time (GMT) with colon between hours and minutes
                    var num = -now.getTimezoneOffset() / 0.6;
                    num = Core.Math.formatLeading(num, 4, undefined, true);
                    result += num.substr(0, 3) + ':' + num.substr(3);
                    break;
                case 'T': // Timezone abbreviation
                    //result += now.toLocaleString(locale, {timeZoneName: 'short'}).substr(-3);
                    var num = now.toLocaleString(locale).length;
                    result += now.toLocaleString(locale, {timeZoneName: 'short'}).substr(num + 1);
                    break;
                case 'Z': // Timezone offset in seconds. The offset for timezones west of UTC is always negative, and for those east of UTC is always positive.
                    result += now.getTimezoneOffset() * 60;
                    break;
                // Full Date/Time
                case 'c': // ISO 8601 date
                    result += now.toISOString();
                    break;
                case 'r': // RFC 2822 formatted date
                    result += now.toString();
                    break;
                case 'U': // Seconds since the Unix Epoch (January 1 1970 00:00:00 GMT)
                    result += Math.floor(now.valueOf() / 1000);
                    break;
                default:
                    result += str[i];
                    break;
            }
        }
        return result;
    },
    
    /** return only rightmost nonzero digit */
    leastSignificantNumber(number, base = 10) {
        if (typeof(number) !== 'number') {
            number = Number(number);
        }
        var str = number.toString(base);
        for (var i = str.length - 1; i > 0; i--) {
            if (str[i] !== '.' && str[i] !== '0') {
                return str.substring(i);
            }
        }
        return str; // gurarenteed to have nonempty string
    },
    
    copyElement(elem) {
        var select = window.getSelection();
        select.selectAllChildren(elem);
        document.execCommand("copy");
    },
    
    setup() {
        var update = this.update;
        var timer = setInterval(function() {
            document.getElementById('text').innerHTML = update(new Date());
        }, 250);
        
        for (var i = 0; i < this.style.length; i++) {
            document.documentElement.classList.add('style-' + this.style[i]);
        }
        
        document.getElementById('text').style.fontSize = this.font;
    },
    
}.init();


/*
    numberFormat(number, size) {
        var str = number.toString();
        while (str.length < size) {
            str = '0' + str;
        }
        return str;
    },
    numberFormatDecimal(number) {
        var str = number.toString();
        var dot = str.indexOf('.') + 1;
        if (dot == 0) {
            str += '.';
            dot = str.length;
        }
        for (var pos = str.length - dot; pos < this.digit; pos++) {
            str += '0';
        }
        return str;
    },
    leastSignificantNumber(number, base) {
        if (number > 0) {
            var count = 0;
            while (number % base == 0) {
                number /= base;
                count++;
            }
            number %= base;
            while (count-- > 0) {
                number *= base;
            }
            return number;
        } else {
            return 0;
        }
    },
    leastSignificantNumber(number, base = 10) {
        if (typeof(number) !== 'number') {
            number = Number(number);
        }
        var str = number.toString(base).split('');
        for (var i = str.length - 1; i > 0; i--) {
            if (str[i] !== '.' && str[i] !== '0') {
                return str.splice(i).join('');
            } else if (str[i] !== '.') {
                str[i] = '0';
            }
        }
        return str.join(''); // gurarenteed to have nonempty string
    },
*/
