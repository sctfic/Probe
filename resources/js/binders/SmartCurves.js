var parse = d3.time.format("%Y-%m-%d %H:%M").parse
var color = d3.scale.category20();
/**
make a curve object
    * @
    */
function curve(parent, init) {
    var ths = this;
    ths.parent = parent;
    ths.station = typeof init.station === 'string'  ? init.station : '';
    ths.sensor = typeof init.sensor === 'string' ? init.sensor : '';
    ths.id = ths.parent.curves.length; // Base64.encode(ths.station+'-'+ths.sensor);

    ths.dark = color(ths.id);
    ths.bright = color(ths.id+'2');

    ths.parent.svg().append("svg:path")
        .attr("id", "line-"+ths.id)
        .attr("class", "line")
        .style("stroke", ths.dark)
        .attr("clip-path", "url(#maskArea)");
    ths.url =  "/data/curve?station="+ths.station+"&sensor="+ths.sensor;
    // console.log(ths.parent);
    ths.data={
        initial:init.data,
        // current:[],
        visible:[]
        }


    ths.xAxis = d3.svg.axis().scale(ths.parent.xRange).orient("bottom");
    ths.xDomain = ths.parent.xRange.domain(d3.extent(ths.data.initial.map(function(d) { return d.date; })));

    // Shallow copy
    // var newObject = jQuery.extend({}, oldObject);
    // Deep copy
    // var ths.yRange = $.extend(true, {}, ths.parent.yRange );

    ths.yAxis = d3.svg.axis().scale(ths.parent.yRange).orient("left");
    ths.yDomain = ths.parent.yRange.domain(d3.extent(ths.data.initial.map(function(d) { return d.val; })));

console.log ('ths.parent.xRange.domain()=', ths.parent.xRange.domain());

    // define the line generator
    ths.line = d3.svg.line()
        .interpolate("linear")
        .x(function(d) { return ths.xDomain(d.date); })
        .y(function(d) { return ths.yDomain(d.val); });

    // ths.legend = function(){
        if (!d3.select('#LegendSpot-' + ths.id)[0][0]) {
            console.log('add <legend> '+ths.id);
            ths.legend = ths.parent.svg().append('text')
                .text('none')
                .attr('id', 'LegendSpot-' + ths.id)
                .attr('class', 'Legend')
                .attr('x', ths.parent._innerWidth()-100)
                .attr('y', ths.parent._innerHeight()-2-14*ths.id)
                .style({fill: ths.dark/*, display: "none"*/});
        }
    // };

    // ths.spot = function(){
        if (!d3.select('#Spot-' + ths.id)[0][0]) {
            console.log('add <spot> '+ths.id);
            ths.spot = ths.parent.svg().append("circle")
                .attr('id', 'Spot-' + ths.id)
                // .on('mouseover', function() {
                //         // d3.selectAll('.Legend').style({display: "none"});
                //         // d3.select('#LegendSpot-' + ths.id).style({display: "block"});
                //         d3.selectAll('.line').style({'stroke-width': '1px', 'stroke-opacity':.5});
                //         d3.select('#line-' + ths.id).style({'stroke-width': '2px', 'stroke-opacity':1});
                //     })
                .attr("r", 6)
                .attr("cx", 0)
                .attr("cy", 0)
                .style({fill: '#FFF', 'fill-opacity': .1, stroke: ths.dark, "stroke-width": '1.8px'});
                // .attr("opacity", 0);
                // .append("svg:title");
        }
    // };

    ths.draw = function(){
        // trace la courbe
        console.log('CurveDraw <curve> '+ths.id);
        ths.curvePtr = ths.parent.svg().select('#line-'+ths.id)
            .data([ths.data.initial])
            .attr("d", ths.line);
        ths.parent.svg().select("#xAxis").call(ths.xAxis);
        console.log ([ths.data.initial]);
        };
    ths.zoom = function(){
        console.log('CurveZoom <curve> ' + ths.id);
        ths.parent.svg().select("#xAxis").call(ths.xAxis);
        ths.parent.svg().select('#line-'+ths.id).attr("d", ths.line);
        // trace l'axe Y
        // svg.select("g.y.axis").call(ths.yDomain);

        };
    ths.infos = function(px, date){
        var currentData = ths.curvePtr.data()[0]; // recupere donnée de la courbe
        currentData.forEach( function(element, index, array) {
            if ((index+1 < array.length) && (array[index].date <= date) && (array[index+1].date >= date)) {
                if (date-array[index].date < array[index+1].date-date) {
                    val = array[index].val;
                    date = array[index].date;
                } else {
                    val = array[index+1].val;
                    date = array[index+1].date;
                }
                px=Math.round(ths.parent.xRange(date));
                py=Math.round(ths.yDomain(val));
            }
        });
        console.log(d3.extent(ths.data.initial.map(function(d) { return d.val; })));
        ths.spot
            .attr("cx", px)
            .attr("cy", py);
        ths.legend.text((val));
   }
    ths.draw();
}


