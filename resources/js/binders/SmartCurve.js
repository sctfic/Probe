var parse = d3.time.format("%Y-%m-%d %H:%M").parse,
    format = d3.time.format("%Y");

var svg, area, line, gradient, x, y, xAxis, yAxis;
    var color = d3.scale.category20();
var curve1, rect;
var url_=null, reversibleData = null;
var Y_val=0, X_date=0, X_px=1, Y_px=1;


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
        .attr("id", "xaxis")
        .attr("transform", "translate(0," + h + ")");

    svg.append("svg:path")
        .attr("class", "line")
        // .style("fill", function(d) { return color('courbe1'); })
        .style("stroke", function(d) { return color('courbe1'); })
        .attr("clip-path", "url(#clip)");

    rect = svg.append("svg:rect")
        // .attr("id","droppable")
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
    // data.forEach(function(d) {
    //     d.date = parse(d.date);
    //     d.val = +d.val;
    //     // reversibleData[d.date]=d.val;
    // });

    x.domain(d3.extent(data.map(function(d) { return d.date; })));
    ymin = d3.min(data.map(function(d) { return d.val; }));
    ymax = d3.max(data.map(function(d) { return d.val; }));
    ymargin = (ymax - ymin)/50;
    y.domain([ymin-ymargin, ymax+ymargin]);

    // Bind the data to our path elements.
    curve1 = svg.select("path.line").data([data]);

    var legend1 = svg.append('text')
            .text('Scroll for Zoom')
            .attr('id', 'Cursor_' + 'courbe1')
            .attr('x', w-200)
            .attr('y', h-8)
            .style("fill", function(d) { return color('courbe1'); });
            // .style("stroke", '#000');
            // .attr('fill', color('courbe1'))​;

    var circle = svg.append("circle")
            .attr("r", 8)
            .attr("cx", 0)
            .attr("cy", 0)
            .style({fill: '#fff', 'fill-opacity': .2, stroke: '#000', "stroke-width": '1px'})
            .attr("opacity", 0);
    var infoBulle = circle.append("svg:title");

    rect.on("mousemove", function() {
        X_px = d3.mouse(this)[0];
        X_date = x.invert(X_px);
            
        Y_px = y(Y_val);
        var pathData = curve1.data()[0]; // recupere donnée de la courbe

        pathData.forEach(function(element, index, array) {
            if ((index+1 < array.length) && (array[index].date <= X_date) && (array[index+1].date >= X_date)) {
                if (X_date-array[index].date < array[index+1].date-X_date) {
                    Y_val = array[index].val;
                    X_date = array[index].date;
                } else {
                    Y_val = array[index+1].val;
                    X_date = array[index+1].date;
                }
                X_px=Math.round(x(X_date));
                Y_px=Math.round(y(Y_val));
            }
        });
        circle.attr("opacity", 1)
            .attr("cx", X_px)
            .attr("cy", Y_px);
        legend1.text("X = " + formatDate(X_date,' ') + " , Y = " + (Y_val));
        infoBulle.text("X = " + (X_date) + "\nY = " + (Y_val));

    });

    rect.call(zm=d3.behavior.zoom().x(x).scaleExtent([1,1000]).on("zoom", function(){
        window.clearTimeout(timeoutID);
        timeoutID = window.setTimeout(function(){zoom()}, 400);
        draw ();
    }));
    console.log(zm);
    draw ();
}

function draw () {
    // trace la courbe
    svg.select("path.line").attr("d", line);    
    // trace l'axe X
    svg.select("g.x.axis").call(xAxis);
    // trace l'axe Y
    svg.select("g.y.axis").call(yAxis);
}
// function redraw (visibleData) {
//     ymin = d3.min(visibleData.map(function(d) { return d.val; }));
//     ymax = d3.max(visibleData.map(function(d) { return d.val; }));
//     ymargin = (ymax - ymin)/50;

//     // trace la courbe avec l'ancienne echelle en Y
//     svg.select("path.line").attr("d", line);    

//     // on redefini l'echelle en Y
//     y.domain([ymin-ymargin, ymax+ymargin]);
//     // trace l'axe Y
//     svg.select("g.y.axis").transition().duration(1000).call(yAxis);
//     // trace la courbe
//     svg.select("path.line").transition().duration(1000).attr("d", line);

//     // trace l'axe X
//     svg.select("g.x.axis").call(xAxis);
// }

var timeoutID=null;

function zoom() {
    var Zoomlevel = zm.scale();

    url = "/data/curve?station="+station+"&sensor="+sensor+"&Since="+formatDate(x.domain()[0])+"&To="+formatDate(x.domain()[1]);
    if (Zoomlevel>1)
        pullData(url);
    else // Zoomlevel == 1
    {
        curve1.data([dataFullView]);
        draw();
        // redraw(dataFullView);

        // on recentre la courbe sur les données initiale
        zm.translate([0,0]);
        svg.select("path.line").transition().duration(2000).attr("d", line);
        svg.select("g.x.axis").transition().duration(2000).call(xAxis);
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
                // reversibleData[d.date]=d.val;
            });
            visibleData = tsv;
 
            tsv = replaceInside(tsv);
            curve1.data([tsv]);

            draw();
            // redraw(visibleData);
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