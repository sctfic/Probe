var parse = d3.time.format("%Y-%m-%d %H:%M").parse
var color = d3.scale.category20();
/**
make a curve object
    * @
    */
function curve(parent, init) {
    this.parent = parent;
    this.station = typeof init.station === 'string'  ? init.station : '';
    this.sensor = typeof init.sensor === 'string' ? init.sensor : '';
    this.id = this.parent.curves.length; // Base64.encode(this.station+'-'+this.sensor);

    this.dark = color(this.id);
    this.bright = color(this.id+'2');

    this.parent.svg().append("svg:path")
        .attr("id", "line-"+this.id)
        .attr("class", "line")
        .style("stroke", this.dark)
        .attr("clip-path", "url(#maskArea)");
thisCurve = this;
    // define the line generator
    this.line = d3.svg.line()
        .interpolate("linear")
        .x(function(d) { return thisCurve.parent._range.x(d.date); })
        .y(function(d) { return thisCurve.parent._range.y(d.val); });

    this.url =  "/data/curve?station="+this.station+"&sensor="+this.sensor;
    // console.log(this.parent);
    this.data={
        initial:init.data,
        // current:[],
        visible:[]
        }
    this._domain = {// a ce moment la les donnee ne sont pas finis de chargee, ne sont pas dispo !
        x: this.parent._range.x.domain(d3.extent(this.data.initial.map(function(d) { return d.date; }))),
        y: this.parent._range.y.domain(d3.extent(this.data.initial.map(function(d) { return d.val; })))
        }

    // this.legend = function(){
        if (!d3.select('#LegendSpot-' + this.id)[0][0]) {
            console.log('add <legend> '+this.id);
            this.legend = this.parent.svg().append('text')
                .text('> xxxxxxxxxxxx-XXXXXXXXX')
                .attr('id', 'LegendSpot-' + this.id)
                .attr('class', 'Legend')
                .attr('x', this.parent._innerWidth()-200)
                .attr('y', this.parent._innerHeight()-8)
                .style({fill: this.dark, display: "none"});
        }
    // };

    // this.spot = function(){
        if (!d3.select('#Spot-' + this.id)[0][0]) {
            console.log('add <spot> '+this.id);
            this.spot = this.parent.svg().append("circle")
                .attr('id', 'Spot-' + this.id)
                .on('mouseover', function() {
                        d3.selectAll('.Legend').style({display: "none"});
                        d3.select('#Legend' + this.id).style({display: "block"});
                    })
                .attr("r", 8)
                .attr("cx", 0)
                .attr("cy", 0)
                .style({fill: this.bright, 'fill-opacity': .1, stroke: this.dark, "stroke-width": '1.2px'});
                // .attr("opacity", 0);
                // .append("svg:title");
        }
    // };
    this.draw = function(){
        // trace la courbe
        console.log('calculate each point')
        this.parent.svg().select('#line-'+this.id).data([this.data.initial]);
        this.parent.svg().select('#line-'+this.id).attr("d", this.line);
        // trace l'axe Y
        // svg.select("g.y.axis").call(this._domain.y);
        };
    this.zoom = function(){

        };
    this.infos = function(px, date){
        py = 100; // position en Y du spot sur la courbe en pixel
        val = 50; // valeur de chaque courbe correspondant a cette date
        // var pathData = curve1.data()[0]; // recupere donnée de la courbe
        // pathData.forEach( function(element, index, array) {
        //     if ((index+1 < array.length) && (array[index].date <= X_date) && (array[index+1].date >= X_date)) {
        //         if (X_date-array[index].date < array[index+1].date-X_date) {
        //             Y_val = array[index].val;
        //             X_date = array[index].date;
        //         } else {
        //             Y_val = array[index+1].val;
        //             X_date = array[index+1].date;
        //         }
        //         X_px=Math.round(x(X_date));
        //         Y_px=Math.round(y(Y_val));
        //     }
        // });
        this.spot
            .attr("cx", px)
            .attr("cy", py);
        this.legend.text("X = " + formatDate(date,' ') + " , Y = " + (val));
        // infoBulle.text("X = " + (X_date) + "\nY = " + (Y_val));
    }
    this.draw();
}


/**
make a graphical object
    * @    
    * @param {Object} of inner property without Underscore
    */
