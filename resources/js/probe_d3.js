function graphe (div, width, height, margin, datas, labelX, labelY, ticksX, ticksY, formatDate, genLine, genArea, genZoom)
{
	// Var for loops
	var j;

    // Nb sensors
	var nb_sensors = datas[0].length - 1;

    // Projection functions for convenience
    function date(e) { return d3.time.format.iso.parse(e[0]); };
    function valeur(e, i) { return e[i]; };

    // Extent of the datas - returns array of [minimum, maximum]
    var xs = d3.extent(datas, date);
    var ys = d3.extent(datas, function(e) { return valeur(e, 1); });
	var ysi;

	for(j=2; j<=nb_sensors; j++)
	{
		ysi = d3.extent(datas, function(e) { return valeur(e, j); });
		ys = [Math.min(ys[0], ysi[0]), Math.max(ys[1], ysi[1])];
	}

    // Margin and height for context
    // Coefficient applied to height
    // Scales functions
    // Scales applied to datas
    var coeffHeight = 1;

    var xScale = d3.time.scale().domain(xs).range([margin, width - margin]);
    var yScale = d3.scale.linear().domain(ys).range([height - margin, margin]).nice();

    function xx(e) { return xScale(date(e)); };
    function yy(e, i) { return yScale(valeur(e, i)); };

    if (genZoom)
	{
		var marginContext = margin / 5;
        var heightContext = height / 5;
        coeffHeight = 1.2;

        var xScaleContext = d3.time.scale().domain(xs).range([margin, width - margin]);
        var yScaleContext = d3.scale.linear().domain(ys).range([heightContext - marginContext, marginContext]).nice();

        function xxContext(e) { return xScaleContext(date(e)); };
        function yyContext(e, i) { return yScaleContext(valeur(e, i)); };
	}

    // Create SVG element
    var svg = d3.select("#"+div).append("svg").attr("width", width).attr("height", height * coeffHeight);

    // Define lines and areas
    if (genLine)
	{
        function line(i)
        { return d3.svg.line()
            .interpolate("basis")
            .x(xx)
            .y(function(e) { return yy(e, i); });
        };
        var focusLine = new Array();
        var color = d3.scale.category10();
        if (genZoom)
            var zoomLine;
	}

    if (genArea)
	{
        function area(i)
        { return d3.svg.area()
            .interpolate("basis")
            .x(xx)
            .y0(height - margin)
            .y1(function(e) { return yy(e, i); });
        };
        var focusArea = new Array();
        if (genZoom)
            var zoomArea;
	}
    
	// Create context element
    if (genZoom)
        var context = svg.append("g").attr("transform", "translate(0 ," + (height - margin - marginContext) + ")");

    // For all sensors
    for(j=1; j<=nb_sensors; j++)
    {
        if (genLine)
        {
            // Define zoom area
            svg.append("defs").append("clipPath")
            .attr("id", "line" + j + "-clip")
            .append("rect")
            .attr("x", margin)
            .attr("y", margin)
            .attr("width", width - (2 * margin))
            .attr("height", height - (2 * margin));

            // Create focus element
            focusLine[j] = svg.append("g").attr("transform", "translate(0 ," + (-margin) + ")");

            // Add line and zoom area to focus element
            eval(focusLine[j]).append("path")
            .attr("class", "line")
            .attr("transform", "translate(0 ," + margin + ")")
            .datum(datas)
            .attr("clip-path", "url(#line" + j + "-clip)")
            .attr("d", line(j))
            .style("stroke", function(e) { return color(j); });

            if (genZoom)
            {
                // Add line to context element
                zoomLine = d3.svg.line()
                .interpolate("basis")
                .x(xxContext)
                .y(function(e) { return yyContext(e, j); });

                context.append("g")
                .attr("transform", "translate(0," + marginContext + ")")
                .append("path")
                .attr("class", "line")
                .datum(datas)
                .attr("d", zoomLine)
                .style("stroke", function(e) { return color(j); });
            }
        }

        if (genArea)
        {
            // Define zoom area
            svg.append("defs").append("clipPath")
            .attr("id", "area" + j + "-clip")
            .append("rect")
            .attr("x", margin)
            .attr("y", margin)
            .attr("width", width - (2 * margin))
            .attr("height", height - (2 * margin));

            // Create focus element
            focusArea[j] = svg.append("g").attr("transform", "translate(0 ," + (-margin) + ")");

            // Add area and zoom area to focus element
            eval(focusArea[j]).append("path")
            .attr("class", "path" + j)
            .attr("transform", "translate(0 ," + margin + ")")
            .datum(datas)
            .attr("clip-path", "url(#area" + j + "-clip)")
            .attr("d", area(j));

            if (genZoom)
            {
                // Add area to context element
                zoomArea = d3.svg.area()
                .interpolate("basis")
                .x(xxContext)
                .y0(heightContext - marginContext)
                .y1(function(e) { return yyContext(e, j); });

                context.append("path")
                .attr("transform", "translate(0," + marginContext + ")")
                .attr("class", "path" + j)
                .datum(datas)
                .attr("d", zoomArea);
            }
        }
    }

    // Define and create X-Y axis for focus
    if (genLine || genArea)
    {
        var xAxis = d3.svg.axis()
        .scale(xScale)
        .orient("bottom")
        .ticks(ticksX)
        .tickFormat(d3.time.format(formatDate))
        .tickSize((2 * margin) - height);

        var yAxis1 = d3.svg.axis()
        .scale(yScale)
        .orient("left")
        .ticks(ticksY)
        .tickSize((2 * margin) - width);

        var yAxis2 = d3.svg.axis()
        .scale(yScale)
        .orient("right");
    }

    if (genLine)
    {
        eval(focusLine[1]).append("g")
        .attr("class", "x axis")
        .attr("transform", "translate(0, " + height + ")")
        .call(xAxis)
        .append("text")
        .attr("x", width - margin)
        .attr("y", margin / 5)
        .text(labelX);

        eval(focusLine[1]).append("g")
        .attr("class", "y axis")
        .attr("transform", "translate(" + margin + ", " + margin + ")")
        .call(yAxis1)
        .append("text")
        .attr("transform", "rotate(-90)")
        .attr("y", - 3 * margin / 5)
        .style("text-anchor", "end")
        .text(labelY);

        eval(focusLine[1]).append("g")
        .attr("class", "y axis")
        .attr("transform", "translate(" + (width + margin) + ",0)")
        .call(yAxis2);
    }
    else if (genArea)
    {
        eval(focusArea[1]).append("g")
        .attr("class", "x axis")
        .attr("transform", "translate(0, " + height + ")")
        .call(xAxis)
        .append("text")
        .attr("x", width - margin)
        .attr("y", margin / 5)
        .text(labelX);

        eval(focusArea[1]).append("g")
        .attr("class", "y axis")
        .attr("transform", "translate(" + margin + ", " + margin + ")")
        .call(yAxis1)
        .append("text")
        .attr("transform", "rotate(-90)")
        .attr("y", - 3 * margin / 5)
        .style("text-anchor", "end")
        .text(labelY);

        eval(focusArea[1]).append("g")
        .attr("class", "y axis")
        .attr("transform", "translate(" + (width + margin) + ",0)")
        .call(yAxis2);
    }

    if (genZoom)
    {
        // Define and create X axis for context
        var xContextAxis = d3.svg.axis()
        .scale(xScaleContext)
        .orient("bottom")
        .tickFormat(d3.time.format(formatDate));

        context.append("g")
        .attr("class", "x axis")
        .attr("transform", "translate(0, " + heightContext + ")")
        .call(xContextAxis);

        // Define and create brush
        var brush = d3.svg.brush()
        .x(xScaleContext)
        .on("brush", onBrush);

        context.append("g")
        .attr("class", "x brush")
        .call(brush)
        .selectAll("rect")
        .attr("y", (2 * marginContext))
        .attr("height", heightContext - (2 * marginContext));

        function onBrush() {
            xScale.domain(brush.empty() ? xScaleContext.domain() : brush.extent());
            for(j=1; j<=nb_sensors; j++)
            {
                if (genLine)
                    eval(focusLine[j]).select("path").attr("d", line(j));

                if (genArea)
                    eval(focusArea[j]).select("path").attr("d", area(j));
            }

            if (genLine)
                eval(focusLine[1]).select(".x.axis").call(xAxis);
            else if (genArea)
                eval(focusArea[1]).select(".x.axis").call(xAxis);
        }
    }
}