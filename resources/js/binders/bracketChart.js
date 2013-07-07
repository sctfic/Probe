/** bracketChart.js
* D3 binder to visualize <dataset> data
*
* @category D3Binder
* @package  Probe
* @author   alban lopez <alban.lopez+probe@gmail.com>
* @license  http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode CC-by-nc-sa-3.0
* @link     http://probe.com/doc
*/

function timeSeriesChart_backet() {
  var margin = {top: 5, right: 5, bottom: 20, left: 30},
      width = 1800,
      height = 480,
      meanDate = function(d) { return d.date; },
      first = function(d) { return d.first; },
      min = function(d) { return d.min; },
      avg = function(d) { return d.avg; },
      max = function(d) { return d.max; },
      last = function(d) { return d.last; },
      xScale = d3.time.scale().range([0, width]),
      yScale = d3.scale.linear().range([height, 0]),
      xAxis = d3.svg.axis().scale(xScale).orient("bottom").tickSize(4,0),
      yAxis = d3.svg.axis().scale(yScale).orient("left").ticks(4).tickSize(3,0);
      // line = d3.svg.line().x(X).y(Y);


    function chart(selection) {
        //selection represente la liste de block ou ecire les donnees
        selection.each(function(data) {
            // Convert data to standard representation greedily;
            // this is needed for nondeterministic accessors.
            data = data.map(function(d, i) {
                return {
                    date:meanDate.call(data, d, i),
                    min:min.call(data, d, i),
                    first:first.call(data, d, i),
                    avg:avg.call(data, d, i),
                    last:last.call(data, d, i),
                    max:max.call(data, d, i),
                };
            });

            // Update the x-scale.
            xScale
                .domain(d3.extent(data, function(d) { return d.date; }))
                .range([0, width - margin.left - margin.right]);

            // Update the y-scale.
            yScale
                .domain([d3.min(data, function(d) {return d.min; }), d3.max(data, function(d) {return d.max; })])
                .range([height - margin.top - margin.bottom, 0]);

            // Select the svg element, if it exists.
            var svg = d3.select(this).selectAll("svg").data([data]);

            // Otherwise, create the skeletal chart.
            var gEnter = svg.enter().append("svg").append("g");

            gEnter.append("path").attr("class", "line");
            gEnter.append("g").attr("class", "x axis");
            gEnter.append("g").attr("class", "y axis");

            // Update the outer dimensions.
            svg .attr("width", width)
                .attr("height", height);

            // Update the inner dimensions.
            var g = svg.select("g")
                .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

            // Update the line path.
            // g.select(".line")
            //     .attr("d", line);
            var coef = (yScale.range()[0]-yScale.range()[1])/(yScale.domain()[1]-yScale.domain()[0]);

            // Draw box block
            var box = g.selectAll(".box")
                .data(data).enter().append("g")
                .attr("class", "box")
                .attr("opacity", "0");
                
                box.transition()
                    .delay(function(d,i) { return i*5;})
                    .duration(500)
                    .attr("opacity", "1");

                //Draw the line
                box.append("line")
                    .attr("class", "line")
                    .attr("x1", function(d) { return xScale(d.date); })
                    .attr("y1", function(d) { return yScale(d.min); })
                    .attr("x2", function(d) { return xScale(d.date); })
                    .attr("y2", function(d) { return yScale(d.max); });
                //Draw the Average
                box.append("line")
                    .attr("class", "line")
                    .attr("x1", function(d) { return xScale(d.date)-4; })
                    .attr("y1", function(d) { return yScale(d.avg); })
                    .attr("x2", function(d) { return xScale(d.date)+4; })
                    .attr("y2", function(d) { return yScale(d.avg); });
                //Draw the min
                box.append("line")
                    .attr("class", "line")
                    .attr("x1", function(d) { return xScale(d.date)-2; })
                    .attr("y1", function(d) { return yScale(d.min); })
                    .attr("x2", function(d) { return xScale(d.date)+2; })
                    .attr("y2", function(d) { return yScale(d.min); });
                //Draw the max
                box.append("line")
                    .attr("class", "line")
                    .attr("x1", function(d) { return xScale(d.date)-2; })
                    .attr("y1", function(d) { return yScale(d.max); })
                    .attr("x2", function(d) { return xScale(d.date)+2; })
                    .attr("y2", function(d) { return yScale(d.max); });
                //Draw the rect
                box.append("rect")
                    .attr("class", "rect")
                    .attr("x", function(d) { return xScale(d.date)-2; })
                    .attr("y", function(d) { return Math.min(yScale(d.first), yScale(d.last)); })
                    .attr("width", 4)
                    .attr("height", function(d) { return Math.abs(yScale(d.first)-yScale(d.last)); });

                // box.append("text").text(function(d) { return (d.max); })
                //     .attr("x",function(d) { return xScale(d.date)-16; })
                //     .attr("y",function(d) { return yScale(d.max)-3; });

                // box.append("text").text(function(d) { return (d.last); })
                //     .attr("x",function(d) { return xScale(d.date)+4; })
                //     .attr("y",function(d) { return yScale(d.last)+0; });

                // box.append("text").text(function(d) { return (d.avg); })
                //     .attr("x",function(d) { return xScale(d.date)-((d.avg+'').length*6+2); })
                //     .attr("y",function(d) { return yScale(d.avg)+3; });

                // box.append("text").text(function(d) { return (d.first); })
                //     .attr("x",function(d) { return xScale(d.date)+4; })
                //     .attr("y",function(d) { return yScale(d.first)+6; });

                // box.append("text").text(function(d) { return (d.min); })
                //     .attr("x",function(d) { return xScale(d.date)-16; })
                //     .attr("y",function(d) { return yScale(d.min)+10; });


                box.append("title")
                    .text(function(d) {
                            return d.date+
                                "\n\nMax\t\t\t\t\t: "+d.max+
                                "\n[Avg+Ecart-Type]\t\t: "+ d.last+
                                "\nAverage\t\t\t\t: "+d.avg+
                                "\nEcart-Type\t\t\t\t: "+Math.round((d.last-d.first)/2*1000)/1000+
                                "\n[Avg-Ecart-Type]\t\t: "+d.first+
                                "\nMin\t\t\t\t\t: "+d.min;
                        });

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
            g.select(".y.axis")
                .attr("transform", "translate(0,0)")
                .call(yAxis);
        });
    }





  // The x-accessor for the path generator; xScale ∘ meanDate.
  function X(d) {
    return xScale(d.date);
  }

  // The x-accessor for the path generator; yScale ∘ first.
  function Y(d) {
    return yScale(d.max);
  }

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

  chart.first = function(_) {
    if (!arguments.length) return first;
    first = _;
    return chart;
  };
  chart.min = function(_) {
    if (!arguments.length) return min;
    min = _;
    return chart;
  };
  chart.avg = function(_) {
    if (!arguments.length) return avg;
    avg = _;
    return chart;
  };
  chart.max = function(_) {
    if (!arguments.length) return max;
    max = _;
    return chart;
  };
  chart.last = function(_) {
    if (!arguments.length) return last;
    last = _;
    return chart;
  };
  return chart;
}