
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