
function probeViewer(){
	progressbar ();

	var XdisplaySizePxl = $('#middleChartsArea').width()-4;

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
                            $("#detailWindRose h3:first").text('Detail du : '+formatDate(d.date, ' '));
                            $("#detailWindRose p:first").text('du : '+formatDate(d.period[0], ' ')+' au : '+formatDate(d.period[1], ' '));
                            $("#detailWindRose").css('display', 'block');

                            plotProbabilityRose(d.rose, '#detailWindRoseRatio', 120);
                            plotSpeedRose(d.rose, '#detailWindRoseSpeed',120);
                        })
                        // .withAxis(false)
                        .toHumanSpeed(formulaConverter ('WindSpeed', 'km/h'))
                        .toHumanAngle(formulaConverter ('angle', '°'))
                        .toHumanDate(formulaConverter ('strDate', 'ISO'));

    HistoricalRose.loader('#HistoricalRose', function(_){ $('#middleChartsArea .bar').attr('data-percentage', _);});
    HistoricalVector.loader('#HistoricalVector');
    HistoricalSpeed.loader('#HistoricalSpeed');
    HistoricalDirection.loader('#HistoricalDirection');


}


function progressbar () {
    $('.progress .bar').each(function() {
        var me = $(this);

        //TODO: left and right text handling

        var current_perc = 0;

        var progress = setInterval(function() {
            var perc = me.attr("data-percentage");
            if (current_perc>=100) {
                clearInterval(progress);
                setTimeout( function () { me.parent().remove();} , 500);
				$('svg').each( function(){
					var ths = $(this);
					// console.log(ths, "viewBox", "0 0 "+ths.width()+" "+ths.height());
				 	// ths.css("width", ths.width());
				 	// ths.css("height", ths.height());
					ths.css("viewBox", "0 0 "+ths.width()+" "+ths.height());
					// console.log(ths.css());
				})
            } else if (current_perc < +perc) {
                current_perc +=1;
                me.css('width', (current_perc)+'%');
            }

            me.text((current_perc)+'%');

        }, 50);

    });
}
