/** ProbeTools.js
* D3 binder to visualize <dataset> data
*
* @category Tools
* @package  Probe
* @author   alban lopez <alban.lopez+probe@gmail.com>
* @license  http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode CC-by-nc-sa-3.0
* @link     http://probe.com/doc
*/

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
retourne la fonction de convertion pour obtenir l'unitée souhaitee
    * @ Si aucun parametre formulaConverter() retourne la liste des grandeur connue
    * @ Si seulement la Grandeur est fournie alors formulaConverter() retourne la liste des unitees possible pour cette grandeur
    * @param inputObj:{Type_De_Grandeur, Unité_SI}
    * @param 
    * @exemple: console.log(formulaConverter());
    * @exemple: console.log(formulaConverter('Temperature'));
    * @exemple: console.log(formulaConverter('Temperature','K'));
    */
function formulaConverter (grandeur, outputUnit)
{
    var units = {

        WindSpeed:{
        	// ref: 'http://en.wikipedia.org/wiki/Speed'
            'm/s':     { name: 'Metres per second',	    symbol: 'm/s',	formula: function(SI){if (!arguments.length) return 'm/s'; return +SI;}},	// ok
            'm.s¹':    { name: 'Metres per second',	    symbol: 'm.s¹',	formula: function(SI){if (!arguments.length) return 'm.s¹'; return +SI;}},	// ok
            'km/h':    { name: 'kilometres per hour',	symbol: 'km/h',	formula: function(SI){if (!arguments.length) return 'km/h'; return 3.6*SI;}},	// ok
            'mph':     { name: 'miles per hour',		symbol: 'mph',	formula: function(SI){if (!arguments.length) return 'mph'; return 2.236936*SI;}},	// ok
            'mi/h':    { name: 'miles per hour',		symbol: 'mi/h',	formula: function(SI){if (!arguments.length) return 'mi/h'; return 2.236936*SI;}},	// ok
            'fps':     { name: 'feet per second',		symbol: 'fps',	formula: function(SI){if (!arguments.length) return 'fps'; return 3.280840*SI;}},	// ok
            'ft/s':    { name: 'feet per second',		symbol: 'ft/s',	formula: function(SI){if (!arguments.length) return 'ft/s'; return 3.280840*SI;}},	// ok
            'knot':    { name: 'Nautical mile',		    symbol: 'knot',	formula: function(SI){if (!arguments.length) return 'knot'; return 1.943844*SI;}},	// ok
            'kn':      { name: 'Nautical mile',		    symbol: 'kn',	formula: function(SI){if (!arguments.length) return 'kn'; return 1.943844*SI;}},	// ok
            'kt':      { name: 'Nautical mile',		    symbol: 'kt',	formula: function(SI){if (!arguments.length) return 'kt'; return 1.943844*SI;}},	// ok
        },
        Temperature:{
            // ref:'http://en.wikipedia.org/wiki/Temperature_conversion_formulas',
            'K':       { name: 'Kelvin',				symbol: 'K',	formula: function(SI){if (!arguments.length) return 'K'; return +SI;}},	// ok
            '°C':      { name: 'Celsius',				symbol: '°C',	formula: function(SI){if (!arguments.length) return '°C'; return SI-273.15;}},	// ok
            '°F':      { name: 'Fahrenheit',			symbol: '°F',	formula: function(SI){if (!arguments.length) return '°F'; return SI*9/5-459.67;}},	// ok
            '°R':      { name: 'Rankine',				symbol: '°R',	formula: function(SI){if (!arguments.length) return '°R'; return SI*9/5;}},	// ok
            '°De':     { name: 'Delisle',				symbol: '°De',	formula: function(SI){if (!arguments.length) return '°De'; return (273.15-SI)*3/2;}},	// ok
            '°N':      { name: 'Newton',				symbol: '°N',	formula: function(SI){if (!arguments.length) return '°N'; return (SI-273.15)*33/100;}},	// ok
            '°Ré':     { name: 'Réaumur',				symbol: '°Ré',	formula: function(SI){if (!arguments.length) return '°Ré'; return (SI-273.15)*4/5;}},	// ok
            '°Rø':     { name: 'Rømer',				    symbol: '°Rø',	formula: function(SI){if (!arguments.length) return '°Rø'; return (SI-273.15)*21/40+7.5;}},	// ok
        },
        Rain:{
            'mm':    { name: 'Millimeters per hour',              symbol: 'mm',     formula: function(Sample){if (!arguments.length) return 'mm'; return Sample;}},    // ok
            'l/m²':  { name: 'Litre per square metre per hour',   symbol: 'l/m²',   formula: function(Sample){if (!arguments.length) return 'l/m²'; return Sample;}},    // ok
            'in':    { name: 'inch per hour',                     symbol: 'in',     formula: function(Sample){if (!arguments.length) return 'in'; return Sample/25.4;}},    // ok
        },
        RainSpeed:{
            'mm/h':    { name: 'Millimeters per hour',              symbol: 'mm/h',     formula: function(SI){if (!arguments.length) return 'mm/h'; return +SI;}},    // ok
            'l/m²/h':  { name: 'Litre per square metre per hour',   symbol: 'l/m²/h',   formula: function(SI){if (!arguments.length) return 'l/m²/h'; return +SI;}},    // ok
            'l/m²/min':{ name: 'Litre per square metre per minute', symbol: 'l/m²/min', formula: function(SI){if (!arguments.length) return 'l/m²/min'; return SI/60;}},  // ok
            'mm/min':  { name: 'Millimeters per ',                  symbol: 'mm/min',   formula: function(SI){if (!arguments.length) return 'mm/min'; return SI/60;}},  // ok
            'in/h':    { name: 'inch per hour',                     symbol: 'in/h',     formula: function(SI){if (!arguments.length) return 'in/h'; return SI/25.4;}},    // ok
            'in/min':  { name: 'inch per minut',                    symbol: 'in/min',   formula: function(SI){if (!arguments.length) return 'in/min'; return SI/25.4/60;}}, // ok
        },
        Humidity:{
            '%':   { name: 'amount of water vapor',         symbol: '%',		formula: function(SI){if (!arguments.length) return '%'; return +SI;}},	// ok
        },
        Pressure:{
        	// ref: 'http://en.wikipedia.org/wiki/Pressure'
        	// ref: 'http://www.sensorsone.co.uk/pressure-measurement-glossary/pa-pascal-pressure-unit.html'
            'Pa':      { name: 'Pascal', 					symbol: 'Pa',		formula: function(SI){if (!arguments.length) return 'Pa'; return +SI;}},
            'hPa':     { name: 'Hecto Pascal', 			    symbol: 'hPa',		formula: function(SI){if (!arguments.length) return 'hPa'; return SI/100;}},	// ok
            'bar':     { name: 'Bar', 						symbol: 'bar',		formula: function(SI){if (!arguments.length) return 'bar'; return SI/100000;}},	// ok
            'mbar':    { name: 'milliBar', 				    symbol: 'mbar',		formula: function(SI){if (!arguments.length) return 'mbar'; return SI/100;}},	// ok
            'at':      { name: 'Technical atmosphere', 	    symbol: 'at',		formula: function(SI){if (!arguments.length) return 'at'; return 0.0000101972*SI;}},	// ok
            'atm':     { name: 'Standard atmosphere', 		symbol: 'atm',		formula: function(SI){if (!arguments.length) return 'atm'; return 0.00000986923*SI;}},	// ok
            'Torr':    { name: 'Torr', 					    symbol: 'Torr',		formula: function(SI){if (!arguments.length) return 'Torr'; return 0.00750062*SI;}},	// ok
            'psi':     { name: 'Pounds per square inch', 	symbol: 'psi',		formula: function(SI){if (!arguments.length) return 'psi'; return 0.0001450377*SI;}},	// ok
            'N/m2':    { name: 'Newtons per square metre',  symbol: 'N/m2',		formula: function(SI){if (!arguments.length) return 'N/m2'; return +SI;}},	// ok
            'mmHg':    { name: 'Millimeters of Mercury', 	symbol: 'mmHg',		formula: function(SI){if (!arguments.length) return 'mmHg'; return 0.00750062*SI;}},	// ok
            'mmH2O':   { name: 'Millimeters of Wather', 	symbol: 'mmH2O',	formula: function(SI){if (!arguments.length) return 'mmH2O'; return 0.000101972*SI;}},	// ok
        },
        Evapotranspiration:{
        	// ref: 'http://en.wikipedia.org/wiki/Evapotranspiration'
            'ET':      { name: 'Evapotranspiration',        symbol: 'ET',		formula: function(SI){if (!arguments.length) return 'ET'; return +SI;}},	// ok
        },
        angle:{
        	// ref: 'http://en.wikipedia.org/wiki/Evapotranspiration'
            '°':       { name: 'Degrees',			        symbol: '°',		formula: function(SI){if (!arguments.length) return '°'; return +SI;}},	// ok
            'Rad':     { name: 'Radians',				    symbol: 'Rad',		formula: function(SI){if (!arguments.length) return 'Rad'; return SI*(Math.pi()/180);}},	// ok
            'tr':      { name: 'Turns',			    	    symbol: 'tr',		formula: function(SI){if (!arguments.length) return 'tr'; return SI/360;}},	// ok
            'CarDir':  { name: 'Cardinal directions',	    symbol: '',			formula: function(SI){if (!arguments.length) return ''; 	// ok
                	var windDir = ['N', 'NNE','NE','ENE','E','ESE','SE','SSE','S','SSW','SW','WSW','W','WNW','NW','NNW'];
                	return windDir[Math.round(SI/22.5)%16];	// ok
                }
            },
        },
        UV: {
            'Idx': { name: 'UV index',     symbol: '',		formula: function(SI){if (!arguments.length) return ''; return +SI;}},	// ok
        },
        Solar: {
            'w/m²':    { name: 'Solar radiation',     symbol: 'w/m²',   formula: function(SI){if (!arguments.length) return 'w/m²'; return +SI;}},    // ok
        },
        strDate: {
            'Auto':    { name: 'Auto',     symbol: 'Browser display',   formula: function(d){if (!arguments.length) return ''; return d;}},    // ok
            'ISO':    { name: 'ISO-8601',     symbol: 'yyyy-mm-dd hh:mm:ss',   formula: function(d){if (!arguments.length) return ''; return formatDate(d, ' ');} },    // ok
        }
    };

    // si on as pas d'argument demandé
    if (!arguments.length) return d3.keys(units); // return units
    // si on demande une grandeur sans lunite de conversion
    if (arguments.length==1) return d3.keys( units[grandeur] ); // return units[grandeur]
    // units.foreach(logArrayElements);
    if (units[grandeur] && units[grandeur][outputUnit]) {
        // console.log(grandeur, outputUnit);
        return units[grandeur][outputUnit].formula;
    }
    return function(SI){return +SI;};
}

function logArrayElements(element, index, array) {
    console.log("a[" + index + "] = " + element);
}