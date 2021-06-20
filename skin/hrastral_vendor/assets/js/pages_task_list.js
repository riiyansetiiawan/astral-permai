$(function() {

  // Drag&Drop

  dragula(Array.prototype.slice.call(document.querySelectorAll('.tugas-list')), {
    moves: function (el, container, handle) {
      return handle.classList.contains('tugas-list-handle');
    }
  });

  // RTL

  if ($('html').attr('dir') === 'rtl') {
    $('.tugas-list-actions .dropdown-menu').removeClass('dropdown-menu-right');
  }

});
