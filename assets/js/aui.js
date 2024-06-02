$(document).ready(function () {

	$('.mobile-toggle-nav').click(function () {
		$(this).toggleClass('is-active');
		$('.app-container').toggleClass('sidebar-mobile-open');
	});

	$('.mobile-toggle-header-nav').click(function () {
		$(this).toggleClass('active');
		$('.app-header__content').toggleClass('header-mobile-open');
	});

	$('.btn-open-options').click(function () {
		$('.ui-theme-settings').toggleClass('settings-open');
	});

	$('.close-sidebar-btn').click(function () {

		var classToSwitch = $(this).attr('data-class');
		var containerElement = '.app-container';
		$(containerElement).toggleClass(classToSwitch);

		var closeBtn = $(this);

		if (closeBtn.hasClass('is-active')) {
			closeBtn.removeClass('is-active');

		} else {
			closeBtn.addClass('is-active');
		}
	});


	$('.switch-container-class').on('click', function () {

		var classToSwitch = $(this).attr('data-class');
		var containerElement = '.app-container';
		$(containerElement).toggleClass(classToSwitch);

		$(this).parent().find('.switch-container-class').removeClass('active');
		$(this).addClass('active');
	});

	$('.switch-theme-class').on('click', function () {

		var classToSwitch = $(this).attr('data-class');
		var containerElement = '.app-container';

		if (classToSwitch == 'body-tabs-line') {
			$(containerElement).removeClass('body-tabs-shadow');
			$(containerElement).addClass(classToSwitch);
		}

		if (classToSwitch == 'body-tabs-shadow') {
			$(containerElement).removeClass('body-tabs-line');
			$(containerElement).addClass(classToSwitch);
		}

		$(this).parent().find('.switch-theme-class').removeClass('active');
		$(this).addClass('active');
	});

	if (localStorage.getItem('header_color_class')) {
		$(".app-header").addClass("header-shadow " + localStorage.getItem('header_color_class'));
	}

	$('.switch-header-cs-class').on('click', function () {
		var classToSwitch = $(this).attr('data-class');
		var containerElement = '.app-header';

		$('.switch-header-cs-class').removeClass('active');
		$(this).addClass('active');

		$(containerElement).attr('class', 'app-header');
		$(containerElement).addClass('header-shadow ' + classToSwitch);
		localStorage.setItem('header_color_class', 'header-shadow ' + classToSwitch);
	});

	if (localStorage.getItem('sidebar_color_class')) {
		$(".app-sidebar").addClass("sidebar-shadow " + localStorage.getItem('sidebar_color_class'));
	}

	$('.switch-sidebar-cs-class').on('click', function () {
		var classToSwitch = $(this).attr('data-class');
		var containerElement = '.app-sidebar';

		$('.switch-sidebar-cs-class').removeClass('active');
		$(this).addClass('active');

		$(containerElement).attr('class', 'app-sidebar');
		$(containerElement).addClass('sidebar-shadow ' + classToSwitch);
		localStorage.setItem('sidebar_color_class', 'sidebar-shadow ' + classToSwitch);
	});

	// Search wrapper trigger
	$('.search-icon').click(function () {
		$(this).parent().parent().addClass('active');
	});

	$('.search-wrapper .close').click(function () {
		$(this).parent().removeClass('active');
	});

	$('.show-toastr-example').click(function () {
		toastr.options = {
			"closeButton": true,
			"debug": false,
			"newestOnTop": true,
			"progressBar": true,
			"positionClass": "toast-top-center",
			"preventDuplicates": false,
			"onclick": null,
			"showDuration": "300",
			"hideDuration": "1000",
			"timeOut": "5000",
			"extendedTimeOut": "1000",
			"showEasing": "swing",
			"hideEasing": "linear",
			"showMethod": "fadeIn",
			"hideMethod": "fadeOut"
		};
		toastr["info"]("You don't have any new items in your calendar today!", "Example Toastr");
	});

	$(function () {
		$('[data-toggle="popover"]').popover();
	});

	$(function () {
		$('[data-toggle="tooltip"]').tooltip();
	});

	setTimeout(function () {
		$(".vertical-nav-menu").metisMenu();
	}, 100);

	setTimeout(function () {
		if ($(".scrollbar-container")[0]) {
			$('.scrollbar-container').each(function () {
				const ps = new PerfectScrollbar($(this)[0], {
					wheelSpeed: 2,
					wheelPropagation: false,
					minScrollbarLength: 20
				});
				$($(this)[0]).fadeIn(200);
				ps.update();
			});

			const ps = new PerfectScrollbar('.scrollbar-sidebar', {
				wheelSpeed: 2,
				wheelPropagation: false,
				minScrollbarLength: 20
			});

		}

	}, 1000);
});

