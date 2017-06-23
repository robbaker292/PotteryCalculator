function drawGraph(product, event_id, pm, date) {
    console.log(product, event_id, pm, date);

    // set the dimensions and margins of the graph
    var margin = {top: 20, right: 20, bottom: 40, left: 40},
        width = 960 - margin.left - margin.right,
        height = 500 - margin.top - margin.bottom;

    // set the ranges
    var x = d3.scaleLinear()
        .range([0, width]);

    var y = d3.scaleLinear()
        .range([height, 0]);

    var center = d3.scaleLinear()
        .range([0, width]);

    // define the line
    var valueline = d3.line()
        .x(function(d) { return x(d.sale_price); })
        .y(function(d) { return y(d.profit); });

    $("#drawingArea").empty();
    // append the svg object to the body of the page
    // append a 'group' element to 'svg'
    // moves the 'group' element to the top left margin
    var svg = d3.select("#drawingArea").append("svg")
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
        .append("g")
        .attr("transform", 
          "translate(" + margin.left + "," + margin.top + ")");

     // get the data
    d3.json("../getPotentialSale/"+product+"/"+event_id+"/"+pm+"/"+date+"/1", function(error, data) {
        if (error) throw error;

        $("#potentialSaleGraph").show();

        // gridlines in x axis function
        function make_x_gridlines() {       
            return d3.axisBottom(x)
                .ticks(10)
        }

        // gridlines in y axis function
        function make_y_gridlines() {       
            return d3.axisLeft(y)
                .ticks(10)
        } 

        // format the data
        data.forEach(function(d) {
            console.log(d);
        });

        // Scale the range of the data
        x.domain(d3.extent(data, function(d) { return d.sale_price; }));
        y.domain([d3.min(data, function(d) { return d.profit; }), d3.max(data, function(d) { return d.profit; })]);

        // add the X gridlines
        svg.append("g")           
          .attr("class", "grid")
          .attr("transform", "translate(0," + height + ")")
          .call(make_x_gridlines()
              .tickSize(-height)
              .tickFormat("")
          );

        // add the Y gridlines
        svg.append("g")           
          .attr("class", "grid")
          .call(make_y_gridlines()
              .tickSize(-width)
              .tickFormat("")
          );

        // Add the valueline path.
        svg.append("path")
          .data([data])
          .attr("class", "line")
          .attr("d", valueline);

        svg.append("g")
            .attr("class", "centerline")
            .attr("transform", "translate(0," + y(0) + ")")
            .call(d3.axisTop(center)
                .ticks(0)
            );

        // Add the X Axis
        svg.append("g")
          .attr("transform", "translate(0," + height + ")")
          .call(d3.axisBottom(x));

        // Add the Y Axis
        svg.append("g")
          .call(d3.axisLeft(y));

        // text label for the x axis
        svg.append("text")             
          .attr("transform",
                "translate(" + (width/2) + " ," + 
                               (height + (margin.bottom - 5)) + ")")
          .style("text-anchor", "middle")
          .html("Sale Price (&pound;)");

          // text label for the y axis
        svg.append("text")
          .attr("transform", "rotate(-90)")
          .attr("y", 0 - margin.left)
          .attr("x",0 - (height / 2))
          .attr("dy", "1em")
          .style("text-anchor", "middle")
          .html("Profit (&pound;)");

    });

};

function loadData(product, event_id, pm, date) {
    $.ajax({
        type: "GET",
        url: "../getPotentialSale/"+product+"/"+event_id+"/"+pm+"/"+date+"/0",
        success: function(data) {
            //console.log(data);
            $("#potentialSale").html(data);
            $("#potentialSale").show();

            $('.dataTable').DataTable({
                "paging":   false,
                "searching":    false,
                "info":     false,
                "lengthChange":     false,
                "order": [[ 0, "asc" ]],
            });
        },
        error: function(data) {
            console.log(data);
        }
    });        
}

$(document).ready( function() {
    /**
    *   Suggests a sale price
    *   $product, $event, $pm, $date
    */
    $("#suggestSalePrice").click(function() {
        var product = $("#product").val();
        var event_id = $("#event").val();
        var pm = $("#payment_method").val();
        var date = $("#date").val();

        loadData(product, event_id, pm, date);
        drawGraph(product, event_id, pm, date);
    });

});