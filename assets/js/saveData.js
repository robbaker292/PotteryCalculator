$(document).ready( function() {

	/**
	*	Saves the current item in the DB
	*/
    function submitForm(urlAddress) {
		var basicForm = $("#basicForm").serialize();
		$.ajax({
            type: "POST",
            url: urlAddress,
            data: basicForm,
            dataType: "json",
            success: function(data) {
                var id = data.insert_id;
                //console.log("../../view/"+id);
                //window.location.href = "../listAll";
                window.location.href = "../view/"+id;
            	//location.reload();
            },
            error: function(data) {
                console.log(data);
                $("#saveResult").text(data);
            }
        });
	};

    /**
    *   Validates the form
    */
    $("#basicForm").validate({
        rules: {
            name: "required"
        },
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'div',
        errorClass: 'help-block error-block',
        errorPlacement: function(error, element) {
            if(element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    });

    /**
    *   Adds another resource option
    */
    $("#resourceAdder").click(function() {
        $.ajax({
            type: "POST",
            url: "../createResourceDropdowns",
            success: function(data) {
                //console.log(data);
                $("#resourceChoosers").append(data);
                var clone = $(".resourceOptions").last();
                clone.find('.bootstrap-select').remove();
                clone.find('select').selectpicker();
                console.log(clone);
            }
        });
    });

    /**
    *  Saves the resource data
    */
    $("#saveResources").click(function() {
        var id = $("#id").val();
        var basicForm = $("#resourceForm").serialize();
        //console.log(basicForm);
        $.ajax({
            type: "POST",
            url: "../doUpdateResources/"+id,
            data: basicForm,
            success: function(data) {
                //console.log(data);
                location.reload();
            },
            error: function(data) {
                console.log(data);
                $("#saveResultResources").text(data);
            }
        });

    });

    /**
    *   Validates the form on user click
    */
    $("#saveBasic").click(function() {
        var result = $("#basicForm").valid();
        if(result) {
            submitForm("../doUpdate");
        }
    });

    /**
    *   Validates the VAT form on user click
    */
    $("#saveVAT").click(function() {
        var result = $("#basicForm").valid();
        if(result) {
            submitForm("../doUpdateVAT");
        }
    });

    /**
    *   Validates the PM form on user click
    */
    $("#savePM").click(function() {
        var result = $("#basicForm").valid();
        if(result) {
            submitForm("../doUpdatePM");
        }
    });

    /**
    *   Validates the form on user click
    */
    $("#saveProduct").click(function() {
        var result = $("#basicForm").valid();
        if(result) {
            var basicForm = $("#basicForm").serialize();
            $.ajax({
                type: "POST",
                url: "../doUpdate",
                data: basicForm,
                dataType: "json",
                success: function(data) {
                    var id = data.insert_id;
                    //console.log(data,data.insert_id);
                    //var id = $("#id").val();
                    basicForm = $("#resourceForm").serialize();
                    //console.log(basicForm);
                    $.ajax({
                        type: "POST",
                        url: "../doUpdateResources/"+id,
                        data: basicForm,
                        success: function(data) {
                            //console.log(data);
                            //location.reload();
                            window.location.href = "../view/"+id;
                        },
                        error: function(data) {
                            console.log(data);
                            $("#saveResultResources").text(data);
                        }
                    });
                },
                error: function(data) {
                    console.log(data);
                    $("#saveResult").text(data);
                }
            });
        }
    });

});