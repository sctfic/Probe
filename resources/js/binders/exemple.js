function include_curve(container, station, sensor, XdisplaySizePxl)
{
    // on definie notre objet au plus pres de notre besoin.
    var curves = timeSeriesChart()
                        .width(XdisplaySizePxl);
                        // .ajaxUrl("/data/curve")
                        // .dateParser("%Y-%m-%d %H:%M")
                        // .dateDomain(["2013-06-31T06:00:00", formatDate(new Date(), ' ')])
                        // .station(station)
                        // .sensor(sensor)
                        // .trend(6)
                        // .withAxis(false)
                        // .toHumanDate(formulaConverter ('strDate', 'ISO'));

    curves.chart();
    // curves.loader(container);
}



function timeSeriesChart() {
  var margin = {top: 5, right: 5, bottom: 20, left: 30},
      width = 1200,
      height = 120,
      meanDate = function(d) { return d.date; },
      Speed = function(d) { return d.speed; },
      angle = function(d) { return d.angle; },
      xSpeed = function(d) { return d.x; },
      ySpeed = function(d) { return d.y; },
      xScale = d3.time.scale().range([0, width]),
      yScale = d3.scale.linear().range([height, 0]),
      xAxis = d3.svg.axis().scale(xScale).orient("bottom").tickSize(4,0),
      yAxis = d3.svg.axis().scale(yScale).orient("left").ticks(4).tickSize(3,0),
      line = d3.svg.line().x(X).y(Y);
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
                    Speed:Speed.call(data, d, i),
                    angle:angle.call(data, d, i),
                    xSpeed:xSpeed.call(data, d, i),
                    ySpeed:ySpeed.call(data, d, i)
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
            gEnter.append("g").attr("class", "y axis");

            // Update the outer dimensions.
            svg .attr("width", width)
                .attr("height", height);

            // Update the inner dimensions.
            var g = svg.select("g")
                .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

            // Update the line path.
            g.select(".line")
                .attr("d", line);

            // Update the x-axis.
                // console.log(yScale.domain())
                // [-0.642, 1.61] 
            if (0<yScale.domain()[0]) xPos = yScale.range()[0];
            else if (yScale.domain()[1]<0) xPos = yScale.range()[1];
            else xPos = yScale(0);
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
    return yScale(d.ySpeed);
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