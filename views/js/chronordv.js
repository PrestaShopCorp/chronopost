
function toggleRDVpane(cust_address, codePostal, city, e)
{
    if($("input.delivery_option_radio:checked").val()==rdv_carrierID+"," || $("input[name=id_carrier]:checked").val()==rdv_carrierIntID) 
    {
        if(typeof e != "undefined") {
            e.stopPropagation();
        }

        var tellMeWhere=$("input.delivery_option_radio:checked").parent().parent().parent().parent().parent();
        if(!tellMeWhere.parent().hasClass('delivery_option')) {
            tellMeWhere=tellMeWhere.parent().parent();
        }

        $('#chronordv_container').insertAfter(tellMeWhere);
        
        $('#chronordv_container').show();
        return false;
    }

    // Hide controls
    $('#chronordv_container').hide();

};