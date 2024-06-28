jQuery(document).ready(function ($) {
  $(document).on("click", ".coupon-toggle-btn", () => {
    $(".cart-coupon").toggleClass("active");
    $("body").toggleClass("overflow-hidden");
  });

  const windowsWidth = $(window).width();
  const listiconFeature = $(".ss-type").find(".featured-box");
  if (windowsWidth <= 576) {
    const listHeight = [];
    console.log(listiconFeature)
    listiconFeature.each(function() {
        listHeight.push($(this).height())
    });
    const maxHeight = arrayMax (listHeight);

    listiconFeature.height(maxHeight)
  }
});

function arrayMax(arr) {
  var len = arr.length, max = -Infinity;
  while (len--) {
    if (arr[len] > max) {
      max = arr[len];
    }
  }
  return max;
};