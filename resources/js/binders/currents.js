	var str = '';
    function recursiveFunction(key, val) {
       	var type = $.type (val);
        if (type==='object' || type==='array') {
        	str += '<li id="' + key + '" class="' + type + '">' + key + '<ul>';
            $.each(val, function(k, v) { recursiveFunction(k, v) });
            str += '</ul></li>'
        }
        else str += '<li id="' + key + '" class="' + type + '">' + key + ' = ' + val + '</li>';
    }

