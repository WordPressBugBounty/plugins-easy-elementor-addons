/**!
 * lightgallery.js | 1.3.0 | September 1st 2020
 * http://sachinchoolur.github.io/lightgallery.js/
 * Copyright (c) 2016 Sachin N; 
 * @license GPLv3 
 */(function(f){if(typeof exports==="object"&&typeof module!=="undefined"){module.exports=f()}else if(typeof define==="function"&&define.amd){define([],f)}else{var g;if(typeof window!=="undefined"){g=window}else if(typeof global!=="undefined"){g=global}else if(typeof self!=="undefined"){g=self}else{g=this}g.Lightgallery = f()}})(function(){var define,module,exports;return (function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(require,module,exports){
    (function (global, factory) {
        if (typeof define === "function" && define.amd) {
            define(['exports'], factory);
        } else if (typeof exports !== "undefined") {
            factory(exports);
        } else {
            var mod = {
                exports: {}
            };
            factory(mod.exports);
            global.lgUtils = mod.exports;
        }
    })(this, function (exports) {
        'use strict';
    
        Object.defineProperty(exports, "__esModule", {
            value: true
        });
    
        var utils = {
            getAttribute: function getAttribute(el, label) {
                return el[label];
            },
    
            setAttribute: function setAttribute(el, label, value) {
                el[label] = value;
            },
            wrap: function wrap(el, className) {
                if (!el) {
                    return;
                }
    
                var wrapper = document.createElement('div');
                wrapper.className = className;
                el.parentNode.insertBefore(wrapper, el);
                el.parentNode.removeChild(el);
                wrapper.appendChild(el);
            },
    
            addClass: function addClass(el, className) {
                if (!el) {
                    return;
                }
    
                if (el.classList) {
                    el.classList.add(className);
                } else {
                    el.className += ' ' + className;
                }
            },
    
            removeClass: function removeClass(el, className) {
                if (!el) {
                    return;
                }
    
                if (el.classList) {
                    el.classList.remove(className);
                } else {
                    el.className = el.className.replace(new RegExp('(^|\\b)' + className.split(' ').join('|') + '(\\b|$)', 'gi'), ' ');
                }
            },
    
            hasClass: function hasClass(el, className) {
                if (el.classList) {
                    return el.classList.contains(className);
                } else {
                    return new RegExp('(^| )' + className + '( |$)', 'gi').test(el.className);
                }
            },
    
            // ex Transform
            // ex TransitionTimingFunction
            setVendor: function setVendor(el, property, value) {
                if (!el) {
                    return;
                }
    
                el.style[property.charAt(0).toLowerCase() + property.slice(1)] = value;
                el.style['webkit' + property] = value;
                el.style['moz' + property] = value;
                el.style['ms' + property] = value;
                el.style['o' + property] = value;
            },
    
            trigger: function trigger(el, event) {
                var detail = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : null;
    
                if (!el) {
                    return;
                }
    
                var customEvent = new CustomEvent(event, {
                    detail: detail
                });
                el.dispatchEvent(customEvent);
            },
    
            Listener: {
                uid: 0
            },
            on: function on(el, events, fn) {
                var _this = this;
    
                if (!el) {
                    return;
                }
    
                events.split(' ').forEach(function (event) {
                    var _id = _this.getAttribute(el, 'lg-event-uid') || '';
                    utils.Listener.uid++;
                    _id += '&' + utils.Listener.uid;
                    _this.setAttribute(el, 'lg-event-uid', _id);
                    utils.Listener[event + utils.Listener.uid] = fn;
                    el.addEventListener(event.split('.')[0], fn, false);
                });
            },
    
            off: function off(el, event) {
                if (!el) {
                    return;
                }
    
                var _id = this.getAttribute(el, 'lg-event-uid');
                if (_id) {
                    _id = _id.split('&');
                    for (var i = 0; i < _id.length; i++) {
                        if (_id[i]) {
                            var _event = event + _id[i];
                            if (_event.substring(0, 1) === '.') {
                                for (var key in utils.Listener) {
                                    if (utils.Listener.hasOwnProperty(key)) {
                                        if (key.split('.').indexOf(_event.split('.')[1]) > -1) {
                                            el.removeEventListener(key.split('.')[0], utils.Listener[key]);
                                            this.setAttribute(el, 'lg-event-uid', this.getAttribute(el, 'lg-event-uid').replace('&' + _id[i], ''));
                                            delete utils.Listener[key];
                                        }
                                    }
                                }
                            } else {
                                el.removeEventListener(_event.split('.')[0], utils.Listener[_event]);
                                this.setAttribute(el, 'lg-event-uid', this.getAttribute(el, 'lg-event-uid').replace('&' + _id[i], ''));
                                delete utils.Listener[_event];
                            }
                        }
                    }
                }
            },
    
            param: function param(obj) {
                return Object.keys(obj).map(function (k) {
                    return encodeURIComponent(k) + '=' + encodeURIComponent(obj[k]);
                }).join('&');
            }
        };
    
        exports.default = utils;
    });
    
    },{}],2:[function(require,module,exports){
    (function (global, factory) {
        if (typeof define === "function" && define.amd) {
            define(['./lg-utils'], factory);
        } else if (typeof exports !== "undefined") {
            factory(require('./lg-utils'));
        } else {
            var mod = {
                exports: {}
            };
            factory(global.lgUtils);
            global.lightgallery = mod.exports;
        }
    })(this, function (_lgUtils) {
        'use strict';
    
        var _lgUtils2 = _interopRequireDefault(_lgUtils);
    
        function _interopRequireDefault(obj) {
            return obj && obj.__esModule ? obj : {
                default: obj
            };
        }
    
        var _extends = Object.assign || function (target) {
            for (var i = 1; i < arguments.length; i++) {
                var source = arguments[i];
    
                for (var key in source) {
                    if (Object.prototype.hasOwnProperty.call(source, key)) {
                        target[key] = source[key];
                    }
                }
            }
    
            return target;
        };
    
        /** Polyfill the CustomEvent() constructor functionality in Internet Explorer 9 and higher */
        (function () {
    
            if (typeof window.CustomEvent === 'function') {
                return false;
            }
    
            function CustomEvent(event, params) {
                params = params || {
                    bubbles: false,
                    cancelable: false,
                    detail: undefined
                };
                var evt = document.createEvent('CustomEvent');
                evt.initCustomEvent(event, params.bubbles, params.cancelable, params.detail);
                return evt;
            }
    
            CustomEvent.prototype = window.Event.prototype;
    
            window.CustomEvent = CustomEvent;
        })();
    
        window.utils = _lgUtils2.default;
        window.lgData = {
            uid: 0
        };
    
        window.lgModules = {};
        var defaults = {
    
            mode: 'lg-slide',
    
            // Ex : 'ease'
            cssEasing: 'ease',
    
            //'for jquery animation'
            easing: 'linear',
            speed: 600,
            height: '100%',
            width: '100%',
            addClass: '',
            startClass: 'lg-start-zoom',
            backdropDuration: 150,
            hideBarsDelay: 6000,
    
            useLeft: false,
    
            // aria-labelledby attribute fot gallery
            ariaLabelledby: '',
    
            //aria-describedby attribute for gallery
            ariaDescribedby: '',
    
            closable: true,
            loop: true,
            escKey: true,
            keyPress: true,
            controls: true,
            slideEndAnimatoin: true,
            hideControlOnEnd: false,
            mousewheel: false,
    
            getCaptionFromTitleOrAlt: true,
    
            // .lg-item || '.lg-sub-html'
            appendSubHtmlTo: '.lg-sub-html',
    
            subHtmlSelectorRelative: false,
    
            /**
             * @desc number of preload slides
             * will exicute only after the current slide is fully loaded.
             *
             * @ex you clicked on 4th image and if preload = 1 then 3rd slide and 5th
             * slide will be loaded in the background after the 4th slide is fully loaded..
             * if preload is 2 then 2nd 3rd 5th 6th slides will be preloaded.. ... ...
             *
             */
            preload: 1,
            showAfterLoad: true,
            selector: '',
            selectWithin: '',
            nextHtml: '',
            prevHtml: '',
    
            // 0, 1
            index: false,
    
            iframeMaxWidth: '100%',
    
            download: true,
            counter: true,
            appendCounterTo: '.lg-toolbar',
    
            swipeThreshold: 50,
            enableSwipe: true,
            enableDrag: true,
    
            dynamic: false,
            dynamicEl: [],
            galleryId: 1
        };
    
        function Plugin(element, options) {
    
            // Current lightGallery element
            this.el = element;
    
            // lightGallery settings
            this.s = _extends({}, defaults, options);
    
            // When using dynamic mode, ensure dynamicEl is an array
            if (this.s.dynamic && this.s.dynamicEl !== 'undefined' && this.s.dynamicEl.constructor === Array && !this.s.dynamicEl.length) {
                throw 'When using dynamic mode, you must also define dynamicEl as an Array.';
            }
    
            // lightGallery modules
            this.modules = {};
    
            // false when lightgallery complete first slide;
            this.lGalleryOn = false;
    
            this.lgBusy = false;
    
            // Timeout function for hiding controls;
            this.hideBartimeout = false;
    
            // To determine browser supports for touch events;
            this.isTouch = 'ontouchstart' in document.documentElement;
    
            // Disable hideControlOnEnd if sildeEndAnimation is true
            if (this.s.slideEndAnimatoin) {
                this.s.hideControlOnEnd = false;
            }
    
            this.items = [];
    
            // Gallery items
            if (this.s.dynamic) {
                this.items = this.s.dynamicEl;
            } else {
                if (this.s.selector === 'this') {
                    this.items.push(this.el);
                } else if (this.s.selector !== '') {
                    if (this.s.selectWithin) {
                        this.items = document.querySelector(this.s.selectWithin).querySelectorAll(this.s.selector);
                    } else {
                        this.items = this.el.querySelectorAll(this.s.selector);
                    }
                } else {
                    this.items = this.el.children;
                }
            }
    
            // .lg-item
    
            this.___slide = '';
    
            // .lg-outer
            this.outer = '';
    
            this.init();
    
            return this;
        }
    
        Plugin.prototype.init = function () {
    
            var _this = this;
    
            // s.preload should not be more than $item.length
            if (_this.s.preload > _this.items.length) {
                _this.s.preload = _this.items.length;
            }
    
            // if dynamic option is enabled execute immediately
            var _hash = window.location.hash;
            if (_hash.indexOf('lg=' + this.s.galleryId) > 0) {
    
                _this.index = parseInt(_hash.split('&slide=')[1], 10);
    
                _lgUtils2.default.addClass(document.body, 'lg-from-hash');
                if (!_lgUtils2.default.hasClass(document.body, 'lg-on')) {
                    _lgUtils2.default.addClass(document.body, 'lg-on');
                    setTimeout(function () {
                        _this.build(_this.index);
                    });
                }
            }
    
            if (_this.s.dynamic) {
    
                _lgUtils2.default.trigger(this.el, 'onBeforeOpen');
    
                _this.index = _this.s.index || 0;
    
                // prevent accidental double execution
                if (!_lgUtils2.default.hasClass(document.body, 'lg-on')) {
                    _lgUtils2.default.addClass(document.body, 'lg-on');
                    setTimeout(function () {
                        _this.build(_this.index);
                    });
                }
            } else {
    
                for (var i = 0; i < _this.items.length; i++) {
    
                    /*jshint loopfunc: true */
                    (function (index) {
    
                        // Using different namespace for click because click event should not unbind if selector is same object('this')
                        _lgUtils2.default.on(_this.items[index], 'click.lgcustom', function (e) {
    
                            e.preventDefault();
    
                            _lgUtils2.default.trigger(_this.el, 'onBeforeOpen');
    
                            _this.index = _this.s.index || index;
    
                            if (!_lgUtils2.default.hasClass(document.body, 'lg-on')) {
                                _this.build(_this.index);
                                _lgUtils2.default.addClass(document.body, 'lg-on');
                            }
                        });
                    })(i);
                }
            }
        };
    
        Plugin.prototype.build = function (index) {
    
            var _this = this;
    
            _this.structure();
    
            for (var key in window.lgModules) {
                _this.modules[key] = new window.lgModules[key](_this.el);
            }
    
            // initiate slide function
            _this.slide(index, false, false);
    
            if (_this.s.keyPress) {
                _this.keyPress();
            }
    
            if (_this.items.length > 1) {
    
                _this.arrow();
    
                setTimeout(function () {
                    _this.enableDrag();
                    _this.enableSwipe();
                }, 50);
    
                if (_this.s.mousewheel) {
                    _this.mousewheel();
                }
            }
    
            _this.counter();
    
            _this.closeGallery();
    
            _lgUtils2.default.trigger(_this.el, 'onAfterOpen');
    
            // Hide controllers if mouse doesn't move for some period
            _lgUtils2.default.on(_this.outer, 'mousemove.lg click.lg touchstart.lg', function () {
    
                _lgUtils2.default.removeClass(_this.outer, 'lg-hide-items');
    
                clearTimeout(_this.hideBartimeout);
    
                // Timeout will be cleared on each slide movement also
                _this.hideBartimeout = setTimeout(function () {
                    _lgUtils2.default.addClass(_this.outer, 'lg-hide-items');
                }, _this.s.hideBarsDelay);
            });
        };
    
        Plugin.prototype.structure = function () {
            var list = '';
            var controls = '';
            var i = 0;
            var subHtmlCont = '';
            var template;
            var _this = this;
    
            document.body.insertAdjacentHTML('beforeend', '<div class="lg-backdrop"></div>');
            _lgUtils2.default.setVendor(document.querySelector('.lg-backdrop'), 'TransitionDuration', this.s.backdropDuration + 'ms');
    
            // Create gallery items
            for (i = 0; i < this.items.length; i++) {
                list += '<div class="lg-item"></div>';
            }
    
            // Create controlls
            if (this.s.controls && this.items.length > 1) {
                controls = '<div class="lg-actions">' + '<button type="button" aria-label="Previous slide" class="lg-prev lg-icon">' + this.s.prevHtml + '</button>' + '<button type="button" aria-label="Next slide" class="lg-next lg-icon">' + this.s.nextHtml + '</button>' + '</div>';
            }
    
            if (this.s.appendSubHtmlTo === '.lg-sub-html') {
                subHtmlCont = '<div role="status" aria-live="polite" class="lg-sub-html"></div>';
            }
    
            var ariaLabelledby = this.s.ariaLabelledby ? 'aria-labelledby="' + this.s.ariaLabelledby + '"' : '';
            var ariaDescribedby = this.s.ariaDescribedby ? 'aria-describedby="' + this.s.ariaDescribedby + '"' : '';
    
            template = '<div tabindex="-1" aria-modal="true" ' + ariaLabelledby + ' ' + ariaDescribedby + ' role="dialog" class="lg-outer ' + this.s.addClass + ' ' + this.s.startClass + '">' + '<div class="lg" style="width:' + this.s.width + '; height:' + this.s.height + '">' + '<div class="lg-inner">' + list + '</div>' + '<div class="lg-toolbar group">' + '<button type="button" aria-label="Close gallery" class="lg-close lg-icon"></button>' + '</div>' + controls + subHtmlCont + '</div>' + '</div>';
    
            document.body.insertAdjacentHTML('beforeend', template);
            this.outer = document.querySelector('.lg-outer');
            this.outer.focus();
            this.___slide = this.outer.querySelectorAll('.lg-item');
    
            if (this.s.useLeft) {
                _lgUtils2.default.addClass(this.outer, 'lg-use-left');
    
                // Set mode lg-slide if use left is true;
                this.s.mode = 'lg-slide';
            } else {
                _lgUtils2.default.addClass(this.outer, 'lg-use-css3');
            }
    
            // For fixed height gallery
            _this.setTop();
            _lgUtils2.default.on(window, 'resize.lg orientationchange.lg', function () {
                setTimeout(function () {
                    _this.setTop();
                }, 100);
            });
    
            // add class lg-current to remove initial transition
            _lgUtils2.default.addClass(this.___slide[this.index], 'lg-current');
    
            // add Class for css support and transition mode
            if (this.doCss()) {
                _lgUtils2.default.addClass(this.outer, 'lg-css3');
            } else {
                _lgUtils2.default.addClass(this.outer, 'lg-css');
    
                // Set speed 0 because no animation will happen if browser doesn't support css3
                this.s.speed = 0;
            }
    
            _lgUtils2.default.addClass(this.outer, this.s.mode);
    
            if (this.s.enableDrag && this.items.length > 1) {
                _lgUtils2.default.addClass(this.outer, 'lg-grab');
            }
    
            if (this.s.showAfterLoad) {
                _lgUtils2.default.addClass(this.outer, 'lg-show-after-load');
            }
    
            if (this.doCss()) {
                var inner = this.outer.querySelector('.lg-inner');
                _lgUtils2.default.setVendor(inner, 'TransitionTimingFunction', this.s.cssEasing);
                _lgUtils2.default.setVendor(inner, 'TransitionDuration', this.s.speed + 'ms');
            }
    
            setTimeout(function () {
                _lgUtils2.default.addClass(document.querySelector('.lg-backdrop'), 'in');
            });
    
            setTimeout(function () {
                _lgUtils2.default.addClass(_this.outer, 'lg-visible');
            }, this.s.backdropDuration);
    
            if (this.s.download) {
                this.outer.querySelector('.lg-toolbar').insertAdjacentHTML('beforeend', '<a id="lg-download" aria-label="Download" target="_blank" download class="lg-download lg-icon"></a>');
            }
    
            // Store the current scroll top value to scroll back after closing the gallery..
            this.prevScrollTop = document.documentElement.scrollTop || document.body.scrollTop;
        };
    
        // For fixed height gallery
        Plugin.prototype.setTop = function () {
            if (this.s.height !== '100%') {
                var wH = window.innerHeight;
                var top = (wH - parseInt(this.s.height, 10)) / 2;
                var lGallery = this.outer.querySelector('.lg');
                if (wH >= parseInt(this.s.height, 10)) {
                    lGallery.style.top = top + 'px';
                } else {
                    lGallery.style.top = '0px';
                }
            }
        };
    
        // Find css3 support
        Plugin.prototype.doCss = function () {
            // check for css animation support
            var support = function support() {
                var transition = ['transition', 'MozTransition', 'WebkitTransition', 'OTransition', 'msTransition', 'KhtmlTransition'];
                var root = document.documentElement;
                var i = 0;
                for (i = 0; i < transition.length; i++) {
                    if (transition[i] in root.style) {
                        return true;
                    }
                }
            };
    
            if (support()) {
                return true;
            }
    
            return false;
        };
    
        /**
         *  @desc Check the given src is video
         *  @param {String} src
         *  @return {Object} video type
         *  Ex:{ youtube  :  ["//www.youtube.com/watch?v=c0asJgSyxcY", "c0asJgSyxcY"] }
         */
        Plugin.prototype.isVideo = function (src, index) {
    
            var html;
            if (this.s.dynamic) {
                html = this.s.dynamicEl[index].html;
            } else {
                html = this.items[index].getAttribute('data-html');
            }
    
            if (!src && html) {
                return {
                    html5: true
                };
            }
    
            var youtube = src.match(/\/\/(?:www\.)?youtu(?:\.be|be\.com|be-nocookie\.com)\/(?:watch\?v=|embed\/)?([a-z0-9\-\_\%]+)/i);
            var vimeo = src.match(/\/\/(?:www\.)?vimeo.com\/([0-9a-z\-_]+)/i);
            var dailymotion = src.match(/\/\/(?:www\.)?dai.ly\/([0-9a-z\-_]+)/i);
            var vk = src.match(/\/\/(?:www\.)?(?:vk\.com|vkontakte\.ru)\/(?:video_ext\.php\?)(.*)/i);
    
            if (youtube) {
                return {
                    youtube: youtube
                };
            } else if (vimeo) {
                return {
                    vimeo: vimeo
                };
            } else if (dailymotion) {
                return {
                    dailymotion: dailymotion
                };
            } else if (vk) {
                return {
                    vk: vk
                };
            }
        };
    
        /**
         *  @desc Create image counter
         *  Ex: 1/10
         */
        Plugin.prototype.counter = function () {
            if (this.s.counter) {
                this.outer.querySelector(this.s.appendCounterTo).insertAdjacentHTML('beforeend', '<div id="lg-counter" role="status" aria-live="polite"><span id="lg-counter-current">' + (parseInt(this.index, 10) + 1) + '</span> / <span id="lg-counter-all">' + this.items.length + '</span></div>');
            }
        };
    
        /**
         *  @desc add sub-html into the slide
         *  @param {Number} index - index of the slide
         */
        Plugin.prototype.addHtml = function (index) {
            var subHtml = null;
            var currentEle;
            if (this.s.dynamic) {
                subHtml = this.s.dynamicEl[index].subHtml;
            } else {
                currentEle = this.items[index];
                subHtml = currentEle.getAttribute('data-sub-html');
                if (this.s.getCaptionFromTitleOrAlt && !subHtml) {
                    subHtml = currentEle.getAttribute('title');
                    if (subHtml && currentEle.querySelector('img')) {
                        subHtml = currentEle.querySelector('img').getAttribute('alt');
                    }
                }
            }
    
            if (typeof subHtml !== 'undefined' && subHtml !== null) {
    
                // get first letter of subhtml
                // if first letter starts with . or # get the html form the jQuery object
                var fL = subHtml.substring(0, 1);
                if (fL === '.' || fL === '#') {
                    if (this.s.subHtmlSelectorRelative && !this.s.dynamic) {
                        subHtml = currentEle.querySelector(subHtml).innerHTML;
                    } else {
                        subHtml = document.querySelector(subHtml).innerHTML;
                    }
                }
            } else {
                subHtml = '';
            }
    
            if (this.s.appendSubHtmlTo === '.lg-sub-html') {
                this.outer.querySelector(this.s.appendSubHtmlTo).innerHTML = subHtml;
            } else {
                this.___slide[index].insertAdjacentHTML('beforeend', subHtml);
            }
    
            // Add lg-empty-html class if title doesn't exist
            if (typeof subHtml !== 'undefined' && subHtml !== null) {
                if (subHtml === '') {
                    _lgUtils2.default.addClass(this.outer.querySelector(this.s.appendSubHtmlTo), 'lg-empty-html');
                } else {
                    _lgUtils2.default.removeClass(this.outer.querySelector(this.s.appendSubHtmlTo), 'lg-empty-html');
                }
            }
    
            _lgUtils2.default.trigger(this.el, 'onAfterAppendSubHtml', {
                index: index
            });
        };
    
        /**
         *  @desc Preload slides
         *  @param {Number} index - index of the slide
         */
        Plugin.prototype.preload = function (index) {
            var i = 1;
            var j = 1;
            for (i = 1; i <= this.s.preload; i++) {
                if (i >= this.items.length - index) {
                    break;
                }
    
                this.loadContent(index + i, false, 0);
            }
    
            for (j = 1; j <= this.s.preload; j++) {
                if (index - j < 0) {
                    break;
                }
    
                this.loadContent(index - j, false, 0);
            }
        };
    
        /**
         *  @desc Load slide content into slide.
         *  @param {Number} index - index of the slide.
         *  @param {Boolean} rec - if true call loadcontent() function again.
         *  @param {Boolean} delay - delay for adding complete class. it is 0 except first time.
         */
        Plugin.prototype.loadContent = function (index, rec, delay) {
    
            var _this = this;
            var _hasPoster = false;
            var _img;
            var _src;
            var _poster;
            var _srcset;
            var _sizes;
            var _html;
            var _alt;
            var getResponsiveSrc = function getResponsiveSrc(srcItms) {
                var rsWidth = [];
                var rsSrc = [];
                for (var i = 0; i < srcItms.length; i++) {
                    var __src = srcItms[i].split(' ');
    
                    // Manage empty space
                    if (__src[0] === '') {
                        __src.splice(0, 1);
                    }
    
                    rsSrc.push(__src[0]);
                    rsWidth.push(__src[1]);
                }
    
                var wWidth = window.innerWidth;
                for (var j = 0; j < rsWidth.length; j++) {
                    if (parseInt(rsWidth[j], 10) > wWidth) {
                        _src = rsSrc[j];
                        break;
                    }
                }
            };
    
            if (_this.s.dynamic) {
    
                if (_this.s.dynamicEl[index].poster) {
                    _hasPoster = true;
                    _poster = _this.s.dynamicEl[index].poster;
                }
    
                _html = _this.s.dynamicEl[index].html;
                _src = _this.s.dynamicEl[index].src;
                _alt = _this.s.dynamicEl[index].alt;
    
                if (_this.s.dynamicEl[index].responsive) {
                    var srcDyItms = _this.s.dynamicEl[index].responsive.split(',');
                    getResponsiveSrc(srcDyItms);
                }
    
                _srcset = _this.s.dynamicEl[index].srcset;
                _sizes = _this.s.dynamicEl[index].sizes;
            } else {
    
                if (_this.items[index].getAttribute('data-poster')) {
                    _hasPoster = true;
                    _poster = _this.items[index].getAttribute('data-poster');
                }
    
                _html = _this.items[index].getAttribute('data-html');
                _src = _this.items[index].getAttribute('href') || _this.items[index].getAttribute('data-src');
                _alt = _this.items[index].getAttribute('title');
    
                if (_this.items[index].querySelector('img')) {
                    _alt = _alt || _this.items[index].querySelector('img').getAttribute('alt');
                }
    
                if (_this.items[index].getAttribute('data-responsive')) {
                    var srcItms = _this.items[index].getAttribute('data-responsive').split(',');
                    getResponsiveSrc(srcItms);
                }
    
                _srcset = _this.items[index].getAttribute('data-srcset');
                _sizes = _this.items[index].getAttribute('data-sizes');
            }
    
            //if (_src || _srcset || _sizes || _poster) {
    
            var iframe = false;
            if (_this.s.dynamic) {
                if (_this.s.dynamicEl[index].iframe) {
                    iframe = true;
                }
            } else {
                if (_this.items[index].getAttribute('data-iframe') === 'true') {
                    iframe = true;
                }
            }
    
            var _isVideo = _this.isVideo(_src, index);
            if (!_lgUtils2.default.hasClass(_this.___slide[index], 'lg-loaded')) {
                if (iframe) {
                    _this.___slide[index].insertAdjacentHTML('afterbegin', '<div class="lg-video-cont" style="max-width:' + _this.s.iframeMaxWidth + '"><div class="lg-video"><iframe class="lg-object" frameborder="0" src="' + _src + '"  allowfullscreen="true"></iframe></div></div>');
                } else if (_hasPoster) {
                    var videoClass = '';
                    if (_isVideo && _isVideo.youtube) {
                        videoClass = 'lg-has-youtube';
                    } else if (_isVideo && _isVideo.vimeo) {
                        videoClass = 'lg-has-vimeo';
                    } else {
                        videoClass = 'lg-has-html5';
                    }
    
                    _this.___slide[index].insertAdjacentHTML('beforeend', '<div class="lg-video-cont ' + videoClass + ' "><div class="lg-video"><span class="lg-video-play"></span><img class="lg-object lg-has-poster" src="' + _poster + '" /></div></div>');
                } else if (_isVideo) {
                    _this.___slide[index].insertAdjacentHTML('beforeend', '<div class="lg-video-cont "><div class="lg-video"></div></div>');
                    _lgUtils2.default.trigger(_this.el, 'hasVideo', {
                        index: index,
                        src: _src,
                        html: _html
                    });
                } else {
                    _alt = _alt ? 'alt="' + _alt + '"' : '';
                    _this.___slide[index].insertAdjacentHTML('beforeend', '<div class="lg-img-wrap"><img class="lg-object lg-image" ' + _alt + ' src="' + _src + '" /></div>');
                }
    
                _lgUtils2.default.trigger(_this.el, 'onAferAppendSlide', {
                    index: index
                });
    
                _img = _this.___slide[index].querySelector('.lg-object');
                if (_sizes) {
                    _img.setAttribute('sizes', _sizes);
                }
    
                if (_srcset) {
                    _img.setAttribute('srcset', _srcset);
                    try {
                        picturefill({
                            elements: [_img[0]]
                        });
                    } catch (e) {
                        console.error('Make sure you have included Picturefill version 2');
                    }
                }
    
                if (this.s.appendSubHtmlTo !== '.lg-sub-html') {
                    _this.addHtml(index);
                }
    
                _lgUtils2.default.addClass(_this.___slide[index], 'lg-loaded');
            }
    
            _lgUtils2.default.on(_this.___slide[index].querySelector('.lg-object'), 'load.lg error.lg', function () {
    
                // For first time add some delay for displaying the start animation.
                var _speed = 0;
    
                // Do not change the delay value because it is required for zoom plugin.
                // If gallery opened from direct url (hash) speed value should be 0
                if (delay && !_lgUtils2.default.hasClass(document.body, 'lg-from-hash')) {
                    _speed = delay;
                }
    
                setTimeout(function () {
                    _lgUtils2.default.addClass(_this.___slide[index], 'lg-complete');
    
                    _lgUtils2.default.trigger(_this.el, 'onSlideItemLoad', {
                        index: index,
                        delay: delay || 0
                    });
                }, _speed);
            });
    
            // @todo check load state for html5 videos
            if (_isVideo && _isVideo.html5 && !_hasPoster) {
                _lgUtils2.default.addClass(_this.___slide[index], 'lg-complete');
            }
    
            if (rec === true) {
                if (!_lgUtils2.default.hasClass(_this.___slide[index], 'lg-complete')) {
                    _lgUtils2.default.on(_this.___slide[index].querySelector('.lg-object'), 'load.lg error.lg', function () {
                        _this.preload(index);
                    });
                } else {
                    _this.preload(index);
                }
            }
    
            //}
        };
    
        /**
        *   @desc slide function for lightgallery
            ** Slide() gets call on start
            ** ** Set lg.on true once slide() function gets called.
            ** Call loadContent() on slide() function inside setTimeout
            ** ** On first slide we do not want any animation like slide of fade
            ** ** So on first slide( if lg.on if false that is first slide) loadContent() should start loading immediately
            ** ** Else loadContent() should wait for the transition to complete.
            ** ** So set timeout s.speed + 50
        <=> ** loadContent() will load slide content in to the particular slide
            ** ** It has recursion (rec) parameter. if rec === true loadContent() will call preload() function.
            ** ** preload will execute only when the previous slide is fully loaded (images iframe)
            ** ** avoid simultaneous image load
        <=> ** Preload() will check for s.preload value and call loadContent() again accoring to preload value
            ** loadContent()  <====> Preload();
        
        *   @param {Number} index - index of the slide
        *   @param {Boolean} fromTouch - true if slide function called via touch event or mouse drag
        *   @param {Boolean} fromThumb - true if slide function called via thumbnail click
        */
        Plugin.prototype.slide = function (index, fromTouch, fromThumb) {
    
            var _prevIndex = 0;
            for (var i = 0; i < this.___slide.length; i++) {
                if (_lgUtils2.default.hasClass(this.___slide[i], 'lg-current')) {
                    _prevIndex = i;
                    break;
                }
            }
    
            var _this = this;
    
            // Prevent if multiple call
            // Required for hsh plugin
            if (_this.lGalleryOn && _prevIndex === index) {
                return;
            }
    
            var _length = this.___slide.length;
            var _time = _this.lGalleryOn ? this.s.speed : 0;
            var _next = false;
            var _prev = false;
    
            if (!_this.lgBusy) {
    
                if (this.s.download) {
                    var _src;
                    if (_this.s.dynamic) {
                        _src = _this.s.dynamicEl[index].downloadUrl !== false && (_this.s.dynamicEl[index].downloadUrl || _this.s.dynamicEl[index].src);
                    } else {
                        _src = _this.items[index].getAttribute('data-download-url') !== 'false' && (_this.items[index].getAttribute('data-download-url') || _this.items[index].getAttribute('href') || _this.items[index].getAttribute('data-src'));
                    }
    
                    if (_src) {
                        document.getElementById('lg-download').setAttribute('href', _src);
                        _lgUtils2.default.removeClass(_this.outer, 'lg-hide-download');
                    } else {
                        _lgUtils2.default.addClass(_this.outer, 'lg-hide-download');
                    }
                }
    
                _lgUtils2.default.trigger(_this.el, 'onBeforeSlide', {
                    prevIndex: _prevIndex,
                    index: index,
                    fromTouch: fromTouch,
                    fromThumb: fromThumb
                });
    
                _this.lgBusy = true;
    
                clearTimeout(_this.hideBartimeout);
    
                // Add title if this.s.appendSubHtmlTo === lg-sub-html
                if (this.s.appendSubHtmlTo === '.lg-sub-html') {
    
                    // wait for slide animation to complete
                    setTimeout(function () {
                        _this.addHtml(index);
                    }, _time);
                }
    
                this.arrowDisable(index);
    
                if (!fromTouch) {
    
                    // remove all transitions
                    _lgUtils2.default.addClass(_this.outer, 'lg-no-trans');
    
                    for (var j = 0; j < this.___slide.length; j++) {
                        _lgUtils2.default.removeClass(this.___slide[j], 'lg-prev-slide');
                        _lgUtils2.default.removeClass(this.___slide[j], 'lg-next-slide');
                    }
    
                    if (index < _prevIndex) {
                        _prev = true;
                        if (index === 0 && _prevIndex === _length - 1 && !fromThumb) {
                            _prev = false;
                            _next = true;
                        }
                    } else if (index > _prevIndex) {
                        _next = true;
                        if (index === _length - 1 && _prevIndex === 0 && !fromThumb) {
                            _prev = true;
                            _next = false;
                        }
                    }
    
                    if (_prev) {
    
                        //prevslide
                        _lgUtils2.default.addClass(this.___slide[index], 'lg-prev-slide');
                        _lgUtils2.default.addClass(this.___slide[_prevIndex], 'lg-next-slide');
                    } else if (_next) {
    
                        // next slide
                        _lgUtils2.default.addClass(this.___slide[index], 'lg-next-slide');
                        _lgUtils2.default.addClass(this.___slide[_prevIndex], 'lg-prev-slide');
                    }
    
                    // give 50 ms for browser to add/remove class
                    setTimeout(function () {
                        _lgUtils2.default.removeClass(_this.outer.querySelector('.lg-current'), 'lg-current');
    
                        //_this.$slide.eq(_prevIndex).removeClass('lg-current');
                        _lgUtils2.default.addClass(_this.___slide[index], 'lg-current');
    
                        // reset all transitions
                        _lgUtils2.default.removeClass(_this.outer, 'lg-no-trans');
                    }, 50);
                } else {
    
                    var touchPrev = index - 1;
                    var touchNext = index + 1;
    
                    if (index === 0 && _prevIndex === _length - 1) {
    
                        // next slide
                        touchNext = 0;
                        touchPrev = _length - 1;
                    } else if (index === _length - 1 && _prevIndex === 0) {
    
                        // prev slide
                        touchNext = 0;
                        touchPrev = _length - 1;
                    }
    
                    _lgUtils2.default.removeClass(_this.outer.querySelector('.lg-prev-slide'), 'lg-prev-slide');
                    _lgUtils2.default.removeClass(_this.outer.querySelector('.lg-current'), 'lg-current');
                    _lgUtils2.default.removeClass(_this.outer.querySelector('.lg-next-slide'), 'lg-next-slide');
                    _lgUtils2.default.addClass(_this.___slide[touchPrev], 'lg-prev-slide');
                    _lgUtils2.default.addClass(_this.___slide[touchNext], 'lg-next-slide');
                    _lgUtils2.default.addClass(_this.___slide[index], 'lg-current');
                }
    
                if (_this.lGalleryOn) {
                    setTimeout(function () {
                        _this.loadContent(index, true, 0);
                    }, this.s.speed + 50);
    
                    setTimeout(function () {
                        _this.lgBusy = false;
                        _lgUtils2.default.trigger(_this.el, 'onAfterSlide', {
                            prevIndex: _prevIndex,
                            index: index,
                            fromTouch: fromTouch,
                            fromThumb: fromThumb
                        });
                    }, this.s.speed);
                } else {
                    _this.loadContent(index, true, _this.s.backdropDuration);
    
                    _this.lgBusy = false;
                    _lgUtils2.default.trigger(_this.el, 'onAfterSlide', {
                        prevIndex: _prevIndex,
                        index: index,
                        fromTouch: fromTouch,
                        fromThumb: fromThumb
                    });
                }
    
                _this.lGalleryOn = true;
    
                if (this.s.counter) {
                    if (document.getElementById('lg-counter-current')) {
                        document.getElementById('lg-counter-current').innerHTML = index + 1;
                    }
                }
            }
        };
    
        /**
         *  @desc Go to next slide
         *  @param {Boolean} fromTouch - true if slide function called via touch event
         */
        Plugin.prototype.goToNextSlide = function (fromTouch) {
            var _this = this;
            if (!_this.lgBusy) {
                if (_this.index + 1 < _this.___slide.length) {
                    _this.index++;
                    _lgUtils2.default.trigger(_this.el, 'onBeforeNextSlide', {
                        index: _this.index
                    });
                    _this.slide(_this.index, fromTouch, false);
                } else {
                    if (_this.s.loop) {
                        _this.index = 0;
                        _lgUtils2.default.trigger(_this.el, 'onBeforeNextSlide', {
                            index: _this.index
                        });
                        _this.slide(_this.index, fromTouch, false);
                    } else if (_this.s.slideEndAnimatoin) {
                        _lgUtils2.default.addClass(_this.outer, 'lg-right-end');
                        setTimeout(function () {
                            _lgUtils2.default.removeClass(_this.outer, 'lg-right-end');
                        }, 400);
                    }
                }
            }
        };
    
        /**
         *  @desc Go to previous slide
         *  @param {Boolean} fromTouch - true if slide function called via touch event
         */
        Plugin.prototype.goToPrevSlide = function (fromTouch) {
            var _this = this;
            if (!_this.lgBusy) {
                if (_this.index > 0) {
                    _this.index--;
                    _lgUtils2.default.trigger(_this.el, 'onBeforePrevSlide', {
                        index: _this.index,
                        fromTouch: fromTouch
                    });
                    _this.slide(_this.index, fromTouch, false);
                } else {
                    if (_this.s.loop) {
                        _this.index = _this.items.length - 1;
                        _lgUtils2.default.trigger(_this.el, 'onBeforePrevSlide', {
                            index: _this.index,
                            fromTouch: fromTouch
                        });
                        _this.slide(_this.index, fromTouch, false);
                    } else if (_this.s.slideEndAnimatoin) {
                        _lgUtils2.default.addClass(_this.outer, 'lg-left-end');
                        setTimeout(function () {
                            _lgUtils2.default.removeClass(_this.outer, 'lg-left-end');
                        }, 400);
                    }
                }
            }
        };
    
        Plugin.prototype.keyPress = function () {
            var _this = this;
            if (this.items.length > 1) {
                _lgUtils2.default.on(window, 'keyup.lg', function (e) {
                    if (_this.items.length > 1) {
                        if (e.keyCode === 37) {
                            e.preventDefault();
                            _this.goToPrevSlide();
                        }
    
                        if (e.keyCode === 39) {
                            e.preventDefault();
                            _this.goToNextSlide();
                        }
                    }
                });
            }
    
            _lgUtils2.default.on(window, 'keydown.lg', function (e) {
                if (_this.s.escKey === true && e.keyCode === 27) {
                    e.preventDefault();
                    if (!_lgUtils2.default.hasClass(_this.outer, 'lg-thumb-open')) {
                        _this.destroy();
                    } else {
                        _lgUtils2.default.removeClass(_this.outer, 'lg-thumb-open');
                    }
                }
            });
        };
    
        Plugin.prototype.arrow = function () {
            var _this = this;
            _lgUtils2.default.on(this.outer.querySelector('.lg-prev'), 'click.lg', function () {
                _this.goToPrevSlide();
            });
    
            _lgUtils2.default.on(this.outer.querySelector('.lg-next'), 'click.lg', function () {
                _this.goToNextSlide();
            });
        };
    
        Plugin.prototype.arrowDisable = function (index) {
    
            // Disable arrows if s.hideControlOnEnd is true
            if (!this.s.loop && this.s.hideControlOnEnd) {
                var next = this.outer.querySelector('.lg-next');
                var prev = this.outer.querySelector('.lg-prev');
                if (index + 1 < this.___slide.length) {
                    next.removeAttribute('disabled');
                    _lgUtils2.default.removeClass(next, 'disabled');
                } else {
                    next.setAttribute('disabled', 'disabled');
                    _lgUtils2.default.addClass(next, 'disabled');
                }
    
                if (index > 0) {
                    prev.removeAttribute('disabled');
                    _lgUtils2.default.removeClass(prev, 'disabled');
                } else {
                    prev.setAttribute('disabled', 'disabled');
                    _lgUtils2.default.addClass(prev, 'disabled');
                }
            }
        };
    
        Plugin.prototype.setTranslate = function (el, xValue, yValue) {
            // jQuery supports Automatic CSS prefixing since jQuery 1.8.0
            if (this.s.useLeft) {
                el.style.left = xValue;
            } else {
                _lgUtils2.default.setVendor(el, 'Transform', 'translate3d(' + xValue + 'px, ' + yValue + 'px, 0px)');
            }
        };
    
        Plugin.prototype.touchMove = function (startCoords, endCoords) {
    
            var distance = endCoords - startCoords;
    
            if (Math.abs(distance) > 15) {
                // reset opacity and transition duration
                _lgUtils2.default.addClass(this.outer, 'lg-dragging');
    
                // move current slide
                this.setTranslate(this.___slide[this.index], distance, 0);
    
                // move next and prev slide with current slide
                this.setTranslate(document.querySelector('.lg-prev-slide'), -this.___slide[this.index].clientWidth + distance, 0);
                this.setTranslate(document.querySelector('.lg-next-slide'), this.___slide[this.index].clientWidth + distance, 0);
            }
        };
    
        Plugin.prototype.touchEnd = function (distance) {
            var _this = this;
    
            // keep slide animation for any mode while dragg/swipe
            if (_this.s.mode !== 'lg-slide') {
                _lgUtils2.default.addClass(_this.outer, 'lg-slide');
            }
    
            for (var i = 0; i < this.___slide.length; i++) {
                if (!_lgUtils2.default.hasClass(this.___slide[i], 'lg-current') && !_lgUtils2.default.hasClass(this.___slide[i], 'lg-prev-slide') && !_lgUtils2.default.hasClass(this.___slide[i], 'lg-next-slide')) {
                    this.___slide[i].style.opacity = '0';
                }
            }
    
            // set transition duration
            setTimeout(function () {
                _lgUtils2.default.removeClass(_this.outer, 'lg-dragging');
                if (distance < 0 && Math.abs(distance) > _this.s.swipeThreshold) {
                    _this.goToNextSlide(true);
                } else if (distance > 0 && Math.abs(distance) > _this.s.swipeThreshold) {
                    _this.goToPrevSlide(true);
                } else if (Math.abs(distance) < 5) {
    
                    // Trigger click if distance is less than 5 pix
                    _lgUtils2.default.trigger(_this.el, 'onSlideClick');
                }
    
                for (var i = 0; i < _this.___slide.length; i++) {
                    _this.___slide[i].removeAttribute('style');
                }
            });
    
            // remove slide class once drag/swipe is completed if mode is not slide
            setTimeout(function () {
                if (!_lgUtils2.default.hasClass(_this.outer, 'lg-dragging') && _this.s.mode !== 'lg-slide') {
                    _lgUtils2.default.removeClass(_this.outer, 'lg-slide');
                }
            }, _this.s.speed + 100);
        };
    
        Plugin.prototype.enableSwipe = function () {
            var _this = this;
            var startCoords = 0;
            var endCoords = 0;
            var isMoved = false;
    
            if (_this.s.enableSwipe && _this.isTouch && _this.doCss()) {
    
                for (var i = 0; i < _this.___slide.length; i++) {
                    /*jshint loopfunc: true */
                    _lgUtils2.default.on(_this.___slide[i], 'touchstart.lg', function (e) {
                        if (!_lgUtils2.default.hasClass(_this.outer, 'lg-zoomed') && !_this.lgBusy) {
                            e.preventDefault();
                            _this.manageSwipeClass();
                            startCoords = e.targetTouches[0].pageX;
                        }
                    });
                }
    
                for (var j = 0; j < _this.___slide.length; j++) {
                    /*jshint loopfunc: true */
                    _lgUtils2.default.on(_this.___slide[j], 'touchmove.lg', function (e) {
                        if (!_lgUtils2.default.hasClass(_this.outer, 'lg-zoomed')) {
                            e.preventDefault();
                            endCoords = e.targetTouches[0].pageX;
                            _this.touchMove(startCoords, endCoords);
                            isMoved = true;
                        }
                    });
                }
    
                for (var k = 0; k < _this.___slide.length; k++) {
                    /*jshint loopfunc: true */
                    _lgUtils2.default.on(_this.___slide[k], 'touchend.lg', function () {
                        if (!_lgUtils2.default.hasClass(_this.outer, 'lg-zoomed')) {
                            if (isMoved) {
                                isMoved = false;
                                _this.touchEnd(endCoords - startCoords);
                            } else {
                                _lgUtils2.default.trigger(_this.el, 'onSlideClick');
                            }
                        }
                    });
                }
            }
        };
    
        Plugin.prototype.enableDrag = function () {
            var _this = this;
            var startCoords = 0;
            var endCoords = 0;
            var isDraging = false;
            var isMoved = false;
            if (_this.s.enableDrag && !_this.isTouch && _this.doCss()) {
                for (var i = 0; i < _this.___slide.length; i++) {
                    /*jshint loopfunc: true */
                    _lgUtils2.default.on(_this.___slide[i], 'mousedown.lg', function (e) {
                        // execute only on .lg-object
                        if (!_lgUtils2.default.hasClass(_this.outer, 'lg-zoomed')) {
                            if (_lgUtils2.default.hasClass(e.target, 'lg-object') || _lgUtils2.default.hasClass(e.target, 'lg-video-play')) {
                                e.preventDefault();
    
                                if (!_this.lgBusy) {
                                    _this.manageSwipeClass();
                                    startCoords = e.pageX;
                                    isDraging = true;
    
                                    // ** Fix for webkit cursor issue https://code.google.com/p/chromium/issues/detail?id=26723
                                    _this.outer.scrollLeft += 1;
                                    _this.outer.scrollLeft -= 1;
    
                                    // *
    
                                    _lgUtils2.default.removeClass(_this.outer, 'lg-grab');
                                    _lgUtils2.default.addClass(_this.outer, 'lg-grabbing');
    
                                    _lgUtils2.default.trigger(_this.el, 'onDragstart');
                                }
                            }
                        }
                    });
                }
    
                _lgUtils2.default.on(window, 'mousemove.lg', function (e) {
                    if (isDraging) {
                        isMoved = true;
                        endCoords = e.pageX;
                        _this.touchMove(startCoords, endCoords);
                        _lgUtils2.default.trigger(_this.el, 'onDragmove');
                    }
                });
    
                _lgUtils2.default.on(window, 'mouseup.lg', function (e) {
                    if (isMoved) {
                        isMoved = false;
                        _this.touchEnd(endCoords - startCoords);
                        _lgUtils2.default.trigger(_this.el, 'onDragend');
                    } else if (_lgUtils2.default.hasClass(e.target, 'lg-object') || _lgUtils2.default.hasClass(e.target, 'lg-video-play')) {
                        _lgUtils2.default.trigger(_this.el, 'onSlideClick');
                    }
    
                    // Prevent execution on click
                    if (isDraging) {
                        isDraging = false;
                        _lgUtils2.default.removeClass(_this.outer, 'lg-grabbing');
                        _lgUtils2.default.addClass(_this.outer, 'lg-grab');
                    }
                });
            }
        };
    
        Plugin.prototype.manageSwipeClass = function () {
            var touchNext = this.index + 1;
            var touchPrev = this.index - 1;
            var length = this.___slide.length;
            if (this.s.loop) {
                if (this.index === 0) {
                    touchPrev = length - 1;
                } else if (this.index === length - 1) {
                    touchNext = 0;
                }
            }
    
            for (var i = 0; i < this.___slide.length; i++) {
                _lgUtils2.default.removeClass(this.___slide[i], 'lg-next-slide');
                _lgUtils2.default.removeClass(this.___slide[i], 'lg-prev-slide');
            }
    
            if (touchPrev > -1) {
                _lgUtils2.default.addClass(this.___slide[touchPrev], 'lg-prev-slide');
            }
    
            _lgUtils2.default.addClass(this.___slide[touchNext], 'lg-next-slide');
        };
    
        Plugin.prototype.mousewheel = function () {
            var _this = this;
            _lgUtils2.default.on(_this.outer, 'mousewheel.lg', function (e) {
    
                if (!e.deltaY) {
                    return;
                }
    
                if (e.deltaY > 0) {
                    _this.goToPrevSlide();
                } else {
                    _this.goToNextSlide();
                }
    
                e.preventDefault();
            });
        };
    
        Plugin.prototype.closeGallery = function () {
    
            var _this = this;
            var mousedown = false;
            _lgUtils2.default.on(this.outer.querySelector('.lg-close'), 'click.lg', function () {
                _this.destroy();
            });
    
            if (_this.s.closable) {
    
                // If you drag the slide and release outside gallery gets close on chrome
                // for preventing this check mousedown and mouseup happened on .lg-item or lg-outer
                _lgUtils2.default.on(_this.outer, 'mousedown.lg', function (e) {
    
                    if (_lgUtils2.default.hasClass(e.target, 'lg-outer') || _lgUtils2.default.hasClass(e.target, 'lg-item') || _lgUtils2.default.hasClass(e.target, 'lg-img-wrap')) {
                        mousedown = true;
                    } else {
                        mousedown = false;
                    }
                });
    
                _lgUtils2.default.on(_this.outer, 'mouseup.lg', function (e) {
    
                    if (_lgUtils2.default.hasClass(e.target, 'lg-outer') || _lgUtils2.default.hasClass(e.target, 'lg-item') || _lgUtils2.default.hasClass(e.target, 'lg-img-wrap') && mousedown) {
                        if (!_lgUtils2.default.hasClass(_this.outer, 'lg-dragging')) {
                            _this.destroy();
                        }
                    }
                });
            }
        };
    
        Plugin.prototype.destroy = function (d) {
    
            var _this = this;
    
            if (!d) {
                _lgUtils2.default.trigger(_this.el, 'onBeforeClose');
            }
    
            document.body.scrollTop = _this.prevScrollTop;
            document.documentElement.scrollTop = _this.prevScrollTop;
    
            /**
             * if d is false or undefined destroy will only close the gallery
             * plugins instance remains with the element
             *
             * if d is true destroy will completely remove the plugin
             */
    
            if (d) {
                if (!_this.s.dynamic) {
                    // only when not using dynamic mode is $items a jquery collection
    
                    for (var i = 0; i < this.items.length; i++) {
                        _lgUtils2.default.off(this.items[i], '.lg');
                        _lgUtils2.default.off(this.items[i], '.lgcustom');
                    }
                }
    
                var lguid = _this.el.getAttribute('lg-uid');
                delete window.lgData[lguid];
                _this.el.removeAttribute('lg-uid');
            }
    
            // Unbind all events added by lightGallery
            _lgUtils2.default.off(this.el, '.lgtm');
    
            // Distroy all lightGallery modules
            for (var key in window.lgModules) {
                if (_this.modules[key]) {
                    _this.modules[key].destroy(d);
                }
            }
    
            this.lGalleryOn = false;
    
            clearTimeout(_this.hideBartimeout);
            this.hideBartimeout = false;
            _lgUtils2.default.off(window, '.lg');
            _lgUtils2.default.removeClass(document.body, 'lg-on');
            _lgUtils2.default.removeClass(document.body, 'lg-from-hash');
    
            if (_this.outer) {
                _lgUtils2.default.removeClass(_this.outer, 'lg-visible');
            }
    
            _lgUtils2.default.removeClass(document.querySelector('.lg-backdrop'), 'in');
            setTimeout(function () {
                try {
                    if (_this.outer) {
                        _this.outer.parentNode.removeChild(_this.outer);
                    }
    
                    if (document.querySelector('.lg-backdrop')) {
                        document.querySelector('.lg-backdrop').parentNode.removeChild(document.querySelector('.lg-backdrop'));
                    }
    
                    if (!d) {
                        _lgUtils2.default.trigger(_this.el, 'onCloseAfter');
                    }
                    _this.el.focus();
                } catch (err) {}
            }, _this.s.backdropDuration + 50);
        };
    
        window.lightGallery = function (el, options) {
            if (!el) {
                return;
            }
    
            try {
                if (!el.getAttribute('lg-uid')) {
                    var uid = 'lg' + window.lgData.uid++;
                    window.lgData[uid] = new Plugin(el, options);
                    el.setAttribute('lg-uid', uid);
                } else {
                    try {
                        window.lgData[el.getAttribute('lg-uid')].init();
                    } catch (err) {
                        console.error('lightGallery has not initiated properly');
                    }
                }
            } catch (err) {
                console.error('lightGallery has not initiated properly');
            }
        };
    });
    
    },{"./lg-utils":1}]},{},[2])(2)
    });

    /**!
 * lg-fullscreen.js | 1.2.0 | May 20th 2020
 * http://sachinchoolur.github.io/lg-fullscreen.js
 * Copyright (c) 2016 Sachin N; 
 * @license GPLv3 
 */(function(f){if(typeof exports==="object"&&typeof module!=="undefined"){module.exports=f()}else if(typeof define==="function"&&define.amd){define([],f)}else{var g;if(typeof window!=="undefined"){g=window}else if(typeof global!=="undefined"){g=global}else if(typeof self!=="undefined"){g=self}else{g=this}g.LgFullscreen = f()}})(function(){var define,module,exports;return (function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(require,module,exports){
(function (global, factory) {
    if (typeof define === "function" && define.amd) {
        define([], factory);
    } else if (typeof exports !== "undefined") {
        factory();
    } else {
        var mod = {
            exports: {}
        };
        factory();
        global.lgFullscreen = mod.exports;
    }
})(this, function () {
    'use strict';

    var _extends = Object.assign || function (target) {
        for (var i = 1; i < arguments.length; i++) {
            var source = arguments[i];

            for (var key in source) {
                if (Object.prototype.hasOwnProperty.call(source, key)) {
                    target[key] = source[key];
                }
            }
        }

        return target;
    };

    var fullscreenDefaults = {
        fullScreen: true
    };

    function isFullScreen() {
        return document.fullscreenElement || document.mozFullScreenElement || document.webkitFullscreenElement || document.msFullscreenElement;
    }

    var Fullscreen = function Fullscreen(element) {

        this.el = element;

        this.core = window.lgData[this.el.getAttribute('lg-uid')];
        this.core.s = _extends({}, fullscreenDefaults, this.core.s);

        this.init();

        return this;
    };

    Fullscreen.prototype.init = function () {
        var fullScreen = '';
        if (this.core.s.fullScreen) {

            // check for fullscreen browser support
            if (!document.fullscreenEnabled && !document.webkitFullscreenEnabled && !document.mozFullScreenEnabled && !document.msFullscreenEnabled) {
                return;
            } else {
                fullScreen = '<button aria-label="Toggle fullscreen" class="lg-fullscreen lg-icon"></button>';
                this.core.outer.querySelector('.lg-toolbar').insertAdjacentHTML('beforeend', fullScreen);
                this.fullScreen();
            }
        }
    };

    Fullscreen.prototype.requestFullscreen = function () {
        var el = document.documentElement;
        if (el.requestFullscreen) {
            el.requestFullscreen();
        } else if (el.msRequestFullscreen) {
            el.msRequestFullscreen();
        } else if (el.mozRequestFullScreen) {
            el.mozRequestFullScreen();
        } else if (el.webkitRequestFullscreen) {
            el.webkitRequestFullscreen();
        }
    };

    Fullscreen.prototype.exitFullscreen = function () {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        }
    };

    // https://developer.mozilla.org/en-US/docs/Web/Guide/API/DOM/Using_full_screen_mode
    Fullscreen.prototype.fullScreen = function () {
        var _this = this;

        utils.on(document, 'fullscreenchange.lgfullscreen webkitfullscreenchange.lgfullscreen mozfullscreenchange.lgfullscreen MSFullscreenChange.lgfullscreen', function () {
            if (utils.hasClass(_this.core.outer, 'lg-fullscreen-on')) {
                utils.removeClass(_this.core.outer, 'lg-fullscreen-on');
            } else {
                utils.addClass(_this.core.outer, 'lg-fullscreen-on');
            }
        });

        utils.on(this.core.outer.querySelector('.lg-fullscreen'), 'click.lg', function () {
            if (isFullScreen()) {
                _this.exitFullscreen();
            } else {
                _this.requestFullscreen();
            }
        });
    };

    Fullscreen.prototype.destroy = function () {

        // exit from fullscreen if activated
        if (isFullScreen()) {
            this.exitFullscreen();
        }

        utils.off(document, '.lgfullscreen');
    };

    window.lgModules.fullscreen = Fullscreen;
});

},{}]},{},[1])(1)
});

