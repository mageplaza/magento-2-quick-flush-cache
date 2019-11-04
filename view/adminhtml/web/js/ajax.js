/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Mageplaza.com license that is
 * available through the world-wide-web at this URL:
 * https://www.mageplaza.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Mageplaza
 * @package     Mageplaza_QuickFlushCache
 * @copyright   Copyright (c) Mageplaza (https://www.mageplaza.com/)
 * @license     https://www.mageplaza.com/LICENSE.txt
 */

define([
    'jquery',
    'uiRegistry'
], function ($, registry) {
    'use strict';

    $.widget('mageplaza.qfcAjax', {
        options: {
            flushCacheUrl: {},
            flushCacheIndexUrl: {},
            reindexUrl: {},
            reindexListUrl: {},
        },

        /**
         * @inheritDoc
         */
        _create: function () {
            var el   = this,
                body = $('body');

            body.on('click', '#mp-qfc-flush-cache', function () {
                el.quickFlushCacheAndReindex(el.options.flushCacheUrl, 'cache');
            });
            body.on('click', '#mp-qfc-reindex', function () {
                el.quickFlushCacheAndReindex(el.options.reindexUrl, 'reindex');
            });
        },

        /** Ajax quick flush cache & reindex */
        quickFlushCacheAndReindex: function (url, type) {
            var el = this,
                target;

            if (type === 'reindex') {
                $('.notices-wrapper .mpQFC-image-loader').show();
            }
            $.ajax({
                type: "POST",
                url: url,
                data: {form_key: FORM_KEY},
                success: function (response) {
                    if (response.ajaxRedirect) {
                        window.location.href = response.ajaxRedirect;
                    }
                    if (response.status) {
                        target = el.updateGrid();
                        target.on('reloaded', function () {
                            $('.page-content .messages').remove();
                            $(response.message).insertBefore($('.page-columns'));
                            if (type === 'reindex') {
                                $('.notices-wrapper .mpQFC-image-loader').hide();
                            }
                        });
                        if (type === 'reindex' && typeof gridIndexerJsObject !== 'undefined') {
                            gridIndexerJsObject.useAjax = true;
                            gridIndexerJsObject.url = el.options.reindexListUrl;
                            gridIndexerJsObject.reload();
                        }
                        if (type === 'cache' && typeof cache_gridJsObject !== 'undefined') {
                            cache_gridJsObject.useAjax = true;
                            cache_gridJsObject.url = el.options.flushCacheIndexUrl;
                            cache_gridJsObject.reload();
                        }
                    }
                },
                error: function (e) {
                    $(el.errorMessageHtml(e.responseText)).insertBefore($('.page-columns'));
                }
            });
        },

        /** Get error message in html */
        errorMessageHtml: function (messageText) {
            return '<div class="messages">' +
                '<div class="message message-error error">' +
                '<div data-ui-id="magento-framework-view-element-messages-0-message-error">' +
                messageText +
                '</div>' +
                '</div>' +
                '</div>';
        },

        /** Update ui system message */
        updateGrid: function () {
            var target = registry.get('notification_area.notification_area_data_source');

            if (target && typeof target === 'object') {
                target.reload({refresh: 1});
            }

            return target;
        }
    });

    return $.mageplaza.qfcAjax;
});