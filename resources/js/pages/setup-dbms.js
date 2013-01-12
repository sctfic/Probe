/*
Add the @require attributes relative to the active engine.
 */
function addRequire(field) {
    "use strict";
    console.log('field: '+field);
    $('.mysql input[name="dbms-host"]').attr('required', 'required');
    $('.mysql input[name="dbms-port"]').attr('required', 'required');
    $('.mysql input[name="dbms-username"]').attr('required', 'required');
    $('.mysql input[name="dbms-password"]').attr('required', 'required');
}

function removeRequire(disabledEngines) {
    "use strict";
    var disabledEngines = $('#dbms-engine input:not(:checked)').val();
    $('.' + disabledEngines + ' input').removeAttr('required');
}

/*
    Attach the event handler to disable/enable field related
    to selected database engine.
 */
function engineHandler() {
    $('#dbms-engine input').change(function () {
        $('.mysql, .sqlite, .postgresql').slideToggle(400, function () {
            "use strict";
            removeRequire($('#dbms-engine input:not(:checked)').val());
            addRequire( $('#dbms-engine input:checked').val());
        });
    });
}

/*
    Entry point
 */
function run() {
    "use strict";
    engineHandler();
}

run();