	var str = '';
	function recursiveFunction(key, val, id) {
		var type = $.type (val);
		id += '_'+key;
		if (type==='object' || type==='array') {
			str += '<li id="' + id + '" class="' + type + '"><a href="#">' + key + "</a>\n";
			str += "<ul>\n";
				$.each(val, function(k, v) { recursiveFunction(k, v, id); });
			str += "</ul>\n";
			str += "</li>\n";
		}
		else str += '<li id="' + id + '" class="' + type + '"><a href="#">' + key + ' = ' + val + "</a></li>\n";
	}

