/**
 * Admin JS — TechOrbit SEO Settings Panel
 */

jQuery(function ($) {
    'use strict';

    const vars = typeof techorbit_admin_vars !== 'undefined' ? techorbit_admin_vars : {};

    /* ---- TAB SWITCHING ---- */
    $('.tab-btn').on('click', function () {
        const tabId = $(this).data('tab');

        $('.tab-btn').removeClass('active').attr('aria-selected', 'false');
        $(this).addClass('active').attr('aria-selected', 'true');

        $('.tab-panel').removeClass('active');
        $('#panel-' + tabId).addClass('active');
    });

    /* ---- SHOW/HIDE API KEY ---- */
    $('.toggle-key-btn').on('click', function () {
        const targetId = $(this).data('target');
        const input = $('#' + targetId);
        if (input.length) {
            const isPass = input.attr('type') === 'password';
            input.attr('type', isPass ? 'text' : 'password');
            $(this).text(isPass ? '🙈' : '👁');
        }
    });

    /* ---- TEST API CONNECTION ---- */
    $('.test-api-btn').on('click', function () {
        const btn = $(this);
        const provider = btn.data('provider');
        const keyInput = provider === 'openai' ? $('#techorbit_openai_api_key') : $('#techorbit_gemini_api_key');
        const resultEl = $('#' + provider + '-test-result');
        const apiKey = keyInput.val().trim();

        if (!apiKey) {
            resultEl.text(vars.strings?.enter_key || 'Please enter an API key first.').removeClass('success error testing').addClass('error');
            return;
        }

        btn.prop('disabled', true);
        resultEl.text(vars.strings?.testing || 'Testing connection...').removeClass('success error').addClass('testing');

        $.post(vars.ajax_url, {
            action: 'techorbit_test_api',
            nonce: vars.nonce,
            provider: provider,
            api_key: apiKey,
        }, function (response) {
            if (response.success) {
                resultEl.text(vars.strings?.success || '✅ Connection successful!').removeClass('testing error').addClass('success');
            } else {
                const msg = response.data?.message || 'Connection failed.';
                resultEl.text((vars.strings?.fail || '❌ ') + msg).removeClass('testing success').addClass('error');
            }
        }).fail(function () {
            resultEl.text('❌ Request failed. Check network connection.').removeClass('testing success').addClass('error');
        }).always(function () {
            btn.prop('disabled', false);
        });
    });

    /* ---- LOGO MEDIA UPLOADER ---- */
    var mediaFrame;

    $('#upload-logo-btn').on('click', function (e) {
        e.preventDefault();

        if (mediaFrame) {
            mediaFrame.open();
            return;
        }

        mediaFrame = wp.media({
            title: 'Select Logo Image',
            button: { text: 'Use This Image' },
            multiple: false,
            library: { type: 'image' },
        });

        mediaFrame.on('select', function () {
            const attachment = mediaFrame.state().get('selection').first().toJSON();

            $('#techorbit_site_logo').val(attachment.id);
            $('#logo-preview')
                .attr('src', attachment.url)
                .css({ display: 'block', maxHeight: '60px', borderRadius: '6px', marginBottom: '12px' });

            if (!$('#remove-logo-btn').length) {
                $('#upload-logo-btn').after('<button type="button" id="remove-logo-btn" class="btn-remove">✕ Remove</button>');
                bindRemoveBtn();
            }
        });

        mediaFrame.open();
    });

    function bindRemoveBtn() {
        $(document).on('click', '#remove-logo-btn', function () {
            $('#techorbit_site_logo').val('');
            $('#logo-preview').hide().removeAttr('src');
            $(this).remove();
        });
    }

    bindRemoveBtn();

});
