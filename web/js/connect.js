$('body').addClass('bodyblue');
function ChangeConnect() {
    $.ajax({
    type: "GET",
    dataType: 'html',
    url: "/~SelvenJoseph/ArtsperBackOffice/web/index_dev.php/connect/pageconnection",
    async: false, 
    success : function(result, statut){ 

     $('#content_connect').html(result); 
     $('.panel-footer a').html('Sign in ');

    }, error : function(xhr, textStatus, errorThrown) {
                        if (xhr.status === 0) {
                        alert('Pas connecté.\n Verifier votre connexion Internet.');
                        } else if (xhr.status == 404) {
                        alert('Requested page not found. [404]');
                                    } else if (xhr.status == 500) {
                                     alert('Server Error [500].');
                                    } else if (errorThrown === 'parsererror') {
                                     alert('Requested JSON parse failed.');
                                    } else if (errorThrown === 'timeout') {
                                     alert('Time out error.');
                                    } else if (errorThrown === 'abort') {
                                     alert('Ajax request aborted.');
                                    } else {
                                     alert('There was some error. Try again.');
                                    }
            }

       });

    }

function ChangeForgetPassword() {
    $.ajax({
    type: "GET",
    dataType: 'html',
    url: "/~SelvenJoseph/ArtsperBackOffice/web/index_dev.php/connect/pageforgetpassword",
    async: false, 
    success : function(result, statut){ 
    
     $('#content_connect').html(result); 
     $('.panel-footer a').html('Reset Password');

    }, error : function(xhr, textStatus, errorThrown) {
                        if (xhr.status === 0) {
                        alert('Pas connecté.\n Verifier votre connexion Internet.');
                        } else if (xhr.status == 404) {
                        alert('Requested page not found. [404]');
                                    } else if (xhr.status == 500) {
                                     alert('Server Error [500].');
                                    } else if (errorThrown === 'parsererror') {
                                     alert('Requested JSON parse failed.');
                                    } else if (errorThrown === 'timeout') {
                                     alert('Time out error.');
                                    } else if (errorThrown === 'abort') {
                                     alert('Ajax request aborted.');
                                    } else {
                                     alert('There was some error. Try again.');
                                    }
            }

       });

}