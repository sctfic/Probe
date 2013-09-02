/** curves.js
* D3 binder to visualize <dataset> data
*
* @category D3Binder
* @package  Probe
* @author   alban lopez <alban.lopez+probe@gmail.com>
* @license  http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode CC-by-nc-sa-3.0
* @link     http://probe-meteo.com/doc
* @Model    http://bost.ocks.org/mike/chart/
*/


function include_curves(container, station, sensor, XdisplaySizePxl)
{
    // on definie notre objet au plus pres de notre besoin.
    var curves = timeSeriesChart_curves()
                        .width(XdisplaySizePxl)
                        // .ajaxUrl("/data/curve")
                        .dateParser("%Y-%m-%d %H:%M")
                        .dateDomain(["2013-06-31T06:00:00", formatDate(new Date(), ' ')])
                        .station(station)
                        .sensor(sensor)
                        // .trend(6)
                        // .withAxis(false)
                        .toHumanDate(formulaConverter ('strDate', 'ISO'));

    curves.loader(container);
}
function include_nudecurves(container, station, sensor, XdisplaySizePxl)
{
    // on definie notre objet au plus pres de notre besoin.
    var curves = timeSeriesChart_curves()
                        .width(XdisplaySizePxl)
                        .height(40)
                        // .ajaxUrl("/data/curve")
                        .dateParser("%Y-%m-%d %H:%M")
                        .dateDomain(["2013-06-31T06:00:00", formatDate(new Date(), ' ')])
                        .station(station)
                        .sensor(sensor)
                        .Color()
                        .nude(true)
                        .toHumanDate(formulaConverter ('strDate', 'ISO'));

    curves.loader(container);
}





