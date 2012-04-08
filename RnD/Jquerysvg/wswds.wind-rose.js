$(document).ready(function(){
      $("#rotate").click(
        function() {
            data = fetchData(); // retrieve data from the server

            for (i=0; i<16; i++) {
                angle = (i+1)*22.5;
//                 console.log('here:'+i); // message
                $('#gToTransform').clone() // we clone the template object
                    .attr('id', 'gToTransform-'+i) // we change its @id to prevent further conflict
                    .appendTo('svg') // we append the clone at the end (inside) on the <svg>
                    .attr('transform', 'translate(110, 110) rotate('+angle+' 0 0) scale('+data[i]+')') // update the @tranform value
                    .attr('fill', colorize(data[i])) // add color depending on force
                    .attr('title', data[i])  // hover information
                ;
//                .appendTo('svg') // we append the clone at the end (inside) on the <svg>
//      .attr('title', 'taille = '+(i%7*14+5)/100+' mm');
            }
        }
    )

    function colorize(force)
    {
        color = [
            '#4e9a06',  //[0-5[ -> dark green
            '#73d216',  //[5-10[ -> medium green
            '#8ae234',  //[10-20[ -> light green
            '#fce94f',  //[20-30[ -> light yellow
            '#edd400',  //[40-50[ yellow
            '#fcaf3e',  //[50-60[ # light orange
            '#f57900',  //[60-70[ orange
            '#ef2929',//[70-80[
            '#ad7fa8',//[80-90[
            '#75507b',//[90-100[
        ];

        item = Math.round(force*10);
        console.log('force: '+force+' item: '+item+'color[item]'+color[item]);
        return color[item];
    }

// this method should connect to the server using AJAX or 'web Sockets' and return an array of value
// right now we just return a fixed array, you need to build the client-server communication
    function fetchData() {
        fakeData = []; // define the array to return
        for (i=0; i<16; i++) { fakeData[i] = Math.round(Math.random()*100)/100; } // fill the array with random data

        return fakeData;
    }
  $("#rotate").click()
  }
)
