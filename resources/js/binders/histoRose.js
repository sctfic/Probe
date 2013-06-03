
function call_histoRose(container, station, XdisplaySizePxl) {
    var histoRose = timeSeriesChart_histoRose()
                        .width(XdisplaySizePxl)
                        .ajaxUrl("/data/windRose")
                        .station(station)
                        ;


    d3.json( histoRose.ajaxUrl() + "?station="+ histoRose.station() +"&XdisplaySizePxl="+histoRose.width(), function(data) {
        var formatDate = d3.time.format("%Y-%m-%d %H:%M:%S");
        d3.select(container)
            .datum(d3.entries(data.data))
            .call(histoRose
                .date(function(d) { return formatDate.parse(d.key); })
                .rose(function(d) { return d.value; })
                .onClickAction(function(d) { console.error (d); })
                );
    });
}







// ================= Engine build chart of rose by period ====================

function timeSeriesChart_histoRose() {
    var margin = {top: 50, right: 50, bottom: 20, left: 30},
        width = 640,
        height = 160,
        meanDate = function(d) { return d.date; },
        rose = function(d) { return d.rose; },
        angle = function(d) { return d.angle; },
        xSpeed = function(d) { return d.x; },
        ySpeed = function(d) { return d.y; },
        xScale = d3.time.scale().range([0, width]),
        yScale = d3.scale.linear().range([height, 0]),
        xAxis = d3.svg.axis().scale(xScale).orient("bottom").tickSize(8,0),
        yAxis = d3.svg.axis().scale(yScale).orient("left").ticks(4).tickSize(3,0),
        onClickAction = function(d) { console.log(d); },
        ajaxUrl = ""
        ;

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
            
            stepPetalsBox.append("circle")
                .attr("class", "sensitive")
                .attr("cx", function(d) { return xScale(d.date); })
                .attr("cy", 0) // function(d) { return yScale(0); })
                .attr("r", 6)
                .on("click", function(d) { return onClickAction(d); })
                .append("title")
                .text(function(d) {
                        return ""+d.date ;
                    });
                

            var visWidth = 30;
            smallArcScale = d3.scale.linear().domain([0, 25]).range([5, visWidth]).clamp(true);
            // // var small = d3.select(container)

            // var winds = [];
            // var t = totalSpl(Data);

            // for (var key in Data) {
            //     if (Data[key]['Dir']!='null')
            //         winds.push(
            //             {
            //                 d: Data[key]['Dir']*1,
            //                 p: Data [key]['Spl'] / t,
            //                 s: Data [key]['Spd']*SpeedFactor,
            //                 m: Data [key]['Max']*SpeedFactor
            //             });
            // }

            //Add conteiner for include petals
            stepPetalsBox.append("svg:g")
                .attr("class", "petals")
                .attr("transform", function(d) { return "translate(" + xScale(d.date) + ", 0)"; })
                .selectAll("path")
                .data(
                    // parse each rose
                    function(d){ return d.rose; }
                )
                .enter()
                .append("svg:path")
                    .attr("d",
                        // build each petal of each rose
                        function(d){
                            if (d.Spd>0)
                            { // if a real petal, not the center (calm:no wind, no direction)
                                var obj={ width: 11, from: 5, to: smallArcScale(d.Spl) };
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

// Dir: 0
// Max: 3.576
// Spd: 0.447
// Spl: 4
// function arc(obj) {
//     return d3.svg.arc()
//         .startAngle(function(d) {console.log(d , (d.Dir - obj.width) * Math.PI/180); return (d.Dir - obj.width) * Math.PI/180; })
//         .endAngle(function(d) {console.log(d , (d.Dir + obj.width) * Math.PI/180); return (d.Dir + obj.width) * Math.PI/180; })
//         .innerRadius(obj.from)
//         .outerRadius(function(d) {console.log(d , obj.to(d)); return obj.to(d) });
// };


    // The x-accessor for the path generator; xScale ∘ meanDate.
    function X(d) {
        return xScale(d.date);
    }

    // The x-accessor for the path generator; yScale ∘ Speed.
    function Y(d) {
        return yScale(d.ySpeed);
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

    return chart;
}