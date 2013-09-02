var str = '';
function recursiveFunction(key, val, id) {
	var type = $.type (val);
	if (type==='object' || type==='array') {

		str += '<li id="' + id +'_'+ key + '" class="' + type + '" rel="Grp"><a href="#' + id + '">' + key + "</a>\n";
		str += "<ul>\n";
			$.each(val, function(k, v) { recursiveFunction(k, v, id+'_'+key ); });
		str += "</ul>\n";
		str += "</li>\n";
	}
	else str += '<li id="' + id+'_'+ key  + '" class="' + type + '" rel="Item"><a href="#' + id + '">' + key + ' = ' + val + "</a></li>\n";
console.log('step');
}

