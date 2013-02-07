var margin = {top: 10, right: 10, bottom: 100, left: 40},
    margin2 = {top: 430, right: 10, bottom: 20, left: 40};
var width, height, height2;
var focus, context;
var parseDate = d3.time.format("%Y-%m-%d %H:%M").parse;
var color = d3.scale.category10();

var x = x2 = d3.time.scale().range([0, width]),
    // x2 = d3.time.scale().range([0, width]),
    y = d3.scale.linear().range([height, 0]),
    y2 = d3.scale.linear().range([height2, 0]);

var xAxis = d3.svg.axis().scale(x).orient("top"),
    xAxis2 = d3.svg.axis().scale(x2).orient("top");
    yAxis = d3.svg.axis().scale(y).orient("left");

var brush = d3.svg.brush()
    .x(x2)
    .on("brush", brush);

var line = d3.svg.line()
    // https://github.com/mbostock/d3/wiki/SVG-Shapes#wiki-line_interpolate
	// linear  step-before  step-after  basis  cardinal
    .interpolate("basis")
    .x(function(d) { return x(d.date); })
    .y(function(d) { return y(d.val); });

var line2 = d3.svg.line()
    .interpolate("basis")
    .x(function(d) { return x2(d.date); })
    .y(function(d) { return y2(d.val); });


var curveCount = 0;




function plotCurve(data, container, w, h) {
    if (!curveCount)
        MakeCurveContainer(container, w, h);

    data.forEach( function(d) {
            d.date = parseDate(d.date);
            d.val = +d.val; // caste au format numerique
        });

    x.domain(d3.extent(data.map(function(d) { return d.date; }))).range([0, w]).clamp(true);
    console.log ( d3.extent(data.map(function(d) { return d.date; })) , 1);

    focus.append("g")
        .attr("class", "x axis")
        .attr("transform", "translate(0," + height + ")")
        .call(xAxis);
    // console.log ( data , 2);

    x2.domain(x.domain());
    context.append("g")
        .attr("class", "x axis")
        .attr("transform", "translate(0," + height2 + ")")
        .call(xAxis2);

    addCurve(data);
}




function addCurve(data) {
    // console.log ( data , 3);
    ymin = d3.min(data.map(function(d) { return d.val; }));
    ymax = d3.max(data.map(function(d) { return d.val; }));
    ymargin = (ymax - ymin)/20

    // y.domain(d3.extent(data.map(function(d) { return d.val; })));
    y.domain([ymin-ymargin, ymax+ymargin]).range([0, height]).clamp(true);
    // y.domain([
    //         d3.min( data.map(function(d) { return d.val; }) ) - ( d3.max(data.map(function(d) { return d.val; }))-d3.min(data.map(function(d) { return d.val; }))/20 ),
    //         d3.max( data.map(function(d) { return d.val; }) ) + ( d3.max(data.map(function(d) { return d.val; }))-d3.min(data.map(function(d) { return d.val; }))/20 )
    //     ]);
    focus.append("g")
        .attr("class", "y axis")
        .call(yAxis);
            // console.log ( [ymin-ymargin, ymax+ymargin] , 10);

            console.log ( height , height2 , 10);
    y2.domain([ymin-ymargin, ymax+ymargin]).range([0, height2]).clamp(true);
    context.append("g")
        .attr("class", "x axis")
        .attr("transform", "translate(0," + height2 + ")")
        .call(xAxis2);

/**
    Tracage de la courbe principale
*/
    focus.append("path")
        .attr("class", "line")
        .datum(data)
        .attr("clip-path", "url(#clip)")
        .style("stroke", function(d) { return color('courbe1'); })
        .attr("d", line);

           focus.append("g")
                .attr("class", "x axis")
                .attr("transform", "translate(0," + height + ")")
                .call(xAxis);
            focus.append("g")
                .attr("class", "y axis")
                .call(yAxis);

            console.log ( data , 5);

/**
    Tracage de la courbe miniature du bas
*/
    context.append("path")
        .attr("class", "line")
        .datum(data)
        .attr("clip-path", "url(#clip)")
        .style("stroke", function(d) {return color('courbe1'); })
        .attr("d", line2);

            context.append("g")
                .attr("class", "x axis")
                .attr("transform", "translate(0," + height2 + ")")
                .call(xAxis2);
            console.log ( data , 6);

/**
    Brush
*/
    context.append("g")
        .attr("class", "x brush")
        .call(brush)
        .selectAll("rect")
        .attr("y", -6)
        .attr("height", height2 + 7);

    curveCount++;
}

function MakeCurveContainer(container, w, h) {
    width = w - margin.left - margin.right,
    height = h - margin.top - margin.bottom,
    height2 = h - margin2.top - margin2.bottom;

            console.log ( height , height2 , 11);

    var svg = d3.select(container)
        .append("svg")
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom);

    // svg.append("defs").append("clipPath")
    //     .attr("id", "clip")
    //     .append("rect")
    //     .attr("width", width)
    //     .attr("height", height);

    focus = svg.append("g")
        .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

    context = svg.append("g")
        .attr("transform", "translate(" + margin2.left + "," + margin2.top + ")");

    return svg;
}

function brush() {
  x.domain(brush.empty() ? x2.domain() : brush.extent());
  focus.select("path").attr("d", line);
  focus.select(".x.axis").call(xAxis);
}