/**
 * Created by donserj on 2/26/15.
 */
$(document).ready(function(){

    $("#test").click(function(){
        alert('s');
    });



});

function calcAmount(el){
    //alert('s');
    //alert($(el).val());
    var amount = parseFloat($("#totalAmount").val());
    if($(el).is(":checked")) {
        amount += parseFloat($(el).val());
        //alert("checked");
    }else{
        amount -= parseFloat($(el).val());
        //alert("No checked");
    }
    $("#totalAmount").val(amount);
    $("#amount").empty();
    $("#amount").append(amount);
}

function checkVin(vin){
//alert(vin);
    $.ajax({
        type: "POST",
        url: "/php-scripts/checkInfoVinAjax.php",
        data: "vin=" + vin,
        beforeSend: function()
        {
            $("#check_vin").css("display", "block");
        },
        success: function(result)
        {
            $("#vin_result").empty();
            $("#vin_result").append(result);

        },
        complete: function()
        {
            $("#check_vin").css("display", "none");
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
            console.log(jqXHR.responseText);
            $("#vin_result").append("Ошибка!" + "EndError"+jqXHR.responseText);
        }
    });

}