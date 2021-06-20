$(function() {

  // Drag&Drop

  dragula(Array.prototype.slice.call(document.querySelectorAll('.project-tugas-list')), {
    moves: function (el, container, handle) {
      return handle.classList.contains('project-tugas-handle');
    }
  });

  // RTL

  if ($('html').attr('dir') === 'rtl') {
    $('.project-tugas-actions .dropdown-menu, .project-priority .dropdown-menu').removeClass('dropdown-menu-right');
  }

});
