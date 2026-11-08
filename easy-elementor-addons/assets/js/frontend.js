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
                'eead-drop-bar.default': EEA.dropBar,
                'eead-countdown.default': EEA.countdown,
                'eead-counter.default': EEA.counterBlock,
                'eead-filterable-gallery.default': EEA.filterableGallery,
                'eead-horizontal-timeline.default': EEA.horizontalTimelineCarousel,
                'eead-hotspot.default': EEA.hotspotBlock,
                'eead-image-comparison.default': EEA.imageComparison,
                'eead-image-accordion.default': EEA.imageAccordion,
                'eead-image-gallery.default': EEA.imageGallery,
                'eead-image-hover-effect.default': EEA.imageHoverEffect,
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
                'eead-vertical-timeline.default': EEA.verticalTimeline,
                'eead-sticky-video.default': EEA.stickyVideo,
                'eead-video-player.default': EEA.videoPlayer,
                'eead-slider.default': EEA.sliderBlock,
                'eead-social-share.default': EEA.socialShare,
                'eead-team-carousel.default': EEA.teamCarousel,
                'eead-testimonial-carousel.default': EEA.testimonialCarousel,
                'eead-twitter-feed.default': EEA.twitterFeed,
                'eead-marquee.default': EEA.textMarquee,
                'eead-data-table.default': EEA.dataTable,
                'eead-table-of-contents.default': EEA.tableOfContents,
                'eead-scroll-text-reveal.default': EEA.scrollTextReveal,
                'eead-whatsapp-chat.default': EEA.whatsappChat,
                'eead-appearing-image.default': EEA.appearingImage,
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

        /**
         * Weekday (0 = Sunday) and minute of the day in a timezone: an IANA name
         * via Intl when possible, else a fixed offset in minutes.
         */
        zonedNow: function (tz, offset) {
            var date = new Date();
            if (tz && /\//.test(tz) && window.Intl) {
                try {
                    var parts = {};
                    new Intl.DateTimeFormat('en-US', {timeZone: tz, weekday: 'short', hour: 'numeric', minute: 'numeric', hourCycle: 'h23'})
                        .formatToParts(date).forEach(function (p) {
                            parts[p.type] = p.value;
                        });
                    return {
                        day: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'].indexOf(parts.weekday),
                        minute: (parseInt(parts.hour, 10) % 24) * 60 + parseInt(parts.minute, 10)
                    };
                } catch (err) {
                }
            }
            var shifted = new Date(date.getTime() + (parseFloat(offset) || 0) * 60000);
            return {day: shifted.getUTCDay(), minute: shifted.getUTCHours() * 60 + shifted.getUTCMinutes()};
        },

        /** Mirrors BusinessHour::is_open_at(): an end at or before the start runs past midnight. */
        isOpenAt: function (schedule, day, minute) {
            var today = schedule[day] || [], yesterday = schedule[(day + 6) % 7] || [], i;
            for (i = 0; i < today.length; i++) {
                if (minute >= today[i][0] && (today[i][1] > today[i][0] ? minute < today[i][1] : true)) {
                    return true;
                }
            }
            for (i = 0; i < yesterday.length; i++) {
                if (yesterday[i][1] <= yesterday[i][0] && minute < yesterday[i][1]) {
                    return true;
                }
            }
            return false;
        },

        /** Say a short status message to screen readers (one shared polite live region). */
        announce: function (message) {
            var region = document.getElementById('eead-live-region');
            if (!region) {
                region = document.createElement('div');
                region.id = 'eead-live-region';
                region.className = 'elementor-screen-only';
                region.setAttribute('aria-live', 'polite');
                document.body.appendChild(region);
            }
            region.textContent = '';
            setTimeout(function () {
                region.textContent = message;
            }, 50);
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

        /**
         * Owl renders its arrows as role="presentation" buttons holding only an
         * icon, and its dots as empty buttons: give them names screen readers can use.
         */
        owlA11y: function ($ele) {
            var t = window.eeadFrontend || {};
            var label = function () {
                $ele.find('.owl-prev').removeAttr('role').attr('aria-label', t.prev || 'Previous');
                $ele.find('.owl-next').removeAttr('role').attr('aria-label', t.next || 'Next');
                $ele.find('.owl-dot').each(function (i) {
                    $(this).attr('aria-label', (t.goTo || 'Go to slide %d').replace('%d', i + 1));
                });
            };
            label();
            $ele.off('refreshed.owl.carousel.eeadA11y').on('refreshed.owl.carousel.eeadA11y', label);
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
                oneAtATime = EEA.own($scope, '.eead-accordion-container').data('one-at-a-time') === 'yes',
                ns = EEA.ns($scope, 'Accordion');

            if (!$accordions.length) {
                return;
            }

            function title($item) {
                return $item.children('.eead-accordion-title');
            }

            function setState($item, open) {
                var $content = $item.children('.eead-accordion-content').stop(true, true);
                $item.toggleClass('eead-open', open);
                EEA.aria(title($item), 'aria-expanded', open ? 'true' : 'false');
                if (open) {
                    $content.slideDown();
                } else {
                    $content.slideUp();
                }
            }

            function open($item) {
                if (oneAtATime) {
                    $item.siblings('.eead-open').each(function () {
                        setState($(this), false);
                    });
                }
                setState($item, true);
            }

            $accordions.each(function () {
                EEA.aria(title($(this)), 'aria-expanded', $(this).hasClass('eead-open') ? 'true' : 'false');
            });

            $accordions.children('.eead-accordion-title')
                .off('.eeadAccordion')
                .on('click.eeadAccordion', function () {
                    var $item = $(this).closest('.eead-each-accordion');
                    if (!$item.hasClass('eead-open')) {
                        open($item);
                    } else {
                        setState($item, false);
                    }
                })
                .on('keydown.eeadAccordion', EEA.activateOnKey);

            /* Deep links: #item-id opens that item (on load and when the hash changes). */
            function fromHash() {
                var hash = window.location.hash.slice(1),
                    $item;
                if (!hash) {
                    return;
                }
                try {
                    hash = decodeURIComponent(hash);
                } catch (err) {
                    return;
                }
                $item = $accordions.filter(function () {
                    return this.id === hash;
                });
                if ($item.length && !$item.hasClass('eead-open')) {
                    open($item);
                }
            }

            if ($accordions.filter('[id]').length) {
                fromHash();
                $(window).off(ns).on('hashchange' + ns, EEA.guard($scope, ns, fromHash));
            }
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
                var mapType = $el.attr('data-map-type');
                var mapOption = {
                    zoom: zoom,
                    scrollwheel: scrollwheel,
                    zoomControl: zoomControl,
                    fullscreenControl: fullscreenControl,
                    streetViewControl: streetViewControl,
                    mapTypeControl: mapTypeControl,
                    center: new google.maps.LatLng(0, 0),
                    mapTypeId: /^(roadmap|satellite|hybrid|terrain)$/.test(mapType) ? mapType : 'roadmap'
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
                    if (!isFinite(parseFloat($(this).attr('data-lat'))) || !isFinite(parseFloat($(this).attr('data-lng')))) {
                        return;
                    }
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
                    var size = parseInt($marker.attr('data-icon-size'), 10) || 50;
                    content = document.createElement('img');
                    content.src = icon_img;
                    content.alt = '';
                    content.style.width = size + 'px';
                    content.style.height = size + 'px';
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
                if ($marker.attr('data-title')) {
                    markerOptions.title = $marker.attr('data-title');
                }
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

                var icon;
                if (icon_img) {
                    // An emptied size slider would scale the pin to 0x0.
                    var size = parseInt($marker.attr('data-icon-size'), 10) || 50;
                    icon = {
                        url: icon_img,
                        scaledSize: new google.maps.Size(size, size)
                    };
                }

                // create marker
                var marker = new google.maps.Marker({
                    position: latlng,
                    map: map,
                    icon: icon,
                    title: $marker.attr('data-title') || undefined,
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

                if (!map.markers.length) {
                    return;
                }

                // One marker, or several on the same spot: fitBounds on a single
                // point would zoom all the way in, so use the Zoom setting instead.
                if (map.markers.length == 1 || bounds.getNorthEast().equals(bounds.getSouthWest())) {
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
            EEA.release($scope, 'rotate');

            if (!$animatedHeading.length || !$settings) {
                return;
            }

            if ($settings.layout === 'animated') {
                // Words go in as text, never HTML: they arrive decoded from JSON.
                var words = $.isArray($settings.words) ? $settings.words : [];
                var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                var animation = reduce ? '' : ($settings.animation || '');
                var index = -1;
                var showWord = function () {
                    index = (index + 1) % words.length;
                    $animatedHeading.empty().append($('<span class="animated"></span>').addClass(animation).text(words[index]));
                };

                if (!words.length) {
                    return;
                }
                showWord();
                if (words.length > 1) {
                    var timer = setInterval(showWord, parseInt($settings.speed, 10) || 2500);
                    EEA.keep($scope, 'rotate', function () {
                        clearInterval(timer);
                    });
                }
            } else if ($settings.layout === 'typed') {
                $settings.showCursor = $settings.showCursor !== 'no';
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

            EEA.release($scope, 'bhStatus');
            if ($.isArray($settings.schedule) || $.isPlainObject($settings.schedule)) {
                var refreshStatus = function () {
                    var now = EEA.zonedNow($settings.tz, $settings.offset);
                    var open = EEA.isOpenAt($settings.schedule, now.day, now.minute);
                    $container.find('.eead-bh-open-status')
                        .toggleClass('eead-bh-is-open', open).toggleClass('eead-bh-is-closed', !open)
                        .each(function () {
                            $(this).children('.eead-bh-status-open').prop('hidden', !open);
                            $(this).children('.eead-bh-status-closed').prop('hidden', open);
                        });
                    $container.find('.eead-business-hour-row[data-day]').each(function () {
                        $(this).toggleClass('active-day', +$(this).attr('data-day') === now.day);
                    });
                };
                refreshStatus();
                var statusTimer = setInterval(refreshStatus, 30000);
                EEA.keep($scope, 'bhStatus', function () {
                    clearInterval(statusTimer);
                });
            }

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
            if (!container.length) {
                return;
            }

            var percentage = Math.max(0, Math.min(100, parseFloat(container.attr('data-number')) || 0)),
                $bar = container.find('circle:nth-child(2)'),
                $value = container.find('.eead-cb-value'),
                reduce = EEA.reducedMotion(),
                countUp = container.attr('data-count') === 'yes' && !reduce,
                decimals = (String(percentage).split('.')[1] || '').length;

            EEA.release($scope, 'cpb');

            // pathLength="100": the offset is simply what is left of 100.
            var fill = function () {
                $bar.css('stroke-dashoffset', 100 - percentage);
                if (!countUp) {
                    return;
                }
                var duration = parseFloat(container.css('--eead-cb-duration')) || 1000,
                    start = null,
                    frame = function (now) {
                        start = start || now;
                        var t = Math.min(1, (now - start) / duration),
                            eased = 1 - Math.pow(1 - t, 3);
                        $value.text((percentage * eased).toFixed(decimals));
                        if (t < 1) {
                            raf = window.requestAnimationFrame(frame);
                        }
                    },
                    raf = window.requestAnimationFrame(frame);
                EEA.keep($scope, 'cpb', function () {
                    window.cancelAnimationFrame(raf);
                });
            };

            if (countUp) {
                $value.text((0).toFixed(decimals));
            }

            if (reduce || typeof container.waypoint !== 'function') {
                countUp = false;
                $value.text(percentage);
                fill();
                return;
            }

            container.waypoint(function () {
                setTimeout(fill, 200);
                this.destroy();
            }, {
                offset: '90%',
            });
        },

        countdown: function ($scope) {
            var $countdown = $scope.find('.eead-countdown'),
                $items = $countdown.find('.eead-countdown-items'),
                expireType = $countdown.attr('data-expire-type') || '',
                redirectUrl = $countdown.attr('data-redirect-url') || '',
                expiryMessage = $countdown.find('template.eead-countdown-expiry').html() || '',
                editMode = window.elementorFrontend && elementorFrontend.isEditMode(),
                evergreen = parseInt($countdown.attr('data-evergreen'), 10),
                end;

            EEA.release($scope, 'countdown');

            if (!$items.length) {
                return;
            }

            var restart = $countdown.is('[data-evergreen]') && $countdown.attr('data-restart') === 'yes' && evergreen > 0,
                key = 'eead-countdown-' + $countdown.attr('data-id') + '-' + evergreen,
                remember = function () {
                    if (!editMode) {
                        try {
                            window.localStorage.setItem(key, String(end));
                        } catch (err) {
                        }
                    }
                };

            if ($countdown.is('[data-evergreen]')) {
                // Per visitor: the deadline is remembered in the browser, keyed by
                // widget and length so a new length starts afresh. Not in the editor.
                var stored = null;
                if (!editMode) {
                    try {
                        stored = parseInt(window.localStorage.getItem(key), 10);
                    } catch (err) {
                    }
                }
                end = stored > 0 ? stored : Date.now() + evergreen * 1000;
                if (end <= Date.now() && restart) {
                    end = Date.now() + evergreen * 1000;
                }
                remember();
            } else {
                end = Date.parse($items.attr('data-date') || '');
            }

            if (!end || isNaN(end)) {
                return;
            }

            // The largest shown unit takes everything above it, so with Days
            // turned off 2 days 3 hours reads 51 hours, not 3.
            var units = [];
            $.each([['days', 86400], ['hours', 3600], ['minutes', 60], ['seconds', 1]], function (i, unit) {
                var $el = $items.find('[data-' + unit[0] + ']');
                if ($el.length) {
                    units.push({$el: $el, size: unit[1]});
                }
            });

            var timer = null;
            var finish = function () {
                if (expireType === 'text') {
                    $countdown.html(expiryMessage);
                } else if (expireType === 'hide') {
                    if (editMode) {
                        $countdown.css('opacity', 0.4);
                    } else {
                        $countdown.hide();
                    }
                } else if (expireType === 'url' && redirectUrl && !editMode) {
                    window.location.href = redirectUrl;
                }
            };
            // Remaining time is read from the clock on every tick, so a throttled
            // background tab doesn't drift.
            var tick = function () {
                var left = Math.max(0, Math.floor((end - Date.now()) / 1000)),
                    rest = left;
                $.each(units, function (i, unit) {
                    var value = Math.floor(rest / unit.size);
                    rest -= value * unit.size;
                    unit.$el.text(value < 10 ? '0' + value : value);
                });
                if (left <= 0 && restart) {
                    end = Date.now() + evergreen * 1000;
                    remember();
                    return evergreen;
                }
                if (left <= 0) {
                    clearInterval(timer);
                    finish();
                }
                return left;
            };

            if (tick() > 0) {
                timer = setInterval(tick, 1000);
                EEA.keep($scope, 'countdown', function () {
                    clearInterval(timer);
                });
            }
        },

        dropBar: function ($scope) {
            var button = EEA.own($scope, '.eead-dropbar-button')[0],
                drop = EEA.own($scope, '.eead-drop')[0],
                ns = EEA.ns($scope, 'Drop');
            EEA.release($scope, 'drop');
            if (!button || !drop || !window.UIkit) {
                return;
            }

            button.setAttribute('role', 'button');
            button.setAttribute('aria-controls', drop.id);

            // Enter/Space open it from the keyboard too (hover mode has no key path).
            $(button).off(ns).on('keydown' + ns, function (e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    var component = UIkit.drop(drop);
                    if (component) {
                        if (drop.classList.contains('uk-open')) {
                            component.hide(false);
                        } else {
                            component.show();
                        }
                    }
                }
            });

            // UIkit's flip doesn't keep the panel on narrow screens, and it places
            // it again on every scroll and resize; each time it does, nudge it back
            // inside the viewport. The nudge itself fits, so it doesn't loop.
            var clamp = function () {
                var rect = drop.getBoundingClientRect(),
                    gap = 8,
                    vw = document.documentElement.clientWidth,
                    shift = 0;
                if (rect.right > vw - gap) {
                    shift = vw - gap - rect.right;
                }
                if (rect.left + shift < gap) {
                    shift = gap - rect.left;
                }
                if (shift) {
                    drop.style.left = (parseFloat(getComputedStyle(drop).left) + shift) + 'px';
                }
            };
            var observer = new MutationObserver(function () {
                if (drop.classList.contains('uk-open')) {
                    clamp();
                }
            });
            observer.observe(drop, {attributes: true, attributeFilter: ['style', 'class']});
            EEA.keep($scope, 'drop', function () {
                observer.disconnect();
            });
        },

        counterBlock: function ($scope) {
            var $ele = $scope.find('.eead-counter-box');
            var $odometer = $ele.find('.eead-odometer');
            if (!$odometer.length || typeof Odometer === 'undefined') {
                return;
            }
            var decimals = (String($odometer.attr('data-count') || '').split('.')[1] || '').length;
            // Odometer format: the character in brackets groups thousands, the one after is the decimal mark.
            var separator = $odometer.attr('data-separator') || ',';
            var radix = separator === '.' ? ',' : '.';
            // A plain space collapses to nothing inside Odometer's inline-block mark.
            separator = separator === ' ' ? '\u00a0' : separator;
            var format = $odometer.attr('data-comma') === 'yes' ? '(' + separator + 'ddd)' : (decimals ? '(d)' : 'd');
            if (decimals) {
                format += radix + new Array(decimals + 1).join('d');
            }
            var still = EEA.reducedMotion() || typeof $ele.waypoint !== 'function';
            var od = new Odometer({
                el: $odometer[0],
                format: format,
                duration: parseInt($odometer.attr('data-duration'), 10) || 2000,
                value: still ? $odometer.data('count') : $odometer.data('start')
            });
            var run = function () {
                od.update($odometer.data('count'));
            };

            if (still) {
                return;
            }
            $ele.waypoint(function () {
                setTimeout(run, 150);
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

        verticalTimeline: function ($scope) {
            var root = EEA.own($scope, '.eead-vertical-timeline')[0];
            if (!root) {
                return;
            }
            var progress = root.classList.contains('eead-vt-progress-on'),
                reveal = root.classList.contains('eead-vt-reveal-on'),
                inner = root.querySelector('.eead-vt-inner'),
                items = [].slice.call(root.querySelectorAll('.eead-vt-each-wrap')),
                ns = EEA.ns($scope, 'Timeline');

            if (reveal) {
                if (elementorFrontend.isEditMode() || EEA.reducedMotion() || !('IntersectionObserver' in window)) {
                    items.forEach(function (item) {
                        item.classList.add('eead-vt-in');
                    });
                } else {
                    root.classList.add('eead-vt-reveal-ready');
                    var io = new IntersectionObserver(function (entries) {
                        entries.forEach(function (entry) {
                            if (entry.isIntersecting) {
                                entry.target.classList.add('eead-vt-in');
                                io.unobserve(entry.target);
                            }
                        });
                    }, {rootMargin: '0px 0px -10% 0px'});
                    items.forEach(function (item) {
                        io.observe(item);
                    });
                }
            }

            if (progress && inner) {
                var ticking = false;
                // The line is filled down to the middle of the viewport.
                var update = function () {
                    ticking = false;
                    var box = inner.getBoundingClientRect(),
                        mark = window.innerHeight / 2,
                        pct = box.height ? Math.max(0, Math.min(1, (mark - box.top) / box.height)) : 0;
                    root.style.setProperty('--eead-vt-progress', (pct * 100).toFixed(2) + '%');
                    items.forEach(function (item) {
                        var point = item.querySelector('.eead-vt-point') || item,
                            r = point.getBoundingClientRect();
                        item.classList.toggle('eead-vt-passed', r.top + r.height / 2 <= mark);
                    });
                };
                var request = function () {
                    if (!ticking) {
                        ticking = true;
                        window.requestAnimationFrame(update);
                    }
                };
                $(window).off(ns).on('scroll' + ns + ' resize' + ns + ' load' + ns, EEA.guard($scope, ns, request));
                update();
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
                activeContent = 'eead-' + prefix + '-active-content',
                ns = EEA.ns($scope, 'Tabs' + prefix),
                vertical = prefix === 'vt';

            if (!$tabs.length) {
                return;
            }

            // One tab stop for the tab list (WAI-ARIA tabs): only the selected tab is tabbable.
            var roving = $tabs.filter('[aria-controls]').length > 0;

            function activate($tab, focus) {
                var id = $tab.data('tabid');
                if (!id) {
                    return;
                }
                $tabs.removeClass(activeTab);
                EEA.aria($tabs, 'aria-selected', 'false');
                $tab.addClass(activeTab);
                EEA.aria($tab, 'aria-selected', 'true');
                if (roving) {
                    $tabs.attr('tabindex', '-1');
                    $tab.attr('tabindex', '0');
                }
                if (focus) {
                    $tab.trigger('focus');
                }

                $contents.removeClass(activeContent);
                $contents.filter('.eead-' + prefix + '-content-' + id).addClass(activeContent);
                // Sliders, carousels and maps in a hidden panel measured 0 wide; let them re-measure.
                setTimeout(function () {
                    window.dispatchEvent(new Event('resize'));
                }, 30);
            }

            $tabs.each(function () {
                EEA.aria($(this), 'aria-selected', $(this).hasClass(activeTab) ? 'true' : 'false');
            });

            $tabs.off('.eeadTabs')
                .on('click.eeadTabs', function () {
                    activate($(this), false);
                })
                .on('keydown.eeadTabs', function (e) {
                    var index = $tabs.index(this), next = null,
                        prevKey = vertical ? 'ArrowUp' : 'ArrowLeft',
                        nextKey = vertical ? 'ArrowDown' : 'ArrowRight';
                    if (e.key === nextKey) {
                        next = (index + 1) % $tabs.length;
                    } else if (e.key === prevKey) {
                        next = (index - 1 + $tabs.length) % $tabs.length;
                    } else if (e.key === 'Home') {
                        next = 0;
                    } else if (e.key === 'End') {
                        next = $tabs.length - 1;
                    }
                    if (next !== null) {
                        e.preventDefault();
                        activate($tabs.eq(next), true);
                        return;
                    }
                    EEA.activateOnKey.call(this, e);
                });

            // Deep links: #tab-id opens that tab and brings it into view.
            function fromHash() {
                var hash = decodeURIComponent((window.location.hash || '').slice(1)),
                    $panel;
                if (!hash) {
                    return;
                }
                $panel = $contents.filter(function () {
                    return this.getAttribute('data-hash') === hash;
                });
                if ($panel.length) {
                    activate($tabs.filter('[aria-controls="' + $panel.attr('id') + '"]'), false);
                    $scope[0].scrollIntoView({block: 'start'});
                }
            }

            if ($contents.filter('[data-hash]').length) {
                fromHash();
                $(window).off(ns).on('hashchange' + ns, EEA.guard($scope, ns, fromHash));
            }
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
                EEA.owlA11y($ele);
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
            var $wrap = $scope.find('.eead-hotspot'),
                $items = $wrap.find('.eead-hotspot-item'),
                onClick = $wrap.hasClass('eead-open-onclick'),
                ns = EEA.ns($scope, 'Hotspot');

            if (!$items.length) {
                return;
            }

            // Keep the tooltip on screen: left/right tooltips that don't fit go
            // below the spot, others slide sideways with the arrow still on the spot.
            function place($item) {
                var content = $item.children('.eead-hotspot-content')[0],
                    gap = 8, vw, pos, rect, shift = 0;
                if (!content) {
                    return;
                }
                pos = content.getAttribute('data-pos') || '';
                content.className = content.className.replace(/\beead-(top|bottom|left|right)-(left|middle|right)\b/g, '').trim() + ' eead-' + pos;
                content.style.removeProperty('--eead-hs-shift');
                vw = document.documentElement.clientWidth;
                rect = content.getBoundingClientRect();
                if (/^(left|right)-middle$/.test(pos) && (rect.left < gap || rect.right > vw - gap)) {
                    content.className = content.className.replace('eead-' + pos, 'eead-bottom-middle');
                    rect = content.getBoundingClientRect();
                }
                if (rect.right > vw - gap) {
                    shift = vw - gap - rect.right;
                }
                if (rect.left + shift < gap) {
                    shift = gap - rect.left;
                }
                if (shift) {
                    content.style.setProperty('--eead-hs-shift', Math.round(shift) + 'px');
                }
            }

            function setOpen($item, open) {
                if (open) {
                    place($item);
                }
                $item.toggleClass('eead-active', open);
                EEA.aria($item.children('a'), 'aria-expanded', open ? 'true' : 'false');
            }

            $items.off(ns);
            $items.on('mouseenter' + ns + ' focusin' + ns, function () {
                place($(this));
                if (!onClick) {
                    EEA.aria($(this).children('a'), 'aria-expanded', 'true');
                }
            }).on('mouseleave' + ns + ' focusout' + ns, function () {
                if (!onClick) {
                    EEA.aria($(this).children('a'), 'aria-expanded', 'false');
                }
            });

            $items.children('a').on('click' + ns, function (e) {
                e.preventDefault();
                if (!onClick) {
                    return;
                }
                var $item = $(this).parent('.eead-hotspot-item'),
                    open = !$item.hasClass('eead-active');
                // One open at a time.
                $items.not($item).each(function () {
                    setOpen($(this), false);
                });
                setOpen($item, open);
            });

            if (onClick) {
                // Click outside or Escape closes the open tooltip.
                $(document).off(ns).on('click' + ns, EEA.guard($scope, ns, function (e) {
                    if (!$(e.target).closest($items).length) {
                        $items.filter('.eead-active').each(function () {
                            setOpen($(this), false);
                        });
                    }
                })).on('keydown' + ns, EEA.guard($scope, ns, function (e) {
                    if (e.key === 'Escape') {
                        var $open = $items.filter('.eead-active');
                        if ($open.length) {
                            $open.each(function () {
                                setOpen($(this), false);
                            });
                            $open.first().children('a').trigger('focus');
                        }
                    }
                }));
            }
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

            var viewer = new ImageCompare($image_compare[0], options);
            viewer.mount();

            // The library is pointer-only; make the divider a keyboard slider.
            var control = $image_compare[0].querySelector('.icv__control');
            if (!control || typeof viewer._slideCompare !== 'function') {
                return;
            }
            var vertical = !!$settings.orientation,
                pos = parseFloat($settings.starting_point);
            pos = isNaN(pos) ? 50 : pos;
            control.setAttribute('tabindex', '0');
            control.setAttribute('role', 'slider');
            control.setAttribute('aria-label', $settings.slider_label || 'Comparison slider');
            control.setAttribute('aria-orientation', vertical ? 'vertical' : 'horizontal');
            control.setAttribute('aria-valuemin', '0');
            control.setAttribute('aria-valuemax', '100');

            var moveTo = function (value) {
                var rect = $image_compare[0].getBoundingClientRect();
                pos = Math.max(0, Math.min(100, value));
                // _slideCompare ignores the exact ends; nudge inside so 0/100 still land.
                var p = Math.max(0.01, Math.min(99.99, pos));
                viewer._slideCompare({
                    clientX: rect.left + rect.width * p / 100,
                    clientY: rect.top + rect.height * p / 100
                });
                control.setAttribute('aria-valuenow', Math.round(pos));
                control.setAttribute('aria-valuetext', Math.round(pos) + '%');
            };
            control.setAttribute('aria-valuenow', Math.round(pos));

            // Keep the value in step when the slider is dragged.
            $image_compare.on('mouseup touchend', function () {
                var rect = $image_compare[0].getBoundingClientRect(),
                    c = control.getBoundingClientRect();
                pos = vertical ? (c.top + c.height / 2 - rect.top) / rect.height * 100 : (c.left + c.width / 2 - rect.left) / rect.width * 100;
                control.setAttribute('aria-valuenow', Math.round(pos));
            });

            control.addEventListener('keydown', function (e) {
                var step = {ArrowLeft: -1, ArrowDown: vertical ? 1 : -1, ArrowRight: 1, ArrowUp: vertical ? -1 : 1, PageDown: vertical ? 10 : -10, PageUp: vertical ? -10 : 10}[e.key];
                if (e.key === 'Home') {
                    moveTo(0);
                } else if (e.key === 'End') {
                    moveTo(100);
                } else if (step) {
                    moveTo(pos + step);
                } else {
                    return;
                }
                e.preventDefault();
            });
        },

        imageAccordion: function ($scope) {
            var $accordionContainer = $scope.find('.eead-image-accordion-on-click');

            if ($accordionContainer.length > 0) {
                var $accordion = $scope.find('.eead-image-accordion-item');
                $accordion.off('.eeadIa').on('click.eeadIa', function (e) {
                    var $this = $(this);
                    if ($this.hasClass('eead-tab-active')) {
                        return;
                    }
                    e.preventDefault();

                    $accordion.removeClass('eead-tab-active');
                    EEA.aria($accordion, 'aria-expanded', 'false');
                    $this.addClass('eead-tab-active');
                    EEA.aria($this, 'aria-expanded', 'true');
                }).on('keydown.eeadIa', function (e) {
                    // Enter on a link item behaves as a click already; Space too for the button ones.
                    if (this.tagName !== 'A') {
                        EEA.activateOnKey.call(this, e);
                    }
                });
            } else {
                // Keyboard focus counts as hover, so a focused item doesn't open alongside the default one.
                $scope.find('.eead-image-accordion-on-hover').off('.eeadIa').on('mouseenter.eeadIa focusin.eeadIa', function () {
                    $(this).find('.eead-image-accordion-item.eead-tab-active').removeClass('eead-tab-active').addClass('eead-trigger');
                }).on('mouseleave.eeadIa focusout.eeadIa', function (e) {
                    if (e.type === 'focusout' && (this.contains(e.relatedTarget) || this.matches(':hover'))) {
                        return;
                    }
                    if (e.type === 'mouseleave' && this.contains(document.activeElement)) {
                        return;
                    }
                    $(this).find('.eead-image-accordion-item.eead-trigger').addClass('eead-tab-active').removeClass('eead-trigger');
                });
            }
        },

        imageHoverEffect: function ($scope) {
            // Touch screens have no hover: on a whole-box link the first tap shows
            // the hidden content, a second tap on the same box follows the link.
            var box = EEA.own($scope, 'a.eead-ihe')[0];
            if (!box) {
                return;
            }
            if (!box.eeadTouchBound) {
                box.eeadTouchBound = true;
                box.addEventListener('touchstart', function () {
                    box.eeadTouch = true;
                }, {passive: true});
            }
            $(box).off('.eeadIhe').on('click.eeadIhe', function (e) {
                if (!box.eeadTouch) {
                    return;
                }
                box.eeadTouch = false;
                if (!box.classList.contains('eead-ihe-revealed')) {
                    e.preventDefault();
                    box.classList.add('eead-ihe-revealed');
                    box.focus();
                }
            }).on('blur.eeadIhe', function () {
                box.classList.remove('eead-ihe-revealed');
            });
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

                // The lightbox only steps through the images the filter shows.
                var lightboxEl = document.getElementById($gallery_container.attr('id'));
                var startLightbox = function (filter) {
                    $gallery.find('.eead-ig-item-box').each(function () {
                        $(this).toggleClass('eead-ig-out', !!filter && filter !== '*' && !$(this).is(filter));
                    });
                    var uid = lightboxEl.getAttribute('lg-uid');
                    if (uid && window.lgData && window.lgData[uid]) {
                        window.lgData[uid].destroy(true);
                    }
                    lightGallery(lightboxEl, {
                        selector: '.eead-ig-item-box:not(.eead-ig-out) .eead-ig-lightbox',
                        thumbnail: false,
                    });
                };

                $gallery_container.off('.eeadIg').on('click.eeadIg', '.eead-ig-filter', function () {
                    var $this = $(this),
                        filterValue = $this.attr('data-filter');

                    $this.siblings().removeClass('eead-ig-active').attr('aria-pressed', 'false');
                    $this.addClass('eead-ig-active').attr('aria-pressed', 'true');
                    $gallery.isotope({
                        itemSelector: '.eead-ig-item-box',
                        layoutMode: layout,
                        percentPosition: true,
                        stagger: 30,
                        transitionDuration: $settings.duration + 'ms',
                        filter: filterValue
                    });
                    startLightbox(filterValue);
                }).on('keydown.eeadIg', '.eead-ig-filter', EEA.activateOnKey);

                $gallery_container.addClass('eead-isotope-initialized');

                // Init Popup
                startLightbox(filterValue);
            }
        },

        pieChart: function ($scope) {
            var $container = $scope.find('.eead-pie-chart-container'),
                $canvas = $scope.find('.eead-pie-chart'),
                data = $container.data('chart') || {},
                options = $container.data('options') || {},
                format = $container.data('format') || {},
                observer = null;

            EEA.release($scope, 'pieChart');
            if (!$canvas.length || typeof Chart === 'undefined') {
                return;
            }

            var tooltip = $.extend({}, options.tooltips || {}, {
                callbacks: {
                    // Prefix/suffix, and optionally the slice's share of the whole.
                    label: function (ctx) {
                        var value = ctx.parsed,
                            text = (ctx.label ? ctx.label + ': ' : '') + (format.prefix || '') + value + (format.suffix || '');
                        if (format.percent) {
                            var total = ctx.dataset.data.reduce(function (sum, v) {
                                return sum + (parseFloat(v) || 0);
                            }, 0);
                            if (total > 0) {
                                text += ' (' + Math.round(value / total * 1000) / 10 + '%)';
                            }
                        }
                        return text;
                    }
                }
            });

            var draw = function () {
                var existing = Chart.getChart ? Chart.getChart($canvas[0]) : null;
                if (existing) {
                    existing.destroy();
                }
                var chart = new Chart($canvas, {
                    type: 'pie',
                    data: data,
                    options: {
                        cutout: options.cutoutPercentage,
                        maintainAspectRatio: false,
                        plugins: {
                            tooltip: tooltip,
                            legend: options.legend
                        },
                        animation: EEA.reducedMotion() ? false : options.animation
                    }
                });
                EEA.keep($scope, 'pieChart', function () {
                    chart.destroy();
                });
            };

            if ($container.attr('data-in-view') === 'yes' && window.IntersectionObserver && !EEA.reducedMotion()) {
                observer = new IntersectionObserver(function (entries) {
                    if (entries[entries.length - 1].isIntersecting) {
                        observer.disconnect();
                        draw();
                    }
                }, {threshold: 0.3});
                observer.observe($container[0]);
                EEA.keep($scope, 'pieChart', function () {
                    observer.disconnect();
                });
            } else {
                draw();
            }
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
            EEA.release($scope, 'opnWheel');

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

            // Each returns whether it moved, so the caller only cancels the native
            // scroll when the navigation actually took over.
            function goPrev() {
                var $active = activeItem(),
                    $prev = $active.prev();
                if ($active.length && $prev.length > 0) {
                    $prev.find('a').trigger('click');
                    return true;
                }
                return false;
            }

            function goNext() {
                var $active = activeItem(),
                    // Above the first section nothing is active yet: go to the first.
                    $next = $active.length ? $active.next() : nav_el.find('.eead-one-page-nav-item').first();
                if ($next.length > 0) {
                    $next.find('a').trigger('click');
                    return true;
                }
                return false;
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
                }, EEA.reducedMotion() ? 0 : $scroll_speed);

                nav_el.find('.eead-one-page-nav-item').removeClass('active');
                $(this).parent().addClass('active');
                markCurrent();
                return false;
            });

            // Screen readers: the dot of the section in view is the current one.
            function markCurrent() {
                $links.removeAttr('aria-current');
                activeItem().children('a').attr('aria-current', 'true');
            }

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
                markCurrent();
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

                // A native, non-passive listener: jQuery's document-level wheel handler is
                // passive in modern browsers, so the page scrolled natively *and* jumped.
                var onWheel = function (e) {
                    if (!document.documentElement.contains($scope[0])) {
                        document.removeEventListener('wheel', onWheel);
                        return;
                    }
                    var deltaY = e.deltaY;
                    if (!deltaY || e.ctrlKey) {
                        return;
                    }

                    var timeNow = new Date().getTime();
                    if ($('html,body').is(':animated') || timeNow - lastAnimation < quietPeriod + animationTime) {
                        // Mid-jump: swallow the wheel so it doesn't fight the animation.
                        if (activeItem().length) {
                            e.preventDefault();
                        }
                        return;
                    }

                    if (deltaY > 0 ? goNext() : goPrev()) {
                        e.preventDefault();
                        lastAnimation = timeNow;
                    }
                };
                document.addEventListener('wheel', onWheel, {passive: false});
                EEA.keep($scope, 'opnWheel', function () {
                    document.removeEventListener('wheel', onWheel);
                });

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
                    // Leave the keys to fields and to widgets that use them (tabs, sliders, menus).
                    if (e.isDefaultPrevented() || e.altKey || e.ctrlKey || e.metaKey ||
                            tag === 'input' || tag === 'textarea' || tag === 'select' || e.target.isContentEditable ||
                            $(e.target).closest('[role="tablist"], [role="slider"], [role="menu"], [role="listbox"], [role="dialog"], [role="tabpanel"]').length) {
                        return;
                    }
                    var moved;
                    switch (e.which) {
                        case 38:
                        case 33:
                            moved = goPrev();
                            break;
                        case 40:
                        case 34:
                            moved = goNext();
                            break;
                        default:
                            return;
                    }
                    if (moved) {
                        e.preventDefault();
                    }
                }));
            }
        },

        Lottie: function ($scope) {
            var $container = $scope.find('.eead-lottie');

            EEA.release($scope, 'lottie');

            if (!$container.length || typeof lottie === 'undefined') {
                return;
            }

            var settings = JSON.parse($container.attr('data-settings') || '{}'),
                still = EEA.reducedMotion(),
                autoplay = !!settings.autoplay && !still,
                action = settings.autoplay ? settings.action : settings.action_alt,
                loop = settings.loop !== false,
                visible = true,
                hoverPaused = false,
                observer = null;

            if (!settings.path) {
                return;
            }

            var animation = lottie.loadAnimation({
                container: $container[0],
                renderer: settings.renderer,
                // Viewport start and off-screen pausing are handled below.
                autoplay: autoplay && settings.trigger !== 'viewport',
                path: settings.path,
                loop: loop
            });

            EEA.keep($scope, 'lottie', function () {
                if (observer) {
                    observer.disconnect();
                }
                animation.destroy();
            });

            $container.off('.eeadLottie');

            animation.setDirection(settings.reverse);
            animation.setSpeed(settings.speed);

            // Reduced motion: hold the first frame instead of playing.
            if (still) {
                animation.addEventListener('DOMLoaded', function () {
                    animation.goToAndStop(settings.reverse == '-1' ? animation.totalFrames - 1 : 0, true);
                });
                return;
            }

            // Autoplay: start when in view (if chosen) and pause while off-screen.
            if (autoplay && window.IntersectionObserver) {
                visible = settings.trigger !== 'viewport';
                observer = new IntersectionObserver(function (entries) {
                    visible = entries[entries.length - 1].isIntersecting;
                    if (visible && !hoverPaused && animation.isPaused) {
                        animation.play();
                    } else if (!visible) {
                        animation.pause();
                    }
                }, {threshold: 0.1});
                observer.observe($container[0]);
                // A play-once animation is done for good: don't restart it on the next scroll.
                animation.addEventListener('complete', function () {
                    if (!loop && observer) {
                        observer.disconnect();
                    }
                });
            }

            switch (action) {
                case 'play':
                    $container.on('mouseenter.eeadLottie', function () {
                        animation.play();
                    });
                    $container.on('mouseleave.eeadLottie', function () {
                        animation.pause();
                    });
                    break;
                case 'click':
                    // Play from the start on each click (or toggle while it loops).
                    $container.css('cursor', 'pointer').on('click.eeadLottie', function (e) {
                        if (this.tagName !== 'A') {
                            e.preventDefault();
                        }
                        if (loop && !animation.isPaused) {
                            animation.pause();
                        } else {
                            animation.goToAndPlay(settings.reverse == '-1' ? animation.totalFrames - 1 : 0, true);
                        }
                    });
                    break;
                case 'pause':
                    $container.on('mouseenter.eeadLottie', function () {
                        hoverPaused = true;
                        animation.pause();
                    });
                    $container.on('mouseleave.eeadLottie', function () {
                        hoverPaused = false;
                        if (visible) {
                            animation.play();
                        }
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

        textMarquee: function ($scope) {
            EEA.release($scope, 'textMarquee');

            // One instance per row: a widget can render a second, crossing row.
            EEA.own($scope, '.eead-marquee').each(function () {
                EEA.textMarqueeRow($scope, this);
            });

            // Pause button: stops every row of this widget until pressed again.
            var toggle = EEA.own($scope, '.eead-tm-toggle')[0];
            $scope[0].eeadTmPaused = false;
            if (toggle) {
                toggle.setAttribute('aria-pressed', 'false');
                $(toggle).off('.eeadTm').on('click.eeadTm', function () {
                    var paused = !$scope[0].eeadTmPaused;
                    $scope[0].eeadTmPaused = paused;
                    toggle.setAttribute('aria-pressed', paused ? 'true' : 'false');
                    toggle.setAttribute('aria-label', toggle.getAttribute(paused ? 'data-label-play' : 'data-label-pause'));
                    $scope[0].classList.toggle('eead-tm-paused', paused);
                });
            }
        },

        textMarqueeRow: function ($scope, el) {
            var track = el.querySelector('.eead-tm-track'),
                group = track.querySelector('.eead-tm-group'),
                settings = JSON.parse(el.getAttribute('data-settings') || '{}'),
                vertical = settings.direction === 'up' || settings.direction === 'down',
                // pos grows while the content moves left / up
                sign = settings.direction === 'right' || settings.direction === 'down' ? -1 : 1,
                hoverFactor = settings.hover === 'pause' ? 0 : (settings.hover === 'slow' ? 0.3 : 1),
                dist = 0, pos = 0, factor = 1, boost = 0, scrollDir = 1,
                last = null, raf = 0, running = false,
                hovering = false, dragging = false, dragMoved = false, dragStart = 0, dragPos = 0,
                lastScroll = window.pageYOffset, resizeObserver = null, viewObserver = null;

            $(track).children('.eead-tm-clone').remove();
            el.classList.remove('eead-tm-static', 'eead-tm-dragging');
            track.style.transform = '';

            if (settings.reducedMotion && window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                el.classList.add('eead-tm-static');
                return;
            }

            function speed() {
                var map = settings.speed || {},
                    mode = elementorFrontend.getCurrentDeviceMode ? elementorFrontend.getCurrentDeviceMode() : 'desktop';
                if (map[mode] !== undefined) {
                    return map[mode];
                }
                if (mode === 'mobile' && map.tablet !== undefined) {
                    return map.tablet;
                }
                return map.desktop !== undefined ? map.desktop : 60;
            }

            function wrap() {
                if (dist > 0) {
                    pos = ((pos % dist) + dist) % dist;
                }
            }

            function paint() {
                track.style.transform = vertical ? 'translate3d(0,' + (-pos) + 'px,0)' : 'translate3d(' + (-pos) + 'px,0,0)';
            }

            // Enough copies of the group to cover the box while one group scrolls out.
            function layout() {
                var size = vertical ? group.offsetHeight : group.offsetWidth,
                    style = window.getComputedStyle(track),
                    gap = parseFloat(vertical ? style.rowGap : style.columnGap) || 0,
                    box = vertical ? el.clientHeight : el.clientWidth,
                    clones = track.querySelectorAll('.eead-tm-clone'),
                    need, i, clone;

                if (size <= 0) {
                    return;
                }

                dist = size + gap;
                need = Math.ceil(box / dist) + 1;

                for (i = clones.length; i < need; i++) {
                    clone = group.cloneNode(true);
                    clone.classList.add('eead-tm-clone');
                    clone.setAttribute('aria-hidden', 'true');
                    $(clone).find('a, button, [tabindex]').attr('tabindex', '-1');
                    track.appendChild(clone);
                }
                for (i = clones.length - 1; i >= need; i--) {
                    track.removeChild(clones[i]);
                }

                wrap();
                paint();
            }

            function tick(now) {
                var dt = last === null ? 0 : Math.min((now - last) / 1000, 0.1),
                    target = $scope[0].eeadTmPaused ? 0 : (hovering ? hoverFactor : 1);
                last = now;

                factor += (target - factor) * Math.min(1, dt * 5);
                if (Math.abs(target - factor) < 0.01) {
                    factor = target;
                }
                boost *= Math.pow(0.04, dt);

                if (!dragging) {
                    pos += speed() * sign * scrollDir * factor * (1 + boost) * dt;
                    wrap();
                    paint();
                }

                raf = window.requestAnimationFrame(tick);
            }

            function start() {
                if (!running) {
                    running = true;
                    last = null;
                    raf = window.requestAnimationFrame(tick);
                }
            }

            function stop() {
                running = false;
                window.cancelAnimationFrame(raf);
            }

            function onScroll() {
                var y = window.pageYOffset,
                    delta = y - lastScroll;
                lastScroll = y;
                if (!delta) {
                    return;
                }
                boost = Math.max(boost, Math.min(Math.abs(delta) / 10, 6));
                if (settings.scroll === 'direction') {
                    scrollDir = delta < 0 ? -1 : 1;
                }
            }

            function onEnter() {
                hovering = true;
            }

            function onLeave() {
                hovering = false;
            }

            function point(e) {
                return vertical ? e.clientY : e.clientX;
            }

            function onDown(e) {
                if (e.button !== undefined && e.button !== 0) {
                    return;
                }
                dragging = true;
                dragMoved = false;
                dragStart = point(e);
                dragPos = pos;
                el.classList.add('eead-tm-dragging');
                if (el.setPointerCapture) {
                    el.setPointerCapture(e.pointerId);
                }
            }

            function onMove(e) {
                if (!dragging) {
                    return;
                }
                var moved = point(e) - dragStart;
                if (Math.abs(moved) > 4) {
                    dragMoved = true;
                }
                pos = dragPos - moved;
                wrap();
                paint();
            }

            function onUp() {
                dragging = false;
                el.classList.remove('eead-tm-dragging');
            }

            // A drag ends with a click on whatever is under the pointer; don't follow that link.
            function onClick(e) {
                if (dragMoved) {
                    e.preventDefault();
                    e.stopPropagation();
                    dragMoved = false;
                }
            }

            layout();

            if (window.ResizeObserver) {
                resizeObserver = new ResizeObserver(layout);
                resizeObserver.observe(el);
                resizeObserver.observe(group);
            } else {
                $(window).on('resize' + EEA.ns($scope, 'Marquee'), layout);
            }
            if (document.fonts && document.fonts.ready) {
                document.fonts.ready.then(layout);
            }

            // Only animate while the marquee is on screen.
            if (window.IntersectionObserver) {
                viewObserver = new IntersectionObserver(function (entries) {
                    if (entries[entries.length - 1].isIntersecting) {
                        start();
                    } else {
                        stop();
                    }
                });
                viewObserver.observe(el);
            } else {
                start();
            }

            // Touch screens fire mouseenter on tap but never mouseleave.
            if (!window.matchMedia || window.matchMedia('(hover: hover)').matches) {
                el.addEventListener('mouseenter', onEnter);
                el.addEventListener('mouseleave', onLeave);
            }
            el.addEventListener('focusin', onEnter);
            el.addEventListener('focusout', onLeave);

            if (settings.scroll && settings.scroll !== 'none') {
                window.addEventListener('scroll', onScroll, {passive: true});
            }

            if (settings.drag) {
                el.addEventListener('pointerdown', onDown);
                el.addEventListener('pointermove', onMove);
                el.addEventListener('pointerup', onUp);
                el.addEventListener('pointercancel', onUp);
                el.addEventListener('click', onClick, true);
            }

            EEA.keep($scope, 'textMarquee', function () {
                stop();
                if (resizeObserver) {
                    resizeObserver.disconnect();
                }
                if (viewObserver) {
                    viewObserver.disconnect();
                }
                $(window).off(EEA.ns($scope, 'Marquee'));
                window.removeEventListener('scroll', onScroll);
                el.removeEventListener('mouseenter', onEnter);
                el.removeEventListener('mouseleave', onLeave);
                el.removeEventListener('focusin', onEnter);
                el.removeEventListener('focusout', onLeave);
                el.removeEventListener('pointerdown', onDown);
                el.removeEventListener('pointermove', onMove);
                el.removeEventListener('pointerup', onUp);
                el.removeEventListener('pointercancel', onUp);
                el.removeEventListener('click', onClick, true);
            });
        },

        /** Pick a per-device value ({desktop, tablet, mobile}) for the current Elementor device. */
        deviceValue: function (map, fallback) {
            var mode = window.elementorFrontend && elementorFrontend.getCurrentDeviceMode ? elementorFrontend.getCurrentDeviceMode() : 'desktop';
            map = map || {};
            if (map[mode] !== undefined) {
                return map[mode];
            }
            if (mode === 'mobile' && map.tablet !== undefined) {
                return map.tablet;
            }
            return map.desktop !== undefined ? map.desktop : fallback;
        },

        reducedMotion: function () {
            return !!(window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches);
        },

        dataTable: function ($scope) {
            var wrap = EEA.own($scope, '.eead-data-table-wrap')[0];
            if (!wrap) {
                return;
            }

            var settings = JSON.parse(wrap.getAttribute('data-settings') || '{}'),
                table = wrap.querySelector('.eead-data-table'),
                tbody = table.tBodies[0],
                search = wrap.querySelector('.eead-dt-search'),
                info = wrap.querySelector('.eead-dt-info'),
                pager = wrap.querySelector('.eead-dt-pagination'),
                rows = Array.prototype.slice.call(tbody.rows),
                columns = 0,
                state = {col: -1, dir: 0, query: '', page: 1},
                timer = 0;

            if (table.tHead && table.tHead.rows[0]) {
                Array.prototype.forEach.call(table.tHead.rows[0].cells, function (cell) {
                    columns += cell.colSpan || 1;
                });
            }

            rows.forEach(function (row) {
                row.eeadText = row.textContent.toLowerCase();
            });

            // The cell under a column, counting earlier cells' column spans.
            function cellAt(row, col) {
                var at = 0, i;
                for (i = 0; i < row.cells.length; i++) {
                    if (col < at + (row.cells[i].colSpan || 1)) {
                        return row.cells[i];
                    }
                    at += row.cells[i].colSpan || 1;
                }
                return null;
            }

            function sortValue(row, col) {
                var cell = cellAt(row, col),
                    text = cell ? cell.textContent.trim() : '',
                    // A number with an optional currency sign or code before it and a
                    // unit after it ($1,200 / USD 30 / 45% / 10 GB). Words before the
                    // digits rule it out, so "Jan 5, 2024" isn't read as 52024.
                    match = text.match(/^(?:[A-Z]{3}\s*)?[^\w\s\-\u2212]*\s*([\-\u2212]?\d[\d,]*(?:\.\d+)?)(?:\s*[^\d\s][^\d]*)?$/),
                    date;
                if (match) {
                    return {num: parseFloat(match[1].replace(/,/g, '').replace('\u2212', '-')), text: text};
                }
                // Dates with a four-digit year: 2024-01-15, Jan 5, 2024, 5 March 2024.
                if (/\d{4}/.test(text) && /[a-z\-\/]/i.test(text)) {
                    date = Date.parse(text);
                    if (!isNaN(date)) {
                        return {num: date, text: text};
                    }
                }
                return {num: null, text: text.toLowerCase()};
            }

            function render() {
                var list = rows.filter(function (row) {
                        return !state.query || row.eeadText.indexOf(state.query) !== -1;
                    }),
                    total, per, pages, from, to, empty;

                if (state.col !== -1 && state.dir) {
                    list = list.map(function (row, i) {
                        return {row: row, i: i, v: sortValue(row, state.col)};
                    }).sort(function (a, b) {
                        var r;
                        if (a.v.num !== null && b.v.num !== null) {
                            r = a.v.num - b.v.num;
                        } else {
                            r = a.v.text.localeCompare(b.v.text, undefined, {numeric: true, sensitivity: 'base'});
                        }
                        return (r * state.dir) || (a.i - b.i);
                    }).map(function (x) {
                        return x.row;
                    });
                }

                total = list.length;
                per = settings.perPage || total || 1;
                pages = Math.max(1, Math.ceil(total / per));
                state.page = Math.min(Math.max(1, state.page), pages);
                from = (state.page - 1) * per;
                to = Math.min(from + per, total);

                rows.forEach(function (row) {
                    row.hidden = true;
                });
                list.forEach(function (row, i) {
                    tbody.appendChild(row);
                    row.hidden = i < from || i >= to;
                });

                empty = tbody.querySelector('.eead-dt-empty');
                if (!total && settings.empty) {
                    if (!empty) {
                        empty = document.createElement('tr');
                        empty.className = 'eead-dt-empty';
                        empty.innerHTML = '<td></td>';
                        empty.firstChild.colSpan = Math.max(1, columns);
                        empty.firstChild.textContent = settings.empty;
                    }
                    tbody.appendChild(empty);
                } else if (empty) {
                    empty.parentNode.removeChild(empty);
                }

                if (info) {
                    info.textContent = total && (settings.perPage || state.query) ? settings.info.replace('%1$s', from + 1).replace('%2$s', to).replace('%3$s', total) : '';
                }
                if (pager) {
                    renderPager(pages);
                }
            }

            function pageButton(label, page, current, disabled, aria) {
                var b = document.createElement('button');
                b.type = 'button';
                b.className = 'eead-dt-page';
                b.textContent = label;
                b.disabled = !!disabled;
                if (aria) {
                    b.setAttribute('aria-label', aria);
                }
                if (current) {
                    b.setAttribute('aria-current', 'page');
                }
                b.addEventListener('click', function () {
                    state.page = page;
                    render();
                    wrap.scrollIntoView({block: 'nearest'});
                });
                return b;
            }

            function renderPager(pages) {
                var p, show = [];
                pager.innerHTML = '';
                pager.hidden = pages < 2;
                if (pages < 2) {
                    return;
                }
                for (p = 1; p <= pages; p++) {
                    if (p === 1 || p === pages || Math.abs(p - state.page) <= 1) {
                        show.push(p);
                    } else if (show[show.length - 1] !== '…') {
                        show.push('…');
                    }
                }
                pager.appendChild(pageButton('‹', state.page - 1, false, state.page === 1, settings.prev));
                show.forEach(function (p) {
                    if (p === '…') {
                        var gap = document.createElement('span');
                        gap.className = 'eead-dt-gap';
                        gap.textContent = '…';
                        pager.appendChild(gap);
                    } else {
                        pager.appendChild(pageButton(String(p), p, p === state.page, false, settings.page.replace('%s', p)));
                    }
                });
                pager.appendChild(pageButton('›', state.page + 1, false, state.page === pages, settings.next));
            }

            if (settings.sortable) {
                Array.prototype.forEach.call(table.querySelectorAll('thead th[data-col]'), function (th) {
                    var button = th.querySelector('.eead-dt-sort');
                    button.addEventListener('click', function () {
                        var col = parseInt(th.getAttribute('data-col'), 10);
                        // Ascending, descending, then back to the original order.
                        state.dir = state.col !== col ? 1 : (state.dir === 1 ? -1 : (state.dir === -1 ? 0 : 1));
                        state.col = state.dir ? col : -1;
                        Array.prototype.forEach.call(table.querySelectorAll('thead th[data-col]'), function (other) {
                            other.setAttribute('aria-sort', other === th && state.dir ? (state.dir === 1 ? 'ascending' : 'descending') : 'none');
                        });
                        render();
                    });
                });
            }

            if (settings.sortable && settings.sortCol >= 0) {
                var initial = table.querySelector('thead th[data-col="' + settings.sortCol + '"]');
                if (initial) {
                    state.col = settings.sortCol;
                    state.dir = settings.sortDir === -1 ? -1 : 1;
                    initial.setAttribute('aria-sort', state.dir === 1 ? 'ascending' : 'descending');
                }
            }

            if (search) {
                search.addEventListener('input', function () {
                    clearTimeout(timer);
                    timer = setTimeout(function () {
                        state.query = search.value.trim().toLowerCase();
                        state.page = 1;
                        render();
                    }, 150);
                });
            }

            render();
        },

        tableOfContents: function ($scope) {
            EEA.release($scope, 'toc');

            var toc = EEA.own($scope, '.eead-toc')[0];
            if (!toc) {
                return;
            }

            var settings = JSON.parse(toc.getAttribute('data-settings') || '{}'),
                list = toc.querySelector('.eead-toc-list'),
                body = toc.querySelector('.eead-toc-body'),
                toggle = toc.querySelector('.eead-toc-toggle'),
                markerTpl = toc.querySelector('.eead-toc-marker-tpl'),
                editMode = !!(window.elementorFrontend && elementorFrontend.isEditMode && elementorFrontend.isEditMode()),
                root = null, headings, links = [], ticking = false, ns = EEA.ns($scope, 'Toc');

            function offset() {
                return parseInt(EEA.deviceValue(settings.offset, 24), 10) || 0;
            }

            // Collapse: start state per device, then a plain toggle.
            function setCollapsed(collapsed) {
                toc.classList.toggle('eead-toc-collapsed', collapsed);
                if (toggle) {
                    toggle.setAttribute('aria-expanded', collapsed ? 'false' : 'true');
                }
            }

            if (settings.collapsed && settings.collapsed !== 'none') {
                var query = {mobile: '(max-width: 767px)', tablet: '(max-width: 1024px)', all: 'all'}[settings.collapsed];
                setCollapsed(!editMode && !!query && window.matchMedia(query).matches);
            }
            toc.classList.remove('eead-toc-start-collapsed');
            if (toggle) {
                toggle.addEventListener('click', function () {
                    setCollapsed(!toc.classList.contains('eead-toc-collapsed'));
                });
            }

            if (settings.container) {
                try {
                    root = document.querySelector(settings.container);
                } catch (err) {
                    root = null;
                }
            }
            if (!root) {
                root = $scope[0].closest('[data-elementor-type="wp-page"], [data-elementor-type="wp-post"], [data-elementor-type="single-post"], [data-elementor-type="single-page"]') || document.querySelector('main') || document.body;
            }

            headings = Array.prototype.filter.call(root.querySelectorAll((settings.headings || ['h2', 'h3']).join(',')), function (h) {
                // Card titles (image hover boxes) and hidden copies (marquee clones) are not page sections.
                if (toc.contains(h) || h.closest('.eead-toc-skip, .eead-ihe, [aria-hidden="true"]') || !h.textContent.trim() || !h.getClientRects().length) {
                    return false;
                }
                if (settings.exclude) {
                    try {
                        if (h.closest(settings.exclude)) {
                            return false;
                        }
                    } catch (err) {
                    }
                }
                return true;
            });

            list.innerHTML = '';
            if (headings.length < (settings.min || 1)) {
                if (editMode) {
                    var message = document.createElement('p');
                    message.className = 'eead-toc-message';
                    message.textContent = settings.empty;
                    list.appendChild(message);
                    toc.classList.remove('eead-toc-hidden');
                } else {
                    toc.classList.add('eead-toc-hidden');
                }
                return;
            }
            toc.classList.remove('eead-toc-hidden');

            function slug(text) {
                var base = text.toLowerCase().normalize('NFD').replace(/[̀-ͯ]/g, '').replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '') || 'section',
                    id = base, n = 2;
                while (document.getElementById(id)) {
                    id = base + '-' + n++;
                }
                return id;
            }

            var lists = [document.createElement('ul')], stack = [], counters = [];
            list.appendChild(lists[0]);

            headings.forEach(function (h) {
                var level = parseInt(h.tagName.charAt(1), 10), depth = 0, li, a, text, marker;
                if (!h.id) {
                    h.id = slug(h.textContent.trim());
                }

                if (settings.nested) {
                    while (stack.length && level <= stack[stack.length - 1]) {
                        stack.pop();
                    }
                    depth = stack.length;
                    stack.push(level);
                }

                while (lists.length - 1 < depth) {
                    var parentLi = lists[lists.length - 1].lastElementChild, sub = document.createElement('ul');
                    (parentLi || lists[lists.length - 1]).appendChild(sub);
                    lists.push(sub);
                }
                lists.length = depth + 1;

                counters.length = depth + 1;
                counters[depth] = (counters[depth] || 0) + 1;
                for (var i = 0; i < depth; i++) {
                    counters[i] = counters[i] || 1;
                }

                li = document.createElement('li');
                a = document.createElement('a');
                a.href = '#' + h.id;
                if (toc.closest('.eead-toc-marker-numbers')) {
                    marker = document.createElement('span');
                    marker.className = 'eead-toc-num';
                    marker.textContent = counters.slice(0, depth + 1).join('.') + (depth ? '' : '.');
                    a.appendChild(marker);
                } else if (toc.closest('.eead-toc-marker-bullets')) {
                    marker = document.createElement('span');
                    marker.className = 'eead-toc-bullet';
                    marker.setAttribute('aria-hidden', 'true');
                    a.appendChild(marker);
                } else if (markerTpl) {
                    a.appendChild(markerTpl.content.cloneNode(true));
                }
                text = document.createElement('span');
                text.className = 'eead-toc-text';
                text.textContent = h.textContent.trim();
                a.appendChild(text);
                a.eeadTarget = h;
                a.addEventListener('click', function (e) {
                    e.preventDefault();
                    var top = h.getBoundingClientRect().top + window.pageYOffset - offset();
                    window.scrollTo({top: top, behavior: settings.smooth && !EEA.reducedMotion() ? 'smooth' : 'auto'});
                    if (window.history && history.replaceState) {
                        history.replaceState(null, '', '#' + h.id);
                    }
                    if (!h.hasAttribute('tabindex')) {
                        h.setAttribute('tabindex', '-1');
                    }
                    h.focus({preventScroll: true});
                });
                li.appendChild(a);
                lists[depth].appendChild(li);
                links.push(a);
            });

            // A shared link such as page/#take-payments: the id only exists now that
            // the table has given headings their anchors, so the browser could not
            // jump on load. Do it here, with the same offset as a click.
            if (!editMode && window.location.hash) {
                var landing = null;
                try {
                    landing = document.getElementById(decodeURIComponent(window.location.hash.slice(1)));
                } catch (err) {
                }
                if (landing && links.some(function (link) {
                    return link.eeadTarget === landing;
                })) {
                    setTimeout(function () {
                        window.scrollTo({top: landing.getBoundingClientRect().top + window.pageYOffset - offset(), behavior: 'auto'});
                    }, 60);
                }
            }

            if (!settings.highlight && !settings.progress) {
                return;
            }

            // The current section is the last heading that has passed the offset line.
            function highlight() {
                ticking = false;
                var line = offset() + 8, current = null;
                if (settings.progress) {
                    // How far the reader is through the content, 0 to 1.
                    var box = root.getBoundingClientRect(),
                        span = Math.max(1, box.height - (window.innerHeight - line));
                    toc.style.setProperty('--eead-toc-read', Math.min(1, Math.max(0, (line - box.top) / span)).toFixed(3));
                }
                if (!settings.highlight) {
                    return;
                }
                links.forEach(function (a) {
                    if (a.eeadTarget.getBoundingClientRect().top <= line) {
                        current = a;
                    }
                });
                links.forEach(function (a) {
                    var on = a === current;
                    a.classList.toggle('eead-toc-active', on);
                    if (on) {
                        a.setAttribute('aria-current', 'true');
                    } else {
                        a.removeAttribute('aria-current');
                    }
                });
            }

            function onScroll() {
                if (!ticking) {
                    ticking = true;
                    window.requestAnimationFrame(highlight);
                }
            }

            $(window).on('scroll' + ns + ' resize' + ns, EEA.guard($scope, ns, onScroll));
            highlight();
            EEA.keep($scope, 'toc', function () {
                $(window).off(ns);
            });
        },

        scrollTextReveal: function ($scope) {
            EEA.release($scope, 'str');

            var el = EEA.own($scope, '.eead-str')[0];
            if (!el) {
                return;
            }

            var settings = JSON.parse(el.getAttribute('data-settings') || '{}'),
                units = Array.prototype.slice.call(el.querySelectorAll('.eead-str-unit')),
                count = units.length,
                done = [], ticking = false, observer = null, ns = EEA.ns($scope, 'Str');

            el.classList.remove('eead-str-static', 'eead-str-once');
            units.forEach(function (u) {
                u.style.removeProperty('--eead-str-p');
                u.style.transitionDelay = '';
            });

            if (!count || EEA.reducedMotion()) {
                el.classList.add('eead-str-static');
                return;
            }

            if (settings.trigger === 'view') {
                // Keep the whole sequence under about four seconds, however long the text.
                var step = Math.min(settings.stagger || 0, 4000 / count);
                el.classList.add('eead-str-once');
                units.forEach(function (u, i) {
                    u.style.transitionDelay = Math.round(i * step) + 'ms';
                });
                if (!window.IntersectionObserver) {
                    el.classList.add('eead-str-static');
                    return;
                }
                observer = new IntersectionObserver(function (entries) {
                    if (entries[0].isIntersecting) {
                        units.forEach(function (u) {
                            u.style.setProperty('--eead-str-p', '1');
                        });
                        observer.disconnect();
                    }
                }, {threshold: 0.25});
                observer.observe(el);
                EEA.keep($scope, 'str', function () {
                    observer.disconnect();
                });
                return;
            }

            // Text already on screen when the page loads fills in as a short intro, then follows the scroll.
            var intro = 1, introStart = null;

            // Scroll-linked: filling starts when the top of the text reaches the start line and ends when its bottom reaches the end line.
            function update() {
                ticking = false;
                var vh = window.innerHeight,
                    startY = vh * (settings.start === undefined ? 85 : settings.start) / 100,
                    endY = vh * (settings.end === undefined ? 35 : settings.end) / 100,
                    rect = el.getBoundingClientRect(),
                    p = Math.min(1, Math.max(0, (startY - rect.top) / Math.max(1, startY - endY + rect.height))) * intro;
                units.forEach(function (u, i) {
                    var v = Math.min(1, Math.max(0, p * count - i));
                    v = Math.round(v * 100) / 100;
                    if (done[i] !== v) {
                        done[i] = v;
                        u.style.setProperty('--eead-str-p', v);
                    }
                });
            }

            function onScroll() {
                if (!ticking) {
                    ticking = true;
                    window.requestAnimationFrame(update);
                }
            }

            function introStep(now) {
                if (introStart === null) {
                    introStart = now;
                }
                var t = Math.min(1, (now - introStart) / 1400);
                intro = 1 - Math.pow(1 - t, 3);
                update();
                if (t < 1 && document.documentElement.contains(el)) {
                    window.requestAnimationFrame(introStep);
                }
            }

            $(window).on('scroll' + ns + ' resize' + ns, EEA.guard($scope, ns, onScroll));
            if (el.getBoundingClientRect().top < window.innerHeight * (settings.start === undefined ? 85 : settings.start) / 100) {
                intro = 0;
                window.requestAnimationFrame(introStep);
            } else {
                update();
            }
            EEA.keep($scope, 'str', function () {
                intro = 1;
                $(window).off(ns);
            });
        },

        whatsappChat: function ($scope) {
            EEA.release($scope, 'wa');

            var wrap = EEA.own($scope, '.eead-wa')[0],
                panel = wrap && wrap.querySelector('.eead-wa-panel'),
                button = wrap && wrap.querySelector('button.eead-wa-button');
            if (!panel || !button) {
                return;
            }

            var settings = JSON.parse(wrap.getAttribute('data-settings') || '{}'),
                closeBtn = panel.querySelector('.eead-wa-close'),
                key = 'eead-wa-closed-' + (settings.id || ''),
                editMode = !!(window.elementorFrontend && elementorFrontend.isEditMode && elementorFrontend.isEditMode()),
                timer = 0;

            function isOpen() {
                return !panel.hidden;
            }

            function open() {
                panel.hidden = false;
                wrap.classList.add('eead-wa-open');
                button.setAttribute('aria-expanded', 'true');
            }

            function close(returnFocus) {
                if (!isOpen()) {
                    return;
                }
                panel.hidden = true;
                wrap.classList.remove('eead-wa-open');
                button.setAttribute('aria-expanded', 'false');
                // Once closed by the visitor, it stays closed for the rest of the visit.
                try {
                    window.sessionStorage.setItem(key, '1');
                } catch (err) {
                }
                if (returnFocus) {
                    button.focus();
                }
            }

            function onButton() {
                if (isOpen()) {
                    close(false);
                } else {
                    clearTimeout(timer);
                    open();
                    var first = panel.querySelector('.eead-wa-start, .eead-wa-agent');
                    if (first) {
                        first.focus();
                    }
                }
            }

            function onClose() {
                close(true);
            }

            function onKey(e) {
                if (e.key === 'Escape' && isOpen()) {
                    close(true);
                }
            }

            function onOutside(e) {
                if (isOpen() && !wrap.contains(e.target) && wrap.classList.contains('eead-wa-floating')) {
                    close(false);
                }
            }

            button.addEventListener('click', onButton);
            closeBtn.addEventListener('click', onClose);
            document.addEventListener('keydown', onKey);
            document.addEventListener('click', onOutside);

            var closedBefore = false;
            try {
                closedBefore = window.sessionStorage.getItem(key) === '1';
            } catch (err) {
            }
            if (settings.autoOpen > 0 && !closedBefore && !editMode) {
                timer = setTimeout(open, settings.autoOpen * 1000);
            }

            EEA.keep($scope, 'wa', function () {
                clearTimeout(timer);
                button.removeEventListener('click', onButton);
                closeBtn.removeEventListener('click', onClose);
                document.removeEventListener('keydown', onKey);
                document.removeEventListener('click', onOutside);
            });
        },

        appearingImage: function ($scope) {
            EEA.release($scope, 'apim');

            var el = EEA.own($scope, '.eead-apim')[0],
                frame = el && el.querySelector('.eead-apim-frame');
            if (!frame) {
                return;
            }

            var settings = JSON.parse(el.getAttribute('data-settings') || '{}'),
                ns = EEA.ns($scope, 'Apim'),
                ticking = false, observer = null;

            el.classList.remove('eead-apim-once', 'eead-apim-shown', 'eead-apim-static');
            frame.style.removeProperty('--eead-apim-p');

            if (EEA.reducedMotion() || !window.IntersectionObserver) {
                el.classList.add('eead-apim-static');
                return;
            }

            if (settings.trigger === 'scroll') {
                // Revealed as the image's top travels from the start line to the end line.
                var update = function () {
                    ticking = false;
                    var vh = window.innerHeight,
                        a = settings.start === undefined ? 95 : settings.start,
                        b = settings.end === undefined ? 45 : settings.end,
                        // The start line has to sit below the finish line; reversed
                        // values would otherwise snap straight to fully shown.
                        startY = vh * Math.max(a, b) / 100,
                        endY = vh * Math.min(a, b) / 100,
                        top = frame.getBoundingClientRect().top,
                        p = Math.min(1, Math.max(0, (startY - top) / Math.max(1, startY - endY)));
                    frame.style.setProperty('--eead-apim-p', p.toFixed(3));
                };
                $(window).on('scroll' + ns + ' resize' + ns, EEA.guard($scope, ns, function () {
                    if (!ticking) {
                        ticking = true;
                        window.requestAnimationFrame(update);
                    }
                }));
                update();
                EEA.keep($scope, 'apim', function () {
                    $(window).off(ns);
                });
                return;
            }

            var repeat = settings.trigger === 'repeat';
            el.classList.add('eead-apim-once');
            // A quarter of the image, or a quarter of the screen for an image too
            // tall to ever show a quarter of itself at once.
            var threshold = Math.min(0.25, window.innerHeight * 0.25 / Math.max(1, frame.offsetHeight));
            observer = new IntersectionObserver(function (entries) {
                var entry = entries[entries.length - 1];
                // isIntersecting turns true at the first visible pixel, before the threshold.
                if (entry.intersectionRatio >= threshold - 0.001) {
                    el.classList.add('eead-apim-shown');
                    if (!repeat) {
                        observer.disconnect();
                    }
                } else if (repeat && !entry.isIntersecting) {
                    el.classList.remove('eead-apim-shown');
                }
            }, {threshold: threshold});
            observer.observe(frame);
            EEA.keep($scope, 'apim', function () {
                observer.disconnect();
            });
        },

        logoCarousel: function ($scope) {
            var $ele = $scope.find('.eead-logo-carousel');
            if ($ele.length > 0) {
                var params = JSON.parse($ele.attr('data-params'));
                $ele.owlCarousel({
                    loop: JSON.parse(params.loop),
                    // No self-moving carousel for visitors who turned motion off.
                    autoplay: JSON.parse(params.autoplay) && !EEA.reducedMotion(),
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
                EEA.owlA11y($ele);
            }
        },

        popupModal: function ($scope) {
            var $open = $scope.find('.eead-popup-modal-trigger-btn'),
                id = $open.data('id'),
                modalId = 'eead-popup-modal-' + id,
                popupNs = '.eeadPopup' + $scope.data('id');

            if (!id || typeof MicroModal === 'undefined') {
                return;
            }

            var show = function () {
                MicroModal.show(modalId, {
                    awaitOpenAnimation: true,
                    awaitCloseAnimation: true,
                    openClass: 'eead-open-modal',
                    disableScroll: true,
                    onShow: function (modal) {
                        // Sliders/carousels in a template measured 0 while hidden.
                        setTimeout(function () {
                            window.dispatchEvent(new Event('resize'));
                        }, 50);
                        // MicroModal skips the close button when picking what to focus,
                        // so focus could land inside a video frame, where Escape is lost.
                        // Start on the dialog itself instead.
                        var box = modal.querySelector('[role="dialog"]'),
                            focused = false,
                            focusBox = function () {
                                if (!focused) {
                                    focused = true;
                                    setTimeout(function () {
                                        box.focus();
                                    }, 0);
                                }
                            };
                        if (box) {
                            box.setAttribute('tabindex', '-1');
                            // MicroModal focuses after its open animation ends; go after it.
                            modal.addEventListener('animationend', focusBox, {once: true});
                            setTimeout(focusBox, 700);
                        }
                    },
                    onClose: function (modal) {
                        // Stop embedded video and audio: re-setting an iframe's src
                        // unloads the player, and media elements are paused.
                        $(modal).find('iframe').each(function () {
                            var src = this.getAttribute('src');
                            if (src && /youtube|vimeo|dailymotion|wistia|soundcloud|spotify/.test(src)) {
                                this.setAttribute('src', src);
                            }
                        });
                        $(modal).find('video, audio').each(function () {
                            this.pause();
                        });
                    }
                });
            };

            if ($open.hasClass('eead-popup-modal-trigger-selector')) {
                var $triggers;
                try {
                    $triggers = $(document).find($open.attr('data-selector'));
                } catch (e) {
                    $triggers = $();
                }
                $triggers.off('click' + popupNs).on('click' + popupNs, function (e) {
                    e.preventDefault();
                    show();
                });
            } else {
                $open.off('click' + popupNs).on('click' + popupNs, function (e) {
                    e.preventDefault();
                    show();
                });
            }

            // Open automatically: after a delay, at a scroll depth or on exit intent,
            // then not again for the chosen number of days (per visitor).
            var auto = $scope.find('.eead-popup-modal-trigger').data('auto');
            $(window).off(popupNs);
            $(document).off(popupNs);
            EEA.release($scope, 'popupAuto');
            if (!auto || (window.elementorFrontend && elementorFrontend.isEditMode())) {
                return;
            }

            var key = 'eead-popup-' + id,
                seen = 0, done = false, timer = 0;
            try {
                seen = parseInt(window.localStorage.getItem(key), 10) || 0;
            } catch (err) {
            }
            if (auto.again > 0 && seen && Date.now() - seen < auto.again * 86400000) {
                return;
            }

            var fire = function () {
                if (done || document.querySelector('.eead-popup-modal.eead-open-modal')) {
                    return;
                }
                done = true;
                $(window).off(popupNs);
                $(document).off(popupNs);
                clearTimeout(timer);
                try {
                    window.localStorage.setItem(key, String(Date.now()));
                } catch (err) {
                }
                show();
            };
            var touch = window.matchMedia && window.matchMedia('(hover: none)').matches;

            if (auto.type === 'delay') {
                timer = setTimeout(fire, auto.delay * 1000);
            } else if (auto.type === 'scroll') {
                var check = function () {
                    var max = document.documentElement.scrollHeight - window.innerHeight;
                    if (max <= 0 || window.pageYOffset / max * 100 >= auto.scroll) {
                        fire();
                    }
                };
                $(window).on('scroll' + popupNs, EEA.guard($scope, popupNs, check));
                check();
            } else if (auto.type === 'exit') {
                if (touch) {
                    timer = setTimeout(fire, 30000);
                } else {
                    $(document).on('mouseout' + popupNs, EEA.guard($scope, popupNs, function (e) {
                        // Leaving through the top edge, towards the tabs and address bar.
                        if (!e.relatedTarget && e.clientY <= 0) {
                            fire();
                        }
                    }));
                }
            }
            EEA.keep($scope, 'popupAuto', function () {
                clearTimeout(timer);
            });
        },

        popupVideo: function ($scope) {
            var $video = $scope.find('.eead-video-popup-button');
            var video_id = $video.attr('id');
            var video_type = $video.attr('data-video-type');
            var video_width = $video.attr('data-video-width');
            if (video_type == 'custom') {
                lightGallery(document.getElementById(video_id), {
                    selector: 'this',
                    counter: false,
                    videoMaxWidth: video_width
                });
                // Without an href, Enter and Space have to open it.
                $video.on('keydown', function (e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        this.click();
                    }
                });
            } else {
                var settings = JSON.parse($video.attr('data-settings'));
                lightGallery(document.getElementById(video_id), {
                    selector: 'this',
                    counter: false,
                    videoMaxWidth: video_width,
                    // Unset values are left out instead of being sent as "undefined".
                    youtubePlayerParams: $.extend({modestbranding: 0, rel: 0}, (function () {
                        var p = {};
                        $.each(['autoplay', 'controls', 'mute', 'start', 'end', 'loop', 'playlist'], function (i, k) {
                            if (settings[k] !== undefined && settings[k] !== false && settings[k] !== null) {
                                p[k] = settings[k];
                            }
                        });
                        return p;
                    })()),
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
            var $container = $scope.find('.eead-progressbar-container'),
                $el = $scope.find('.eead-progressbar'),
                duration = parseInt($container.attr('data-duration'), 10),
                still = EEA.reducedMotion();
            duration = isNaN(duration) ? 1000 : duration;

            $el.each(function (index) {
                var $this = $(this),
                    target = Math.max(0, Math.min(100, parseFloat($this.attr('data-width')) || 0)),
                    $bar = $this.find('.eead-progressbar-length'),
                    // The percentage sits beside or inside the bar depending on the style.
                    $label = $this.closest('.eead-progress').find('.eead-progressbar-percentage'),
                    fill = function () {
                        if (still || !duration) {
                            $bar.css('width', target + '%');
                            return;
                        }
                        // The number counts up with the bar instead of showing the end value first.
                        $label.text('0%');
                        $bar.stop(true).css('width', 0).animate({width: target + '%'}, {
                            duration: duration,
                            step: function (now, fx) {
                                if (fx.prop === 'width') {
                                    $label.text(Math.round(Math.min(now, target)) + '%');
                                }
                            },
                            complete: function () {
                                $label.text(target + '%');
                            }
                        });
                    };

                if (still || typeof $this.waypoint !== 'function') {
                    $bar.css('width', target + '%');
                    return;
                }
                if (duration) {
                    $label.text('0%');
                }
                $this.waypoint(function () {
                    setTimeout(fill, index * 100 + 150);
                    this.destroy();
                }, {
                    offset: '90%',
                });
            });
        },

        toggleBlock: function ($scope, $) {
            var $container = EEA.own($scope, '.eead-toggle-container'),
                $toggle_switch = EEA.own($scope, '.eead-toggle-switch-checkbox'),
                $label_primary = EEA.own($scope, '.eead-toggle-label-primary'),
                $label_secondary = EEA.own($scope, '.eead-toggle-label-secondary'),
                hash = $container.attr('data-hash'),
                ns = EEA.ns($scope, 'Toggle');

            var set = function (on) {
                if ($container.hasClass('eead-switch-on') === on) {
                    $toggle_switch.prop('checked', on);
                    return;
                }
                $container.toggleClass('eead-switch-on', on);
                $toggle_switch.prop('checked', on);
                // Carousels, maps etc. in the shown content measure 0 while hidden.
                window.dispatchEvent(new Event('resize'));
            };

            $toggle_switch.on('change', function () {
                set($(this).prop('checked'));
            });

            $label_primary.on('click', function () {
                set(false);
            });

            $label_secondary.on('click', function () {
                set(true);
            });

            if (hash && !elementorFrontend.isEditMode()) {
                var fromHash = function () {
                    if (decodeURIComponent(window.location.hash.slice(1)) === hash) {
                        set(true);
                    }
                };
                fromHash();
                $(window).off(ns).on('hashchange' + ns, EEA.guard($scope, ns, fromHash));
                // A link to the hash that is already in the URL fires no hashchange.
                $(document).off(ns).on('click' + ns, 'a[href$="#' + hash + '"]', EEA.guard($scope, ns, function () {
                    set(true);
                }));
            }
        },

        switcherBlock: function ($scope) {
            var $container = $scope.find('.eead-switcher-container').first(),
                $tabs = $container.find('.eead-switcher-tab'),
                ns = EEA.ns($scope, 'Switcher');

            if (!$tabs.length) {
                return;
            }

            // The sliding pill follows the active option; measured again when fonts
            // or the window change its size.
            var placePill = function () {
                var $active = $tabs.filter('.eead-switcher-active-tab');
                if ($active.length) {
                    $container.find('.eead-switcher-slider').css({
                        'width': $active.outerWidth() + 'px',
                        'left': $active.position().left + 'px'
                    });
                }
            };

            var activate = function ($tab, focus) {
                if (!$tab.hasClass('eead-switcher-active-tab')) {
                    $tabs.removeClass('eead-switcher-active-tab').attr({'aria-selected': 'false', tabindex: '-1'});
                    $container.find('.eead-switcher-content').removeClass('eead-switcher-active-content');
                    $tab.addClass('eead-switcher-active-tab').attr({'aria-selected': 'true', tabindex: '0'});
                    $container.find('.eead-switcher-content-' + $tab.attr('data-switchid')).addClass('eead-switcher-active-content');
                    placePill();
                    // Sliders/carousels in the newly shown content re-measure.
                    setTimeout(function () {
                        window.dispatchEvent(new Event('resize'));
                    }, 30);
                }
                if (focus) {
                    $tab.trigger('focus');
                }
            };

            placePill();
            if (document.fonts && document.fonts.ready) {
                document.fonts.ready.then(placePill);
            }
            $(window).off(ns).on('resize' + ns + ' load' + ns, EEA.guard($scope, ns, placePill));

            $tabs.off('.eeadSwitcher').on('click.eeadSwitcher', function () {
                activate($(this), false);
            }).on('keydown.eeadSwitcher', function (e) {
                var index = $tabs.index(this), next = null;
                if (e.key === 'ArrowRight' || e.key === 'ArrowDown') {
                    next = (index + 1) % $tabs.length;
                } else if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') {
                    next = (index - 1 + $tabs.length) % $tabs.length;
                } else if (e.key === 'Home') {
                    next = 0;
                } else if (e.key === 'End') {
                    next = $tabs.length - 1;
                }
                if (next !== null) {
                    e.preventDefault();
                    activate($tabs.eq(next), true);
                    return;
                }
                EEA.activateOnKey.call(this, e);
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

            $scope.find('.eead-sticky-player-close').off('.eeadSticky').on('click.eeadSticky', function () {
                stickyVideo.removeClass('out').addClass('in');
                player.pause();
                videoIsActive = 'off';
            }).on('keydown.eeadSticky', EEA.activateOnKey);

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

            var ns = EEA.ns($scope, 'StickyVideo');
            $(window).off(ns);

            if (sticky == 'yes') {
                var floatsHere = function () {
                    return stickyVideo.attr('data-mobile') !== 'no' || !window.matchMedia('(max-width: 767px)').matches;
                };
                // The placeholder keeps the page from jumping while the player floats.
                var keepSpace = function () {
                    if (!stickyVideo.hasClass('out')) {
                        videoContainer.css('height', stickyVideo.height() + 'px');
                    }
                };
                // Measured on every check rather than once after load, so content that
                // loads later and moves the video doesn't throw the float point off.
                var check = function () {
                    var gone = videoContainer[0].getBoundingClientRect().bottom < 0;
                    if (gone && videoIsActive === 'on' && floatsHere()) {
                        stickyVideo.removeClass('in').addClass('out');
                    } else if (!gone || !floatsHere()) {
                        stickyVideo.removeClass('out').addClass('in');
                    }
                };

                setTimeout(keepSpace, 300);
                $(window).on('load' + ns, keepSpace);
                $(window).on('resize' + ns, EEA.guard($scope, ns, function () {
                    keepSpace();
                    check();
                }));
                $(window).on('scroll' + ns, EEA.guard($scope, ns, check));
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
                // Load the iframe once, with autoplay on wherever it sits in the query.
                var src = iframe.data('lazy-load') || iframe[0].src;
                if (!autoplay && src) {
                    try {
                        var url = new URL(src, window.location.href);
                        url.searchParams.set('autoplay', '1');
                        src = url.toString();
                    } catch (e) {
                        src = src.replace(/([?&])autoplay=0/, '$1autoplay=1');
                    }
                }
                if (src && iframe[0].src !== src) {
                    iframe[0].src = src;
                }
                overlay.remove();
                hasOverlay = false;
            }

            function resizeVideo() {
                var videoHeight = video.outerHeight();
                videoContainer.height(videoHeight);
            }
        },

        socialShare: function ($scope) {
            var $copy = $scope.find('.eead-share-copy'),
                $native = $scope.find('.eead-share-native');

            // The device share sheet only where the browser has one.
            if ($native.length && navigator.share) {
                $native.prop('hidden', false);
            }
            $native.off('.eeadShare').on('click.eeadShare', function (e) {
                e.preventDefault();
                navigator.share({title: $(this).attr('data-title'), url: $(this).attr('data-url')}).catch(function () {
                });
            });

            $copy.off('.eeadShare').on('click.eeadShare', function (e) {
                e.preventDefault();
                var $btn = $(this), url = $btn.attr('data-url'),
                    $text = $btn.find('.eead-social-share-text'),
                    label = $btn.attr('aria-label'),
                    done = function () {
                        // Brief confirmation, read out by screen readers too.
                        $btn.addClass('eead-share-copied').attr('aria-label', $btn.attr('data-done'));
                        var original = $text.text();
                        $text.text($btn.attr('data-done'));
                        EEA.announce($btn.attr('data-done'));
                        setTimeout(function () {
                            $btn.removeClass('eead-share-copied').attr('aria-label', label);
                            $text.text(original);
                        }, 2000);
                    };
                if (navigator.clipboard && window.isSecureContext) {
                    navigator.clipboard.writeText(url).then(done, function () {
                        window.prompt('', url);
                    });
                } else {
                    // Older browsers / plain http: a selectable field the visitor can copy.
                    window.prompt('', url);
                }
            });
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
                    // No self-moving slides for visitors who turned motion off.
                    autoplay: JSON.parse(params.autoplay) && !EEA.reducedMotion(),
                    speed: params.speed,
                    autoplaySpeed: params.pause || 3000,
                    pauseOnHover: JSON.parse(params.pause_on_hover),
                    arrows: JSON.parse(params.arrows),
                    dots: JSON.parse(params.dots),
                    adaptiveHeight: JSON.parse(params.auto_height),
                    // Divs (so theme button styles don't leak in) made into real controls.
                    // Slick only inserts arrows given as an HTML string; outerHTML keeps the values escaped.
                    prevArrow: $('<div class="slick-prev slick-arrow" role="button" tabindex="0"><i aria-hidden="true"></i></div>').attr('aria-label', params.prev_label || 'Previous slide').find('i').attr('class', params.prev_icon).end().prop('outerHTML'),
                    nextArrow: $('<div class="slick-next slick-arrow" role="button" tabindex="0"><i aria-hidden="true"></i></div>').attr('aria-label', params.next_label || 'Next slide').find('i').attr('class', params.next_icon).end().prop('outerHTML'),
                    fade: $slider.attr('data-transition') == 'fade' ? true : false,
                    appendArrows: $scope.find('.slick-nav'),
                    appendDots: $scope.find('.slick-dots-wrap')
                };

                $slider.on('init', function (event, slick) {
                    // Slick strips tabindex from non-button arrows while building them.
                    $scope.find('.slick-nav .slick-arrow').not('.slick-hidden').attr('tabindex', '0');
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

                // Enter/Space on the arrow divs, as on a button.
                $scope.find('.slick-nav').off('keydown.eeadSlider').on('keydown.eeadSlider', '.slick-arrow', EEA.activateOnKey);

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
                    autoplay: JSON.parse(params.autoplay) && !EEA.reducedMotion(),
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
                EEA.owlA11y($ele);
            }
        },

        testimonialCarousel: function ($scope) {
            var $ele = $scope.find('.eead-testimonial-carousel');
            if ($ele.length > 0) {
                var params = JSON.parse($ele.attr('data-params'));
                $ele.owlCarousel({
                    loop: JSON.parse(params.loop),
                    autoplay: JSON.parse(params.autoplay) && !EEA.reducedMotion(),
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
                EEA.owlA11y($ele);
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