function graph(init) {

    this.container = init.container ? (typeof init.container === 'string' ? $(init.container) : init.container) : null;

    this.width = function() {
        // console.log('this.width', this.container.width(),this.container.selector);
        return init.width ? init.width : (this.container ? (this.container.width()>40?this.container.width():320) : 320)};        // total container size
    this.height = function() {
        // console.log('this.height', init.height, this.container.height(), this.container.selector);
        return init.height ? init.height : (this.container ? (this.container.height()>20?this.container.height():160) : 160)};

    this.padding = init.padding ? init.padding : {t:5, r:15, b:20, l:35};    // padding container size

    this._innerWidth = function() {
        // console.log('this._innerWidth', this.container.width(), this.padding.r, this.padding.l);
        return this.width()-this.padding.r-this.padding.l};    // calculated inner container size
    this._innerHeight = function() {
        // console.log('this._innerHeight', this.container.height(), this.padding.t, this.padding.b);
        return this.height()-this.padding.t-this.padding.b};

    this._range = {
        x: d3.time.scale().range([0, this._innerWidth()]),
        y: d3.scale.linear().range([this._innerHeight(), 0])
        };

    this._svg = undefined; // ptr to <svg>
    this.svg = function(){ // return ptr to <svg>
        if (typeof this._svg == 'undefined') {
            w=this.width(); // on utilise des variables intermediaire car on ne peut pas mesurer un object que l'on modifie en meme temp
            h=this.height();
        // console.log('this.svg', this.container.height(), this.height());
            this._svg = d3.select(this.container.selector).append("svg:svg")
                .attr("id", "svgBlok")
                .attr("width", w)
                .attr("height", h)
                .append("svg:g")
                .attr("transform", "translate(" + this.padding.l + "," + this.padding.t + ")");
        // console.log('this.svg', this.container.height(), this.height());

            console.log('add <svg>');
        }
        return this._svg;
        };

    this.CurrentZoom = null;
    this.timeoutID = null;

    this._Sensitive = undefined; // ptr to <clipPath>
    this.Sensitive = function() { // return ptr to <clipPath>
        if (!d3.select('#sensitive')[0][0]) {

            this.svg().append("svg:clipPath")   // drawing mask area
                .attr("id", "maskArea")
                .append("svg:rect")             // invisible black rectangle is my mask
                .attr("x", this._range.x(0))
                .attr("y", this._range.y(1))
                .attr("width", this._range.x(1) - this._range.x(0))
                .attr("height", this._range.y(0) - this._range.y(1));

            this._Sensitive = this.svg()
                .append("svg:rect")
                .attr("id", "sensitive")
                .attr("x", this._range.x(0))
                .attr("y", this._range.y(1))
                .attr("width", this._range.x(1) - this._range.x(0))
                .attr("height", this._range.y(0) - this._range.y(1));

            me = this;
            this._Sensitive.on("mousemove", function() {
                px = d3.mouse(me)[0];             // position en X de la sourie en pixel
                date = me._range.x.invert(px);    // Date correspondant a cette position
                this.curves.forEach( function(element, index, array) {
                    element.infos(px, date);
                });
                console.log('event <MouseMove>', px, date, me);
            });
            this._Sensitive.call(
                this.CurrentZoom = d3.behavior.zoom()
                                        .x(this._range.x)
                                        .scaleExtent([1,1000])
                                        .on("zoom", function() {
                                            window.clearTimeout(me.timeoutID);
                                            me.timeoutID = window.setTimeout(function() {
                                                // me.zoom();
                                                console.log('event <Improove granularity>', me);
                                            },
                                            400); // Delay (in ms) before request new data
                                            me.draw ();
                                        }
                                    )
                                );

            console.log('add <clipPath>');
        }
        return this._Sensitive;
        };

    this.Axes = function() {
        if (!d3.select('#xAxis')[0][0]) {
            this.svg().append("svg:g")
                .attr("class", "x axis")
                .attr("id", "xAxis")
                .attr("transform", "translate(0," + this._innerHeight() + ")");
            console.log('add <xAxes>');
        }
        if (!d3.select('#yAxis')[0][0]) {
            this.svg().append("svg:g")
                .attr("class", "y axis")
                .attr("id", "yAxis")
                .attr("transform", "translate(0,0)");
            console.log('add <yAxes>');
        }
        };

    this.cls = function(){ // clear container and remove <svg>
        console.log('cls <svg>');
        $('#svgBlok').remove();
        };
        // this.init = function(){ // clear container and remove <svg>
            this.cls();
            this.Sensitive();
            this.Axes();
        // };

    this._date={min:0, max:999999999999};

    this.curves = [];

    this.addCurve = function(_station,_sensor){
        var line = this.curves.length;
        this.pullData(
                "/data/curve?station="+'VP2_GTD'+"&sensor="+'TA:Arch:Temp:Out:Average',
                function(objGrapgh, data){
                    // console.log(objGrapgh, objGrapgh.curves, objGrapgh.curves[objGrapgh.curves.length]);
                    objGrapgh.curves[objGrapgh.curves.length] = new curve(objGrapgh, {data: data,station:'VP2_GTD',sensor:'TA:Arch:Temp:Out:Average'});
                }
            );
            console.log('adding <line> '+line);
        };


    this.draw = function() {
        // trace l'axe X
        this.svg().select("#xAxis").call(this.curves[0]._domain.x);

        this.curves.forEach( function(element, index, array) {
                element.draw();
            });
        };
    // this.rmAllCurves = function(){

    //     };
    // this.refresh = function(){

    //     };
    // this.zoom = function(){
    //     this.curves.forEach( function(element, index, array) {
    //             element.zoom();
    //         });
    //     };
    // this.redraw = function(){

    //     };
    this.pullData = function(url, myCallBack){
        var objGrapgh = this;
        // var myCallBack = callback;
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
                myCallBack(objGrapgh, tsv);

                // console.log(objGrapgh);
            }
            console.log('Data Avaible',url);
            console.groupEnd();
            return tsv;
        });
        };
}

















$(document).ready(function(){
    console.group("Drawing SmartCurves");
    var graphs = new graph({container: '#SvgZone'});

        // graphs.curves[0] = new curve({station:'VP2_GTD',sensor:'Sensor1'});
        // graphs.init();
        graphs.addCurve({station:'VP2_GTD',sensor:'TA:Arch:Temp:Out:Average'});

//    console.log(graphs);
    console.groupEnd();
});

$(window).resize(function() {
    console.log('window size has changed', $(window).width());
});