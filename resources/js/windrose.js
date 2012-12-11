//Live example from: https://gist.github.com/3589712
//https://groups.google.com/forum/?fromgroups=#!searchin/d3-js/windhistory.com/d3-js/0fYBKF8mYvE/0VXPUCBBtXsJ
//ksfo is taken from windhistory.com server
//var data = tributary.ksfo;


//scroll to bottom to see how we call the drawBigWindrose function with the data

//we don't have a selectedMonthControl so we just turn on all the months
var months = [];
for(var i = 0; i < 12; i++) {
  months.push(true);
}

var svg = d3.select("svg");


//setup some containers to put the plots inside
var big = svg.append("g")
  .attr("id", "windrose")
  .attr("transform", "translate(" + [35, 100] + ")");


var avg = svg.append("g")
  .attr("id", "avg")
  .attr("transform", "translate(" + [464, 100] + ")");






// This is the core Javascript code for http://windhistory.com/
// I haven't done a full open source release, but I figured I'd put the most important
// D3 code out there for people to learn from.   --nelson@monkey.org

/** Common wind rose code **/

// Function to draw a single arc for the wind rose
// Input: Drawing options object containing
//   width: degrees of width to draw (ie 5 or 15)
//   from: integer, inner radius
//   to: function returning the outer radius
// Output: a function that when called, generates SVG paths.
//   It expects to be called via D3 with data objects from totalsToFrequences()
var arc = function(o) {
    return d3.svg.arc()
        .startAngle(function(d) { return (d.d - o.width) * Math.PI/180; })
        .endAngle(function(d) { return (d.d + o.width) * Math.PI/180; })
        .innerRadius(o.from)
        .outerRadius(function(d) { return o.to(d) });
};

/** Code for data manipulation **/

// Convert a dictionary of {direction: total} to frequencies
// Output is an array of objects with three parameters:
//   d: wind direction
//   p: probability of the wind being in this direction
//   s: average speed of the wind in this direction
function totalsToFrequencies(totals, speeds) {
    var sum = 0;
    // Sum all the values in the dictionary
    for (var dir in totals) {
        sum += totals[dir];
    }
    if (sum == 0) {  // total hack to work around the case where no months are selected
        sum = 1;
    }
    
    // Build up an object containing frequencies
    var ret = {};
    ret.dirs = []
    ret.sum = sum;
    for (var dir in totals) {
        var freq = totals[dir] / sum;
        var avgspeed;
        if (totals[dir] > 0) { 
            avgspeed = speeds[dir] / totals[dir];
        } else {
            avgspeed = 0;
        }
        if (dir == "null") {   // winds calm is a special case
            ret.calm = { d: null, p: freq, s: null };
        } else {
            ret.dirs.push({ d: parseInt(dir), p: freq, s: avgspeed });
        }
    }
    return ret;
}

// Filter input data, giving back frequencies for the selected month 
function rollupForStep(d, step) {
    var totals = {"null":0,"0.0":0,"22.5":0,"45.0":0,"67.5":0,"90.0":0,"112.5":0,"135.0":0,"157.5":0,"180.0":0,"202.5":0,"225.0":0,"247.5":0,"270.0":0,"292.5":0,"315.0":0,"337.5":0};
    var speeds = {"null":0,"0.0":0,"22.5":0,"45.0":0,"67.5":0,"90.0":0,"112.5":0,"135.0":0,"157.5":0,"180.0":0,"202.5":0,"225.0":0,"247.5":0,"270.0":0,"292.5":0,"315.0":0,"337.5":0};
    //    console.log('==========================================================');
    //return null;
    for (var key in d.data) {
        // console.log (d.data[key], d.data[key].Step*1);
        var step = d.data[key].Step*1;
        if (step == 49) {
            var direction = d.data[key].Direction;
            totals[direction] += d.data[key].NbSample *1;
            speeds[direction] += d.data[key].SpeedAvg * d.data[key].NbSample *1;
            // console.log (d.data[key].Direction, direction, totals[direction], speeds[direction]);
        }
    }
    // console.log (totals, speeds);
    return totalsToFrequencies(totals, speeds);
}

/** Code for big visualization **/

