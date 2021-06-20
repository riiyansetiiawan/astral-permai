$(function() {

  var $container = $('.kontaks-row-view, .kontaks-col-view');

  // Initial setup
  $container
    .removeClass('kontaks-row-view kontaks-col-view')
    .addClass($('[name="kontaks-view"]').val());

  $('[name="kontaks-view"]').on('change', function() {
    $container
      .removeClass('kontaks-row-view kontaks-col-view')
      .addClass(this.value);
  });

  if ($('html').attr('dir') === 'rtl') {
    $('.kontaks-dropdown-menu').removeClass('dropdown-menu-right');
  }

});
