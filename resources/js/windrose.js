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
    .attr("id", "windspeed")
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
//   p: probability of the wind being in this directionl
//   s: average speed of the wind in this direction
// function totalsToFrequencies(totals, speeds) {
//     var sum = 0;
//     // Sum all the values in the dictionary
//     for (var dir in totals) {
//         sum += totals[dir];
//     }
//     if (sum == 0) {  // total hack to work around the case where no months are selected
//         sum = 1;
//     }
    
//     // Build up an object containing frequencies
//     var ret = {};
//     ret.dirs = []
//     ret.sum = sum;
//     for (var dir in totals) {
//         var freq = totals[dir] / sum;
//         var avgspeed;
//         if (totals[dir] > 0) { 
//             avgspeed = speeds[dir] / totals[dir];
//         } else {
//             avgspeed = 0;
//         }
//         if (dir == "null") {   // winds calm is a special case
//             ret.calm = { d: null, p: freq, s: null };
//         } else {
//             ret.dirs.push({ d: parseInt(dir), p: freq, s: avgspeed });
//         }
//     }
//     return ret;
// }

// // Filter input data, giving back frequencies for the selected month 
// function rollupForStep(d, needstep) {

//     var totals = {"null":0,"0.0":0,"22.5":0,"45.0":0,"67.5":0,"90.0":0,"112.5":0,"135.0":0,"157.5":0,"180.0":0,"202.5":0,"225.0":0,"247.5":0,"270.0":0,"292.5":0,"315.0":0,"337.5":0};
//     var speeds = {"null":0,"0.0":0,"22.5":0,"45.0":0,"67.5":0,"90.0":0,"112.5":0,"135.0":0,"157.5":0,"180.0":0,"202.5":0,"225.0":0,"247.5":0,"270.0":0,"292.5":0,"315.0":0,"337.5":0};
//     //    console.log('==========================================================');
//     //return null;
//     for (var key in d) {
//         var direction = d[key].Dir;
//         totals[direction] += d[key].Spl;
//         speeds[direction] += d[key].Spd * d[key].Spl ;
//         console.log (d[key],d[key].Dir, direction, totals[direction], speeds[direction]);
//     }
//     // console.log (totals, speeds);
//     return totalsToFrequencies(totals, speeds);
// }

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
var visWidth = 240;

// Map a wind probability to an outer radius for the chart
var probabilityToRadiusScale = d3.scale.linear().domain([0, 0.15]).range([34, visWidth]).clamp(true);
function probabilityToRadius(d) { return probabilityToRadiusScale(d.p); }
// Map a wind speed to an outer radius for the chart
var speedToRadiusScale = d3.scale.linear().domain([0,  20]).range([34, visWidth-20]).clamp(true);
function speedToRadius(d) { return speedToRadiusScale(d.s); }

// Options for drawing the complex arc chart
var windProbabilityArcOptions = {
    width: 10,
    from: 32,
    to: probabilityToRadius
}   
var windSpeedArcOptions = {
    width: 10,
    from: 32,
    to: speedToRadius
}
// // Draw a complete wind rose visualization, including axes and center text
// function drawComplexArcs(parent, plotData, colorFunc, arcTextFunc, complexArcOptions, arcTextT) {
//     // Draw the main wind rose arcs
//     parent.append("svg:g")
//         .attr("class", "arcs")
//         .selectAll("path")
//         .data(plotData.dirs)
//     .enter().append("svg:path")
//         .attr("d", arc(complexArcOptions))
//         .style("fill", colorFunc)
//         .attr("transform", "translate(" + visWidth + "," + visWidth + ")")
//         .append("svg:title")
//         .text(function(d) { return d.d + "\u00b0 " + (100*d.p).toFixed(1) + "% " + d.s.toFixed(0) + "km/h" });
        
//     // Annotate the arcs with speed in text
//     if (false) {    // disabled: just looks like chart junk
//         parent.append("svg:g")
//             .attr("class", "arctext")
//             .selectAll("text")
//             .data(plotData.dirs)
//         .enter().append("svg:text")
//             .text(arcTextFunc)
//             .attr("dy", "-3px")
//             .attr("transform", arcTextT);
//     }