var color=d3.scale.category20();
function timeSeriesChart_curves() {
    var data,margin = {top: 5, right: 5, bottom: 28, left: 40},
        width = null,
        height = 160,
        station = null,
        sensor = null,
        dataheader = null,
        dateDomain = [formatDate(new Date(0)), formatDate(new Date())],
        ajaxUrl = "/data/curve",
        withAxis = true,
        nude = false,
        trend=false,
        onClickAction = function(d) { console.error (d); },
        unit = false,
        md5 = false,
        darkColor = false,
        lightColor = false,
        toHumanUnit = function(SI){if (!arguments.length) return '';return +SI;},
        toHumanDate = function(SI){if (!arguments.length) return '';return +SI;},
        timeFormat = d3.time.format("%Y-%m-%dT%H:%M:%S"),
        dateParser = function(d) { return timeFormat.parse (d.date); },
        val = function(d) { return toHumanUnit(+d.val); },
        xPos=0,
        yPos=0,
        xScale = d3.time.scale().range([0, width]),
        yScale = d3.scale.linear().range([height, 0]),
        xAxis = d3.svg.axis().scale(xScale).orient("bottom").tickSize(4,6),
        yAxis = d3.svg.axis().scale(yScale).orient("left").ticks(4).tickSize(3,5),
        line = d3.svg.line().x(X).y(Y);
        // circle = d3.svg.circle().

    function chart(selection) {
        md5 = MD5(station+sensor+(new Date()).getMilliseconds());
        if (!darkColor)  darkColor=color(md5+'0');
        if (!lightColor)  lightColor=color(md5+'1');
        //selection represente la liste de block ou ecire les donnees
        selection.each(function(rawdata) {
           
            // Convert data to standard representation greedily;
            // this is needed for nondeterministic accessors.
            data = rawdata.map(function(d, i) {
                return {
                    date:dateParser.call(rawdata, d, i),
                    val:val.call(rawdata, d, i)
                };
            });


            // Update the x-scale.
            xScale
                .domain(d3.extent(data, function(d) { return d.date; }))
                .range([0, width - margin.left - margin.right]);
                // rangeRoundBands

            // Update the y-scale.
            yScale
                .domain(d3.extent(data, function(d) {return +d.val; })) // [toHumanUnit(dataheader.min),toHumanUnit(dataheader.max)]
                .range([height - margin.top - margin.bottom, 0]);

            // Select the svg element, if it exists.
            var svg = d3.select(this).selectAll("svg").data([{date:0,val:yScale.domain()[0]},{date:new Date(),val:yScale.domain()[0]}])

            svg = svg.data([data]);

            // Otherwise, create the skeletal chart.
            var gEnter = svg.enter()
                .append("svg")
                    .attr("viewBox", "0 0 "+width+" "+height)
                    // // .attr("preserveAspectRatio", "xMinYMin")
                    .attr("width", function(){return nude ? width : "100%";})
                    .attr("height", height)
                    .append("g");

            gEnter.append("path")
                .attr("class", "line")
                .attr("stroke", darkColor);
 
            // Update the inner dimensions.
            var g = svg.select("g")
                .attr("transform", "translate(" + margin.left + "," + margin.top + ")");
            g.updateCurve = function(){
                yScale.domain(
                    d3.extent(
                        data.filter(function(element, index, array){
                          return (element.date>=xScale.domain()[0] && element.date<=xScale.domain()[1]);
                      }), function(d) {return d.val; }));

                    // Update the line path.
                    this.select(".line")
                        .attr("d", line(data))
                        .attr("clip-path", "url(#" + md5 + ")");
                    return this;
                };

            gEnter.append("svg:clipPath")
                .attr("id", "" + md5)
                .append("svg:rect")
                .attr('width', width - margin.left - margin.right)
                .attr('height', height - margin.top - margin.bottom);

            if (!nude) {
                g.drawAxis = function(){
                        if (withAxis) {
                        // Update the x-axis.
                            this.select(".x.axis")//.transition().duration(1000)
                                .attr("transform", "translate(-1," + (xPos+12) + ")") // axe tjrs en bas : yScale.range()[0] + ")")
                                .call(xAxis);
                            this.select(".y.axis")
                                .attr("transform", "translate(-1,0)")
                                .call(yAxis);
                        }
                        return this;
                    };
                var legend = gEnter.append("g")
                    .attr("class", "legend")
                    .attr("transform", "translate(0,"+(height - margin.bottom +5)+")")
                    .attr("fill", darkColor);

                var legendTitle = legend.append('text')
                    .attr("class","title")
                    .text(dataheader.sensor.SEN_HUMAN_NAME);

                var legendXleft = width - margin.left- margin.right-4;
                var legendDate = legend.append('text')
                    .attr("class","date")
                    .attr('x', legendXleft-formatVal(dataheader.max).length*6-6)
                    .text('Scroll for Zoom');
                   // console.log(legendDate.getComputedTextLength());

                var legendVal = legend.append('text')
                    .attr("class","val")
                    .attr('x', legendXleft)
                    .text(formatVal(data[data.length-1].val));

                var spotSize = 8;
                var spot=gEnter.append("g")
                    .attr("id", "spot")
                    .attr("opacity", 0)
                    .attr("x", 0)
                    .attr("y", 0);
                    spot.append('circle')
                        .attr("class", "Dot")
                        .attr("stroke", darkColor)
                        .attr("r", spotSize/2)
                        .attr("cx", 0)
                        .attr("cy", 0);
                    spot.append('circle')
                        .attr("class", "spotCircle")
                        .attr("stroke", lightColor)
                        .attr("r", spotSize)
                        .attr("cx", 0)
                        .attr("cy", 0);
                var tendance=gEnter.append('line')
                        .attr("stroke", darkColor);


                var Sensitive = gEnter.append("rect")
                    .attr("class", "sensitive")
                    .attr('width', width - margin.left - margin.right)
                    .attr('height', height - margin.top - margin.bottom);

                var Y_val=0, timeoutID=null;
                Sensitive.on("mousemove", function() {
                // http://bl.ocks.org/mbostock/3025699
                    // var d = offsets[Math.round((xScale.invert(d3.mouse(this)[0]) - startDate) / step)];
                    // focus.select("circle").attr("transform", "translate(" + xScale(d[0]) + "," + yScale(d[1]) + ")");

                        var X_px = d3.mouse(this)[0],
                            X_date = xScale.invert(X_px);

                        Y_px = yScale(Y_val);
                        var iSpot;
                        data.forEach(function(element, index, array) {
                            if ((index+1 < array.length) && (array[index].date <= X_date) && (array[index+1].date >= X_date)) {
                                if (X_date-array[index].date < array[index+1].date-X_date) {
                                    iSpot=index;
                                } else {
                                    iSpot=index+1;
                                }
                                Y_val = array[iSpot].val;
                                X_date = array[iSpot].date;
                                X_px=Math.round(xScale(X_date));
                                Y_px=Math.round(yScale(Y_val));
                            }
                        });
                        spot.attr("opacity", 1)
                            .attr("transform", "translate("+X_px+","+Y_px+")");

                        if (trend){
                            var steps = data.filter(function(element, index, array){
                                    return (element.date>data[iSpot-trend].date && element.date<data[iSpot+trend].date);
                                });
                            var afine=linearRegression(steps);
                            tendance
                                .attr("x1", xScale(steps[0].date))
                                .attr("y1", yScale(afine.slope*(steps[0].date.getTime()/60000)+afine.middle_intercept))
                                .attr("x2", xScale(steps[steps.length-1].date))
                                .attr("y2", yScale(afine.slope*(steps[steps.length-1].date.getTime()/60000)+afine.middle_intercept));
                        }
                        legendDate.text(timeFormat(X_date,' '));
                        legendVal.text(formatVal(Y_val));
                    });

                Sensitive.call(zm=d3.behavior.zoom().x(xScale).scaleExtent([1,1000]).on("zoom", function(){
                    window.clearTimeout(timeoutID);
                    timeoutID = window.setTimeout(function(){zoom(g)}, 400);
                    // Update the line path.
                    // g.select(".line").transition().duration(1000)
                    //     .attr("d", line(data))
                    // g.select(".x.axis").transition().duration(1000)
                    //             .attr("transform", "translate(-1," + (xPos+12) + ")") // axe tjrs en bas : yScale.range()[0] + ")")
                    //             .call(xAxis);
                     g.updateCurve()
                      .drawAxis ();
                }));

                // chose the possition of x-Axis
                if (0<yScale.domain()[0])
                    xPos = yScale.range()[0];
                else if (yScale.domain()[1]<0)
                    xPos = yScale.range()[1];
                else
                    xPos = yScale(0);

                gEnter.append("g").attr("class", "x axis");
                gEnter.append("g").attr("class", "y axis");

                // Update the line path.
                g.updateCurve()
                 .drawAxis ();

            } else {
                g.updateCurve(line);
            }
            // Update the outer dimensions.
            // svg .attr("width", width)
            //     .attr("height", height);
        });
    }  


    function zoom(g) {
        var ready = false,
            dataTsv = false,
            zmDomain=xScale.domain();
        // on demande les infos importante au sujet de notre futur tracé
        // ces infos permettent de finir le parametrage de notre "Chart"
        // on charge les données et on lance le tracage
        console.TimeStep('Zoom');
        d3.tsv( ajaxUrl + "?station="+ station +"&sensor="+ sensor +"&XdisplaySizePxl="+width+"&Since="+formatDate(zmDomain[0],'T')+"&To="+formatDate(zmDomain[1]
,'T'),
            function(data2add) {
                console.TimeStep('load Data Zoom');
                data2add = data2add.map(function(d, i) {
                    return {
                        date:dateParser.call(data2add, d, i),
                        val:val.call(data2add, d, i)
                    };
                });
                
                data = data.filter(function(element, index, array){
                          return (element.date<data2add[0].date || element.date>data2add[data2add.length-1].date);
                      })
                   .concat(data2add)
                   .sort(function (a, b) {
                       return a.date-b.date;
                      });

                if (ready) {
                    g.updateCurve()
                     .drawAxis ();
                }
                ready = true;
                dataTsv = data;
            }
        );

        d3.json( ajaxUrl + "?station="+ station +"&sensor="+ sensor +"&XdisplaySizePxl="+width+"&infos=dataheader"+"&Since="+formatDate(zmDomain[0],'T')+"&To="+formatDate(zmDomain[1],'T'),
            function(header) {
                console.TimeStep('load Header Zoom');

                chart//.yDomain([header.min, header.max])
                    .dataheader(header);
                
                if (ready) {
                    g.updateCurve()
                     .drawAxis ();
                }
                ready = true;
            }
        );
    }
    // The x-accessor for the path generator; xScale ∘ dateParser.
    function X(d) {
        return xScale(d.date);
    }

    // The x-accessor for the path generator; yScale ∘ Speed.
    function Y(d) {
        return yScale(+d.val);
    }

    function formatVal(v) {
        //console.log(v, (+v).toPrecision(5));
        return (+v).toFixed(2) + toHumanUnit();
    }

    // calcule la regression lineaire sur une srie de donnee
    function linearRegression(lst){
        var n = lst.length;
        var sum_x = 0;
        var sum_y = 0;
        var sum_xy = 0;
        var sum_xx = 0;
        var sum_yy = 0;
        
        lst.forEach ( function(d) {
                intDate = d.date.getTime()/(60*1000)
                sum_x += intDate;
                sum_y += d.val;
                sum_xy += (intDate*d.val);
                sum_xx += (intDate*intDate);
                sum_yy += (d.val*d.val);
            }
        );
        
        slope = (n * sum_xy - sum_x * sum_y) / (n*sum_xx - sum_x * sum_x);
        intercept = (sum_y - slope * sum_x)/n;
        // console.log(lst, lst[(lst.length-1)/2]);
        middle_intercept = -slope*lst[(lst.length-1)/2].date.getTime()/(60*1000)+lst[(lst.length-1)/2].val;
        r2 = Math.pow((n*sum_xy - sum_x*sum_y)/Math.sqrt((n*sum_xx-sum_x*sum_x)*(n*sum_yy-sum_y*sum_y)),2);
        
        return {slope:slope, intercept:intercept, middle_intercept:middle_intercept, r2:r2};
    }

// ================= Property of chart =================

    chart.loader = function(container) {
        var ready = false,
            dataTsv = false;

        // on demande les infos importante au sujet de notre futur tracé
        // ces infos permettent de finir le parametrage de notre "Chart"
        // on charge les données et on lance le tracage
        d3.tsv( ajaxUrl + "?station="+ station +"&sensor="+ sensor +"&XdisplaySizePxl="+(width - margin.left - margin.right)+"&Since="+dateDomain[0]+"&To="+dateDomain[1],
            function(data) {
                console.TimeStep('load Data');
                // console.log(data);
                if (ready) {
                    d3.select(container)
                        .datum(data)
                        .call(chart);
                }
                ready = true;
                dataTsv = data;
            }
        );

        d3.json( ajaxUrl + "?station="+ station +"&sensor="+ sensor +"&XdisplaySizePxl="+(width - margin.left - margin.right)+"&infos=dataheader"+"&Since="+dateDomain[0]+"&To="+dateDomain[1],
            function(data) {
                console.TimeStep('load Header');
                console.log(data);
                chart
                    .dataheader(data)
                    .toHumanUnit(formulaConverter (data.sensor.SEN_MAGNITUDE, data.sensor.SEN_USER_UNIT));

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


    chart.nude = function(_) {
        if (!arguments.length) return nude;
        nude = _;
        if (_) {
            margin = {top: 0, right: 0, bottom: 0, left: 0};
        }
        return chart;
    };
    chart.dateParser = function(_) { // genere la fonction de conversion du champ [string]:date en [date]:date
        if (!arguments.length) return dateParser;
        if (typeof _ === "string") {
            timeFormat = d3.time.format(_);
            dateParser = function(d) { return timeFormat.parse (d.date); };
        } else dateParser = _;
        return chart;
    };
    chart.Color = function(_) {
        if (/(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i.test(_)) {
            darkColor = _;
            lightColor = '#c7c7c7';
        } else {
            darkColor = color(_+'1');
            lightColor = color(_+'2');
        }
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
    chart.trend = function(_) {
        if (!arguments.length) return trend;
        trend = _;
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
    chart.val = function(_) {
        if (!arguments.length) return val;
        val = _;
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
    chart.sensor = function(_) {
        if (!arguments.length) return sensor;
        sensor = _;
        return chart;
    };
    chart.dataheader = function(_) {
        if (!arguments.length) return dataheader;
        dataheader = _;
        return chart;
    };
    chart.sensor = function(_) {
        if (!arguments.length) return sensor;
        sensor = _;
        return chart;
    };

    chart.toHumanUnit = function(_) {
        if (!arguments.length) return toHumanUnit;
        toHumanUnit = _;
        return chart;
    };
    chart.toHumanDate = function(_) {
        if (!arguments.length) return toHumanDate;
        toHumanDate = _;
        return chart;
    };

  return chart;
  }