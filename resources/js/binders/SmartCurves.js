/**
make a curve object
	* @
	*/
function curve(init) {
	this.station = typeof init.station === 'string'  ? init.station : '';
	this.sensor = typeof init.sensor === 'string' ? init.sensor : '';
	// define the line generator
	this.line = d3.svg.line()
        .interpolate("linear")
        .x(function(d) { return this.parent._range.x(d.date); })
        .y(function(d) { return this.parent._range.y(d.val); });

console.log(this, this.parent);
        // .attr("class", "line")
        // .attr("id", 'Line'+this.curves.length)

	this.url = function(){
		return  "/data/curve?station="+this.station+"&sensor="+this.sensor; // +"&Since="+formatDate(x.domain()[0])+"&To="+formatDate(x.domain()[1]);
	}
	this._domain = {
		x:0,
		y:0
	}
	this.data={
		initial:[],
		// current:[],
		visible:[]
	}
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
		return init.width ? init.width : (this.container ? (this.container.width()>40?this.container.width():320) : 320)};		// total container size
	this.height = function() {
		// console.log('this.height', init.height, this.container.height(), this.container.selector);
		return init.height ? init.height : (this.container ? (this.container.height()>20?this.container.height():160) : 160)};

	this.padding = init.padding ? init.padding : {t:5, r:15, b:20, l:35};	// padding container size

	this._innerWidth = function() {
		// console.log('this._innerWidth', this.container.width(), this.padding.r, this.padding.l);
		return this.width()-this.padding.r-this.padding.l};	// calculated inner container size
	this._innerHeight = function() {
		// console.log('this._innerHeight', this.container.height(), this.padding.t, this.padding.b);
		return this.height()-this.padding.t-this.padding.b};

	this._range = {
		x:d3.time.scale().range([0, this._innerWidth()]),
		y:d3.scale.linear().range([this._innerHeight(), 0])
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
		        .attr("id", "clip")
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
		}	}

	this.cls = function(){ // clear container and remove <svg>
		console.log('cls <svg>');
		$('#svgBlok').remove();
		this.Sensitive();
		this.Axes();
		this.addCurve({station:'VP2_GTD',sensor:'Sensor1'});
	};

	this._date={min:0, max:999999999999};
	// this. = undefined;
	// this. = undefined;
	this.curves = {};

	this.addCurve = function(_station,_sensor){

		this.curves[0] = new curve({station:'VP2_GTD',sensor:'Sensor1'});
		this.curves[0].parent = this;
		// this.svg()
		console.log('add <Line'+this.curves.length+'>');
	};
	this.rmAllCurves = function(){

	};
	this.refresh = function(){

	};
	this.draw = function(){

	};
	this.redraw = function(){

	};

}
$(document).ready(function(){
	console.group("Drawing SmartCurves");
	var graphs = new graph({container: '#SvgZone'});

		// graphs.curves[0] = new curve({station:'VP2_GTD',sensor:'Sensor1'});
		graphs.cls();

	console.log(graphs);
	console.groupEnd();
});

$(window).resize(function() {
	console.log('window size has changed', $(window).width());
});