//     // Add the calm wind probability in the center
//     var cw = parent.append("svg:g").attr("class", "calmwind")
//         .selectAll("text")
//         .data([plotData.calm.p])
//         .enter();
//     cw.append("svg:text")
//         .attr("transform", "translate(" + visWidth + "," + visWidth + ")")
//         .text(function(d) { return Math.round(d * 100) + "%" });
//     cw.append("svg:text")
//         .attr("transform", "translate(" + visWidth + "," + (visWidth+14) + ")")
//         .attr("class", "calmcaption")
//         .text("calm");
// }
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

    // var mapurl = 'map.html#10.00/' + d.info.lat + "/" + d.info.lon;  
    // d3.select("#maplink").html('<a href="' + mapurl + '">' + d.info.lat + ', ' + d.info.lon + '</a>');
    // d3.select("#whlink").attr("href", mapurl);

    var wsurl = 'http://weatherspark.com/#!dashboard;loc=' + d.info.lat + ',' + d.info.lon + ';t0=01/01;t1=12/31';
    d3.select("#wslink").attr("href", wsurl);
    
    var wuurl = 'http://www.wunderground.com/cgi-bin/findweather/getForecast?query=' + d.info.id;
    d3.select("#wulink").attr("href", wuurl);
    
    var vmurl = 'http://vfrmap.com/?type=vfrc&lat=' + d.info.lat + '&lon=' + d.info.lon + '&zoom=10';
    d3.select("#vmlink").attr("href", vmurl);
    
    var rfurl = 'http://runwayfinder.com/?loc=' + d.info.id;
    d3.select("#rflink").attr("href", rfurl);
    
    // var nmurl = 'http://www.navmonster.com/apt/' + d.info.id;
    // d3.select("#nmlink").attr("href", nmurl);
}

// Update all diagrams to the newly selected months
// function updateWindVisDiagrams(d) {
//     updateBigWindrose(d, "#windrose");
//     updateBigWindrose(d, "#windspeed");
// }

// Update a specific digram to the newly selected months
// function updateBigWindrose(windroseData, container) {
//     var vis = d3.select(container).select("svg");
//     var rollup = rollupForStep(windroseData, selectedMonthControl.selected());

//     if (container == "#windrose") {
//         updateComplexArcs(vis, rollup, speedToColor, speedText, windroseArcOptions, probArcTextT);
//     } else {
//         updateComplexArcs(vis, rollup, probabilityToColor, probabilityText, windspeedArcOptions, speedArcTextT);
//     }
// }

// Update drawn arcs, etc to the newly selected months
// function updateComplexArcs(parent, plotData, colorFunc, arcTextFunc, complexArcOptions, arcTextT) {
//     // Update the arcs' shape and color
//     parent.select("g.arcs").selectAll("path")
//         .data(plotData.dirs)
//         .transition().duration(200)
//         .style("fill", colorFunc)
//         .attr("d", arc(complexArcOptions));

//     // Update the arcs' title tooltip
//     parent.select("g.arcs").selectAll("path").select("title")
//         .text(function(d) { return d.d + "\u00b0 " + (100*d.p).toFixed(1) + "% " + d.s.toFixed(0) + "km/h" });
        
//     // Update the calm wind probability in the center
//     parent.select("g.calmwind").select("text")
//         .data([plotData.calm.p])
//         .text(function(d) { return Math.round(d * 100) + "%" });            
// }

// Top level function to draw all station diagrams
// function makeWindVis(d) {
//     console.log('makeWindVis', d);

//     var stationData = d;
//     if (maxSpl(d)/totalSpl(d)>0.14)
//         probabilityToRadiusScale = d3.scale.linear().domain(
//             [0,  (maxSpl(d)/totalSpl(d)+0.05).toFixed(2)]).range([34, visWidth-20]).clamp(true);
//     if (maxSpd(d)>19)
//         speedToRadiusScale = d3.scale.linear().domain(
//             [0, (maxSpd(d)*1.01).toFixed(2)]).range([34, visWidth-20]).clamp(true);
//     updatePageText(d);
//     drawBigWindrose(d, "#windrose", "Frequency by Direction");
//     drawBigWindrose(d, "#windspeed", "Average Speed by Direction");
//     // selectedMonthControl.setCallback(function() { updateWindVisDiagrams(d); });
//     // Style the plots, this doesn't capture everything from windhistory.com  
//     svg.selectAll("text").style( { font: "12px sans-serif", "text-anchor": "middle" });
//     svg.selectAll(".calmwind text").style( { font: "16px sans-serif", "text-anchor": "middle" });
//     svg.selectAll(".arcs").style( {  stroke: "#000", "stroke-width": "0.5px", "fill-opacity": 0.6 });
//     svg.selectAll(".caption").style( { font: "18px sans-serif" });
//     svg.selectAll(".axes").style( { stroke: "#aaa", "stroke-width": "0.5px", fill: "none" });
//     svg.selectAll("text.labels").style( { "letter-spacing": "1px", fill: "#444", "font-size": "12px" });
//     svg.selectAll("text.arctext").style( { "font-size": "9px" });
//     // selectedMonthControl = new monthControl(null);
//     // selectedMonthControl.install("#monthControlDiv");
// }

