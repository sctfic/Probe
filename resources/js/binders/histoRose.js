/** histoRose.js
* D3 binder to visualize <dataset> data
*
* @category D3Binder
* @package  Probe
* @author   alban lopez <alban.lopez+probe@gmail.com>
* @license  http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode CC-by-nc-sa-3.0
* @link     http://probe.com/doc
*/

function include_histoRose(container, station, XdisplaySizePxl) {
    // on defini la fonction de convertion de nos dates (string) en Objet
    var formatDate = d3.time.format("%Y-%m-%d %H:%M:%S");

    // on definie notre objet au plus pres de notre besoin.
    var histoRose = timeSeriesChart_histoRose()
                        .width(XdisplaySizePxl)
                        .ajaxUrl("/data/windRose")
                        .station(station)
                        .date(function(d) { return formatDate.parse (d.key); })
                        .rose(function(d) { return d.value; })
                        .onClickAction(function(d) { console.error (d); })
                        .toHumanSpeed(formulaConverter ('WindSpeed', 'km/h'))
                        .toHumanAngle(formulaConverter ('angle', '°'))
                        .toHumanDate(formulaConverter ('strDate', 'ISO'));

    histoRose.loader(container);
}







// ================= Engine build chart of rose by period ====================

function timeSeriesChart_histoRose() {
    var margin = {top: 50, right: 50, bottom: 20, left: 30},
        width = 640,
        height = 160,
        dataheader = null,
        station = null,
        meanDate = function(d) { return d.date; },
        rose = function(d) { return d.rose; },
        angle = function(d) { return d.angle; },
        xSpeed = function(d) { return d.x; },
        ySpeed = function(d) { return d.y; },
        xScale = d3.time.scale().range([0, width]),
        yScale = d3.scale.linear().range([height, 0]),
        yDomain = [0, 1],
        xAxis = d3.svg.axis().scale(xScale).orient("bottom").tickSize(8,0),
        yAxis = d3.svg.axis().scale(yScale).orient("left").ticks(4).tickSize(3,0),
        onClickAction = function(d) { console.log(d); },
        toHumanSpeed = function(d) { return +d; },
        toHumanAngle = function(d) { return +d; },
        toHumanDate = function(d) { return d; },
        ajaxUrl = "";

        // line = d3.svg.line().x(X).y(Y);


    function chart(selection) {
        //selection represente la liste de block ou ecire les donnees
        selection.each(function(data) {
            // Convert data to standard representation greedily;
            // this is needed for nondeterministic accessors.
            data = data.map(function(d, i) {
                // console.log(data, d, i);
                return {
                    date:meanDate.call(data, d, i),
                    rose:rose.call(data, d, i)
                };
            });

            // Update the x-scale.
            xScale
                .domain(d3.extent(data, function(d) { return d.date; }))
                .range([0, width - margin.left - margin.right]);

            // Update the y-scale.
            yScale
                .domain(d3.extent(data, function(d) {return d.ySpeed; }))
                .range([height - margin.top - margin.bottom, 0]);

            // Select the svg element, if it exists.
            var svg = d3.select(this).selectAll("svg").data([data]);

            // Otherwise, create the skeletal chart.
            var gEnter = svg.enter().append("svg").append("g");

            gEnter.append("path").attr("class", "line");
            gEnter.append("g").attr("class", "x axis");
            // gEnter.append("g").attr("class", "y axis");

            // Update the outer dimensions.
            svg .attr("width", width)
                .attr("height", height);

            // Update the inner dimensions.
            var g = svg.select("g")
                .attr("transform", "translate(" + margin.left + "," + margin.top + ")");


            // Draw stepPointBox block (default point view on chart)
            var stepPointBox = g.selectAll(".stepPointBox")
                .data(data).enter().append("g")
                .attr("class", "stepPointBox");

            var speedScale = d3.scale.linear().domain(d3.extent(data.map(function(d, i){return d.rose.length;}))).range([0, 18]);
            //Draw the center Calm
            stepPointBox.append("circle")
                .attr("class", "calm")
                .attr("cx", function(d) { return xScale(d.date); })
                .attr("cy", 0) // function(d) { return yScale(0); })
                .attr("r", 5);
                    
            // Draw stepPetalsBox block (on mouse hover point view foreach rose)
            var stepPetalsBox = g.selectAll(".stepPetalsBox")
                .data(data).enter().append("g")
                .attr("class", "stepPetalsBox");
            
            stepPetalsBox.append("rect")
                .attr("class", "sensitive")
                .attr("x", function(d) { return xScale(d.date)-6; })
                .attr("y", -40) // function(d) { return yScale(0); })
                .attr("width", 12)
                .attr("height", 80)
                .on("click", function(d) { return onClickAction(d); })
                .append("title")
                .text(function(d) {
                        return toHumanDate(d.date)+"\nEach item for "+dataheader.step+" min";
                    });
                

            var visWidth = 30;
            smallArcScale = d3.scale.linear().domain([0, 4]).range([5, visWidth]).clamp(true);

            //Add conteiner for include petals
            stepPetalsBox.append("svg:g")
                .attr("class", "petals")
                .attr("transform", function(d) { return "translate(" + xScale(d.date) + ", 0)"; })
                .selectAll("path")
                .data(
                    // parse each rose
                    function(d){
			var sum = d3.sum(d.rose, function(item){return item.Spl;});
			d.rose.forEach(function (item,index,array){array[index].tSpl=sum; return array;})
			// console.log (d3.sum(d.rose, function(item){return item.Spl;}),d.rose);
			return d.rose; }
                )
                .enter()
                .append("svg:path")
                	.attr("fill", function(d){ return colorScale(d.Spl/d.tSpl); } ) // 
                    .attr("d",
                        // build each petal of each rose
                        function(d){
                            if (d.Spd>0)
                            { // if a real petal, not the center (calm:no wind, no direction)
                                var obj={ width: 11, from: 5, to: smallArcScale(d.Spd) };
                                return d3.svg.arc()
                                    .startAngle((d.Dir - obj.width) * Math.PI/180)
                                    .endAngle((d.Dir + obj.width) * Math.PI/180)
                                    .innerRadius(obj.from)
                                    .outerRadius(obj.to)();
                            }
                        }
                    );


            // chose the possition of x-Axis
            if (0<yScale.domain()[0])
              xPos = yScale.range()[0];
            else if (yScale.domain()[1]<0)
              xPos = yScale.range()[1];
            else
              xPos = yScale(0);

            // Update the x-axis.
            g.select(".x.axis")
                .attr("transform", "translate(0," + xPos + ")") // axe tjrs en bas : yScale.range()[0] + ")")
                .call(xAxis);
        });
    }

    // The x-accessor for the path generator; xScale ∘ meanDate.
    function X(d) {
        return xScale(d.date);
    }

    // The x-accessor for the path generator; yScale ∘ Speed.
    function Y(d) {
        return yScale(d.ySpeed);
    }
	var colorScale = d3.scale.linear()
                                .domain([0, .5, .8, 1])
                                .range(["#AEC7E8","#1F77B4","#D62728","#2C3539"])// ["hsl(0, 70%, 99%)", "hsl(0, 70%, 40%)"])
                                .interpolate(d3.interpolateHsl);

// ================= Property of chart =================

    chart.loader = function(container) {
        // on demande les infos importante au sujet de notre futur tracé
        // ces infos permettent de finir le parametrage de notre "Chart"
        d3.json( ajaxUrl + "?station="+ station +"&XdisplaySizePxl="+width+"&infos=dataheader",
            function(data) {
                console.TimeStep('load Header');
                // console.log(data); //, ;
                    chart.yDomain([data.min, data.max])
                    .dataheader(data);
            }
        );

        // on charge les données et on lance le tracage
        d3.json( ajaxUrl + "?station="+ station +"&XdisplaySizePxl="+width,
            function(data) {
                console.TimeStep('load Data');
                d3.select(container)
                    .datum(d3.entries(data.data))
                    .call( chart );
            }
        );
        return chart;
    }

// ================= Accesseurs =====================

    chart.margin = function(_) {
        if (!arguments.length) return margin;
        margin = _;
        return chart;
    };
    chart.width = function(_) {
        if (!arguments.length) return width;
        width = _;
        return chart;
    };
    chart.height = function(_) {
        if (!arguments.length) return height;
        height = _;
        return chart;
    };
    chart.date = function(_) {
        if (!arguments.length) return meanDate;
        meanDate = _;
        return chart;
    };
    chart.rose = function(_) {
        if (!arguments.length) return rose;
        rose = _;
        return chart;
    };
    chart.speed = function(_) {
        if (!arguments.length) return Speed;
        Speed = _;
        return chart;
    };
    chart.angle = function(_) {
        if (!arguments.length) return angle;
        angle = _;
        return chart;
    };
    chart.ajaxUrl = function(_) {
        if (!arguments.length) return ajaxUrl;
        ajaxUrl = _;
        return chart;
    };
    chart.station = function(_) {
        if (!arguments.length) return station;
        station = _;
        return chart;
    };
    chart.onClickAction = function(_) {
        if (!arguments.length) return onClickAction;
        onClickAction = _;
        return chart;
    };
    chart.yDomain = function(_) {
        if (!arguments.length) return yDomain;
        yDomain = _;
        yScale.domain(yDomain);
        return chart;
    };
    chart.dataheader = function(_) {
        if (!arguments.length) return dataheader;
        dataheader = _;
        return chart;
    };
    chart.toHumanSpeed = function(_) {
        if (!arguments.length) return toHumanSpeed;
        toHumanSpeed = _;
        return chart;
    };
    chart.toHumanAngle = function(_) {
        if (!arguments.length) return toHumanAngle;
        toHumanAngle = _;
        return chart;
    };
    chart.toHumanDate = function(_) {
        if (!arguments.length) return toHumanDate;
        toHumanDate = _;
        return chart;
    };



    return chart;
}
