
const Script = {
    
    init() {
        
        this.init = Core.init;
        return this.init(Core.None.__proto__);
    },
    
    run() {
        var inputtext = document.getElementById('inputtext');
        var outputtext = document.getElementById('outputtext');
        var errortext = document.getElementById('errortext');
        $('#outputcontainer').collapse('show');
        Script.parse(inputtext, outputtext, errortext);
        return false;
    },
    
    copy() {
        var outputtext = document.getElementById('outputtext');
        var errortext = document.getElementById('errortext');
        if (outputtext.value.length > 0) {
            function alternative() {
                outputtext.select();
                document.execCommand("paste");
                errortext.value = 'Copied to clipboard';
            };
            if (navigator.clipboard.writeText) {
                navigator.clipboard.writeText(outputtext.value).then(
                    () => {errortext.value = 'Copied to clipboard';}, alternative);
            } else {
                alternative();
            }
        } else {
            errortext.value = 'Nothing to copy';
        }
        return false;
    },
    
    parse(inputtext, outputtext, errortext) {
        outputtext.value = '';
        errortext.value = '';
        
        function escapeString(string) {
            return string.replaceAll('\\', '\\\\').replaceAll('"', '\\"');
        }
        
        const keep = {'keep':null, 'remove':null, 'optional':null, 'remove+':null},
            axis = {'vertical':null, 'positive-x':null, 'negative-x':null, 'positive-z':null, 'negative-z':null},
            mode = {'impulse':null, 'chain':null, 'repeat':null},
            auto = {'auto':null, 'manual':null},
            cond = {'conditional':null, 'unconditional':null},
            face = {'up':null, 'down':null, 'east':null, 'north':null, 'west':null, 'south':null};
        
        let cmd = [],
            meta = {},
            entry = {'position': 0};
        
        for (let line of inputtext.value.split('\n')) {
            line = line.trim();
            // command
            if (line.length > 0 && line[0] !== '#') {
                entry['command'] = escapeString(line);
                cmd.push(entry);
                entry = {'position': cmd.length};
            } else if (line.length > 2 && line.substring(0,2) === '#@') {
                // metadata
                var param = line.substr(2).trim();
                if (!('keep' in meta) && param in keep)
                    meta['keep'] = param;
                else if (!('axis' in meta) && param in axis)
                    meta['axis'] = param;
                else if (param.substring(0,7) === 'default') {
                    param = param.substr(7).trim();
                    if (!('mode' in meta) && param in mode)
                        meta['mode'] = param;
                    else if (!('auto' in meta) && param in auto)
                        meta['auto'] = param;
                    else if (!('cond' in meta) && param in cond)
                        meta['cond'] = param;
                    else if (!('face' in meta) && param in face)
                        meta['face'] = param;
                } else {
                    // block speecific data
                    if (!('mode' in entry) && param in mode)
                        entry['mode'] = param;
                    else if (!('auto' in entry) && param in auto)
                        entry['auto'] = param;
                    else if (!('cond' in entry) && param in cond)
                        entry['cond'] = param;
                    else if (!('face' in entry) && param in face)
                        entry['face'] = param;
                }
            }
        }
        
        // skip if no command
        var num = cmd.length;
        if (num > 0) {
            if (num > 250)
                errortext.value += 'Input command of ' + num + ' is more than limit of 250 commands\n';
            
            var horizontal = 'axis' in meta && meta['axis'] !== 'vertical';
            var horizontal
            if (horizontal) {
                var horizontal_dir = meta['axis'][meta['axis'].length-1] === 'x';
                var horizontal_sign = meta['axis'][0] === 'p' ? 1 : -1;
            }
            
            // determine automatic behavior of keep
            if (!('keep' in meta)) {
                if (horizontal)
                    meta['keep'] = 'remove';
                else if ('mode' in meta && meta['mode'] !== 'chain')
                    meta['keep'] = 'keep';
                else {
                    for (let entry of cmd) {
                        if ('mode' in entry && entry['mode'] !== 'chain') {
                            meta['keep'] = 'optional';
                            break;
                        }
                    }
                    if (!('keep' in meta))
                        meta['keep'] = 'remove';
                }
            }
            
            function convert(data) {
                if (data instanceof Array) {
                    var list = [];
                    for (key in data[0])
                        list.push(key + ':' + convert(data[0][key]));
                    return '[{' + list.join(',') + '}]';
                } else if (data instanceof Object) {
                    var list = [];
                    for (key in data)
                        list.push(key + ':' + convert(data[key]));
                    return '{' + list.join(',') + '}';
                } else {
                    return data;
                }
            }
            
            function apply(entry) {
                // generate command object
                if (!('mode' in entry)) {
                    if ('mode' in meta)
                        entry['mode'] = meta['mode']
                    else if (entry['position'] === 0)
                        entry['mode'] = 'impulse';
                    else
                        entry['mode'] = 'chain';
                }
                if (!('auto' in entry)) {
                    if ('auto' in meta)
                        entry['auto'] = meta['auto'];
                    else
                        entry['auto'] = 'auto';
                }
                if (!('cond' in entry)) {
                    if ('cond' in meta)
                        entry['cond'] = meta['cond'];
                    else
                        entry['cond'] = 'unconditional';
                }
                if (!('face' in entry) && 'face' in meta)
                    entry['face'] = meta['face'];
                
                var data = {'id': 'falling_block', 'Time': '1', 'BlockState': {'Name': '"chain_command_block"'}, 'TileEntityData': {}};
                if (entry['mode'] === 'impulse')
                    data['BlockState']['Name'] = '"command_block"';
                else if (entry['mode'] === 'repeat')
                    data['BlockState']['Name'] = '"repeating_command_block"';
                if (entry['cond'] === 'conditional')
                    data['BlockState']['Properties'] = {'condiitional': 'true'};
                else if (!horizontal || 'face' in entry)
                    data['BlockState']['Properties'] = {};
                if (horizontal) {
                    if ('face' in entry)
                        data['BlockState']['Properties']['facing'] = '"' + entry['face'] + '"';
                } else
                    data['BlockState']['Properties']['facing'] = '"down"';
                if (entry['auto'] === 'auto' && entry['mode'] !== 'chain')
                    data['TileEntityData']['auto'] = '1';
                else if (entry['auto'] === 'manual' && entry['mode'] === 'chain')
                    data['TileEntityData']['auto'] = '0';
                data['TileEntityData']['Command'] = '"' + entry['command'] + '"';
                
                if (horizontal) {
                    var wrapper = {'id': 'falling_block', 'Time': '1', 'BlockState': {'Name': '"chain_command_block"', 'Properties': {'facing': '"down"'}}, 'TileEntityData': {}};
                    if (entry['position'] === 0) {
                        wrapper['BlockState']['Name'] = '"command_block"';
                        wrapper['TileEntityData']['auto'] = '1';
                    }
                    var pos = entry['position'] + 1;
                    if (horizontal_dir)
                        var position = (pos * horizontal_sign) + ' ~' + pos + ' ~ ';
                    else
                        var position = ' ~' + pos + ' ~' + (pos * horizontal_sign) + ' ';
                    wrapper['TileEntityData']['Command'] = '"summon falling_block ~' + position + escapeString(convert(data)) + '"'
                    data = wrapper
                }
                
                return {'id': 'armor_stand', 'Invisible': '1', 'Tags': '["CMDSPACER"]', 'Passengers': [data]};
            }
            
            var nsp = meta['keep'] === 'keep' ? num : num + 1;
            var data = null;
            for (entry of cmd) {
                var spacer = apply(entry);
                if (data !== null)
                    spacer['Passengers'][0]['Passengers'] = [data];
                data = spacer;
            }
            var wrapper = {'Time': '1', 'BlockState': {'Name': '"command_block"', 'Properties': {'facing': '"down"'}}, 'TileEntityData': {'auto': '1'}};
            wrapper['TileEntityData']['Command'] = '"kill @e[type=armor_stand,tag=CMDSPACER,sort=nearest,limit=' + nsp + ']"';
            if (meta['keep'] !== 'keep') {
                var spacer = {'id': 'falling_block', 'Time': '1', 'BlockState': {'Name': '"chain_command_block"', 'Properties': {'facing': '"down"'}}, 'TileEntityData': {}, 'Passengers': [data]};
                if (meta['keep'] === 'optional')
                    spacer['BlockState']['Name'] = '"command_block"';
                spacer['TileEntityData']['Command'] = '"fill ~ ~' + (meta['keep'][meta['keep'].length-1] === '+' ? '-2' : '-1') + ' ~ ~ ~' + num + ' ~ air"';
                wrapper['Passengers'] = [{'id': 'armor_stand', 'Invisible': '1', 'Tags': '["CMDSPACER"]', 'Passengers': [spacer]}];
            } else
                wrapper['Passengers'] = [data];
            
            var command = 'summon falling_block ~ ~1 ~ ' + convert(wrapper);
            
            if (command.length > 32500)
                errortext.value += 'Output command of ' + command.length + ' is longer than limit of 32500 characters\n';
            
            outputtext.value = command;
            return command;
            
        } else {
            errortext.value = 'No commands entered\n';
            return null;
        }
    },
    
}.init();
