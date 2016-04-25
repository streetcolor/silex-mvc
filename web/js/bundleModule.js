var bundleModule = (function($) {

    var _apiClient = apiModule || {};

   
    /**
     * Bulk action button clicked
     *
     * @return {[type]} [description]
     */
    var _FooActionClick = function() {
      
        _apiClient
            .bulkGalleryAction(_action, _ids)
            .done(function(response) {
                if (response.status == 'success') {
                    $('.do-check-gallery:checked').closest('li').remove();
                }
            });

        return false;
    };

    /**
     * Init module
     *
     * @return {[type]} [description]
     */
    var init = function() {
   
    };

    return {
        init: init
    };

})(jQuery);

$(function() {
    bundleModule.init();
});