// Draw a big wind rose, for the visualization
// function drawBigWindrose(windroseData, container, captionText) {
//     console.log ('drawBigWindrose', windroseData);
//     // Various visualization size parameters
//     var w = 400,
//         h = 400,
//         r = Math.min(w, h) / 2,      // center; probably broken if not square
//         p = 22,                      // padding on outside of major elements
//         ip = 34;                     // padding on inner circle
        
//     // The main SVG visualization element
//     var vis = d3.select(container)
//         .append("svg:svg")
//         .attr("width", w + "px").attr("height", (h + 30) + "px");

//     // Set up axes: circles whose radius represents probability or speed
//     if (container == "#windrose") {
//         var s=(maxSpl(windroseData)/totalSpl(windroseData)).toFixed(2);

//         if (s>0.14) {
//             // console.log ((s/4).toFixed(3), s*1+0.01, (s/4).toFixed(3));
//             var ticks = d3.range((s/3).toFixed(5), s*1.001, (s/3).toFixed(5));
//             var tickmarks = d3.range((s/3).toFixed(2), (s/3).toFixed(2)*3*0.76, (s/3).toFixed(2));
//         }
//         else {
//             var ticks = d3.range(0.05, 0.151, 0.05);
//             var tickmarks = d3.range(0.05,0.101,0.05);
//         }
//         var radiusFunction = probabilityToRadiusScale;
//         var tickLabel = function(d) { return "" + (d*100).toFixed(0) + "%"; }
//     } else {
//         var m=maxSpd(windroseData);
//         if (m>19) {
//             var ticks = d3.range((m/4).toFixed(0), m*1.01, (m/4).toFixed(0));
//             var tickmarks = d3.range((m/4).toFixed(0), m*0.75, (m/4).toFixed(0));
//         }
//         else {
//             var ticks = d3.range(5, 20.1, 5);
//             var tickmarks = d3.range(5, 15.1, 5);
//         }
//         var radiusFunction = speedToRadiusScale;
//         var tickLabel = function(d) { return "" + d + "km/h"; }
//     }

//     // Circles representing chart ticks
//     vis.append("svg:g")
//         .attr("class", "axes")
//         .selectAll("circle")
//         .data(ticks)
//         .enter().append("svg:circle")
//         .attr("cx", r).attr("cy", r)
//         .attr("r", radiusFunction);
//     // Text representing chart tickmarks
//     vis.append("svg:g").attr("class", "tickmarks")
//         .selectAll("text")
//         .data(tickmarks)
//         .enter().append("svg:text")
//         .text(tickLabel)
//         .attr("dy", "-2px")
//         .attr("transform", function(d) {
//             var y = visWidth - radiusFunction(d);
//             return "translate(" + r + "," + y + ") " })
            
//     // Labels: degree markers
//     vis.append("svg:g")
//         .attr("class", "labels")
//         .selectAll("text")
//         .data(d3.range(22.5, 361, 22.5))
//         .enter().append("svg:text")
//         .attr("dy", "-4px")
//         .attr("transform", function(d) {     
//             return "translate(" + r + "," + p + ") rotate(" + d + ",0," + (r-p) + ")"})        
//         .text(function(dir) { return dir; });

//     //var rollup = rollupForStep(windroseData, selectedMonthControl.selected());
//     var rollup = rollupForStep(windroseData, months);

  
//     if (container == "#windrose") {
//         console.log(rollup, windroseArcOptions);
//         drawComplexArcs(vis, rollup, speedToColor, speedText, windroseArcOptions, probArcTextT);
//     } else {
//         drawComplexArcs(vis, rollup, probabilityToColor, probabilityText, windspeedArcOptions, speedArcTextT);
//     }
//     vis.append("svg:text")
//        .text(captionText)
//        .attr("class", "caption")
//        .attr("transform", "translate(" + w/2 + "," + (h + 20) + ")");
// }

/** Code for small wind roses **/
//
var maxSpl =  function(d) { return d3.max(d, function(d) { return d['Spl']; }); };

var totalSpl = function(d) { return d3.sum(d, function(d) { return d['Spl']; }); };

var maxSpd = function(d) { return d3.max(d, function(d) { return d['Spd']; }); };

// domain([0, 0.2]) = zoom rose between 0% - 20%
// range([5, 50]) = limit of drawed value 5px to 50px
var smallArcScale;// = d3.scale.linear().domain([0,  (maxSpl/totalSpl+0.05).toFixed(2)]).range([5, 40]).clamp(true);