/** *******************************************************************************************************
make a graphical object
    * @    
    * @param {Object} of inner property without Underscore
    */
function graph(init) {
    var ths = this;
    ths.container = init.container ? (typeof init.container === 'string' ? $(init.container) : init.container) : null;

    ths.width = function() {
        // console.log('ths.width', ths.container.width(),ths.container.selector);
        return init.width ? init.width : (ths.container ? (ths.container.width()>40?ths.container.width():320) : 320)};        // total container size
    ths.height = function() {
        // console.log('ths.height', init.height, ths.container.height(), ths.container.selector);
        return init.height ? init.height : (ths.container ? (ths.container.height()>20?ths.container.height():160) : 160)};

    ths.padding = init.padding ? init.padding : {t:5, r:15, b:20, l:15};    // padding container size

    ths._innerWidth = function() {
        // console.log('ths._innerWidth', ths.container.width(), ths.padding.r, ths.padding.l);
        return ths.width()-ths.padding.r-ths.padding.l};    // calculated inner container size
    ths._innerHeight = function() {
        // console.log('ths._innerHeight', ths.container.height(), ths.padding.t, ths.padding.b);
        return ths.height()-ths.padding.t-ths.padding.b};

    ths._date = {
        min: init.since ? parse(init.since) : parse('2013-01-01 00:00'),
        max: init.to ? parse(init.to) : new Date() };

    ths.xRange = d3.time.scale().range([0, ths._innerWidth()]);
    ths.yRange = d3.scale.linear().range([ths._innerHeight(), 0]);

    ths.svg = function(){ // return ptr to <svg>
        if (!d3.select('#gBlock')[0][0]) {
            w=ths.width(); // on utilise des variables intermediaire car on ne peut pas mesurer un object que l'on modifie en meme temp
            h=ths.height();
        // console.log('ths', ths, w, h);
            var svg = d3.select(ths.container.selector).append("svg:svg")
                .attr("id", "svgBlock")
                .attr("width", w)
                .attr("height", h)
                .append("svg:g")
                .attr("id", "gBlock")
                .attr("transform", "translate(" + ths.padding.l + "," + ths.padding.t + ")");
        // console.log('ths.svg', ths.container.height(), ths.height());

            console.log('add <svg>');
            return svg;
        }
        return d3.select('#gBlock');
        };
    ths.ZoomObj = null;
    ths.timeoutID = null;

    ths.Sensitive = function() { // return ptr to <clipPath>
        if (!d3.select('#Sensitive')[0][0]) {
            ths.svg().append("svg:clipPath")   // drawing mask area
                .attr("id", "maskArea")
                .append("svg:rect")            // invisible black rectangle is my mask
                .attr("x", 0)
                .attr("y", 0)
                .attr("width",  ths._innerWidth()+1 - 0)
                .attr("height", ths._innerHeight()+1 - 0);

           var area = ths.svg()
                .append("svg:rect")
                .attr("id", "Sensitive")
                .attr("x", 0)
                .attr("y", 0)
                .attr("width",  ths._innerWidth()+1 - 0)
                .attr("height", ths._innerHeight()+1 - 0);

            area.on("mousemove", function() {
                px = d3.mouse(this)[0];             // position en X de la sourie en pixel
                date = ths.xRange.invert(px);    // Date correspondant a cette position
                ths.curves.forEach( function(element, index, array) {
                    element.infos(px, date);
                });
                ths.LegendDate.text(formatDate(date,' '));
                // console.log('event <MouseMove>', px, date);
                });

            console.log('add <clipPath>');
            return area;
            
        }
        return d3.select('#Sensitive');
        };

    ths.Axes = function() {
        if (!d3.select('#xAxis')[0][0]) {
            ths.svg().append("svg:g")
                .attr("class", "x axis")
                .attr("id", "xAxis")
                .attr("transform", "translate(0," + ths._innerHeight() + ")");
            console.log('add <xAxes>');
        }
        // if (!d3.select('#yAxis')[0][0]) {
        //     ths.svg().append("svg:g")
        //         .attr("class", "y axis")
        //         .attr("id", "yAxis")
        //         .attr("transform", "translate(0,0)");
        //     console.log('add <yAxes>');
        // }
        ths.LegendDate = ths.svg().append('text')
            .text('none')
            .attr('id', 'LegendDate')
            .attr('class', 'Legend')
            .attr('x', ths._innerWidth()-260)
            .attr('y', ths._innerHeight()-2);
        };

    ths.draw = function() {
        // console.log (ths.xRange, ths.ZoomObj.scale(), ths.ZoomObj.translate(), ths.xAxis.scale());
        // trace l'axe X
        // ths.svg().select("#xAxis").call(ths.xAxis);

        console.log('draw <xAxis> none!');

        ths.curves.forEach( function(element, index, array) {
                console.log('draw <curve> '+index);
                // trace la courbe
                // ths.svg().select("#line-"+index).attr("d", ths.line);
                // element.draw();
            });
        };

    ths.cls = function(){ // clear container and remove <svg>
        console.log('cls <svg>');
        $('#svgBlock').remove();
        };

    ths.curves = [];

    ths.addCurve = function(_station,_sensor){
        var line = ths.curves.length;
        ths.pullData(
                "/data/curve?station="+_station+"&sensor="+_sensor,
                function(objGrapgh, data){
                    // console.log(objGrapgh);
                    objGrapgh.curves[objGrapgh.curves.length] = new curve(objGrapgh, {data: data, station:_station, sensor:_sensor});
                    // ths.svg().select("#xAxis").call(ths.xAxis);
                }
            );
            console.log('adding <line> ');
        };

    // ths.rmAllCurves = function(){
    //         ths.draw();
    //     };

    // ths.refresh = function(){
    //         ths.draw();
    //     };

    ths.zoom = function(){
console.log (ths.ZoomObj.scale(), 'ths.xRange.domain()=', ths.xRange.domain());
        // trace l'axe X
        // ths.svg().select("#xAxis").call(ths.xAxis);
        ths.curves.forEach( function(element, index, array) {
                element.zoom();
            });
            // ths.draw();
        };

    // ths.redraw = function(){
    //     ths.draw();
    //     };

    ths.pullData = function(url, myCallBack){
        console.log('pullData',url);
        d3.tsv(url, function(error, tsv) {
        console.group("Ajax Query");
            if (error) {
                console.warn(error);
                tsv=[];
            }
            else {
                tsv.forEach(function(d) {
                    d.date = parse(d.date);
                    d.val = +d.val;
                    // reversibleData[d.date]=d.val;
                });
                myCallBack(ths, tsv);
                ths.ZoomObj = d3.behavior.zoom()
                                        .x(ths.xRange)
                                        .scaleExtent([1,1000])
                                        .on("zoom", function() {
                                            window.clearTimeout(ths.timeoutID);
                                            ths.timeoutID = window.setTimeout(function() {
                                                    ths.zoom();
                                                    console.log('event <Improove granularity>');
                                                },
                                                400); // Delay (in ms) before request new data
// console.log ('ths.xRange.domain()=', ths.xRange.domain());
                                            ths.zoom ();
                                        }
                                    );
                ths.Sensitive.call( ths.ZoomObj );

                // console.log(objGrapgh);
            }
            console.log('Data Avaible',url);
            console.groupEnd();
            return tsv;
        });
        };

// ths.init = function(){ // clear container and remove <svg>
    ths.cls();
    ths.Sensitive();
    ths.Axes();

// };
}
















    var graphs;
$(document).ready(function(){
    if (station=='') console.error('Aucune station definie !');
    console.group("Drawing SmartCurves");
    graphs = new graph({container: '#SvgZone'});

        // graphs.curves[0] = new curve({station:'VP2_GTD',sensor:'Sensor1'});
        // graphs.init();
        graphs.addCurve(station, 'TA:Arch:Temp:Out:Average');
        // graphs.addCurve(station, 'TA:Arch:Various:Solar:Radiation');
        graphs.addCurve(station, 'TA:Arch:Various:Bar:Current');
        // graphs.addCurve(station, 'TA:Arch:Various:UV:IndexAvg');
        // graphs.addCurve(station, 'TA:Arch:Various:Wind:SpeedAvg');
        // graphs.addCurve(station, 'TA:Arch:Various:RainFall:Sample');

//    console.log(graphs);
    console.groupEnd();
});

$(window).resize(function() {
    console.log('window size has changed', $(window).width());
});