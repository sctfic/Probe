var margin = {top: 10, right: 10, bottom: 100, left: 40},
    margin2 = {top: 430, right: 10, bottom: 20, left: 40},
    width = 1400 - margin.left - margin.right,
    height = 500 - margin.top - margin.bottom,
    height2 = 500 - margin2.top - margin2.bottom;

var parseDate = d3.time.format("%Y-%m-%d %H:%M").parse;
var color = d3.scale.category20();

var x = d3.time.scale().range([0, width]),
    x2 = d3.time.scale().range([0, width]),
    y = d3.scale.linear().range([height, 0]),
    y2 = d3.scale.linear().range([height2, 0]);

var xAxis = d3.svg.axis().scale(x).orient("bottom"),
    xAxis2 = d3.svg.axis().scale(x2).orient("bottom"),
    yAxis = d3.svg.axis().scale(y).orient("left");

var brush = d3.svg.brush()
    .x(x2)
    .on("brush", brush);

var line = d3.svg.line()
    .interpolate("basis")
    .x(function(d) { return x(d.date); })
    .y(function(d) { return y(d.val); });

// var area = d3.svg.area()
//     .interpolate("monotone")
//     .x(function(d) { return x(d.date); })
//     .y0(height)
//     .y1(function(d) { return y(d.val); });
    
var line2 = d3.svg.line()
    .interpolate("basis")
    .x(function(d) { return x2(d.date); })
    .y(function(d) { return y2(d.val); });

// var area2 = d3.svg.area()
//     .interpolate("monotone")
//     .x(function(d) { return x2(d.date); })
//     .y0(height2)
//     .y1(function(d) { return y2(d.val); });

var svg = d3.select("body").append("svg")
    .attr("width", width + margin.left + margin.right)
    .attr("height", height + margin.top + margin.bottom);

svg.append("defs").append("clipPath")
    .attr("id", "clip")
    .append("rect")
    .attr("width", width)
    .attr("height", height);

var focus = svg.append("g")
    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

var context = svg.append("g")
    .attr("transform", "translate(" + margin2.left + "," + margin2.top + ")");

d3.tsv("http://probe.dev/draw/curve?station=VP2_GTD&sensor=TA:Arch:Temp:Out:Average&Since=2013-01-01&StepUnit=DAY&StepNbr=1", function(error, data) {

  data.forEach(function(d) {
    d.date = parseDate(d.date);
    d.val = +d.val;
  });

  x.domain(d3.extent(data.map(function(d) { return d.date; })));
  y.domain(d3.extent(data.map(function(d) { return d.val; })));
  // y.domain([  // mini et maxi parmis plusieurs courbes
  //   d3.min(cities, function(c) { return d3.min(c.values, function(v) { return v.temperature; }); }),
  //   d3.max(cities, function(c) { return d3.max(c.values, function(v) { return v.temperature; }); })
  // ]);

  x2.domain(x.domain());
  y2.domain(y.domain());

/**
    Tracage de la courbe principale
*/
  // focus.append("path")
  //       .datum(data)
  //       .attr("clip-path", "url(#clip)")
  //       .attr("d", area);

   focus.append("path")
        .attr("class", "line")
        .datum(data)
        .attr("clip-path", "url(#clip)")
        .style("stroke", function(d) { console.log(color(9)); return color(9); })
        .attr("d", line);

  focus.append("g")
      .attr("class", "x axis")
      .attr("transform", "translate(0," + height + ")")
      .call(xAxis);

  focus.append("g")
      .attr("class", "y axis")
      .call(yAxis);



/**
    Tracage de la courbe miniature du bas
*/
  // context.append("path")
  //       .datum(data)
  //       .attr("d", area2);

  context.append("path")
        .attr("class", "line")
        .datum(data)
        .attr("clip-path", "url(#clip)")
        .style("stroke", function(d) { console.log(color(4)); return color(4); })
        .attr("d", line2);


  context.append("g")
        .attr("class", "x axis")
        .attr("transform", "translate(0," + height2 + ")")
        .call(xAxis2);

  context.append("g")
        .attr("class", "x brush")
        .call(brush)
        .selectAll("rect")
        .attr("y", -6)
        .attr("height", height2 + 7);
});

function brush() {
  x.domain(brush.empty() ? x2.domain() : brush.extent());
  focus.select("path").attr("d", line);
  focus.select(".x.axis").call(xAxis);
}