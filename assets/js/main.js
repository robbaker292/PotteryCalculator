$(document).ready(function() {
    $('.dataTable').DataTable({
    	"paging":   false,
        "searching": 	false,
        "info":     false,
        "lengthChange":     false,
        "order": [[ 1, "desc" ]],
        "columnDefs": [
    		{ "orderable": false, "targets": 0 }
  		]
    });

} );