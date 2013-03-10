var parse = d3.time.format("%Y-%m-%d %H:%M").parse,
    format = d3.time.format("%Y");

var svg, area, line, gradient, x, y, xAxis, yAxis;
    var color = d3.scale.category20();
var Zoomlevel, TranslateXY, TimeDomain;
var ZmMin = 0.6,
    ZmMax = 2.29;
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


    rect = svg.append("svg:rect")
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
    curve1 = svg.select("path.line").data([data]);


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
        // console.log("here", x.domain()); // retourne la plage de temp affiché
        });

    rect.call(zm=d3.behavior.zoom().x(x).scaleExtent([ZmMin,ZmMax]).on("zoom", zoom));
    // rect.call(dg=d3.behavior.drag().origin(Object).on("dragstart", draw).on("drag", draw).on("dragend", dragend));

    // XTranslate;

    draw();
}

function draw () {
    // console.log("draw");

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


// function dragend() {
//     console.log("dragend");
//     if (!ajaxWork) {
//         var TimeDomain = x.domain();
//             TimeDomain[0] = TimeDomain[0].getTime();
//             TimeDomain[1] = TimeDomain[1].getTime();
//         var TimeMargin = (TimeDomain[1]-TimeDomain[0])/4;
//             first = new Date(TimeDomain[0]-TimeMargin*2);
//             last = new Date(TimeDomain[1]+TimeMargin*2);
//         var firstData = curve1.data()[0][0];
//         var lastData = curve1.data()[0][curve1.data()[0].length-1];
//         url = "/data/curve?station=VP2_GTD&sensor=TA:Arch:Various:Wind:HighSpeed&Since="+formatDate(first)+"&To="+formatDate(last);
//         if ( ( firstData.date.getTime() > TimeDomain[0]-TimeMargin // si la reserve de donnee a gauche est inferieur a 50%
//                 || lastData.date.getTime() < TimeDomain[1]+TimeMargin) ) { // si la reserve de donnee a droite est inferieur a 50% 
//             pullData(url);
//         }
//     }
//     draw();
//     eventFire(document,'click');
// }


function zoom() {
    // console.log("zoom");

    draw();
    if (!ajaxWork) {
        var Zoomlevel = zm.scale();
        // var TranslateXY = zm.translate();
        var TimeDomain = x.domain();
            TimeDomain[0] = TimeDomain[0].getTime();
            TimeDomain[1] = TimeDomain[1].getTime();
        var TimeMargin = (TimeDomain[1]-TimeDomain[0])/4;
            first = new Date(TimeDomain[0]-TimeMargin*2);
            last = new Date(TimeDomain[1]+TimeMargin*2);
        var firstData = curve1.data()[0][0];
        var lastData = curve1.data()[0][curve1.data()[0].length-1];
        url = "/data/curve?station=VP2_GTD&sensor=TA:Arch:Various:Wind:HighSpeed&Since="+formatDate(first)+"&To="+formatDate(last);
        if (   Zoomlevel == ZmMax // on est au zoom maxi
            || Zoomlevel == ZmMin 
            || ( firstData.date.getTime() > TimeDomain[0]-TimeMargin 
                || lastData.date.getTime() < TimeDomain[1]+TimeMargin) ) {// on est au zoom mini
                pullData(url);
            }
    }
}

function pullData(url)
{
    // rect.call(zm=d3.behavior.zoom().x(x).scaleExtent([ZmMin,ZmMax]).on("zoom", null));
    ajaxWork = true;
    d3.tsv(url, function(error, tsv) {
        if (error) {
            console.warn(error);
        }
        else {
            var d = new Date();
            // console.log (d.getSeconds());
            tsv.forEach(function(d) {
                d.date = parse(d.date);
                d.val = +d.val;
            });
            // if (tsv[0].date.getTime() != firstData.date.getTime()) {
                curve1.data([tsv]);
                rect.call(zm=d3.behavior.zoom().x(x).scaleExtent([ZmMin,ZmMax]).on("zoom", zoom));
                draw();
            // }
        }
        ajaxWork = false;
    });
}

function formatDate(value)
{

    var dd = value.getDate(); 
    var mm = value.getMonth()+1;//January is 0! 
    var yyyy = value.getFullYear();
    var H = value.getHours();
    var m = value.getMinutes()
    if(dd<10) dd='0'+dd ; 
    if(mm<10) mm='0'+mm ; 
    if(H<10) H='0'+H ; 
    if(m<10) m='0'+m ; 
   return yyyy + "-" + mm + "-" + dd + "T" + H + ":" + m  ;
}

function eventFire(el, etype){
  if (el.fireEvent) {
    (el.fireEvent('on' + etype));
  } else {
    var evObj = document.createEvent('Events');
    evObj.initEvent(etype, true, false);
    el.dispatchEvent(evObj);
  }
}