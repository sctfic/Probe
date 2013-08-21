/** histoWind.js
* D3 binder to visualize <dataset> data
*
* @category D3Binder
* @package  Probe
* @author   alban lopez <alban.lopez+probe@gmail.com>
* @license  http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode CC-by-nc-sa-3.0
* @link     http://probe-meteo.com/doc
*/
function include_histoWind(container, station, XdisplaySizePxl) {
    // on defini la fonction de convertion de nos dates (string) en Objet
    // var timeFormat = d3.time.format("%Y-%m-%d %H:%M");

    // on definie notre objet au plus pres de notre besoin.
    var histoWind = timeSeriesChart_histoWind()
                        .width(XdisplaySizePxl)
                        // .ajaxUrl("/data/histoWind")
                        .station(station)
                        .dateParser("%Y-%m-%d %H:%M")
                        .dateDomain(["2013-05-31T06:00:00", formatDate(new Date(), 'T')])
                        // .speed(function(d) { return +d.speed; })
                        // .angle(function(d) { return +d.angle; })
                        // .xSpeed(function(d) { return +d.x; })
                        // .ySpeed(function(d) { return +d.y; })
                        .onClickAction(function(d) { console.error (d); })
                        // .withAxis(false)
                        .toHumanSpeed(formulaConverter ('WindSpeed', 'km/h'))
                        .toHumanAngle(formulaConverter ('angle', '°'))
                        .toHumanDate(formulaConverter ('strDate', 'ISO'));

    histoWind.loader(container);
}






// ================= Engine build chart of wind by period ====================

