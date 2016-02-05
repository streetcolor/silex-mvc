var apiModule = (function($, Config) {

    var _baseUrl;
    var _templateMap = {
        'gallery_single': '/gallery/{id}',
        'gallery_edit_form': '/gallery/{id}/edit',
        'gallery_add_form': '/gallery/add',
        'gallery_add_address_form': '/gallery/address/add',
        'gallery_list': '/gallery/list',
        'connect_forgot_password_form': '/connect/forgot-password',
        'connect_login_form': '/connect/login-form'
    };

    /**
     * Load a twig template
     *
     * @param  {[type]} name template name
     * @param  {[type]} opt  object that contains placeholders values
     * @return promise
     */
    var loadTemplate = function(name, opt) {
        if (_templateMap[name] !== undefined) {
            var _serviceUrl = _templateMap[name];
            var _matchs = _serviceUrl.match(/{([a-zA-Z])+}/gi);

            if (_matchs) {
                // replace placeholders with opt received as input
                for (var i = 0; i < _matchs.length; i++) {
                    var _parameter = _matchs[i].replace('{', '').replace('}', '');

                    if (opt.hasOwnProperty(_parameter)) {
                        _serviceUrl = _serviceUrl.replace(_matchs[i], opt[_parameter]);
                    }
                }
            }

            if (opt !== undefined
                && opt.hasOwnProperty('queryString')) {
                _serviceUrl += '?' + opt.queryString;
            }

            return $.get(_serviceUrl);
        }
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
            dataType: 'json',
            crossDomain: true,
            headers: {
                "Content-Type": "application/json",
                "Authorization": "Basic " + btoa('artsper' + ":" + 'suih4igCd3mXP9r')
            }
        });
    };

    /**
     * Add a gallery
     * Sends a POST request to the API
     *
     * @param  {[type]} data [description]
     * @return {[type]}      [description]
     */
    var addGallery = function(data) {
        var _serviceUrl = _baseUrl + '/users/galleries';

        return $.ajax({
            type: 'POST',
            url: _serviceUrl,
            data: data,
            dataType: 'json',
            crossDomain: true,
            headers: {
                "Content-Type": "application/json",
                "Authorization": "Basic " + btoa('artsper' + ":" + 'suih4igCd3mXP9r')
            }
        });
    };

    /**
     * Remove gallery address
     *
     * @param  {[type]} id_gallery
     * @param  {[type]} id_address
     * @return
     * @todo /!\ THIS MUST BE SECURED when the JWT will be in place /!\
     */
    var deleteGalleryAddress = function(id_gallery, id_address) {
        var _serviceUrl = _baseUrl
            + '/users/galleries/'
            + id_gallery
            + '/addresses/'
            + id_address;

        return $.ajax({
            type: 'DELETE',
            url: _serviceUrl,
            dataType: 'json',
            crossDomain: true,
            headers: {
                "Content-Type": "application/json",
                "Authorization": "Basic " + btoa('artsper' + ":" + 'suih4igCd3mXP9r')
            }
        });
    };

    /**
     * Bulk operations on galleries
     *
     * @param  string action (archive|activate|inactivate)
     * @param  JSON string data
     * @return promise
     */
    var bulkGalleryAction = function(action, data) {
        var _type = action == 'archive' ? 'DELETE' : 'POST';
        var _serviceUrl = _baseUrl
            + '/users/bulk/galleries'
            + (action !== 'archive' ? '/' + action : '');

        return $.ajax({
            type: _type,
            url: _serviceUrl,
            data: data,
            dataType: 'json',
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
        loadTemplate: loadTemplate,
        editGallery: editGallery,
        addGallery: addGallery,
        bulkGalleryAction: bulkGalleryAction,
        deleteGalleryAddress: deleteGalleryAddress
    };

})(jQuery, Config);

$(function() {
    apiModule.init();
});