// Transformation to place a mark on top of an arc
function probArcTextT(d) {
    var tr = probabilityToRadius(d);
    return "translate(" + visWidth + "," + (visWidth-tr) + ")" +
           "rotate(" + d.d + ",0," + tr + ")"; };
function speedArcTextT(d) {
    var tr = speedToRadius(d);
    return "translate(" + visWidth + "," + (visWidth-tr) + ")" +
           "rotate(" + d.d + ",0," + tr + ")"; };   

// Return a string representing the wind speed for this datum
function speedText(d) { return d.s < 10 ? "" : d.s.toFixed(0); };
// Return a string representing the probability of wind coming from this direction
function probabilityText(d) { return d.p < 0.02 ? "" : (100*d.p).toFixed(0); };

// Map a wind speed to a color
var speedToColorScale = d3.scale.linear()
                          .domain([5, 25])
                          .range(["hsl(220, 70%, 90%)", "hsl(220, 70%, 30%)"])
                          .interpolate(d3.interpolateHsl);
function speedToColor(d) { return speedToColorScale(d.s); }
// Map a wind probability to a color                     
var probabilityToColorScale = d3.scale.linear()
                                .domain([0, 0.2])
                                .range(["hsl(0, 70%, 99%)", "hsl(0, 70%, 40%)"])
                                .interpolate(d3.interpolateHsl);
function probabilityToColor(d) { return probabilityToColorScale(d.p); }
                                
// Width of the whole visualization; used for centering               
var visWidth = 200;

// Map a wind probability to an outer radius for the chart      
var probabilityToRadiusScale = d3.scale.linear().domain([0, 0.15]).range([34, visWidth-20]).clamp(true);
function probabilityToRadius(d) { return probabilityToRadiusScale(d.p); }
// Map a wind speed to an outer radius for the chart      
var speedToRadiusScale = d3.scale.linear().domain([0, 20]).range([34, visWidth-20]).clamp(true);
function speedToRadius(d) { return speedToRadiusScale(d.s); }

// Options for drawing the complex arc chart
var windroseArcOptions = {
    width: 10,
    from: 32,
    to: probabilityToRadius
}   
var windspeedArcOptions = {
    width: 10,
    from: 32,
    to: speedToRadius
}
// Draw a complete wind rose visualization, including axes and center text
function drawComplexArcs(parent, plotData, colorFunc, arcTextFunc, complexArcOptions, arcTextT) {
    // Draw the main wind rose arcs
    parent.append("svg:g")
        .attr("class", "arcs")
        .selectAll("path")
        .data(plotData.dirs)
      .enter().append("svg:path")
        .attr("d", arc(complexArcOptions))
        .style("fill", colorFunc)
        .attr("transform", "translate(" + visWidth + "," + visWidth + ")")
      .append("svg:title")
        .text(function(d) { return d.d + "\u00b0 " + (100*d.p).toFixed(1) + "% " + d.s.toFixed(0) + "kts" });
        
    // Annotate the arcs with speed in text
    if (false) {    // disabled: just looks like chart junk
        parent.append("svg:g")
            .attr("class", "arctext")
            .selectAll("text")
            .data(plotData.dirs)
          .enter().append("svg:text")
            .text(arcTextFunc)
            .attr("dy", "-3px")
            .attr("transform", arcTextT);
    }

    // Add the calm wind probability in the center
    var cw = parent.append("svg:g").attr("class", "calmwind")
        .selectAll("text")
        .data([plotData.calm.p])
        .enter();
    cw.append("svg:text")
        .attr("transform", "translate(" + visWidth + "," + visWidth + ")")
        .text(function(d) { return Math.round(d * 100) + "%" });
    cw.append("svg:text")
        .attr("transform", "translate(" + visWidth + "," + (visWidth+14) + ")")
        .attr("class", "calmcaption")
        .text("calm");
}
/**
    Update the page text after the data has been loaded
    Lots of template substitution here
*/
function updatePageText(d) {
    if (!('info' in d)) {
        // workaround for stations missing in the master list
        d3.selectAll(".stationid").text("????")
        d3.selectAll(".stationname").text("Unknown station");
        return;
    }
    document.title = "Wind History for " + d.info.id;
    d3.selectAll(".stationid").text(d.info.id);
    d3.selectAll(".stationname").text(d.info.name.toLowerCase());

    var mapurl = 'map.html#10.00/' + d.info.lat + "/" + d.info.lon;  
    d3.select("#maplink").html('<a href="' + mapurl + '">' + d.info.lat + ', ' + d.info.lon + '</a>');
    d3.select("#whlink").attr("href", mapurl);

    var wsurl = 'http://weatherspark.com/#!dashboard;loc=' + d.info.lat + ',' + d.info.lon + ';t0=01/01;t1=12/31';
    d3.select("#wslink").attr("href", wsurl);
    
    var wuurl = 'http://www.wunderground.com/cgi-bin/findweather/getForecast?query=' + d.info.id;
    d3.select("#wulink").attr("href", wuurl);
    
    var vmurl = 'http://vfrmap.com/?type=vfrc&lat=' + d.info.lat + '&lon=' + d.info.lon + '&zoom=10';
    d3.select("#vmlink").attr("href", vmurl);
    
    var rfurl = 'http://runwayfinder.com/?loc=' + d.info.id;
    d3.select("#rflink").attr("href", rfurl);
    
    var nmurl = 'http://www.navmonster.com/apt/' + d.info.id;
    d3.select("#nmlink").attr("href", nmurl);
}

