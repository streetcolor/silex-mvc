var apiModule = (function($, Config) {

    var _baseUrl;

    /**
     * Get a gallery
     *
     * @param  {[type]} id [description]
     * @return {[type]}    [description]
     */
    var loadGallery = function(id) {
        var _serviceUrl = '/gallery/' + id;

        return $.get(
            _serviceUrl,
            {'restrict': false}
        );
    };

    /**
     * Load gallery edit form
     *
     * @param  {[type]} id [description]
     * @return {[type]}    [description]
     */
    var loadGalleryForm = function(id) {
        var _serviceUrl = '/gallery/' + id + '/edit';

        return $.get(_serviceUrl);
    };

    /**
     * Edit a gallery
     * Sends a PUT request to the API
     *
     * @param  {[type]} id   [description]
     * @param  {[type]} data [description]
     * @return {[type]}      [description]
     */
    var editGallery = function(id, data) {
        var _serviceUrl = _baseUrl + '/users/galleries/' + id;

        return $.ajax({
            type: 'PUT',
            url: _serviceUrl,
            data: data,
            crossDomain: true,
            headers: {
                "Content-Type": "application/json",
                "Authorization": "Basic " + btoa('artsper' + ":" + 'suih4igCd3mXP9r')
            }
        });
    };

    /**
     * Init
     *
     * @return {[type]} [description]
     */
    var init = function() {
        _baseUrl = Config.baseApiUrl;
    };

    return {
        init: init,
        loadGallery: loadGallery,
        loadGalleryForm: loadGalleryForm,
        editGallery: editGallery
    };

})(jQuery, Config);

$(function() {
    apiModule.init();
});
