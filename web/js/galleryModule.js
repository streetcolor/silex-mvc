var galleryModule = (function($) {

    var _apiClient = apiModule || {};

    /**
     * Get a gallery
     *
     * @return {[type]} [description]
     */
    var _loadGallery = function() {
        var _id = $(this).data('id');

        _apiClient.loadGallery(_id).done(function(response) {
            $('.MainPanelRight').html(response);
        });
    };

    /**
     * Load gallery edit form
     *
     * @return {[type]} [description]
     */
    var _loadEditForm = function() {
        var _id = $(this).data('id');
        var _previousView = $('.MainPanelRight').html();

        _apiClient.loadGalleryForm(_id).done(function(response) {
            $('.MainPanelRight').html(response);
            $('.edit-back-button').on('click', function() {
                $('.MainPanelRight').html(_previousView);
            });
            $('.editselect').select2({
                minimumResultsForSearch: -1
            });
            $('.toggle').toggles({on: $(this).data('toggle')});
        });
    };

    /**
     * Edit a gallery
     *
     * @return {[type]} [description]
     */
    var _editGallery = function() {
        var _form = $('.form-edit-gallery');
        var _id = _form.data('id');
        var _data = _form.serialize();

        _apiClient.editGallery(_id, _data).done(function(response) {
            console.debug(response);
            if (response.status == 'success') {
                // success
            }
            else {
                // error handling
            }
        });

        return false;
    };

    var init = function() {
        $('.do-load-gallery').click(_loadGallery);
        $('body').on('click', '.do-edit-gallery', _loadEditForm);
        $('body').on('click', '.do-submit-edit-gallery', _editGallery);
    };

    return {
        init: init
    };

})(jQuery);

$(function() {
    galleryModule.init();
});



function displaygalleryzz(){

$(".MainPanelLeft .MainPanelBottom .media-list li .media-body").click(function() {

    if($(this).parent().attr('class')==="unread"){

        $(".MainPanelLeft .MainPanelBottom .media-list li").attr('class','unread');
        $(this).parent().attr('class','read');
        fetchgallery();

        $('.scroll ul li').on('click',function() {
            MainPanelScroller();

        });

    }else{
    $( ".MainPanelLeft" ).removeClass( "hidden-xs" ).removeClass("hidden-sm").addClass( "col-sm-12" );
    $( ".MainPanelRight" ).removeClass( "col-sm-12" ).addClass( "hidden-xs" ).addClass( "hidden-sm" );
    $(".MainPanelLeft .MainPanelBottom .media-list li").attr('class','unread');
    $('.MainPanelRight').html('');
    }

});

}





