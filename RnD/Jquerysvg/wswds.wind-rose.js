  $(document).ready(function(){
      $("#rotate").click(
        function() {
            for (i=0; i<16; i++) {
                angle = (i+1)*22.5;
                console.log('here:'+i); // message
                $('#gToTransform').clone() // we clone the template object
                .attr('id', 'gToTransform-'+i) // we change its @id to prevent further conflict
                .appendTo('svg') // we append the clone at the end (inside) on the <svg>
                .attr('transform', 'translate(110, 110) rotate('+angle+' 0 0) scale('+(i%7*14+5)/100+')'); // update the @tranform value
//                .appendTo('svg') // we append the clone at the end (inside) on the <svg>
//      .attr('title', 'taille = '+(i%7*14+5)/100+' mm');
            }
        }
    )
  $("#rotate").click()
  }
)
