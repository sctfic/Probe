function formatDate(value, separator)
{
    //toDateString()
    if(typeof(separator)==='undefined') separator = 'T';
    var dd = value.getDate(); 
    var mm = value.getMonth()+1;//January is 0! 
    var yyyy = value.getFullYear();
    var H = value.getHours();
    var m = value.getMinutes()
    if(dd<10) dd='0'+dd ; 
    if(mm<10) mm='0'+mm ; 
    if(H<10) H='0'+H ; 
    if(m<10) m='0'+m ; 
    return yyyy + "-" + mm + "-" + dd + separator + H + ":" + m  + ":00";
}

(function() {
    var previousStep = Date.now();
    // console.debug('[0.000 sec]', 'Initialize( console.TimeStep )');
    console.TimeStep = function(msg) {
        var step = Date.now()-previousStep;
        previousStep = Date.now();
        console.debug('['+(step/1000)+' sec]', msg);
    }
})()

/**
Convertie toutes les unités de base SI en d'autre unitées connues
    * @
    * @param inputObj:{Type_De_Grandeur, Valeur_Numerique, Unité_SI}
    * @param 
    */
function formulaConverter (input, outputUnit)
{
array()
    var units = {
        WindSpeed:{
        	// ref: 'http://en.wikipedia.org/wiki/Speed'
            { name: 'Metres per second',	symbol: 'm/s',	formula:function(SI){return +SI;},	// ok
            { name: 'Metres per second',	symbol: 'm.s¹',	formula:function(SI){return +SI;},	// ok
            { name: 'kilometres per hour',	symbol: 'km/h',	formula:function(SI){return 3.6*SI;},	// ok
            { name: 'miles per hour',		symbol: 'mph',	formula:function(SI){return 2.236936*SI;},	// ok
            { name: 'miles per hour',		symbol: 'mi/h',	formula:function(SI){return 2.236936*SI;},	// ok
            { name: 'feet per second',		symbol: 'fps',	formula:function(SI){return 3.280840*SI;}	// ok
            { name: 'feet per second',		symbol: 'ft/s',	formula:function(SI){return 3.280840*SI;}	// ok
            { name: 'Nautical mile',		symbol: 'knot',	formula:function(SI){return 1.943844*SI;},	// ok
            { name: 'Nautical mile',		symbol: 'kn',	formula:function(SI){return 1.943844*SI;},	// ok
            { name: 'Nautical mile',		symbol: 'kt',	formula:function(SI){return 1.943844*SI;},	// ok
        },
        Temperature:{
            // ref:'http://en.wikipedia.org/wiki/Temperature_conversion_formulas',
            { name: 'Kelvin',				symbol: 'K',	formula: function(SI){return +SI;},	// ok
            { name: 'Celsius',				symbol: '°C',	formula: function(SI){return SI-273.15;},	// ok
            { name: 'Fahrenheit',			symbol: '°F',	formula: function(SI){return SI*9/5-459.67;},	// ok
            { name: 'Rankine',				symbol: '°R',	formula: function(SI){return SI*9/5;},	// ok
            { name: 'Delisle',				symbol: '°De',	formula: function(SI){return (273.15-SI)*3/2;},	// ok
            { name: 'Newton',				symbol: '°N',	formula: function(SI){return (SI-273.15)*33/100;},	// ok
            { name: 'Réaumur',				symbol: '°Ré',	formula: function(SI){return (SI-273.15)*4/5;},	// ok
            { name: 'Rømer',				symbol: '°Rø',	formula: function(SI){return (SI-273.15)*21/40+7.5;},	// ok
        },
        RainSpeed:{
            { name: 'Millimeters per hour', 				symbol: 'mm/h',		formula: function(SI){return +SI;},	// ok
            { name: 'Litre per square metre per hour',		symbol: 'l/m²/h',	formula: function(SI){return +SI;},	// ok
            { name: 'Litre per square metre per minute',	symbol: 'l/m²/min',	formula: function(SI){return SI/60;},	// ok
            { name: 'Millimeters per ', 					symbol: 'mm/min',	formula: function(SI){return SI/60;},	// ok
            { name: 'inch per hour', 						symbol: 'in/h',		formula: function(SI){return SI/25.4;},	// ok
            { name: 'inch per minut', 						symbol: 'in/min',	formula: function(SI){return SI/25.4/60;},	// ok
        },
        Humidity:{
            { name: 'amount of water vapor', symbol: '%',		formula: function(SI){return +SI;},	// ok
        },
        Pressure:{
        	// ref: 'http://en.wikipedia.org/wiki/Pressure'
        	// ref: 'http://www.sensorsone.co.uk/pressure-measurement-glossary/pa-pascal-pressure-unit.html'
            { name: 'Pascal', 					symbol: 'Pa',		formula: function(SI){return +SI;},
            { name: 'Hecto Pascal', 			symbol: 'hPa',		formula: function(SI){return SI/100;},	// ok
            { name: 'Bar', 						symbol: 'bar',		formula: function(SI){return SI/100000;},	// ok
            { name: 'milliBar', 				symbol: 'mbar',		formula: function(SI){return SI/100;},	// ok
            { name: 'Technical atmosphere', 	symbol: 'at',		formula: function(SI){return 0.0000101972*SI;},	// ok
            { name: 'Standard atmosphere', 		symbol: 'atm',		formula: function(SI){return 0.00000986923*SI;},	// ok
            { name: 'Torr', 					symbol: 'Torr',		formula: function(SI){return 0.00750062*SI;},	// ok
            { name: 'Pounds per square inch', 	symbol: 'psi',		formula: function(SI){return 0.0001450377*SI;},	// ok
            { name: 'Newtons per square metre', symbol: 'N/m2',		formula: function(SI){return +SI;},	// ok
            { name: 'Millimeters of Mercury', 	symbol: 'mmHg',		formula: function(SI){return 0.00750062*SI;},	// ok
            { name: 'Millimeters of Wather', 	symbol: 'mmH2O',	formula: function(SI){return 0.000101972*SI;},	// ok
        },
        Evapotranspiration:{
        	// ref: 'http://en.wikipedia.org/wiki/Evapotranspiration'
            { name: 'Evapotranspiration', symbol: 'ET',		formula: function(SI){return +SI;},	// ok
        }
        angle:{
        	// ref: 'http://en.wikipedia.org/wiki/Evapotranspiration'
            { name: 'Degrees',				symbol: '°',		formula: function(SI){return +SI;},	// ok
            { name: 'Radians',				symbol: 'Rad',		formula: function(SI){return SI*(Math.pi()/180);},	// ok
            { name: 'Turns',				symbol: 'tr',		formula: function(SI){return SI/360;},	// ok
            { name: 'Cardinal directions',	symbol: '',			formula: function(SI){	// ok
            	var windDir = ['N', 'NNE','NE','ENE','E','ESE','SE','SSE','S','SSW','SW','WSW','W','WNW','NW','NNW'];
            	return windDir[Math.round(SI/22.5)%16];	// ok
            },
        },
        UV: {
            { name: 'UV index', symbol: '-',		formula: function(SI){return +SI;},	// ok
        },
        Solar: {
            { name: 'Solar radiation', symbol: 'w/m²',	formula: function(SI){return +SI;},	// ok
        }
    };
    // si on as pas d'argument demandé
    if (!arguments.length) return width;
    // si on demande une grandeur sans lunite de conversion
    if (arguments.length==1) return width;
    return 
}