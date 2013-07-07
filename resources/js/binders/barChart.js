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
  var   margin = {top: 5, right: 5, bottom: 20, left: 40},
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
        meanDate = null,
        val = function(d) { return toHumanUnit(+d.val); },
        xScale = d3.time.scale().range([0, width]),
        yScale = d3.scale.linear().range([height, 0]),
        xAxis = d3.svg.axis().scale(xScale).orient("bottom").tickSize(4,6),
        yAxis = d3.svg.axis().scale(yScale).orient("left").ticks(4).tickSize(3,5);
        // line = d3.svg.line().x(X).y(Y);
        // circle = d3.svg.circle().


    function chart(selection) {
        // console.log(selection);
        //selection represente la liste de block ou ecire les donnees
        selection.each(function(data) {
            // Convert data to standard representation greedily;
            // this is needed for nondeterministic accessors.
            data = data.map(function(d, i) {
                return {
                    date:meanDate.call(data, d, i),
                    val:val.call(data, d, i)
                };
            });
            // Update the x-scale.
            xScale
                .domain(d3.extent(data, function(d) { return d.date; }))
                .range([0, width - margin.left - margin.right]);
                // rangeRoundBands

            // Update the y-scale.
            yScale
                .domain(d3.extent(data, function(d) {return +d.val; }))
                .range([height - margin.top - margin.bottom, 0]);
            // console.log(toHumanUnit, [toHumanUnit(dataheader.min),toHumanUnit(dataheader.max)]);

            // Select the svg element, if it exists.
            var svg = d3.select(this).selectAll("svg").data([data]);

            // Otherwise, create the skeletal chart.
            var gEnter = svg.enter().append("svg").append("g");

            // chose the possition of x-Axis
            if (0<yScale.domain()[0])
                xPos = yScale.range()[0];
            else if (yScale.domain()[1]<0)
                xPos = yScale.range()[1];
            else
                xPos = yScale(0);

            // Draw stepPetalsBox block (on mouse hover point view foreach rose)
            var stepBarBox = gEnter.selectAll(".stepBarBox")
                .data(data).enter().append("g")
                .attr("class", "stepBarBox");

                stepBarBox.append("rect")
                    .attr("class", "sensitive")
                    .attr("x", function(d) {return X(d)-1;})
                    .attr("width", 10)
                    .attr("height", height)
                    .on("click", function(d) { return onClickAction(d); })
                    .append("title")
                    .text(function(d) {
                            return toHumanDate(d.date)+"\nEach item for "+dataheader.step+" min\n"+formatVal(+d.val);
                        });

                // attempt to use circle instead of line < - - - - - - -
                stepBarBox.append("rect")
                    .attr("class", "bar")
                    .attr("x", X)
                    .attr("y", Y)
                    .attr("width", 8)
                    .attr("height", function(d) {return Math.abs(xPos-Y(d));})
                    .on("click", function(d) { return onClickAction(d); })
                    .append("title")
                    .text(function(d) {
                            return toHumanDate(d.date)+"\nEach item for "+dataheader.step+" min\n"+formatVal(+d.val);
                        });
            // Update the inner dimensions.
            var g = svg.select("g")
                .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

            // Update the line path.
            // g.select(".line")
            //     .attr("d", line);
            

            // gEnter.append("path").attr("class", "line");
            gEnter.append("g").attr("class", "x axis");
            gEnter.append("g").attr("class", "y axis");

            // Update the outer dimensions.
            svg .attr("width", width)
                .attr("height", height);

            // Update the x-axis.
            g.select(".x.axis")
                .attr("transform", "translate(0," + xPos + ")") // axe tjrs en bas : yScale.range()[0] + ")")
                .call(xAxis);
            g.select(".y.axis")
                .attr("transform", "translate(0,0)")
                .call(yAxis);
        });
    }  





    // The x-accessor for the path generator; xScale ∘ meanDate.
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
        if (!arguments.length) return meanDate;
        meanDate = _;
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