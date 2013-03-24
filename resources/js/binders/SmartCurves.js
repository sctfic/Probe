var parse = d3.time.format("%Y-%m-%d %H:%M").parse

/**
make a curve object
    * @
    */
function curve(parent, init) {
    this.parent = parent;
    this.station = typeof init.station === 'string'  ? init.station : '';
    this.sensor = typeof init.sensor === 'string' ? init.sensor : '';
    this.id=this.station+'-'+this.sensor;
    // define the line generator
    this.line = d3.svg.line()
        .interpolate("linear")
        .x(function(d) { return this.parent._range.x(d.date); })
        .y(function(d) { return this.parent._range.y(d.val); });

    this.url =  "/data/curve?station="+this.station+"&sensor="+this.sensor;
// console.log(this.parent);
    this.data={
        initial:this.parent.pullData(this.url),
        // current:[],
        visible:[]
    }
    this._domain = {// a ce moment la les donnee ne sont pas finis de chargee, ne sont pas dispo !
        x: this.parent._range.x.domain(d3.extent(this.data.initial.map(function(d) { return d.date; }))),
        y: this.parent._range.y.domain(d3.extent(this.data.initial.map(function(d) { return d.val; })))
    }
    this.legend = function(){
        if (!d3.select('#Legend' + this.id)[0][0]) {
            this.parent.svg().append('text')
                .text('Scroll for Zoom')
                .attr('id', 'Legend' + this.id)
                .attr('x', w-200)
                .attr('y', h-8)
                .style("fill", function(d) { return color(this.id); });
        }
    };
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

    this._Sensitive = undefined; // ptr to <clipPath>
    this.Sensitive = function(){ // return ptr to <clipPath>
        if (typeof this._Sensitive == 'undefined'){
            this._Sensitive = this.svg().append("svg:clipPath")
                .attr("id", "sensitive")
                .append("svg:rect")
                .attr("x", this._range.x(0))
                .attr("y", this._range.y(1))
                .attr("width", this._range.x(1) - this._range.x(0))
                .attr("height", this._range.y(0) - this._range.y(1));
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
        }    }

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
    // this. = undefined;
    // this. = undefined;
    this.curves = [];

    this.addCurve = function(_station,_sensor){
        var line = this.curves.length;
        this.curves[line] = new curve(this, {station:'VP2_GTD',sensor:'Sensor-'+line});
        console.log('add <line> '+line+' </line>');
        };
    this.rmAllCurves = function(){

        };
    this.refresh = function(){

        };
    this.draw = function(){

        };
    this.redraw = function(){

        };
    this.pullData = function(url){
        d3.tsv(url, function(error, tsv) {
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
            }
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

    console.log(graphs);
    console.groupEnd();
});

$(window).resize(function() {
    console.log('window size has changed', $(window).width());
});