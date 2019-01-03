jQuery(document).ready(function() {
    // This does the ajax request
//    jQuery( document ).on( 'click', '#SubmitForm', function() {
        jQuery("#PayhereSubmitForm").click(function(){ 
                var fName=jQuery("#fName").val(); 
		var lName= jQuery('#lName').val();
		var eMail= jQuery('#eMail').val() ;
		var phoneNo = jQuery('#phoneNo').val();
		var address = jQuery('#address').val();
//		var address = jQuery('form#payCusForms #address').val();                
                var classORid = jQuery('#classORid').val();
		var postID = jQuery('#pageid').val();  
                var ItemName = jQuery('#ItemName').val();    
		var CurrencyCode = jQuery('#CurrencyCode').val();                                
                var postAmount = jQuery('#'+ classORid).text();
                if(postAmount == ''){
                var postAmount = jQuery('#'+ classORid).html();//If incase above postAmount got null value
            }
                var postAmount = postAmount.replace(CurrencyCode,'');//Remove currency code
            
            
//    console.log(postAmount);                
//     console.log('postAmount '+postAmount);
//     console.log('postAmount1 '+postAmount1);

       
    jQuery.ajax({
	url : payhere.ajaxUrlPay,        
        type : 'POST',
        data: {
            action:'payhere_payment_submition',
            PayfirstName : fName,
            PaylastName : lName,
            PayeMail : eMail,
            PayphoneNo : phoneNo,
            Payaddress : address,
            PaypostID : postID,
            ItemName : ItemName,
            PayCurrencyCode : CurrencyCode,            
            PaypostAmount : postAmount
        },
        success:function(data) {
            // This outputs the result of the ajax request
            console.log(data);
        },
//		success : function( response ) {
//                    alert(response);
////			//jQuery('#love-count').html( response );
//		},
        error: function(errorThrown){
            console.log(errorThrown);
        }
//        ,
//        success: function( data ) {
//            alert( 'Your home page has ' + $(data).find('div').length + ' div elements.');
//        }
        
        
        
        
    });
});      
              
});