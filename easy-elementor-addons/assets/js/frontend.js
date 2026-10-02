(function ($) {
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
                'eead-twitter-feed.default': EEA.twitterFeed,
            };

            $.each(widgets, function (widget, callback) {
                elementorFrontend.hooks.addAction('frontend/element_ready/' + widget, callback);
            });
        },

        /**
         * Find elements that belong to this widget only, skipping matches inside
         * nested widgets (e.g. Elementor templates rendered inside the widget).
         */
        own: function ($scope, selector) {
            return $scope.find(selector).filter(function () {
                return $(this).closest('.elementor-widget')[0] === $scope[0];
            });
        },

        uid: 0,

        /** Event namespace unique to this widget element (includes the widget id). */
        ns: function ($scope, name) {
            var el = $scope[0];
            if (!el.eeadUid) {
                EEA.uid++;
                el.eeadUid = EEA.uid;
            }
            return '.eead' + name + ($scope.data('id') || '') + '-' + el.eeadUid;
        },

        /** Wrap a window/document handler so it unbinds itself once the widget leaves the DOM. */
        guard: function ($scope, ns, fn) {
            var el = $scope[0];
            return function () {
                if (!document.documentElement.contains(el)) {
                    $(window).off(ns);
                    $(document).off(ns);
                    return;
                }
                return fn.apply(this, arguments);
            };
        },

        /** Instances (timers, animations) per widget id, torn down on re-init. */
        registry: {},

        release: function ($scope, type) {
            var key = type + '-' + ($scope.data('id') || ''),
                el = $scope[0];
            EEA.registry[key] = (EEA.registry[key] || []).filter(function (entry) {
                if (entry.el === el || !document.documentElement.contains(entry.el)) {
                    try {
                        entry.destroy();
                    } catch (err) {
                    }
                    return false;
                }
                return true;
            });
        },

        keep: function ($scope, type, destroy) {
            var key = type + '-' + ($scope.data('id') || '');
            (EEA.registry[key] = EEA.registry[key] || []).push({el: $scope[0], destroy: destroy});
        },

        /** Update an ARIA attribute only on elements whose markup already declares it. */
        aria: function ($el, name, value) {
            $el.filter('[' + name + ']').attr(name, value);
        },

        /** Keydown handler: Enter/Space activates the element via click. */
        activateOnKey: function (e) {
            if (e.target !== this) {
                return;
            }
            if (e.which === 13 || e.which === 32) {
                e.preventDefault();
                $(this).trigger('click');
            }
        },

        /** Owl carousel responsive map built from Elementor's active breakpoints. */
        owlResponsive: function (mobile, tablet, desktop) {
            var mobileMax = 767,
                tabletMax = 1024,
                config = window.elementorFrontend && elementorFrontend.config,
                breakpoints = config && config.responsive && config.responsive.activeBreakpoints,
                responsive = {};

            if (breakpoints) {
                if (breakpoints.mobile && breakpoints.mobile.value) {
                    mobileMax = parseInt(breakpoints.mobile.value, 10);
                }
                if (breakpoints.tablet && breakpoints.tablet.value) {
                    tabletMax = parseInt(breakpoints.tablet.value, 10);
                }
            }

            responsive[0] = mobile;
            responsive[mobileMax + 1] = tablet;
            responsive[tabletMax + 1] = desktop;
            return responsive;
        },

        accordionBlock: function ($scope) {
            var $accordions = EEA.own($scope, '.eead-each-accordion'),
                oneAtATime = EEA.own($scope, '.eead-accordion-container').data('one-at-a-time') === 'yes';

            if (!$accordions.length) {
                return;
            }

            function setState($item, open) {
                var $content = $item.children('.eead-accordion-content').stop(true, true);
                $item.toggleClass('eead-open', open);
                EEA.aria($item.children('.eead-accordion-title'), 'aria-expanded', open ? 'true' : 'false');
                if (open) {
                    $content.slideDown();
                } else {
                    $content.slideUp();
                }
            }

            $accordions.each(function () {
                EEA.aria($(this).children('.eead-accordion-title'), 'aria-expanded', $(this).hasClass('eead-open') ? 'true' : 'false');
            });

            $accordions.children('.eead-accordion-title')
                .off('.eeadAccordion')
                .on('click.eeadAccordion', function () {
                    var $item = $(this).parent('.eead-each-accordion');
                    if (!$item.hasClass('eead-open')) {
                        if (oneAtATime) {
                            $item.siblings('.eead-open').each(function () {
                                setState($(this), false);
                            });
                        }
                        setState($item, true);
                    } else {
                        setState($item, false);
                    }
                })
                .on('keydown.eeadAccordion', EEA.activateOnKey);
        },

        advancedMap: function ($scope) {
            var $mapEl = $scope.find('.eead-gmap-markers');
            if (!$mapEl.length || typeof google === 'undefined' || !google.maps) {
                return;
            }

            new_map($mapEl);

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
                // Read via attr() so jQuery doesn't coerce numeric-looking IDs.
                var mapId = $.trim($el.attr('data-map-id') || '');
                var useAdvanced = mapId !== '' && !!(google.maps.marker && google.maps.marker.AdvancedMarkerElement);
                var mapOption = {
                    zoom: zoom,
                    scrollwheel: scrollwheel,
                    zoomControl: zoomControl,
                    fullscreenControl: fullscreenControl,
                    streetViewControl: streetViewControl,
                    mapTypeControl: mapTypeControl,
                    center: new google.maps.LatLng(0, 0),
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };

                if (useAdvanced) {
                    // A Map ID disables JSON styles; styling is done in Google Cloud.
                    mapOption.mapId = mapId;
                } else if (Array.isArray(styles)) {
                    mapOption.styles = styles;
                }

                if (typeof gestureHandling !== 'undefined' && gestureHandling === 'none') {
                    mapOption['gestureHandling'] = 'none';
                }

                // Generate map
                var map = new google.maps.Map($el[0], mapOption);

                // add a markers reference
                map.markers = [];

                // add markers
                $markers.each(function () {
                    if (useAdvanced) {
                        add_advanced_marker($(this), map);
                    } else {
                        add_marker($(this), map);
                    }
                });

                // center map
                center_map(map, zoom);

                return map;
            }

            // Web Animations API equivalents of the legacy DROP / BOUNCE animations.
            function animate_drop(el) {
                if (!el || typeof el.animate !== 'function') {
                    return null;
                }
                return el.animate([
                    {transform: 'translateY(-200px)', opacity: 0},
                    {transform: 'translateY(0)', opacity: 1}
                ], {duration: 500, easing: 'cubic-bezier(0.33, 1, 0.68, 1)'});
            }

            function animate_bounce(el) {
                if (!el || typeof el.animate !== 'function') {
                    return null;
                }
                return el.animate([
                    {transform: 'translateY(0)', easing: 'ease-out'},
                    {transform: 'translateY(-20px)', easing: 'ease-in'},
                    {transform: 'translateY(0)'}
                ], {duration: 700, iterations: Infinity});
            }

            // Prefer the 'gmp-click' DOM event; fall back to addListener('click') on older API versions.
            function on_marker_click(marker, fn) {
                if ('gmpClickable' in marker) {
                    marker.gmpClickable = true;
                    marker.addEventListener('gmp-click', fn);
                } else {
                    marker.addListener('click', fn);
                }
            }

            function add_advanced_marker($marker, map) {
                var animate = $marker.attr('data-animate');
                var position = {
                    lat: parseFloat($marker.attr('data-lat')),
                    lng: parseFloat($marker.attr('data-lng'))
                };
                var icon_img = $marker.attr('data-icon');
                var content;

                if (icon_img) {
                    var size = parseInt($marker.attr('data-icon-size'), 10);
                    content = document.createElement('img');
                    content.src = icon_img;
                    content.alt = '';
                    if (size > 0) {
                        content.style.width = size + 'px';
                        content.style.height = size + 'px';
                    }
                    content.style.display = 'block';
                } else if (google.maps.marker.PinElement) {
                    var pin = new google.maps.marker.PinElement();
                    // Newer API versions: PinElement is itself an element (.element is deprecated).
                    content = (typeof HTMLElement !== 'undefined' && pin instanceof HTMLElement) ? pin : pin.element;
                }

                var markerOptions = {
                    map: map,
                    position: position
                };
                if (content) {
                    markerOptions.content = content;
                }

                var marker = new google.maps.marker.AdvancedMarkerElement(markerOptions);
                var bounce = null;

                animate_drop(content);

                var startBounce = function () {
                    if (!bounce) {
                        bounce = animate_bounce(content);
                    }
                };
                var stopBounce = function () {
                    if (bounce) {
                        bounce.cancel();
                        bounce = null;
                    }
                };

                if (animate == 'animate-yes' && $marker.data('info-window') != 'yes') {
                    // start after the drop finishes
                    setTimeout(startBounce, 500);
                }

                if (animate == 'animate-yes') {
                    on_marker_click(marker, stopBounce);
                }

                // add to array
                map.markers.push(marker);

                // if marker has html elements, add it to an infoWindow
                var infoContent = $.trim($marker.html());
                if (infoContent) {
                    var infowindow = new google.maps.InfoWindow({
                        content: infoContent
                    });

                    if ($marker.data('info-window') == 'yes') {
                        infowindow.open({map: map, anchor: marker});
                    }
                    on_marker_click(marker, function () {
                        infowindow.open({map: map, anchor: marker});
                    });

                    if (animate == 'animate-yes') {
                        google.maps.event.addListener(infowindow, 'closeclick', startBounce);
                    }
                }
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
                var content = $.trim($marker.html());
                if (content) {
                    // make info window
                    var infowindow = new google.maps.InfoWindow({
                        content: content
                    });

                    // show info window when marker is clicked
                    if ($marker.data('info-window') == 'yes') {
                        infowindow.open(map, marker);
                    }
                    google.maps.event.addListener(marker, 'click', function () {
                        infowindow.open(map, marker);
                    });

                    if (animate == 'animate-yes') {
                        google.maps.event.addListener(infowindow, 'closeclick', function () {
                            marker.setAnimation(google.maps.Animation.BOUNCE);
                        });
                    }
                }
            }

            function center_map(map, zoom) {
                var bounds = new google.maps.LatLngBounds();

                // loop markers and create bounds
                $.each(map.markers, function (i, marker) {
                    var pos = marker.position;
                    if (!pos) {
                        return;
                    }
                    // Legacy Marker returns LatLng; AdvancedMarkerElement may return a literal.
                    var lat = typeof pos.lat === 'function' ? pos.lat() : pos.lat;
                    var lng = typeof pos.lng === 'function' ? pos.lng() : pos.lng;
                    bounds.extend(new google.maps.LatLng(lat, lng));
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
                $settings = $animatedHeading.data('settings');

            if ($heading.length) {
                $heading.animate({
                    opacity: 1
                }, 500);
            }

            EEA.release($scope, 'typed');

            if (!$animatedHeading.length || !$settings) {
                return;
            }

            if ($settings.layout === 'animated') {
                $animatedHeading.Morphext($settings);
            } else if ($settings.layout === 'typed') {
                var typed = new Typed($animatedHeading[0], $settings);
                EEA.keep($scope, 'typed', function () {
                    typed.destroy();
                });
            }
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
                var timeFormat = '%H:%M:%S';
                var offset_val = $settings.dynamic_timezone;

                if (timeNotation == '12h') {
                    timeFormat = '%I:%M:%S %p';
                }

                if (offset_val === '' || offset_val === null || typeof offset_val === 'undefined') {
                    return;
                }

                var options = {
                    format: timeFormat,
                    timeNotation: timeNotation, //'24h',
                    am_pm: true,
                    utc: true,
                    utc_offset: offset_val
                };

                EEA.release($scope, 'jclock');

                var $clock = $container.find('.eead-bh-current-time');
                if (!$clock.length) {
                    return;
                }
                $clock.jclock(options);

                // jclock keeps its timer on an implicit global `$this` wrapper of the (last) clock element.
                var clockRef = window.$this;
                if (clockRef && clockRef.jquery && clockRef[0] === $clock[$clock.length - 1]) {
                    EEA.keep($scope, 'jclock', function () {
                        clearTimeout(clockRef.timerID);
                    });
                }
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
                $expiry_message = $coundDown.find('template.eead-countdown-expiry').html() || '',
                $redirect_url = $coundDown.data('redirect-url') !== '' ? $coundDown.data('redirect-url') : '';

            EEA.release($scope, 'countdown');

            var $countdownItems = $coundDown.find('.eead-countdown-items');
            $countdownItems.countdown({
                end: function end() {
                    if ($expire_type == 'text') {
                        $coundDown.html($expiry_message);
                    } else if ($expire_type === 'url') {
                        if (elementorFrontend.isEditMode() == false) {
                            window.location.href = $redirect_url;
                        }
                    }
                }
            });

            EEA.keep($scope, 'countdown', function () {
                $countdownItems.each(function () {
                    var instance = $(this).data('countdown');
                    if (instance) {
                        instance.stop();
                        $(this).removeData('countdown');
                    }
                });
            });
        },

        counterBlock: function ($scope) {
            var $ele = $scope.find('.eead-counter-box');
            var $odometer = $ele.find('.eead-odometer');
            if (!$odometer.length) {
                return;
            }
            var decimals = (String($odometer.attr('data-count') || '').split('.')[1] || '').length;
            var format = $odometer.data('comma') == 'yes' ? '(,ddd)' : (decimals ? '(d)' : 'd');
            if (decimals) {
                format += '.' + new Array(decimals + 1).join('d');
            }
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
                var lgElement = document.getElementById($gallery_items.attr('id')),
                    lgOptions = $gallery_enabled ? {
                        selector: '.eead-magnific-link',
                        thumbnail: false,
                    } : {
                        selector: '.eead-magnific-link',
                        thumbnail: false,
                        counter: false,
                        controls: false,
                        loop: false,
                        mousewheel: false
                    };

                function initLightGallery() {
                    if (!lgElement) {
                        return;
                    }
                    var lgUid = lgElement.getAttribute('lg-uid');
                    if (lgUid && window.lgData && window.lgData[lgUid]) {
                        // destroy() restores this scroll position, so keep the current one.
                        window.lgData[lgUid].prevScrollTop = window.pageYOffset || document.documentElement.scrollTop;
                        window.lgData[lgUid].destroy(true);
                    }
                    lightGallery(lgElement, lgOptions);
                }

                initLightGallery();

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
                        searchRegex = new RegExp($this.val().replace(/[.*+?^${}()|[\]\\]/g, '\\$&'), 'gi');
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
                    initLightGallery();
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
            EEA.tabsBlock($scope, 'ht');
        },

        verticalTabsBlock: function ($scope) {
            EEA.tabsBlock($scope, 'vt');
        },

        // Shared by horizontal (ht) and vertical (vt) tabs.
        tabsBlock: function ($scope, prefix) {
            var $tabs = EEA.own($scope, '.eead-' + prefix + '-tab'),
                $contents = EEA.own($scope, '.eead-' + prefix + '-content'),
                activeTab = 'eead-' + prefix + '-active-tab',
                activeContent = 'eead-' + prefix + '-active-content';

            $tabs.each(function () {
                EEA.aria($(this), 'aria-selected', $(this).hasClass(activeTab) ? 'true' : 'false');
            });

            $tabs.off('.eeadTabs')
                .on('click.eeadTabs', function () {
                    var $tab_id = $(this).data('tabid');
                    if ($tab_id) {
                        $tabs.removeClass(activeTab);
                        EEA.aria($tabs, 'aria-selected', 'false');
                        $(this).addClass(activeTab);
                        EEA.aria($(this), 'aria-selected', 'true');

                        $contents.removeClass(activeContent);
                        $contents.filter('.eead-' + prefix + '-content-' + $tab_id).addClass(activeContent);
                    }
                })
                .on('keydown.eeadTabs', EEA.activateOnKey);
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
                    responsive: EEA.owlResponsive(
                        {items: params.items_mobile},
                        {items: params.items_tablet},
                        {items: params.items}
                    )
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
            var ns = EEA.ns($scope, 'Htl');
            $(window).off(ns).on('resize' + ns, EEA.guard($scope, ns, function () {
                equalizeHeights('.eead-htl-content', '.eead-htl-meta');
            }));
        },

        hotspotBlock: function ($scope) {
            $scope.find('.eead-open-onclick .eead-hotspot-item > a').on('click', function (e) {
                e.preventDefault();
                $(this).parent('.eead-hotspot-item').toggleClass('eead-active');
            });
        },

        imageComparison: function ($scope) {
            var $image_compare = $scope.find('.eead-image-compare');
            if ($image_compare.find('img').length < 2) {
                return;
            }
            var $settings = $image_compare.data('settings') || {};
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

            new ImageCompare($image_compare[0], options).mount();
        },

        imageAccordion: function ($scope) {
            var $accordionContainer = $scope.find('.eead-image-accordion-on-click');

            if ($accordionContainer.length > 0) {
                var $accordion = $scope.find('.eead-image-accordion-item');
                $accordion.on('click', function (e) {
                    var $this = $(this);
                    if ($this.hasClass('eead-tab-active')) {
                        return;
                    }
                    e.preventDefault();

                    $accordion.removeClass('eead-tab-active');
                    $this.addClass('eead-tab-active');
                });
            } else {
                $scope.find('.eead-image-accordion-on-hover').on('mouseenter', function () {
                    $(this).find('.eead-image-accordion-item.eead-tab-active').removeClass('eead-tab-active').addClass('eead-trigger');
                });

                $scope.find('.eead-image-accordion-on-hover').on('mouseleave', function () {
                    $(this).find('.eead-image-accordion-item.eead-trigger').addClass('eead-tab-active').removeClass('eead-trigger');
                });
            }
        },

        imageGallery: function ($scope, $) {
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
            if (!nav_el.length) {
                return;
            }

            var $top_offset = parseFloat(nav_el.data('top-offset')) || 0,
                $scroll_speed = nav_el.data('scroll-speed'),
                $scroll_wheel = nav_el.data('scroll-wheel'),
                $scroll_touch = nav_el.data('scroll-touch'),
                $scroll_keys = nav_el.data('scroll-keys'),
                $links = nav_el.find('.eead-one-page-nav-item a'),
                ns = EEA.ns($scope, 'Opn'),
                isEditMode = elementorFrontend.isEditMode(),
                ticking = false;

            // Remove handlers left by a previous init of this widget.
            $(window).off(ns);
            $(document).off(ns);

            function getTarget($link) {
                var rowId = $link.data('row-id');
                if (rowId === undefined || rowId === null) {
                    return null;
                }
                rowId = String(rowId).replace(/^#/, '');
                return rowId ? document.getElementById(rowId) : null;
            }

            function activeItem() {
                return nav_el.find('.eead-one-page-nav-item.active').first();
            }

            function goPrev() {
                var $prev = activeItem().prev();
                if ($prev.length > 0) {
                    $prev.find('a').trigger('click');
                }
            }

            function goNext() {
                var $next = activeItem().next();
                if ($next.length > 0) {
                    $next.find('a').trigger('click');
                }
            }

            $links.off('click' + ns).on('click' + ns, function (e) {
                e.preventDefault();
                e.stopPropagation();
                var target = getTarget($(this));
                if (!target) {
                    return false;
                }
                if ($('html, body').is(':animated')) {
                    return false;
                }

                $('html, body').animate({
                    scrollTop: $(target).offset().top - $top_offset
                }, $scroll_speed);

                nav_el.find('.eead-one-page-nav-item').removeClass('active');
                $(this).parent().addClass('active');
                return false;
            });

            function updateDot() {
                var winHeight = $(window).height(),
                    scrollTop = $(window).scrollTop();

                $links.each(function () {
                    var target = getTarget($(this));
                    if (!target) {
                        return;
                    }
                    var $target = $(target),
                        top = $target.offset().top,
                        inView = (top - winHeight / 2 < scrollTop) && (top >= scrollTop || top + $target.height() - winHeight / 2 > scrollTop);
                    $(this).parent().toggleClass('active', inView);
                });
            }

            function requestUpdateDot() {
                if (ticking) {
                    return;
                }
                ticking = true;
                var raf = window.requestAnimationFrame || function (callback) {
                    return setTimeout(callback, 16);
                };
                raf(function () {
                    ticking = false;
                    updateDot();
                });
            }

            updateDot();

            $(window).on('scroll' + ns, EEA.guard($scope, ns, requestUpdateDot));

            // Don't hijack wheel/touch/keys inside the Elementor editor.
            if (isEditMode) {
                return;
            }

            // When Mouse Wheel Scrolled
            if ($scroll_wheel === 'on') {
                var lastAnimation = 0,
                    quietPeriod = 500,
                    animationTime = 800,
                    startY = null;

                $(document).on('wheel' + ns, EEA.guard($scope, ns, function (e) {
                    var deltaY = e.originalEvent ? e.originalEvent.deltaY : 0;
                    if (!deltaY) {
                        return;
                    }

                    var timeNow = new Date().getTime();
                    if (timeNow - lastAnimation < quietPeriod + animationTime) {
                        return;
                    }

                    if (!$('html,body').is(':animated')) {
                        if (deltaY > 0) {
                            goNext();
                        } else {
                            goPrev();
                        }
                    }
                    lastAnimation = timeNow;
                }));

                // When Screen Touch swiped
                if ($scroll_touch === 'on') {
                    $(document).on('touchstart' + ns, EEA.guard($scope, ns, function (e) {
                        var touches = e.originalEvent.touches;
                        if (touches && touches.length) {
                            startY = touches[0].screenY;
                        }
                    })).on('touchmove' + ns, EEA.guard($scope, ns, function (e) {
                        if ($('html,body').is(':animated')) {
                            e.preventDefault();
                        }
                    })).on('touchend' + ns, EEA.guard($scope, ns, function (e) {
                        var touches = e.originalEvent.changedTouches;
                        if (startY === null || !touches || !touches.length) {
                            return;
                        }
                        var deltaY = startY - touches[0].screenY;
                        startY = null;

                        // Ignore taps and small movements.
                        if (Math.abs(deltaY) < 50) {
                            return;
                        }

                        if (deltaY < 0) {
                            // screen swipe up.
                            goPrev();
                        } else {
                            // screen swipe down.
                            goNext();
                        }
                    }));
                }
            }

            // Key Press Scroll
            if ($scroll_keys === 'on') {
                $(document).on('keydown' + ns, EEA.guard($scope, ns, function (e) {
                    var tag = e.target.tagName ? e.target.tagName.toLowerCase() : '';
                    if (tag === 'input' || tag === 'textarea' || tag === 'select' || e.target.isContentEditable) {
                        return;
                    }
                    switch (e.which) {
                        case 38:
                        case 33:
                            goPrev();
                            break;
                        case 40:
                        case 34:
                            goNext();
                            break;
                        default:
                            return;
                    }
                }));
            }
        },

        Lottie: function ($scope) {
            var $container = $scope.find('.eead-lottie');

            EEA.release($scope, 'lottie');

            if (!$container.length) {
                return;
            }

            var settings = JSON.parse($container.attr('data-settings') || '{}'),
                action = settings.autoplay ? settings.action : settings.action_alt;

            if (!settings.path) {
                return;
            }

            let animation = lottie.loadAnimation({
                container: $container[0],
                renderer: settings.renderer,
                autoplay: settings.autoplay,
                path: settings.path,
                loop: true,
            });

            EEA.keep($scope, 'lottie', function () {
                animation.destroy();
            });

            $container.off('.eeadLottie');

            animation.setDirection(settings.reverse);
            animation.setSpeed(settings.speed);

            switch (action) {
                case 'play':
                    $container.on('mouseenter.eeadLottie', function () {
                        animation.play();
                    });
                    $container.on('mouseleave.eeadLottie', function () {
                        animation.pause();
                    });
                    break;
                case 'pause':
                    $container.on('mouseenter.eeadLottie', function () {
                        animation.pause();
                    });
                    $container.on('mouseleave.eeadLottie', function () {
                        animation.play();
                    });
                    break;
                case 'reverse':
                    var direction = settings.reverse == '1' ? '-1' : '1';
                    $container.on('mouseenter.eeadLottie', function () {
                        animation.pause();
                        setTimeout(function () {
                            animation.setDirection(direction);
                            animation.play();
                        }, 200);
                    });
                    $container.on('mouseleave.eeadLottie', function () {
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

            var ns = EEA.ns($scope, 'ScrollImg');

            resizeVideo();

            // Re-measure once the device frame image (and the page) has loaded.
            $frame.off('load' + ns).on('load' + ns, resizeVideo);
            $(window).off(ns);
            if (document.readyState !== 'complete') {
                $(window).one('load' + ns, resizeVideo);
            }

            $(window).on('resize' + ns, EEA.guard($scope, ns, resizeVideo));

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
                    responsive: EEA.owlResponsive({
                        items: params.items_mobile,
                        margin: params.margin_mobile,
                        stagePadding: params.stagepadding_mobile
                    }, {
                        items: params.items_tablet,
                        margin: params.margin_tablet,
                        stagePadding: params.stagepadding_tablet
                    }, {
                        items: params.items,
                        margin: params.margin,
                        stagePadding: params.stagepadding
                    })
                });
            }
        },

        popupModal: function ($scope) {
            var $open = $scope.find('.eead-popup-modal-trigger-btn');
            if ($open.hasClass('eead-popup-modal-trigger-selector')) {
                var $trigger = $open.attr('data-selector');
                var $triggers;
                try {
                    $triggers = $(document).find($trigger);
                } catch (e) {
                    return;
                }
                var popupNs = '.eeadPopup' + $scope.data('id');
                $triggers.off('click' + popupNs).on('click' + popupNs, function (e) {
                    e.preventDefault();
                    var $id = $open.data('id');
                    MicroModal.show('eead-popup-modal-' + $id, {
                        awaitOpenAnimation: true,
                        awaitCloseAnimation: true,
                        openClass: 'eead-open-modal',
                        disableScroll: true
                    })
                });
            } else {
                $open.on('click', function (e) {
                    e.preventDefault();
                    var $id = $(this).data('id');
                    MicroModal.show('eead-popup-modal-' + $id, {
                        awaitOpenAnimation: true,
                        awaitCloseAnimation: true,
                        openClass: 'eead-open-modal',
                        disableScroll: true
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
                            }, 1000);
                        }, delay_time);
                        this.destroy();
                    }, {
                        offset: '90%',
                    });
                });
            }
        },

        toggleBlock: function ($scope, $) {
            var $container = EEA.own($scope, '.eead-toggle-container'),
                $toggle_switch = EEA.own($scope, '.eead-toggle-switch-checkbox'),
                $label_primary = EEA.own($scope, '.eead-toggle-label-primary'),
                $label_secondary = EEA.own($scope, '.eead-toggle-label-secondary');

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
            var $active_tab = $scope.find('.eead-switcher-active-tab');

            if ($active_tab.length) {
                $scope.find('.eead-switcher-slider').css({
                    'width': $active_tab.outerWidth() + 'px',
                    'left': $active_tab.position().left + 'px'
                });
            }

            $scope.find('.eead-switcher-tab').on('click', function () {
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

            var playerEl = $scope.find('#eead-player-' + $scope.data('id'))[0];
            if (!playerEl) {
                return;
            }

            var player = new Plyr(playerEl, {
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

            $scope.find('.eead-sticky-player-close').on('click', function () {
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

                var ns = EEA.ns($scope, 'StickyVideo');
                $(window).off(ns);

                $(window).on('resize' + ns, EEA.guard($scope, ns, function () {
                    videoContainer.css('height', stickyVideo.height() + 'px');
                    var stickyPoint = videoContainer.offset().top + videoContainer.height();
                    stickyVideo.attr('data-sticky-point', stickyPoint);
                }));

                $(window).on('scroll' + ns, EEA.guard($scope, ns, function () {
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
                }));
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
                overlay.off('.eead-video-player').on('keydown.eead-video-player', EEA.activateOnKey);
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

            var ns = EEA.ns($scope, 'VideoPlayer');
            $(window).off(ns).on('resize' + ns, EEA.guard($scope, ns, resizeVideo));

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
                    autoplaySpeed: params.pause || 3000,
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
                    responsive: EEA.owlResponsive({
                        items: params.items_mobile,
                        margin: params.margin_mobile,
                        stagePadding: params.stagepadding_mobile
                    }, {
                        items: params.items_tablet,
                        margin: params.margin_tablet,
                        stagePadding: params.stagepadding_tablet
                    }, {
                        items: params.items,
                        margin: params.margin,
                        stagePadding: params.stagepadding
                    })
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
                    responsive: EEA.owlResponsive({
                        items: params.items_mobile,
                        margin: params.margin_mobile,
                        stagePadding: params.stagepadding_mobile
                    }, {
                        items: params.items_tablet,
                        margin: params.margin_tablet,
                        stagePadding: params.stagepadding_tablet
                    }, {
                        items: params.items,
                        margin: params.margin,
                        stagePadding: params.stagepadding
                    })
                });
            }
        },

        twitterFeed: function ($scope) {
            if (typeof twttr !== 'undefined' && twttr.widgets) {
                twttr.widgets.load($scope[0]);
            }
        }
    };

    $(window).on('elementor/frontend/init', EEA.init);

}(jQuery));