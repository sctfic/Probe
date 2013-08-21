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
    // var timeFormat = d3.time.format("%Y-%m-%d %H:%M:%S");

    // on definie notre objet au plus pres de notre besoin.
    var histoRose = timeSeriesChart_histoRose()
                        .width(XdisplaySizePxl)
                        // .ajaxUrl("/data/windRose")
                        .station(station)
                        .dateParser("%Y-%m-%d %H:%M:%S")
                        .dateDomain(["2013-06-31T06:00:00", formatDate(new Date(), ' ')])
                        .rose(function(d) { return d.value; })
                        .onClickAction(function(d) { console.error (d); })
                        // .withAxis(false)
                        .toHumanSpeed(formulaConverter ('WindSpeed', 'km/h'))
                        .toHumanAngle(formulaConverter ('angle', '°'))
                        .toHumanDate(formulaConverter ('strDate', 'ISO'));

    histoRose.loader(container);
}







// ================= Engine build chart of rose by period ====================

function timeSeriesChart_histoRose() {
    var data,
        margin = {top: 40, right: 40, bottom: 40, left: 40},
        width = 320,
        height = 80,
        dataheader = null,
        station = null,
        withAxis = true,
        timeFormat = d3.time.format("%Y-%m-%dT%H:%M:%S"),
        dateParser = function(d) { return timeFormat.parse (d.date); },
        dateDomain = [formatDate(new Date(0)), formatDate(new Date())],
        rose = function(d) { return d.rose; },
        angle = function(d) { return d.angle; },
        xSpeed = function(d) { return d.x; },
        ySpeed = function(d) { return d.y; },
        xPos=0,
        yPos=0,
        xScale = d3.time.scale().range([0, width]),
        yScale = d3.scale.linear().range([height, 0]),
        yDomain = [0, 1],
        xAxis = d3.svg.axis().scale(xScale).orient("bottom").tickSize(8,8),
        yAxis = d3.svg.axis().scale(yScale).orient("left").ticks(4).tickSize(3,8),
        onClickAction = function(d) { console.log(d); },
        toHumanSpeed = function(d) { return +d; },
        toHumanAngle = function(d) { return +d; },
        toHumanDate = function(d) { return d; },
        ajaxUrl = "/data/windRose";

        // line = d3.svg.line().x(X).y(Y);


    function chart(selection) {
        //selection represente la liste de block ou ecire les donnees
        selection.each(function(rawdata) {
            // Convert data to standard representation greedily;
            // this is needed for nondeterministic accessors.
            data = rawdata.map(function(d, i) {
                var date=dateParser.call(rawdata, d, i)
                return {
                    date:date,
                    period:[
                        new Date(date.getTime()-(60*1000*dataheader.step/2)),
                        new Date(date.getTime()+(60*1000*dataheader.step/2))
                    ],
                    rose:rose.call(rawdata, d, i)
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
            var gEnter = svg.enter()
                .append("svg")
                    // .attr("xmlns", "http://www.w3.org/2000/svg")
                    // .attr("version", "1.1")
                    // .attr("viewBox", "0 0 "+width+" "+height)
                    // .attr("preserveAspectRatio", "xMinYMin")
                    .attr("width", "100%")
                    .attr("height", height)
                    .append("g");

            // gEnter.append("path").attr("class", "line");
            gEnter.append("g").attr("class", "x axis");
            // gEnter.append("g").attr("class", "y axis");

            // Update the inner dimensions.
            var g = svg.select("g")
                .attr("transform", "translate(" + margin.left + "," + margin.top + ")");
            // Draw PointBox block (default point view on chart)
            g.selectAll(".PointBox")
                .data(data).enter()
                .append("g")
                    .attr("class", "PointBox");

            var speedScale = d3.scale.linear().domain(d3.extent(data.map(function(d, i){return d.rose.length;}))).range([0, 18]);

            var timeoutID=null;
            g.update = function() {
                var pointBox=this.selectAll('.PointBox');
                    pointBox.append("circle")  // Draw the center Calm
                        .attr("class", "calm");

                var hoverBox=pointBox
                                .append("g")
                                    .attr("class", "hoverBox");

                // Draw hoverBox block (on mouse hover point view foreach rose)
                var sensitive=hoverBox
                                .append("rect")
                                    .attr("class", "sensitive");
                    
                sensitive
                    .append("title");

                var visWidth = 30;
                smallArcScale = d3.scale.linear().domain([0, 4]).range([5, visWidth]).clamp(true);

                hoverBox
                    .append("g")// Add conteiner for include petals
                        .attr("class", "petals")
                        .attr("transform", function(d) { return "translate(" + xScale(d.date) + ", 0)"; })
                        .selectAll("path")
                        .data(
                            // parse each rose
                            function(d){
                                var sum = d3.sum(d.rose, function(item){return item.Spl;});
                                d.rose.forEach(function (item,index,array){array[index].tSpl=sum; return array;})
                                // console.log (d3.sum(d.rose, function(item){return item.Spl;}),d.rose);
                                return d.rose;
                            })
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
                return this;
            }  
            g.redraw = function() {
                var xExtend=xScale.domain();
                this.selectAll('.PointBox')
                    .attr("display", function(d) {return (d.date>=xExtend[0] && d.date<=xExtend[1])?'inline':'none'; });

                this.selectAll('.calm').attr("cx", function(d) { return xScale(d.date); })
                    .attr("cy", 0) // function(d) { return yScale(0); })
                    .attr("r", 5);
                this.selectAll('.sensitive')
                    .attr("x", function(d) {return xScale(d.period[0]); })
                    .attr("y", -40) // function(d) { return yScale(0); })
                    .attr("width", function(d) {return xScale(d.period[1])-xScale(d.period[0])+1; })
                    .attr("height", 80)
                    .on("click", function(d) { return onClickAction(d); });
                this.selectAll('.sensitive')
                    .call(zm=d3.behavior.zoom()
                            .x(xScale)
                            .scaleExtent([1,1000])
                            .on("zoom", function(d){
                                    console.TimeStep('Zoom');
                                    console.log(d);
                                    window.clearTimeout(timeoutID);
                                    timeoutID = window.setTimeout(function(){zoom(g)}, 400);                
                                    g.redraw()
                                     .drawAxis ();
                                }
                            )
                        );
                this.selectAll('.sensitive title').text(function(d) {
                                return toHumanDate(d.date)+"\nEach item for "+dataheader.step+" min";
                            });
                return this;
            }  
            g.drawAxis = function() {
                // chose the possition of x-Axis
                if (0<yScale.domain()[0])
                  xPos = yScale.range()[0];
                else if (yScale.domain()[1]<0)
                  xPos = yScale.range()[1];
                else
                  xPos = yScale(0);

                if (withAxis) {
                    // Update the x-axis.
                    g.select(".x.axis")
                        .attr("transform", "translate(0," + xPos + ")") // axe tjrs en bas : yScale.range()[0] + ")")
                        .call(xAxis);
                }
                return this;
            }
            g.update()
             .redraw()
             .drawAxis();
        });
    }



    function zoom(g) {
        var ready = false,
            dataTsv = false,
            zmDomain=xScale.domain();
        console.TimeStep('Zoom');
        // on demande les infos importante au sujet de notre futur tracé
        // ces infos permettent de finir le parametrage de notre "Chart"
        // on charge les données et on lance le tracage
        d3.json( ajaxUrl + "?station="+ station +"&XdisplaySizePxl="+width+"&Since="+formatDate(zmDomain[0],'T')+"&To="+formatDate(zmDomain[1]
,'T'),
            function(data2add) {
                console.TimeStep('load Data Zoom');
                data2add = d3.entries(data2add.data).map(function(d, i) {
                    var date=dateParser.call(data2add, d, i);
                    console.log('period n est pas dynamique');
                    return {
                        date:date,
                        period:[
                            new Date(date.getTime()-1),
                            new Date(date.getTime()+1)
                        ],
                        rose:rose.call(data2add, d, i)
                    };
                });

                    console.log(data2add);
                mergedata = data.filter(function(element, index, array){
                          return (element.date<data2add[0].date || element.date>data2add[data2add.length-1].date);
                      })
                   .concat(data2add)
                   .sort(function (a, b) {
                       return a.date-b.date;
                      });

                // Draw PointBox block (default point view on chart)
                var PointBox = g.selectAll(".PointBox")
                    .data(data2add, function(d) { return d.date; });
                PointBox.exit().remove();
                PointBox.enter()
                    .append("g")
                    .attr("class", "PointBox");

                g.update()
                 .redraw()
                 .drawAxis ();
            }
        );
    }
    // The x-accessor for the path generator; xScale ∘ dateParser.
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


    chart.loader = function(container,callback) {
        var ready = false,
            dataTsv = false;
        // on demande les infos importante au sujet de notre futur tracé
        // ces infos permettent de finir le parametrage de notre "Chart"
        // on charge les données et on lance le tracage
        d3.json( ajaxUrl + "?station="+ station +"&XdisplaySizePxl="+width+"&Since="+dateDomain[0]+"&To="+dateDomain[1],
            function(data) {
                console.TimeStep('load Data');
                console.log(data.data);

                if (ready) {
                    if (typeof callback === 'function') callback(100);
                    d3.select(container)
                        .datum(d3.entries(data.data))
                        .call( chart );
                }
                ready = true;
                dataTsv = data;
            }
        );

        d3.json( ajaxUrl + "?station="+ station +"&XdisplaySizePxl="+width+"&infos=dataheader"+"&Since="+dateDomain[0]+"&To="+dateDomain[1],
            function(data) {
                console.TimeStep('load Header');
                console.log(data);

                chart.yDomain([data.min, data.max])
                    .dataheader(data);
                
                if (ready) {
                    if (typeof callback === 'function') callback(100);
                    // console.log(data);
                    d3.select(container)
                        .datum(dataTsv)
                        .call(chart);
                }
                ready = true;
            }
        );
        if (typeof callback === 'function') callback(96);

        return chart;
    }

// ================= Accesseurs =====================

    chart.dateParser = function(_) { // genere la fonction de conversion du champ [string]:date en [date]:date
        if (!arguments.length) return dateParser;
        if (typeof _ === "string") {
            timeFormat = d3.time.format(_);
            dateParser = function(d) { return timeFormat.parse (d.key); };
        } else dateParser = _;
        return chart;
    };

    chart.dateDomain = function(_) {
        if (!arguments.length) return dateDomain;
        dateDomain = _;
        return chart;
    };
    chart.withAxis = function(_) {
        if (!arguments.length) return withAxis;
        withAxis = _;
        return chart;
    };
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
