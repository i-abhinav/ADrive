// Menu Toggle Script
$(document).ready(function () {
// Toggle the side navigation
  $("#sidebarToggle").on('click',function(e) {
    e.preventDefault();
    $("body").toggleClass("sidebar-toggled");
    $(".sidebar").toggleClass("toggled");
  });

  // Prevent the content wrapper from scrolling when the fixed side navigation hovered over
  $('body.fixed-nav .sidebar').on('mousewheel DOMMouseScroll wheel', function(e) {
    if ($(window).width() > 768) {
      var e0 = e.originalEvent,
        delta = e0.wheelDelta || -e0.detail;
      this.scrollTop += (delta < 0 ? 1 : -1) * 30;
      e.preventDefault();
    }
  });

  // Scroll to top button appear
  $(document).on('scroll',function() {
    var scrollDistance = $(this).scrollTop();
    if (scrollDistance > 100) {
      $('.scroll-to-top').fadeIn();
    } else {
      $('.scroll-to-top').fadeOut();
    }
  });

  // Smooth scrolling using jQuery easing
  $(document).on('click', 'a.scroll-to-top', function(event) {
    var $anchor = $(this);
    $('html, body').stop().animate({
      scrollTop: ($($anchor.attr('href')).offset().top)
    }, 1000, 'easeInOutExpo');
    event.preventDefault();
  });

          $('[data-toggle="tooltip"]').tooltip();

    /*============= For confirmation to Delete===================*/
	$('.delete-confirm').on('click', function(evt) {
		evt.preventDefault();
		var text = $(this).data('text'),
		delModal = $('#delete-confirm');
		if(delModal.find('.prepend-text').length === 0 && text!=undefined) {
			delModal.find('h4').prepend("<h4 class='prepend-text'>" + text  + "</h4>");
		}
		delModal.modal().find('a.confirm').attr('href', $(this).attr('href'));
    });
    
});