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
                        .dateDomain(["2013-05-31T06:00:00", formatDate(new Date(), ' ')])
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
    var margin = {top: 5, right: 25, bottom: 5, left: 25},
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
        selection.each(function(data) {
            // Convert data to standard representation greedily;
            // this is needed for nondeterministic accessors.
            data = data.map(function(d, i) {
                return {
                    date:dateParser.call(data, d, i),
                    Speed:Speed.call(data, d, i),
                    angle:angle.call(data, d, i),
                    xSpeed:xSpeed.call(data, d, i),
                    ySpeed:ySpeed.call(data, d, i)
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

            // Update the x-scale.
            xScale
                .domain(domainDate)
                .range([0, width - margin.left - margin.right]);

            // Select the svg element, if it exists.
            var svg = d3.select(this).selectAll("svg").data([data]);

            // Otherwise, create the skeletal chart.
            var gEnter = svg.enter()
                .append("svg")
                    .attr("viewBox", "0 0 "+width+" "+height)
                    // .attr("preserveAspectRatio", "xMinYMin")
                    .attr("width", "100%")
                    .attr("height", height)
                    .append("g");

            gEnter.append("path").attr("class", "line");
            gEnter.append("g").attr("class", "x axis");
            // gEnter.append("g").attr("class", "y axis");

            // Update the inner dimensions.
            var g = svg.select("g")
                .attr("left","0px")
                .attr("transform", "translate(" + margin.left + "," + margin.top + ")");
            //     console.log("translate(" + margin.left + "," + margin.top + ")");

            var coef = (yScale.range()[0]-yScale.range()[1])/(yScale.domain()[1]-yScale.domain()[0]);

            // Draw arrow block
            var arrow = g.selectAll(".arrow")
                .data(data).enter().append("g")
                .on("click", function(d) { return onClickAction(d); })
                .attr("class", "arrow");

                //Draw the line
                arrow.append("line")
                    .attr("class", "hair")
                    .attr("x1", function(d) { return xScale(d.date); })
                    .attr("y1", function(d) { return yScale(0); })
                    .attr("x2", function(d) { return xScale(d.date) + d.xSpeed*coef; })
                    .attr("y2", function(d) { return yScale(d.ySpeed); });

                arrow.append("polygon")
                    .attr("class", "marker")
                    .attr("points","-1.5,2 0,-2 1.5,2")
                    .attr("transform", function(d) {
                            return "translate("+(xScale(d.date) + d.xSpeed*coef)+","+(yScale(d.ySpeed))+") rotate("+(d.angle)+")";
                        });

                arrow.append("title")
                    .text(function(d) {
                            return "Speed Avg: "+ toHumanSpeed(d.Speed).toFixed(1)+toHumanSpeed()+
                                    "\nAngle Avg: "+toHumanAngle(d.angle)+toHumanAngle()+
                                    "\nAverage on: "+toHumanDate(d.date) ;
                        });

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
                // g.select(".y.axis")
                //     .attr("transform", "translate(0,0)")
                //     .call(yAxis);
            }
        });
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

                chart.yDomain([data.min, data.max])
                    .dataheader(data);
                
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