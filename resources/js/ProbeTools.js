function formatDate(value)
{
    var dd = value.getDate(); 
    var mm = value.getMonth()+1;//January is 0! 
    var yyyy = value.getFullYear();
    var H = value.getHours();
    var m = value.getMinutes()
    if(dd<10) dd='0'+dd ; 
    if(mm<10) mm='0'+mm ; 
    if(H<10) H='0'+H ; 
    if(m<10) m='0'+m ; 
    return yyyy + "-" + mm + "-" + dd + "T" + H + ":" + m  + ":00";
}

(function() {
    var previousStep = Date.now();
    console.debug('[0.000 sec]', 'Initialize( console.TimeStep )');
    console.TimeStep = function(msg) {
        var step = Date.now()-previousStep;
        previousStep = Date.now();
        console.debug('['+(step/1000)+' sec]', msg);
    }
})()