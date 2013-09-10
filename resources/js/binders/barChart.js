/** barChart.js
* D3 binder to visualize <dataset> data
*
* @category D3Binder
* @package  Probe
* @author   alban lopez <alban.lopez+probe@gmail.com>
* @license  http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode CC-by-nc-sa-3.0
* @link     http://probe-meteo.com/doc
*/
function include_barChart(container, station, sensor, XdisplaySizePxl)
{
    var formatDate = d3.time.format("%Y-%m-%d %H:%M");

    // on definie notre objet au plus pres de notre besoin.
    var barChart = timeSeriesChart_barChart()
                        .width(XdisplaySizePxl)
                        .ajaxUrl("/data/cumul")
                        .date(function(d) { return formatDate.parse (d.date); })
                        .station(station)
                        .sensor(sensor)
                        .onClickAction(function(d, i) { console.error (d, i); })
                        .toHumanDate(formulaConverter ('strDate', 'ISO'));

    barChart.loader(container);
}


function timeSeriesChart_barChart() {
  var   data,
        margin = {top: 5, right: 5, bottom: 20, left: 40},
        width = 600,
        height = 160,
        station = null,
        sensor = null,
        dataheader = null,
        ajaxUrl = null,
        onClickAction = function(d) { console.error (d); },
        unit = false,
        toHumanUnit = formulaConverter ('unknow', unit),
        toHumanDate = formulaConverter ('strDate', 'ISO'),
        dateParser = null,
        val = function(d) { return toHumanUnit(+d.val); },
        xScale = d3.time.scale().range([0, width]),
        yScale = d3.scale.linear().range([height, 0]),
        xAxis = d3.svg.axis().scale(xScale).orient("bottom").tickSize(4,6),
        yAxis = d3.svg.axis().scale(yScale).orient("left").ticks(4).tickSize(3,5);
        // line = d3.svg.line().x(X).y(Y);
        // circle = d3.svg.circle().


    function chart(selection) {
        md5 = MD5(station+sensor+(new Date()).getMilliseconds());
        // console.log(selection);
        //selection represente la liste de block ou ecire les donnees
        selection.each(function(rawdata) {
            // Convert data to standard representation greedily;
            // this is needed for nondeterministic accessors.
            data = rawdata.map(function(d, i) {
                var date=dateParser.call(rawdata, d, i)
                return {
                        val:val.call(rawdata, d, i),
                        // date:dateParser.call(rawdatarawdata, d, i),
                        date:date,
                        period:[
                            new Date(date.getTime()-(60*1000*dataheader.step/2)),
                            new Date(date.getTime()+(60*1000*dataheader.step/2))
                        ]
                    };
            });

            // Update the x-scale.
            xScale
                .domain(d3.extent(data, function(d) { return d.date; }))
                .range([0, width - margin.left - margin.right]);

            // Update the y-scale.
            yScale
                .domain(d3.extent(data, function(d) {return +d.val; }))
                .range([height - margin.top - margin.bottom, 0]);
            // console.log(toHumanUnit, [toHumanUnit(dataheader.min),toHumanUnit(dataheader.max)]);

            // Select the svg element, if it exists.
            var svg = d3.select(this).selectAll("svg").data([data]);


            // Otherwise, create the skeletal chart.
            var gEnter = svg.enter()
                        .append("svg")
                            .attr("width", "100%")
                            .attr("height", height);

            gEnter.append("svg:clipPath")
                .attr("id", "" + md5)
                .append("svg:rect")
                .attr('width', width - margin.left - margin.right)
                .attr('height', height - margin.top - margin.bottom);

            var timeoutID=null;
            var Sensitive = svg.append("rect")
                .attr("class", "sensitive")
                .attr('width', width - margin.left - margin.right)
                .attr('height', height - margin.top - margin.bottom)
                .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

            var g = gEnter.append("g")
                .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

            // chose the possition of x-Axis
            if (0<yScale.domain()[0])
                xPos = yScale.range()[0];
            else if (yScale.domain()[1]<0)
                xPos = yScale.range()[1];
            else
                xPos = yScale(0);

            // gEnter.append("path").attr("class", "line");
            g.append("g").attr("class", "x axis");
            g.append("g").attr("class", "y axis");

            // Draw stepPetalsBox block (on mouse hover point view foreach rose)
            var BarBox = g.selectAll(".BarBox")
                .data(data)
                .enter()
                .append("g")
                    .attr("class", "BarBox")
                    .attr("clip-path", "url(#" + md5 + ")")
                    .append("rect")
                        .attr("class", "bar")
                        .append("title");

            g.updateCurve = function(){
                yScale.domain(
                    d3.extent(
                        data.filter(function(element, index, array){
                          return (element.date>=xScale.domain()[0] && element.date<=xScale.domain()[1]);
                      }), function(d) {return d.val; }));
                this.selectAll(".BarBox rect")
                            .attr("x", X)
                            .attr("y", Y)
                            .attr("width", 8)
                            .attr("height", function(d) {return Math.abs(xPos-Y(d));})
                            .on("click", function(d) { return onClickAction(d); })
                            .select('title')
                            .text(function(d) {
                                    return formatVal(+d.val)+" (in "+dataheader.step+"min)\nFrom : "+toHumanDate(d.period[0])+"\nto : "+toHumanDate(d.period[1]);
                                });

                return this;
            }

            g.drawAxis = function(){
                // Update the x-axis.
                this.select(".x.axis")
                    .attr("transform", "translate(0," + xPos + ")") // axe tjrs en bas : yScale.range()[0] + ")")
                    .call(xAxis);
                this.select(".y.axis")
                    .attr("transform", "translate(0,0)")
                    .call(yAxis);

                return this;
            }
            // Update the outer dimensions.
            svg .attr("width", width)
                .attr("height", height);

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
        var DomBuilder = function(data2add) {
            data2add = data2add.map(function(d, i) {
                var date=dateParser.call(data2add, d, i)
                return {
                        val:val.call(data2add, d, i),
                        // date:dateParser.call(rawdatarawdata, d, i),
                        date:date,
                        period:[
                            new Date(date.getTime()-(60*1000*dataheader.step/2)),
                            new Date(date.getTime()+(60*1000*dataheader.step/2))
                        ]
                    };
            });
            
            data = data.filter(function(element, index, array){
                      return (element.date<data2add[0].date || element.date>data2add[data2add.length-1].date);
                  })

            var bars = g.selectAll(".BarBox")
                .data(data, function(d) { return d.date; });
            bars.exit().remove();
            
            data = data
               .concat(data2add)
               .sort(function (a, b) {
                   return a.date-b.date;
                  });
            bars = g.selectAll(".BarBox")
                .data(data, function(d) { return d.date; });

            bars.enter()
                .append("g")
                    .attr("class", "BarBox")
                    .attr("clip-path", "url(#" + md5 + ")")
                    .append("rect")
                        .attr("class", "bar")
                        .append("title");
        };

        d3.tsv( ajaxUrl + "?station="+ station +"&sensor=" + sensor + "&XdisplaySizePxl="+width+"&Since="+formatDate(zmDomain[0],'T')+"&To="+formatDate(zmDomain[1]
,'T'),
            function(data2add) {
                if (ready) {
                    DomBuilder(data2add);
                    g.updateCurve()
                     .drawAxis ();
                }
                ready = true;
                dataTsv = data2add;
            }
        );

        d3.json( ajaxUrl + "?station="+ station +"&sensor=" + sensor + "&XdisplaySizePxl="+width+"&infos=dataheader"+"&Since="+formatDate(zmDomain[0],'T')+"&To="+formatDate(zmDomain[1],'T'),
            function(header) {

                chart//.yDomain([header.min, header.max])
                    .dataheader(header);
                
                if (ready) {
                    DomBuilder(dataTsv);
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

// ================= Property of chart =================

    chart.loader = function(container) {
        var ready = false,
            dataTsv = false;
        // on demande les infos importante au sujet de notre futur tracé
        // ces infos permettent de finir le parametrage de notre "Chart"
        // on charge les données et on lance le tracage
        d3.tsv( ajaxUrl + "?station="+ station +"&sensor="+ sensor +"&XdisplaySizePxl="+width, //+"&Since=2013-05-30T10:00"+"&To=2013-05-31T06:00",
            function(data) {
                console.TimeStep('load Data');
                console.log(data);
                if (ready) {
                    d3.select(container)
                        .datum(data)
                        .call(chart);
                }
                ready = true;
                dataTsv = data;
            }
        );

        d3.json( ajaxUrl + "?station="+ station +"&sensor="+ sensor +"&XdisplaySizePxl="+width+"&infos=dataheader", //&since=2013-05-30T10:00"+"&To=2013-05-31T06:00",
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
        if (!arguments.length) return dateParser;
        dateParser = _;
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
    chart.onClickAction = function(_) {
        if (!arguments.length) return onClickAction;
        onClickAction = _;
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