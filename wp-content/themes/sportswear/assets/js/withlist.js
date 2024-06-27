jQuery(document).ready(function ($) {
  const btnActions = $("span.js-wishlist.btn-wishlist");
  const iconHeartWithList = "i.fas.fa-heart";
  const iconHeartNoWithList = "i.far.fa-heart";
  const listWithListShow = $(".wishlist-link span");

  loadWithListCount(listWithListShow);

  btnActions.click(function (e) {
    const productID = $(this).data("id");
    const thisBtn = $(this);
    e.preventDefault();
    $.ajax({
      url: flatsomeVars.ajaxurl,
      data: {
        action: "wishlist_product",
        id: Number(productID),
      },
      type: "post",
      success: function (response) {
        if (response.success && response.data) {
          const data = response.data;
          listWithListShow.text(data.length);
          for (const item of data) {
            if (item == productID) {
              thisBtn.find(iconHeartWithList).css("display", "block");
              thisBtn.find(iconHeartNoWithList).css("display", "none");
              return;
            }
          }
        }
        thisBtn.find(iconHeartWithList).css("display", "none");
        thisBtn.find(iconHeartNoWithList).css("display", "block");
      },
    });
  });
});

function loadWithListCount(listWithListShow) {
  jQuery.ajax({
    url: flatsomeVars.ajaxurl,
    data: {
      action: "wishlist_count",
    },
    success: function (response) {
      if (response.success && response.data) {
        const data = response.data;
        listWithListShow.text(data);
      }
    },
  });
}