var smallArcOptions = {
    width: 11,
    from: 5,
    to: function(d) { return smallArcScale(d.p); }
}
    

/**
    draw the small rose 50px
    @param array of samples by direction and sample of null
    ex : {    };
*/
function plotSmallRose(Data, container) {
    console.log('plotSmallRose',maxSpd(Data),maxSpl(Data),totalSpl(Data),(maxSpl(Data)/totalSpl(Data)+0.05).toFixed(2));
    smallArcScale = d3.scale.linear().domain([0,  (maxSpl(Data)/totalSpl(Data)+0.05).toFixed(2)]).range([5, 40]).clamp(true);
    var small = d3.select(container)
        .append("svg")
        .attr("id", "smallrose")
        .append("g")
        .attr("transform", "translate(" + [30, 30] + ")");
    var winds = [];
    var t = totalSpl(Data);

    for (var key in Data) {
        if (Data[key]['Dir']!='null')
            winds.push({d: Data[key]['Dir']*1, p: Data [key]['Spl'] / t, s: Data [key]['Spd']});
    }

    small.append("svg:g")
        .selectAll("path")
        .data(winds)
        .enter().append("svg:path")
        .attr("d", arc(smallArcOptions))
        .style({fill: '#58e', stroke: '#000', "stroke-width": '0.5px'})
        .append("svg:title")
        .text(function(d) { return d.d + "\u00b0 " + (100*d.p).toFixed(1) + "% " + (d.s).toFixed(1) + "km/h" });
        // .attr('title',function(d){ return 'p=' + d.p + '  d=' + d.d })

    small.append("svg:circle")
        .attr("r", smallArcOptions.from)
        .style({fill: '#fff', stroke: '#000', "stroke-width": '0.5px'});
}



function plotProbabilityRose(Data, container, R) {
    var winds = [],
        zero = [],
        t = totalSpl(Data),
        SplScale = maxSpl(Data)/t,
        visWidth = R;

    var p = 22,                      // padding on outside of major elements
        w = visWidth*2,
        h = visWidth*2,
        calm = 0,
        r = Math.min(w, h) / 2,      // center; probably broken if not square
        ip = 34;                     // padding on inner circle

    var svg = d3.select(container)
        .append("svg")
        .attr("id", "ProbabilityWindRose")
        .append("g")
        .attr("transform", "translate(" + [visWidth+p/2, visWidth+p/2] + ")")
        .attr("width", (w*2+p) + "px").attr("height", (h*2+p) + "px");

    for (var key in Data) {
        if (Data[key]['Dir']!='null') {
            zero.push({d: Data[key]['Dir']*1, p: 0, s: 0});
            winds.push({d: Data[key]['Dir']*1, p: Data [key]['Spl'] / t, s: Data [key]['Spd']});
        }
        else calm = Data [key]['Spl'];
    }

    if (SplScale>0.14) {
        probabilityToRadiusScale = d3.scale.linear().domain([0, (SplScale).toFixed(4)]).range([ip, visWidth]).clamp(true);
        var ticks = d3.range((SplScale/4).toFixed(4), (SplScale/4).toFixed(4)*4.001, (SplScale/4).toFixed(4));
        var tickmarks = d3.range((SplScale/4).toFixed(4), (SplScale/4).toFixed(4)*4.001*0.75, (SplScale/4).toFixed(4));
    }
    else {
        probabilityToRadiusScale = d3.scale.linear().domain([0, 0.15]).range([ip, visWidth]).clamp(true);
        var ticks = d3.range(0.05, 0.151, 0.05);
        var tickmarks = d3.range(0.05,0.101,0.05);
    }
    var tickLabel = function(d) { return "" + (d*100).toFixed(0) + "%"; }

    svg.append("circle")
        .attr("r", windProbabilityArcOptions.from)
        .style({fill: '#fff', stroke: '#000', "stroke-width": '0.5px'});

    // Circles representing chart ticks
    svg.append("g")
        .attr("class", "axes")
        .selectAll("circle")
        .data(ticks)
        .enter().append("circle")
        .attr("r", probabilityToRadiusScale);

    // Text representing chart tickmarks
    svg.append("g")
        .attr("class", "tickmarks")
        .selectAll("text")
        .data(tickmarks)
        .enter().append("text")
        .text(tickLabel)
        .attr("dy", "-3px")
        .attr("transform",  function(d) { return "translate(0," + -(probabilityToRadiusScale(d)) + ") " } );

    // Add the calm wind probability in the center
    var cw = svg.append("svg:g").attr("class", "calmwind")
        .selectAll("text")
        .data([calm/t])
        .enter();
        cw.append("svg:text")
            .text(function(d) { return Math.round(d * 100) + "%" });
        cw.append("svg:text")
            .attr("transform", "translate(0," + 14 + ")")
            .attr("class", "calmcaption")
            .text("calm");

    // Labels: degree markers
    var label = svg.append("svg:g")
        .attr("class", "labels")
        .selectAll("text")
        .data(d3.range(22.5, 361, 22.5))
        .enter().append("svg:g")
        .attr("dy", "-2px")
        .attr("transform", function(d) {
            return "translate(" + 0 + "," + -(r+1) + ") rotate(" + d + ",0," + (r+2) + ")"});
        label
            .append("title")
            .data(d3.range(22.5, 361, 22.5))
            .text(function(d) { return d + "\u00b0 "; });
        label
            .append("svg:text")
            .data(['NNE','NE','ENE','E','ESE','SE','SSE','S','SSW','SW','WSW','W','WNW','NW','NNW','N'])
            .text(function(d) { return d; });

    // draw each arc of Probability at 0%
    var ProbabilityArc = svg.append("g")
        .attr("id", "ProbabilityArc");
        ProbabilityArc.selectAll("path")
            .data(zero)
            .enter().append("path")
            .attr("d", arc(windProbabilityArcOptions))
            .style({fill: speedToColor, stroke: '#000', "stroke-width": '0.5px'});
        // draw each arc of Probability animated
        ProbabilityArc.selectAll("path")
            .data(winds)
            .append("title")
            .text(function(d) { return d.d + "\u00b0 \n" + (100*d.p).toFixed(1) + "% \n" + (d.s).toFixed(1) + "km/h" });
        ProbabilityArc.selectAll("path")
            .data(winds)
            .transition().duration(2000)
            .attr("d", arc(windProbabilityArcOptions))
            .style({fill: speedToColor, stroke: '#000', "stroke-width": '0.5px'});

    svg.selectAll("text").style( { font: "12px sans-serif", "text-anchor": "middle" });
    svg.selectAll(".calmwind text").style( { font: "16px sans-serif", "text-anchor": "middle" });
    svg.selectAll(".arcs").style( {  stroke: "#000", "stroke-width": "0.5px", "fill-opacity": 0.6 });
    svg.selectAll(".caption").style( { font: "18px sans-serif" });
    svg.selectAll(".axes").style( { stroke: "#aaa", "stroke-width": "0.5px", fill: "none" });
    svg.selectAll("text.labels").style( { "letter-spacing": "1px", fill: "#444", "font-size": "12px" });
    svg.selectAll("text.arctext").style( { "font-size": "9px" });
}








