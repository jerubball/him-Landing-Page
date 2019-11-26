
const Script = Object.freeze({
});

//const format = { localeMatcher: 'best fit', formatMatcher: 'best fit', timeZone: 'UTC', };
//const format = { era: 'short', year: 'numeric', month: 'short', day: '2-digit', weekday: 'short', hour12: 'false', hourCycle: 'h23', hour: '2-digit', minute: '2-digit', second: '2-digit', timeZoneName: 'short' };
const format_date = { era: 'short', year: 'numeric', month: 'short', day: '2-digit', weekday: 'short' };
const format_time = { hour: '2-digit', minute: '2-digit', second: '2-digit', timeZoneName: 'short' };

/** process time unit to milliseconds */
const convertTimeUnit = function(input) {
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
}

/** process time parameter for start time */
const convertTime = function(input) {
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
}

/** process unit parameter for display unit */
const convertUnit = function(input) {
    if (input != null && input != '') {
        if (!isNaN(input)) {
            var result = parseInt(input);
            if (result > 0) {
                return result;
            }
        } else {
            var result = convertTimeUnit(input);
            if (result != null) {
                return result;
            }
        }
    }
    return 3600000;
}

/** process span parameter for duration */
const convertSpan = function(input, timestamp) {
    if (input != null && input != '') {
        if (!isNaN(input)) {
            return parseInt(input) * 1000 - timestamp;
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
                var result = convertTimeUnit(arr[1]);
                if (result != null) {
                    return parseInt(arr[0]) * result;
                }
            }
            var date = new Date(input);
            if (!isNaN(date)) {
                return date.getTime() - timestamp;
            }
        }
    }
    return 3155555556000;
}

/** process base parameter */
const convertBase = function(input) {
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
}

/** process digit parameter */
const convertDigit = function(input, timefactor) {
    if (input != null && input != '' && !isNaN(input)) {
        return parseInt(input);
    }
    if (timefactor > 1E9) {
        return 6;
    } else if (timefactor > 1E7) {
        return 5;
    } else if (timefactor > 1E6) {
        return 4;
    } else {
        return 3;
    }
}

/** process input to escape for HTML */
const convertHTML = function(input, value) {
    if (input != null) {
        input = input.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
        return input.replace(/\\n/g, '<br>').replace(/\\[a-z]/g, '');
    }
    return value;
}

const mode = Core.Window.param.get('mode') == null ? '' : Core.Window.param.get('mode');
const space = convertHTML(Core.Window.param.get('space'), '');
const line = convertHTML(Core.Window.param.get('line'), '<br>');
const timestamp = convertTime(Core.Window.param.get('time'));
const timefactor = convertUnit(Core.Window.param.get('unit'));
const timelapse = convertSpan(Core.Window.param.get('span'), timestamp) + timestamp;
const base = convertBase(Core.Window.param.get('base'));
const digit = convertDigit(Core.Window.param.get('digit'), timefactor);
const locale = 'en-US';

/** add leading zeros to number */
const numberFormat = function(number, size) {
    var str = number.toString();
    while (str.length < size) {
        str = '0' + str;
    }
    return str;
}

/** add trailing zeros to decimal number */
const numberFormatDecimal = function(number) {
    var str = number.toString();
    var dot = str.indexOf('.') + 1;
    if (dot == 0) {
        str += '.';
        dot = str.length;
    }
    for (var pos = str.length - dot; pos < digit; pos++) {
        str += '0';
    }
    return str;
}

/** truncate decimal number to digits */
const numberDigit = function(number) {
    var divisor = Math.pow(10, digit);
    return Math.round(number * divisor) / divisor;
}

/** return only rightmost nonzero digit */
const number10 = function(number) {
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
}

