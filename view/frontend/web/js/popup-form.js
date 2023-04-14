define(['jquery', 'Magento_Ui/js/modal/modal'], function ($, modal) {
    'use strict';
    $.widget('maisondunet.customWidgetPopupForm',{
        options:{
            PopupForms: '.popup-form-data-submit',
            popupLink : '.action-print'
        },
        _create: function () {
            this._super();
            let self = this;
            let popupOptions = {
                type: 'popup',
                responsive: true,
                innerScroll: true,
                modalClass: 'custom_popup_box'
            };
            modal(popupOptions, this.options.PopupForms);
            $(self.options.popupLink).on('click',function () {
                $(self.options.PopupForms).css({display: 'block'});
                $(self.options.PopupForms).modal('openModal');
            });
        }
    });
    return $.maisondunet.customWidgetPopupForm;

});
