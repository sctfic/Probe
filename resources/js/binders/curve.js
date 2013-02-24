var parse = d3.time.format("%Y-%m-%d %H:%M").parse,
    format = d3.time.format("%Y");

var svg, area, line, gradient, xAxis, yAxis;
var color = d3.scale.category20();

function drawGraph (data, container, w, h) {
    var m = [5, 15, 20, 35], // [haut, droite, bas, gauche]
    w = w - m[1] - m[3],
    h = h - m[0] - m[2];

    var x = d3.time.scale().range([0, w]),
        y = d3.scale.linear().range([h, 0]);

    xAxis = d3.svg.axis().scale(x).orient("bottom"),//.tickSize(-h, 0).tickPadding(6),
    yAxis = d3.svg.axis().scale(y).orient("left");//.tickSize(-w).tickPadding(6);


    svg = d3.select(container).append("svg:svg")
        .attr("width", w + m[1] + m[3])
        .attr("height", h + m[0] + m[2])
        .append("svg:g")
        .attr("transform", "translate(" + m[3] + "," + m[0] + ")");

    svg.append("svg:clipPath")
        .attr("id", "clip")
        .append("svg:rect")
        .attr("x", x(0))
        .attr("y", y(1))
        .attr("width", x(1) - x(0))
        .attr("height", y(0) - y(1));

    svg.append("svg:g")
        .attr("class", "y axis")
        .attr("transform", "translate(0,0)");

    // svg.append("svg:path")
    //     .attr("class", "area")
    //     .attr("clip-path", "url(#clip)");
    //    .style("fill", "url(#gradient)");

    svg.append("svg:g")
        .attr("class", "x axis")
        .attr("transform", "translate(0," + h + ")");

    svg.append("svg:path")
        .attr("class", "line")
        .style("stroke", function(d) { return color('courbe1'); })
        .attr("clip-path", "url(#clip)");

    // hoverLine = svg.append("svg:line")
    //     .attr("class", "hover-line")
    //     .style("stroke", function(d) { return color('curssor'); })
    //     // .style('stroke-width', 1)
    //     .attr("x1", 0).attr("x2", 0) // vertical line so same value on each
    //     .attr("y1", 0).attr("y2", h); // top to bottom      
    // hide it by default
    // hoverLine.classed("hide", true);


    var rect = svg.append("svg:rect")
        .attr("class", "pane")
        .attr("width", w)
        .attr("height", h);

    // A line generator.
    line = d3.svg.line()
        // .interpolate("step-after")
        .interpolate("linear")
        // .interpolate("basis")
        // .on("mouseover", function(d, i) { console.log(d,i); })
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
    ymargin = (ymax - ymin)/50;
    y.domain([ymin-ymargin, ymax+ymargin]);

    // y.domain(d3.extent(data.map(function(d) { return d.val; })));

    

    // Bind the data to our path elements.
    // svg.select("path.area").data([data]);
    var curve1 = svg.select("path.line").data([data]);


    var circle = svg.append("circle")
            .attr("r", 8)
            .attr("cx", 0)
            .attr("cy", 0)
            .style({fill: '#fff', 'fill-opacity': .2, stroke: '#000', "stroke-width": '1px'})
            .attr("opacity", 0);
    var infoBulle = circle.append("svg:title");



    hoverLineXOffset = m[3];
    // hoverLineYOffset = margin[0]+rect.offset().top;

    rect.on("mousemove", function() {
        var pathEl = curve1.node(); // recupere les point de la courbe
        var pathData = curve1.data(); // recupere donnée de la courbe
        var pathLength = pathEl.getTotalLength(); // longueur totale de la ligne de la courbe
        var BBox = pathEl.getBBox(); // SVGRect {height: visible+caché, width: visible+caché, y: positionY, x: PositionX}

        var mouseX = event.pageX-hoverLineXOffset,
            findX = mouseX,
            pos = pathEl.getPointAtLength((findX-BBox.x)/BBox.width*pathLength),
            i=0;

        while (Math.floor(pos.x,1) != mouseX && i<20) {
            findX = findX+(mouseX-Math.floor(pos.x))/2;
            pos = pathEl.getPointAtLength((findX-BBox.x)/BBox.width*pathLength);
            i++;
        }

        // hoverLine.attr("x1", pos.x)
        //     .attr("x2", pos.x);

        circle.attr("opacity", 1)
            .attr("cx", pos.x)
            .attr("cy", pos.y);
            
        dataIndex = pathEl.getPathSegAtLength((findX-BBox.x)/BBox.width*pathLength);

        infoBulle.text(pathData[0][dataIndex]['date'] + "\n" + pathData[0][dataIndex]['val']);
        // console.log(curve1.zoom().x() , curve1.zoom().translate());
        console.log("here", x.domain());

        });


    rect.call(d3.behavior.zoom().x(x).scaleExtent([1,10]).on("zoom", draw));
    // d3.behavior.zoom().scale();
    draw();
}

function draw() {
    // var ptg = d3.event.translate[0]; // coordonnee X du point gauche en pixel
    // console.log('zoom().scale()', d3.behavior.zoom().scale());
    // if (d3.event.translate[0]>0) d3.event.translate[0]=0;
    // console.log('ptg', ptg);

    // trace l'axe X
    svg.select("g.x.axis").call(xAxis);

    // trace l'axe Y
    svg.select("g.y.axis").call(yAxis);

    // trace la courbe
    svg.select("path.line").attr("d", line);

    // console.log(d3.event.scale, d3.event.translate[1], d3.event.translate[0]);
}