function fetchgallzzzery(){
      $.ajax({
        type: "GET",
        dataType: 'html',
        url: "/gallery/getgallery",
        success : function(result, statut){

            $('.MainPanelRight').html(result);

            MainPanelScroller();
            $('#TitleEditGallery').hide();
            $(".MainPanelRight" ).removeClass( "hidden-xs hidden-sm" ).addClass( "col-xs-12" );
            $(".MainPanelLeft").removeClass( "col-xs-12" ).addClass( "hidden-xs hidden-sm" );


            // TableSorter
            $(".table-striped").tablesorter();
            $(".sorter-false").removeClass("tablesorter-header");
           /* $(".table thead tr th:first-child").attr("data-column","0");*/

                //fonction permettant de rechercher
            $('.tabsearch').keyup(function () {
                var rex = new RegExp($(this).val(), 'i');
                $('.searchable tr').hide();
                $('.searchable tr').filter(function () {
                    return rex.test($(this).text());
                }).show();
            })

            /*
            $('.tablesorter-header-inner input').click(function(){
                        if($(this).is(':checked')) {
                           // jQuery(this).parents('li').addClass('highlighted');
                           alert('check');
                        } else {
                            alert('no check');
                            //jQuery(this).parents('li').removeClass('highlighted');
                        }
                    });

            $('.table tbody tr input').click(function(){
                        if($(this).is(':checked')) {
                           jQuery(this).parents('td').parents('tr').addClass('highlighted');
                        } else {
                            jQuery(this).parents('td').parents('tr').removeClass('highlighted');
                        }
                   });
            */
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




function EditGallerie() {
    $.ajax({
    type: "GET",
    dataType: 'html',
    url: "/~SelvenJoseph/ArtsperBackOffice/web/index_dev.php/dashboard/editgallerie",
    async: false,
    success : function(result, statut){

        $("#MainPanelBottomRight").html(result);
        $('.scroll').hide();
        $('#TitleEditGallery').show();
        MainPanelScroller();
        $('.editselect').select2({
                    minimumResultsForSearch: -1
                });
       jQuery('.toggle').toggles({on: true});
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



function BackMainLeftMenu() {
    $(".MainPanelLeft .MainPanelBottom .media-list li").attr('class','unread');
    $( ".MainPanelLeft" ).removeClass( "hidden-xs" ).removeClass("hidden-sm").addClass( "col-sm-12" );
    $( ".MainPanelRight" ).removeClass( "col-sm-12" ).addClass( "hidden-xs" ).addClass( "hidden-sm" );
}

function MainPanelScroller(){
    HeightWindow = $(window).height();
    $('.MainPanelBottom').css('height',HeightWindow - $('.headerwrapper').height() - $('.MainPanelTop').height());
    $('.MainPanelBottomRightTableScroller').css('height',HeightWindow - $('.headerwrapper').height() - $('.MainPanelTop').height() - $('.active .TabContentMargin').outerHeight( true ));
    //if(HeightWindow < ($('.headerwrapper').height() + $(".MainPanelTop").height() + $('.tab-content').height() + 20)){
        //alert($('.headerwrapper').height() + $(".MainPanelTop").height() + $('.tab-content').height() + 20);
        //alert($('.active .TabContentMargin').outerHeight( true ));
        //$('.tab-content').css('height',HeightWindow - $(".MainPanelTop").height() + $('.tab-content').height() + 20)
  /*  }else{
        $('.MainPanelBottomRightTableScroller').css('height','auto');
    }*/
}

function MainTabScroller(){
    HeightWindow = $(window).height();
    $('.MainPanelBottomRightTableScroller').css('height',HeightWindow - $('.headerwrapper').height() - $('.MainPanelTop').height() - $('.active .TabContentMargin').outerHeight( true ));
}
/*
function MainRightPanelScroller(){

    heightRightPanel = $('.headerwrapper').height() + $('.MainRightPanelTop').height() + $('.scroll').height() + $('.MainRightPanelScroller').outerHeight(true);
    heightWindow = $(window).height();
    if(heightRightPanel > heightWindow){
        $('.MainRightPanelScroller').css('height',heightWindow - $('.headerwrapper').height() - $('.MainRightPanelTop').height() - $('.scroll').height());
    }else{
        $('.MainRightPanelScroller').css('height','auto');
    }

    $( window ).resize(function() {

    heightWindow = $(window).height();

    if(heightRightPanel > heightWindow){
        $('.MainRightPanelScroller').css('height',heightWindow - $('.headerwrapper').height() - $('.MainRightPanelTop').height() - $('.scroll').height());
    }else{
        $('.MainRightPanelScroller').css('height','auto');
    }

 });
}

function MainLeftPanelScroller(){

    hauteurliste = $('.MainLeftPanel').height()+$('.headerwrapper').height();
    hauteurFenetre = $(window).height();
    if(hauteurliste > hauteurFenetre){
        $('.MainLeftPanelScroller').css('height',hauteurFenetre - $(".testscroll").height() - $('.headerwrapper').height());
    }else{
        $('.MainLeftPanelScroller').css('height','auto');
    }

    $( window ).resize(function() {
        hauteurFenetre = $(window).height();

        if(hauteurliste > hauteurFenetre){
            $('.MainLeftPanelScroller').css('height',hauteurFenetre - $(".testscroll").height() - $('.headerwrapper').height());
        }else{
            $('.MainLeftPanelScroller').css('height','auto');
        }

 });
}

function MainRightPanelBottomScroller(){

    heightRightPanel = $('.headerwrapper').height() + $('.MainRightPanelTop').height() + $('.scroll').height() + $('.MainRightPanelScroller').outerHeight(true);
    heightWindow = $(window).height();
    if(heightRightPanel > heightWindow){
        $('.MainRightPanelScroller').css('height',heightWindow - $('.headerwrapper').height() - $('.MainRightPanelTop').height() - $('.scroll').height());
    }else{
        $('.MainRightPanelScroller').css('height','auto');
    }

    $( window ).resize(function() {

    heightWindow = $(window).height();

    if(heightRightPanel > heightWindow){
        $('.MainRightPanelScroller').css('height',heightWindow - $('.headerwrapper').height() - $('.MainRightPanelTop').height() - $('.scroll').height());
    }else{
        $('.MainRightPanelScroller').css('height','auto');
    }

 });
}*/
