jQuery(function ($) {
  const btnOpenMedia = $(".btn-select__banner_link");
  const inputIMGSaveID = $('input[name="config_setting_shop_banner_link"]');
  btnOpenMedia.click(function () {
    frame = wp.media({
      title: "Select or Upload Media Of Your Chosen Persuasion",
      button: {
        text: "Use this media",
      },
      multiple: false,
    });
    // When an image is selected in the media frame...
    frame.on("select", function () {
      // Get media attachment details from the frame state
      var attachment = frame.state().get("selection").first().toJSON();
      $(
        '<img src="' +
          attachment.url +
          '" alt="" style="width: 300px; display: block;margin-bottom: 20px;"/>'
      ).insertBefore(btnOpenMedia);
      inputIMGSaveID.val(attachment.id);
      //     // Send the attachment id to our hidden input
      //     imgIdInput.val( attachment.id );
      return;
    });
    frame.open();
  });
  const filterContainer = $(".append-filter__data");
  const btnAddFilterData = $(".btn-add_filter_price_data");
  const filterLabel = $(".filter__label");
  const filterShortCODE = $(".filter__shortcode");
  const inputCheckedFilter = $(
    'input[name="config_setting_shop_enable_filter_price"]'
  );
  inputCheckedFilter.on("change", function (e) {
    e.preventDefault();
    if ($(this).prop("checked") === true) {
      filterContainer.removeClass("d-none");
      filterLabel.removeClass("d-none");
      filterShortCODE.removeClass("d-none");
    } else {
      if (!filterContainer.hasClass("d-none")) {
        filterContainer.addClass("d-none");
      }
      if (!filterLabel.hasClass("d-none")) {
        filterLabel.addClass("d-none");
      }
      if (!filterShortCODE.hasClass("d-none")) {
        filterShortCODE.addClass("d-none");
      }
    }
  });

  btnAddFilterData.on("click", function (e) {
    e.preventDefault();
    let key = Number(filterContainer.attr("data-key"));

    const appendContainer = filterContainer.find("tbody");
    const html = `<tr>
        <td>
        <label>MIN</label>
        <input type="number" name="config_setting_shop_filter_price_data[${key}][min]" value="">
        </td>
        <td>
        <label>MAX</label>
        <input type="number" name="config_setting_shop_filter_price_data[${key}][max]" value="">
        </td>
    </tr>`;
    appendContainer.append(html);
    filterContainer.attr("data-key", key + 1);
  });
  $(".btn-remove_data").on("click", function (e) {
    e.preventDefault();
    $(this).parent().parent().remove();
    let key = Number(filterContainer.attr("data-key"));
    filterContainer.attr("data-key", key - 1);
  });


  const enableShippingInput = $('input[name="config_setting_shop_enable_shipping"]');
  const contentShipping = $('.shipping_content')

  enableShippingInput.on("change", function (e) {
    e.preventDefault();
    if ($(this).prop("checked") === true) {
      contentShipping.removeClass("d-none");

    } else {
      if (!contentShipping.hasClass("d-none")) {
        contentShipping.addClass("d-none");
      }
    }
  });
  
  const enableExchangeInput = $('input[name="config_setting_shop_enable_exchange"]');
  const contentExchange = $('.exchange_content')

  enableExchangeInput.on("change", function (e) {
    e.preventDefault();
    if ($(this).prop("checked") === true) {
      contentExchange.removeClass("d-none");

    } else {
      if (!contentExchange.hasClass("d-none")) {
        contentExchange.addClass("d-none");
      }
    }
  });
});
