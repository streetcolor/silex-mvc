var galleryModule = (function($) {

    var _apiClient = apiModule || {};

    /**
     * Load a gallery, when we click on a
     * checkbox
     *
     * @return {[type]} [description]
     */
    var _loadGalleryProfil = function() {
        var _id = $(this).data('id');

        $('.gallery-list-item.active').removeClass('active');

        $(this).addClass('active');

        _apiClient
            .loadTemplate('gallery_single', {'id':_id})
            .done(function(response) {
                $('.MainPanelRight').html(response);
            });
    };

    /**
     * Load gallery add form
     *
     * @return {[type]} [description]
     */
    var _loadAddForm = function() {
        $('.gallery-list-item.active').removeClass('active');

        _apiClient.loadTemplate('gallery_add_form').done(function(response) {
            $('.MainPanelRight').html(response);
            _renderFormComponents();
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

        _apiClient
            .loadTemplate('gallery_edit_form', {'id': _id})
            .done(function(response) {
                $('.MainPanelRight').html(response);
                $('.edit-back-button').on('click', function() {
                    $('.MainPanelRight').html(_previousView);
                });

                _renderFormComponents();
            });
    };

    /**
     * Append gallery to the gallery list
     * (typically after gallery insertion)
     *
     * @param {[type]}   gallery  [description]
     * @param {Function} callback [description]
     */
    var _addGalleryToList = function(gallery, callback) {
        var _list = $('ul.gallery-list');
        var _clone = _list.find('li:first-child').clone();

        _clone.find('input[type="checkbox"]')
            .attr('id', 'checkbox_' + gallery.id_gallery)
        ;

        _clone.attr('data-id', gallery.id_gallery);

        _clone.find('label').attr('for', 'checkbox_' + gallery.id_gallery);

        _clone.find('span').html(gallery.gallery_name);

        _clone.prependTo(_list);

        if (typeof callback == 'function') {
            callback(_clone);
        }
    };

    /**
     * Edit a gallery
     *
     * @return {[type]} [description]
     */
    var _editGallery = function() {
        var _form = $('.form-edit-gallery');
        var _id = _form.data('id');
        var _data = _form.serializeJSON();
        var _editButton = $(this);

        _editButton.attr('disabled', true);

        _apiClient.editGallery(_id, _data).done(function(response) {
            if (response.status == 'success') {
                // success, reload homepage for the current gallery being edited
                _loadGalleryProfil.apply($('.gallery-list-item.active'));
            }
            else if (response.status == 'error') {
                // error handling
                _renderFormErrors(_form, response.result);
            }

            _editButton.attr('disabled', false);
        });

        return false;
    };

    /**
     * Add a gallery
     *
     * @return {[type]} [description]
     */
    var _addGallery = function() {
        var _form = $('.form-add-gallery');
        var _data = _form.serializeJSON();
        var _submitButton = $(this);

        _submitButton.attr('disabled', true);

        _apiClient.addGallery(_data).done(function(response) {
            if (response.status == 'success') {
                // success, add the new gallery to the list and load it
                _addGalleryToList(response.result, function(li) {
                    li.trigger('click');
                });
            }
            else if (response.status == 'error') {
                // error handling
                _renderFormErrors(_form, response.result);
            }

            _submitButton.attr('disabled', false);
        });

        return false;
    };

    /**
     * Remove gallery address
     *
     * @return {[type]} [description]
     */
    var _deleteGalleryAddress = function() {
        var _confirmed = confirm('Delete address ?');
        var _address = $(this).closest('.address-block');

        if (_confirmed) {
            var _id_address = $(this).data('id');
            var _id_gallery = $(this).closest('form').data('id');

            if (_id_address == undefined) {
                // no id_address which means the user
                // clicked on the "add address" button but didn't
                // save it to the database
                _address.remove();
                return ;
            }

            _apiClient
                .deleteGalleryAddress(_id_gallery, _id_address)
                .done(function(response) {
                    if (response.status == 'success') {
                        _address.remove();
                    }
                });
        }
    };

    /**
     * Render form errors
     *
     * @param  {[type]} form
     * @param  {[type]} errors
     * @return {[type]}
     */
    var _renderFormErrors = function(form, errors) {
        form.find('p.form-error-message').remove();

        for (key in errors) {
            var _parts = key.split('.');

            if (_parts.length == 2) {
                // If the error key is like headquarter_address.address_city
                // we detect that the input name has array notation
                var _input = $('input[name="'+_parts[0]+'['+_parts[1]+']"]');
                var _txtarea = $('textarea[name="'+_parts[0]+'['+_parts[1]+']"]');
            }
            else {
                var _input = $('input[name="'+key+'"]');
                var _txtarea = $('textarea[name="'+key+'"]');
            }

            if (_input.length) {
                $('<p/>').attr({
                    'class': 'form-error-message'
                }).html(errors[key]).insertAfter(_input);
            }
            else if (_txtarea.length) {
                $('<p/>').attr({
                    'class': 'form-error-message'
                }).html(errors[key]).insertAfter(_txtarea);
            }
        }
    };

    /**
     * Render toggle + selects
     *
     * @return {[type]} [description]
     */
    var _renderFormComponents = function() {
        $('select.editselect').select2();

        $('.toggle').toggles({on: $(this).data('toggle')});
    };

    /**
     * When a toggle is performed, update the
     * corresponding hidden input
     *
     * @param  {[type]} e      [description]
     * @param  {[type]} active [description]
     * @return {[type]}        [description]
     */
    var _updateInputOnToggle = function(e, active) {
        var _target = $(e.currentTarget);

        if (active) {
            _target.parent().find('input[type="hidden"]').val('1');
        }
        else {
            _target.parent().find('input[type="hidden"]').val('0');
        }
    };

    /**
     * Prepare cropping area for gallery's profile picture
     *
     * @return {[type]} [description]
     */
    var _prepareForCrop = function() {
        var _editor = $(this).parents(".image-editor").eq(0);
        var _input = $(this).parents(".upload").eq(0).find('.cropit-image-input');

        _editor.cropit({
            'onImageLoading': function(e) {
                _editor.find('.submit-crop').removeClass('hidden');
            },
            'exportZoom': 1
        });

        _editor.cropit('reenable');
        _input.click();
    };

    /**
     * Save gallery profile picture
     *
     * @return {[type]} [description]
     */
    var _saveGalleryImage = function() {
        var _editor = $('.upload .image-editor');
        var _loader = $('.upload .loaderContainer');
        var _camera = $('div[data-element="picture"]').find(".camera");
        var _submitCrop = $(this).parents(".submit-crop").eq(0);

        _submitCrop.addClass('hidden');
        _loader.fadeIn();
        _camera.stop().animate({ opacity: 0 },"fast");

        var _id = $('.gallery-list-item.active').data('id');
        var _data = {
            'gallery_image_small': JSON.stringify(_editor.cropit('export'))
        };

        _data = JSON.stringify(_data);

        _apiClient.editGallery(_id, _data).done(function(response) {
            if (response.status == 'error') {
                $('p.error-image-upload').remove();
                $('<p/>')
                    .attr({
                        'class': 'error-image-upload form-error-message'
                    })
                    .html('Error while validating the gallery')
                    .appendTo(_editor);
            }
            _camera.stop().animate({ opacity: 1 }, 'fast');
        });
    };

    /**
     * Load add address template
     */
    var _addAddressClick = function() {
        var _form = $(this).closest('form');
        var _addresses = $('.address-block');
        var _index = _addresses.length;

        _apiClient
            .loadTemplate('gallery_add_address_form')
            .done(function(response) {
                var _container = $('<div/>').html(response);
                var _address = $.extend(true, {}, _container);

                _address.find('input, select').each(function(i) {
                    var _replaced = $(this).attr('name').replace('[0]', '['+_index+']');
                    $(this).attr('name', _replaced);
                    $(this).val('');
                });

                _address.insertAfter(_form.find('.addresses > h4'));
                _renderFormComponents();
            });
    };

    /**
     * Checkbox within a .gallery-list-item
     * has been checked
     *
     * @param  {[type]} e
     * @return
     */
    var _galleryListCheckboxClick = function(e) {
        // e.stopPropagation();
        var _checkbox = $(this).find('input[type="checkbox"]');
        var _checkOrNot = _checkbox.is(':checked') ? false : true;
        var _checkedStatus = [];
        var _actions = [];

        _checkbox.prop('checked', _checkOrNot);

        var _checkboxes = $('.do-check-gallery:checked');

        _checkboxes.each(function() {
            var _gallery = $(this).closest('.gallery-list-item');

            _checkedStatus.push(_gallery.data('status'));
        });

        $.unique(_checkedStatus);

        // We can only have 1 bulk action type
        // per gallery_status. That is to say, an archived gallery (status3)
        // can't be inactivated (status4)
        if (_checkedStatus.length == 1) {
            switch (_checkedStatus[0]) {
                case 'status2':
                    _actions.push('archive');
                    _actions.push('inactivate');
                    break;
                case 'status3':
                    _actions.push('activate');
                    break;
                case 'status4':
                    _actions.push('archive');
                    _actions.push('activate');
                    break;
                default:
                    break;
            }
        }
        else {
            $('.do-bulk-action').prop('disabled', true);
            return ;
        }

        for (var i = 0; i < _actions.length; i++) {
            var _actionButton = $('.do-bulk-action[data-action="'+_actions[i]+'"]');

            if (_actionButton.length) {
                _actionButton.prop('disabled', false);
            }
        }

        // /!\ We MUST return false here
        // to prevent the click being propagated
        // towards the <li>
        return false;
    };

    /**
     * Advanced search submit
     *
     * @param  {[type]} e
     * @return
     */
    var _advancedSearchSubmit = function(e) {
        var _form = $(this);
        var _submitBtn = _form.find('button[type="submit"]');
        var _queryString = window.location.search.substring(1);
        var _data = _form.serialize() + '&' + _queryString;

        _submitBtn.prop('disabled', true);

        _apiClient
            .loadTemplate('gallery_list', {'queryString': _data})
            .done(function(response) {
                var _oldList = $('ul.gallery-list');
                var _newList = $(response);
                var _parent = _oldList.parent();

                _oldList.remove();
                _newList.appendTo(_parent);
                _submitBtn.prop('disabled', false);

                // get back to the list
                $('#advanced-search').collapse('hide');
            });

        return false;
    };

    /**
     * Used to filter the list of galleries
     *
     * @return
     */
    var _filterGalleries = function() {
        var _query = $(this).val();

        if (_query.length > 3) {
            var _items = $('.gallery-list-item');

            _items.each(function() {
                var _attributes = $(this).data();
                var _match = false;

                for (var i in _attributes) {
                    if (String(_attributes[i]).indexOf(_query) !== -1) {
                        _match = true;
                        break;
                    }
                }

                if (!_match) {
                    $(this).removeClass('hidden').addClass('hidden');
                }
                else {
                    $(this).removeClass('hidden');
                }
            });
        }
        else {
            $('.gallery-list-item.hidden').removeClass('hidden');
        }
    };

    /**
     * Bulk action button clicked
     *
     * @return {[type]} [description]
     */
    var _bulkActionClick = function() {
        var _action = $(this).data('action');
        var _ids = [];

        $('.do-check-gallery:checked').each(function() {
            var _id = $(this).closest('li').data('id');

            _ids.push(_id);
        });

        _ids = JSON.stringify({'ids': _ids});

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
        $('.do-load-addGallery-form').click(_loadAddForm);
        // delegated bindings
        $('body').on('click', '.ckbox-primary', _galleryListCheckboxClick);
        $('body').on('click', '.upload .camera', _prepareForCrop);
        $('body').on('click', '.cropit-submit', _saveGalleryImage);
        $('body').on('click', '.do-load-gallery', _loadGalleryProfil);
        $('body').on('click', '.do-edit-gallery', _loadEditForm);
        $('body').on('click', '.do-delete-address', _deleteGalleryAddress);
        $('body').on('click', '.do-submit-edit-gallery', _editGallery);
        $('body').on('click', '.do-submit-add-gallery', _addGallery);
        $('body').on('click', '.do-add-address-form', _addAddressClick);
        $('body').on('toggle', '.form-edit-gallery .toggle', _updateInputOnToggle);
        $('body').on('toggle', '.form-add-gallery .toggle', _updateInputOnToggle);
        $('body').on('submit', '.advanced-search-form', _advancedSearchSubmit);
        $('body').on('keyup', '.do-filter-galleries', _filterGalleries);
        $('body').on('click', '.do-bulk-action', _bulkActionClick);
        _renderFormComponents();
    };

    return {
        init: init
    };

})(jQuery);

$(function() {
    galleryModule.init();
});

/*
 *
 * The following functions must be moved
 * into a single "App" module.
 *
 */

function BackMainLeftMenu() {
    $(".MainPanelLeft .MainPanelBottom .media-list li").attr('class','unread');
    $( ".MainPanelLeft" ).removeClass( "hidden-xs" ).removeClass("hidden-sm").addClass( "col-sm-12" );
    $( ".MainPanelRight" ).removeClass( "col-sm-12" ).addClass( "hidden-xs" ).addClass( "hidden-sm" );
}

function MainPanelScroller(){
    HeightWindow = $(window).height();
    $('.MainPanelBottom').css('height',HeightWindow - $('.headerwrapper').height() - $('.MainPanelTop').height());
    $('.MainPanelBottomRightTableScroller').css('height',HeightWindow - $('.headerwrapper').height() - $('.MainPanelTop').height() - $('.active .TabContentMargin').outerHeight( true ));
}

function MainTabScroller(){
    HeightWindow = $(window).height();
    $('.MainPanelBottomRightTableScroller').css('height',HeightWindow - $('.headerwrapper').height() - $('.MainPanelTop').height() - $('.active .TabContentMargin').outerHeight( true ));
}
