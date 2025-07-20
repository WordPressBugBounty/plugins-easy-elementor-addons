(function ($, elementor) {
    'use strict';
    var EEA = {

        init: function () {

            var widgets = {
                'eead-accordion.default': EEA.accordionBlock,
                'eead-advanced-map.default': EEA.advancedMap,
                'eead-animated-heading.default': EEA.animatedHeading,
                'eead-business-hour.default': EEA.businessHours,
                'eead-circular-progressbar.default': EEA.circularProgressBar,
                'eead-countdown.default': EEA.countdown,
                'eead-counter.default': EEA.counterBlock,
                'eead-filterable-gallery.default': EEA.filterableGallery,
                'eead-horizontal-timeline.default': EEA.horizontalTimelineCarousel,
                'eead-hotspot.default': EEA.hotspotBlock,
                'eead-image-comparison.default': EEA.imageComparison,
                'eead-image-accordion.default': EEA.imageAccordion,
                'eead-image-gallery.default': EEA.imageGallery,
                'eead-pie-chart.default': EEA.pieChart,
                'eead-one-page-nav.default': EEA.onePageNav,
                'eead-lottie.default': EEA.Lottie,
                'eead-scroll-image.default': EEA.scrollImage,
                'eead-logo-carousel.default': EEA.logoCarousel,
                'eead-popup-modal.default': EEA.popupModal,
                'eead-progressbar.default': EEA.progressBar,
                'eead-toggle.default': EEA.toggleBlock,
                'eead-switcher.default': EEA.switcherBlock,
                'eead-popup-video.default': EEA.popupVideo,
                'eead-horizontal-tab.default': EEA.horizontalTabsBlock,
                'eead-vertical-tab.default': EEA.verticalTabsBlock,
                'eead-sticky-video.default': EEA.stickyVideo,
                'eead-video-player.default': EEA.videoPlayer,
                'eead-slider.default': EEA.sliderBlock,
                'eead-team-carousel.default': EEA.teamCarousel,
                'eead-testimonial-carousel.default': EEA.testimonialCarousel,
            };

            $.each(widgets, function (widget, callback) {
                elementor.hooks.addAction('frontend/element_ready/' + widget, callback);
            });
        },

        accordionBlock: function ($scope) {
            var accordion = $scope.find('.eead-each-accordion');

            if (accordion.length > 0) {
                accordion.find('.eead-accordion-title').each(function () {
                    var eachTitle = $(this);
                    // On Accordion Click
                    eachTitle.on('click', function () {
                        if (!$(this).parent('.eead-each-accordion').hasClass('eead-open')) {
                            $(this).next('.eead-accordion-content').slideDown();
                            $(this).parent('.eead-each-accordion').addClass('eead-open');
                        } else {
                            $(this).next('.eead-accordion-content').slideUp();
                            $(this).parent('.eead-each-accordion').removeClass('eead-open');
                        }
                    });
                });
            }
        },

        advancedMap: function ($scope) {
            new_map($scope.find('.eead-gmap-markers'));

            function new_map($el) {
                var zoom = $el.data('zoom');
                var scrollwheel = $el.data('scrollwheel') ? true : false;
                var zoomControl = $el.data('zoomcontrol') ? true : false;
                var fullscreenControl = $el.data('fullscreencontrol') ? true : false;
                var streetViewControl = $el.data('streetviewcontrol') ? true : false;
                var mapTypeControl = $el.data('maptypecontrol') ? true : false;
                var gestureHandling = $el.data('gesturehandling') ? $el.data('gesturehandling') : null;
                var $markers = $el.find('.eead-gmap-marker');
                var styles = $el.data('style');
                var mapOption = {
                    zoom: zoom,
                    scrollwheel: scrollwheel,
                    zoomControl: zoomControl,
                    fullscreenControl: fullscreenControl,
                    streetViewControl: streetViewControl,
                    mapTypeControl: mapTypeControl,
                    center: new google.maps.LatLng(0, 0),
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    styles: styles
                };

                if (typeof gestureHandling !== 'undefined' && gestureHandling === 'none') {
                    mapOption['gestureHandling'] = 'none';
                }

                // Generate map
                var map = new google.maps.Map($el[0], mapOption);

                // add a markers reference
                map.markers = [];

                // add markers
                $markers.each(function () {
                    add_marker($(this), map);
                });

                // center map
                center_map(map, zoom);

                return map;
            }

            function add_marker($marker, map) {
                var animate = $marker.attr('data-animate');
                var latlng = new google.maps.LatLng($marker.attr('data-lat'), $marker.attr('data-lng'));
                var icon_img = $marker.attr('data-icon');

                if (icon_img != '') {
                    var icon = {
                        url: $marker.attr('data-icon'),
                        scaledSize: new google.maps.Size($marker.attr('data-icon-size'), $marker.attr('data-icon-size'))
                    };
                }

                // create marker
                var marker = new google.maps.Marker({
                    position: latlng,
                    map: map,
                    icon: icon,
                    animation: google.maps.Animation.DROP,
                });

                if (animate == 'animate-yes' && $marker.data('info-window') != 'yes') {
                    marker.setAnimation(google.maps.Animation.BOUNCE);
                }

                if (animate == 'animate-yes') {
                    google.maps.event.addListener(marker, 'click', function () {
                        marker.setAnimation(null);
                    });
                }

                // add to array
                map.markers.push(marker);

                // if marker has html elements, add it to an infoWindow
                if ($marker.html()) {
                    // make info window
                    var infowindow = new google.maps.InfoWindow({
                        content: $marker.html()
                    });

                    // show info window when marker is clicked
                    if ($marker.data('info-window') == 'yes') {
                        infowindow.open(map, marker);
                    }
                    google.maps.event.addListener(marker, 'click', function () {
                        infowindow.open(map, marker);
                    });
                }

                if (animate == 'animate-yes') {
                    google.maps.event.addListener(infowindow, 'closeclick', function () {
                        marker.setAnimation(google.maps.Animation.BOUNCE);
                    });
                }
            }

            function center_map(map, zoom) {
                var bounds = new google.maps.LatLngBounds();

                // loop markers and create bounds
                $.each(map.markers, function (i, marker) {
                    var latlng = new google.maps.LatLng(marker.position.lat(), marker.position.lng());
                    bounds.extend(latlng);
                });

                // If only 1 marker exist
                if (map.markers.length == 1) {
                    map.setCenter(bounds.getCenter());
                    map.setZoom(zoom);
                } else {
                    map.fitBounds(bounds);
                }
            }
        },

        animatedHeading: function ($scope, $) {
            var $heading = $scope.find('.eead-ah-heading > *'),
                $animatedHeading = $scope.find('.eead-animated-heading'),
                $settings = $scope.find('.eead-animated-heading').data('settings');

            if (!$heading.length) {
                return;
            }

            if ($settings.layout === 'animated') {
                $($animatedHeading).Morphext($settings);
            } else if ($settings.layout === 'typed') {
                var animateSelector = $($animatedHeading).attr('id');
                new Typed('#' + animateSelector, $settings);
            }

            $($heading).animate({
                easing: 'slow',
                opacity: 1
            }, 500);
        },

        businessHours: function ($scope) {
            var $container = $scope.find('.eead-business-hour');
            if (!$container.length) {
                return;
            }

            var $settings = $container.data('settings');
            var timeNotation = $settings.timeNotation;
            var business_hour_style = $settings.business_hour_style;

            if (business_hour_style != 'dynamic')
                return;

            $(document).ready(function () {
                var offset_val;
                var timeFormat = '%H:%M:%S', timeZoneFormat;
                var dynamic_timezone = $settings.dynamic_timezone;

                if (business_hour_style == 'static') {
                    offset_val = $settings.dynamic_timezone_default;
                } else {
                    offset_val = dynamic_timezone;
                }

                if (timeNotation == '12h') {
                    timeFormat = '%I:%M:%S %p';
                }

                if (offset_val == '') {
                    return;
                }

                var options = {
                    format: timeFormat,
                    timeNotation: timeNotation, //'24h',
                    am_pm: true,
                    utc: true,
                    utc_offset: offset_val
                }
                $($container).find('.eead-bh-current-time').jclock(options);

            });
        },

        circularProgressBar: function ($scope) {
            var container = $scope.find('.eead-circular-progressbar');
            var percentage = container.attr('data-number');
            var radius = container.attr('data-radius');
            const circumference = 2 * Math.PI * radius;
            const dashOffset = circumference - (percentage / 100) * circumference;
            if ((container.length > 0)) {
                container.waypoint(function () {
                    setTimeout(function () {
                        container.find('circle:nth-child(2)').css({
                            'stroke-dashoffset': dashOffset
                        }, 1000);
                    }, 400);
                    this.destroy();
                }, {
                    offset: '90%',
                });
            }
        },

        countdown: function ($scope) {
            var $coundDown = $scope.find('.eead-countdown'),
                $expire_type = $coundDown.data('expire-type') !== '' ? $coundDown.data('expire-type') : '',
                $expiry_text = $coundDown.data('expiry-text') !== '' ? $coundDown.data('expiry-text') : '',
                $expiry_title = $coundDown.data('expiry-title') !== '' ? $coundDown.data('expiry-title') : '',
                $redirect_url = $coundDown.data('redirect-url') !== '' ? $coundDown.data('redirect-url') : '';

            $coundDown.find('.eead-countdown-items').countdown({
                end: function end() {
                    if ($expire_type == 'text') {
                        $coundDown.html('<div class="eead-countdown-finish-message"><h4 class="expiry-title">' + $expiry_title + '</h4>' + '<div class="eead-countdown-finish-text">' + $expiry_text + '</div></div>');
                    } else if ($expire_type === 'url') {
                        if (elementorFrontend.isEditMode() == false) {
                            window.location.href = $redirect_url;
                        }
                    }
                }
            });
        },

        counterBlock: function ($scope) {
            var $ele = $scope.find('.eead-counter-box');
            var $odometer = $ele.find('.eead-odometer');
            var format = $odometer.data('comma') == 'yes' ? '(,ddd)' : 'd';
            $ele.waypoint(function () {
                var od = new Odometer({
                    el: $odometer[0],
                    format: format,
                    value: $odometer.data('start'),
                });
                setTimeout(function () {
                    od.render();
                    od.update($odometer.data('count'));
                }, 1000);
                this.destroy();
            }, {
                offset: '90%'
            });
        },

        filterableGallery: function ($scope) {
            var filterControls = $scope.find('.eead-fg-filter-dropdown').eq(0),
                filterTrigger = $scope.find('#eead-fg-filter-trigger'),
                form = $scope.find('.eead-fg-search-box'),
                input = $scope.find('#eead-fg-search-input'),
                searchRegex,
                buttonFilter,
                timer;

            if (form.length) {
                form.on('submit', function (e) {
                    e.preventDefault();
                });
            }

            filterTrigger.on('click', function () {
                filterControls.toggleClass('open-filters');
            });

            /*filterTrigger.on('blur', function () {
                filterControls.removeClass('open-filters');
            });*/

            if (elementorFrontend.isEditMode() == false) {
                var $gallery = $('.eead-filter-gallery-container', $scope),
                    $gallery_items = $scope.find('.eead-filter-gallery'),
                    $settings = $gallery.data('settings'),
                    fg_items = $gallery.data('gallery-items'),
                    $layout_mode = $settings.grid_style === 'masonry' ? 'masonry' : 'fitRows',
                    $gallery_enabled = $settings.gallery_enabled === 'yes' ? true : false,
                    $init_show_setting = $gallery.data('init-show'),
                    filterType = $settings.filter_type;
                fg_items.splice(0, $init_show_setting);

                // setup isotope
                var $isotope_gallery = $gallery.isotope({
                    itemSelector: '.eead-fg-item-list',
                    layoutMode: $layout_mode,
                    percentPosition: true,
                    stagger: 30,
                    transitionDuration: $settings.duration + 'ms',
                    filter: function filter() {
                        var $this = $(this);
                        var $result = searchRegex ? $this.text().match(searchRegex) : true;
                        if (buttonFilter === undefined) {
                            if (filterType == 'normal') {
                                buttonFilter = $scope.find('.eead-fg-filter ul li').first().data('filter');
                            } else {
                                buttonFilter = $scope.find('ul.eead-fg-filter-dropdown li').first().data('filter');
                            }
                        }
                        var buttonResult = buttonFilter ? $this.is(buttonFilter) : true;
                        return $result && buttonResult;
                    }
                });

                $isotope_gallery.addClass('eead-isotope-initialized');

                // Init Popup
                if ($gallery_enabled) {
                    lightGallery(document.getElementById($gallery_items.attr('id')), {
                        selector: '.eead-magnific-link',
                        thumbnail: false,
                    });
                } else {
                    lightGallery(document.getElementById($gallery_items.attr('id')), {
                        selector: '.eead-magnific-link',
                        thumbnail: false,
                        counter: false,
                        controls: false,
                        loop: false,
                        mousewheel: false
                    });
                }

                // filter
                $scope.on('click', '.eead-fg-filter-control', function () {
                    var $this = $(this);
                    buttonFilter = $(this).attr('data-filter');
                    var $spanText = $scope.find('#eead-fg-filter-trigger > span');
                    if ($spanText.length) {
                        $spanText.text($this.text());
                    }

                    var LoadMoreShow = $(this).attr('data-load-more-status'),
                        loadMore = $('.eead-fg-loadmore-btn', $scope);

                    //hide load more button if no item to show
                    if (LoadMoreShow == '1' || fg_items.length < 1) {
                        loadMore.hide();
                    } else {
                        loadMore.show();
                    }
                    $this.siblings().removeClass('eead-fg-active');
                    $this.addClass('eead-fg-active');
                    $isotope_gallery.isotope();
                });

                //quick search
                input.on('input', function () {
                    var $this = $(this);
                    clearTimeout(timer);
                    timer = setTimeout(function () {
                        searchRegex = new RegExp($this.val(), 'gi');
                        $isotope_gallery.isotope();
                    }, 600);
                });

                // layout gal, while images are loading
                $isotope_gallery.imagesLoaded().progress(function () {
                    $isotope_gallery.isotope('layout');
                });

                // layout gal, on click tabs
                $isotope_gallery.on('arrangeComplete', function () {
                    $isotope_gallery.isotope('layout');
                });

                // layout gal, after window loaded
                $(window).on('load', function () {
                    $isotope_gallery.isotope('layout');
                });

                // Load more button
                $scope.on('click', '.eead-fg-loadmore-btn', function (e) {
                    e.preventDefault();
                    var $this = $(this),
                        $images_per_page = $gallery.data('images-per-page'),
                        $nomore_text = $gallery.data('nomore-item-text'),
                        enable_filter = $('.eead-fg-filter', $scope).length,
                        $items = [];
                    var filter_name = $('.eead-fg-filter li.eead-fg-active', $scope).data('filter');

                    if (filterControls.length > 0) {
                        filter_name = $('.eead-fg-filter-dropdown li.eead-fg-active', $scope).data('filter');
                    }

                    let item_found = 0;
                    let index_list = []
                    for (const [index, item] of fg_items.entries()) {
                        if (filter_name !== '' && filter_name !== '*' && enable_filter) {
                            let element = $($(item)[0]);
                            if (element.is(filter_name)) {
                                ++item_found;
                                $items.push($(item)[0]);
                                index_list.push(index);
                            }

                            if ((fg_items.length - 1) === index) {
                                $('.eead-fg-filter li.eead-fg-active', $scope).attr('data-load-more-status', 1)
                                $this.hide()
                            }
                        } else {
                            ++item_found;
                            $items.push($(item)[0]);
                            index_list.push(index);
                        }

                        if (item_found === $images_per_page) {
                            break;
                        }
                    }

                    if (index_list.length > 0) {
                        fg_items = fg_items.filter(function (item, index) {
                            return !index_list.includes(index);
                        });
                    }

                    if (fg_items.length < 1) {
                        $this.html($nomore_text);
                        setTimeout(function () {
                            $this.fadeOut();
                        }, 600);
                    }

                    // append items
                    $gallery.append($items);
                    $isotope_gallery.isotope('insert', $items);
                    $isotope_gallery.imagesLoaded().progress(function () {
                        $isotope_gallery.isotope('layout');
                    });
                });

                // Safari: hide filter menu
                $(document).on('mouseup', function (e) {
                    if (!filterTrigger.is(e.target) && filterTrigger.has(e.target).length === 0) {
                        filterControls.removeClass('open-filters');
                    }
                });
            }
        },

        horizontalTabsBlock: function ($scope) {
            $scope.find('.eead-horizontal-tab').on('click', '.eead-ht-tab', function () {
                var $tab_id = $(this).data('tabid');
                if ($tab_id) {
                    $scope.find('.eead-ht-tab').removeClass('eead-ht-active-tab');
                    $(this).addClass('eead-ht-active-tab');

                    $scope.find('.eead-ht-content').removeClass('eead-ht-active-content');
                    $scope.find('.eead-ht-content-' + $tab_id).addClass('eead-ht-active-content');
                }
            });
        },

        verticalTabsBlock: function ($scope) {
            $scope.find('.eead-vertical-tab').on('click', '.eead-vt-tab', function () {
                var $tab_id = $(this).data('tabid');
                if ($tab_id) {
                    $scope.find('.eead-vt-tab').removeClass('eead-vt-active-tab');
                    $(this).addClass('eead-vt-active-tab');

                    $scope.find('.eead-vt-content').removeClass('eead-vt-active-content');
                    $scope.find('.eead-vt-content-' + $tab_id).addClass('eead-vt-active-content');
                }
            });
        },

        horizontalTimelineCarousel: function ($scope) {
            $scope.find('.eead-htl-scrollbar').mCustomScrollbar({
                theme: 'dark',
                scrollInertia: 500,
                axis: 'x',
                advanced: {autoExpandHorizontalScroll: true}
            });

            var $ele = $scope.find('.eead-htl-carousel');
            if ($ele.length > 0) {
                var params = JSON.parse($ele.attr('data-params'));
                $ele.owlCarousel({
                    loop: JSON.parse(params.loop),
                    autoplay: JSON.parse(params.autoplay),
                    autoplayTimeout: params.pause,
                    autoplayHoverPause: JSON.parse(params.pause_on_hover),
                    nav: JSON.parse(params.arrows),
                    dots: false,
                    navText: ['<i class="' + params.prev_icon + '">', '<i class="' + params.next_icon + '">'],
                    responsive: {
                        0: {
                            items: params.items_mobile,
                        },
                        480: {
                            items: params.items_tablet,
                        },
                        769: {
                            items: params.items,
                        }
                    }
                });
            }

            function equalizeHeights(selector1, selector2) {
                var maxHeight1 = 0,
                    maxHeight2 = 0;

                $scope.find(selector1).each(function () {
                    maxHeight1 = Math.max(maxHeight1, $(this).outerHeight());
                });

                $scope.find(selector2).each(function () {
                    maxHeight2 = Math.max(maxHeight2, $(this).outerHeight());
                });

                // Apply the maximum height
                $scope.find('.eead-htl-list').css({
                    '--eead-htl-content-height': maxHeight1 + 'px',
                    '--eead-htl-meta-height': maxHeight2 + 'px',
                });
            }

            equalizeHeights('.eead-htl-content', '.eead-htl-meta');

            // Re-apply on window resize
            $(window).on('resize', function () {
                equalizeHeights('.eead-htl-content', '.eead-htl-meta');
            });
        },

        hotspotBlock: function ($scope) {
            $scope.find('.eead-open-onclick .eead-hotspot-item > a').on('click', function (e) {
                e.preventDefault();
                $(this).parent('.eead-hotspot-item').toggleClass('eead-active');
            });
        },

        imageComparison: function ($scope) {
            var $image_compare = $scope.find('.eead-image-compare');
            var $settings = $image_compare.data('settings');
            var options = {
                // UI Theme Defaults
                addCircle: $settings.add_circle,
                controlShadow: $settings.add_circle_shadow,
                addCircleBlur: $settings.add_circle_blur,
                controlColor: $settings.bar_color,

                // Label Defaults
                showLabels: $settings.show_before_after_label,
                labelOptions: {
                    onHover: $settings.show_before_after_label_onhover,
                    before: $settings.before_label,
                    after: $settings.after_label
                },

                // Smoothing
                smoothing: $settings.smoothing,
                smoothingAmount: $settings.smoothing_amount,

                // Other options
                hoverStart: $settings.move_slider_on_hover,
                verticalMode: $settings.orientation,
                startingPoint: $settings.starting_point,
                fluidMode: false
            };

            new ImageCompare(document.querySelector('#' + $settings.id), options).mount();
        },

        imageAccordion: function ($scope) {
            var $accordionContainer = $scope.find('.eead-image-accordion-on-click');

            if ($accordionContainer.length > 0) {
                var $accordion = $scope.find('.eead-image-accordion-item');
                $accordion.on('click', function (e) {
                    e.preventDefault();
                    var $this = $(this);
                    if ($this.hasClass('eead-tab-active')) {
                        return;
                    }

                    $accordion.removeClass('eead-tab-active');
                    $this.addClass('eead-tab-active');
                });
            } else {
                $scope.find('.eead-image-accordion-on-hover').mouseenter(function () {
                    $(this).find('.eead-image-accordion-item.eead-tab-active').removeClass('eead-tab-active').addClass('eead-trigger');
                });

                $scope.find('.eead-image-accordion-on-hover').mouseleave(function () {
                    $(this).find('.eead-image-accordion-item.eead-trigger').addClass('eead-tab-active').removeClass('eead-trigger');
                });
            }
        },

        imageGallery: function ($scope, $) {
            if (elementorFrontend.isEditMode() == false) {
                var $gallery_container = $scope.find('.eead-image-gallery-container');
                var $gallery = $scope.find('.eead-ig-wrap');
                var $settings = $gallery_container.data('settings');

                if ($settings.layout == 'masonry' || $settings.layout == 'grid') {
                    var layout = $settings.layout == 'grid' ? 'fitRows' : 'masonry';
                    var filterValue = $gallery_container.find('.eead-ig-filter-list .eead-ig-filter').first().data('filter');

                    $gallery.imagesLoaded().done(function () {
                        $gallery.isotope({
                            itemSelector: '.eead-ig-item-box',
                            layoutMode: layout,
                            percentPosition: true,
                            stagger: 30,
                            transitionDuration: $settings.duration + 'ms',
                            filter: filterValue
                        });
                    });

                    $gallery_container.on('click', '.eead-ig-filter', function () {
                        var $this = $(this),
                            filterValue = $this.attr('data-filter');

                        $this.siblings().removeClass('eead-ig-active');
                        $this.addClass('eead-ig-active');
                        $gallery.isotope({
                            itemSelector: '.eead-ig-item-box',
                            layoutMode: layout,
                            percentPosition: true,
                            stagger: 30,
                            transitionDuration: $settings.duration + 'ms',
                            filter: filterValue
                        });
                    });

                    $gallery_container.addClass('eead-isotope-initialized');

                    // Init Popup
                    lightGallery(document.getElementById($gallery_container.attr('id')), {
                        selector: '.eead-ig-lightbox',
                        thumbnail: false,
                    });
                }
            }
        },

        pieChart: function ($scope) {
            var $container = $scope.find('.eead-pie-chart-container'),
                $canvas = $scope.find('.eead-pie-chart'),
                data = $container.data('chart') || {},
                options = $container.data('options') || {};
            new Chart($canvas, {
                type: 'pie',
                data: data,
                options: {
                    cutout: options.cutoutPercentage,
                    maintainAspectRatio: false,
                    plugins: {
                        tooltip: options.tooltips,
                        legend: options.legend
                    },
                    animation: options.animation
                }
            });

        },

        onePageNav: function ($scope) {
            var nav_el = $scope.find('.eead-one-page-nav');
            var $section_id = '#' + nav_el.data('section-id'),
                $top_offset = nav_el.data('top-offset'),
                $scroll_speed = nav_el.data('scroll-speed'),
                $scroll_wheel = nav_el.data('scroll-wheel'),
                $scroll_touch = nav_el.data('scroll-touch'),
                $scroll_keys = nav_el.data('scroll-keys'),
                $target_dot = $section_id + ' .eead-one-page-nav-item a',
                $active_item = $section_id + ' .eead-one-page-nav-item.active';

            $($target_dot).on('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                if ($('#' + $(this).data('row-id')).length === 0) {
                    return;
                }
                if ($('html, body').is(':animated')) {
                    return;
                }

                $('html, body').animate({
                    scrollTop: $('#' + $(this).data('row-id')).offset().top - $top_offset
                }, $scroll_speed);

                $($section_id + ' .eead-one-page-nav-item').removeClass('active');
                $(this).parent().addClass('active');
                return false;
            });

            updateDot();

            $(window).on('scroll', function () {
                updateDot();
            });

            function updateDot() {
                $('.elementor-element').each(function () {
                    var $this = $(this);
                    if (($this.offset().top - $(window).height() / 2 < $(window).scrollTop()) && ($this.offset().top >= $(window).scrollTop() || $this.offset().top + $this.height() - $(window).height() / 2 > $(window).scrollTop())) {
                        $($section_id + ' .eead-one-page-nav-item a[data-row-id="' + $this.attr('id') + '"]').parent().addClass('active');
                    } else {
                        $($section_id + ' .eead-one-page-nav-item a[data-row-id="' + $this.attr('id') + '"]').parent().removeClass('active');
                    }
                });
            }

            // When Mouse Wheel Scrolled
            if ($scroll_wheel === 'on') {
                var lastAnimation = 0,
                    quietPeriod = 500,
                    animationTime = 800,
                    startX,
                    startY,
                    timestamp;

                $(document).on('mousewheel DOMMouseScroll', function (e) {
                    var timeNow = new Date().getTime();
                    if (timeNow - lastAnimation < quietPeriod + animationTime) {
                        return;
                    }

                    var delta = e.originalEvent.detail < 0 || e.originalEvent.wheelDelta > 0 ? 1 : -1;
                    if (!$('html,body').is(':animated')) {
                        if (delta < 0) {
                            if ($($active_item).next().length > 0) {
                                $($active_item).next().find('a').trigger('click');
                            }
                        } else {
                            if ($($active_item).prev().length > 0) {
                                $($active_item).prev().find('a').trigger('click');
                            }
                        }
                    }
                    lastAnimation = timeNow;
                });

                // When Screen Touch swiped
                if ($scroll_touch === 'on') {
                    $(document).on('pointerdown touchstart', function (e) {
                        var touches = e.originalEvent.touches;
                        if (touches && touches.length) {
                            startY = touches[0].screenY;
                            timestamp = e.originalEvent.timeStamp;
                        }
                    }).on('touchmove', function (e) {
                        if ($('html,body').is(':animated')) {
                            e.preventDefault();
                        }
                    }).on('pointerup touchend', function (e) {
                        var touches = e.originalEvent;
                        if (touches.pointerType === 'touch' || e.type === 'touchend') {
                            var Y = touches.screenY || touches.changedTouches[0].screenY;
                            var deltaY = startY - Y;
                            var time = touches.timeStamp - timestamp;
                            // screen swipe up.
                            if (deltaY < 0) {
                                if ($($active_item).prev().length > 0) {
                                    $($active_item).prev().find('a').trigger('click');
                                }
                            }
                            // screen swipe down.
                            if (deltaY > 0) {
                                if ($($active_item).next().length > 0) {
                                    $($active_item).next().find('a').trigger('click');
                                }
                            }
                            if (Math.abs(deltaY) < 2) {
                                return;
                            }
                        }
                    });
                }
            }

            // Key Press Scroll
            if ($scroll_keys === 'on') {
                $(document).keydown(function (e) {
                    var tag = e.target.tagName.toLowerCase();
                    if (tag === 'input' && tag === 'textarea') {
                        return;
                    }
                    switch (e.which) {
                        case 38:
                            $($active_item).prev().find('a').trigger('click');
                            break;
                        case 40:
                            $($active_item).next().find('a').trigger('click');
                            break;
                        case 33:
                            $($active_item).prev().find('a').trigger('click');
                            break;
                        case 36:
                            $($active_item).next().find('a').trigger('click');
                            break;
                        default:
                            return;
                    }
                });
            }
        },

        Lottie: function ($scope) {
            var $container = $scope.find('.eead-lottie'),
                id = $container.attr('id'),
                settings = JSON.parse($container.attr('data-settings')),
                action = settings.autoplay ? settings.action : settings.action_alt;

            let animation = lottie.loadAnimation({
                container: document.getElementById(id),
                renderer: settings.renderer,
                autoplay: settings.autoplay,
                path: settings.path,
                loop: true,
            });

            animation.setDirection(settings.reverse);
            animation.setSpeed(settings.speed);

            switch (action) {
                case 'play':
                    $container.on('mouseenter', function () {
                        animation.play();
                    });
                    $container.on('mouseleave', function () {
                        animation.pause();
                    });
                    break;
                case 'pause':
                    $container.on('mouseenter', function () {
                        animation.pause();
                    });
                    $container.on('mouseleave', function () {
                        animation.play();
                    });
                    break;
                case 'reverse':
                    var direction = settings.reverse == '1' ? '-1' : '1';
                    $container.on('mouseenter', function () {
                        animation.pause();
                        setTimeout(function () {
                            animation.setDirection(direction);
                            animation.play();
                        }, 200);
                    });
                    $container.on('mouseleave', function () {
                        animation.pause();
                        setTimeout(function () {
                            animation.setDirection(settings.reverse);
                            animation.play();
                        }, 200);
                    });
                    break;
            }

        },

        scrollImage: function ($scope) {
            var $container = $scope.find('.eead-scroll-image-container');
            var $frame = $scope.find('.eead-scroll-image-device');
            var $frameContainer = $scope.find('.eead-scroll-image-frame-wrapper');

            lightGallery(document.getElementById($container.attr('id')), {
                selector: '.eead-scroll-image-modal',
                counter: false,
                iframeMaxWidth: '80%',
            });

            setTimeout(function () {
                resizeVideo();
            }, 1000);

            $(window).resize(function () {
                resizeVideo();
            });

            function resizeVideo() {
                if ($frame.length > 0) {
                    var frameHeight = $frame.outerHeight();
                    $frameContainer.height(frameHeight);
                }
            }
        },

        logoCarousel: function ($scope) {
            var $ele = $scope.find('.eead-logo-carousel');
            if ($ele.length > 0) {
                var params = JSON.parse($ele.attr('data-params'));
                $ele.owlCarousel({
                    loop: JSON.parse(params.loop),
                    autoplay: JSON.parse(params.autoplay),
                    autoplayTimeout: params.pause,
                    autoplayHoverPause: JSON.parse(params.pause_on_hover),
                    nav: JSON.parse(params.arrows),
                    dots: JSON.parse(params.dots),
                    autoHeight: JSON.parse(params.auto_height),
                    center: JSON.parse(params.focus_center_logo),
                    navText: ['<i class="' + params.prev_icon + '">', '<i class="' + params.next_icon + '">'],
                    responsive: {
                        0: {
                            items: params.items_mobile,
                            margin: params.margin_mobile,
                            stagePadding: params.stagepadding_mobile
                        },
                        480: {
                            items: params.items_tablet,
                            margin: params.margin_tablet,
                            stagePadding: params.stagepadding_tablet
                        },
                        769: {
                            items: params.items,
                            margin: params.margin,
                            stagePadding: params.stagepadding
                        }
                    }
                });
            }
        },

        popupModal: function ($scope) {
            var $open = $scope.find('.eead-popup-modal-trigger-btn');
            if ($open.hasClass('eead-popup-modal-trigger-selector')) {
                var $trigger = $open.attr('data-selector');
                $($trigger)?.on('click', function () {
                    var $id = $open.data('id');
                    MicroModal.show('eead-popup-modal-' + $id, {
                        awaitOpenAnimation: true,
                        awaitCloseAnimation: true,
                        openClass: 'eead-open-modal',
                        disableScroll: true,
                        onShow: (modal) => {
                        },
                        onClose: (modal) => {
                        }
                    })
                });
            } else {
                $open.on('click', function () {
                    var $id = $(this).data('id');
                    MicroModal.show('eead-popup-modal-' + $id, {
                        awaitOpenAnimation: true,
                        awaitCloseAnimation: true,
                        openClass: 'eead-open-modal',
                        disableScroll: true,
                        onShow: (modal) => {
                        },
                        onClose: (modal) => {
                        }
                    })
                });
            }
        },

        popupVideo: function ($scope) {
            var $video = $scope.find('.eead-video-popup-button');
            var video_id = $video.attr('id');
            var video_type = $video.attr('data-video-type');
            var video_width = $video.attr('data-video-width');
            if (video_type == 'custom') {
                lightGallery(document.getElementById(video_id), {
                    selector: 'this',
                    counter: false
                });
            } else {
                var settings = JSON.parse($video.attr('data-settings'));
                lightGallery(document.getElementById(video_id), {
                    selector: 'this',
                    counter: false,
                    videoMaxWidth: video_width,
                    youtubePlayerParams: {
                        autoplay: settings.autoplay,
                        controls: settings.controls,
                        mute: settings.mute,
                        start: settings.start,
                        end: settings.end,
                        loop: settings.loop,
                        modestbranding: 0,
                        rel: 0
                    },
                    vimeoPlayerParams: {
                        autoplay: settings.autoplay,
                        loop: settings.loop,
                        title: settings.title,
                        byline: settings.byline,
                        portrait: settings.portrait,
                        muted: settings.mute
                    }
                });
            }
        },

        progressBar: function ($scope) {
            var $el = $scope.find('.eead-progressbar');
            if (($el.length > 0)) {
                $el.each(function (index) {
                    var $this = $(this);
                    var delay_time = parseInt(index * 100 + 300);
                    $this.waypoint(function () {
                        setTimeout(function () {
                            $this.find('.eead-progressbar-length').animate({
                                width: $this.attr('data-width') + '%'
                            }, 1000, function () {
                                $this.find('span').animate({
                                    opacity: 1
                                }, 500);
                            });
                        }, delay_time);
                        this.destroy();
                    }, {
                        offset: '90%',
                    });
                });
            }
        },

        toggleBlock: function ($scope, $) {
            var $container = $scope.find('.eead-toggle-container'),
                $toggle_switch = $container.find('.eead-toggle-switch-checkbox'),
                $label_primary = $container.find('.eead-toggle-label-primary'),
                $label_secondary = $container.find('.eead-toggle-label-secondary');

            $toggle_switch.on('click', function () {
                $container.toggleClass('eead-switch-on');
                if ($(this).prop('checked')) {
                    $toggle_switch.prop('checked', true);
                } else {
                    $toggle_switch.prop('checked', false);
                }
            });

            $label_primary.on('click', function () {
                $container.removeClass('eead-switch-on');
                $toggle_switch.prop('checked', false);
            });

            $label_secondary.on('click', function () {
                $container.addClass('eead-switch-on');
                $toggle_switch.prop('checked', true);
            });
        },

        switcherBlock: function ($scope) {
            $scope.find('.eead-switcher-slider').css({
                'width': $scope.find('.eead-switcher-active-tab').outerWidth() + 'px',
                'left': $scope.find('.eead-switcher-active-tab').position().left + 'px'
            });

            $('.eead-switcher-tab').on('click', function () {
                if ($(this).hasClass('eead-switcher-active-tab')) {
                    return;
                }

                var $container = $(this).closest('.eead-switcher-container');

                $container.find('.eead-switcher-slider').css({
                    'width': $(this).outerWidth() + 'px',
                    'left': $(this).position().left + 'px'
                });

                $container.find('.eead-switcher-tab').removeClass('eead-switcher-active-tab');
                $container.find('.eead-switcher-content').removeClass('eead-switcher-active-content');

                $(this).addClass('eead-switcher-active-tab');
                var clickedTabId = $(this).attr('data-switchid');
                $container.find('.eead-switcher-content-' + clickedTabId).addClass('eead-switcher-active-content');
            });
        },

        stickyVideo: function ($scope) {
            var stickyVideo = $scope.find('.eead-sticky-video');
            var videoContainer = $scope.find('.eead-sticky-video-container');
            var overlayContainer = $scope.find('.eead-overlay');
            var sticky = stickyVideo.data('sticky');
            var overlay = stickyVideo.data('overlay') ? stickyVideo.data('overlay') : '';
            var autoplay = JSON.parse(stickyVideo.data('autoplay'));
            var videoIsActive = 'off';

            var player = new Plyr('#eead-player-' + $scope.data('id'), {
                autoplay: JSON.parse(stickyVideo.data('autoplay')),
                muted: JSON.parse(stickyVideo.data('mute')),
                loop: {active: JSON.parse(stickyVideo.data('loop'))}
            });

            player.on('pause', function (event) {
                videoIsActive = 'off';
            });

            player.on('play', function (event) {
                videoIsActive = 'on';
            });

            $('.eead-sticky-player-close').on('click', function () {
                stickyVideo.removeClass('out').addClass('in');
                player.pause();
                videoIsActive = 'off';
            });

            if (overlay === 'yes' && autoplay) {
                player.play();
                overlayContainer.hide();
                videoIsActive = 'on';
            } else if (overlay === 'yes') {
                overlayContainer.on('click', function () {
                    player.play();
                    overlayContainer.hide();
                    videoIsActive = 'on';
                });
            }

            if (sticky == 'yes') {
                setTimeout(function () {
                    videoContainer.css('height', stickyVideo.height() + 'px');
                    var stickyPoint = videoContainer.offset().top + videoContainer.height();
                    stickyVideo.attr('data-sticky-point', stickyPoint);
                }, 1000);

                $(window).resize(function () {
                    videoContainer.css('height', stickyVideo.height() + 'px');
                    var stickyPoint = videoContainer.offset().top + videoContainer.height();
                    stickyVideo.attr('data-sticky-point', stickyPoint);
                });

                $(window).scroll(function () {
                    var scrollTop = $(window).scrollTop();
                    var stickyPoint = stickyVideo.attr('data-sticky-point');

                    var scrollBottom = $(document).height() - scrollTop;

                    if (scrollBottom > jQuery(window).height() + 400) {
                        if (scrollTop > stickyPoint) {
                            if (videoIsActive == 'on') {
                                stickyVideo.removeClass('in').addClass('out');
                            }
                        } else {
                            stickyVideo.removeClass('out').addClass('in');
                        }
                    }
                });
            }
        },

        videoPlayer: function ($scope) {
            var videoContainer = $scope.find('.eead-video-player-container'),
                video = $scope.find('.eead-video-player'),
                videoPlayer = $scope.find('.eead-html-video-player'),
                overlay = $scope.find('.eead-video-overlay'),
                iframe = $scope.find('.eead-video-iframe'),
                hasOverlay = overlay.length > 0,
                settings = video.data('settings') || {},
                autoplay = settings.autoplay || false;

            if (overlay[0]) {
                overlay.on('click.eead-video-player', function (event) {
                    if (videoPlayer[0]) {
                        videoPlayer[0].play();
                        overlay.remove();
                        hasOverlay = false;
                        return;
                    }

                    if (iframe[0]) {
                        playIframeVideo();
                    }
                });
            }

            if (autoplay && iframe[0] && overlay[0]) {
                playIframeVideo();
            }

            if (videoPlayer[0]) {
                videoPlayer.on('play.eead-video-player', function (event) {
                    if (hasOverlay) {
                        overlay.remove();
                        hasOverlay = false;
                    }
                });
            }

            setTimeout(function () {
                resizeVideo();
            }, 1000);

            $(window).resize(function () {
                resizeVideo();
            });

            function playIframeVideo() {
                var lazyLoad = iframe.data('lazy-load');
                if (lazyLoad) {
                    iframe.attr('src', lazyLoad);
                }
                if (!autoplay) {
                    iframe[0].src = iframe[0].src.replace('&autoplay=0', '&autoplay=1');
                }
                overlay.remove();
                hasOverlay = false;
            }

            function resizeVideo() {
                var videoHeight = video.outerHeight();
                videoContainer.height(videoHeight);
            }
        },

        sliderBlock: function ($scope) {
            var $slider = $scope.find('.eead-slider');
            var titleAnim = $slider.attr('data-title-anim');
            var subtitleAnim = $slider.attr('data-subtitle-anim');
            var buttonAnim = $slider.attr('data-button-anim');
            if ($slider.find('.eead-slide').length > 0) {
                var params = JSON.parse($slider.attr('data-params'));
                var sliderObj = {
                    infinite: JSON.parse(params.loop),
                    autoplay: JSON.parse(params.autoplay),
                    speed: params.speed,
                    autoplaySpeed: params.pause,
                    pauseOnHover: JSON.parse(params.pause_on_hover),
                    arrows: JSON.parse(params.arrows),
                    dots: JSON.parse(params.dots),
                    adaptiveHeight: JSON.parse(params.auto_height),
                    prevArrow: '<div class="slick-prev slick-arrow"><i class="' + params.prev_icon + '"></div>',
                    nextArrow: '<div class="slick-next slick-arrow"><i class="' + params.next_icon + '"></div>',
                    fade: $slider.attr('data-transition') == 'fade' ? true : false,
                    appendArrows: $scope.find('.slick-nav'),
                    appendDots: $scope.find('.slick-dots-wrap')
                };

                $slider.on('init', function (event, slick) {
                    $(this).find('.slick-current .eead-slide-caption').addClass('eead-animate');
                    if (titleAnim !== 'none') {
                        $(this).find('.slick-current .eead-slide-cap-title').addClass(titleAnim);
                    }
                    if (subtitleAnim !== 'none') {
                        $(this).find('.slick-current .eead-slide-cap-desc').addClass(subtitleAnim);
                    }
                    if (buttonAnim !== 'none') {
                        $(this).find('.slick-current .eead-slide-button').addClass(buttonAnim);
                    }
                });

                $slider.slick(sliderObj);

                $slider.on('beforeChange', function (event, slick, currentSlide) {
                    $(this).find('.slick-slide .eead-slide-caption').removeClass('eead-animate');
                    if (titleAnim !== 'none') {
                        $(this).find('.slick-slide .eead-slide-cap-title').removeClass(titleAnim);
                    }
                    if (subtitleAnim !== 'none') {
                        $(this).find('.slick-slide .eead-slide-cap-desc').removeClass(subtitleAnim);
                    }
                    if (buttonAnim !== 'none') {
                        $(this).find('.slick-slide .eead-slide-button').removeClass(buttonAnim);
                    }
                });

                $slider.on('afterChange', function (event, slick, currentSlide) {
                    $(this).find('.slick-current .eead-slide-caption').addClass('eead-animate');
                    if (titleAnim !== 'none') {
                        $(this).find('.slick-current .eead-slide-cap-title').addClass(titleAnim);
                    }
                    if (subtitleAnim !== 'none') {
                        $(this).find('.slick-current .eead-slide-cap-desc').addClass(subtitleAnim);
                    }
                    if (buttonAnim !== 'none') {
                        $(this).find('.slick-current .eead-slide-button').addClass(buttonAnim);
                    }
                });
            }
        },

        teamCarousel: function ($scope, $) {
            var $ele = $scope.find('.eead-team-carousel');
            if ($ele.length > 0) {
                var params = JSON.parse($ele.attr('data-params'));
                $ele.owlCarousel({
                    loop: JSON.parse(params.loop),
                    autoplay: JSON.parse(params.autoplay),
                    autoplayTimeout: params.pause,
                    autoplayHoverPause: JSON.parse(params.pause_on_hover),
                    nav: JSON.parse(params.arrows),
                    dots: JSON.parse(params.dots),
                    autoHeight: JSON.parse(params.auto_height),
                    center: JSON.parse(params.focus_center_slide),
                    navText: ['<i class="' + params.prev_icon + '">', '<i class="' + params.next_icon + '">'],
                    responsive: {
                        0: {
                            items: params.items_mobile,
                            margin: params.margin_mobile,
                            stagePadding: params.stagepadding_mobile
                        },
                        480: {
                            items: params.items_tablet,
                            margin: params.margin_tablet,
                            stagePadding: params.stagepadding_tablet
                        },
                        769: {
                            items: params.items,
                            margin: params.margin,
                            stagePadding: params.stagepadding
                        }
                    }
                });
            }
        },

        testimonialCarousel: function ($scope) {
            var $ele = $scope.find('.eead-testimonial-carousel');
            if ($ele.length > 0) {
                var params = JSON.parse($ele.attr('data-params'));
                $ele.owlCarousel({
                    loop: JSON.parse(params.loop),
                    autoplay: JSON.parse(params.autoplay),
                    autoplayTimeout: params.pause,
                    autoplayHoverPause: JSON.parse(params.pause_on_hover),
                    nav: JSON.parse(params.arrows),
                    dots: JSON.parse(params.dots),
                    autoHeight: JSON.parse(params.auto_height),
                    center: JSON.parse(params.focus_center_slide),
                    navText: ['<i class="' + params.prev_icon + '">', '<i class="' + params.next_icon + '">'],
                    responsive: {
                        0: {
                            items: params.items_mobile,
                            margin: params.margin_mobile,
                            stagePadding: params.stagepadding_mobile
                        },
                        480: {
                            items: params.items_tablet,
                            margin: params.margin_tablet,
                            stagePadding: params.stagepadding_tablet
                        },
                        769: {
                            items: params.items,
                            margin: params.margin,
                            stagePadding: params.stagepadding
                        }
                    }
                });
            }
        },
    };

    $(window).on('elementor/frontend/init', EEA.init);

}(jQuery, window.elementorFrontend));