/** format time as the format */
const timeFormat = function(now) {
    var item1 = now.getFullYear() + space + now.toLocaleString(locale, {month: 'short'}).toUpperCase() + space + now.toLocaleString(locale, {day: '2-digit'}) + space + now.toLocaleString(locale, {weekday: 'short'}).toUpperCase() + space;
    var timezone = now.toLocaleTimeString(locale, {timeZoneName: 'short'});
    timezone = timezone.substring(timezone.length - 3).toUpperCase();
    var item2 = space + numberFormat(now.getHours(), 2) + space + numberFormat(now.getMinutes(), 2) + space + timezone + space + numberFormat(now.getSeconds(), 2);
    return item1 + item2;
    //var item = now.toLocaleString(locale, format).toUpperCase();
    //return item.substring(13,17) + space + item.substring(5,8) + space + item.substring(9,11) + space + item.substring(0,3) + space + item.substring(19,21) + space + item.substring(22,24) + space + item.substring(28,31) + space + item.substring(25,27);
}

/**  */
const dateFormat = function(now, str) {
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
                result += (Date.UTC(now.getFullYear(), now.getMonth(), now.getDate()) - Date.UTC(now.getFullYear(), 0, 1)) / convertTimeUnit('day');
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
            
                break;
            // Year
            case 'L': // Whether it's a leap year
            // 1 or 0
            
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
            // 000 through 999
            
                break;
            case 'g': // 12-hour format of an hour without leading zeros
                result += now.toLocaleString(locale, {hour12: true, hour: 'numeric'}).split(' ')[0];
                break;
            case 'G': // 24-hour format of an hour without leading zeros
                result += now.toLocaleString(locale, {hour12: false, hour: 'numeric'});
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
                result += now.toLocaleString(locale, {second: '2-digit'});
                break;
            case 'u': // Microseconds
            
                break;
            case 'v': // Milliseconds
                result += now.getMilliseconds();
                break;
            // Timezone
            case 'e': // Timezone identifier
                result += now.toLocaleString(locale, {timeZoneName: 'long'});
                break;
            case 'I': // Whether or not the date is in daylight saving time
            // 1 or 0
            
                break;
            case 'O': // Difference to Greenwich time (GMT) in hours
            // +0200
            
                break;
            case 'P': // Difference to Greenwich time (GMT) with colon between hours and minutes
            // +02:00
            
                break;
            case 'T': // Timezone abbreviation
                result += now.toLocaleString(locale, {timeZoneName: 'short'});
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
                result += now.valueOf();
                break;
            default:
                result += str[i];
                break;
        }
    }
    return result;
}

const update = function() {
    if (mode == 'unix') {
        return (now) => Math.round(now.getTime() / 1000).toString(base).toUpperCase();
    } else if (mode == 'unix10') {
        return (now) => number10(Math.round(now.getTime() / 1000)).toString(base).toUpperCase();
    } else if (mode == 'countdown') {
        return (now) => numberFormatDecimal(numberDigit((timelapse - now.getTime()) / timefactor));
    } else if (mode == 'countup') {
        return (now) => numberFormatDecimal(numberDigit((now.getTime() - timestamp) / timefactor));
    } else if (mode == 'simple') {
        return (now) => now.toLocaleDateString() + line + now.toLocaleTimeString();
    } else if (mode == 'plain') {
        return (now) => now.toLocaleString(locale, format_date).toUpperCase() + line + now.toLocaleTimeString(locale, format_time).toUpperCase();
    } else if (mode == 'him') {
        return (now) => timeFormat(now);
    }
    return (now) => timeFormat(now);
}

const init = function() {
    var updatefunction = update();
    var timer = setInterval(function() {
        document.getElementById('text').innerHTML = updatefunction(new Date());
    }, 250);
    
    var font = '5vw';
    
    if (mode == 'unix' || mode == 'unix10') {
        if (base > 8) {
            font = '9vw';
        } else if (base > 4) {
            font = '8vw';
        } else if (base > 2) {
            font = '7vw';
        } else {
            font = '4vw';
        }
    } else if (mode == 'countdown' || mode == 'countup') {
        if (timefactor > 3E6) {
            font = '9vw';
        } else if (timefactor > 3E4) {
            font = '8vw';
        } else {
            font = '7vw';
        }
    } else if (mode == 'simple') {
        font = '7vw';
    } else if (mode == 'plain') {
        font = '7vw';
    } else {
        font = '5vw';
    }
    
    document.getElementById('text').style.fontSize = font;
}

const copyElement = function(elem) {
    var select = window.getSelection();
    select.selectAllChildren(elem);
    document.execCommand("copy");
}