// Update all diagrams to the newly selected months
function updateWindVisDiagrams(d) {
    updateBigWindrose(d, "#windrose");
    updateBigWindrose(d, "#windspeed");
}

// Update a specific digram to the newly selected months
function updateBigWindrose(windroseData, container) {
    var vis = d3.select(container).select("svg");
    var rollup = rollupForStep(windroseData, selectedMonthControl.selected());

    if (container == "#windrose") {
        updateComplexArcs(vis, rollup, speedToColor, speedText, windroseArcOptions, probArcTextT);
    } else {
        updateComplexArcs(vis, rollup, probabilityToColor, probabilityText, windspeedArcOptions, speedArcTextT);
    }
}

// Update drawn arcs, etc to the newly selected months
function updateComplexArcs(parent, plotData, colorFunc, arcTextFunc, complexArcOptions, arcTextT) {
    // Update the arcs' shape and color
    parent.select("g.arcs").selectAll("path")
        .data(plotData.dirs)
        .transition().duration(200)
        .style("fill", colorFunc)
        .attr("d", arc(complexArcOptions));

    // Update the arcs' title tooltip
    parent.select("g.arcs").selectAll("path").select("title")
        .text(function(d) { return d.d + "\u00b0 " + (100*d.p).toFixed(1) + "% " + d.s.toFixed(0) + "kts" });
        
    // Update the calm wind probability in the center
    parent.select("g.calmwind").select("text")
        .data([plotData.calm.p])
        .text(function(d) { return Math.round(d * 100) + "%" });            
}

// Top level function to draw all station diagrams
function makeWindVis(station) {
    var url = "data/" + station + ".json";
    var stationData = null;
    d3.json(url, function(d) {
        stationData = d;
        updatePageText(d);        
        drawBigWindrose(d, "#windrose", "Frequency by Direction");
        drawBigWindrose(d, "#windspeed", "Average Speed by Direction");
        selectedMonthControl.setCallback(function() { updateWindVisDiagrams(d); });
    });

    selectedMonthControl = new monthControl(null);
    selectedMonthControl.install("#monthControlDiv");
}

