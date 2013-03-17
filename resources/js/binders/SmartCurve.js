var parse = d3.time.format("%Y-%m-%d %H:%M").parse,
    format = d3.time.format("%Y");

var svg, area, line, gradient, x, y, xAxis, yAxis;
    var color = d3.scale.category20();
var Zoomlevel, TranslateXY, TimeDomain;
var ZmMin = 1,
    ZmMax = 1000;
var curve1, rect;
var url_=null, ajaxWork = false;

function drawGraph (data, container, w, h) {
    var m = [5, 15, 20, 35], // [haut, droite, bas, gauche]
    w = w - m[1] - m[3],
    h = h - m[0] - m[2];

    $(container).empty();

    x = d3.time.scale().range([0, w]);
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

    svg.append("svg:g")
        .attr("class", "x axis")
        .attr("transform", "translate(0," + h + ")");

    svg.append("svg:path")
        .attr("class", "line")
        .style("stroke", function(d) { return color('courbe1'); })
        .attr("clip-path", "url(#clip)");

    rect = svg.append("svg:rect")
        .attr("class", "pane")
        .attr("width", w)
        .attr("height", h);

    // A line generator.
    line = d3.svg.line()
        .interpolate("linear")
        // .interpolate("basis")
        .x(function(d) { return x(d.date); })
        .y(function(d) { return y(d.val); });

        var dataRebuild = [];
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
    console.log(ymin, ymax, ymargin)

    // Bind the data to our path elements.
    curve1 = svg.select("path.line").data([data]);

    var circle = svg.append("circle")
            .attr("r", 8)
            .attr("cx", 0)
            .attr("cy", 0)
            .style({fill: '#fff', 'fill-opacity': .2, stroke: '#000', "stroke-width": '1px'})
            .attr("opacity", 0);
    var infoBulle = circle.append("svg:title");

    hoverLineXOffset = m[3];

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

        circle.attr("opacity", 1)
            .attr("cx", pos.x)
            .attr("cy", pos.y);
            
        dataIndex = pathEl.getPathSegAtLength((findX-BBox.x)/BBox.width*pathLength);
        infoBulle.text(pathData[0][dataIndex]['date'] + "\n" + pathData[0][dataIndex]['val']);
        });

    rect.call(zm=d3.behavior.zoom().x(x).scaleExtent([ZmMin,ZmMax]).on("zoom", function(){
        window.clearTimeout(timeoutID);
        timeoutID = window.setTimeout(function(){zoom()}, 400);
        draw();
    }));
    draw();
}

function draw () {
    // trace la courbe
    svg.select("path.line").attr("d", line);    
    // trace l'axe X
    svg.select("g.x.axis").call(xAxis);
    var data = curve1.data()[0];
    ymin = d3.min(data.map(function(d) { return d.val; }));
    ymax = d3.max(data.map(function(d) { return d.val; }));
    ymargin = (ymax - ymin)/50;
    y.domain([ymin-ymargin, ymax+ymargin]);
    // // trace l'axe Y
    svg.select("g.y.axis").transition().duration(1000).call(yAxis);

    // trace la courbe
    svg.select("path.line").transition().duration(1000).attr("d", line);    
}

var timeoutID=null;

function zoom() {
    var Zoomlevel = zm.scale();

    url = "/data/curve?station="+station+"&sensor="+sensor+"&Since="+formatDate(x.domain()[0])+"&To="+formatDate(x.domain()[1]);
    // if (   Zoomlevel == ZmMax // on est au zoom maxi
    //     || Zoomlevel == ZmMin 
    //     || ( firstData.date.getTime() > TimeDomain[0]-TimeMargin 
    //         || lastData.date.getTime() < TimeDomain[1]+TimeMargin) ) {// on est au zoom mini
    if (Zoomlevel>1)
        pullData(url);
    else
    {
        curve1.data([dataFullView]);
        draw();
    }
}

function pullData(url) {
    d3.tsv(url, function(error, tsv) {
        if (error) {
            console.warn(error);
        }
        else {
            tsv.forEach(function(d) {
                d.date = parse(d.date);
                d.val = +d.val;
            });

            tsv = replaceInside(tsv);
            curve1.data([tsv]);
            draw();
        }
    });
}

function replaceInside (middleData) {
    previousData = dataFullView.filter(function(element, index, array){
        return (element.date<middleData[0].date);
    });
    
    nextData = dataFullView.filter(function(element, index, array){
        return (element.date>middleData[middleData.length-1].date);
    });
    return previousData.concat(middleData, nextData);
}