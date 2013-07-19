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

var svg = d3.select("#Details");


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
                          .domain([2, 10, 25, 100])
                          .range(["#fbb4ae","#b3cde3","#ccebc5","#decbe4"])
                          .interpolate(d3.interpolateHsl);
function speedToColor(d) { return speedToColorScale(d.s); }
// Map a wind probability to a color
var probabilityToColorScale = d3.scale.linear()
                                .domain([0, .5, .8, 1])
                                .range(["#AEC7E8","#1F77B4","#D62728","#2C3539"])// ["hsl(0, 70%, 99%)", "hsl(0, 70%, 40%)"])
                                .interpolate(d3.interpolateHsl);
function probabilityToColor(d) { return probabilityToColorScale(d.p); }
                                
// Width of the whole visualization; used for centering               
var visWidth = 240;

// Map a wind probability to an outer radius for the chart
var probabilityToRadiusScale = d3.scale.linear().domain([0, 0.15]).range([28, visWidth]).clamp(true);
function probabilityToRadius(d) { return probabilityToRadiusScale(d.p); }
// Map a wind speed to an outer radius for the chart
var speedToRadiusScale = d3.scale.linear().domain([0,  20]).range([28, visWidth]).clamp(true);
function speedToRadius(d) { return speedToRadiusScale(d.s); }
function maxToRadius(d) { return speedToRadiusScale(d.m); }

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
var windMaxArcOptions = {
    width: 8,
    from: maxToRadius,
    to: maxToRadius
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

var SpeedFactor = 3.6; // m/sec to km/h

/** Code for small wind roses **/
//
var maxSpl =  function(d) { return d3.max(d, function(d) { return d['Spl']; }); };

var totalSpl = function(d) { return d3.sum(d, function(d) { return d['Spl']; }); };

var maxSpd = function(d) { return d3.max(d, function(d) { return d['Max']; })*3.6; };

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
function histograph (data, container)
{
    var parseDate = d3.time.format("%Y-%m-%d").parse;

    var i=0;
    var list=[];
    for (var keydate in data) {
        // data [keydate].date= keydate;
        // data [keydate].step= ++i;
        // data [keydate].day= parseDate(keydate);
        list.push({
            datestr: keydate,
            step: ++i,
            // date: parseDate(keydate),
            subdata: data [keydate]
        });
    }

// add visible circle in background
    d3.select(container)
        .attr("width", (i*10+50) + "px")
        .append("g")
        .attr("id", "cercles")
        .selectAll("circle")
        .data(list)
        .enter()
        .append("circle")
            // .attr("id", function(d) { return "cercle-"+d.datestr; })
            .attr("cx", function(d) { return 20+10*d.step; })
            .attr("cy", 30)
            .attr("r", 5)
            .style({ fill: '#fff', stroke: '#000', "stroke-width": '0.5px'});

// add petals layer in middelground
    d3.select(container)
        .append("g")
        .attr("id", "petals");


// add events circle on forground with opacity 0%
    d3.select(container)
        .attr("width", (i*10+50) + "px")
        .append("g")
        .attr("id", "cercles")
        .selectAll("circle")
        .data(list)
        .enter()
        .append("circle")
            // .attr("id", function(d) { return "cercle-"+d.datestr; })
            .attr("cx", function(d) { return 20+10*d.step; })
            .attr("cy", 30)
            .attr("r", 5)
            .style({"fill-opacity": 0 })
            .on("mouseover",function (d){
                $('#petals')
                    .empty()
                d3.select('#petals')
                    .attr("transform", "translate(" + [20+10*d.step, 30] + ")");
                plotSmallRose(d.step, d.subdata, '#petals');
                // plotProbabilityRose(d.subdata, '#windrose', 120);
                // plotSpeedRose(d.subdata, '#windspeed',120);
            })
            .on("click",function (d){
                plotProbabilityRose(d.subdata, '#windrose', 120);
                plotSpeedRose(d.subdata, '#windspeed',120);
            })
            .append("svg:title")
            .text(function(d) { return d.datestr });
}
function plotSmallRose(step, Data, container) {
    // console.log('plotSmallRose',maxSpd(Data),maxSpl(Data),totalSpl(Data),(maxSpl(Data)/totalSpl(Data)+0.05).toFixed(2));
    var visWidth = 30;
    smallArcScale = d3.scale.linear().domain([0,  (maxSpl(Data)/totalSpl(Data)+0.05).toFixed(2)]).range([5, visWidth]).clamp(true);
    var small = d3.select(container)

    var winds = [];
    var t = totalSpl(Data);

    for (var key in Data) {
        if (Data[key]['Dir']!='null')
            winds.push(
                {
                    d: Data[key]['Dir']*1,
                    p: Data [key]['Spl'] / t,
                    s: Data [key]['Spd']*SpeedFactor,
                    m: Data [key]['Max']*SpeedFactor
                });
    }

    small.append("svg:g")
        .attr("id", "petals_"+step)
        .selectAll("path")
        .data(winds)
        .enter()
        .append("svg:path")
        .attr("d", arc(smallArcOptions))
        .style({fill: '#58e', stroke: '#000', "stroke-width": '0.5px'})
        // .append("svg:title")
        // .text(function(d) { return d.d + "\u00b0 " + (100*d.p).toFixed(1) + "% " + (d.s).toFixed(1) + " km/h\n Maxi : " + (d.m).toFixed(1) + " km/h"; });
        // .attr('title',function(d){ return 'p=' + d.p + '  d=' + d.d })
}

function MakeWindContainer(container, w,h,p) {
    var svg = d3.select(container)
        .append("svg")
        // .attr("id", idName)
        .style( { float: 'left' , position: 'relative', width: (w+p)+'px', height: (h+p)+'px'})
        .append("g")
        .attr("transform", "translate(" + [(w+p)/2, (h+p)/2] + ")")
        .attr("width", (w+p) + "px")
        .attr("height", (h+p) + "px");
    return svg;
}
function drawGird(svg, ticks, probabilityToRadiusScale) {
    // Circles representing chart ticks
    var g = svg.append("g")
        .attr("class", "axes")
        .selectAll("circle")
        .data(ticks)
        .enter().append("circle")
        .attr("r", probabilityToRadiusScale);
    return g;
}
function drawGirdScale(svg, tickmarks, tickLabel, probabilityToRadiusScale) {
    // Text representing chart tickmarks
    var g = svg.append("g")
        .attr("class", "tickmarks")
        .selectAll("text")
        .data(tickmarks)
        .enter().append("text")
        .text(tickLabel)
        .attr("dy", "-3px")
        .attr("transform",  function(d) { return "translate(0," + -(probabilityToRadiusScale(d)) + ") " } );
    return g;
}
function drawCalm (svg, form, data) {
    // Add the calm wind probability in the center
    svg.append("circle")
        .attr("r", form)
        .style({fill: '#fff', stroke: '#000', "stroke-width": '0.5px'});
    var cw = svg.append("svg:g").attr("class", "calmwind")
        .selectAll("text")
        .data(data)
        .enter();
        cw.append("svg:text")
            .attr("transform", "translate(0,-2)")
            .text(function(d) { return Math.round(d * 100) + "%" });
        cw.append("svg:text")
            .attr("transform", "translate(0,12)")
            .text("calm");
    return cw;
}
function drawLevelGird (svg, r) {
    // Labels: degree markers
    var label = svg.append("svg:g")
        .attr("class", "labels")
        .selectAll("text")
        .data(d3.range(22.5, 361, 22.5))
        .enter().append("svg:g")
        .attr("dy", "-2px")
        .attr("transform", function(d) {
            return "translate(" + 0 + "," + -(r+2) + ") rotate(" + d + ",0," + (r+2) + ")"});
        label
            .append("title")
            .data(d3.range(22.5, 361, 22.5))
            .text(function(d) { return d + "\u00b0 "; });
        label
            .append("svg:text")
            .data(['NNE','NE','ENE','E','ESE','SE','SSE','S','SSW','SW','WSW','W','WNW','NW','NNW','N'])
            .text(function(d) { return d; });
    return label;
}
function StyleIt (svg){
    svg.selectAll("text").style( { font: "10px sans-serif", "text-anchor": "middle" });
    svg.selectAll(".calmwind text").style( { font: "14px sans-serif", "text-anchor": "middle" });
    svg.selectAll(".arcs").style( {  stroke: "#000", "stroke-width": "0.5px", "fill-opacity": 0.6 });
    svg.selectAll(".arcs_max").style( {  stroke: "#000", "stroke-width": "0.5px", "fill-opacity": 0.1 });
    svg.selectAll(".caption").style( { font: "18px sans-serif" });
    svg.selectAll(".axes").style( { stroke: "#aaa", "stroke-width": "0.5px", fill: "none" });
    svg.selectAll("text.labels").style( { "letter-spacing": "1px", fill: "#444", "font-size": "12px" });
    svg.selectAll("text.arctext").style( { "font-size": "9px" });
}


function plotProbabilityRose(Data, container, R, clear) {
    var winds = [], zero = [], t = totalSpl(Data), SplScale = maxSpl(Data)/t, visWidth = R;

    var p = 22,                      // padding on outside of major elements
        r = visWidth, w = h = visWidth*2,
        calm = 0,
        ip = 28;                     // padding on inner circle
    windProbabilityArcOptions.from = ip-2;

    $(container).empty();

    var svg = MakeWindContainer(container, w,h,p);

    for (var key in Data) {
        if (Data[key]['Dir']!='null') {
            zero.push({d: Data[key]['Dir']*1, p: 0, s: 0, m: 0});
            winds.push(
            {
                d: Data[key]['Dir']*1,
                p: Data [key]['Spl'] / t,
                s: Data [key]['Spd']*SpeedFactor,
                m: Data [key]['Max']*SpeedFactor
            });
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

    drawGird (svg, ticks, probabilityToRadiusScale);
    drawGirdScale (svg, tickmarks, function(d) { return "" + (d*100).toFixed(0) + " %"; }, probabilityToRadiusScale);
    drawCalm (svg, windProbabilityArcOptions.from, [calm/t]);
    drawLevelGird (svg, r);

    // draw each arc of Probability at 0%
    var ProbabilityArc = svg.append("g")
        .attr("class", "ProbabilityArc");
        ProbabilityArc.selectAll("path")
            .data(zero)
            .enter().append("path")
            .attr("d", arc(windProbabilityArcOptions))
            .attr("class", "arcs")
            .style({fill: speedToColor, stroke: '#000', "stroke-width": '0.5px'});
        // draw each arc of Probability animated
        ProbabilityArc.selectAll("path")
            .data(winds)
            .append("title")
            .text(function(d) {return d.d + "\u00b0 \n" + (100*d.p).toFixed(1) + " % \n" + (d.s).toFixed(1) + " km/h\nMaxi : " + (d.m).toFixed(1) + " km/h"; });
        ProbabilityArc.selectAll("path")
            .data(winds)
            .transition().delay(function(d) { return d.d*0;}).duration(500)
            .attr("d", arc(windProbabilityArcOptions))
            .style({fill: speedToColor, stroke: '#000', "stroke-width": '0.5px'});
    StyleIt(svg);
}


function plotSpeedRose(Data, container, R) {
    var winds = [], zero = [], t = totalSpl(Data), SpdScale = maxSpd(Data), visWidth = R;

    var p = 22,                      // padding on outside of major elements
        r = visWidth, w = h = visWidth*2,
        calm = 0,
        ip = 28;                     // padding on inner circle
        windSpeedArcOptions.from = ip-2;//,

    $(container).empty();

    var svg = MakeWindContainer(container, w,h,p);

    for (var key in Data) {
        if (Data[key]['Dir']!='null') {
            zero.push({d: Data[key]['Dir']*1, p: 0, s: 0, m: 0});
            winds.push(
            {
                d: Data[key]['Dir']*1,
                p: Data [key]['Spl'] / t,
                s: Data [key]['Spd']*SpeedFactor,
                m: Data [key]['Max']*SpeedFactor
            });
        }
        else calm = Data [key]['Spl'];
    }

    if (SpdScale>6) {
        speedToRadiusScale = d3.scale.linear().domain([0, (SpdScale).toFixed(4)]).range([ip, visWidth]).clamp(true);
        var ticks = d3.range((SpdScale/4).toFixed(4), (SpdScale/4).toFixed(4)*4.001, (SpdScale/4).toFixed(4));
        var tickmarks = d3.range((SpdScale/4).toFixed(4), (SpdScale/4).toFixed(4)*4.001*0.75, (SpdScale/4).toFixed(4));
    }
    else {
        speedToRadiusScale = d3.scale.linear().domain([0, 6]).range([ip, visWidth]).clamp(true);
        var ticks = d3.range(2, 6.01, 2);
        var tickmarks = d3.range(2, 4.01, 2);
    }

    drawGird (svg, ticks, speedToRadiusScale);
    drawGirdScale (svg, tickmarks, function(d) { return "" + (d).toFixed(1) + " km/h"; }, speedToRadiusScale);
    drawCalm (svg, windSpeedArcOptions.from, [calm/t]);
    drawLevelGird (svg, r);

    // draw each max of Probability at 0%
    var SpeedArc = svg.append("g")
        .attr("class", "speedArc");
        SpeedArc.selectAll("path")
            .data(zero)
            .enter().append("path")
            .attr("d", arc(windMaxArcOptions))
            .attr("class", "arcs_max")
            .style({fill:'#fff', stroke: '#222', "stroke-width": '0.5px'});
        // draw each arc of Probability animated
        SpeedArc.selectAll("path")
            .data(winds)
            .append("title")
            .text(function(d) { return 'Maxi : ' + (d.m).toFixed(1) + " km/h" });
        // draw each arc of Probability animated
        SpeedArc.selectAll("path")
            .data(winds)
            .transition().delay(function(d) { return d.d*0;}).duration(500)
            .attr("d", arc(windMaxArcOptions))
            .style({fill:'#fff', stroke: '#222', "stroke-width": '1.5px'});

    // draw each arc of Probability at 0%
    var SpeedArc = svg.append("g")
        .attr("class", "speedArc");
        SpeedArc.selectAll("path")
            .data(zero)
            .enter().append("path")
            .attr("d", arc(windSpeedArcOptions))
            .attr("class", "arcs")
            .style({fill: probabilityToColor, stroke: '#000', "stroke-width": '0.5px'});
        // draw each arc of Probability animated
        SpeedArc.selectAll("path")
            .data(winds)
            .append("title")
            .text(function(d) { return d.d + "\u00b0 \n" + (100*d.p).toFixed(1) + " % \n" + (d.s).toFixed(1) + " km/h\n Maxi : " + (d.m).toFixed(1) + " km/h" });
        SpeedArc.selectAll("path")
            .data(winds)
            .transition().delay(function(d) { return d.d*0;}).duration(500)
            .attr("d", arc(windSpeedArcOptions))
            .style({fill: probabilityToColor, stroke: '#000', "stroke-width": '0.5px'});

    StyleIt(svg);
}




/**

*    draw the small rose 50px
    @param array of samples by direction and sample of null
    ex : {    };
    */
function historybar(Data, container) {

    console.log('historybar');
    var svg = d3.select(container).append("svg");

    var histobarre = svg.append("g")
        .attr("id", "histobarre")
        .attr("transform", "translate(100,100)");

    var his = [],hist = [], keys = [], i=0;
    // For every wind direction (note: skip plotData[0], winds calm)
    for (var keydate in Data) {
        // console.log(Data[keydate]);
        // dominantWind = 0;
        radian = 0;
        speed = 0;
        mspeed = 0;
        probability = 0;
        // p = 0;
        for (var key in Data[keydate]) {
            if (Data[keydate][key]['Spl']>probability && Data[keydate][key]['Dir']!='null') {
                radian = Data[keydate][key]['Dir'];
                speed = Data[keydate][key]['Spd'];
                mspeed = Data[keydate][key]['Max'];
                probability = Data[keydate][key]['Spl'];
            }
        }
        // console.log({t: keydate, r: radian, s: speed, m: mspeed, p: p});
        his.push({r: radian, s: Math.round(speed*100)/100});
        hist.push({i: i++,t: keydate, r: radian, s: Math.round(speed*100)/100, m: Math.round(mspeed*100)/100, p:probability});
        keys.push(keydate);

   }

    X = d3.scale.linear().domain([0,100]).range([0, 800]); // d3.time.scale()

    var spdLine = d3.svg.line.radial()
        .interpolate("basis")
        // .attr("transform", "translate(0," + function(d) { console.log(d); return X(d) } + ")" )
        .radius(function(d) { console.log(d.s); return d.s*10; })
        .angle(function(d) { console.log(d.r); return d.r*Math.PI / 180; });

    histobarre
        .selectAll("path")
        .data(his)
        .enter()
        .append("path")
            .style({fill: '#58e', stroke: '#000', "stroke-width": '2px'})
            .attr("d", spdLine);

}