/**!
 * lg-thumbnail.js | 1.2.0 | May 20th 2020
 * http://sachinchoolur.github.io/lg-thumbnail.js
 * Copyright (c) 2016 Sachin N; 
 * @license GPLv3 
 */(function(f){if(typeof exports==="object"&&typeof module!=="undefined"){module.exports=f()}else if(typeof define==="function"&&define.amd){define([],f)}else{var g;if(typeof window!=="undefined"){g=window}else if(typeof global!=="undefined"){g=global}else if(typeof self!=="undefined"){g=self}else{g=this}g.LgThumbnail = f()}})(function(){var define,module,exports;return (function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(require,module,exports){
    (function (global, factory) {
        if (typeof define === "function" && define.amd) {
            define([], factory);
        } else if (typeof exports !== "undefined") {
            factory();
        } else {
            var mod = {
                exports: {}
            };
            factory();
            global.lgThumbnail = mod.exports;
        }
    })(this, function () {
        'use strict';
    
        var _extends = Object.assign || function (target) {
            for (var i = 1; i < arguments.length; i++) {
                var source = arguments[i];
    
                for (var key in source) {
                    if (Object.prototype.hasOwnProperty.call(source, key)) {
                        target[key] = source[key];
                    }
                }
            }
    
            return target;
        };
    
        var thumbnailDefaults = {
            thumbnail: true,
    
            animateThumb: true,
            currentPagerPosition: 'middle',
    
            thumbWidth: 100,
            thumbContHeight: 100,
            thumbMargin: 5,
    
            exThumbImage: false,
            showThumbByDefault: true,
            toggleThumb: true,
            pullCaptionUp: true,
    
            enableThumbDrag: true,
            enableThumbSwipe: true,
            swipeThreshold: 50,
    
            loadYoutubeThumbnail: true,
            youtubeThumbSize: 1,
    
            loadVimeoThumbnail: true,
            vimeoThumbSize: 'thumbnail_small',
    
            loadDailymotionThumbnail: true
        };
    
        var Thumbnail = function Thumbnail(element) {
    
            this.el = element;
    
            this.core = window.lgData[this.el.getAttribute('lg-uid')];
            this.core.s = _extends({}, thumbnailDefaults, this.core.s);
    
            this.thumbOuter = null;
            this.thumbOuterWidth = 0;
            this.thumbTotalWidth = this.core.items.length * (this.core.s.thumbWidth + this.core.s.thumbMargin);
            this.thumbIndex = this.core.index;
    
            // Thumbnail animation value
            this.left = 0;
    
            this.init();
    
            return this;
        };
    
        Thumbnail.prototype.init = function () {
            var _this = this;
            if (this.core.s.thumbnail && this.core.items.length > 1) {
                if (this.core.s.showThumbByDefault) {
                    setTimeout(function () {
                        utils.addClass(_this.core.outer, 'lg-thumb-open');
                    }, 700);
                }
    
                if (this.core.s.pullCaptionUp) {
                    utils.addClass(this.core.outer, 'lg-pull-caption-up');
                }
    
                this.build();
                if (this.core.s.animateThumb) {
                    if (this.core.s.enableThumbDrag && !this.core.isTouch && this.core.doCss()) {
                        this.enableThumbDrag();
                    }
    
                    if (this.core.s.enableThumbSwipe && this.core.isTouch && this.core.doCss()) {
                        this.enableThumbSwipe();
                    }
    
                    this.thumbClickable = false;
                } else {
                    this.thumbClickable = true;
                }
    
                this.toggle();
                this.thumbkeyPress();
            }
        };
    
        Thumbnail.prototype.build = function () {
            var _this = this;
            var thumbList = '';
            var vimeoErrorThumbSize = '';
            var $thumb;
            var html = '<div class="lg-thumb-outer">' + '<div class="lg-thumb group">' + '</div>' + '</div>';
    
            switch (this.core.s.vimeoThumbSize) {
                case 'thumbnail_large':
                    vimeoErrorThumbSize = '640';
                    break;
                case 'thumbnail_medium':
                    vimeoErrorThumbSize = '200x150';
                    break;
                case 'thumbnail_small':
                    vimeoErrorThumbSize = '100x75';
            }
    
            utils.addClass(_this.core.outer, 'lg-has-thumb');
    
            _this.core.outer.querySelector('.lg').insertAdjacentHTML('beforeend', html);
    
            _this.thumbOuter = _this.core.outer.querySelector('.lg-thumb-outer');
            _this.thumbOuterWidth = _this.thumbOuter.offsetWidth;
    
            if (_this.core.s.animateThumb) {
                _this.core.outer.querySelector('.lg-thumb').style.width = _this.thumbTotalWidth + 'px';
                _this.core.outer.querySelector('.lg-thumb').style.position = 'relative';
            }
    
            if (this.core.s.animateThumb) {
                _this.thumbOuter.style.height = _this.core.s.thumbContHeight + 'px';
            }
    
            function getThumb(src, thumb, index) {
                var isVideo = _this.core.isVideo(src, index) || {};
                var thumbImg;
                var vimeoId = '';
    
                if (isVideo.youtube || isVideo.vimeo || isVideo.dailymotion) {
                    if (isVideo.youtube) {
                        if (_this.core.s.loadYoutubeThumbnail) {
                            thumbImg = '//img.youtube.com/vi/' + isVideo.youtube[1] + '/' + _this.core.s.youtubeThumbSize + '.jpg';
                        } else {
                            thumbImg = thumb;
                        }
                    } else if (isVideo.vimeo) {
                        if (_this.core.s.loadVimeoThumbnail) {
                            thumbImg = '//i.vimeocdn.com/video/error_' + vimeoErrorThumbSize + '.jpg';
                            vimeoId = isVideo.vimeo[1];
                        } else {
                            thumbImg = thumb;
                        }
                    } else if (isVideo.dailymotion) {
                        if (_this.core.s.loadDailymotionThumbnail) {
                            thumbImg = '//www.dailymotion.com/thumbnail/video/' + isVideo.dailymotion[1];
                        } else {
                            thumbImg = thumb;
                        }
                    }
                } else {
                    thumbImg = thumb;
                }
    
                thumbList += '<div data-vimeo-id="' + vimeoId + '" class="lg-thumb-item" style="width:' + _this.core.s.thumbWidth + 'px; margin-right: ' + _this.core.s.thumbMargin + 'px"><img src="' + thumbImg + '" /></div>';
                vimeoId = '';
            }
    
            if (_this.core.s.dynamic) {
                for (var j = 0; j < _this.core.s.dynamicEl.length; j++) {
                    getThumb(_this.core.s.dynamicEl[j].src, _this.core.s.dynamicEl[j].thumb, j);
                }
            } else {
                for (var i = 0; i < _this.core.items.length; i++) {
                    if (!_this.core.s.exThumbImage) {
                        getThumb(_this.core.items[i].getAttribute('href') || _this.core.items[i].getAttribute('data-src'), _this.core.items[i].querySelector('img').getAttribute('src'), i);
                    } else {
                        getThumb(_this.core.items[i].getAttribute('href') || _this.core.items[i].getAttribute('data-src'), _this.core.items[i].getAttribute(_this.core.s.exThumbImage), i);
                    }
                }
            }
    
            _this.core.outer.querySelector('.lg-thumb').innerHTML = thumbList;
    
            $thumb = _this.core.outer.querySelectorAll('.lg-thumb-item');
    
            for (var n = 0; n < $thumb.length; n++) {
    
                /*jshint loopfunc: true */
                (function (index) {
                    var $this = $thumb[index];
                    var vimeoVideoId = $this.getAttribute('data-vimeo-id');
                    if (vimeoVideoId) {
    
                        window['lgJsonP' + _this.el.getAttribute('lg-uid') + '' + n] = function (content) {
                            $this.querySelector('img').setAttribute('src', content[0][_this.core.s.vimeoThumbSize]);
                        };
    
                        var script = document.createElement('script');
                        script.className = 'lg-script';
                        script.src = '//www.vimeo.com/api/v2/video/' + vimeoVideoId + '.json?callback=lgJsonP' + _this.el.getAttribute('lg-uid') + '' + n;
                        document.body.appendChild(script);
                    }
                })(n);
            }
    
            // manage active class for thumbnail
            utils.addClass($thumb[_this.core.index], 'active');
            utils.on(_this.core.el, 'onBeforeSlide.lgtm', function () {
    
                for (var j = 0; j < $thumb.length; j++) {
                    utils.removeClass($thumb[j], 'active');
                }
    
                utils.addClass($thumb[_this.core.index], 'active');
            });
    
            for (var k = 0; k < $thumb.length; k++) {
    
                /*jshint loopfunc: true */
                (function (index) {
    
                    utils.on($thumb[index], 'click.lg touchend.lg', function () {
    
                        setTimeout(function () {
    
                            // In IE9 and bellow touch does not support
                            // Go to slide if browser does not support css transitions
                            if (_this.thumbClickable && !_this.core.lgBusy || !_this.core.doCss()) {
                                _this.core.index = index;
                                _this.core.slide(_this.core.index, false, true);
                            }
                        }, 50);
                    });
                })(k);
            }
    
            utils.on(_this.core.el, 'onBeforeSlide.lgtm', function () {
                _this.animateThumb(_this.core.index);
            });
    
            utils.on(window, 'resize.lgthumb orientationchange.lgthumb', function () {
                setTimeout(function () {
                    _this.animateThumb(_this.core.index);
                    _this.thumbOuterWidth = _this.thumbOuter.offsetWidth;
                }, 200);
            });
        };
    
        Thumbnail.prototype.setTranslate = function (value) {
            utils.setVendor(this.core.outer.querySelector('.lg-thumb'), 'Transform', 'translate3d(-' + value + 'px, 0px, 0px)');
        };
    
        Thumbnail.prototype.animateThumb = function (index) {
            var $thumb = this.core.outer.querySelector('.lg-thumb');
            if (this.core.s.animateThumb) {
                var position;
                switch (this.core.s.currentPagerPosition) {
                    case 'left':
                        position = 0;
                        break;
                    case 'middle':
                        position = this.thumbOuterWidth / 2 - this.core.s.thumbWidth / 2;
                        break;
                    case 'right':
                        position = this.thumbOuterWidth - this.core.s.thumbWidth;
                }
                this.left = (this.core.s.thumbWidth + this.core.s.thumbMargin) * index - 1 - position;
                if (this.left > this.thumbTotalWidth - this.thumbOuterWidth) {
                    this.left = this.thumbTotalWidth - this.thumbOuterWidth;
                }
    
                if (this.left < 0) {
                    this.left = 0;
                }
    
                if (this.core.lGalleryOn) {
                    if (!utils.hasClass($thumb, 'on')) {
                        utils.setVendor(this.core.outer.querySelector('.lg-thumb'), 'TransitionDuration', this.core.s.speed + 'ms');
                    }
    
                    if (!this.core.doCss()) {
                        $thumb.style.left = -this.left + 'px';
                    }
                } else {
                    if (!this.core.doCss()) {
                        $thumb.style.left = -this.left + 'px';
                    }
                }
    
                this.setTranslate(this.left);
            }
        };
    
        // Enable thumbnail dragging and swiping
        Thumbnail.prototype.enableThumbDrag = function () {
    
            var _this = this;
            var startCoords = 0;
            var endCoords = 0;
            var isDraging = false;
            var isMoved = false;
            var tempLeft = 0;
    
            utils.addClass(_this.thumbOuter, 'lg-grab');
    
            utils.on(_this.core.outer.querySelector('.lg-thumb'), 'mousedown.lgthumb', function (e) {
                if (_this.thumbTotalWidth > _this.thumbOuterWidth) {
                    // execute only on .lg-object
                    e.preventDefault();
                    startCoords = e.pageX;
                    isDraging = true;
    
                    // ** Fix for webkit cursor issue https://code.google.com/p/chromium/issues/detail?id=26723
                    _this.core.outer.scrollLeft += 1;
                    _this.core.outer.scrollLeft -= 1;
    
                    // *
                    _this.thumbClickable = false;
                    utils.removeClass(_this.thumbOuter, 'lg-grab');
                    utils.addClass(_this.thumbOuter, 'lg-grabbing');
                }
            });
    
            utils.on(window, 'mousemove.lgthumb', function (e) {
                if (isDraging) {
                    tempLeft = _this.left;
                    isMoved = true;
                    endCoords = e.pageX;
    
                    utils.addClass(_this.thumbOuter, 'lg-dragging');
    
                    tempLeft = tempLeft - (endCoords - startCoords);
    
                    if (tempLeft > _this.thumbTotalWidth - _this.thumbOuterWidth) {
                        tempLeft = _this.thumbTotalWidth - _this.thumbOuterWidth;
                    }
    
                    if (tempLeft < 0) {
                        tempLeft = 0;
                    }
    
                    // move current slide
                    _this.setTranslate(tempLeft);
                }
            });
    
            utils.on(window, 'mouseup.lgthumb', function () {
                if (isMoved) {
                    isMoved = false;
                    utils.removeClass(_this.thumbOuter, 'lg-dragging');
    
                    _this.left = tempLeft;
    
                    if (Math.abs(endCoords - startCoords) < _this.core.s.swipeThreshold) {
                        _this.thumbClickable = true;
                    }
                } else {
                    _this.thumbClickable = true;
                }
    
                if (isDraging) {
                    isDraging = false;
                    utils.removeClass(_this.thumbOuter, 'lg-grabbing');
                    utils.addClass(_this.thumbOuter, 'lg-grab');
                }
            });
        };
    
        Thumbnail.prototype.enableThumbSwipe = function () {
            var _this = this;
            var startCoords = 0;
            var endCoords = 0;
            var isMoved = false;
            var tempLeft = 0;
    
            utils.on(_this.core.outer.querySelector('.lg-thumb'), 'touchstart.lg', function (e) {
                if (_this.thumbTotalWidth > _this.thumbOuterWidth) {
                    e.preventDefault();
                    startCoords = e.targetTouches[0].pageX;
                    _this.thumbClickable = false;
                }
            });
    
            utils.on(_this.core.outer.querySelector('.lg-thumb'), 'touchmove.lg', function (e) {
                if (_this.thumbTotalWidth > _this.thumbOuterWidth) {
                    e.preventDefault();
                    endCoords = e.targetTouches[0].pageX;
                    isMoved = true;
    
                    utils.addClass(_this.thumbOuter, 'lg-dragging');
    
                    tempLeft = _this.left;
    
                    tempLeft = tempLeft - (endCoords - startCoords);
    
                    if (tempLeft > _this.thumbTotalWidth - _this.thumbOuterWidth) {
                        tempLeft = _this.thumbTotalWidth - _this.thumbOuterWidth;
                    }
    
                    if (tempLeft < 0) {
                        tempLeft = 0;
                    }
    
                    // move current slide
                    _this.setTranslate(tempLeft);
                }
            });
    
            utils.on(_this.core.outer.querySelector('.lg-thumb'), 'touchend.lg', function () {
                if (_this.thumbTotalWidth > _this.thumbOuterWidth) {
    
                    if (isMoved) {
                        isMoved = false;
                        utils.removeClass(_this.thumbOuter, 'lg-dragging');
                        if (Math.abs(endCoords - startCoords) < _this.core.s.swipeThreshold) {
                            _this.thumbClickable = true;
                        }
    
                        _this.left = tempLeft;
                    } else {
                        _this.thumbClickable = true;
                    }
                } else {
                    _this.thumbClickable = true;
                }
            });
        };
    
        Thumbnail.prototype.toggle = function () {
            var _this = this;
            if (_this.core.s.toggleThumb) {
                utils.addClass(_this.core.outer, 'lg-can-toggle');
                _this.thumbOuter.insertAdjacentHTML('beforeend', '<button aria-label="Toggle thumbnails" class="lg-toggle-thumb lg-icon"></button>');
                utils.on(_this.core.outer.querySelector('.lg-toggle-thumb'), 'click.lg', function () {
                    if (utils.hasClass(_this.core.outer, 'lg-thumb-open')) {
                        utils.removeClass(_this.core.outer, 'lg-thumb-open');
                    } else {
                        utils.addClass(_this.core.outer, 'lg-thumb-open');
                    }
                });
            }
        };
    
        Thumbnail.prototype.thumbkeyPress = function () {
            var _this = this;
            utils.on(window, 'keydown.lgthumb', function (e) {
                if (e.keyCode === 38) {
                    e.preventDefault();
                    utils.addClass(_this.core.outer, 'lg-thumb-open');
                } else if (e.keyCode === 40) {
                    e.preventDefault();
                    utils.removeClass(_this.core.outer, 'lg-thumb-open');
                }
            });
        };
    
        Thumbnail.prototype.destroy = function (d) {
            if (this.core.s.thumbnail && this.core.items.length > 1) {
                utils.off(window, '.lgthumb');
                if (!d) {
                    this.thumbOuter.parentNode.removeChild(this.thumbOuter);
                }
                utils.removeClass(this.core.outer, 'lg-has-thumb');
    
                var lgScript = document.getElementsByClassName('lg-script');
                while (lgScript[0]) {
                    lgScript[0].parentNode.removeChild(lgScript[0]);
                }
            }
        };
    
        window.lgModules.thumbnail = Thumbnail;
    });
    
    },{}]},{},[1])(1)
    });

    /**!
 * lg-video.js | 1.2.1 | September 15th 2020
 * http://sachinchoolur.github.io/lg-video.js
 * Copyright (c) 2016 Sachin N; 
 * @license GPLv3 
 */(function(f){if(typeof exports==="object"&&typeof module!=="undefined"){module.exports=f()}else if(typeof define==="function"&&define.amd){define([],f)}else{var g;if(typeof window!=="undefined"){g=window}else if(typeof global!=="undefined"){g=global}else if(typeof self!=="undefined"){g=self}else{g=this}g.LgVideo = f()}})(function(){var define,module,exports;return (function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(require,module,exports){
(function (global, factory) {
    if (typeof define === "function" && define.amd) {
        define([], factory);
    } else if (typeof exports !== "undefined") {
        factory();
    } else {
        var mod = {
            exports: {}
        };
        factory();
        global.lgVideo = mod.exports;
    }
})(this, function () {
    'use strict';

    var _extends = Object.assign || function (target) {
        for (var i = 1; i < arguments.length; i++) {
            var source = arguments[i];

            for (var key in source) {
                if (Object.prototype.hasOwnProperty.call(source, key)) {
                    target[key] = source[key];
                }
            }
        }

        return target;
    };

    var videoDefaults = {
        videoMaxWidth: '855px',
        youtubePlayerParams: false,
        vimeoPlayerParams: false,
        dailymotionPlayerParams: false,
        vkPlayerParams: false,
        videojs: false,
        videojsOptions: {}
    };

    var Video = function Video(element) {

        this.el = element;

        this.core = window.lgData[this.el.getAttribute('lg-uid')];
        this.core.s = _extends({}, videoDefaults, this.core.s);

        this.videoLoaded = false;

        this.init();

        return this;
    };

    Video.prototype.init = function () {
        var _this = this;

        // Event triggered when video url found without poster
        utils.on(_this.core.el, 'hasVideo.lgtm', function (event) {
            _this.core.___slide[event.detail.index].querySelector('.lg-video').insertAdjacentHTML('beforeend', _this.loadVideo(event.detail.src, 'lg-object', true, event.detail.index, event.detail.html));
            if (event.detail.html) {
                if (_this.core.s.videojs) {
                    try {
                        videojs(_this.core.___slide[event.detail.index].querySelector('.lg-html5'), _this.core.s.videojsOptions, function () {
                            if (!_this.videoLoaded) {
                                this.play();
                            }
                        });
                    } catch (e) {
                        console.error('Make sure you have included videojs');
                    }
                } else {
                    _this.core.___slide[event.detail.index].querySelector('.lg-html5').play();
                }
            }
        });

        // Set max width for video
        utils.on(_this.core.el, 'onAferAppendSlide.lgtm', function (event) {
            var modalWidth = _this.core.s.videoMaxWidth;
            if(_this.core.items[_this.core.index].getAttribute('data-iframe') === 'true'){
                modalWidth = _this.core.s.iframeMaxWidth;
            }

            if (_this.core.___slide[event.detail.index].querySelector('.lg-video-cont')) {
                _this.core.___slide[event.detail.index].querySelector('.lg-video-cont').style.maxWidth = modalWidth;
                _this.videoLoaded = true;
            }
        });

        var loadOnClick = function loadOnClick($el) {
            // check slide has poster
            if (utils.hasClass($el.querySelector('.lg-object'), 'lg-has-poster') && $el.querySelector('.lg-object').style.display !== 'none') {

                // check already video element present
                if (!utils.hasClass($el, 'lg-has-video')) {

                    utils.addClass($el, 'lg-video-playing');
                    utils.addClass($el, 'lg-has-video');

                    var _src;
                    var _html;
                    var _loadVideo = function _loadVideo(_src, _html) {

                        $el.querySelector('.lg-video').insertAdjacentHTML('beforeend', _this.loadVideo(_src, '', false, _this.core.index, _html));

                        if (_html) {
                            if (_this.core.s.videojs) {
                                try {
                                    videojs(_this.core.___slide[_this.core.index].querySelector('.lg-html5'), _this.core.s.videojsOptions, function () {
                                        this.play();
                                    });
                                } catch (e) {
                                    console.error('Make sure you have included videojs');
                                }
                            } else {
                                _this.core.___slide[_this.core.index].querySelector('.lg-html5').play();
                            }
                        }
                    };

                    if (_this.core.s.dynamic) {

                        _src = _this.core.s.dynamicEl[_this.core.index].src;
                        _html = _this.core.s.dynamicEl[_this.core.index].html;

                        _loadVideo(_src, _html);
                    } else {

                        _src = _this.core.items[_this.core.index].getAttribute('href') || _this.core.items[_this.core.index].getAttribute('data-src');
                        _html = _this.core.items[_this.core.index].getAttribute('data-html');

                        _loadVideo(_src, _html);
                    }

                    var $tempImg = $el.querySelector('.lg-object');
                    $el.querySelector('.lg-video').appendChild($tempImg);

                    // @todo loading icon for html5 videos also
                    // for showing the loading indicator while loading video
                    if (!utils.hasClass($el.querySelector('.lg-video-object'), 'lg-html5')) {
                        utils.removeClass($el, 'lg-complete');
                        utils.on($el.querySelector('.lg-video-object'), 'load.lg error.lg', function () {
                            utils.addClass($el, 'lg-complete');
                        });
                    }
                } else {

                    var youtubePlayer = $el.querySelector('.lg-youtube');
                    var vimeoPlayer = $el.querySelector('.lg-vimeo');
                    var dailymotionPlayer = $el.querySelector('.lg-dailymotion');
                    var html5Player = $el.querySelector('.lg-html5');
                    if (youtubePlayer) {
                        youtubePlayer.contentWindow.postMessage('{"event":"command","func":"playVideo","args":""}', '*');
                    } else if (vimeoPlayer) {
                        try {
                            $f(vimeoPlayer).api('play');
                        } catch (e) {
                            console.error('Make sure you have included froogaloop2 js');
                        }
                    } else if (dailymotionPlayer) {
                        dailymotionPlayer.contentWindow.postMessage('play', '*');
                    } else if (html5Player) {
                        if (_this.core.s.videojs) {
                            try {
                                videojs(html5Player).play();
                            } catch (e) {
                                console.error('Make sure you have included videojs');
                            }
                        } else {
                            html5Player.play();
                        }
                    }

                    utils.addClass($el, 'lg-video-playing');
                }
            }
        };

        if (_this.core.doCss() && _this.core.items.length > 1 && (_this.core.s.enableSwipe && _this.core.isTouch || _this.core.s.enableDrag && !_this.core.isTouch)) {
            utils.on(_this.core.el, 'onSlideClick.lgtm', function () {
                var $el = _this.core.___slide[_this.core.index];
                loadOnClick($el);
            });
        } else {

            // For IE 9 and bellow
            for (var i = 0; i < _this.core.___slide.length; i++) {

                /*jshint loopfunc: true */
                (function (index) {
                    utils.on(_this.core.___slide[index], 'click.lg', function () {
                        loadOnClick(_this.core.___slide[index]);
                    });
                })(i);
            }
        }

        utils.on(_this.core.el, 'onBeforeSlide.lgtm', function (event) {

            var $videoSlide = _this.core.___slide[event.detail.prevIndex];
            var youtubePlayer = $videoSlide.querySelector('.lg-youtube');
            var vimeoPlayer = $videoSlide.querySelector('.lg-vimeo');
            var dailymotionPlayer = $videoSlide.querySelector('.lg-dailymotion');
            var vkPlayer = $videoSlide.querySelector('.lg-vk');
            var html5Player = $videoSlide.querySelector('.lg-html5');
            if (youtubePlayer) {
                youtubePlayer.contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*');
            } else if (vimeoPlayer) {
                try {
                    $f(vimeoPlayer).api('pause');
                } catch (e) {
                    console.error('Make sure you have included froogaloop2 js');
                }
            } else if (dailymotionPlayer) {
                dailymotionPlayer.contentWindow.postMessage('pause', '*');
            } else if (html5Player) {
                if (_this.core.s.videojs) {
                    try {
                        videojs(html5Player).pause();
                    } catch (e) {
                        console.error('Make sure you have included videojs');
                    }
                } else {
                    html5Player.pause();
                }
            }if (vkPlayer) {

                vkPlayer.setAttribute('src', vkPlayer.getAttribute('src').replace('&autoplay', '&noplay'));
            }

            var _src;
            if (_this.core.s.dynamic) {
                _src = _this.core.s.dynamicEl[event.detail.index].src;
            } else {
                _src = _this.core.items[event.detail.index].getAttribute('href') || _this.core.items[event.detail.index].getAttribute('data-src');
            }

            var _isVideo = _this.core.isVideo(_src, event.detail.index) || {};
            if (_isVideo.youtube || _isVideo.vimeo || _isVideo.dailymotion || _isVideo.vk) {
                utils.addClass(_this.core.outer, 'lg-hide-download');
            }

            //$videoSlide.addClass('lg-complete');
        });

        utils.on(_this.core.el, 'onAfterSlide.lgtm', function (event) {
            utils.removeClass(_this.core.___slide[event.detail.prevIndex], 'lg-video-playing');
        });
    };

    Video.prototype.loadVideo = function (src, addClass, noposter, index, html) {
        var video = '';
        var autoplay = 1;
        var a = '';
        var isVideo = this.core.isVideo(src, index) || {};

        // Enable autoplay for first video if poster doesn't exist
        if (noposter) {
            if (this.videoLoaded) {
                autoplay = 0;
            } else {
                autoplay = 1;
            }
        }

        var videoTitle;

        if (this.core.s.dynamic) {
            videoTitle = this.core.s.dynamicEl[index].title;
        } else {
            videoTitle = this.core.items[index].getAttribute('title');
            if (!videoTitle) {
                var firstImage = this.core.items[index].querySelector('img');
                if (firstImage) {
                    videoTitle = firstImage.getAttribute('alt');
                }
            }
        }

        videoTitle = videoTitle ? 'title="' + videoTitle + '"' : '';

        if (isVideo.youtube) {

            a = '?wmode=opaque&autoplay=' + autoplay + '&enablejsapi=1';
            if (this.core.s.youtubePlayerParams) {
                a = a + '&' + utils.param(this.core.s.youtubePlayerParams);
            }

            video = '<iframe class="lg-video-object lg-youtube ' + addClass + '" ' + videoTitle + ' width="560" height="315" src="//www.youtube.com/embed/' + isVideo.youtube[1] + a + '" frameborder="0" allowfullscreen></iframe>';
        } else if (isVideo.vimeo) {

            a = '?autoplay=' + autoplay + '&api=1';
            if (this.core.s.vimeoPlayerParams) {
                a = a + '&' + utils.param(this.core.s.vimeoPlayerParams);
            }

            video = '<iframe class="lg-video-object lg-vimeo ' + addClass + '" ' + videoTitle + ' width="560" height="315"  src="//player.vimeo.com/video/' + isVideo.vimeo[1] + a + '" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
        } else if (isVideo.dailymotion) {

            a = '?wmode=opaque&autoplay=' + autoplay + '&api=postMessage';
            if (this.core.s.dailymotionPlayerParams) {
                a = a + '&' + utils.param(this.core.s.dailymotionPlayerParams);
            }

            video = '<iframe class="lg-video-object lg-dailymotion ' + addClass + '" ' + videoTitle + ' width="560" height="315" src="//www.dailymotion.com/embed/video/' + isVideo.dailymotion[1] + a + '" frameborder="0" allowfullscreen></iframe>';
        } else if (isVideo.html5) {
            var fL = html.substring(0, 1);
            if (fL === '.' || fL === '#') {
                html = document.querySelector(html).innerHTML;
            }

            video = html;
        } else if (isVideo.vk) {

            a = '&autoplay=' + autoplay;
            if (this.core.s.vkPlayerParams) {
                a = a + '&' + utils.param(this.core.s.vkPlayerParams);
            }

            video = '<iframe class="lg-video-object lg-vk ' + addClass + '" ' + videoTitle + '  width="560" height="315" src="http://vk.com/video_ext.php?' + isVideo.vk[1] + a + '" frameborder="0" allowfullscreen></iframe>';
        }

        return video;
    };

    Video.prototype.destroy = function () {
        this.videoLoaded = false;
    };

    window.lgModules.video = Video;
});

},{}]},{},[1])(1)
});

