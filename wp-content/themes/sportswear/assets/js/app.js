jQuery(document).ready(function($){
    $(document).on("click", ".coupon-toggle-btn", () => {
        $(".cart-coupon").toggleClass("active");
        $("body").toggleClass("overflow-hidden");
      });
      
})