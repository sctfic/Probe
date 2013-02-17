var parse = d3.time.format("%Y-%m-%d %H:%M").parse,
    format = d3.time.format("%Y");

var svg, area, line, gradient, xAxis, yAxis;

function drawGraph (data, container, w, h) {
    var m = [1, 40, 30, 1],
    w = w - m[1] - m[3],
    h = h - m[0] - m[2];

    var x = d3.time.scale().range([0, w]),
        y = d3.scale.linear().range([h, 0]);

    xAxis = d3.svg.axis().scale(x).orient("bottom").tickSize(-h, 0).tickPadding(6),
    yAxis = d3.svg.axis().scale(y).orient("right").tickSize(-w).tickPadding(6);


    svg = d3.select(container).append("svg:svg")
        .attr("width", w + m[1] + m[3])
        .attr("height", h + m[0] + m[2])
        .append("svg:g")
        .attr("transform", "translate(" + m[3] + "," + m[0] + ")");

    gradient = svg.append("svg:defs").append("svg:linearGradient")
        .attr("id", "gradient")
        .attr("x2", "0%")
        .attr("y2", "100%");

    gradient.append("svg:stop")
        .attr("offset", "0%")
        .attr("stop-color", "#fff")
        .attr("stop-opacity", .5);

    gradient.append("svg:stop")
        .attr("offset", "100%")
        .attr("stop-color", "#999")
        .attr("stop-opacity", 1);

    svg.append("svg:clipPath")
        .attr("id", "clip")
      .append("svg:rect")
        .attr("x", x(0))
        .attr("y", y(1))
        .attr("width", x(1) - x(0))
        .attr("height", y(0) - y(1));

    svg.append("svg:g")
        .attr("class", "y axis")
        .attr("transform", "translate(" + w + ",0)");

    svg.append("svg:path")
        .attr("class", "area")
        .attr("clip-path", "url(#clip)")
        .style("fill", "url(#gradient)");

    svg.append("svg:g")
        .attr("class", "x axis")
        .attr("transform", "translate(0," + h + ")");

    svg.append("svg:path")
        .attr("class", "line")
        .attr("clip-path", "url(#clip)");

    var rect = svg.append("svg:rect")
        .attr("class", "pane")
        .attr("width", w)
        .attr("height", h);

    // An area generator.
    area = d3.svg.area()
        .interpolate("step-after")
        .x(function(d) { return x(d.date); })
        .y0(y(0))
        .y1(function(d) { return y(d.val); });

    // A line generator.
    line = d3.svg.line()
        .interpolate("step-after")
        .x(function(d) { return x(d.date); })
        .y(function(d) { return y(d.val); });




    // Parse dates and numbers.
    data.forEach(function(d) {
        d.date = parse(d.date);
        d.val = +d.val;
    });

    x.domain(d3.extent(data.map(function(d) { return d.date; })));
    ymin = d3.min(data.map(function(d) { return d.val; }));
    ymax = d3.max(data.map(function(d) { return d.val; }));
    ymargin = (ymax - ymin)/50
    y.domain([ymin-ymargin, ymax+ymargin]);

    // y.domain(d3.extent(data.map(function(d) { return d.val; })));

    // Bind the data to our path elements.
    svg.select("path.area").data([data]);
    svg.select("path.line").data([data]);
    rect.call(d3.behavior.zoom().x(x).scaleExtent([1,Infinity]).on("zoom", draw));
    d3.behavior.zoom().scale(4);
    console.log(d3.behavior.zoom().scale());
    draw();
}

function draw() {
    var ptg = d3.event.translate[0]; // coordonnee X du point gauche en pixel
    svg.select("g.x.axis").call(xAxis);
    svg.select("g.y.axis").call(yAxis);
    svg.select("path.area").attr("d", area);
    svg.select("path.line").attr("d", line);
    // console.log(d3.event.scale, d3.event.translate[1], d3.event.translate[0]);
}
