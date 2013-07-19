function probeViewer(){

	var XdisplaySizePxl = $('#middleChartsArea').width();
	console.log(XdisplaySizePxl);

    var HistoricalVector = timeSeriesChart_histoWind()
                        .width(XdisplaySizePxl)
                        // .ajaxUrl("/data/histoWind")
                        .station(station)
                        .dateParser("%Y-%m-%d %H:%M")
                        .dateDomain([0, formatDate(new Date(), ' ')])
                        // .speed(function(d) { return +d.speed; })
                        // .angle(function(d) { return +d.angle; })
                        // .xSpeed(function(d) { return +d.x; })
                        // .ySpeed(function(d) { return +d.y; })
                        .onClickAction(function(d) { console.error (d); })
                        // .withAxis(false)
                        .toHumanSpeed(formulaConverter ('WindSpeed', 'km/h'))
                        .toHumanAngle(formulaConverter ('angle', '°'))
                        .toHumanDate(formulaConverter ('strDate', 'ISO'));

    // on definie notre objet au plus pres de notre besoin.
    var HistoricalSpeed = timeSeriesChart_curves()
                        .width(XdisplaySizePxl)
                        // .ajaxUrl("/data/curve")
                        .dateParser("%Y-%m-%d %H:%M")
                        .dateDomain([0, formatDate(new Date(), ' ')])
                        .station(station)
                        .sensor('TA:Arch:Various:Wind:SpeedAvg')
                        // .trend(6)
                        // .withAxis(false)
                        .toHumanDate(formulaConverter ('strDate', 'ISO'));

    // on definie notre objet au plus pres de notre besoin.
    var HistoricalDirection = timeSeriesChart_curves()
                        .width(XdisplaySizePxl)
                        // .ajaxUrl("/data/curve")
                        .dateParser("%Y-%m-%d %H:%M")
                        .dateDomain([0, formatDate(new Date(), ' ')])
                        .station(station)
                        .sensor('TA:Arch:Various:Wind:DominantDirection')
                        // .trend(6)
                        // .withAxis(false)
                        .toHumanDate(formulaConverter ('strDate', 'ISO'));

    // on definie notre objet au plus pres de notre besoin.
    var HistoricalRose = timeSeriesChart_histoRose()
                        .width(XdisplaySizePxl)
                        // .ajaxUrl("/data/windRose")
                        .station(station)
                        .dateParser("%Y-%m-%d %H:%M:%S")
                        .dateDomain([0, formatDate(new Date(), ' ')])
                        .rose(function(d) { return d.value; })
                        .onClickAction(function (d){
                            $("#detailWindRose p").text('Detail du : '+formatDate(d.date, ' '));
                            plotProbabilityRose(d.rose, '#detailWindRoseRatio', 120);
                            plotSpeedRose(d.rose, '#detailWindRoseSpeed',120);
                        })
                        // .withAxis(false)
                        .toHumanSpeed(formulaConverter ('WindSpeed', 'km/h'))
                        .toHumanAngle(formulaConverter ('angle', '°'))
                        .toHumanDate(formulaConverter ('strDate', 'ISO'));

    HistoricalRose.loader('#HistoricalRose');
    HistoricalVector.loader('#HistoricalVector');
    HistoricalSpeed.loader('#HistoricalSpeed');
    HistoricalDirection.loader('#HistoricalDirection');

	XdisplaySizePxl = $('#middleChartsArea').width();
	console.log(XdisplaySizePxl);
}



