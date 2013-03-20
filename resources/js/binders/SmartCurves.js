function curve() {
	this.station='';
	this.sensor='';
	this.url = function(){
		return  "/data/curve?station="+this.station+"&sensor="+this.sensor; // +"&Since="+formatDate(x.domain()[0])+"&To="+formatDate(x.domain()[1]);
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

	this.width = init.width ? init.width : 320;		// total container size
	this.height = init.height ? init.height : 160;

	this.padding = init.padding ? init.padding : {t:5, r:15, b:20, l:35};	// padding container size

	this._innerWidth = function() {return this.width-this.padding.r-this.padding.l};	// calculated inner containner size
	this._innerHeight = function() {return this.width-this.padding.t-this.padding.b};

	this._range = {
		x:d3.time.scale().range([0, this.innerWidth]),
		y:d3.scale.linear().range([this.innerHeight, 0])
	}
	this.container = init.container ? (typeof init.container === 'string' ? $(init.container) : init.container) : null;
	this._svg = undefined; // ptr to <svg>
	this.svg = function(){ // return ptr to <svg>
		if (typeof this._svg == 'undefined'){
			console.log('add <svg>');
			return d3.select(init.container).append("svg:svg")
				.attr("width", this.width)
				.attr("height", this.height)
				.append("svg:g")
				.attr("transform", "translate(" + init.padding.l + "," + init.padding.t + ")");
		}
		return this._svg;
	};
	this.cls = function(){ // clear container and remove <svg>
		console.log('cls <svg>');
		this.container.empty();
		this._svg = undefined;
		this.svg();
	}

	this._sensitive = undefined;
	this._date={min:0, max:999999999999};
	// this. = undefined;
	// this. = undefined;
	this.addCurve = function(station,sensor){

	};
	this.rmAllCurves = function(){

	};
	this.refresh = function(){

	};
	this.draw = function(){

	};
	this.redraw = function(){

	};
	this.curves = {};

}

var graphs = new graph({width:1000, height:200, container: '#SvgZone'});

	graphs.curves[0]=new curve();
	graphs.cls();

console.log(graphs);