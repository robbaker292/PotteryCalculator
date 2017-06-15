$(document).ready(function() {


    function barClicked(date) {
        console.log("hello", date);
        $.ajax({
          url: "./dashboard/getFromDate/"+date
        })
        .done(function( data ) {
            $("#eventsDrilldownOuter").html(data);
            $("#eventsDrilldownOuter").show();            
            console.log( "Sample of data:", data );

            $('.dataTable').DataTable({
                "paging":   false,
                "searching":    false,
                "info":     false,
                "lengthChange":     false,
                "order": [[ 1, "desc" ]],
                "columnDefs": [
                    { "orderable": false, "targets": 0 }
                ]
            });
        });
    }

    $("#eventsDrilldownOuter").hide();

    // set the dimensions and margins of the graph
    var margin = {top: 20, right: 20, bottom: 30, left: 40},
        width = 960 - margin.left - margin.right,
        height = 500 - margin.top - margin.bottom;

    // set the ranges
    var x = d3.scaleBand()
        .range([0, width])
        .padding(0.1);

    var y = d3.scaleLinear()
        .range([height, 0]);

    var center = d3.scaleLinear()
        .range([0, width]);

    var parseDate = d3.timeParse("%Y-%m-%d");
    var formatDate = d3.timeFormat("%Y-%m-%d");
    var formatMonth = d3.timeFormat("%B"),
    formatDay = d3.timeFormat("%e");
              
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
    d3.json("./dashboard/getData", function(error, data) {
        if (error) throw error;

        // format the data
        data.forEach(function(d) {
            d.date = parseDate(d.date);
            d.profit = +d.profit;
        });

        // Scale the range of the data in the domains
        x.domain(data.map(function(d) { return d.date; }));
        y.domain([d3.min(data, function(d) { return d.profit; }), d3.max(data, function(d) { return d.profit; })]);

        // append the rectangles for the bar chart
        svg.selectAll(".bar")
            .data(data)
            .enter().append("rect")
            .attr("class", function(d) {
                if(d.profit > 0) {
                    return "bar positive";
                } else {
                    return "bar negative"
                }
            })
            .attr("data-sale-date", function(d) {
                return formatDate(d.date);
            })
            .attr("x", function(d) { return x(d.date); })
            .attr("width", x.bandwidth())
            .attr("y", function(d) { return y(Math.max(0, d.profit)); })
            .attr("height", function(d) { return Math.abs(y(d.profit) - y(0)); })
            .on("click", function(d) {
                barClicked(formatDate(d.date));
                d3.event.stopPropagation();
            });


//.attr("y", function(d) { return y(d.profit); })
//.attr("height", function(d) { return height - y(d.profit); });

        // add the x Axis
        svg.append("g")
            .attr("transform", "translate(0," + height + ")")
            .call(
                d3.axisBottom()
                .scale(x)
                .tickFormat( function(d,i) {
                    if (d.getDate() == 1) {
                        return formatMonth(d);
                    } else {
                        return formatDay(d);
                    }
                })
            );

        svg.append("g")
            .attr("class", "centerline")
            .attr("transform", "translate(0," + y(0) + ")")
            .call(d3.axisTop(center)
                .ticks(0)
            );

        // add the y Axis
        svg.append("g")
            .call(d3.axisLeft(y));

    });

} );