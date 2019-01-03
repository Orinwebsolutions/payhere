  $( function() {
       var dialog;
      dialog = $( "#payhereCustomerdetails" ).dialog({
      autoOpen: false,
      height: 650,
      width: 500,
      modal: true
//      buttons: {
//        "Submit your payment": addUser,
//        Cancel: function() {
//          dialog.dialog( "close" );
//        }
//      },
//      close: function() {
//        form[ 0 ].reset();
//        allFields.removeClass( "ui-state-error" );
//      }
    });
    
//    $( "#opener" ).button().on( "click", function() {
        $( "#opener" ).on( "click", function() {
      dialog.dialog( "open" );
    });
    
    
    
    
//        form = dialog.find( "form" ).on( "submit", function( event ) {
//      event.preventDefault();
//      addUser();
//    });
    
//        function addUser() {
//            alert("test");
//        }
      
//    $( "#payhereCustomerdetails" ).dialog({
//      autoOpen: false,
//      show: {
//        effect: "blind",
//        duration: 1000
//      },
//      hide: {
//        effect: "explode",
//        duration: 1000
//      }
//    });
// 
//    $( "#opener" ).on( "click", function() {
//      $( "#payhereCustomerdetails" ).dialog( "open" );
//    });
  } );

