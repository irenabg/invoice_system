$(document).ready(function() {
    $("#formButton").click(function(){
        //alert('tuk');
        $("#hidden").toggle();
    });


    $(document).ready(function(){
        $('#datepicker').datepicker();
    });

    var i=1;
    $("#add_row").click(function(){
        $('#addr'+i).html("<td>"+ (i+1) +"</td><td><input name='option_value["+i+"][item]' type='text' placeholder='Item' class='form-control input-md'  /></td><td><input  name='option_value["+i+"][cost]' type='text' placeholder='Cost'  class='form-control input-md'></td><td><input  name='option_value["+i+"][quantity]"+i+"' type='text' placeholder='Quantity'  class='form-control input-md'></td><td><input  name='option_value["+i+"][total]' type='text' placeholder='Total'  class='form-control input-md'></td>");

        $('#tab_logic').append('<tr id="addr'+(i+1)+'"></tr>');
        i++;
    });
    $("#delete_row").click(function(){
        if(i>1){
            $("#addr"+(i-1)).html('');
            i--;
        }
    });

    $('#contact_form').bootstrapValidator({
        // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            client: {
                validators: {
                    stringLength: {
                        min: 1
                    },
                    notEmpty: {
                        message: 'Please select client'
                    }
                }
            },
            issuer: {
                validators: {
                    stringLength: {
                        min: 1
                    },
                    notEmpty: {
                        message: 'Please select issuer'
                    }
                }
            },
            currency: {
                validators: {

                    notEmpty: {
                        message: 'Please select currency'
                    }
                }
            },
            invoice_no: {
                validators: {
                    notEmpty: {
                        message: 'Please enter Invoice No'
                    }
                }
            },
            vat: {
                validators: {
                    stringLength: {
                        min: 1
                    },
                    notEmpty: {
                        message: 'Please enter VAT'
                    }
                }
            }

        }
    });

});