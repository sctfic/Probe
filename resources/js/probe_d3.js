function graphe (div, width, height, margin, data, labelX, labelY, ticksX, ticksY, formatDate, genLine, genArea)
{
    // Var for the loops
    var j;

    // Nb sensors
    var nb_sensors = data[0].length - 1;
    
    // Projection functions for convenience
    function date(e) { return d3.time.format.iso.parse(e[0]); };
    function valeur(e, i) { return e[i]; };
    
    // Extent of the datas
    var xs = d3.extent(data, date);   // returns array of [minimum, maximum]
    var ys = d3.extent(data, function(e) { return valeur(e, 1); });
	var ysi;
	
	for(j=2; j<=nb_sensors; j++)
	{
		ysi = d3.extent(data, function(e) { return valeur(e, j); });
		ys = [Math.min(ys[0], ysi[0]), Math.max(ys[1], ysi[1])];
	}
    
    // Scales functions
    var xScale = d3.time.scale().domain(xs).range([margin, width - margin]);
    var yScale = d3.scale.linear().domain(ys).range([height - margin, margin]).nice();
    
    // Scales applied to datas
    function xx(e) { return xScale(date(e)); };
    function yy(e, i) { return yScale(valeur(e, i)); };
    
    // Create SVG element
    var svg = d3.select("#"+div).append("svg").attr("width", width).attr("height", height);
    
    // Define and create X axis
    var xAxis = d3.svg.axis()
    .scale(xScale)
    .orient("bottom")
    .ticks(ticksX)
    .tickFormat(d3.time.format(formatDate))
    .tickSize(2 * margin - height);
    
    svg.append("g")
    .attr("class", "axis")
    .attr("transform", "translate(0," + (height - margin) + ")")
    .call(xAxis)
    .append("text")
    .attr("x", width - margin)
    .attr("y", 3 * margin / 5)
    .text(labelX);
    
    // Define and create Y axis
    var yAxis1 = d3.svg.axis()
    .scale(yScale)
    .orient("left")
    .ticks(ticksY)
    .tickSize((margin * 2 - width));
    
    var yAxis2 = d3.svg.axis()
    .scale(yScale)
    .orient("right")
    .ticks(ticksY)
    .tickSize(0);
    
    svg.append("g")
    .attr("class", "axis")
    .attr("transform", "translate(" + margin + ",0)")
    .call(yAxis1)
    .append("text")
    .attr("transform", "rotate(-90)")
    .attr("y", - 3 * margin / 5)
    .style("text-anchor", "end")
    .text(labelY);
    
    svg.append("g")
    .attr("class", "axis")
    .attr("transform", "translate(" + (width - margin) + ",0)")
    .call(yAxis2);
    
    // Define and create lines
    if (genLine)
    {
        var color = d3.scale.category10();
		var linej;
        
		for(j=1; j<=nb_sensors; j++)
		{
			linej = d3.svg.line()
			.interpolate("basis")
			.x(xx)
			.y(function(e) { return yy(e, j); });
        
			svg.append("g")
			.append("path")
			.attr("class", "line")
			.datum(data)
			.attr("d", linej)
			.style("stroke", function(e) { return color(j); });
		}
    }
    
    // Define and create areas
    if (genArea)
    {
		var areaj;
        
		for(var j=1; j<=nb_sensors; j++)
		{
			areaj = d3.svg.area()
			.interpolate("basis")
			.x(xx)
			.y0(height - margin)
			.y1(function(e) { return yy(e, j); });
        
			svg.append("g")
			.append("path")
			.attr("class", "path" + j)
			.datum(data)
			.attr("d", areaj);
		}
    }
}