/**!
 * lg-autoplay.js | 1.2.0 | May 20th 2020
 * http://sachinchoolur.github.io/lg-autoplay.js
 * Copyright (c) 2016 Sachin N; 
 * @license GPLv3 
 */(function(f){if(typeof exports==="object"&&typeof module!=="undefined"){module.exports=f()}else if(typeof define==="function"&&define.amd){define([],f)}else{var g;if(typeof window!=="undefined"){g=window}else if(typeof global!=="undefined"){g=global}else if(typeof self!=="undefined"){g=self}else{g=this}g.LgAutoplay = f()}})(function(){var define,module,exports;return (function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(require,module,exports){
    (function (global, factory) {
        if (typeof define === "function" && define.amd) {
            define([], factory);
        } else if (typeof exports !== "undefined") {
            factory();
        } else {
            var mod = {
                exports: {}
            };
            factory();
            global.lgAutoplay = mod.exports;
        }
    })(this, function () {
        'use strict';
    
        var _extends = Object.assign || function (target) {
            for (var i = 1; i < arguments.length; i++) {
                var source = arguments[i];
    
                for (var key in source) {
                    if (Object.prototype.hasOwnProperty.call(source, key)) {
                        target[key] = source[key];
                    }
                }
            }
    
            return target;
        };
    
        var autoplayDefaults = {
            autoplay: false,
            pause: 5000,
            progressBar: true,
            fourceAutoplay: false,
            autoplayControls: true,
            appendAutoplayControlsTo: '.lg-toolbar'
        };
    
        /**
         * Creates the autoplay plugin.
         * @param {object} element - lightGallery element
         */
        var Autoplay = function Autoplay(element) {
    
            this.el = element;
    
            this.core = window.lgData[this.el.getAttribute('lg-uid')];
    
            // Execute only if items are above 1
            if (this.core.items.length < 2) {
                return false;
            }
    
            this.core.s = _extends({}, autoplayDefaults, this.core.s);
            this.interval = false;
    
            // Identify if slide happened from autoplay
            this.fromAuto = true;
    
            // Identify if autoplay canceled from touch/drag
            this.canceledOnTouch = false;
    
            // save fourceautoplay value
            this.fourceAutoplayTemp = this.core.s.fourceAutoplay;
    
            // do not allow progress bar if browser does not support css3 transitions
            if (!this.core.doCss()) {
                this.core.s.progressBar = false;
            }
    
            this.init();
    
            return this;
        };
    
        Autoplay.prototype.init = function () {
            var _this = this;
    
            // append autoplay controls
            if (_this.core.s.autoplayControls) {
                _this.controls();
            }
    
            // Create progress bar
            if (_this.core.s.progressBar) {
                _this.core.outer.querySelector('.lg').insertAdjacentHTML('beforeend', '<div class="lg-progress-bar"><div class="lg-progress"></div></div>');
            }
    
            // set progress
            _this.progress();
    
            // Start autoplay
            if (_this.core.s.autoplay) {
                _this.startlAuto();
            }
    
            // cancel interval on touchstart and dragstart
            utils.on(_this.el, 'onDragstart.lgtm touchstart.lgtm', function () {
                if (_this.interval) {
                    _this.cancelAuto();
                    _this.canceledOnTouch = true;
                }
            });
    
            // restore autoplay if autoplay canceled from touchstart / dragstart
            utils.on(_this.el, 'onDragend.lgtm touchend.lgtm onSlideClick.lgtm', function () {
                if (!_this.interval && _this.canceledOnTouch) {
                    _this.startlAuto();
                    _this.canceledOnTouch = false;
                }
            });
        };
    
        Autoplay.prototype.progress = function () {
    
            var _this = this;
            var _progressBar;
            var _progress;
    
            utils.on(_this.el, 'onBeforeSlide.lgtm', function () {
    
                // start progress bar animation
                if (_this.core.s.progressBar && _this.fromAuto) {
                    _progressBar = _this.core.outer.querySelector('.lg-progress-bar');
                    _progress = _this.core.outer.querySelector('.lg-progress');
                    if (_this.interval) {
                        _progress.removeAttribute('style');
                        utils.removeClass(_progressBar, 'lg-start');
                        setTimeout(function () {
                            utils.setVendor(_progress, 'Transition', 'width ' + (_this.core.s.speed + _this.core.s.pause) + 'ms ease 0s');
                            utils.addClass(_progressBar, 'lg-start');
                        }, 20);
                    }
                }
    
                // Remove setinterval if slide is triggered manually and fourceautoplay is false
                if (!_this.fromAuto && !_this.core.s.fourceAutoplay) {
                    _this.cancelAuto();
                }
    
                _this.fromAuto = false;
            });
        };
    
        // Manage autoplay via play/stop buttons
        Autoplay.prototype.controls = function () {
            var _this = this;
            var _html = '<button aria-label="Toggle autoplay" class="lg-autoplay-button lg-icon"></button>';
    
            // Append autoplay controls
            _this.core.outer.querySelector(this.core.s.appendAutoplayControlsTo).insertAdjacentHTML('beforeend', _html);
    
            utils.on(_this.core.outer.querySelector('.lg-autoplay-button'), 'click.lg', function () {
                if (utils.hasClass(_this.core.outer, 'lg-show-autoplay')) {
                    _this.cancelAuto();
                    _this.core.s.fourceAutoplay = false;
                } else {
                    if (!_this.interval) {
                        _this.startlAuto();
                        _this.core.s.fourceAutoplay = _this.fourceAutoplayTemp;
                    }
                }
            });
        };
    
        // Autostart gallery
        Autoplay.prototype.startlAuto = function () {
            var _this = this;
    
            utils.setVendor(_this.core.outer.querySelector('.lg-progress'), 'Transition', 'width ' + (_this.core.s.speed + _this.core.s.pause) + 'ms ease 0s');
            utils.addClass(_this.core.outer, 'lg-show-autoplay');
            utils.addClass(_this.core.outer.querySelector('.lg-progress-bar'), 'lg-start');
    
            _this.interval = setInterval(function () {
                if (_this.core.index + 1 < _this.core.items.length) {
                    _this.core.index++;
                } else {
                    _this.core.index = 0;
                }
    
                _this.fromAuto = true;
                _this.core.slide(_this.core.index, false, false);
            }, _this.core.s.speed + _this.core.s.pause);
        };
    
        // cancel Autostart
        Autoplay.prototype.cancelAuto = function () {
            clearInterval(this.interval);
            this.interval = false;
            if (this.core.outer.querySelector('.lg-progress')) {
                this.core.outer.querySelector('.lg-progress').removeAttribute('style');
            }
    
            utils.removeClass(this.core.outer, 'lg-show-autoplay');
            utils.removeClass(this.core.outer.querySelector('.lg-progress-bar'), 'lg-start');
        };
    
        Autoplay.prototype.destroy = function () {
    
            this.cancelAuto();
            if (this.core.outer.querySelector('.lg-progress-bar')) {
                this.core.outer.querySelector('.lg-progress-bar').parentNode.removeChild(this.core.outer.querySelector('.lg-progress-bar'));
            }
        };
    
        window.lgModules.autoplay = Autoplay;
    });
    
    },{}]},{},[1])(1)
    });