<?php
/**
* D3 binder to visualize <dataset> data
*
* @category D3Binder
* @package  Probe
* @author   Édouard Lopez <dev+probe@edouard-lopez.com>
* @license  http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode CC-by-nc-sa-3.0
* @link  http://probe.com/doc
 */
// data getter



?>
<style>

</style>
<div id="filename" class="canvas" style="clear:both;">
    <div id="Tree"> </div>
    <noscript><?=i18n('warning.javascript.disable');?></noscript>
</div>

<script type="text/javascript" src="/resources/js/libs/jstree/jquery.jstree.js"></script>

<script>
// http://jquery.bassistance.de/treeview/demo/

function probeViewer(){
    var url = "/data/currents?station=VP2_GTD";
    // $.getJSON(url, function(json) {
    $.getJSON(url, function(data) {
        console.log(data);

        $.each(data.data, function(key, val) { str = ''; recursiveFunction(key, val, 'Tree') });
        // console.log(str);
        $('#Tree').append('<ul>'+str+'</ul>');
        $("#Tree").jstree({
            "themes" : {
                "theme" : "apple",
                // "url" : '/resources/icons/jstree/'
                // "dots" : false,
                // "icons" : false
            },
            "types" : {
                "types" : {
                    "Item" : {
                        "icon" : {
                            // "image" : "../resources/icons/famfamfam/bricks.png"
                            // "image" : "../resources/icons/famfamfam/map_go.png"
                            "image" : "/resources/icons/famfamfam/tag_pink.png"
                            // "image" : "../resources/icons/famfamfam/bullet_go.png"
                            // "image" : "../resources/icons/famfamfam/feed.png"
                        }
                    },
                    "Grp" : {
                        // "icon" : {"image" : "../resources/icons/famfamfam/bricks.png"}
                    },
                    "Alarm" : {
                        "icon" : {"image" : "/resources/icons/famfamfam/clock.png"}
                    },
                    "Arch" : {
                        "icon" : {"image" : "/resources/icons/famfamfam/chart_curve.png"}
                    },
                    "Low" : {
                        "icon" : {"image" : "/resources/icons/famfamfam/tag_blue_delete.png"}
                    },
                    "High" : {
                        "icon" : {"image" : "/resources/icons/famfamfam/tag_blue_add.png"}
                    }

                }
            },
            "plugins" : [ "html_data", "types", "themes" ]
        });
        console.log('end');

    });
}
</script>