// Draw a big wind rose, for the visualization
function drawBigWindrose(windroseData, container, captionText) {
    // Various visualization size parameters
    var w = 400,
        h = 400,
        r = Math.min(w, h) / 2,      // center; probably broken if not square
        p = 22,                      // padding on outside of major elements
        ip = 34;                     // padding on inner circle
        
    // The main SVG visualization element
    var vis = d3.select(container)
        .append("svg:svg")
        .attr("width", w + "px").attr("height", (h + 30) + "px");

    // Set up axes: circles whose radius represents probability or speed
    if (container == "#windrose") {
        var ticks = d3.range(0.025, 0.151, 0.025);
        var tickmarks = d3.range(0.05,0.101,0.05);
        var radiusFunction = probabilityToRadiusScale;
        var tickLabel = function(d) { return "" + (d*100).toFixed(0) + "%"; }
    } else {
        var ticks = d3.range(5, 20.1, 5);
        var tickmarks = d3.range(5, 15.1, 5);
        var radiusFunction = speedToRadiusScale;
        var tickLabel = function(d) { return "" + d + "kts"; }
    }

    // Circles representing chart ticks
    vis.append("svg:g")
        .attr("class", "axes")
      .selectAll("circle")
        .data(ticks)
      .enter().append("svg:circle")
        .attr("cx", r).attr("cy", r)
        .attr("r", radiusFunction);
    // Text representing chart tickmarks
    vis.append("svg:g").attr("class", "tickmarks")
        .selectAll("text")
        .data(tickmarks)
      .enter().append("svg:text")
        .text(tickLabel)
        .attr("dy", "-2px")
        .attr("transform", function(d) {
            var y = visWidth - radiusFunction(d);
            return "translate(" + r + "," + y + ") " })
            
    // Labels: degree markers
    vis.append("svg:g")
      .attr("class", "labels")
      .selectAll("text")
        .data(d3.range(30, 361, 30))
      .enter().append("svg:text")
        .attr("dy", "-4px")
        .attr("transform", function(d) {     
            return "translate(" + r + "," + p + ") rotate(" + d + ",0," + (r-p) + ")"})        
        .text(function(dir) { return dir; });

    //var rollup = rollupForStep(windroseData, selectedMonthControl.selected());
    var rollup = rollupForStep(windroseData, months);

  
    if (container == "#windrose") {
        drawComplexArcs(vis, rollup, speedToColor, speedText, windroseArcOptions, probArcTextT);
    } else {
        drawComplexArcs(vis, rollup, probabilityToColor, probabilityText, windspeedArcOptions, speedArcTextT);
    }
    vis.append("svg:text")
       .text(captionText)
       .attr("class", "caption")
       .attr("transform", "translate(" + w/2 + "," + (h + 20) + ")");
}

/** Code for small wind roses **/

// Plot a small wind rose with the specified percentage data
//   parent: the SVG element to put the plot on
//   plotData: a list of 12 months, each a list of 13 numbers. plotData[month][0] is winds calm percentage,
//     plotData[month][1, 2, 3...] is percentage of winds at 30 degrees, 60, 90, ...
var smallArcScale = d3.scale.linear().domain([0, 0.15]).range([5, 30]).clamp(true)
var smallArcOptions = {
    width: 15,
    from: 5,
    to: function(d) { return smallArcScale(d.p); }
}
    
function plotSmallRose(parent, plotData) {
    var winds = [];
    //var months = selectedMonthControl.selected();
  
    // For every wind direction (note: skip plotData[0], winds calm)
    for (var dir = 1; dir < 13; dir++) {
        // Calculate average probability for all selected months
        var n = 0; sum = 0;
        for (var month = 0; month < 12; month++) {
            if (months[month]) {
                n += 1;
                sum += plotData[month][dir];
            }
        }
        var avg = sum/n;
        winds.push({d: dir * 30, p: avg / 100});
    }
    parent.append("svg:g")
        .selectAll("path")
        .data(winds)
      .enter().append("svg:path")
        .attr("d", arc(smallArcOptions));
    parent.append("svg:circle")
        .attr("r", smallArcOptions.from);
}









    // drawBigWindrose(data, "#windrose", "caption")
    // drawBigWindrose(data, "#avg", "caption")
      
      
      
    // //need to reformat the data to get smallPlot to work, not sure how yet
    // //var rollup = rollupForStep(data, months);
    // //var small = svg.append("g")
    // //.attr("id", "small");
    // //plotSmallRose(small, rollup)
      
      

    // //Style the plots, this doesn't capture everything from windhistory.com  
    // svg.selectAll("text").style( { font: "14px sans-serif", "text-anchor": "middle" });

    // svg.selectAll(".arcs").style( {  stroke: "#000", "stroke-width": "0.5px", "fill-opacity": 0.9 })
    // svg.selectAll(".caption").style( { font: "18px sans-serif" });
    // svg.selectAll(".axes").style( { stroke: "#aaa", "stroke-width": "0.5px", fill: "none" })
    // svg.selectAll("text.labels").style( { "letter-spacing": "1px", fill: "#444", "font-size": "12px" })
    // svg.selectAll("text.arctext").style( { "font-size": "9px" })
