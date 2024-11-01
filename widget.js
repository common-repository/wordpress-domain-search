(($) => {
  $(document).ready(() => {
    $.validator.addMethod(
      'nowhitespace',
      function (value, element) {
        return $.validator.prototype.optional(element) || /^\S+$/i.test(value);
      },
      'Invalid domain format.'
    );

    $('.wpdn_form').each((index, value) => {
      const id = $(value).data('id');

      let buy = $('#buy_' + id);
      let domain = $('#domain_' + id);
      let error = $('#error_' + id);
      let icon = $('#icon_' + id);
      let registrar = $(value).data('registrar');
      let search = $('#search_' + id);

      domain.on('keyup', () => {
        buy.hide();
        domain.removeClass('wpdn-muted').removeClass('wpdn-error').removeClass('wpdn-success');
        error.html('').css('display', 'none');
        icon.html('<span class="wpdn-icon-search"></span>');
        search.show();
      });

      $(value).validate({
        errorClass: 'invalid-feedback mb-0',
        errorPlacement: function (error, element) {
          error.appendTo(element.parent());
        },
        highlight: function (element, errorClass) {
          /* overrides default behavior */
        },
        invalidHandler: function (form, validator) {
          if (!validator.numberOfInvalids()) return;
        },
        messages: {
          domain: {
            required: 'Required',
            minlength: '3 character minimum',
            maxlength: '253 character maximum',
          },
        },
        rules: {
          domain: {
            required: true,
            minlength: 3,
            maxlength: 253,
            nowhitespace: true,
          },
        },
        submitHandler: (form) => {
          buy.hide();
          domain.addClass('wpdn-muted');
          error.html('').css('display', 'none');
          icon.html('<span class="wpdn-icon-spinner"></span>');
          search.show();

          $.get(`http://wpdn.nerdwarehouse.com/check.php?domain=${domain.val()}`, (response) => {
            domain.removeClass('wpdn-muted');

            if (response.code) {
              icon.html('<span class="wpdn-icon-remove wpdn-error"></span>');
              domain.addClass('wpdn-error');
              error.html(response.message).css('display', 'inline-block');
            }

            if (response.available === false) {
              icon.html('<span class="wpdn-icon-remove wpdn-error"></span>');
              domain.addClass('wpdn-error');
            }

            if (response.available === true) {
              buy.attr(
                'href',
                `http://wpdn.nerdwarehouse.com/purchase.php?registrar=${registrar}&domain=${domain.val()}`
              );
              buy.show();
              domain.addClass('wpdn-success');
              icon.html('<span class="wpdn-icon-check wpdn-success"></span>');
              search.hide();
            }
          });
        },
      });
    });
  });
})(jQuery);
