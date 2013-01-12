var COL={date:0,open:1,high:2,low:3,close:4,volume:5};
var min=Math.min.apply(Math,$data.map(ƒ(COL.low))),
    max=Math.max.apply(Math,$data.map(ƒ(COL.high))),
    vscale=($playground.offsetHeight-20)/(max-min);

var vol     = $data.map(ƒ(COL.volume)),
    volMin  = Math.min.apply(Math,vol),
    volDiff = Math.max.apply(Math,vol)-volMin;

var boxes = d3.select("#playground").selectAll("div.box").data($data); 

boxes.enter() 
  .append('div').attr('class','box')
    .append('div').attr('class','range');

boxes
  .sort(function(a,b){ return a[0]<b[0]?-1:a[0]>b[0]?1:0 })
  .attr('title',function(d){ return d[COL.date]+" open:"+d[COL.open]+", close:"+d[COL.close]+" ("+d[COL.low]+"–"+d[COL.high]+")" })
  .style('height',function(d){ return (d[COL.high]-d[COL.low])*vscale+'px' })
  .style('margin-bottom',function(d){ return (d[COL.low]-min)*vscale+'px'})
  .select('.range')
    .classed('fall',function(d){ return d[COL.open]>d[COL.close] })
    .style('height',function(d){ return Math.abs(d[COL.open]-d[COL.close])*vscale+'px' })
    .style('bottom',function(d){ return (Math.min(d[COL.close],d[COL.open])-d[COL.low])*vscale+'px'})
    .style('opacity',function(d){ return (d[COL.volume]-volMin)/volDiff });

boxes.exit().remove();