function timeSeriesChart_histoWind() {
    var data,
        margin = {top: 5, right: 25, bottom: 5, left: 25},
        width = 1800,
        height = 160,
        dataheader = null,
        station = null,
        withAxis = true,
        timeFormat = d3.time.format("%Y-%m-%dT%H:%M:%S"),
        dateParser = function(d) { return timeFormat.parse (d.date); },
        dateDomain = [formatDate(new Date(0)), formatDate(new Date())],
        Speed = function(d) { return +d.speed; },
        angle = function(d) { return +d.angle; },
        xPos=0,
        yPos=0,
        xSpeed = function(d) { return +d.x; },
        ySpeed = function(d) { return +d.y; },
        xScale = d3.time.scale().range([0, width]),
        yScale = d3.scale.linear().range([height, 0]),
        xAxis = d3.svg.axis().scale(xScale).orient("bottom").tickSize(4,0),
        yAxis = d3.svg.axis().scale(yScale).orient("left").ticks(4).tickSize(3,0),
        onClickAction = function(d) { console.log(d); },
        toHumanSpeed = function(d) { return +d; },
        toHumanAngle = function(d) { return +d; },
        toHumanDate = function(d) { return d; },
        ajaxUrl = "/data/histoWind";
      // line = d3.svg.line().x(X).y(Y);


    function chart(selection) {
        //selection represente la liste de block ou ecire les donnees
        selection.each(function(rawdata) {
            // Convert data to standard representation greedily;
            // this is needed for nondeterministic accessors.
            data = rawdata.map(function(d, i) {
                return {
                    date:dateParser.call(rawdata, d, i),
                    Speed:Speed.call(rawdata, d, i),
                    angle:angle.call(rawdata, d, i),
                    xSpeed:xSpeed.call(rawdata, d, i),
                    ySpeed:ySpeed.call(rawdata, d, i)
                };
            });

            domainDate=d3.extent(data, function(d) { return d.date; });
            // Update the y-scale.
            yScale
                .domain(d3.extent(data, function(d) {return d.ySpeed; }))
                .range([height - margin.top - margin.bottom, 0]);
            // Update the x-scale.
            xScale
                .domain(domainDate)
                .range([0, width - margin.left - margin.right]);

            // Update the marge left and right
            chart.margin({
                top: margin.top,
                right: d3.max(data, function(d) { // marge droite fonctione des vitesse-X compensée relative a leur propre date
                    Offset=(yScale(0)-yScale(d.xSpeed))-(xScale(domainDate[1])-xScale(d.date));
                    return Offset>0?Offset:0; })+1,
                bottom: margin.bottom,
                left: d3.max(data, function(d) { // marge droite fonctione des vitesse-X compensée relative a leur propre date
                    Offset=(yScale(d.xSpeed)-yScale(0))-(xScale(d.date)-xScale(domainDate[0]));
                    return Offset>0?Offset:0;  })+1,
            });
                console.log(xScale.domain(), xScale.range(), width, margin.left, margin.right);

            // Update the x-scale with new margin values
            xScale
                // .domain(domainDate)
                .range([0, width - (margin.left + margin.right)]);
                console.log(xScale.domain(), xScale.range());

            // Select the svg element, if it exists.
            var svg = d3.select(this).selectAll("svg").data([data]);


            // Otherwise, create the skeletal chart.
            var gEnter = svg.enter()
                            .append("svg")
                                // .attr("viewBox", "0 0 "+width+" "+height)
                                // .attr("preserveAspectRatio", "xMinYMin")
                                .attr("width", "100%")
                                .attr("height", height);

            var defs = gEnter.append("defs")

            defs.append("marker")
                .attr("id", "arrowhead")
                .attr("refX", 2)
                .attr("refY", 0)
                .attr("viewBox", "-5 -5 12 10")
                .attr("markerUnits", "strokeWidth")
                .attr("markerWidth", 6)
                .attr("markerHeight", 12)
                .attr("orient", "auto")
                .append("polygon")
                    .attr("stroke", "#3182bd")
                    .attr("points", "0,0 -2.5,-2.5 5,0 -2.5,2.5");
            defs.append("marker")
                .attr("id", "arrowheadHover")
                .attr("refX", 2)
                .attr("refY", 0)
                .attr("viewBox", "-5 -5 12 10")
                .attr("markerUnits", "strokeWidth")
                .attr("markerWidth", 6)
                .attr("markerHeight", 12)
                .attr("orient", "auto")
                .append("polygon")
                    .attr("stroke", "#E6550D")
                    .attr("points", "0,0 -2.5,-2.5 5,0 -2.5,2.5");

            var timeoutID=null;
            var Sensitive = svg.append("rect")
                .attr("class", "sensitive")
                .attr('width', width - margin.left - margin.right)
                .attr('height', height - margin.top - margin.bottom)
                .attr("transform", "translate(" + margin.left + "," + margin.top + ")");



            // Update the inner dimensions.
            var g = gEnter.append("g")
                        .attr("left","0px")
                        .attr("transform", "translate(" + margin.left + "," + margin.top + ")");
            // gEnter=gEnter.append("g");

            g.append("path").attr("class", "line");
            g.append("g").attr("class", "x axis");

            var coef = (yScale.range()[0]-yScale.range()[1])/(yScale.domain()[1]-yScale.domain()[0]);

            var arrow = g.selectAll(".arrow")
                            .data(data)
                            .enter()
                            .append("g")
                                .attr("class", "arrow")
                                .on("click", onClickAction);

            arrow.append("line")
                .attr("class", "hair");
            arrow.append("line")
                .attr("class", "hair2");
            arrow.append("title")
                .text(function(d) {
                        return "Speed Avg: "+ toHumanSpeed(d.Speed).toFixed(1)+toHumanSpeed()+
                                "\nAngle Avg: "+toHumanAngle(d.angle)+toHumanAngle()+
                                "\nAverage on: "+toHumanDate(d.date) ;
                    });

            g.updateCurve = function(){
                // Draw arrow block
                var xExtend=xScale.domain();
                //Draw the line
                this.selectAll('.hair,.hair2')
                    // on deplace en fonction du nouveau referentiel
                    .attr("x1", function(d) { return xScale(d.date); })
                    .attr("y1", function(d) { return yScale(0); })
                    .attr("x2", function(d) { return xScale(d.date) + d.xSpeed*coef; })
                    .attr("y2", function(d) { return yScale(d.ySpeed); })
                    // on cache les elements hors referentiel
                    .attr("display", function(d) {return (d.date>=xExtend[0] && d.date<=xExtend[1])?'inline':'none'; });

                return this;
            }
            g.drawAxis = function(){
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

            Sensitive.call(zm=d3.behavior.zoom().x(xScale).scaleExtent([1,1000]).on("zoom", function(){
                window.clearTimeout(timeoutID);
                timeoutID = window.setTimeout(function(){zoom(g)}, 400);                
                g.updateCurve()
                 .drawAxis ();
                // console.TimeStep('Zoom');
            }));

            g.updateCurve()
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
        d3.tsv( ajaxUrl + "?station="+ station +"&XdisplaySizePxl="+width+"&Since="+formatDate(zmDomain[0],'T')+"&To="+formatDate(zmDomain[1]
,'T'),
            function(data2add) {
                console.TimeStep('load Data Zoom');
                data2add = data2add.map(function(d, i) {
                    return {
                        date:dateParser.call(data2add, d, i),
                        Speed:Speed.call(data2add, d, i),
                        angle:angle.call(data2add, d, i),
                        xSpeed:xSpeed.call(data2add, d, i),
                        ySpeed:ySpeed.call(data2add, d, i)
                    };
                });
                
                mergedata = data.filter(function(element, index, array){
                          return (element.date<data2add[0].date || element.date>data2add[data2add.length-1].date);
                      })
                   .concat(data2add)
                   .sort(function (a, b) {
                       return a.date-b.date;
                      });
                yScale.domain(d3.extent(data2add, function(d) {return d.ySpeed; }));
                var arrow = g.selectAll(".arrow")
                                .data(mergedata, function(d) { return d.date; });
                arrow.exit().remove();
                arrow = arrow
                    .enter()
                    .append("g")
                        .attr("class", "arrow")
                        // .attr("new",function(d){return d.date})
                        .on("click", onClickAction);

                arrow.append("line")
                    .attr("class", "hair");
                arrow.append("line")
                    .attr("class", "hair2");
                arrow.append("title")
                    .text(function(d) {
                            return "Speed Avg: "+ toHumanSpeed(d.Speed).toFixed(1)+toHumanSpeed()+
                                    "\nAngle Avg: "+toHumanAngle(d.angle)+toHumanAngle()+
                                    "\nAverage on: "+toHumanDate(d.date) ;
                        });

                // if (ready) {
                    g.updateCurve()
                     .drawAxis ();
                // }
                // ready = true;
                // dataTsv = data;
            }
        );

        // d3.json( ajaxUrl + "?station="+ station +"&XdisplaySizePxl="+width+"&infos=dataheader"+"&Since="+formatDate(zmDomain[0],'T')+"&To="+formatDate(zmDomain[1],'T'),
        //     function(header) {
        //         console.TimeStep('load Header Zoom');

        //         chart//.yDomain([header.min, header.max])
        //             .dataheader(header);
                
        //         if (ready) {
        //             g.updateCurve()
        //              .drawAxis ();
        //         }
        //         ready = true;
        //     }
        // );
    }
    // The x-accessor for the path generator; xScale ∘ dateParser.
    function X(d) {
    return xScale(d.date);
    }

    // The x-accessor for the path generator; yScale ∘ Speed.
    function Y(d) {
    return yScale(d.ySpeed);
    }

// ================= Property of chart =================

    chart.loader = function(container) {
        var ready = false,
            dataTsv = false;
        // on demande les infos importante au sujet de notre futur tracé
        // ces infos permettent de finir le parametrage de notre "Chart"
        // on charge les données et on lance le tracage
        d3.tsv( ajaxUrl + "?station="+ station +"&XdisplaySizePxl="+width+"&Since="+dateDomain[0]+"&To="+dateDomain[1],
            function(data) {
                console.TimeStep('load Data');
                console.log(data);

                if (ready) {
                    d3.select(container)
                        .datum(data)
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

                chart.dataheader(data);
                
                if (ready) {
                    // console.log(data);
                    d3.select(container)
                        .datum(dataTsv)
                        .call(chart);
                }
                ready = true;
            }
        );

        return chart;
    }

// ================= Accesseurs =====================

    chart.dateParser = function(_) { // genere la fonction de conversion du champ [string]:date en [date]:date
        if (!arguments.length) return dateParser;
        if (typeof _ === "string") {
            timeFormat = d3.time.format(_);
            dateParser = function(d) { return timeFormat.parse (d.date); };
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
    chart.xSpeed = function(_) {
        if (!arguments.length) return xSpeed;
        xSpeed = _;
        return chart;
    };
    chart.ySpeed = function(_) {
        if (!arguments.length) return ySpeed;
        ySpeed = _;
        return chart;
    };

  return chart;
}