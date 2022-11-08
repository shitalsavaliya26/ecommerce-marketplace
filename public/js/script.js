
$(document).ready(function(){  
	$("#ic-number").inputmask({
		"mask": "999999-99-9999",
      placeholder: "XXXXXX-XX-XXXX"
    });
    $('.account-satting').click(function(){
        $('.shopping-cart-content').removeClass("cart-visible");
    });
    $('.cart-wrap').click(function(){
        $('.account-dropdown').css('display','none');
    });
    setTimeout(function(){
        $(".alert-success").slideUp(500);
        $("#app_massges").slideUp(500);
    }, 4000);

    $('#checklogin').click(function(){
         if($('#authuser').val() == 0){
            $("#registerModal").modal('show');
            return false;
         }else{
             return true;
         }
    });
});

function validateForm(id){
    var qty = $("#qty_" + id).val();
    if(qty && qty > 0){
        $("#form_"+ id ).submit();
        return ;
    }
    alert("Please enter valid quantity");
    return false;
}