/**

*    draw the small rose 50px
    @param array of samples by direction and sample of null
    ex : {    };
    */
function historybar(Data, container) {
    console.log('historybar');
    var svg = d3.select(container).select("svg");
    var histobarre = svg.append("g")
        .attr("id", "histobarre")
        .attr("transform", "translate(" + [120, 60] + ")");
    var hist = [];
    // For every wind direction (note: skip plotData[0], winds calm)
    for (var keydate in Data) {
        // console.log(Data[keydate]);
        dominantWind = 0;
        _d = 0;
        _s = 0;
        _m = 0;
        _p = 0;
        for (var key in Data[keydate]) {
            //console.log(Data[keydate][key]);
            _p += Data[keydate][key]['Spl']*1;
            if (Data[keydate][key]['Spl']>_d && Data[keydate][key]['Dir']!='null') {
                _d = Data[keydate][key]['Dir']*1;
                _s = Data[keydate][key]['Spd']*1;
                _m = Data[keydate][key]['Max']*1;
            }
        }
        // console.log({t: keydate,dd: _d, dspd: _s, m: _m, p: _p});
        hist.push({t: keydate,dd: _d, ds: _s, m: _m, p: _p});
   }
    console.log(hist);

    histobarre.append("svg:g")
        .selectAll("path")
        .data(hist)
        .enter().append("svg:path")
        // .bottom(0)
        // .angle(0)
        // .startAngle(d3.scale.linear().range(-Math.PI / 2 - 1, -Math.PI / 2 + 1))
        .attr("d", arc(barOblic))
        .style({fill: '#58e', stroke: '#000', "stroke-width": '0.5px'})
        .append("svg:title")
        .text(function(d) { return d.dd + "\u00b0 " + d.ds + "kms" });
        // .attr('title',function(d){ return 'p=' + d.p + '  d=' + d.d })

    // histobarre.append("svg:circle")
    //     .attr("r", smallArcOptions.from)
    //     .style({fill: '#fff', stroke: '#000', "stroke-width": '0.5px'});
}