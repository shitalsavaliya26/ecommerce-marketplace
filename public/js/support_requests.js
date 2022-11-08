// console.log(array_data["1"]);
$("#support_ticket").validate({
     rules: {
         subject: {
            required: true,    
        },
         username: {
            required: true,           
            // remote: {
            //     url: usernameExits,
            //     type: "post",
            //     data: {
            //         _token: $("input[name=_token]").val()
            //     },
            //     dataFilter: function(data) {
            //         var data = JSON.parse(data);
            //         if (data.valid != true) {
            //             return true;
            //         } else {
            //             return false;
            //         }
            //     }
            // }
         },
         message: {
            required: true,           
            maxlength:500
         },

     },
     messages:{
     	username:{
            remote: 'please enter username....',
            remote: 'Username is not available in our database',

     	},
        message: {
            required: 'Please enter reply desctiption..',
            
        }
    }
});
// console.log(array_data["1"]);
$("#reply_support_ticket").validate({
     rules: {
        
         message: {
            required: true,           
            maxlength:500
         },

     },
     messages:{
     	
        message: {
            required: 'Please enter reply desctiption..',
            
        }
    }
});
$('#reply_support_ticket').submit(function(e){
	if(!$(this).valid()){
		return false;
	}
	$('#reply_support_ticket').find("[type='submit']").attr('disabled','disabled');
	e.preventDefault();
	var formData = new FormData($(this)[0]);
	$.ajax({
		type: "POST",
		contentType: false, // The content type used when sending data to the server.
	    cache: false, // To unable request pages to be cached
	    processData: false, // To send DOMDocument or non processed data file it is set to false
		url:$(this).attr('action'),
		data:formData,
		success: function (data) {
			$('#reply_support_ticket').find("[type='submit']").removeAttr('disabled')
			$('#reply_support').modal('hide');
			// if(data.status =='success'){
			// 	$('.include-html').html(data.data);
			// 	var alertMsg = alerthtml(data.status,data.message);
			// }else{
			// 	var alertMsg = alerthtml(data.status,data.message);

			// }
			location.reload();
			$('#reply_support_ticket').find('input[name=subject]').val('')
			$('#reply_support_ticket').find('textarea[name=message]').text();
			$('#reply_support_ticket').find('textarea[name=message]').val();
			// $('.wrapper-content .row:eq(0)').before(alertMsg);
			// setTimeout(function(){
	  //           $('.alert').hide('100');
	  //       },4000);

		},
		error:function(){
			$('#reply_support_ticket').find("[type='submit']").removeAttr('disabled')
		}
  	});


});

var opFundWallet = function(th){
	var request_id = $(th).parent().find('input[name="withdraw_request_id"]').val();;
	var username = $(th).parent().find('input[name="username"]').val();
	var subject = $(th).parent().find('input[name="subject"]').val();
	var form_url = action_url //$('#reply_support_ticket').attr('action');
	form_url = form_url+'/'+request_id;
	$('#reply_support_ticket').attr('action',form_url);
 	$('#reply_support_ticket').find('span.username').text(username)
 	$('#reply_support_ticket').find('span.id').text(request_id)
 	$('#reply_support_ticket').find('input[name=request_id]').val(request_id)
 	$('#reply_support_ticket').find('input[name=subject]').val(subject)
	$('#reply_support').modal('show');

}
$('select[name="template"]').on('change',function(){
	
	var opt = $(this).val();
	if(array_data[opt]!=undefined){
		console.log(array_data[opt])
		$('#reply_support_ticket').find('textarea[name=message]').val(array_data[opt]);
		// $('#reply_support_ticket').find('textarea[name=message]').text(array_data[opt]);
	}
});


var showDetail = function(th){
	var request_id = $(th).parent().find('input[name="withdraw_request_id"]').val();
	var subject = $(th).parent().find('input[name="subject"]').val();
	var username = $(th).parent().find('input[name="username"]').val();
	var form_url = detail_url;
	form_url = form_url+'/'+request_id;
	$.get(form_url,function(response){
		$('#view_ticket').find('span.username').text(username);
		$('#view_ticket').find('span.id').text(request_id);
		$('#view_ticket').find('span.subject').text(subject);
		$('#view_ticket').find('.modal-body div').html(response.data);
		$('#view_ticket').modal('show');
	});

}
$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
var closeTicket = function(element){
	var slug = $(element).data('id');
	if(confirm('Are you sure want to close ticket ?')){
		$.ajax({
			type: "POST",
			url:close_ticket_url,
			data:{slug:slug},
			success: function (data) {
				console.log(data);
				// if(data.status =='success'){
				// 	var htm = $(data.data).find('.include-html').html();
				// 	$('.include-html').html(htm);
				// 	var alertMsg = alerthtml(data.status,data.message);
				// }else{
				// 	var alertMsg = alerthtml(data.status,data.message);

				// }
				location.reload();
				// $('.wrapper-content .row:eq(0)').before(alertMsg);
				// setTimeout(function(){
		  //           $('.alert').hide('100');
		  //       },4000);
			},
			error:function(){
				$('#reply_support_ticket').find("[type='submit']").removeAttr('disabled')
			}
	  	});
	}	
}