jQuery(document).ready(function ($) {
  $("[data-fancybox]").fancybox();
  $('[data-fancybox][type="videos"]').fancybox({
    href: this.href
  });
});
