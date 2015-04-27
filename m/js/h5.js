!function() {
    function t(t, e) {
        var s = t[0], r = t[1], l = t[2], c = t[3];
        s = i(s, r, l, c, e[0], 7, -680876936), c = i(c, s, r, l, e[1], 12, -389564586), l = i(l, c, s, r, e[2], 17, 606105819), r = i(r, l, c, s, e[3], 22, -1044525330), s = i(s, r, l, c, e[4], 7, -176418897), c = i(c, s, r, l, e[5], 12, 1200080426), l = i(l, c, s, r, e[6], 17, -1473231341), r = i(r, l, c, s, e[7], 22, -45705983), s = i(s, r, l, c, e[8], 7, 1770035416), c = i(c, s, r, l, e[9], 12, -1958414417), l = i(l, c, s, r, e[10], 17, -42063), r = i(r, l, c, s, e[11], 22, -1990404162), s = i(s, r, l, c, e[12], 7, 1804603682), c = i(c, s, r, l, e[13], 12, -40341101), l = i(l, c, s, r, e[14], 17, -1502002290), r = i(r, l, c, s, e[15], 22, 1236535329), s = o(s, r, l, c, e[1], 5, -165796510), c = o(c, s, r, l, e[6], 9, -1069501632), l = o(l, c, s, r, e[11], 14, 643717713), r = o(r, l, c, s, e[0], 20, -373897302), s = o(s, r, l, c, e[5], 5, -701558691), c = o(c, s, r, l, e[10], 9, 38016083), l = o(l, c, s, r, e[15], 14, -660478335), r = o(r, l, c, s, e[4], 20, -405537848), s = o(s, r, l, c, e[9], 5, 568446438), c = o(c, s, r, l, e[14], 9, -1019803690), l = o(l, c, s, r, e[3], 14, -187363961), r = o(r, l, c, s, e[8], 20, 1163531501), s = o(s, r, l, c, e[13], 5, -1444681467), c = o(c, s, r, l, e[2], 9, -51403784), l = o(l, c, s, r, e[7], 14, 1735328473), r = o(r, l, c, s, e[12], 20, -1926607734), s = n(s, r, l, c, e[5], 4, -378558), c = n(c, s, r, l, e[8], 11, -2022574463), l = n(l, c, s, r, e[11], 16, 1839030562), r = n(r, l, c, s, e[14], 23, -35309556), s = n(s, r, l, c, e[1], 4, -1530992060), c = n(c, s, r, l, e[4], 11, 1272893353), l = n(l, c, s, r, e[7], 16, -155497632), r = n(r, l, c, s, e[10], 23, -1094730640), s = n(s, r, l, c, e[13], 4, 681279174), c = n(c, s, r, l, e[0], 11, -358537222), l = n(l, c, s, r, e[3], 16, -722521979), r = n(r, l, c, s, e[6], 23, 76029189), s = n(s, r, l, c, e[9], 4, -640364487), c = n(c, s, r, l, e[12], 11, -421815835), l = n(l, c, s, r, e[15], 16, 530742520), r = n(r, l, c, s, e[2], 23, -995338651), s = a(s, r, l, c, e[0], 6, -198630844), c = a(c, s, r, l, e[7], 10, 1126891415), l = a(l, c, s, r, e[14], 15, -1416354905), r = a(r, l, c, s, e[5], 21, -57434055), s = a(s, r, l, c, e[12], 6, 1700485571), c = a(c, s, r, l, e[3], 10, -1894986606), l = a(l, c, s, r, e[10], 15, -1051523), r = a(r, l, c, s, e[1], 21, -2054922799), s = a(s, r, l, c, e[8], 6, 1873313359), c = a(c, s, r, l, e[15], 10, -30611744), l = a(l, c, s, r, e[6], 15, -1560198380), r = a(r, l, c, s, e[13], 21, 1309151649), s = a(s, r, l, c, e[4], 6, -145523070), c = a(c, s, r, l, e[11], 10, -1120210379), l = a(l, c, s, r, e[2], 15, 718787259), r = a(r, l, c, s, e[9], 21, -343485551), t[0] = d(s, t[0]), t[1] = d(r, t[1]), t[2] = d(l, t[2]), t[3] = d(c, t[3])
    }
    function e(t, e, i, o, n, a) {
        return e = d(d(e, t), d(o, a)), d(e << n | e >>> 32 - n, i)
    }
    function i(t, i, o, n, a, s, r) {
        return e(i & o | ~i & n, t, i, a, s, r)
    }
    function o(t, i, o, n, a, s, r) {
        return e(i & n | o & ~n, t, i, a, s, r)
    }
    function n(t, i, o, n, a, s, r) {
        return e(i ^ o ^ n, t, i, a, s, r)
    }
    function a(t, i, o, n, a, s, r) {
        return e(o ^ (i | ~n), t, i, a, s, r)
    }
    function s(e) {
        /[\x80-\xFF]/.test(e) && (e = unescape(encodeURI(e))), txt = "";
        var i, o = e.length, n = [1732584193, -271733879, -1732584194, 271733878];
        for (i = 64; i <= e.length; i += 64)
            t(n, r(e.substring(i - 64, i)));
        e = e.substring(i - 64);
        var a = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        for (i = 0; i < e.length; i++)
            a[i >> 2] |= e.charCodeAt(i) << (i % 4 << 3);
        if (a[i >> 2] |= 128 << (i % 4 << 3), i > 55)
            for (t(n, a), i = 0; 16 > i; i++)
                a[i] = 0;
        return a[14] = 8 * o, t(n, a), n
    }
    function r(t) {
        var e, i = [];
        for (e = 0; 64 > e; e += 4)
            i[e >> 2] = t.charCodeAt(e) + (t.charCodeAt(e + 1) << 8) + (t.charCodeAt(e + 2) << 16) + (t.charCodeAt(e + 3) << 24);
        return i
    }
    function l(t) {
        for (var e = "", i = 0; 4 > i; i++)
            e += u[t >> 8 * i + 4 & 15] + u[t >> 8 * i & 15];
        return e
    }
    function c(t) {
        for (var e = 0; e < t.length; e++)
            t[e] = l(t[e]);
        return t.join("")
    }
    function d(t, e) {
        return t + e & 4294967295
    }
    function d(t, e) {
        var i = (65535 & t) + (65535 & e), o = (t >> 16) + (e >> 16) + (i >> 16);
        return o << 16 | 65535 & i
    }
    var u = "0123456789abcdef".split("");
    md5 = function(t) {
        return c(s(t))
    }, "5d41402abc4b2a76b9719d911017c592" != md5("hello")
}(), function(t, e, i) {
    function o(t, i) {
        this.wrapper = "string" == typeof t ? e.querySelector(t) : t, this.scroller = this.wrapper.children[0], this.scrollerStyle = this.scroller.style, this.options = {resizeScrollbars: !0,mouseWheelSpeed: 20,snapThreshold: .334,startX: 0,startY: 0,scrollY: !0,directionLockThreshold: 5,momentum: !0,bounce: !0,bounceTime: 600,bounceEasing: "",preventDefault: !0,preventDefaultException: {tagName: /^(INPUT|TEXTAREA|BUTTON|SELECT)$/},HWCompositing: !0,useTransition: !0,useTransform: !0};
        for (var o in i)
            this.options[o] = i[o];
        this.translateZ = this.options.HWCompositing && r.hasPerspective ? " translateZ(0)" : "", this.options.useTransition = r.hasTransition && this.options.useTransition, this.options.useTransform = r.hasTransform && this.options.useTransform, this.options.eventPassthrough = this.options.eventPassthrough === !0 ? "vertical" : this.options.eventPassthrough, this.options.preventDefault = !this.options.eventPassthrough && this.options.preventDefault, this.options.scrollY = "vertical" == this.options.eventPassthrough ? !1 : this.options.scrollY, this.options.scrollX = "horizontal" == this.options.eventPassthrough ? !1 : this.options.scrollX, this.options.freeScroll = this.options.freeScroll && !this.options.eventPassthrough, this.options.directionLockThreshold = this.options.eventPassthrough ? 0 : this.options.directionLockThreshold, this.options.bounceEasing = "string" == typeof this.options.bounceEasing ? r.ease[this.options.bounceEasing] || r.ease.circular : this.options.bounceEasing, this.options.resizePolling = void 0 === this.options.resizePolling ? 60 : this.options.resizePolling, this.options.tap === !0 && (this.options.tap = "tap"), "scale" == this.options.shrinkScrollbars && (this.options.useTransition = !1), this.options.invertWheelDirection = this.options.invertWheelDirection ? -1 : 1, 3 == this.options.probeType && (this.options.useTransition = !1), this.x = 0, this.y = 0, this.directionX = 0, this.directionY = 0, this._events = {}, this._init(), this.refresh(), this.scrollTo(this.options.startX, this.options.startY), this.enable()
    }
    function n(t, i, o) {
        var n = e.createElement("div"), a = e.createElement("div");
        return o === !0 && (n.style.cssText = "position:absolute;z-index:9999", a.style.cssText = "-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;position:absolute;background:rgba(0,0,0,0.5);border:1px solid rgba(255,255,255,0.9);border-radius:3px"), a.className = "iScrollIndicator", "h" == t ? (o === !0 && (n.style.cssText += ";height:7px;left:2px;right:2px;bottom:0", a.style.height = "100%"), n.className = "iScrollHorizontalScrollbar") : (o === !0 && (n.style.cssText += ";width:7px;bottom:2px;top:2px;right:1px", a.style.width = "100%"), n.className = "iScrollVerticalScrollbar"), n.style.cssText += ";overflow:hidden", i || (n.style.pointerEvents = "none"), n.appendChild(a), n
    }
    function a(i, o) {
        this.wrapper = "string" == typeof o.el ? e.querySelector(o.el) : o.el, this.wrapperStyle = this.wrapper.style, this.indicator = this.wrapper.children[0], this.indicatorStyle = this.indicator.style, this.scroller = i, this.options = {listenX: !0,listenY: !0,interactive: !1,resize: !0,defaultScrollbars: !1,shrink: !1,fade: !1,speedRatioX: 0,speedRatioY: 0};
        for (var n in o)
            this.options[n] = o[n];
        this.sizeRatioX = 1, this.sizeRatioY = 1, this.maxPosX = 0, this.maxPosY = 0, this.options.interactive && (this.options.disableTouch || (r.addEvent(this.indicator, "touchstart", this), r.addEvent(t, "touchend", this)), this.options.disablePointer || (r.addEvent(this.indicator, r.prefixPointerEvent("pointerdown"), this), r.addEvent(t, r.prefixPointerEvent("pointerup"), this)), this.options.disableMouse || (r.addEvent(this.indicator, "mousedown", this), r.addEvent(t, "mouseup", this))), this.options.fade && (this.wrapperStyle[r.style.transform] = this.scroller.translateZ, this.wrapperStyle[r.style.transitionDuration] = r.isBadAndroid ? "0.001s" : "0ms", this.wrapperStyle.opacity = "0")
    }
    var s = t.requestAnimationFrame || t.webkitRequestAnimationFrame || t.mozRequestAnimationFrame || t.oRequestAnimationFrame || t.msRequestAnimationFrame || function(e) {
            t.setTimeout(e, 1e3 / 60)
        }, r = function() {
        function o(t) {
            return s === !1 ? !1 : "" === s ? t : s + t.charAt(0).toUpperCase() + t.substr(1)
        }
        var n = {}, a = e.createElement("div").style, s = function() {
            for (var t, e = ["t", "webkitT", "MozT", "msT", "OT"], i = 0, o = e.length; o > i; i++)
                if (t = e[i] + "ransform", t in a)
                    return e[i].substr(0, e[i].length - 1);
            return !1
        }();
        n.getTime = Date.now || function() {
            return (new Date).getTime()
        }, n.extend = function(t, e) {
            for (var i in e)
                t[i] = e[i]
        }, n.addEvent = function(t, e, i, o) {
            t.addEventListener(e, i, !!o)
        }, n.removeEvent = function(t, e, i, o) {
            t.removeEventListener(e, i, !!o)
        }, n.prefixPointerEvent = function(e) {
            return t.MSPointerEvent ? "MSPointer" + e.charAt(9).toUpperCase() + e.substr(10) : e
        }, n.momentum = function(t, e, o, n, a, s) {
            var r, l, c = t - e, d = i.abs(c) / o;
            return s = void 0 === s ? 6e-4 : s, r = t + d * d / (2 * s) * (0 > c ? -1 : 1), l = d / s, n > r ? (r = a ? n - a / 2.5 * (d / 8) : n, c = i.abs(r - t), l = c / d) : r > 0 && (r = a ? a / 2.5 * (d / 8) : 0, c = i.abs(t) + r, l = c / d), {destination: i.round(r),duration: l}
        };
        var r = o("transform");
        n.extend(n, {hasTransform: r !== !1,hasPerspective: o("perspective") in a,hasTouch: "ontouchstart" in t,hasPointer: t.PointerEvent || t.MSPointerEvent,hasTransition: o("transition") in a});
        var l = t.navigator.appVersion, c = 0, d = function() {
            if (-1 !== l.indexOf("Android ")) {
                var t = l.indexOf("Android "), e = l.substring(t + 8, l.indexOf(";", t));
                return e = e.replace(/\./g, ""), 2 === e.length && (e += "0"), parseInt(e, 10)
            }
            return 0
        };
        try {
            c = d()
        } catch (u) {
            c = 0
        }
        var h = 411 === c && l.indexOf("UCBrowser") > -1, p = 430 === c && l.indexOf("MQQBrowser") > -1;
        return n.isBadAndroid = /Android /.test(l) && !/Chrome\/\d/.test(l) && 440 > c && !h && !p, n.extend(n.style = {}, {transform: r,transitionTimingFunction: o("transitionTimingFunction"),transitionDuration: o("transitionDuration"),transitionDelay: o("transitionDelay"),transformOrigin: o("transformOrigin")}), n.hasClass = function(t, e) {
            var i = new RegExp("(^|\\s)" + e + "(\\s|$)");
            return i.test(t.className)
        }, n.addClass = function(t, e) {
            if (!n.hasClass(t, e)) {
                var i = t.className.split(" ");
                i.push(e), t.className = i.join(" ")
            }
        }, n.removeClass = function(t, e) {
            if (n.hasClass(t, e)) {
                var i = new RegExp("(^|\\s)" + e + "(\\s|$)", "g");
                t.className = t.className.replace(i, " ")
            }
        }, n.offset = function(t) {
            for (var e = -t.offsetLeft, i = -t.offsetTop; t = t.offsetParent; )
                e -= t.offsetLeft, i -= t.offsetTop;
            return {left: e,top: i}
        }, n.preventDefaultException = function(t, e) {
            for (var i in e)
                if (e[i].test(t[i]))
                    return !0;
            return !1
        }, n.extend(n.eventType = {}, {touchstart: 1,touchmove: 1,touchend: 1,mousedown: 2,mousemove: 2,mouseup: 2,pointerdown: 3,pointermove: 3,pointerup: 3,MSPointerDown: 3,MSPointerMove: 3,MSPointerUp: 3}), n.extend(n.ease = {}, {quadratic: {style: "cubic-bezier(0.25, 0.46, 0.45, 0.94)",fn: function(t) {
            return t * (2 - t)
        }},circular: {style: "cubic-bezier(0.1, 0.57, 0.1, 1)",fn: function(t) {
            return i.sqrt(1 - --t * t)
        }},back: {style: "cubic-bezier(0.175, 0.885, 0.32, 1.275)",fn: function(t) {
            var e = 4;
            return (t -= 1) * t * ((e + 1) * t + e) + 1
        }},bounce: {style: "",fn: function(t) {
            return (t /= 1) < 1 / 2.75 ? 7.5625 * t * t : 2 / 2.75 > t ? 7.5625 * (t -= 1.5 / 2.75) * t + .75 : 2.5 / 2.75 > t ? 7.5625 * (t -= 2.25 / 2.75) * t + .9375 : 7.5625 * (t -= 2.625 / 2.75) * t + .984375
        }},elastic: {style: "",fn: function(t) {
            var e = .22, o = .4;
            return 0 === t ? 0 : 1 == t ? 1 : o * i.pow(2, -10 * t) * i.sin(2 * (t - e / 4) * i.PI / e) + 1
        }}}), n.tap = function(t, i) {
            var o = e.createEvent("Event");
            o.initEvent(i, !0, !0), o.pageX = t.pageX, o.pageY = t.pageY, t.target.dispatchEvent(o)
        }, n.click = function(t) {
            var i, o = t.target;
            /(SELECT|INPUT|TEXTAREA)/i.test(o.tagName) || (i = e.createEvent("MouseEvents"), i.initMouseEvent("click", !0, !0, t.view, 1, o.screenX, o.screenY, o.clientX, o.clientY, t.ctrlKey, t.altKey, t.shiftKey, t.metaKey, 0, null), i._constructed = !0, o.dispatchEvent(i))
        }, n
    }();
    o.prototype = {version: "5.1.2",_init: function() {
        this._initEvents(), (this.options.scrollbars || this.options.indicators) && this._initIndicators(), this.options.mouseWheel && this._initWheel(), this.options.snap && this._initSnap(), this.options.keyBindings && this._initKeys()
    },destroy: function() {
        this._initEvents(!0), this._execEvent("destroy")
    },_transitionEnd: function(t) {
        t.target == this.scroller && this.isInTransition && (this._transitionTime(), this.resetPosition(this.options.bounceTime) || (this.isInTransition = !1, this._execEvent("scrollEnd")))
    },_start: function(t) {
        if (!(1 != r.eventType[t.type] && 0 !== t.button || !this.enabled || this.initiated && r.eventType[t.type] !== this.initiated)) {
            !this.options.preventDefault || r.isBadAndroid || r.preventDefaultException(t.target, this.options.preventDefaultException) || t.preventDefault();
            var e, o = t.touches ? t.touches[0] : t;
            this.initiated = r.eventType[t.type], this.moved = !1, this.distX = 0, this.distY = 0, this.directionX = 0, this.directionY = 0, this.directionLocked = 0, this._transitionTime(), this.startTime = r.getTime(), this.options.useTransition && this.isInTransition ? (this.isInTransition = !1, e = this.getComputedPosition(), this._translate(i.round(e.x), i.round(e.y)), this._execEvent("scrollEnd")) : !this.options.useTransition && this.isAnimating && (this.isAnimating = !1, this._execEvent("scrollEnd")), this.startX = this.x, this.startY = this.y, this.absStartX = this.x, this.absStartY = this.y, this.pointX = o.pageX, this.pointY = o.pageY, this._execEvent("beforeScrollStart")
        }
    },_move: function(t) {
        if (this.enabled && r.eventType[t.type] === this.initiated) {
            this.options.preventDefault && t.preventDefault();
            var e, o, n, a, s = t.touches ? t.touches[0] : t, l = s.pageX - this.pointX, c = s.pageY - this.pointY, d = r.getTime();
            if (this.pointX = s.pageX, this.pointY = s.pageY, this.distX += l, this.distY += c, n = i.abs(this.distX), a = i.abs(this.distY), !(d - this.endTime > 300 && 10 > n && 10 > a)) {
                if (this.directionLocked || this.options.freeScroll || (this.directionLocked = n > a + this.options.directionLockThreshold ? "h" : a >= n + this.options.directionLockThreshold ? "v" : "n"), "h" == this.directionLocked) {
                    if ("vertical" == this.options.eventPassthrough)
                        t.preventDefault();
                    else if ("horizontal" == this.options.eventPassthrough)
                        return void (this.initiated = !1);
                    c = 0
                } else if ("v" == this.directionLocked) {
                    if ("horizontal" == this.options.eventPassthrough)
                        t.preventDefault();
                    else if ("vertical" == this.options.eventPassthrough)
                        return void (this.initiated = !1);
                    l = 0
                }
                l = this.hasHorizontalScroll ? l : 0, c = this.hasVerticalScroll ? c : 0, e = this.x + l, o = this.y + c, (e > 0 || e < this.maxScrollX) && (e = this.options.bounce ? this.x + l / 3 : e > 0 ? 0 : this.maxScrollX), (o > 0 || o < this.maxScrollY) && (o = this.options.bounce ? this.y + c / 3 : o > 0 ? 0 : this.maxScrollY), this.directionX = l > 0 ? -1 : 0 > l ? 1 : 0, this.directionY = c > 0 ? -1 : 0 > c ? 1 : 0, this.moved || this._execEvent("scrollStart"), this.moved = !0, this._translate(e, o), d - this.startTime > 300 && (this.startTime = d, this.startX = this.x, this.startY = this.y, 1 == this.options.probeType && this._execEvent("scroll")), this.options.probeType > 1 && this._execEvent("scroll")
            }
        }
    },_end: function(t) {
        if (this.enabled && r.eventType[t.type] === this.initiated) {
            this.options.preventDefault && !r.preventDefaultException(t.target, this.options.preventDefaultException) && t.preventDefault();
            var e, o, n = (t.changedTouches ? t.changedTouches[0] : t, r.getTime() - this.startTime), a = i.round(this.x), s = i.round(this.y), l = i.abs(a - this.startX), c = i.abs(s - this.startY), d = 0, u = "";
            if (this.isInTransition = 0, this.initiated = 0, this.endTime = r.getTime(), !this.resetPosition(this.options.bounceTime)) {
                if (this.scrollTo(a, s), !this.moved)
                    return this.options.tap && r.tap(t, this.options.tap), this.options.click && !r.isBadAndroid && r.click(t), void this._execEvent("scrollCancel");
                if (this._events.flick && 200 > n && 100 > l && 100 > c)
                    return void this._execEvent("flick");
                if (this.options.momentum && 300 > n && (e = this.hasHorizontalScroll ? r.momentum(this.x, this.startX, n, this.maxScrollX, this.options.bounce ? this.wrapperWidth : 0, this.options.deceleration) : {destination: a,duration: 0}, o = this.hasVerticalScroll ? r.momentum(this.y, this.startY, n, this.maxScrollY, this.options.bounce ? this.wrapperHeight : 0, this.options.deceleration) : {destination: s,duration: 0}, a = e.destination, s = o.destination, d = i.max(e.duration, o.duration), this.isInTransition = 1), this.options.snap) {
                    var h = this._nearestSnap(a, s);
                    this.currentPage = h, d = this.options.snapSpeed || i.max(i.max(i.min(i.abs(a - h.x), 1e3), i.min(i.abs(s - h.y), 1e3)), 300), a = h.x, s = h.y, this.directionX = 0, this.directionY = 0, u = this.options.bounceEasing
                }
                return a != this.x || s != this.y ? ((a > 0 || a < this.maxScrollX || s > 0 || s < this.maxScrollY) && (u = r.ease.quadratic), void this.scrollTo(a, s, d, u)) : void this._execEvent("scrollEnd")
            }
        }
    },_resize: function() {
        var t = this;
        clearTimeout(this.resizeTimeout), this.resizeTimeout = setTimeout(function() {
            t.refresh()
        }, this.options.resizePolling)
    },resetPosition: function(t) {
        var e = this.x, i = this.y;
        return t = t || 0, !this.hasHorizontalScroll || this.x > 0 ? e = 0 : this.x < this.maxScrollX && (e = this.maxScrollX), !this.hasVerticalScroll || this.y > 0 ? i = 0 : this.y < this.maxScrollY && (i = this.maxScrollY), e == this.x && i == this.y ? !1 : (this.scrollTo(e, i, t, this.options.bounceEasing), !0)
    },disable: function() {
        this.enabled = !1
    },enable: function() {
        this.enabled = !0
    },refresh: function() {
        this.wrapper.offsetHeight;
        this.wrapperWidth = this.wrapper.clientWidth, this.wrapperHeight = this.wrapper.clientHeight, this.scrollerWidth = this.scroller.offsetWidth, this.scrollerHeight = this.scroller.offsetHeight, this.maxScrollX = this.wrapperWidth - this.scrollerWidth, this.maxScrollY = this.wrapperHeight - this.scrollerHeight, this.hasHorizontalScroll = this.options.scrollX && this.maxScrollX < 0, this.hasVerticalScroll = this.options.scrollY && this.maxScrollY < 0, this.hasHorizontalScroll || (this.maxScrollX = 0, this.scrollerWidth = this.wrapperWidth), this.hasVerticalScroll || (this.maxScrollY = 0, this.scrollerHeight = this.wrapperHeight), this.endTime = 0, this.directionX = 0, this.directionY = 0, this.wrapperOffset = r.offset(this.wrapper), this._execEvent("refresh"), this.resetPosition()
    },on: function(t, e) {
        this._events[t] || (this._events[t] = []), this._events[t].push(e)
    },off: function(t, e) {
        if (this._events[t]) {
            var i = this._events[t].indexOf(e);
            i > -1 && this._events[t].splice(i, 1)
        }
    },_execEvent: function(t) {
        if (this._events[t]) {
            var e = 0, i = this._events[t].length;
            if (i)
                for (; i > e; e++)
                    this._events[t][e].apply(this, [].slice.call(arguments, 1))
        }
    },scrollBy: function(t, e, i, o) {
        t = this.x + t, e = this.y + e, i = i || 0, this.scrollTo(t, e, i, o)
    },scrollTo: function(t, e, i, o) {
        o = o || r.ease.circular, this.isInTransition = this.options.useTransition && i > 0, !i || this.options.useTransition && o.style ? (this._transitionTimingFunction(o.style), this._transitionTime(i), this._translate(t, e)) : this._animate(t, e, i, o.fn)
    },scrollToElement: function(t, e, o, n, a) {
        if (t = t.nodeType ? t : this.scroller.querySelector(t)) {
            var s = r.offset(t);
            s.left -= this.wrapperOffset.left, s.top -= this.wrapperOffset.top, o === !0 && (o = i.round(t.offsetWidth / 2 - this.wrapper.offsetWidth / 2)), n === !0 && (n = i.round(t.offsetHeight / 2 - this.wrapper.offsetHeight / 2)), s.left -= o || 0, s.top -= n || 0, s.left = s.left > 0 ? 0 : s.left < this.maxScrollX ? this.maxScrollX : s.left, s.top = s.top > 0 ? 0 : s.top < this.maxScrollY ? this.maxScrollY : s.top, e = void 0 === e || null === e || "auto" === e ? i.max(i.abs(this.x - s.left), i.abs(this.y - s.top)) : e, this.scrollTo(s.left, s.top, e, a)
        }
    },_transitionTime: function(t) {
        if (t = t || 0, this.scrollerStyle[r.style.transitionDuration] = t + "ms", !t && r.isBadAndroid && (this.scrollerStyle[r.style.transitionDuration] = "0.001s"), this.indicators)
            for (var e = this.indicators.length; e--; )
                this.indicators[e].transitionTime(t)
    },_transitionTimingFunction: function(t) {
        if (this.scrollerStyle[r.style.transitionTimingFunction] = t, this.indicators)
            for (var e = this.indicators.length; e--; )
                this.indicators[e].transitionTimingFunction(t)
    },_translate: function(t, e) {
        if (this.options.useTransform ? this.scrollerStyle[r.style.transform] = "translate(" + t + "px," + e + "px)" + this.translateZ : (t = i.round(t), e = i.round(e), this.scrollerStyle.left = t + "px", this.scrollerStyle.top = e + "px"), this.x = t, this.y = e, this.indicators)
            for (var o = this.indicators.length; o--; )
                this.indicators[o].updatePosition()
    },_initEvents: function(e) {
        var i = e ? r.removeEvent : r.addEvent, o = this.options.bindToWrapper ? this.wrapper : t;
        i(t, "orientationchange", this), i(t, "resize", this), this.options.click && !r.isBadAndroid && i(this.wrapper, "click", this, !0), this.options.disableMouse || (i(this.wrapper, "mousedown", this), i(o, "mousemove", this), i(o, "mousecancel", this), i(o, "mouseup", this)), r.hasPointer && !this.options.disablePointer && (i(this.wrapper, r.prefixPointerEvent("pointerdown"), this), i(o, r.prefixPointerEvent("pointermove"), this), i(o, r.prefixPointerEvent("pointercancel"), this), i(o, r.prefixPointerEvent("pointerup"), this)), r.hasTouch && !this.options.disableTouch && (i(this.wrapper, "touchstart", this), i(o, "touchmove", this), i(o, "touchcancel", this), i(o, "touchend", this)), i(this.scroller, "transitionend", this), i(this.scroller, "webkitTransitionEnd", this), i(this.scroller, "oTransitionEnd", this), i(this.scroller, "MSTransitionEnd", this)
    },getComputedPosition: function() {
        var e, i, o = t.getComputedStyle(this.scroller, null);
        return this.options.useTransform ? (o = o[r.style.transform].split(")")[0].split(", "), e = +(o[12] || o[4]), i = +(o[13] || o[5])) : (e = +o.left.replace(/[^-\d.]/g, ""), i = +o.top.replace(/[^-\d.]/g, "")), {x: e,y: i}
    },_initIndicators: function() {
        function t(t) {
            for (var e = r.indicators.length; e--; )
                t.call(r.indicators[e])
        }
        var e, i = this.options.interactiveScrollbars, o = "string" != typeof this.options.scrollbars, s = [], r = this;
        this.indicators = [], this.options.scrollbars && (this.options.scrollY && (e = {el: n("v", i, this.options.scrollbars),interactive: i,defaultScrollbars: !0,customStyle: o,resize: this.options.resizeScrollbars,shrink: this.options.shrinkScrollbars,fade: this.options.fadeScrollbars,listenX: !1}, this.wrapper.appendChild(e.el), s.push(e)), this.options.scrollX && (e = {el: n("h", i, this.options.scrollbars),interactive: i,defaultScrollbars: !0,customStyle: o,resize: this.options.resizeScrollbars,shrink: this.options.shrinkScrollbars,fade: this.options.fadeScrollbars,listenY: !1}, this.wrapper.appendChild(e.el), s.push(e))), this.options.indicators && (s = s.concat(this.options.indicators));
        for (var l = s.length; l--; )
            this.indicators.push(new a(this, s[l]));
        this.options.fadeScrollbars && (this.on("scrollEnd", function() {
            t(function() {
                this.fade()
            })
        }), this.on("scrollCancel", function() {
            t(function() {
                this.fade()
            })
        }), this.on("scrollStart", function() {
            t(function() {
                this.fade(1)
            })
        }), this.on("beforeScrollStart", function() {
            t(function() {
                this.fade(1, !0)
            })
        })), this.on("refresh", function() {
            t(function() {
                this.refresh()
            })
        }), this.on("destroy", function() {
            t(function() {
                this.destroy()
            }), delete this.indicators
        })
    },_initWheel: function() {
        r.addEvent(this.wrapper, "wheel", this), r.addEvent(this.wrapper, "mousewheel", this), r.addEvent(this.wrapper, "DOMMouseScroll", this), this.on("destroy", function() {
            r.removeEvent(this.wrapper, "wheel", this), r.removeEvent(this.wrapper, "mousewheel", this), r.removeEvent(this.wrapper, "DOMMouseScroll", this)
        })
    },_wheel: function(t) {
        if (this.enabled) {
            t.preventDefault(), t.stopPropagation();
            var e, o, n, a, s = this;
            if (void 0 === this.wheelTimeout && s._execEvent("scrollStart"), clearTimeout(this.wheelTimeout), this.wheelTimeout = setTimeout(function() {
                    s._execEvent("scrollEnd"), s.wheelTimeout = void 0
                }, 400), "deltaX" in t)
                e = -t.deltaX, o = -t.deltaY;
            else if ("wheelDeltaX" in t)
                e = t.wheelDeltaX / 120 * this.options.mouseWheelSpeed, o = t.wheelDeltaY / 120 * this.options.mouseWheelSpeed;
            else if ("wheelDelta" in t)
                e = o = t.wheelDelta / 120 * this.options.mouseWheelSpeed;
            else {
                if (!("detail" in t))
                    return;
                e = o = -t.detail / 3 * this.options.mouseWheelSpeed
            }
            if (e *= this.options.invertWheelDirection, o *= this.options.invertWheelDirection, this.hasVerticalScroll || (e = o, o = 0), this.options.snap)
                return n = this.currentPage.pageX, a = this.currentPage.pageY, e > 0 ? n-- : 0 > e && n++, o > 0 ? a-- : 0 > o && a++, void this.goToPage(n, a);
            n = this.x + i.round(this.hasHorizontalScroll ? e : 0), a = this.y + i.round(this.hasVerticalScroll ? o : 0), n > 0 ? n = 0 : n < this.maxScrollX && (n = this.maxScrollX), a > 0 ? a = 0 : a < this.maxScrollY && (a = this.maxScrollY), this.scrollTo(n, a, 0), this.options.probeType > 1 && this._execEvent("scroll")
        }
    },_initSnap: function() {
        this.currentPage = {}, "string" == typeof this.options.snap && (this.options.snap = this.scroller.querySelectorAll(this.options.snap)), this.on("refresh", function() {
            var t, e, o, n, a, s, r = 0, l = 0, c = 0, d = this.options.snapStepX || this.wrapperWidth, u = this.options.snapStepY || this.wrapperHeight;
            if (this.pages = [], this.wrapperWidth && this.wrapperHeight && this.scrollerWidth && this.scrollerHeight) {
                if (this.options.snap === !0)
                    for (o = i.round(d / 2), n = i.round(u / 2); c > -this.scrollerWidth; ) {
                        for (this.pages[r] = [], t = 0, a = 0; a > -this.scrollerHeight; )
                            this.pages[r][t] = {x: i.max(c, this.maxScrollX),y: i.max(a, this.maxScrollY),width: d,height: u,cx: c - o,cy: a - n}, a -= u, t++;
                        c -= d, r++
                    }
                else
                    for (s = this.options.snap, t = s.length, e = -1; t > r; r++)
                        (0 === r || s[r].offsetLeft <= s[r - 1].offsetLeft) && (l = 0, e++), this.pages[l] || (this.pages[l] = []), c = i.max(-s[r].offsetLeft, this.maxScrollX), a = i.max(-s[r].offsetTop, this.maxScrollY), o = c - i.round(s[r].offsetWidth / 2), n = a - i.round(s[r].offsetHeight / 2), this.pages[l][e] = {x: c,y: a,width: s[r].offsetWidth,height: s[r].offsetHeight,cx: o,cy: n}, c > this.maxScrollX && l++;
                this.goToPage(this.currentPage.pageX || 0, this.currentPage.pageY || 0, 0), this.options.snapThreshold % 1 === 0 ? (this.snapThresholdX = this.options.snapThreshold, this.snapThresholdY = this.options.snapThreshold) : (this.snapThresholdX = i.round(this.pages[this.currentPage.pageX][this.currentPage.pageY].width * this.options.snapThreshold), this.snapThresholdY = i.round(this.pages[this.currentPage.pageX][this.currentPage.pageY].height * this.options.snapThreshold))
            }
        }), this.on("flick", function() {
            var t = this.options.snapSpeed || i.max(i.max(i.min(i.abs(this.x - this.startX), 1e3), i.min(i.abs(this.y - this.startY), 1e3)), 300);
            this.goToPage(this.currentPage.pageX + this.directionX, this.currentPage.pageY + this.directionY, t)
        })
    },_nearestSnap: function(t, e) {
        if (!this.pages.length)
            return {x: 0,y: 0,pageX: 0,pageY: 0};
        var o = 0, n = this.pages.length, a = 0;
        if (i.abs(t - this.absStartX) < this.snapThresholdX && i.abs(e - this.absStartY) < this.snapThresholdY)
            return this.currentPage;
        for (t > 0 ? t = 0 : t < this.maxScrollX && (t = this.maxScrollX), e > 0 ? e = 0 : e < this.maxScrollY && (e = this.maxScrollY); n > o; o++)
            if (t >= this.pages[o][0].cx) {
                t = this.pages[o][0].x;
                break
            }
        for (n = this.pages[o].length; n > a; a++)
            if (e >= this.pages[0][a].cy) {
                e = this.pages[0][a].y;
                break
            }
        return o == this.currentPage.pageX && (o += this.directionX, 0 > o ? o = 0 : o >= this.pages.length && (o = this.pages.length - 1), t = this.pages[o][0].x), a == this.currentPage.pageY && (a += this.directionY, 0 > a ? a = 0 : a >= this.pages[0].length && (a = this.pages[0].length - 1), e = this.pages[0][a].y), {x: t,y: e,pageX: o,pageY: a}
    },goToPage: function(t, e, o, n) {
        n = n || this.options.bounceEasing, t >= this.pages.length ? t = this.pages.length - 1 : 0 > t && (t = 0), e >= this.pages[t].length ? e = this.pages[t].length - 1 : 0 > e && (e = 0);
        var a = this.pages[t][e].x, s = this.pages[t][e].y;
        o = void 0 === o ? this.options.snapSpeed || i.max(i.max(i.min(i.abs(a - this.x), 1e3), i.min(i.abs(s - this.y), 1e3)), 300) : o, this.currentPage = {x: a,y: s,pageX: t,pageY: e}, this.scrollTo(a, s, o, n)
    },next: function(t, e) {
        var i = this.currentPage.pageX, o = this.currentPage.pageY;
        i++, i >= this.pages.length && this.hasVerticalScroll && (i = 0, o++), this.goToPage(i, o, t, e)
    },prev: function(t, e) {
        var i = this.currentPage.pageX, o = this.currentPage.pageY;
        i--, 0 > i && this.hasVerticalScroll && (i = 0, o--), this.goToPage(i, o, t, e)
    },_initKeys: function() {
        var e, i = {pageUp: 33,pageDown: 34,end: 35,home: 36,left: 37,up: 38,right: 39,down: 40};
        if ("object" == typeof this.options.keyBindings)
            for (e in this.options.keyBindings)
                "string" == typeof this.options.keyBindings[e] && (this.options.keyBindings[e] = this.options.keyBindings[e].toUpperCase().charCodeAt(0));
        else
            this.options.keyBindings = {};
        for (e in i)
            this.options.keyBindings[e] = this.options.keyBindings[e] || i[e];
        r.addEvent(t, "keydown", this), this.on("destroy", function() {
            r.removeEvent(t, "keydown", this)
        })
    },_key: function(t) {
        if (this.enabled) {
            var e, o = this.options.snap, n = o ? this.currentPage.pageX : this.x, a = o ? this.currentPage.pageY : this.y, s = r.getTime(), l = this.keyTime || 0, c = .25;
            switch (this.options.useTransition && this.isInTransition && (e = this.getComputedPosition(), this._translate(i.round(e.x), i.round(e.y)), this.isInTransition = !1), this.keyAcceleration = 200 > s - l ? i.min(this.keyAcceleration + c, 50) : 0, t.keyCode) {
                case this.options.keyBindings.pageUp:
                    this.hasHorizontalScroll && !this.hasVerticalScroll ? n += o ? 1 : this.wrapperWidth : a += o ? 1 : this.wrapperHeight;
                    break;
                case this.options.keyBindings.pageDown:
                    this.hasHorizontalScroll && !this.hasVerticalScroll ? n -= o ? 1 : this.wrapperWidth : a -= o ? 1 : this.wrapperHeight;
                    break;
                case this.options.keyBindings.end:
                    n = o ? this.pages.length - 1 : this.maxScrollX, a = o ? this.pages[0].length - 1 : this.maxScrollY;
                    break;
                case this.options.keyBindings.home:
                    n = 0, a = 0;
                    break;
                case this.options.keyBindings.left:
                    n += o ? -1 : 5 + this.keyAcceleration >> 0;
                    break;
                case this.options.keyBindings.up:
                    a += o ? 1 : 5 + this.keyAcceleration >> 0;
                    break;
                case this.options.keyBindings.right:
                    n -= o ? -1 : 5 + this.keyAcceleration >> 0;
                    break;
                case this.options.keyBindings.down:
                    a -= o ? 1 : 5 + this.keyAcceleration >> 0;
                    break;
                default:
                    return
            }
            if (o)
                return void this.goToPage(n, a);
            n > 0 ? (n = 0, this.keyAcceleration = 0) : n < this.maxScrollX && (n = this.maxScrollX, this.keyAcceleration = 0), a > 0 ? (a = 0, this.keyAcceleration = 0) : a < this.maxScrollY && (a = this.maxScrollY, this.keyAcceleration = 0), this.scrollTo(n, a, 0), this.keyTime = s
        }
    },_animate: function(t, e, i, o) {
        function n() {
            var h, p, f, g = r.getTime();
            return g >= u ? (a.isAnimating = !1, a._translate(t, e), void (a.resetPosition(a.options.bounceTime) || a._execEvent("scrollEnd"))) : (g = (g - d) / i, f = o(g), h = (t - l) * f + l, p = (e - c) * f + c, a._translate(h, p), a.isAnimating && s(n), void (3 == a.options.probeType && a._execEvent("scroll")))
        }
        var a = this, l = this.x, c = this.y, d = r.getTime(), u = d + i;
        this.isAnimating = !0, n()
    },handleEvent: function(t) {
        switch (t.type) {
            case "touchstart":
            case "pointerdown":
            case "MSPointerDown":
            case "mousedown":
                this._start(t);
                break;
            case "touchmove":
            case "pointermove":
            case "MSPointerMove":
            case "mousemove":
                this._move(t);
                break;
            case "touchend":
            case "pointerup":
            case "MSPointerUp":
            case "mouseup":
            case "touchcancel":
            case "pointercancel":
            case "MSPointerCancel":
            case "mousecancel":
                this._end(t);
                break;
            case "orientationchange":
            case "resize":
                this._resize();
                break;
            case "transitionend":
            case "webkitTransitionEnd":
            case "oTransitionEnd":
            case "MSTransitionEnd":
                this._transitionEnd(t);
                break;
            case "wheel":
            case "DOMMouseScroll":
            case "mousewheel":
                this._wheel(t);
                break;
            case "keydown":
                this._key(t);
                break;
            case "click":
                t._constructed || (t.preventDefault(), t.stopPropagation())
        }
    }}, a.prototype = {handleEvent: function(t) {
        switch (t.type) {
            case "touchstart":
            case "pointerdown":
            case "MSPointerDown":
            case "mousedown":
                this._start(t);
                break;
            case "touchmove":
            case "pointermove":
            case "MSPointerMove":
            case "mousemove":
                this._move(t);
                break;
            case "touchend":
            case "pointerup":
            case "MSPointerUp":
            case "mouseup":
            case "touchcancel":
            case "pointercancel":
            case "MSPointerCancel":
            case "mousecancel":
                this._end(t)
        }
    },destroy: function() {
        this.options.interactive && (r.removeEvent(this.indicator, "touchstart", this), r.removeEvent(this.indicator, r.prefixPointerEvent("pointerdown"), this), r.removeEvent(this.indicator, "mousedown", this), r.removeEvent(t, "touchmove", this), r.removeEvent(t, r.prefixPointerEvent("pointermove"), this), r.removeEvent(t, "mousemove", this), r.removeEvent(t, "touchend", this), r.removeEvent(t, r.prefixPointerEvent("pointerup"), this), r.removeEvent(t, "mouseup", this)), this.options.defaultScrollbars && this.wrapper.parentNode.removeChild(this.wrapper)
    },_start: function(e) {
        var i = e.touches ? e.touches[0] : e;
        e.preventDefault(), e.stopPropagation(), this.transitionTime(), this.initiated = !0, this.moved = !1, this.lastPointX = i.pageX, this.lastPointY = i.pageY, this.startTime = r.getTime(), this.options.disableTouch || r.addEvent(t, "touchmove", this), this.options.disablePointer || r.addEvent(t, r.prefixPointerEvent("pointermove"), this), this.options.disableMouse || r.addEvent(t, "mousemove", this), this.scroller._execEvent("beforeScrollStart")
    },_move: function(t) {
        var e, i, o, n, a = t.touches ? t.touches[0] : t, s = r.getTime();
        this.moved || this.scroller._execEvent("scrollStart"), this.moved = !0, e = a.pageX - this.lastPointX, this.lastPointX = a.pageX, i = a.pageY - this.lastPointY, this.lastPointY = a.pageY, o = this.x + e, n = this.y + i, this._pos(o, n), 1 == this.scroller.options.probeType && s - this.startTime > 300 ? (this.startTime = s, this.scroller._execEvent("scroll")) : this.scroller.options.probeType > 1 && this.scroller._execEvent("scroll"), t.preventDefault(), t.stopPropagation()
    },_end: function(e) {
        if (this.initiated) {
            if (this.initiated = !1, e.preventDefault(), e.stopPropagation(), r.removeEvent(t, "touchmove", this), r.removeEvent(t, r.prefixPointerEvent("pointermove"), this), r.removeEvent(t, "mousemove", this), this.scroller.options.snap) {
                var o = this.scroller._nearestSnap(this.scroller.x, this.scroller.y), n = this.options.snapSpeed || i.max(i.max(i.min(i.abs(this.scroller.x - o.x), 1e3), i.min(i.abs(this.scroller.y - o.y), 1e3)), 300);
                (this.scroller.x != o.x || this.scroller.y != o.y) && (this.scroller.directionX = 0, this.scroller.directionY = 0, this.scroller.currentPage = o, this.scroller.scrollTo(o.x, o.y, n, this.scroller.options.bounceEasing))
            }
            this.moved && this.scroller._execEvent("scrollEnd")
        }
    },transitionTime: function(t) {
        t = t || 0, this.indicatorStyle[r.style.transitionDuration] = t + "ms", !t && r.isBadAndroid && (this.indicatorStyle[r.style.transitionDuration] = "0.001s")
    },transitionTimingFunction: function(t) {
        this.indicatorStyle[r.style.transitionTimingFunction] = t
    },refresh: function() {
        this.transitionTime(), this.indicatorStyle.display = this.options.listenX && !this.options.listenY ? this.scroller.hasHorizontalScroll ? "block" : "none" : this.options.listenY && !this.options.listenX ? this.scroller.hasVerticalScroll ? "block" : "none" : this.scroller.hasHorizontalScroll || this.scroller.hasVerticalScroll ? "block" : "none", this.scroller.hasHorizontalScroll && this.scroller.hasVerticalScroll ? (r.addClass(this.wrapper, "iScrollBothScrollbars"), r.removeClass(this.wrapper, "iScrollLoneScrollbar"), this.options.defaultScrollbars && this.options.customStyle && (this.options.listenX ? this.wrapper.style.right = "8px" : this.wrapper.style.bottom = "8px")) : (r.removeClass(this.wrapper, "iScrollBothScrollbars"), r.addClass(this.wrapper, "iScrollLoneScrollbar"), this.options.defaultScrollbars && this.options.customStyle && (this.options.listenX ? this.wrapper.style.right = "2px" : this.wrapper.style.bottom = "2px"));
        this.wrapper.offsetHeight;
        this.options.listenX && (this.wrapperWidth = this.wrapper.clientWidth, this.options.resize ? (this.indicatorWidth = i.max(i.round(this.wrapperWidth * this.wrapperWidth / (this.scroller.scrollerWidth || this.wrapperWidth || 1)), 8), this.indicatorStyle.width = this.indicatorWidth + "px") : this.indicatorWidth = this.indicator.clientWidth, this.maxPosX = this.wrapperWidth - this.indicatorWidth, "clip" == this.options.shrink ? (this.minBoundaryX = -this.indicatorWidth + 8, this.maxBoundaryX = this.wrapperWidth - 8) : (this.minBoundaryX = 0, this.maxBoundaryX = this.maxPosX), this.sizeRatioX = this.options.speedRatioX || this.scroller.maxScrollX && this.maxPosX / this.scroller.maxScrollX), this.options.listenY && (this.wrapperHeight = this.wrapper.clientHeight, this.options.resize ? (this.indicatorHeight = i.max(i.round(this.wrapperHeight * this.wrapperHeight / (this.scroller.scrollerHeight || this.wrapperHeight || 1)), 8), this.indicatorStyle.height = this.indicatorHeight + "px") : this.indicatorHeight = this.indicator.clientHeight, this.maxPosY = this.wrapperHeight - this.indicatorHeight, "clip" == this.options.shrink ? (this.minBoundaryY = -this.indicatorHeight + 8, this.maxBoundaryY = this.wrapperHeight - 8) : (this.minBoundaryY = 0, this.maxBoundaryY = this.maxPosY), this.maxPosY = this.wrapperHeight - this.indicatorHeight, this.sizeRatioY = this.options.speedRatioY || this.scroller.maxScrollY && this.maxPosY / this.scroller.maxScrollY), this.updatePosition()
    },updatePosition: function() {
        var t = this.options.listenX && i.round(this.sizeRatioX * this.scroller.x) || 0, e = this.options.listenY && i.round(this.sizeRatioY * this.scroller.y) || 0;
        this.options.ignoreBoundaries || (t < this.minBoundaryX ? ("scale" == this.options.shrink && (this.width = i.max(this.indicatorWidth + t, 8), this.indicatorStyle.width = this.width + "px"), t = this.minBoundaryX) : t > this.maxBoundaryX ? "scale" == this.options.shrink ? (this.width = i.max(this.indicatorWidth - (t - this.maxPosX), 8), this.indicatorStyle.width = this.width + "px", t = this.maxPosX + this.indicatorWidth - this.width) : t = this.maxBoundaryX : "scale" == this.options.shrink && this.width != this.indicatorWidth && (this.width = this.indicatorWidth, this.indicatorStyle.width = this.width + "px"), e < this.minBoundaryY ? ("scale" == this.options.shrink && (this.height = i.max(this.indicatorHeight + 3 * e, 8), this.indicatorStyle.height = this.height + "px"), e = this.minBoundaryY) : e > this.maxBoundaryY ? "scale" == this.options.shrink ? (this.height = i.max(this.indicatorHeight - 3 * (e - this.maxPosY), 8), this.indicatorStyle.height = this.height + "px", e = this.maxPosY + this.indicatorHeight - this.height) : e = this.maxBoundaryY : "scale" == this.options.shrink && this.height != this.indicatorHeight && (this.height = this.indicatorHeight, this.indicatorStyle.height = this.height + "px")), this.x = t, this.y = e, this.scroller.options.useTransform ? this.indicatorStyle[r.style.transform] = "translate(" + t + "px," + e + "px)" + this.scroller.translateZ : (this.indicatorStyle.left = t + "px", this.indicatorStyle.top = e + "px")
    },_pos: function(t, e) {
        0 > t ? t = 0 : t > this.maxPosX && (t = this.maxPosX), 0 > e ? e = 0 : e > this.maxPosY && (e = this.maxPosY), t = this.options.listenX ? i.round(t / this.sizeRatioX) : this.scroller.x, e = this.options.listenY ? i.round(e / this.sizeRatioY) : this.scroller.y, this.scroller.scrollTo(t, e)
    },fade: function(t, e) {
        if (!e || this.visible) {
            clearTimeout(this.fadeTimeout), this.fadeTimeout = null;
            var i = t ? 250 : 500, o = t ? 0 : 300;
            t = t ? "1" : "0", this.wrapperStyle[r.style.transitionDuration] = i + "ms", this.fadeTimeout = setTimeout(function(t) {
                this.wrapperStyle.opacity = t, this.visible = +t
            }.bind(this, t), o)
        }
    }}, o.utils = r, "undefined" != typeof module && module.exports ? module.exports = o : t.IScroll = o
}(window, document, Math), function(t) {
    t.pgwModal = function(e) {
        var i = {}, o = {close: !0,maxWidth: 500,popup: !1,duration: 0,confirm: !1,confirmButtons: [{name: "确定",style: "btn",fn: function() {
        }}, {name: "取消",style: "btn",fn: function(t) {
            t()
        }}],afterClose: function() {
        },afterRender: function() {
        },xClass: "pgwmodal",loading: "Loading in progress...",error: "An error has occured. Please try again in a few moments."};
        if ("undefined" != typeof window.pgwModalObject && (i = window.pgwModalObject), "object" == typeof e && !e.pushContent) {
            if (!e.url && !e.target && !e.content)
                throw new Error('PgwModal - There is no content to display, please provide a config parameter : "url", "target" or "content"');
            i.config = {}, i.config = t.extend({}, o, e), window.pgwModalObject = i
        }
        var n = function() {
            var e = i.config.xClass;
            if (i.config.popup && (e = "popup"), i.config.confirm && (e = "confirm"), i.config.customClass)
                var o = i.config.customClass;
            var n = '<div id="pgwModalWrapper" class="' + e + " " + o + '"></div><div id="pgwModal" class="' + e + " " + o + '"><div class="pm-container"><div class="pm-body"><a href="javascript:void(0)" class="pm-close" onclick="$.pgwModal(\'close\')"></a><div class="pm-title"></div><div class="pm-content cntr"></div></div></div></div>';
            return t("body").append(n), t(document).trigger("PgwModal::Create"), !0
        }, a = function() {
            t("#pgwModal .pm-title, #pgwModal .pm-content").html("");
            var e = i.config.xClass;
            return i.config.popup && (e = "popup"), i.config.confirm && (e = "confirm"), t("#pgwModalWrapper, #pgwModal").attr("class", e), !0
        }, s = function() {
            return angular.element("body").injector().invoke(function(e) {
                var i = angular.element(t("#pgwModal .pm-content")).scope();
                e(t("#pgwModal .pm-content"))(i), i.$digest()
            }), !0
        }, r = function(e) {
            if (t("#pgwModal .pm-content").html(e), i.config.angular && s(), i.config.confirm) {
                var o = t("<p>");
                o.addClass("btns"), t.each(i.config.confirmButtons, function(e, i) {
                    var n = t("<a>");
                    n.attr({href: i.link ? i.link : "javascript:;","class": i.style}), n.text(i.name), n.on("click", function() {
                        i.fn.call(this, h)
                    }), o.append(n)
                }), t("#pgwModal .pm-content").append(o)
            }
            return t(document).trigger("PgwModal::PushContent"), i.config.afterRender(), !0
        }, l = function() {
            var e = t(window).height(), i = t("#pgwModal .pm-body").height(), o = Math.round((e - i) / 3);
            return 0 >= o && (o = 10), t("#pgwModal .pm-body").css("margin-top", o), !0
        }, c = function() {
            return i.config.modalData
        }, d = function() {
            return t("body").hasClass("pgwModal")
        }, u = function() {
            t("#pgwModal, #pgwModalWrapper").hide(), t("body").removeClass("pgwModal"), a();
            try {
                delete window.pgwModalObject
            } catch (e) {
                window.pgwModalObject = void 0
            }
            return t(document).trigger("PgwModal::Close"), !0
        }, h = function() {
            t("#pgwModal, #pgwModalWrapper").remove(), t("body").removeClass("pgwModal")
        }, p = function() {
            if (0 == t("#pgwModal").length ? n() : a(), i.config.close ? t("#pgwModal .pm-close").show() : t("#pgwModal .pm-close").hide(), i.config.title && t("#pgwModal .pm-title").text(i.config.title), i.config.maxWidth && (i.config.popup && (i.config.maxWidth = "70%"), i.config.confirm && (i.config.maxWidth = "85%"), t("#pgwModal .pm-body").css("max-width", i.config.maxWidth)), i.config.url) {
                i.config.loading && t("#pgwModal .pm-content").html(i.config.loading);
                var o = {url: e.url,success: function(t) {
                    r(t)
                },error: function() {
                    t("#pgwModal .pm-content").html(i.config.error)
                }};
                i.config.ajaxOptions && (o = t.extend({}, o, i.config.ajaxOptions)), t.ajax(o)
            } else
                i.config.target ? r(t(i.config.target).html()) : i.config.content && r(i.config.content);
            return t("#pgwModal, #pgwModalWrapper").show(), t("body").addClass("pgwModal"), t(document).trigger("PgwModal::Open"), l(), i.config.duration > 0 && setTimeout(function() {
                h(), "function" == typeof i.config.afterClose && i.config.afterClose()
            }, i.config.duration), !0
        };
        return "string" == typeof e && "close" == e ? u() : "string" == typeof e && "reposition" == e ? l() : "string" == typeof e && "getData" == e ? c() : "string" == typeof e && "isOpen" == e ? d() : "object" == typeof e && e.pushContent ? r(e.pushContent) : "object" == typeof e ? p() : void 0
    }
}(window.Zepto || window.jQuery);
var Swiper = function(t, e) {
    "use strict";
    function i(t, e) {
        return document.querySelectorAll ? (e || document).querySelectorAll(t) : jQuery(t, e)
    }
    function o(t) {
        return "[object Array]" === Object.prototype.toString.apply(t) ? !0 : !1
    }
    function n() {
        var t = E - P;
        return e.freeMode && (t = E - P), e.slidesPerView > T.slides.length && !e.centeredSlides && (t = 0), 0 > t && (t = 0), t
    }
    function a() {
        function t(t) {
            var i = new Image;
            i.onload = function() {
                "undefined" != typeof T && null !== T && (void 0 !== T.imagesLoaded && T.imagesLoaded++, T.imagesLoaded === T.imagesToLoad.length && (T.reInit(), e.onImagesReady && T.fireCallback(e.onImagesReady, T)))
            }, i.src = t
        }
        var o = T.h.addEventListener, n = "wrapper" === e.eventTarget ? T.wrapper : T.container;
        if (T.browser.ie10 || T.browser.ie11 ? (o(n, T.touchEvents.touchStart, g), o(document, T.touchEvents.touchMove, m), o(document, T.touchEvents.touchEnd, v)) : (T.support.touch && (o(n, "touchstart", g), o(n, "touchmove", m), o(n, "touchend", v)), e.simulateTouch && (o(n, "mousedown", g), o(document, "mousemove", m), o(document, "mouseup", v))), e.autoResize && o(window, "resize", T.resizeFix), s(), T._wheelEvent = !1, e.mousewheelControl) {
            if (void 0 !== document.onmousewheel && (T._wheelEvent = "mousewheel"), !T._wheelEvent)
                try {
                    new WheelEvent("wheel"), T._wheelEvent = "wheel"
                } catch (a) {
                }
            T._wheelEvent || (T._wheelEvent = "DOMMouseScroll"), T._wheelEvent && o(T.container, T._wheelEvent, c)
        }
        if (e.keyboardControl && o(document, "keydown", l), e.updateOnImagesReady) {
            T.imagesToLoad = i("img", T.container);
            for (var r = 0; r < T.imagesToLoad.length; r++)
                t(T.imagesToLoad[r].getAttribute("src"))
        }
    }
    function s() {
        var t, o = T.h.addEventListener;
        if (e.preventLinks) {
            var n = i("a", T.container);
            for (t = 0; t < n.length; t++)
                o(n[t], "click", p)
        }
        if (e.releaseFormElements) {
            var a = i("input, textarea, select", T.container);
            for (t = 0; t < a.length; t++)
                o(a[t], T.touchEvents.touchStart, f, !0)
        }
        if (e.onSlideClick)
            for (t = 0; t < T.slides.length; t++)
                o(T.slides[t], "click", d);
        if (e.onSlideTouch)
            for (t = 0; t < T.slides.length; t++)
                o(T.slides[t], T.touchEvents.touchStart, u)
    }
    function r() {
        var t, o = T.h.removeEventListener;
        if (e.onSlideClick)
            for (t = 0; t < T.slides.length; t++)
                o(T.slides[t], "click", d);
        if (e.onSlideTouch)
            for (t = 0; t < T.slides.length; t++)
                o(T.slides[t], T.touchEvents.touchStart, u);
        if (e.releaseFormElements) {
            var n = i("input, textarea, select", T.container);
            for (t = 0; t < n.length; t++)
                o(n[t], T.touchEvents.touchStart, f, !0)
        }
        if (e.preventLinks) {
            var a = i("a", T.container);
            for (t = 0; t < a.length; t++)
                o(a[t], "click", p)
        }
    }
    function l(t) {
        var e = t.keyCode || t.charCode;
        if (!(t.shiftKey || t.altKey || t.ctrlKey || t.metaKey)) {
            if (37 === e || 39 === e || 38 === e || 40 === e) {
                for (var i = !1, o = T.h.getOffset(T.container), n = T.h.windowScroll().left, a = T.h.windowScroll().top, s = T.h.windowWidth(), r = T.h.windowHeight(), l = [[o.left, o.top], [o.left + T.width, o.top], [o.left, o.top + T.height], [o.left + T.width, o.top + T.height]], c = 0; c < l.length; c++) {
                    var d = l[c];
                    d[0] >= n && d[0] <= n + s && d[1] >= a && d[1] <= a + r && (i = !0)
                }
                if (!i)
                    return
            }
            A ? ((37 === e || 39 === e) && (t.preventDefault ? t.preventDefault() : t.returnValue = !1), 39 === e && T.swipeNext(), 37 === e && T.swipePrev()) : ((38 === e || 40 === e) && (t.preventDefault ? t.preventDefault() : t.returnValue = !1), 40 === e && T.swipeNext(), 38 === e && T.swipePrev())
        }
    }
    function c(t) {
        var i = T._wheelEvent, o = 0;
        if (t.detail)
            o = -t.detail;
        else if ("mousewheel" === i)
            if (e.mousewheelControlForceToAxis)
                if (A) {
                    if (!(Math.abs(t.wheelDeltaX) > Math.abs(t.wheelDeltaY)))
                        return;
                    o = t.wheelDeltaX
                } else {
                    if (!(Math.abs(t.wheelDeltaY) > Math.abs(t.wheelDeltaX)))
                        return;
                    o = t.wheelDeltaY
                }
            else
                o = t.wheelDelta;
        else if ("DOMMouseScroll" === i)
            o = -t.detail;
        else if ("wheel" === i)
            if (e.mousewheelControlForceToAxis)
                if (A) {
                    if (!(Math.abs(t.deltaX) > Math.abs(t.deltaY)))
                        return;
                    o = -t.deltaX
                } else {
                    if (!(Math.abs(t.deltaY) > Math.abs(t.deltaX)))
                        return;
                    o = -t.deltaY
                }
            else
                o = Math.abs(t.deltaX) > Math.abs(t.deltaY) ? -t.deltaX : -t.deltaY;
        if (e.freeMode) {
            var a = T.getWrapperTranslate() + o;
            if (a > 0 && (a = 0), a < -n() && (a = -n()), T.setWrapperTransition(0), T.setWrapperTranslate(a), T.updateActiveSlide(a), 0 === a || a === -n())
                return
        } else
            (new Date).getTime() - R > 60 && (0 > o ? T.swipeNext() : T.swipePrev()), R = (new Date).getTime();
        return e.autoplay && T.stopAutoplay(!0), t.preventDefault ? t.preventDefault() : t.returnValue = !1, !1
    }
    function d(t) {
        T.allowSlideClick && (h(t), T.fireCallback(e.onSlideClick, T, t))
    }
    function u(t) {
        h(t), T.fireCallback(e.onSlideTouch, T, t)
    }
    function h(t) {
        if (t.currentTarget)
            T.clickedSlide = t.currentTarget;
        else {
            var i = t.srcElement;
            do {
                if (i.className.indexOf(e.slideClass) > -1)
                    break;
                i = i.parentNode
            } while (i);
            T.clickedSlide = i
        }
        T.clickedSlideIndex = T.slides.indexOf(T.clickedSlide), T.clickedSlideLoopIndex = T.clickedSlideIndex - (T.loopedSlides || 0)
    }
    function p(t) {
        return T.allowLinks ? void 0 : (t.preventDefault ? t.preventDefault() : t.returnValue = !1, e.preventLinksPropagation && "stopPropagation" in t && t.stopPropagation(), !1)
    }
    function f(t) {
        return t.stopPropagation ? t.stopPropagation() : t.returnValue = !1, !1
    }
    function g(t) {
        if (e.preventLinks && (T.allowLinks = !0), T.isTouched || e.onlyExternal)
            return !1;
        var i = t.target || t.srcElement;
        document.activeElement && document.activeElement !== i && document.activeElement.blur();
        var o = "input select textarea".split(" ");
        if (e.noSwiping && i && $(i))
            return !1;
        if (Q = !1, T.isTouched = !0, K = "touchstart" === t.type, !K && "which" in t && 3 === t.which)
            return !1;
        if (!K || 1 === t.targetTouches.length) {
            T.callPlugins("onTouchStartBegin"), !K && !T.isAndroid && o.indexOf(i.tagName.toLowerCase()) < 0 && (t.preventDefault ? t.preventDefault() : t.returnValue = !1);
            var n = K ? t.targetTouches[0].pageX : t.pageX || t.clientX, a = K ? t.targetTouches[0].pageY : t.pageY || t.clientY;
            T.touches.startX = T.touches.currentX = n, T.touches.startY = T.touches.currentY = a, T.touches.start = T.touches.current = A ? n : a, T.setWrapperTransition(0), T.positions.start = T.positions.current = T.getWrapperTranslate(), T.setWrapperTranslate(T.positions.start), T.times.start = (new Date).getTime(), I = void 0, e.moveStartThreshold > 0 && (X = !1), e.onTouchStart && T.fireCallback(e.onTouchStart, T, t), T.callPlugins("onTouchStartEnd")
        }
    }
    function m(t) {
        if (T.isTouched && !e.onlyExternal && (!K || "mousemove" !== t.type)) {
            var i = K ? t.targetTouches[0].pageX : t.pageX || t.clientX, o = K ? t.targetTouches[0].pageY : t.pageY || t.clientY;
            if ("undefined" == typeof I && A && (I = !!(I || Math.abs(o - T.touches.startY) > Math.abs(i - T.touches.startX))), "undefined" != typeof I || A || (I = !!(I || Math.abs(o - T.touches.startY) < Math.abs(i - T.touches.startX))), I)
                return void (T.isTouched = !1);
            if (A) {
                if (!e.swipeToNext && i < T.touches.startX || !e.swipeToPrev && i > T.touches.startX)
                    return
            } else if (!e.swipeToNext && o < T.touches.startY || !e.swipeToPrev && o > T.touches.startY)
                return;
            if (t.assignedToSwiper)
                return void (T.isTouched = !1);
            if (t.assignedToSwiper = !0, e.preventLinks && (T.allowLinks = !1), e.onSlideClick && (T.allowSlideClick = !1), e.autoplay && T.stopAutoplay(!0), !K || 1 === t.touches.length) {
                if (T.isMoved || (T.callPlugins("onTouchMoveStart"), e.loop && (T.fixLoop(), T.positions.start = T.getWrapperTranslate()), e.onTouchMoveStart && T.fireCallback(e.onTouchMoveStart, T)), T.isMoved = !0, t.preventDefault ? t.preventDefault() : t.returnValue = !1, T.touches.current = A ? i : o, T.positions.current = (T.touches.current - T.touches.start) * e.touchRatio + T.positions.start, T.positions.current > 0 && e.onResistanceBefore && T.fireCallback(e.onResistanceBefore, T, T.positions.current), T.positions.current < -n() && e.onResistanceAfter && T.fireCallback(e.onResistanceAfter, T, Math.abs(T.positions.current + n())), e.resistance && "100%" !== e.resistance) {
                    var a;
                    if (T.positions.current > 0 && (a = 1 - T.positions.current / P / 2, T.positions.current = .5 > a ? P / 2 : T.positions.current * a), T.positions.current < -n()) {
                        var s = (T.touches.current - T.touches.start) * e.touchRatio + (n() + T.positions.start);
                        a = (P + s) / P;
                        var r = T.positions.current - s * (1 - a) / 2, l = -n() - P / 2;
                        T.positions.current = l > r || 0 >= a ? l : r
                    }
                }
                if (e.resistance && "100%" === e.resistance && (T.positions.current > 0 && (!e.freeMode || e.freeModeFluid) && (T.positions.current = 0), T.positions.current < -n() && (!e.freeMode || e.freeModeFluid) && (T.positions.current = -n())), !e.followFinger)
                    return;
                if (e.moveStartThreshold)
                    if (Math.abs(T.touches.current - T.touches.start) > e.moveStartThreshold || X) {
                        if (!X)
                            return X = !0, void (T.touches.start = T.touches.current);
                        T.setWrapperTranslate(T.positions.current)
                    } else
                        T.positions.current = T.positions.start;
                else
                    T.setWrapperTranslate(T.positions.current);
                return (e.freeMode || e.watchActiveIndex) && T.updateActiveSlide(T.positions.current), e.grabCursor && (T.container.style.cursor = "move", T.container.style.cursor = "grabbing", T.container.style.cursor = "-moz-grabbin", T.container.style.cursor = "-webkit-grabbing"), q || (q = T.touches.current), V || (V = (new Date).getTime()), T.velocity = (T.touches.current - q) / ((new Date).getTime() - V) / 2, Math.abs(T.touches.current - q) < 2 && (T.velocity = 0), q = T.touches.current, V = (new Date).getTime(), T.callPlugins("onTouchMoveEnd"), e.onTouchMove && T.fireCallback(e.onTouchMove, T, t), !1
            }
        }
    }
    function v(t) {
        if (I && T.swipeReset(), !e.onlyExternal && T.isTouched) {
            T.isTouched = !1, e.grabCursor && (T.container.style.cursor = "move", T.container.style.cursor = "grab", T.container.style.cursor = "-moz-grab", T.container.style.cursor = "-webkit-grab"), T.positions.current || 0 === T.positions.current || (T.positions.current = T.positions.start), e.followFinger && T.setWrapperTranslate(T.positions.current), T.times.end = (new Date).getTime(), T.touches.diff = T.touches.current - T.touches.start, T.touches.abs = Math.abs(T.touches.diff), T.positions.diff = T.positions.current - T.positions.start, T.positions.abs = Math.abs(T.positions.diff);
            var i = T.positions.diff, o = T.positions.abs, a = T.times.end - T.times.start;
            5 > o && 300 > a && T.allowLinks === !1 && (e.freeMode || 0 === o || T.swipeReset(), e.preventLinks && (T.allowLinks = !0), e.onSlideClick && (T.allowSlideClick = !0)), setTimeout(function() {
                "undefined" != typeof T && null !== T && (e.preventLinks && (T.allowLinks = !0), e.onSlideClick && (T.allowSlideClick = !0))
            }, 100);
            var s = n();
            if (!T.isMoved && e.freeMode)
                return T.isMoved = !1, e.onTouchEnd && T.fireCallback(e.onTouchEnd, T, t), void T.callPlugins("onTouchEnd");
            if (!T.isMoved || T.positions.current > 0 || T.positions.current < -s)
                return T.swipeReset(), e.onTouchEnd && T.fireCallback(e.onTouchEnd, T, t), void T.callPlugins("onTouchEnd");
            if (T.isMoved = !1, e.freeMode) {
                if (e.freeModeFluid) {
                    var r, l = 1e3 * e.momentumRatio, c = T.velocity * l, d = T.positions.current + c, u = !1, h = 20 * Math.abs(T.velocity) * e.momentumBounceRatio;
                    -s > d && (e.momentumBounce && T.support.transitions ? (-h > d + s && (d = -s - h), r = -s, u = !0, Q = !0) : d = -s), d > 0 && (e.momentumBounce && T.support.transitions ? (d > h && (d = h), r = 0, u = !0, Q = !0) : d = 0), 0 !== T.velocity && (l = Math.abs((d - T.positions.current) / T.velocity)), T.setWrapperTranslate(d), T.setWrapperTransition(l), e.momentumBounce && u && T.wrapperTransitionEnd(function() {
                        Q && (e.onMomentumBounce && T.fireCallback(e.onMomentumBounce, T), T.callPlugins("onMomentumBounce"), T.setWrapperTranslate(r), T.setWrapperTransition(300))
                    }), T.updateActiveSlide(d)
                }
                return (!e.freeModeFluid || a >= 300) && T.updateActiveSlide(T.positions.current), e.onTouchEnd && T.fireCallback(e.onTouchEnd, T, t), void T.callPlugins("onTouchEnd")
            }
            L = 0 > i ? "toNext" : "toPrev", "toNext" === L && 300 >= a && (30 > o || !e.shortSwipes ? T.swipeReset() : T.swipeNext(!0)), "toPrev" === L && 300 >= a && (30 > o || !e.shortSwipes ? T.swipeReset() : T.swipePrev(!0));
            var p = 0;
            if ("auto" === e.slidesPerView) {
                for (var f, g = Math.abs(T.getWrapperTranslate()), m = 0, v = 0; v < T.slides.length; v++)
                    if (f = A ? T.slides[v].getWidth(!0, e.roundLengths) : T.slides[v].getHeight(!0, e.roundLengths), m += f, m > g) {
                        p = f;
                        break
                    }
                p > P && (p = P)
            } else
                p = G * e.slidesPerView;
            "toNext" === L && a > 300 && (o >= p * e.longSwipesRatio ? T.swipeNext(!0) : T.swipeReset()), "toPrev" === L && a > 300 && (o >= p * e.longSwipesRatio ? T.swipePrev(!0) : T.swipeReset()), e.onTouchEnd && T.fireCallback(e.onTouchEnd, T, t), T.callPlugins("onTouchEnd")
        }
    }
    function $(t) {
        var i = !1;
        do
            t.className.indexOf(e.noSwipingClass) > -1 && (i = !0), t = t.parentElement;
        while (!i && t.parentElement && -1 === t.className.indexOf(e.wrapperClass));
        return !i && t.className.indexOf(e.wrapperClass) > -1 && t.className.indexOf(e.noSwipingClass) > -1 && (i = !0), i
    }
    function w(t, e) {
        var i, o = document.createElement("div");
        return o.innerHTML = e, i = o.firstChild, i.className += " " + t, i.outerHTML
    }
    function S(t, i, o) {
        function n() {
            var a = +new Date, u = a - s;
            r += l * u / (1e3 / 60), d = "toNext" === c ? r > t : t > r, d ? (T.setWrapperTranslate(Math.ceil(r)), T._DOMAnimating = !0, window.setTimeout(function() {
                n()
            }, 1e3 / 60)) : (e.onSlideChangeEnd && ("to" === i ? o.runCallbacks === !0 && T.fireCallback(e.onSlideChangeEnd, T, c) : T.fireCallback(e.onSlideChangeEnd, T, c)), T.setWrapperTranslate(t), T._DOMAnimating = !1)
        }
        var a = "to" === i && o.speed >= 0 ? o.speed : e.speed, s = +new Date;
        if (T.support.transitions || !e.DOMAnimation)
            T.setWrapperTranslate(t), T.setWrapperTransition(a);
        else {
            var r = T.getWrapperTranslate(), l = Math.ceil((t - r) / a * (1e3 / 60)), c = r > t ? "toNext" : "toPrev", d = "toNext" === c ? r > t : t > r;
            if (T._DOMAnimating)
                return;
            n()
        }
        T.updateActiveSlide(t), e.onSlideNext && "next" === i && T.fireCallback(e.onSlideNext, T, t), e.onSlidePrev && "prev" === i && T.fireCallback(e.onSlidePrev, T, t), e.onSlideReset && "reset" === i && T.fireCallback(e.onSlideReset, T, t), ("next" === i || "prev" === i || "to" === i && o.runCallbacks === !0) && _(i)
    }
    function _(t) {
        if (T.callPlugins("onSlideChangeStart"), e.onSlideChangeStart)
            if (e.queueStartCallbacks && T.support.transitions) {
                if (T._queueStartCallbacks)
                    return;
                T._queueStartCallbacks = !0, T.fireCallback(e.onSlideChangeStart, T, t), T.wrapperTransitionEnd(function() {
                    T._queueStartCallbacks = !1
                })
            } else
                T.fireCallback(e.onSlideChangeStart, T, t);
        if (e.onSlideChangeEnd)
            if (T.support.transitions)
                if (e.queueEndCallbacks) {
                    if (T._queueEndCallbacks)
                        return;
                    T._queueEndCallbacks = !0, T.wrapperTransitionEnd(function(i) {
                        T.fireCallback(e.onSlideChangeEnd, i, t)
                    })
                } else
                    T.wrapperTransitionEnd(function(i) {
                        T.fireCallback(e.onSlideChangeEnd, i, t)
                    });
            else
                e.DOMAnimation || setTimeout(function() {
                    T.fireCallback(e.onSlideChangeEnd, T, t)
                }, 10)
    }
    function y() {
        var t = T.paginationButtons;
        if (t)
            for (var e = 0; e < t.length; e++)
                T.h.removeEventListener(t[e], "click", x)
    }
    function b() {
        var t = T.paginationButtons;
        if (t)
            for (var e = 0; e < t.length; e++)
                T.h.addEventListener(t[e], "click", x)
    }
    function x(t) {
        for (var i, o = t.target || t.srcElement, n = T.paginationButtons, a = 0; a < n.length; a++)
            o === n[a] && (i = a);
        e.autoplay && T.stopAutoplay(!0), T.swipeTo(i)
    }
    function C() {
        Z = setTimeout(function() {
            e.loop ? (T.fixLoop(), T.swipeNext(!0)) : T.swipeNext(!0) || (e.autoplayStopOnLast ? (clearTimeout(Z), Z = void 0) : T.swipeTo(0)), T.wrapperTransitionEnd(function() {
                "undefined" != typeof Z && C()
            })
        }, e.autoplay)
    }
    function J() {
        T.calcSlides(), e.loader.slides.length > 0 && 0 === T.slides.length && T.loadSlides(), e.loop && T.createLoop(), T.init(), a(), e.pagination && T.createPagination(!0), e.loop || e.initialSlide > 0 ? T.swipeTo(e.initialSlide, 0, !1) : T.updateActiveSlide(0), e.autoplay && T.startAutoplay(), T.centerIndex = T.activeIndex, e.onSwiperCreated && T.fireCallback(e.onSwiperCreated, T), T.callPlugins("onSwiperCreated")
    }
    if (!document.body.outerHTML && document.body.__defineGetter__ && HTMLElement) {
        var H = HTMLElement.prototype;
        H.__defineGetter__ && H.__defineGetter__("outerHTML", function() {
            return (new XMLSerializer).serializeToString(this)
        })
    }
    if (window.getComputedStyle || (window.getComputedStyle = function(t) {
            return this.el = t, this.getPropertyValue = function(e) {
                var i = /(\-([a-z]){1})/g;
                return "float" === e && (e = "styleFloat"), i.test(e) && (e = e.replace(i, function() {
                    return arguments[2].toUpperCase()
                })), t.currentStyle[e] ? t.currentStyle[e] : null
            }, this
        }), Array.prototype.indexOf || (Array.prototype.indexOf = function(t, e) {
            for (var i = e || 0, o = this.length; o > i; i++)
                if (this[i] === t)
                    return i;
            return -1
        }), (document.querySelectorAll || window.jQuery) && "undefined" != typeof t && (t.nodeType || 0 !== i(t).length)) {
        var T = this;
        T.touches = {start: 0,startX: 0,startY: 0,current: 0,currentX: 0,currentY: 0,diff: 0,abs: 0}, T.positions = {start: 0,abs: 0,diff: 0,current: 0}, T.times = {start: 0,end: 0}, T.id = (new Date).getTime(), T.container = t.nodeType ? t : i(t)[0], T.isTouched = !1, T.isMoved = !1, T.activeIndex = 0, T.centerIndex = 0, T.activeLoaderIndex = 0, T.activeLoopIndex = 0, T.previousIndex = null, T.velocity = 0, T.snapGrid = [], T.slidesGrid = [], T.imagesToLoad = [], T.imagesLoaded = 0, T.wrapperLeft = 0, T.wrapperRight = 0, T.wrapperTop = 0, T.wrapperBottom = 0, T.isAndroid = navigator.userAgent.toLowerCase().indexOf("android") >= 0;
        var k, G, E, L, I, P, D = {eventTarget: "wrapper",mode: "horizontal",touchRatio: 1,speed: 300,freeMode: !1,freeModeFluid: !1,momentumRatio: 1,momentumBounce: !0,momentumBounceRatio: 1,slidesPerView: 1,slidesPerGroup: 1,slidesPerViewFit: !0,simulateTouch: !0,followFinger: !0,shortSwipes: !0,longSwipesRatio: .5,moveStartThreshold: !1,onlyExternal: !1,createPagination: !0,pagination: !1,paginationElement: "span",paginationClickable: !1,paginationAsRange: !0,resistance: !0,scrollContainer: !1,preventLinks: !0,preventLinksPropagation: !1,noSwiping: !1,noSwipingClass: "swiper-no-swiping",initialSlide: 0,keyboardControl: !1,mousewheelControl: !1,mousewheelControlForceToAxis: !1,useCSS3Transforms: !0,autoplay: !1,autoplayDisableOnInteraction: !0,autoplayStopOnLast: !1,loop: !1,loopAdditionalSlides: 0,roundLengths: !1,calculateHeight: !1,cssWidthAndHeight: !1,updateOnImagesReady: !0,releaseFormElements: !0,watchActiveIndex: !1,visibilityFullFit: !1,offsetPxBefore: 0,offsetPxAfter: 0,offsetSlidesBefore: 0,offsetSlidesAfter: 0,centeredSlides: !1,queueStartCallbacks: !1,queueEndCallbacks: !1,autoResize: !0,resizeReInit: !1,DOMAnimation: !0,loader: {slides: [],slidesHTMLType: "inner",surroundGroups: 1,logic: "reload",loadAllSlides: !1},swipeToPrev: !0,swipeToNext: !0,slideElement: "div",slideClass: "swiper-slide",slideActiveClass: "swiper-slide-active",slideVisibleClass: "swiper-slide-visible",slideDuplicateClass: "swiper-slide-duplicate",wrapperClass: "swiper-wrapper",paginationElementClass: "swiper-pagination-switch",paginationActiveClass: "swiper-active-switch",paginationVisibleClass: "swiper-visible-switch"};
        e = e || {};
        for (var M in D)
            if (M in e && "object" == typeof e[M])
                for (var j in D[M])
                    j in e[M] || (e[M][j] = D[M][j]);
            else
                M in e || (e[M] = D[M]);
        T.params = e, e.scrollContainer && (e.freeMode = !0, e.freeModeFluid = !0), e.loop && (e.resistance = "100%");
        var A = "horizontal" === e.mode, N = ["mousedown", "mousemove", "mouseup"];
        T.browser.ie10 && (N = ["MSPointerDown", "MSPointerMove", "MSPointerUp"]), T.browser.ie11 && (N = ["pointerdown", "pointermove", "pointerup"]), T.touchEvents = {touchStart: T.support.touch || !e.simulateTouch ? "touchstart" : N[0],touchMove: T.support.touch || !e.simulateTouch ? "touchmove" : N[1],touchEnd: T.support.touch || !e.simulateTouch ? "touchend" : N[2]};
        for (var B = T.container.childNodes.length - 1; B >= 0; B--)
            if (T.container.childNodes[B].className)
                for (var F = T.container.childNodes[B].className.split(/\s+/), W = 0; W < F.length; W++)
                    F[W] === e.wrapperClass && (k = T.container.childNodes[B]);
        T.wrapper = k, T._extendSwiperSlide = function(t) {
            return t.append = function() {
                return e.loop ? t.insertAfter(T.slides.length - T.loopedSlides) : (T.wrapper.appendChild(t), T.reInit()), t
            }, t.prepend = function() {
                return e.loop ? (T.wrapper.insertBefore(t, T.slides[T.loopedSlides]), T.removeLoopedSlides(), T.calcSlides(), T.createLoop()) : T.wrapper.insertBefore(t, T.wrapper.firstChild), T.reInit(), t
            }, t.insertAfter = function(i) {
                if ("undefined" == typeof i)
                    return !1;
                var o;
                return e.loop ? (o = T.slides[i + 1 + T.loopedSlides], o ? T.wrapper.insertBefore(t, o) : T.wrapper.appendChild(t), T.removeLoopedSlides(), T.calcSlides(), T.createLoop()) : (o = T.slides[i + 1], T.wrapper.insertBefore(t, o)), T.reInit(), t
            }, t.clone = function() {
                return T._extendSwiperSlide(t.cloneNode(!0))
            }, t.remove = function() {
                T.wrapper.removeChild(t), T.reInit()
            }, t.html = function(e) {
                return "undefined" == typeof e ? t.innerHTML : (t.innerHTML = e, t)
            }, t.index = function() {
                for (var e, i = T.slides.length - 1; i >= 0; i--)
                    t === T.slides[i] && (e = i);
                return e
            }, t.isActive = function() {
                return t.index() === T.activeIndex ? !0 : !1
            }, t.swiperSlideDataStorage || (t.swiperSlideDataStorage = {}), t.getData = function(e) {
                return t.swiperSlideDataStorage[e]
            }, t.setData = function(e, i) {
                return t.swiperSlideDataStorage[e] = i, t
            }, t.data = function(e, i) {
                return "undefined" == typeof i ? t.getAttribute("data-" + e) : (t.setAttribute("data-" + e, i), t)
            }, t.getWidth = function(e, i) {
                return T.h.getWidth(t, e, i)
            }, t.getHeight = function(e, i) {
                return T.h.getHeight(t, e, i)
            }, t.getOffset = function() {
                return T.h.getOffset(t)
            }, t
        }, T.calcSlides = function(t) {
            var i = T.slides ? T.slides.length : !1;
            T.slides = [], T.displaySlides = [];
            for (var o = 0; o < T.wrapper.childNodes.length; o++)
                if (T.wrapper.childNodes[o].className)
                    for (var n = T.wrapper.childNodes[o].className, a = n.split(/\s+/), l = 0; l < a.length; l++)
                        a[l] === e.slideClass && T.slides.push(T.wrapper.childNodes[o]);
            for (o = T.slides.length - 1; o >= 0; o--)
                T._extendSwiperSlide(T.slides[o]);
            i !== !1 && (i !== T.slides.length || t) && (r(), s(), T.updateActiveSlide(), T.params.pagination && T.createPagination(), T.callPlugins("numberOfSlidesChanged"))
        }, T.createSlide = function(t, i, o) {
            i = i || T.params.slideClass, o = o || e.slideElement;
            var n = document.createElement(o);
            return n.innerHTML = t || "", n.className = i, T._extendSwiperSlide(n)
        }, T.appendSlide = function(t, e, i) {
            return t ? t.nodeType ? T._extendSwiperSlide(t).append() : T.createSlide(t, e, i).append() : void 0
        }, T.prependSlide = function(t, e, i) {
            return t ? t.nodeType ? T._extendSwiperSlide(t).prepend() : T.createSlide(t, e, i).prepend() : void 0
        }, T.insertSlideAfter = function(t, e, i, o) {
            return "undefined" == typeof t ? !1 : e.nodeType ? T._extendSwiperSlide(e).insertAfter(t) : T.createSlide(e, i, o).insertAfter(t)
        }, T.removeSlide = function(t) {
            if (T.slides[t]) {
                if (e.loop) {
                    if (!T.slides[t + T.loopedSlides])
                        return !1;
                    T.slides[t + T.loopedSlides].remove(), T.removeLoopedSlides(), T.calcSlides(), T.createLoop()
                } else
                    T.slides[t].remove();
                return !0
            }
            return !1
        }, T.removeLastSlide = function() {
            return T.slides.length > 0 ? (e.loop ? (T.slides[T.slides.length - 1 - T.loopedSlides].remove(), T.removeLoopedSlides(), T.calcSlides(), T.createLoop()) : T.slides[T.slides.length - 1].remove(), !0) : !1
        }, T.removeAllSlides = function() {
            for (var t = T.slides.length - 1; t >= 0; t--)
                T.slides[t].remove()
        }, T.getSlide = function(t) {
            return T.slides[t]
        }, T.getLastSlide = function() {
            return T.slides[T.slides.length - 1]
        }, T.getFirstSlide = function() {
            return T.slides[0]
        }, T.activeSlide = function() {
            return T.slides[T.activeIndex]
        }, T.fireCallback = function() {
            var t = arguments[0];
            if ("[object Array]" === Object.prototype.toString.call(t))
                for (var i = 0; i < t.length; i++)
                    "function" == typeof t[i] && t[i](arguments[1], arguments[2], arguments[3], arguments[4], arguments[5]);
            else
                "[object String]" === Object.prototype.toString.call(t) ? e["on" + t] && T.fireCallback(e["on" + t], arguments[1], arguments[2], arguments[3], arguments[4], arguments[5]) : t(arguments[1], arguments[2], arguments[3], arguments[4], arguments[5])
        }, T.addCallback = function(t, e) {
            var i, n = this;
            return n.params["on" + t] ? o(this.params["on" + t]) ? this.params["on" + t].push(e) : "function" == typeof this.params["on" + t] ? (i = this.params["on" + t], this.params["on" + t] = [], this.params["on" + t].push(i), this.params["on" + t].push(e)) : void 0 : (this.params["on" + t] = [], this.params["on" + t].push(e))
        }, T.removeCallbacks = function(t) {
            T.params["on" + t] && (T.params["on" + t] = null)
        };
        var Y = [];
        for (var O in T.plugins)
            if (e[O]) {
                var z = T.plugins[O](T, e[O]);
                z && Y.push(z)
            }
        T.callPlugins = function(t, e) {
            e || (e = {});
            for (var i = 0; i < Y.length; i++)
                t in Y[i] && Y[i][t](e)
        }, !T.browser.ie10 && !T.browser.ie11 || e.onlyExternal || T.wrapper.classList.add("swiper-wp8-" + (A ? "horizontal" : "vertical")), e.freeMode && (T.container.className += " swiper-free-mode"), T.initialized = !1, T.init = function(t, i) {
            var o = T.h.getWidth(T.container, !1, e.roundLengths), n = T.h.getHeight(T.container, !1, e.roundLengths);
            if (o !== T.width || n !== T.height || t) {
                T.width = o, T.height = n;
                var a, s, r, l, c, d, u;
                P = A ? o : n;
                var h = T.wrapper;
                if (t && T.calcSlides(i), "auto" === e.slidesPerView) {
                    var p = 0, f = 0;
                    e.slidesOffset > 0 && (h.style.paddingLeft = "", h.style.paddingRight = "", h.style.paddingTop = "", h.style.paddingBottom = ""), h.style.width = "", h.style.height = "", e.offsetPxBefore > 0 && (A ? T.wrapperLeft = e.offsetPxBefore : T.wrapperTop = e.offsetPxBefore), e.offsetPxAfter > 0 && (A ? T.wrapperRight = e.offsetPxAfter : T.wrapperBottom = e.offsetPxAfter), e.centeredSlides && (A ? (T.wrapperLeft = (P - this.slides[0].getWidth(!0, e.roundLengths)) / 2, T.wrapperRight = (P - T.slides[T.slides.length - 1].getWidth(!0, e.roundLengths)) / 2) : (T.wrapperTop = (P - T.slides[0].getHeight(!0, e.roundLengths)) / 2, T.wrapperBottom = (P - T.slides[T.slides.length - 1].getHeight(!0, e.roundLengths)) / 2)), A ? (T.wrapperLeft >= 0 && (h.style.paddingLeft = T.wrapperLeft + "px"), T.wrapperRight >= 0 && (h.style.paddingRight = T.wrapperRight + "px")) : (T.wrapperTop >= 0 && (h.style.paddingTop = T.wrapperTop + "px"), T.wrapperBottom >= 0 && (h.style.paddingBottom = T.wrapperBottom + "px")), d = 0;
                    var g = 0;
                    for (T.snapGrid = [], T.slidesGrid = [], r = 0, u = 0; u < T.slides.length; u++) {
                        a = T.slides[u].getWidth(!0, e.roundLengths), s = T.slides[u].getHeight(!0, e.roundLengths), e.calculateHeight && (r = Math.max(r, s));
                        var m = A ? a : s;
                        if (e.centeredSlides) {
                            var v = u === T.slides.length - 1 ? 0 : T.slides[u + 1].getWidth(!0, e.roundLengths), $ = u === T.slides.length - 1 ? 0 : T.slides[u + 1].getHeight(!0, e.roundLengths), w = A ? v : $;
                            if (m > P) {
                                if (e.slidesPerViewFit)
                                    T.snapGrid.push(d + T.wrapperLeft), T.snapGrid.push(d + m - P + T.wrapperLeft);
                                else
                                    for (var S = 0; S <= Math.floor(m / (P + T.wrapperLeft)); S++)
                                        T.snapGrid.push(0 === S ? d + T.wrapperLeft : d + T.wrapperLeft + P * S);
                                T.slidesGrid.push(d + T.wrapperLeft)
                            } else
                                T.snapGrid.push(g), T.slidesGrid.push(g);
                            g += m / 2 + w / 2
                        } else {
                            if (m > P)
                                if (e.slidesPerViewFit)
                                    T.snapGrid.push(d), T.snapGrid.push(d + m - P);
                                else if (0 !== P)
                                    for (var _ = 0; _ <= Math.floor(m / P); _++)
                                        T.snapGrid.push(d + P * _);
                                else
                                    T.snapGrid.push(d);
                            else
                                T.snapGrid.push(d);
                            T.slidesGrid.push(d)
                        }
                        d += m, p += a, f += s
                    }
                    e.calculateHeight && (T.height = r), A ? (E = p + T.wrapperRight + T.wrapperLeft, h.style.width = p + "px", h.style.height = T.height + "px") : (E = f + T.wrapperTop + T.wrapperBottom, h.style.width = T.width + "px", h.style.height = f + "px")
                } else if (e.scrollContainer)
                    h.style.width = "", h.style.height = "", l = T.slides[0].getWidth(!0, e.roundLengths), c = T.slides[0].getHeight(!0, e.roundLengths), E = A ? l : c, h.style.width = l + "px", h.style.height = c + "px", G = A ? l : c;
                else {
                    if (e.calculateHeight) {
                        for (r = 0, c = 0, A || (T.container.style.height = ""), h.style.height = "", u = 0; u < T.slides.length; u++)
                            T.slides[u].style.height = "", r = Math.max(T.slides[u].getHeight(!0), r), A || (c += T.slides[u].getHeight(!0));
                        s = r, T.height = s, A ? c = s : (P = s, T.container.style.height = P + "px")
                    } else
                        s = A ? T.height : T.height / e.slidesPerView, e.roundLengths && (s = Math.ceil(s)), c = A ? T.height : T.slides.length * s;
                    for (a = A ? T.width / e.slidesPerView : T.width, e.roundLengths && (a = Math.ceil(a)), l = A ? T.slides.length * a : T.width, G = A ? a : s, e.offsetSlidesBefore > 0 && (A ? T.wrapperLeft = G * e.offsetSlidesBefore : T.wrapperTop = G * e.offsetSlidesBefore), e.offsetSlidesAfter > 0 && (A ? T.wrapperRight = G * e.offsetSlidesAfter : T.wrapperBottom = G * e.offsetSlidesAfter), e.offsetPxBefore > 0 && (A ? T.wrapperLeft = e.offsetPxBefore : T.wrapperTop = e.offsetPxBefore), e.offsetPxAfter > 0 && (A ? T.wrapperRight = e.offsetPxAfter : T.wrapperBottom = e.offsetPxAfter), e.centeredSlides && (A ? (T.wrapperLeft = (P - G) / 2, T.wrapperRight = (P - G) / 2) : (T.wrapperTop = (P - G) / 2, T.wrapperBottom = (P - G) / 2)), A ? (T.wrapperLeft > 0 && (h.style.paddingLeft = T.wrapperLeft + "px"), T.wrapperRight > 0 && (h.style.paddingRight = T.wrapperRight + "px")) : (T.wrapperTop > 0 && (h.style.paddingTop = T.wrapperTop + "px"), T.wrapperBottom > 0 && (h.style.paddingBottom = T.wrapperBottom + "px")), E = A ? l + T.wrapperRight + T.wrapperLeft : c + T.wrapperTop + T.wrapperBottom, parseFloat(l) > 0 && (!e.cssWidthAndHeight || "height" === e.cssWidthAndHeight) && (h.style.width = l + "px"), parseFloat(c) > 0 && (!e.cssWidthAndHeight || "width" === e.cssWidthAndHeight) && (h.style.height = c + "px"), d = 0, T.snapGrid = [], T.slidesGrid = [], u = 0; u < T.slides.length; u++)
                        T.snapGrid.push(d), T.slidesGrid.push(d), d += G, parseFloat(a) > 0 && (!e.cssWidthAndHeight || "height" === e.cssWidthAndHeight) && (T.slides[u].style.width = a + "px"), parseFloat(s) > 0 && (!e.cssWidthAndHeight || "width" === e.cssWidthAndHeight) && (T.slides[u].style.height = s + "px")
                }
                T.initialized ? (T.callPlugins("onInit"), e.onInit && T.fireCallback(e.onInit, T)) : (T.callPlugins("onFirstInit"), e.onFirstInit && T.fireCallback(e.onFirstInit, T)), T.initialized = !0
            }
        }, T.reInit = function(t) {
            T.init(!0, t)
        }, T.resizeFix = function(t) {
            T.callPlugins("beforeResizeFix"), T.init(e.resizeReInit || t), e.freeMode ? T.getWrapperTranslate() < -n() && (T.setWrapperTransition(0), T.setWrapperTranslate(-n())) : (T.swipeTo(e.loop ? T.activeLoopIndex : T.activeIndex, 0, !1), e.autoplay && (T.support.transitions && "undefined" != typeof Z ? "undefined" != typeof Z && (clearTimeout(Z), Z = void 0, T.startAutoplay()) : "undefined" != typeof te && (clearInterval(te), te = void 0, T.startAutoplay()))), T.callPlugins("afterResizeFix")
        }, T.destroy = function() {
            var t = T.h.removeEventListener, i = "wrapper" === e.eventTarget ? T.wrapper : T.container;
            T.browser.ie10 || T.browser.ie11 ? (t(i, T.touchEvents.touchStart, g), t(document, T.touchEvents.touchMove, m), t(document, T.touchEvents.touchEnd, v)) : (T.support.touch && (t(i, "touchstart", g), t(i, "touchmove", m), t(i, "touchend", v)), e.simulateTouch && (t(i, "mousedown", g), t(document, "mousemove", m), t(document, "mouseup", v))), e.autoResize && t(window, "resize", T.resizeFix), r(), e.paginationClickable && y(), e.mousewheelControl && T._wheelEvent && t(T.container, T._wheelEvent, c), e.keyboardControl && t(document, "keydown", l), e.autoplay && T.stopAutoplay(), T.callPlugins("onDestroy"), T = null
        }, T.disableKeyboardControl = function() {
            e.keyboardControl = !1, T.h.removeEventListener(document, "keydown", l)
        }, T.enableKeyboardControl = function() {
            e.keyboardControl = !0, T.h.addEventListener(document, "keydown", l)
        };
        var R = (new Date).getTime();
        if (T.disableMousewheelControl = function() {
                return T._wheelEvent ? (e.mousewheelControl = !1, T.h.removeEventListener(T.container, T._wheelEvent, c), !0) : !1
            }, T.enableMousewheelControl = function() {
                return T._wheelEvent ? (e.mousewheelControl = !0, T.h.addEventListener(T.container, T._wheelEvent, c), !0) : !1
            }, e.grabCursor) {
            var U = T.container.style;
            U.cursor = "move", U.cursor = "grab", U.cursor = "-moz-grab", U.cursor = "-webkit-grab"
        }
        T.allowSlideClick = !0, T.allowLinks = !0;
        var X, q, V, K = !1, Q = !0;
        T.swipeNext = function(t) {
            !t && e.loop && T.fixLoop(), !t && e.autoplay && T.stopAutoplay(!0), T.callPlugins("onSwipeNext");
            var i = T.getWrapperTranslate(), o = i;
            if ("auto" === e.slidesPerView) {
                for (var a = 0; a < T.snapGrid.length; a++)
                    if (-i >= T.snapGrid[a] && -i < T.snapGrid[a + 1]) {
                        o = -T.snapGrid[a + 1];
                        break
                    }
            } else {
                var s = G * e.slidesPerGroup;
                o = -(Math.floor(Math.abs(i) / Math.floor(s)) * s + s)
            }
            return o < -n() && (o = -n()), o === i ? !1 : (S(o, "next"), !0)
        }, T.swipePrev = function(t) {
            !t && e.loop && T.fixLoop(), !t && e.autoplay && T.stopAutoplay(!0), T.callPlugins("onSwipePrev");
            var i, o = Math.ceil(T.getWrapperTranslate());
            if ("auto" === e.slidesPerView) {
                i = 0;
                for (var n = 1; n < T.snapGrid.length; n++) {
                    if (-o === T.snapGrid[n]) {
                        i = -T.snapGrid[n - 1];
                        break
                    }
                    if (-o > T.snapGrid[n] && -o < T.snapGrid[n + 1]) {
                        i = -T.snapGrid[n];
                        break
                    }
                }
            } else {
                var a = G * e.slidesPerGroup;
                i = -(Math.ceil(-o / a) - 1) * a
            }
            return i > 0 && (i = 0), i === o ? !1 : (S(i, "prev"), !0)
        }, T.swipeReset = function() {
            T.callPlugins("onSwipeReset");
            {
                var t, i = T.getWrapperTranslate(), o = G * e.slidesPerGroup;
                -n()
            }
            if ("auto" === e.slidesPerView) {
                t = 0;
                for (var a = 0; a < T.snapGrid.length; a++) {
                    if (-i === T.snapGrid[a])
                        return;
                    if (-i >= T.snapGrid[a] && -i < T.snapGrid[a + 1]) {
                        t = T.positions.diff > 0 ? -T.snapGrid[a + 1] : -T.snapGrid[a];
                        break
                    }
                }
                -i >= T.snapGrid[T.snapGrid.length - 1] && (t = -T.snapGrid[T.snapGrid.length - 1]), i <= -n() && (t = -n())
            } else
                t = 0 > i ? Math.round(i / o) * o : 0, i <= -n() && (t = -n());
            return e.scrollContainer && (t = 0 > i ? i : 0), t < -n() && (t = -n()), e.scrollContainer && P > G && (t = 0), t === i ? !1 : (S(t, "reset"), !0)
        }, T.swipeTo = function(t, i, o) {
            t = parseInt(t, 10), T.callPlugins("onSwipeTo", {index: t,speed: i}), e.loop && (t += T.loopedSlides);
            var a = T.getWrapperTranslate();
            if (!(t > T.slides.length - 1 || 0 > t)) {
                var s;
                return s = "auto" === e.slidesPerView ? -T.slidesGrid[t] : -t * G, s < -n() && (s = -n()), s === a ? !1 : (o = o === !1 ? !1 : !0, S(s, "to", {index: t,speed: i,runCallbacks: o}), !0)
            }
        }, T._queueStartCallbacks = !1, T._queueEndCallbacks = !1, T.updateActiveSlide = function(t) {
            if (T.initialized && 0 !== T.slides.length) {
                T.previousIndex = T.activeIndex, "undefined" == typeof t && (t = T.getWrapperTranslate()), t > 0 && (t = 0);
                var i;
                if ("auto" === e.slidesPerView) {
                    if (T.activeIndex = T.slidesGrid.indexOf(-t), T.activeIndex < 0) {
                        for (i = 0; i < T.slidesGrid.length - 1 && !(-t > T.slidesGrid[i] && -t < T.slidesGrid[i + 1]); i++)
                            ;
                        var o = Math.abs(T.slidesGrid[i] + t), n = Math.abs(T.slidesGrid[i + 1] + t);
                        T.activeIndex = n >= o ? i : i + 1
                    }
                } else
                    T.activeIndex = Math[e.visibilityFullFit ? "ceil" : "round"](-t / G);
                if (T.activeIndex === T.slides.length && (T.activeIndex = T.slides.length - 1), T.activeIndex < 0 && (T.activeIndex = 0), T.slides[T.activeIndex]) {
                    if (T.calcVisibleSlides(t), T.support.classList) {
                        var a;
                        for (i = 0; i < T.slides.length; i++)
                            a = T.slides[i], a.classList.remove(e.slideActiveClass), T.visibleSlides.indexOf(a) >= 0 ? a.classList.add(e.slideVisibleClass) : a.classList.remove(e.slideVisibleClass);
                        T.slides[T.activeIndex].classList.add(e.slideActiveClass)
                    } else {
                        var s = new RegExp("\\s*" + e.slideActiveClass), r = new RegExp("\\s*" + e.slideVisibleClass);
                        for (i = 0; i < T.slides.length; i++)
                            T.slides[i].className = T.slides[i].className.replace(s, "").replace(r, ""), T.visibleSlides.indexOf(T.slides[i]) >= 0 && (T.slides[i].className += " " + e.slideVisibleClass);
                        T.slides[T.activeIndex].className += " " + e.slideActiveClass
                    }
                    if (e.loop) {
                        var l = T.loopedSlides;
                        T.activeLoopIndex = T.activeIndex - l, T.activeLoopIndex >= T.slides.length - 2 * l && (T.activeLoopIndex = T.slides.length - 2 * l - T.activeLoopIndex), T.activeLoopIndex < 0 && (T.activeLoopIndex = T.slides.length - 2 * l + T.activeLoopIndex), T.activeLoopIndex < 0 && (T.activeLoopIndex = 0)
                    } else
                        T.activeLoopIndex = T.activeIndex;
                    e.pagination && T.updatePagination(t)
                }
            }
        }, T.createPagination = function(t) {
            if (e.paginationClickable && T.paginationButtons && y(), T.paginationContainer = e.pagination.nodeType ? e.pagination : i(e.pagination)[0], e.createPagination) {
                var o = "", n = T.slides.length, a = n;
                e.loop && (a -= 2 * T.loopedSlides);
                for (var s = 0; a > s; s++)
                    o += "<" + e.paginationElement + ' class="' + e.paginationElementClass + '"></' + e.paginationElement + ">";
                T.paginationContainer.innerHTML = o
            }
            T.paginationButtons = i("." + e.paginationElementClass, T.paginationContainer), t || T.updatePagination(), T.callPlugins("onCreatePagination"), e.paginationClickable && b()
        }, T.updatePagination = function(t) {
            if (e.pagination && !(T.slides.length < 1)) {
                var o = i("." + e.paginationActiveClass, T.paginationContainer);
                if (o) {
                    var n = T.paginationButtons;
                    if (0 !== n.length) {
                        for (var a = 0; a < n.length; a++)
                            n[a].className = e.paginationElementClass;
                        var s = e.loop ? T.loopedSlides : 0;
                        if (e.paginationAsRange) {
                            T.visibleSlides || T.calcVisibleSlides(t);
                            var r, l = [];
                            for (r = 0; r < T.visibleSlides.length; r++) {
                                var c = T.slides.indexOf(T.visibleSlides[r]) - s;
                                e.loop && 0 > c && (c = T.slides.length - 2 * T.loopedSlides + c), e.loop && c >= T.slides.length - 2 * T.loopedSlides && (c = T.slides.length - 2 * T.loopedSlides - c, c = Math.abs(c)), l.push(c)
                            }
                            for (r = 0; r < l.length; r++)
                                n[l[r]] && (n[l[r]].className += " " + e.paginationVisibleClass);
                            e.loop ? void 0 !== n[T.activeLoopIndex] && (n[T.activeLoopIndex].className += " " + e.paginationActiveClass) : n[T.activeIndex].className += " " + e.paginationActiveClass
                        } else
                            e.loop ? n[T.activeLoopIndex] && (n[T.activeLoopIndex].className += " " + e.paginationActiveClass + " " + e.paginationVisibleClass) : n[T.activeIndex].className += " " + e.paginationActiveClass + " " + e.paginationVisibleClass
                    }
                }
            }
        }, T.calcVisibleSlides = function(t) {
            var i = [], o = 0, n = 0, a = 0;
            A && T.wrapperLeft > 0 && (t += T.wrapperLeft), !A && T.wrapperTop > 0 && (t += T.wrapperTop);
            for (var s = 0; s < T.slides.length; s++) {
                o += n, n = "auto" === e.slidesPerView ? A ? T.h.getWidth(T.slides[s], !0, e.roundLengths) : T.h.getHeight(T.slides[s], !0, e.roundLengths) : G, a = o + n;
                var r = !1;
                e.visibilityFullFit ? (o >= -t && -t + P >= a && (r = !0), -t >= o && a >= -t + P && (r = !0)) : (a > -t && -t + P >= a && (r = !0), o >= -t && -t + P > o && (r = !0), -t > o && a > -t + P && (r = !0)), r && i.push(T.slides[s])
            }
            0 === i.length && (i = [T.slides[T.activeIndex]]), T.visibleSlides = i
        };
        var Z, te;
        T.startAutoplay = function() {
            if (T.support.transitions) {
                if ("undefined" != typeof Z)
                    return !1;
                if (!e.autoplay)
                    return;
                T.callPlugins("onAutoplayStart"), e.onAutoplayStart && T.fireCallback(e.onAutoplayStart, T), C()
            } else {
                if ("undefined" != typeof te)
                    return !1;
                if (!e.autoplay)
                    return;
                T.callPlugins("onAutoplayStart"), e.onAutoplayStart && T.fireCallback(e.onAutoplayStart, T), te = setInterval(function() {
                    e.loop ? (T.fixLoop(), T.swipeNext(!0)) : T.swipeNext(!0) || (e.autoplayStopOnLast ? (clearInterval(te), te = void 0) : T.swipeTo(0))
                }, e.autoplay)
            }
        }, T.stopAutoplay = function(t) {
            if (T.support.transitions) {
                if (!Z)
                    return;
                Z && clearTimeout(Z), Z = void 0, t && !e.autoplayDisableOnInteraction && T.wrapperTransitionEnd(function() {
                    C()
                }), T.callPlugins("onAutoplayStop"), e.onAutoplayStop && T.fireCallback(e.onAutoplayStop, T)
            } else
                te && clearInterval(te), te = void 0, T.callPlugins("onAutoplayStop"), e.onAutoplayStop && T.fireCallback(e.onAutoplayStop, T)
        }, T.loopCreated = !1, T.removeLoopedSlides = function() {
            if (T.loopCreated)
                for (var t = 0; t < T.slides.length; t++)
                    T.slides[t].getData("looped") === !0 && T.wrapper.removeChild(T.slides[t])
        }, T.createLoop = function() {
            if (0 !== T.slides.length) {
                T.loopedSlides = "auto" === e.slidesPerView ? e.loopedSlides || 1 : e.slidesPerView + e.loopAdditionalSlides, T.loopedSlides > T.slides.length && (T.loopedSlides = T.slides.length);
                var t, i = "", o = "", n = "", a = T.slides.length, s = Math.floor(T.loopedSlides / a), r = T.loopedSlides % a;
                for (t = 0; s * a > t; t++) {
                    var l = t;
                    if (t >= a) {
                        var c = Math.floor(t / a);
                        l = t - a * c
                    }
                    n += T.slides[l].outerHTML
                }
                for (t = 0; r > t; t++)
                    o += w(e.slideDuplicateClass, T.slides[t].outerHTML);
                for (t = a - r; a > t; t++)
                    i += w(e.slideDuplicateClass, T.slides[t].outerHTML);
                var d = i + n + k.innerHTML + n + o;
                for (k.innerHTML = d, T.loopCreated = !0, T.calcSlides(), t = 0; t < T.slides.length; t++)
                    (t < T.loopedSlides || t >= T.slides.length - T.loopedSlides) && T.slides[t].setData("looped", !0);
                T.callPlugins("onCreateLoop")
            }
        }, T.fixLoop = function() {
            var t;
            T.activeIndex < T.loopedSlides ? (t = T.slides.length - 3 * T.loopedSlides + T.activeIndex, T.swipeTo(t, 0, !1)) : ("auto" === e.slidesPerView && T.activeIndex >= 2 * T.loopedSlides || T.activeIndex > T.slides.length - 2 * e.slidesPerView) && (t = -T.slides.length + T.activeIndex + T.loopedSlides, T.swipeTo(t, 0, !1))
        }, T.loadSlides = function() {
            var t = "";
            T.activeLoaderIndex = 0;
            for (var i = e.loader.slides, o = e.loader.loadAllSlides ? i.length : e.slidesPerView * (1 + e.loader.surroundGroups), n = 0; o > n; n++)
                t += "outer" === e.loader.slidesHTMLType ? i[n] : "<" + e.slideElement + ' class="' + e.slideClass + '" data-swiperindex="' + n + '">' + i[n] + "</" + e.slideElement + ">";
            T.wrapper.innerHTML = t, T.calcSlides(!0), e.loader.loadAllSlides || T.wrapperTransitionEnd(T.reloadSlides, !0)
        }, T.reloadSlides = function() {
            var t = e.loader.slides, i = parseInt(T.activeSlide().data("swiperindex"), 10);
            if (!(0 > i || i > t.length - 1)) {
                T.activeLoaderIndex = i;
                var o = Math.max(0, i - e.slidesPerView * e.loader.surroundGroups), n = Math.min(i + e.slidesPerView * (1 + e.loader.surroundGroups) - 1, t.length - 1);
                if (i > 0) {
                    var a = -G * (i - o);
                    T.setWrapperTranslate(a), T.setWrapperTransition(0)
                }
                var s;
                if ("reload" === e.loader.logic) {
                    T.wrapper.innerHTML = "";
                    var r = "";
                    for (s = o; n >= s; s++)
                        r += "outer" === e.loader.slidesHTMLType ? t[s] : "<" + e.slideElement + ' class="' + e.slideClass + '" data-swiperindex="' + s + '">' + t[s] + "</" + e.slideElement + ">";
                    T.wrapper.innerHTML = r
                } else {
                    var l = 1e3, c = 0;
                    for (s = 0; s < T.slides.length; s++) {
                        var d = T.slides[s].data("swiperindex");
                        o > d || d > n ? T.wrapper.removeChild(T.slides[s]) : (l = Math.min(d, l), c = Math.max(d, c))
                    }
                    for (s = o; n >= s; s++) {
                        var u;
                        l > s && (u = document.createElement(e.slideElement), u.className = e.slideClass, u.setAttribute("data-swiperindex", s), u.innerHTML = t[s], T.wrapper.insertBefore(u, T.wrapper.firstChild)), s > c && (u = document.createElement(e.slideElement), u.className = e.slideClass, u.setAttribute("data-swiperindex", s), u.innerHTML = t[s], T.wrapper.appendChild(u))
                    }
                }
                T.reInit(!0)
            }
        }, J()
    }
};
Swiper.prototype = {plugins: {},wrapperTransitionEnd: function(t, e) {
    "use strict";
    function i(r) {
        if (r.target === a && (t(n), n.params.queueEndCallbacks && (n._queueEndCallbacks = !1), !e))
            for (o = 0; o < s.length; o++)
                n.h.removeEventListener(a, s[o], i)
    }
    var o, n = this, a = n.wrapper, s = ["webkitTransitionEnd", "transitionend", "oTransitionEnd", "MSTransitionEnd", "msTransitionEnd"];
    if (t)
        for (o = 0; o < s.length; o++)
            n.h.addEventListener(a, s[o], i)
},getWrapperTranslate: function(t) {
    "use strict";
    var e, i, o, n, a = this.wrapper;
    return "undefined" == typeof t && (t = "horizontal" === this.params.mode ? "x" : "y"), this.support.transforms && this.params.useCSS3Transforms ? (o = window.getComputedStyle(a, null), window.WebKitCSSMatrix ? n = new WebKitCSSMatrix("none" === o.webkitTransform ? "" : o.webkitTransform) : (n = o.MozTransform || o.OTransform || o.MsTransform || o.msTransform || o.transform || o.getPropertyValue("transform").replace("translate(", "matrix(1, 0, 0, 1,"), e = n.toString().split(",")), "x" === t && (i = window.WebKitCSSMatrix ? n.m41 : parseFloat(16 === e.length ? e[12] : e[4])), "y" === t && (i = window.WebKitCSSMatrix ? n.m42 : parseFloat(16 === e.length ? e[13] : e[5]))) : ("x" === t && (i = parseFloat(a.style.left, 10) || 0), "y" === t && (i = parseFloat(a.style.top, 10) || 0)), i || 0
},setWrapperTranslate: function(t, e, i) {
    "use strict";
    var o, n = this.wrapper.style, a = {x: 0,y: 0,z: 0};
    3 === arguments.length ? (a.x = t, a.y = e, a.z = i) : ("undefined" == typeof e && (e = "horizontal" === this.params.mode ? "x" : "y"), a[e] = t), this.support.transforms && this.params.useCSS3Transforms ? (o = this.support.transforms3d ? "translate3d(" + a.x + "px, " + a.y + "px, " + a.z + "px)" : "translate(" + a.x + "px, " + a.y + "px)", n.webkitTransform = n.MsTransform = n.msTransform = n.MozTransform = n.OTransform = n.transform = o) : (n.left = a.x + "px", n.top = a.y + "px"), this.callPlugins("onSetWrapperTransform", a), this.params.onSetWrapperTransform && this.fireCallback(this.params.onSetWrapperTransform, this, a)
},setWrapperTransition: function(t) {
    "use strict";
    var e = this.wrapper.style;
    e.webkitTransitionDuration = e.MsTransitionDuration = e.msTransitionDuration = e.MozTransitionDuration = e.OTransitionDuration = e.transitionDuration = t / 1e3 + "s", this.callPlugins("onSetWrapperTransition", {duration: t}), this.params.onSetWrapperTransition && this.fireCallback(this.params.onSetWrapperTransition, this, t)
},h: {getWidth: function(t, e, i) {
    "use strict";
    var o = window.getComputedStyle(t, null).getPropertyValue("width"), n = parseFloat(o);
    return (isNaN(n) || o.indexOf("%") > 0 || 0 > n) && (n = t.offsetWidth - parseFloat(window.getComputedStyle(t, null).getPropertyValue("padding-left")) - parseFloat(window.getComputedStyle(t, null).getPropertyValue("padding-right"))), e && (n += parseFloat(window.getComputedStyle(t, null).getPropertyValue("padding-left")) + parseFloat(window.getComputedStyle(t, null).getPropertyValue("padding-right"))), i ? Math.ceil(n) : n
},getHeight: function(t, e, i) {
    "use strict";
    if (e)
        return t.offsetHeight;
    var o = window.getComputedStyle(t, null).getPropertyValue("height"), n = parseFloat(o);
    return (isNaN(n) || o.indexOf("%") > 0 || 0 > n) && (n = t.offsetHeight - parseFloat(window.getComputedStyle(t, null).getPropertyValue("padding-top")) - parseFloat(window.getComputedStyle(t, null).getPropertyValue("padding-bottom"))), e && (n += parseFloat(window.getComputedStyle(t, null).getPropertyValue("padding-top")) + parseFloat(window.getComputedStyle(t, null).getPropertyValue("padding-bottom"))), i ? Math.ceil(n) : n
},getOffset: function(t) {
    "use strict";
    var e = t.getBoundingClientRect(), i = document.body, o = t.clientTop || i.clientTop || 0, n = t.clientLeft || i.clientLeft || 0, a = window.pageYOffset || t.scrollTop, s = window.pageXOffset || t.scrollLeft;
    return document.documentElement && !window.pageYOffset && (a = document.documentElement.scrollTop, s = document.documentElement.scrollLeft), {top: e.top + a - o,left: e.left + s - n}
},windowWidth: function() {
    "use strict";
    return window.innerWidth ? window.innerWidth : document.documentElement && document.documentElement.clientWidth ? document.documentElement.clientWidth : void 0
},windowHeight: function() {
    "use strict";
    return window.innerHeight ? window.innerHeight : document.documentElement && document.documentElement.clientHeight ? document.documentElement.clientHeight : void 0
},windowScroll: function() {
    "use strict";
    return "undefined" != typeof pageYOffset ? {left: window.pageXOffset,top: window.pageYOffset} : document.documentElement ? {left: document.documentElement.scrollLeft,top: document.documentElement.scrollTop} : void 0
},addEventListener: function(t, e, i, o) {
    "use strict";
    "undefined" == typeof o && (o = !1), t.addEventListener ? t.addEventListener(e, i, o) : t.attachEvent && t.attachEvent("on" + e, i)
},removeEventListener: function(t, e, i, o) {
    "use strict";
    "undefined" == typeof o && (o = !1), t.removeEventListener ? t.removeEventListener(e, i, o) : t.detachEvent && t.detachEvent("on" + e, i)
}},setTransform: function(t, e) {
    "use strict";
    var i = t.style;
    i.webkitTransform = i.MsTransform = i.msTransform = i.MozTransform = i.OTransform = i.transform = e
},setTranslate: function(t, e) {
    "use strict";
    var i = t.style, o = {x: e.x || 0,y: e.y || 0,z: e.z || 0}, n = this.support.transforms3d ? "translate3d(" + o.x + "px," + o.y + "px," + o.z + "px)" : "translate(" + o.x + "px," + o.y + "px)";
    i.webkitTransform = i.MsTransform = i.msTransform = i.MozTransform = i.OTransform = i.transform = n, this.support.transforms || (i.left = o.x + "px", i.top = o.y + "px")
},setTransition: function(t, e) {
    "use strict";
    var i = t.style;
    i.webkitTransitionDuration = i.MsTransitionDuration = i.msTransitionDuration = i.MozTransitionDuration = i.OTransitionDuration = i.transitionDuration = e + "ms"
},support: {touch: window.Modernizr && Modernizr.touch === !0 || function() {
    "use strict";
    return !!("ontouchstart" in window || window.DocumentTouch && document instanceof DocumentTouch)
}(),transforms3d: window.Modernizr && Modernizr.csstransforms3d === !0 || function() {
    "use strict";
    var t = document.createElement("div").style;
    return "webkitPerspective" in t || "MozPerspective" in t || "OPerspective" in t || "MsPerspective" in t || "perspective" in t
}(),transforms: window.Modernizr && Modernizr.csstransforms === !0 || function() {
    "use strict";
    var t = document.createElement("div").style;
    return "transform" in t || "WebkitTransform" in t || "MozTransform" in t || "msTransform" in t || "MsTransform" in t || "OTransform" in t
}(),transitions: window.Modernizr && Modernizr.csstransitions === !0 || function() {
    "use strict";
    var t = document.createElement("div").style;
    return "transition" in t || "WebkitTransition" in t || "MozTransition" in t || "msTransition" in t || "MsTransition" in t || "OTransition" in t
}(),classList: function() {
    "use strict";
    var t = document.createElement("div");
    return "classList" in t
}()},browser: {ie8: function() {
    "use strict";
    var t = -1;
    if ("Microsoft Internet Explorer" === navigator.appName) {
        var e = navigator.userAgent, i = new RegExp(/MSIE ([0-9]{1,}[\.0-9]{0,})/);
        null !== i.exec(e) && (t = parseFloat(RegExp.$1))
    }
    return -1 !== t && 9 > t
}(),ie10: window.navigator.msPointerEnabled,ie11: window.navigator.pointerEnabled}}, (window.jQuery || window.Zepto) && !function(t) {
    "use strict";
    t.fn.swiper = function(e) {
        var i;
        return this.each(function(o) {
            var n = t(this);
            if (!n.data("swiper")) {
                var a = new Swiper(n[0], e);
                o || (i = a), n.data("swiper", a)
            }
        }), i
    }
}(window.jQuery || window.Zepto), "undefined" != typeof module && (module.exports = Swiper), "function" == typeof define && define.amd && define([], function() {
    "use strict";
    return Swiper
}), Swiper.prototype.plugins.progress = function(t) {
    function e() {
        for (var e = 0; e < t.slides.length; e++) {
            var i = t.slides[e];
            i.progressSlideSize = n ? t.h.getWidth(i) : t.h.getHeight(i), i.progressSlideOffset = "offsetLeft" in i ? n ? i.offsetLeft : i.offsetTop : n ? i.getOffset().left - t.h.getOffset(t.container).left : i.getOffset().top - t.h.getOffset(t.container).top
        }
        o = n ? t.h.getWidth(t.wrapper) + t.wrapperLeft + t.wrapperRight - t.width : t.h.getHeight(t.wrapper) + t.wrapperTop + t.wrapperBottom - t.height
    }
    function i(e) {
        e = e || {x: 0,y: 0,z: 0};
        var i;
        i = t.params.centeredSlides === !0 ? n ? -e.x + t.width / 2 : -e.y + t.height / 2 : n ? -e.x : -e.y;
        for (var a = 0; a < t.slides.length; a++) {
            var s = t.slides[a], r = t.params.centeredSlides === !0 ? s.progressSlideSize / 2 : 0, l = (i - s.progressSlideOffset - r) / s.progressSlideSize;
            s.progress = l
        }
        t.progress = n ? -e.x / o : -e.y / o, t.params.onProgressChange && t.fireCallback(t.params.onProgressChange, t)
    }
    var o, n = "horizontal" === t.params.mode, a = {onFirstInit: function() {
        e(), i({x: t.getWrapperTranslate("x"),y: t.getWrapperTranslate("y")})
    },onInit: function() {
        e()
    },onSetWrapperTransform: function(t) {
        i(t)
    }};
    return a
};
var SpinningWheel = {cellHeight: 44,friction: .003,slotData: [],handleEvent: function(t) {
    "touchstart" == t.type ? (this.lockScreen(t), "sw-cancel" == t.currentTarget.id || "sw-done" == t.currentTarget.id ? this.tapDown(t) : "sw-frame" == t.currentTarget.id && this.scrollStart(t)) : "touchmove" == t.type ? (this.lockScreen(t), "sw-cancel" == t.currentTarget.id || "sw-done" == t.currentTarget.id || "sw-frame" == t.currentTarget.id && this.scrollMove(t)) : "touchend" == t.type ? "sw-cancel" == t.currentTarget.id || "sw-done" == t.currentTarget.id ? this.tapUp(t) : "sw-frame" == t.currentTarget.id && this.scrollEnd(t) : "webkitTransitionEnd" == t.type ? "sw-wrapper" == t.target.id ? this.destroy() : this.backWithinBoundaries(t) : "orientationchange" == t.type ? this.onOrientationChange(t) : "scroll" == t.type && this.onScroll(t)
},onOrientationChange: function() {
    window.scrollTo(0, 0), this.swWrapper.style.top = window.innerHeight + window.pageYOffset + "px", this.calculateSlotsWidth()
},onScroll: function() {
    this.swWrapper.style.top = window.innerHeight + window.pageYOffset + "px"
},lockScreen: function(t) {
    t.preventDefault(), t.stopPropagation()
},reset: function() {
    this.slotEl = [], this.activeSlot = null, this.swWrapper = void 0, this.swSlotWrapper = void 0, this.swSlots = void 0, this.swFrame = void 0
},calculateSlotsWidth: function() {
    for (var t = this.swSlots.getElementsByTagName("div"), e = 0; e < t.length; e += 1)
        this.slotEl[e].slotWidth = t[e].offsetWidth
},create: function() {
    var t, e, i, o, n;
    for (this.reset(), n = document.createElement("div"), n.id = "sw-wrapper", n.style.top = window.innerHeight + window.pageYOffset + "px", n.style.webkitTransitionProperty = "-webkit-transform", n.innerHTML = '<div id="sw-header"><div id="sw-cancel">取消</div><div id="sw-done">确定</div></div><div id="sw-slots-wrapper"><div id="sw-slots"></div></div><div id="sw-frame"></div>', document.body.appendChild(n), this.swWrapper = n, this.swSlotWrapper = document.getElementById("sw-slots-wrapper"), this.swSlots = document.getElementById("sw-slots"), this.swFrame = document.getElementById("sw-frame"), e = 0; e < this.slotData.length; e += 1) {
        o = document.createElement("ul"), i = "";
        for (t in this.slotData[e].values)
            i += "<li>" + this.slotData[e].values[t] + "</li>";
        o.innerHTML = i, n = document.createElement("div"), n.className = this.slotData[e].style, n.appendChild(o), this.swSlots.appendChild(n), o.slotPosition = e, o.slotYPosition = 0, o.slotWidth = 0, o.slotMaxScroll = this.swSlotWrapper.clientHeight - o.clientHeight - 86, o.style.webkitTransitionTimingFunction = "cubic-bezier(0, 0, 0.2, 1)", this.slotEl.push(o), this.slotData[e].defaultValue && this.scrollToValue(e, this.slotData[e].defaultValue)
    }
    this.calculateSlotsWidth(), document.addEventListener("touchstart", this, !1), document.addEventListener("touchmove", this, !1), window.addEventListener("orientationchange", this, !0), window.addEventListener("scroll", this, !0), document.getElementById("sw-cancel").addEventListener("touchstart", this, !1), document.getElementById("sw-done").addEventListener("touchstart", this, !1), this.swFrame.addEventListener("touchstart", this, !1)
},init: function(t) {
    for (var e = this, i = new Date, o = {}, n = {}, a = {1: "1月",2: "2月",3: "3月",4: "4月",5: "5月",6: "6月",7: "7月",8: "8月",9: "9月",10: "10月",11: "11月",12: "12月"}, s = 1; 32 > s; s += 1)
        o[s] = s + "日";
    for (s = i.getFullYear() - 100; s < i.getFullYear() + 2; s += 1)
        n[s] = s + "年";
    this.addSlot(n, "center", i.getFullYear()), this.addSlot(a, "center", i.getMonth() + 1), this.addSlot(o, "center", i.getDate()), this.setCancelAction(function() {
        "function" == typeof t.onCanel && t.onCanel()
    }), this.setDoneAction(function() {
        if ("function" == typeof t.onSelect) {
            var e = this.getSelectedValues();
            e && (e = e.keys), t.onSelect(e)
        }
    }), $(document).on("click", function() {
        0 === $("#sw-wrapper").length || $(this).is("#sw-wrapper") || e.close()
    })
},open: function(t) {
    this.init(t), this.create(), this.swWrapper.style.webkitTransitionTimingFunction = "ease-out", this.swWrapper.style.webkitTransitionDuration = "400ms", this.swWrapper.style.webkitTransform = "translate3d(0, -260px, 0)"
},destroy: function() {
    this.swWrapper.removeEventListener("webkitTransitionEnd", this, !1), this.swFrame.removeEventListener("touchstart", this, !1), document.getElementById("sw-cancel").removeEventListener("touchstart", this, !1), document.getElementById("sw-done").removeEventListener("touchstart", this, !1), document.removeEventListener("touchstart", this, !1), document.removeEventListener("touchmove", this, !1), window.removeEventListener("orientationchange", this, !0), window.removeEventListener("scroll", this, !0), this.slotData = [], this.cancelAction = function() {
        return !1
    }, this.cancelDone = function() {
        return !0
    }, this.reset(), document.body.removeChild(document.getElementById("sw-wrapper"))
},close: function() {
    this.swWrapper.style.webkitTransitionTimingFunction = "ease-in", this.swWrapper.style.webkitTransitionDuration = "400ms", this.swWrapper.style.webkitTransform = "translate3d(0, 0, 0)", this.swWrapper.addEventListener("webkitTransitionEnd", this, !1)
},addSlot: function(t, e, i) {
    e || (e = ""), e = e.split(" ");
    for (var o = 0; o < e.length; o += 1)
        e[o] = "sw-" + e[o];
    e = e.join(" ");
    var n = {values: t,style: e,defaultValue: i};
    this.slotData.push(n)
},getSelectedValues: function() {
    var t, e, i, o, n = [], a = [];
    for (i in this.slotEl) {
        this.slotEl[i].removeEventListener("webkitTransitionEnd", this, !1), this.slotEl[i].style.webkitTransitionDuration = "0", this.slotEl[i].slotYPosition > 0 ? this.setPosition(i, 0) : this.slotEl[i].slotYPosition < this.slotEl[i].slotMaxScroll && this.setPosition(i, this.slotEl[i].slotMaxScroll), t = -Math.round(this.slotEl[i].slotYPosition / this.cellHeight), e = 0;
        for (o in this.slotData[i].values) {
            if (e == t) {
                n.push(o), a.push(this.slotData[i].values[o]);
                break
            }
            e += 1
        }
    }
    return {keys: n,values: a}
},setPosition: function(t, e) {
    this.slotEl[t].slotYPosition = e, this.slotEl[t].style.webkitTransform = "translate3d(0, " + e + "px, 0)"
},scrollStart: function(t) {
    for (var e = t.targetTouches[0].clientX - this.swSlots.offsetLeft, i = 0, o = 0; o < this.slotEl.length; o += 1)
        if (i += this.slotEl[o].slotWidth, i > e) {
            this.activeSlot = o;
            break
        }
    if (this.slotData[this.activeSlot].style.match("readonly"))
        return this.swFrame.removeEventListener("touchmove", this, !1), this.swFrame.removeEventListener("touchend", this, !1), !1;
    this.slotEl[this.activeSlot].removeEventListener("webkitTransitionEnd", this, !1), this.slotEl[this.activeSlot].style.webkitTransitionDuration = "0";
    var n = window.getComputedStyle(this.slotEl[this.activeSlot]).webkitTransform;
    return n = new WebKitCSSMatrix(n).m42, n != this.slotEl[this.activeSlot].slotYPosition && this.setPosition(this.activeSlot, n), this.startY = t.targetTouches[0].clientY, this.scrollStartY = this.slotEl[this.activeSlot].slotYPosition, this.scrollStartTime = t.timeStamp, this.swFrame.addEventListener("touchmove", this, !1), this.swFrame.addEventListener("touchend", this, !1), !0
},scrollMove: function(t) {
    var e = t.targetTouches[0].clientY - this.startY;
    (this.slotEl[this.activeSlot].slotYPosition > 0 || this.slotEl[this.activeSlot].slotYPosition < this.slotEl[this.activeSlot].slotMaxScroll) && (e /= 2), this.setPosition(this.activeSlot, this.slotEl[this.activeSlot].slotYPosition + e), this.startY = t.targetTouches[0].clientY, t.timeStamp - this.scrollStartTime > 80 && (this.scrollStartY = this.slotEl[this.activeSlot].slotYPosition, this.scrollStartTime = t.timeStamp)
},scrollEnd: function(t) {
    if (this.swFrame.removeEventListener("touchmove", this, !1), this.swFrame.removeEventListener("touchend", this, !1), this.slotEl[this.activeSlot].slotYPosition > 0 || this.slotEl[this.activeSlot].slotYPosition < this.slotEl[this.activeSlot].slotMaxScroll)
        return this.scrollTo(this.activeSlot, this.slotEl[this.activeSlot].slotYPosition > 0 ? 0 : this.slotEl[this.activeSlot].slotMaxScroll), !1;
    var e = this.slotEl[this.activeSlot].slotYPosition - this.scrollStartY;
    if (e < this.cellHeight / 1.5 && e > -this.cellHeight / 1.5)
        return this.slotEl[this.activeSlot].slotYPosition % this.cellHeight && this.scrollTo(this.activeSlot, Math.round(this.slotEl[this.activeSlot].slotYPosition / this.cellHeight) * this.cellHeight, "100ms"), !1;
    var i = t.timeStamp - this.scrollStartTime, o = 2 * e / i / this.friction, n = this.friction / 2 * o * o;
    0 > o && (o = -o, n = -n);
    var a = this.slotEl[this.activeSlot].slotYPosition + n;
    return a > 0 ? (a /= 2, o /= 3, a > this.swSlotWrapper.clientHeight / 4 && (a = this.swSlotWrapper.clientHeight / 4)) : a < this.slotEl[this.activeSlot].slotMaxScroll ? (a = (a - this.slotEl[this.activeSlot].slotMaxScroll) / 2 + this.slotEl[this.activeSlot].slotMaxScroll, o /= 3, a < this.slotEl[this.activeSlot].slotMaxScroll - this.swSlotWrapper.clientHeight / 4 && (a = this.slotEl[this.activeSlot].slotMaxScroll - this.swSlotWrapper.clientHeight / 4)) : a = Math.round(a / this.cellHeight) * this.cellHeight, this.scrollTo(this.activeSlot, Math.round(a), Math.round(o) + "ms"), !0
},scrollTo: function(t, e, i) {
    this.slotEl[t].style.webkitTransitionDuration = i ? i : "100ms", this.setPosition(t, e ? e : 0), (this.slotEl[t].slotYPosition > 0 || this.slotEl[t].slotYPosition < this.slotEl[t].slotMaxScroll) && this.slotEl[t].addEventListener("webkitTransitionEnd", this, !1)
},scrollToValue: function(t, e) {
    var i, o, n;
    this.slotEl[t].removeEventListener("webkitTransitionEnd", this, !1), this.slotEl[t].style.webkitTransitionDuration = "0", o = 0;
    for (n in this.slotData[t].values) {
        if (n == e) {
            i = o * this.cellHeight, this.setPosition(t, i);
            break
        }
        o -= 1
    }
},backWithinBoundaries: function(t) {
    return t.target.removeEventListener("webkitTransitionEnd", this, !1), this.scrollTo(t.target.slotPosition, t.target.slotYPosition > 0 ? 0 : t.target.slotMaxScroll, "150ms"), !1
},tapDown: function(t) {
    t.currentTarget.addEventListener("touchmove", this, !1), t.currentTarget.addEventListener("touchend", this, !1), t.currentTarget.className = "sw-pressed"
},tapCancel: function(t) {
    t.currentTarget.removeEventListener("touchmove", this, !1), t.currentTarget.removeEventListener("touchend", this, !1), t.currentTarget.className = ""
},tapUp: function(t) {
    this.tapCancel(t), "sw-cancel" == t.currentTarget.id ? this.cancelAction() : this.doneAction(), this.close()
},setCancelAction: function(t) {
    this.cancelAction = t
},setDoneAction: function(t) {
    this.doneAction = t
},cancelAction: function() {
    return !1
},cancelDone: function() {
    return !0
}}, $GH = function(t) {
    return t.extend(t.fn, {countdown: function(e, i, o) {
        o = o || "";
        var n = t(this[0]).html(o.replace(/time/g, i)), a = setInterval(function() {
            --i ? n.html(o.replace(/time/g, i)) : (clearInterval(a), e.call(n))
        }, 1e3)
    },serializeToObj: function() {
        var e = {}, i = this.serializeArray();
        return t.each(i, function() {
            e[this.name] ? (e[this.name].push || (e[this.name] = [e[this.name]]), e[this.name].push(this.value || "")) : e[this.name] = this.value || ""
        }), e
    },getUrlParams: function(t) {
        var e = {}, i = location.href, o = i.indexOf("?");
        if (-1 !== o) {
            var n = i.substring(i.indexOf("?") + 1);
            n = n.split("&");
            for (var a = 0; a < n.length; a++) {
                var s = n[a];
                s = s.split("="), e[s[0]] = s[1]
            }
            return t ? e[t] : e
        }
    },dropdownSheet: function(e) {
        return t(this).each(function() {
            var i = t(this), o = i.find("select"), n = i.find("input"), a = [], s = function(t) {
                o.val(t.attr("data-value")).trigger("change"), this.close()
            };
            n.val(t.trim(o.find("option:selected").text())), o.on("change", function() {
                return n.val(t.trim(o.find("option:selected").text())), !1
            }), o.find("option").each(function() {
                var e = t(this);
                e.text() && a.push({name: t.trim(e.text()),value: e.val(),styleClass: "option",fn: s})
            }), o.find("option").length > 4 ? i.on("click", function(t) {
                return $GH.hideKeyboard(), t.preventDefault(), t.stopImmediatePropagation(), $GH.MultiOptions.init(o.attr("data-title"), a, e).open(), !1
            }) : (e && (e.styleClass || (e.styleClass = "gbn gbt-pri"), a.push(e)), a.push({name: "取消",styleClass: "cancel",fn: function() {
                this.close()
            }}), i.on("click", function(t) {
                return $GH.hideKeyboard(), t.stopPropagation(), new $GH.ActionSheet(o.attr("data-title"), a).open(), !1
            }))
        })
    },datepicker: function(e) {
        if (this.length) {
            var i = t.extend({}, {onSelect: function() {
            },onCanel: function() {
            }}, e), o = window.SpinningWheel;
            t(this).on("click", function() {
                return t("#sw-wrapper").length ? void 0 : (o.open(i), !1)
            })
        }
    }}), {hideKeyboard: function() {
        document.activeElement.blur(), t("input，textarea").blur()
    },getQuery: function(t) {
        return (t || document.location.search).replace(/(^\?)/, "").split("&").map(function(t) {
            return t = t.split("="), this[t[0]] = t[1], this
        }.bind({}))[0]
    },genDate: function(t) {
        return (t.getMonth() + 1 < 10 ? "0" + (t.getMonth() + 1) : t.getMonth() + 1) + "-" + (t.getDate() < 10 ? "0" + t.getDate() : t.getDate()) + " " + (t.getHours() < 10 ? "0" + t.getHours() : t.getHours()) + ":" + (t.getMinutes() < 10 ? "0" + t.getMinutes() : t.getMinutes()) + ":" + (t.getSeconds() < 10 ? "0" + t.getSeconds() : t.getSeconds())
    },compileTmpl: function(t, e) {
        var i = /<%=this\.([^%>]+)%>/g;
        return t.replace(i, function() {
            return e && e[arguments[1]] || ""
        })
    },monitor: {link: function(t, e) {
        return (new Image).src = $GLog.url + "lt=1&from=" + encodeURIComponent(location.href) + "&to=" + encodeURIComponent(t) + "&mod=" + e + "&info=" + $GLog.loginId + "~|~" + $GLog.perSessiionId + "~|~" + $GLog.shortSessionId + "&_=" + (new Date).getTime(), !0
    },action: function(t) {
        return (new Image).src = $GLog.url + "lt=2&page=" + encodeURIComponent(location.href) + "&action=" + t + "&info=" + $GLog.loginId + "~|~" + $GLog.perSessiionId + "~|~" + $GLog.shortSessionId + "&_=" + (new Date).getTime(), !0
    },info: function(t, e) {
        return (new Image).src = $GLog.url + "lt=3&page=" + encodeURIComponent(location.href) + "&code=" + e + "&msg=" + encodeURIComponent(t) + "&info=" + $GLog.loginId + "~|~" + $GLog.perSessiionId + "~|~" + $GLog.shortSessionId + "&_=" + (new Date).getTime(), !0
    }},alTmpl: function(t, e) {
        var i = document.createElement("div"), o = alight.Scope();
        return i.innerHTML = t, o.data = e, alight.applyBindings(o, i), i.innerHTML
    },smartStr: function(t, e) {
        return t.length > e ? t.substr(0, e) + "..." : t
    },maskStr: function(t, e, i) {
        return t.substring(0, e - 1) + t.substring(e - 1, i).replace(/./g, "*") + t.substring(i)
    },cookie: {set: function(t, e, i, o) {
        var n = new Date;
        n.setTime(n.getTime() + 24 * i * 60 * 60 * 1e3);
        var a = "expires=" + n.toGMTString();
        o = "path=" + (o || "/"), document.cookie = t + "=" + e + "; " + a + ";" + o
    },get: function(t) {
        if (document.cookie.length > 0) {
            var e = document.cookie.indexOf(t + "=");
            if (-1 !== e) {
                e = e + t.length + 1;
                var i = document.cookie.indexOf(";", e);
                return -1 === i && (i = document.cookie.length), unescape(document.cookie.substring(e, i))
            }
        }
        return ""
    }},touchSlider: function(e, i) {
        function o(t) {
            $ = !0;
            var e = Math.abs(u) / S, i = e > a.slidePercent ? "0px" : S * t + "px", o = w ? {top: i} : {left: i}, n = -S * t + "px", s = w ? {top: n} : {left: n};
            r.eq(h + t).animate(o, 250, function() {
                e > a.slidePercent ? (r.eq(h).css(s).css("opacity", ""), r.eq(h + t).css({transition: "","z-index": 600}), h += t, a.onMoveEnd(h)) : r.eq(h).css("opacity", ""), $ = !1
            })
        }
        function n(t, e) {
            r.eq(h).css("opacity", 1 - Math.abs(u) / S), r.eq(t).css(w ? "top" : "left", e + "px").css({"z-index": 1e3})
        }
        t(document).on("touchmove", function(t) {
            t.preventDefault()
        });
        var a = t.extend({}, {direction: "h",slidePercent: .3,itemSelector: "div",onMoveEnd: function() {
        },index: 0}, i || {}), s = t(e), r = s.find(a.itemSelector), l = s.css("position"), c = s.height(), d = s.width(), u = 0, h = a.index, p = 0, f = !1, g = !1, m = !1, v = !1, $ = !1, w = "v" === a.direction, S = w ? c : d;
        return "absolute" === l || "fixed" === l || s.css({position: "relative"}), r.each(function(t) {
            r.eq(t).css({position: "absolute",top: w ? c + "px" : 0,left: a.index > t ? -(w ? 0 : d) + "px" : w ? 0 : d + "px","z-index": "600"})
        }), r.eq(a.index).css(w ? "top" : "left", 0), s.on("touchstart", function(t) {
            var e = t.touches[0];
            p = w ? e.clientY : e.clientX, u = 0, f = !1, g = !1, m = !1, v = !1
        }).on("touchmove", function(t) {
            var e = t.touches[0], i = w ? e.clientY : e.clientX, o = i - p, a = 0, s = 0;
            u += o, 0 > o && !$ && (v = h !== r.length - 1 || f ? !1 : !0, f ? (s = -S + u, a = 0 === h ? h : h - 1, n(a, s)) : h === r.length - 1 || m || (s = S + u, a = h + 1, n(a, s), g = !0)), o > 0 && !$ && (m = 0 !== h || g ? !1 : !0, g ? (s = S + u, a = h === r.length - 1 ? h : h + 1, n(a, s)) : 0 === h || v || (s = -S + u, a = h - 1, f = !0, n(a, s))), p = i
        }).on("touchend", function() {
            g && o(1), f && o(-1)
        }), this
    },iScroll: function(e, i, o) {
        if (0 == t("#gh").length && t(e).parent().length > 0) {
            var n = t(e).parent();
            if ("J_MultiOptions_Div" == n.attr("id")) {
                var a = n.find("h3").text();
                null != a && "" != a && (i.top = n.find("h3").height())
            }
        }
        i.top = (i.top || 0) + t("#gh").height(), i.bottom = (i.bottom || 0) + t("#gf").height();
        var s = t.extend({}, {position: "absolute",left: 0,top: 0,bottom: 0,zIndex: 1,width: "100%",overflow: "hidden",display: "block"}, i || {});
        return o = t.extend({}, {scrollbars: !0,fadeScrollbars: !0,shrinkScrollbars: "scale",mouseWheel: !0,click: !0,tap: "iscrollTap"}, o), t(e).css(s), window.IScroll ? new window.IScroll(e, o) : void 0
    },module: function(e, i) {
        var o = t(e);
        if (o.length > 0) {
            var n = alight.Scope();
            i.call(this, o, n), alight.applyBindings(n, o[0])
        }
    },Wrapper: function(e) {
        var i = document.body.scrollHeight > window.screen.availHeight ? document.body.scrollHeight + "px" : window.screen.availHeight + "px";
        this.config = t.extend({}, {zIndex: 100,opacity: .5,width: "100%",height: i,top: 0,background: "#000"}, e || {}), this.$wrapper = t("#J_wrapper").length > 0 ? t("#J_wrapper") : function() {
            return t("body").append(t('<div id="J_wrapper"></div>')), t("#J_wrapper")
        }(), t.extend($GH.Wrapper.prototype, {show: function(e) {
            var i = this;
            return t("body").css("overflow", "hidden"), t(document).on("ontouchstart", function(t) {
                t.preventDefault()
            }).on("touchmove", function(t) {
                t.preventDefault()
            }), i.$wrapper.css({position: "absolute",opacity: 0,background: i.config.background,zIndex: i.config.zIndex,top: i.config.top,width: i.config.width,height: i.config.height}).animate({opacity: i.config.opacity}, 100, function() {
                t.isFunction(e) && e.call(i)
            }), i.$wrapper
        },close: function() {
            this.$wrapper.remove(), t(document).off("ontouchstart").off("touchmove"), t("body").css("overflow", "auto")
        }})
    },MultiOptions: {init: function(e, i, o) {
        var n = this;
        return n.title = e, n.buttons = i, n.actionBtn = o, n.$wrapper = new $GH.Wrapper, n.$wrapper.$wrapper.on("click", function() {
            n.close()
        }), n.$container = n.$container ? n.$container : function() {
            return t('<div id="J_MultiOptions_Div" class="g-multi-opts"><h3></h3><div id="J_MultiOptions_Scroller"><div class="options J_Options"></div></div></div>').appendTo(t("body"))
        }(), n
    },_createButtons: function() {
        var e = this;
        if (!t.isArray(e.buttons) || 0 === e.buttons.length)
            throw "plz set buttonArray";
        e.title && "" !== e.title ? e.$container.find("h3").text(e.title).show() : e.$container.find("h3").hide(), e.$container.find(".action-btn").remove(), e.actionBtn && t('<a href="javascript:;" class="action-btn ' + (e.actionBtn.styleClass ? e.actionBtn.styleClass : "gbn gbt-pri") + '" data-value="' + (e.actionBtn.value ? e.actionBtn.value : "") + '">' + e.actionBtn.name + "</a>").appendTo(e.$container).on("click", function() {
            e.actionBtn.fn.call(e, t(this))
        });
        var i = e.$container.find(".J_Options").empty();
        t.each(e.buttons, function(o, n) {
            var a = n.value ? n.value : "";
            t('<a href="javascript:;" class="' + n.styleClass + '" data-value="' + a + '">' + n.name + "</a>").appendTo(i).on("iscrollTap", function() {
                n.fn.call(e, t(this))
            })
        }), e.$container.css({left: "100%"}).animate({left: "33%",width: "67%",boxShadow: "-1px 1px 5px #999"}, 200, function() {
            e.subScroll ? (e.subScroll.refresh(), e.subScroll.scrollTo(0, 0, 200)) : e.subScroll = $GH.iScroll("#J_MultiOptions_Scroller", {bottom: e.actionBtn ? e.$container.find(".action-btn").height() + 20 : 0,zIndex: 999})
        })
    },open: function() {
        var t = this;
        t.$wrapper.show(function() {
            t._createButtons()
        })
    },close: function() {
        var t = this;
        t.$container.animate({left: "100%"}, 200, function() {
            t.$wrapper.close()
        })
    }},ActionSheet: function(e, i) {
        var o = this;
        o.title = e, o.buttons = i, o.$wrapper = new $GH.Wrapper, o.$wrapper.$wrapper.on("click", function() {
            o.close()
        }), this.$ul = t("#J_ActionSheet_ul").length > 0 ? t("#J_ActionSheet_ul") : function() {
            return o.$wrapper.$wrapper.before(t('<ul id="J_ActionSheet_ul" class="g-actionsheet"></ul>')), t("#J_ActionSheet_ul")
        }(), t.extend($GH.ActionSheet.prototype, {_createButtons: function() {
            var e = this;
            if (!t.isArray(e.buttons) || 0 === e.buttons.length)
                throw "plz set buttonArray";
            e.$ul.css({position: "fixed",zIndex: 9999,visibility: "hidden",bottom: 0}), e.title && "" !== e.title && e.$ul.append('<li class="title">' + e.title + "</li>"), t.each(e.buttons, function(i, o) {
                e.$ul.append('<li><a href="javascript:;" class="J_ASBtn_' + i + " " + (o.styleClass ? o.styleClass : "") + '" data-value="' + (o.value ? o.value : "") + '">' + o.name + "</a></li>"), t(".J_ASBtn_" + i).on("click", function() {
                    o.fn.call(e, t(this))
                })
            }), e.$ul.css({bottom: -e.$ul.height()}).animate({bottom: 0,visibility: "visible"}, 100)
        },open: function() {
            var t = this;
            t.$wrapper.show(function() {
                t._createButtons()
            })
        },close: function() {
            var t = this;
            t.$wrapper.close(), t.$ul.remove()
        }})
    },ImageUploader: function(e, i) {
        var o = function(e, i) {
            var o = this;
            if (o.config = t.extend({}, {inputName: "img",onlySlider: !1,uploadBtn: ".J_UploadBtn",fileInput: ".J_FileInput",prevClass: "preview",uploaderUrl: "/mockup/image-uploader.json",deleteUrl: "/mockup/image-del.json",afterUpload: !1,limitSize: 2,limitNum: 9,beforeComplete: function() {
                },afterComplete: function() {
                },afterDelete: function() {
                }}, i), o.file = null, o.$controller = e, o.$uploadBtn = e.find(o.config.uploadBtn), o.$fileInput = e.find(o.config.fileInput), o.$uploadBtn.css({overflow: "hidden"}), o.$uploadBtn.on("click", function() {
                    o.$fileInput.focus()
                }), o.config.onlySlider) {
                var n = o.$controller.find("." + o.config.prevClass);
                t.each(n, function(t, e) {
                    e === o.config.onlySlider && o.sliderShow(t)
                })
            }
            return o.config.onlySlider ? void 0 : o.selected()
        };
        return t.extend(o.prototype, {selected: function() {
            var e = this;
            return e.$fileInput.on("change", function(i) {
                if (e.file = i.target.files[0], e.file) {
                    var o = new FileReader;
                    o.onloadend = function(i) {
                        var o = i.target.result, n = t("<img>"), a = (new Date).getTime();
                        return e.$uploadBtn.siblings("." + e.config.prevClass).length >= e.config.limitNum ? void $GH.alert("最多可上传: " + e.config.limitNum + "张") : i.total / 1024 / 1024 >= e.config.limitSize ? void $GH.alert("文件大小不能超过: " + e.config.limitSize + "M") : (e.$uploadBtn.hasClass("small") && n.addClass("small"), e.$uploadBtn.addClass("loading"), e.config.beforeComplete.call(e), t.ajax({type: "post",url: e.config.uploaderUrl,data: {photo: o},dataType: "json",cache: !1,success: function(i) {
                            var o = e.config.inputName + "_" + a;
                            if (i.hasError)
                                return void $GH.alert(i.message);
                            if (t.isFunction(e.config.afterUpload))
                                return e.config.afterUpload.call(e, i);
                            var s = i.map.medicalRecordImgPath || i.map.imageServerPath + "/" + i.map.path;
                            n[0].src = s, e.$uploadBtn.before(n.addClass(e.config.prevClass).addClass(o)), e.$uploadBtn.before('<input type="hidden" name="' + e.config.inputName + '" class="' + o + '" value="' + i.map.sourcePath + '">'), n.on("click", function() {
                                t.each(e.$uploadBtn.siblings("." + e.config.prevClass), function(t, i) {
                                    i.src === s && e.sliderShow(t)
                                })
                            })
                        },complete: function() {
                            e.$uploadBtn.removeClass("loading"), e.config.afterComplete.call(e)
                        }}), void e.$fileInput.val(""))
                    }, o.readAsDataURL(e.file)
                }
            }), e
        },sliderRest: function(e, i) {
            var o = this;
            o.$slider = t("#J_ImageSlider").length > 0 ? t("#J_ImageSlider") : function() {
                return t("body").append(t('<div id="J_ImageSlider"></div>')), t("#J_ImageSlider")
            }(), o.$slider.html(""), t.each(o.$controller.find("img." + o.config.prevClass), function(i, n) {
                var a, s = t("<canvas/>"), r = n.classList[n.classList.length - 1], l = t('<div class="' + r + ' g-img-loading"/>'), c = new Image;
                a = s[0].getContext("2d"), c.onload = function() {
                    var t = c.width, e = c.height, i = window.screen.availWidth;
                    t > i ? (s[0].width = i, s[0].height = e * (i / t)) : (s[0].width = t, s[0].height = e), a.drawImage(c, 0, 0, s[0].width, s[0].height)
                }, t(c).one("load", function() {
                    l.removeClass("g-img-loading")
                }).attr("src", -1 !== n.src.indexOf("small") ? n.src.replace("small", "large") : n.src), l.css({paddingTop: "5%",height: "90%"}), l.append(s), l.append('<p>              <a href="#" class="J_Image_Del" data-cname="' + r + '">删除</a>              <a href="#" class="J_Slider_Close" data-cname="' + r + '">关闭</a>            </p>'), l.find("p").css({position: "absolute",bottom: 0,width: "100%"}).find("a").css({color: "#ccc",display: "inline-block",width: "35%",boxShadow: "0 0 5px #000",border: "1px solid #444",padding: "5px 0",background: "#000"}), l.css({width: "100%",textAlign: "center"}), o.$slider.append(l), e.$wrapper.one("click", function() {
                    o.$wrapper.close(), o.$slider.remove()
                })
            }), o.config.onlySlider && t(".J_Image_Del").hide(), $GH.touchSlider("#" + o.$slider[0].id, {direction: "h",itemSelector: "div",slidePercent: .2,index: i})
        },sliderShow: function(e) {
            var i = this;
            return i.$wrapper = new $GH.Wrapper({zIndex: 200,overflow: "hidden",opacity: .8}), 0 === i.$controller.find("." + i.config.prevClass).length ? void i.$wrapper.close() : (i.$slider = t("#J_ImageSlider").length > 0 ? t("#J_ImageSlider") : function() {
                return t("body").append(t('<div id="J_ImageSlider"></div>')), t("#J_ImageSlider")
            }(), void i.$wrapper.show(function() {
                var o = this;
                i.$slider.css({position: "absolute",top: document.body.scrollTop > 0 ? document.body.scrollTop : 0,left: 0,width: "100%",height: "90%",overflow: "hidden",display: "block"}), i.sliderRest(o, e), t(".J_Image_Del").on("click", function() {
                    {
                        var e = t(this).data("cname");
                        t(this)
                    }
                    t("." + e).find("canvas").animate({scale: "0.1, 0.1"}, 200, function() {
                        t("." + e).remove(), i.$slider.remove(), i.$wrapper.close()
                    }), i.config.afterDelete.call(i)
                }), t(".J_Slider_Close").on("click", function() {
                    i.$slider.remove(), i.$wrapper.close()
                })
            }))
        }}), new o(e, i)
    },btnTapClassChange: function() {
        0 !== t(".GJ_TapClass").length && (t(".GJ_TapClass").on("touchstart", function() {
            var e = t(this), i = e.data("tap-class") || "active";
            e.addClass(i)
        }), t(".GJ_TapClass").on("touchend", function() {
            var e = t(this);
            e.removeClass(e.data("tap-class") || "active")
        }))
    },alert: function(e, i, o) {
        e && t.pgwModal({content: e,popup: !0,duration: i || 2e3,close: !1,afterClose: function() {
            "function" == typeof o && o()
        }})
    },confirm: function(e, i) {
        t.pgwModal({content: '<div class="g-msg">' + e + "</div>",popup: !0,close: !1,confirm: !0,confirmButtons: i})
    },loading: {show: function() {
        return t(".GJ_Loading").length > 0 ? void (t(".GJ_Loading").is(":visible") || t(".GJ_Loading").show()) : void t("body").append('<div class="g-page-loading GJ_Loading"><div class="roll"></div><div class="fixed"></div></div>')
    },hide: function() {
        0 !== t(".GJ_Loading").length && t(".GJ_Loading").hide()
    }},validate: function(e) {
        if (e)
            for (var i in e) {
                var o = t(i);
                if (o.length) {
                    var n = t.trim(o.val()), a = e[i];
                    if (a)
                        for (var s in a) {
                            var r = !1, l = "";
                            if ("function" == typeof a[s]) {
                                var c = a[s].call(o, n);
                                c !== !0 && (r = !0, l = c)
                            } else
                                switch (s) {
                                    case "required":
                                        n || (r = !0);
                                        break;
                                    case "mobile":
                                        /^1\d{10}$/.test(n) || "" === n || (r = !0);
                                        break;
                                    case "password":
                                        /^([a-zA-Z0-9]|[~`!@#$%\^&\*\(\)_\+-=\{\}\]|\[:;\"'<>,\.\/\?]){6,16}$/.test(n) || "" === n || (r = !0);
                                        break;
                                    case "chinese":
                                        /^[\u2E80-\uFE4F]+$/.test(n) || "" === n || (r = !0);
                                        break;
                                    case "email":
                                        /^([a-z0-9_\.\-\+]+)@([\da-z\.\-]+)\.([a-z\.]{2,6})$/i.test(n) || "" === n || (r = !0)
                                }
                            if (r)
                                return l || (l = a[s]), l || (l = i + "未配置校验提示信息"), $GH.alert(l), !1
                        }
                }
            }
        return !0
    },adjustGpPadding: function(e) {
        var i = t(".GJ_Gp"), o = 10;
        if (t("#gf").length) {
            var n = t("#gf").height();
            t(".GJ_BotFixed:visible").css("bottom", n + "px"), o += n
        }
        i.css("padding-bottom", o + t(".GJ_BotFixed:visible").height() + "px");
        var a = 0;
        if (t("#gh").length) {
            var s = t("#gh").height();
            t(".GJ_TopFixed:visible").css("top", s + "px"), a += s
        }
        i.hasClass("gp-tp") && (a += 10), i.css("padding-top", a + (t(".GJ_TopFixed:visible").height() - 1) + "px"), e && e()
    },formSubmit: function(e, i) {
        t.ajax({dataType: "json",cache: !1,data: e.serialize(),url: e.attr("action"),type: e.attr("method"),success: function(t) {
            if (void 0 === t.hasError || t.hasError)
                i && i.error ? i.error.call(e, t) : $GH.alert(t.message);
            else {
                var o = t.message || "成功了！";
                $GH.alert(o, 2e3, function() {
                    if (i && i.success)
                        i.success.call(e, t);
                    else if (t.returnUrl && "" != t.returnUrl) {
                        var o = t.returnUrl;
                        o.indexOf("http://") < 0 && (o = $GC.guahaoServer + o), location.href = o
                    }
                })
            }
        },error: function(t, e) {
            return "abort" === e ? void $GH.alert("请求过于频繁，请求已中止") : void $GH.alert("系统异常，请稍后重试！")
        }})
    },mobileMsg: {orderResend: function(e, i) {
        t.ajax({dataType: "json",cache: !1,url: "/json/black/order/resendmsg/" + e,success: function(t) {
            void 0 === t.hasError || t.hasError ? $GH.alert(t.message) : ($GH.alert("验证码消息发送成功！"), i && i())
        },error: function(t, e) {
            return "abort" === e ? void $GH.alert("请求过于频繁，请求已中止") : void $GH.alert("发送失败，请稍后重试！")
        }})
    }},refreshCaptcha: function(t) {
        var e = t.attr("data-src") || t.attr("src");
        return t.attr("src", e + "?_=" + Math.floor(1e7 * Math.random())), t
    },mobileCode: {_doSend: function(e, i) {
        t.ajax({dataType: "json",cache: !1,url: e,success: function(t) {
            void 0 === t.hasError || t.hasError ? $GH.alert(t.message) : ($GH.alert("验证码消息发送成功！"), i && i())
        },error: function(t, e) {
            return "abort" === e ? void $GH.alert("请求过于频繁，请求已中止") : void $GH.alert("发送失败，请稍后重试！")
        }})
    },basic: function(t, e, i) {
        var o = "/json/white/mobile/send/" + t + "/" + e + "/" + md5(e + t);
        this._doSend(o, i)
    },updateProfile: function(t, e) {
        var i = "/json/black/update/profile/" + t + "/UPDATE_PROFILE/" + md5("UPDATE_PROFILE" + t);
        this._doSend(i, e)
    },book: function(t, e, i, o, n) {
        var a = "/json/black/res/mobile/" + t + "/RES_CODE_MOBILE/" + e + "/" + i;
        n && "voice" == n && (a = "/json/black/res/voicemobile/" + t + "/RES_CODE_MOBILE/" + e + "/" + i), this._doSend(a, o)
    }}}
}(Zepto), $Common = function(t) {
    if (window.$GF)
        for (var e = 0; e < window.$GF.length; e++)
            window.$GF[e].call();
    if (t(".GJ_WxShare").on("click", function() {
            return t(".GJ_WxShareOverlay").show(), !1
        }), t(".GJ_WxShareOverlay").on("click", function() {
            return t(".GJ_WxShareOverlay").is(":visible") && t(".GJ_WxShareOverlay").hide(), !1
        }), t(document).on("ajaxBeforeSend", function(e) {
            var i = ["a", "button", "input", "body"], o = e.target.activeElement, n = i.join("[req-url],") + "[req-url]", a = e._args[1].url.replace(/\_\=[\d]+/, "");
            return t(n).length > 0 && !t(o).hasClass("GJ_IngoreBlock") && t(o).attr("req-url") === a ? !1 : void (-1 !== i.indexOf(o.localName) && (t(o).attr("req-url", a), t(document).on("ajaxComplete", function() {
                t(o).removeAttr("req-url")
            })))
        }), t(".GJ_AHText").on("keyup", function() {
            var e = t(this).height(), i = t(this)[0].scrollHeight, o = t(this).parent().height();
            i > e + 2 && 74 > e && (t(this).height(i - 2), t(this).parent().height(o + (i - e)))
        }), $GH.btnTapClassChange(), t(".GJ_DatePicker").datepicker({onSelect: function(e) {
            t(".GJ_ShowDate").html(e[0] + "年" + e[1] + "月" + e[2] + "日"), t(".GJ_DateValue").val(e.join("-"))
        }}), t(document).on("click", ".GJ_Redirect", function(e) {
            return e.stopPropagation(), location.href = t(this).attr("data-page"), !1
        }), document.domain.indexOf("mhealth") > -1) {
        var i = $GH.cookie.get("_wycb_");
        if (t("#gh").length && i) {
            var o = t('<a href="javascript:;">关闭</a>');
            o.css({position: "absolute",color: "#fff",right: "10px"}), o.on("click", function() {
                location.href = i.replace(/\"/g, "")
            }), t("#gh").prepend(o)
        }
    }
    return document.domain.indexOf("sanxing") > -1 ? "" == location.pathname.replace(/\//g, "") && t("#gh .GJ_Back").attr("href", "action://finish") : ("" === document.referrer || "" == location.pathname.replace(/\//g, "")) && t("#gh .GJ_Back").remove(), t(".gp-orderpay-state").length > 0 && t("#gh .GJ_Back").remove(), t(".GJ_Back").on("click", function() {
        var e = t(this).attr("href");
        return "javascript:;" == e ? history.back(-1) : location.href = e, !1
    }), t(document).on("focus", "input, textarea", function() {
        "file" != t(this).attr("type") && 1 != t(this).attr("data-noaction") && t("body").addClass("g-fix-fixed")
    }), t(document).on("blur", "input, textarea", function() {
        "file" != t(this).attr("type") && 1 != t(this).attr("data-noaction") && (t("body").removeClass("g-fix-fixed"), setTimeout(function() {
            window.scrollTo(document.body.scrollLeft, document.body.scrollTop)
        }, 10))
    }), t(".GJ_Dropdown").dropdownSheet(), $GH.adjustGpPadding(), {mulLevelSelect: {subScroll: null,option: {},init: function(e) {
        var i = this;
        this.options = t.extend({}, {defaultSubItem: 0,top: 0,loadSubData: function() {
        },buildHtml: function() {
        },onSubSelect: function() {
        }}, e), t(".J_MainScroller").on("click", "li", function() {
            return i.showSubList(t(this)), !1
        }), t(document).on("click", ".J_SubScroller li", function() {
            return i.options.onSubSelect && i.options.onSubSelect.call(this), !1
        }), this.initMainScroll()
    },showSubList: function(e) {
        var i = this;
        $GH.loading.show(), t(".J_FixedCurrent").hide(), e.closest(".J_MainScroller").find("li").removeClass("current"), e.addClass("current"), this.options.loadSubData.call(e, function(t) {
            i.renderSubList(t, function() {
                $GH.loading.hide()
            })
        })
    },initMainScroll: function() {
        var e = this, i = $GH.iScroll(".J_MainScroller", {top: e.options.top}, {probeType: 3,deceleration: 2e-4});
        if (i.on("scroll", function() {
                e.adjustCurrent(this.y)
            }), i.on("scrollEnd", function() {
                e.adjustCurrent(this.y)
            }), e.options.defaultSubItem) {
            var o = t(".J_MainScroller .current");
            o.length > 0 && (i.scrollToElement(o[0]), e.showSubList(o))
        }
    },renderSubList: function(e, i) {
        var o = t(".J_SubScroller").find("ul");
        if (o.empty(), !e || 0 === e.length)
            return void ("function" == typeof i && i());
        for (var n = [], a = 0; a < e.length; a++)
            n.push(this.options.buildHtml(e[a]));
        o.append(n.join("")), this.options.defaultSubItem && o.find('li[data-id="' + this.options.defaultSubItem + '"]').addClass("current"), this.initSubScroll(i)
    },initSubScroll: function(e) {
        var i = this;
        return i.subScroll ? (i.subScroll.refresh(), i.options.defaultSubItem ? t(".J_SubScroller .current").length > 0 && i.subScroll.scrollToElement(t(".J_SubScroller .current")[0]) : i.subScroll.scrollTo(0, 0, 200), void ("function" == typeof e && e())) : (t(".J_SubScroller").css({height: t(".J_MainScroller").height(),display: "block"}).animate({left: "34%",width: "66%",zIndex: 2,boxShadow: "-1px 3px 5px rgba(0,0,0,0.3)"}, 100, function() {
            i.subScroll = $GH.iScroll(".J_SubScroller", {top: i.options.top,left: "34%",width: "66%",zIndex: 999}), i.options.defaultSubItem && i.subScroll.scrollToElement(t(".J_SubScroller .current")[0])
        }), void ("function" == typeof e && e()))
    },adjustCurrent: function() {
        var e = t(".J_MainScroller .current");
        if (e.length) {
            var i = e.offset().top, o = e.height(), n = t(window).height(), a = t("#gh").height();
            a >= i ? t(".J_FixedCurrent").text(e.text()).css({top: a}).show() : i > a && n - o >= i ? t(".J_FixedCurrent").hide() : t(".J_FixedCurrent").text(e.text()).css({top: "auto",bottom: 0}).show()
        }
    }},pullUpAngularScroll: {scroll: null,options: {},currentPage: 1,pageCount: 1,init: function(e) {
        $GH.loading.show();
        var i = this;
        this.options = t.extend({}, {pageSize: 10,initScrollCfg: {},scrollSelector: "",listSelector: "",loadingData: function() {
        }}, e), this.options.loadingData.call(this, 1, function() {
            i.initScroll()
        })
    },initScroll: function() {
        var e = this;
        if (e.pageCount == e.currentPage && t(this.options.listSelector + " .g-pullUp").hide(), this.scroll)
            return this.scroll.refresh(), void $GH.loading.hide();
        var i = document.querySelector(".g-pullUp"), o = 0;
        i && (o = i.offsetHeight), this.scroll = $GH.iScroll(this.options.scrollSelector, {top: this.options.initScrollCfg.top || 0,bottom: this.options.initScrollCfg.bottom || 0}, {probeType: 1,deceleration: 2e-4,startY: 0});
        var n = function() {
            e.pageCount <= e.currentPage || e.scroll.y <= e.scroll.maxScrollY + 50 && i && !i.className.match("g-loading") && (t(".g-pullUp").addClass("g-loading").html('<span class="g-icon g-pullUpIcon">&nbsp;</span><span class="g-pullUpLabel">正在努力加载...</span>'), e.options.loadingData.call(e, ++e.currentPage, function() {
                e.initScroll(), i && i.className.match("g-loading") && t(".g-pullUp").removeClass("g-loading").html("")
            }))
        };
        this.scroll.on("scroll", function() {
            n()
        }), this.scroll.on("scrollEnd", function() {
            n()
        }), $GH.loading.hide()
    }},pullUpScroll: {scroll: null,options: {},currentPage: 1,totalCount: 0,init: function(e) {
        $GH.loading.show();
        var i = this;
        this.options = t.extend({}, {pageSize: 10,initScrollCfg: {},scrollSelector: "",listSelector: "",customFunc: null,loadingData: function() {
        },buildHtml: function() {
        },afterRendered: function() {
        }}, e), this.options.loadingData.call(this, 1, function(t) {
            i.renderList(t, function() {
                i.initScroll()
            })
        }), t(this.options.listSelector).on("refreshList", function() {
            t(this).find("ul").empty(), i.options.loadingData.call(this, 1, function(t) {
                i.renderList(t, function() {
                    i.initScroll()
                }), i.scroll.scrollTo(0, 0)
            })
        })
    },initScroll: function() {
        var e = this;
        if (this.scroll)
            return this.scroll.refresh(), this.options.afterRendered(), void $GH.loading.hide();
        var i = document.querySelector(".g-pullUp"), o = 0;
        i && (o = i.offsetHeight), t(this.options.listSelector + " ul > li").length < this.options.pageSize && t(this.options.listSelector + " .g-pullUp").hide(), this.scroll = $GH.iScroll(this.options.scrollSelector, {top: this.options.initScrollCfg.top || 0,bottom: this.options.initScrollCfg.bottom || 0}, {probeType: 1,deceleration: 2e-4,startY: 0});
        var n = function() {
            if (!(t(e.options.listSelector + " ul > li").length < e.options.pageSize) && !(t(e.options.listSelector + " ul > li").length >= e.totalCount) && e.scroll.y <= e.scroll.maxScrollY + 50 && i && !i.className.match("g-loading")) {
                t(".g-pullUp").addClass("g-loading").html('<span class="g-icon g-pullUpIcon">&nbsp;</span><span class="g-pullUpLabel">正在努力加载...</span>');
                var o = 0;
                o = e.currentPage ? e.currentPage + 1 : 2, e.options.loadingData.call(e, o, function(n) {
                    e.renderList(n, function() {
                        e.initScroll(), i && i.className.match("g-loading") && t(".g-pullUp").removeClass("g-loading").html(""), e.currentPage = o
                    })
                })
            }
        };
        e.options.customFunc && "function" == typeof e.options.customFunc && e.options.customFunc.call(e), this.scroll.on("scroll", function() {
            n()
        }), this.scroll.on("scrollEnd", function() {
            n()
        }), this.options.afterRendered(), $GH.loading.hide()
    },renderList: function(e, i) {
        var o = t(this.options.listSelector);
        if (!e || !e.length)
            return void (i && i());
        for (var n = [], a = 0; a < e.length; a++) {
            var s = e[a];
            n.push(this.options.buildHtml(s))
        }
        o.find("ul").append(n.join("")), i && i()
    }},initStarsVote: function() {
        t(".GJ_StarList span").on("click", function() {
            var e = t(this).data("index");
            e = parseInt(e, 10);
            var i = t(this).parent().find(".selected").length, o = t(this).parent().next();
            1 === e && 1 === i ? (t(this).removeClass("selected"), o.val("")) : (t(this).parent().find("span").each(function() {
                var i = t(this).data("index");
                i = parseInt(i, 10), e >= i ? t(this).addClass("selected") : t(this).removeClass("selected")
            }), o.val(t(this).parent().find(".selected").length))
        })
    },doVote: function() {
        $Common.initStarsVote(), t(".J_Submit").on("click", function() {
            t("#J_DoVoteForm").submit()
        }), t("#J_DoVoteForm").on("submit", function() {
            var e = (t(this), $GH.validate({"#disease": {required: "请输入所患疾病",check: function(t) {
                return /[\u4E00-\uFA29]/.test(t) ? !0 : "疾病名称必须含有汉字"
            }},"#manner": {required: "请为医生态度评分"},"#effect": {required: "请为治疗效果评分"},"#service": {required: "请为医院服务评分"},"#time": {required: "请为候诊时间评分"},"#desc": {required: "请输入就医经验",check: function(t) {
                return t.length < 10 ? "分享内容不得少于10个字" : /[\u4E00-\uFA29]/.test(t) ? !0 : "分享内容必须含有汉字"
            }}}));
            return e && $GH.formSubmit(t("#J_DoVoteForm")), !1
        })
    },buildDoctorItem: function(t) {
        var e = [];
        e.push('<li data-id="' + t.id + '">'), e.push('<div class="portrait">');
        var i = t.photo, o = $GC.staticServer + "/img/character/doc-unknow.png";
        return e.push('<img src="' + i + '" alt="" onerror="this.src=\'' + o + "'\"/>"), e.push("</div>"), e.push('<div class="main">'), e.push('<p><span class="name">' + t.name + "</span>"), e.push('<span class="position">' + t.titleTypeText + "</span></p>"), e.push('<p class="office">' + t.hospitalName + "-" + t.hospDeptName + "</p>"), e.push('<p class="great"><span class="tt">擅长：</span>' + (t.feature || "暂无") + "</p>"), e.push("</div>"), e.push('<div class="g-fr show">'), e.push('<span class="' + ("1" === t.haoyuan ? "enable" : "disable") + '">' + ("1" === t.haoyuan ? "有号" : "约满") + "</span>"), e.push('<span class="count">' + $Common.shortCount(t.patientCount) + "</span>"), e.push('<span class="count">患者数</span>'), e.push("</div>"), e.push("</li>"), e.join("")
    },buildHospitalItem: function(t) {
        var e = [];
        e.push('<li class="g-arrow-r" data-id="' + t.id + '">');
        var i = $GC.staticServer + "/img/character/hos.png";
        return e.push('<div class="portrait"><img src="' + t.photo + '" alt="" onerror="this.src=\'' + i + "'\"/></div>"), e.push('<div class="main">'), e.push('<p><span class="name">' + t.name + "</span></p>"), e.push('<p class="level">' + t.hospitalLevel + "&nbsp;&nbsp;|&nbsp;&nbsp;患者数：" + $Common.shortCount(t.patientNum || 0) + "</p>"), e.push("</div>"), e.push("</li>"), e.join("")
    },buildVoteItem: function(t) {
        var e = [];
        e.push('<li class="shadow-box">'), e.push('<div class="title g-clear">'), e.push('<span class="topic">' + t.diseaseName + "</span>"), e.push('<div class="g-vote">'), e.push('<div class="enable" style="width:' + 20 * t.doctorAttitude + '%"></div>'), e.push("</div>"), e.push("</div>"), e.push('<div class="desc">' + t.content + "</div>"), e.push('<div class="date">');
        var i = null === t.treatmentAfterday ? "" : 0 === t.treatmentAfterday ? "就诊当天" : "就诊后" + t.treatmentAfterday + "天";
        e.push('<span class="time">' + t.gmtCreatedStr + " " + i + "</span>");
        var o = t.nickName;
        o = o.substr(0, 1) + (2 === o.length ? "*" : "**"), e.push('<span class="user">' + o + "</span>"), e.push("</div>");
        var n = t.commentExpertAppendVOList;
        if (n)
            for (var a = 0; a < n.length; a++) {
                var s = n[a];
                e.push('<div class="more">'), e.push('<dv class="message"><span>追加</span>：' + s.content + "</div>"), e.push('<div class="date">');
                var r = 0 === s.treatmentAfterday ? "就诊当天" : "就诊后" + s.treatmentAfterday + "天";
                e.push('<span class="time">' + s.gmtCreated + " " + r + "</span>"), e.push('<span class="user">' + o + "</span>"), e.push("</div>"), e.push("</div>")
            }
        return e.push("</li>"), e.join("")
    },shortCount: function(t) {
        if (!t)
            return 0;
        var e = t;
        return e > 1e4 && (e = (e / 1e4).toFixed(1) + "万"), e
    }}
}(Zepto);
$(function() {
    function t(t) {
        var e = function() {
            $(".J_CountDownTip").show(), $(".J_CountDown").countdown(function() {
                $(".J_CountDownTip").hide(), $(".J_Resend").show()
            }, 60, "time")
        };
        $(".J_TriggerSend").length > 0 && $GH.mobileCode.basic($("#J_HiddenMobile").val(), t, function() {
            e()
        }), $(".J_Resend").on("click", function() {
            $GH.mobileCode.basic($("#J_HiddenMobile").val(), t, function() {
                $(".J_Resend").hide(), e()
            })
        })
    }
    $GH.module("#J_Broken", function() {
        $(window).on("click", function() {
            location.reload()
        })
    }), $GH.module("#J_AccountLogin", function() {
        var t = {init: function() {
            $(".J_ImgCaptcha").on("click", function() {
                return $GH.refreshCaptcha($(this).find("img")), !1
            }), $(".J_Login").on("click", function() {
                var t = $(this), e = $GH.validate({"#username": {required: "用户名不能为空"},"#password": {required: "请输入密码"},"#captcha": {required: "请输入验证码"}});
                return e && $.ajax({type: "post",dataType: "json",data: {loginId: $("#username").val(),password: window.md5($("#password").val()),validCode: $("#captcha").val()},cache: !1,url: t.attr("data-action"),success: function(t) {
                    void 0 === t.hasError || t.hasError ? ($GH.alert(t.message), $("#captcha").val("").focus(), $GH.refreshCaptcha($(".J_ImgCaptcha").find("img"))) : location.href = $GC.guahaoServer + $("#target").val()
                },error: function(t, e) {
                    "abort" !== e && $GH.alert("登录失败，请稍后重试！")
                }}), !1
            })
        }};
        t.init()
    }), $GH.module("#J_AccountRegister", function() {
        $(".J_ImgCaptcha").on("click", function() {
            return $GH.refreshCaptcha($(this).find("img")), !1
        }), $(".J_Check").on("click", function() {
            return $(this).toggleClass("g-checkbox-checked"), $(this).toggleClass("g-checkbox"), $("#agreement").val($(this).hasClass("g-checkbox-checked") ? "1" : ""), !1
        }), $(".J_GetCaptcha").on("click", function() {
            var t = $(this);
            $(".J_Check").hasClass("g-checkbox-checked") && $("#agreement").val("1");
            var e = $GH.validate({"#mobile": {required: "手机号码不能为空",mobile: "手机号码格式不正确"},"#agreement": {required: "请先同意协议才能注册"}});
            if (e) {
                var i = t.attr("data-goto") + "?mobile=" + $("#mobile").val();
                $("#J_HiddenTarget").val() && (i += "&target=" + $("#J_HiddenTarget").val()), location.href = i
            }
            return !1
        }), t("REG_MOBILE"), $(".J_VerifyCaptcha").on("click", function() {
            var t = $(this), e = $GH.validate({"#smsCaptcha": {required: "短信验证码不能为空"},"#imgCaptcha": {required: "图片验证码不能为空"}});
            if (e) {
                var i = $("#J_HiddenMobile").val(), o = $("#smsCaptcha").val(), n = $("#imgCaptcha").val(), a = $("#J_HiddenTarget").val();
                $.ajax({type: "post",dataType: "json",data: {mobile: i,smsCaptcha: o,imgCaptcha: n,target: a},cache: !1,url: t.attr("data-action"),success: function(e) {
                    void 0 === e.hasError || e.hasError ? ($GH.alert(e.message), $("#imgCaptcha").val("").focus(), $GH.refreshCaptcha($(".J_ImgCaptcha").find("img"))) : location.href = t.attr("data-goto") + "?mobile=" + i + "&smsCaptcha=" + o + "&imgCaptcha=" + n + "&target=" + a
                },error: function(t, e) {
                    "abort" !== e && $GH.alert("提交失败，请稍后重试！")
                }})
            }
            return !1
        }), $(".J_SetPassword").on("click", function() {
            var t = $(this), e = $GH.validate({"#password": {required: "密码不能为空",password: "密码格式不正确，请输入6-16位数字、字母组成的密码"}});
            return e && $.ajax({type: "post",dataType: "json",data: {mobile: $("#J_HiddenMobile").val(),password: $("#password").val(),smsCaptcha: $("#J_HiddenSmsCaptcha").val(),imgCaptcha: $("#J_HiddenImgCaptcha").val(),encMobile: $("#J_HiddenEncMobile").val(),target: $("#J_HiddenTarget").val()},cache: !1,url: t.attr("data-action"),success: function(e) {
                void 0 === e.hasError || e.hasError ? $GH.alert(e.message, "", function() {
                    e.returnUrl && (location.href = e.returnUrl)
                }) : $GH.alert("注册成功", "", function() {
                    location.href = e.returnUrl ? e.returnUrl : t.attr("data-goto")
                })
            },error: function(t, e) {
                "abort" !== e && $GH.alert("提交失败，请稍后重试！")
            }}), !1
        })
    }), $GH.module("#J_Account", function() {
        $(".J_ImgCaptcha").on("click", function() {
            return $GH.refreshCaptcha($(this).find("img")), !1
        }), $(".J_BackPwdFirst").on("click", function() {
            var t = $(this), e = $GH.validate({"#username": {required: "请输入登录名"},"#captcha": {required: "请输入验证码"}}), i = $("#username").val(), o = $("#captcha").val();
            return e && $.ajax({type: "post",dataType: "json",data: {loginId: i,validcode: o},cache: !1,url: t.attr("data-action"),success: function(e) {
                void 0 === e.hasError || e.hasError ? ($GH.alert(e.message), $("#captcha").val("").focus(), $GH.refreshCaptcha($(".J_ImgCaptcha").find("img"))) : location.href = t.attr("data-goto") + "?loginId=" + i + "&imgCaptcha=" + o
            },error: function(t, e) {
                "abort" !== e && $GH.alert("操作失败，请稍后重试！")
            }}), !1
        }), $("#J_PhoneVerify").on("click", function() {
            $(".J_PhoneLines").show(), $(".J_EmailLines").hide(), $(".J_BackPwdPhoneSecond").show(), $(".J_BackPwdEmailSecond").hide()
        }), $("#J_EmailVerify").on("click", function() {
            $(".J_PhoneLines").hide(), $(".J_EmailLines").show(), $(".J_BackPwdPhoneSecond").hide(), $(".J_BackPwdEmailSecond").show()
        }), $(".J_BackPwdPhoneSecond").on("click", function() {
            var t = $(this), e = $GH.validate({"#captcha": {required: "请输入验证码"}}), i = $("#captcha").val(), o = $("#encodeMobile").val();
            return e && $.ajax({type: "post",dataType: "json",data: {mobile: o,userId: $("#encodeUserId").val(),validcode: i,findPwdType: 1},cache: !1,url: t.attr("data-action"),success: function(e) {
                void 0 === e.hasError || e.hasError ? $GH.alert(e.message, "", function() {
                    e.returnUrl && (location.href = e.returnUrl)
                }) : location.href = t.attr("data-goto") + "?loginId=" + $("#encodeUserId").val() + "&imgCaptcha=" + $("#J_HiddenImgCaptcha").val() + "&smsCaptcha=" + i + "&mobile=" + o + "&findPwdType=1"
            },error: function(t, e) {
                return "abort" === e ? void $GH.alert("请求过于频繁，请求已中止") : void $GH.alert("操作失败，请稍后重试！")
            }}), !1
        }), $(".J_BackPwdSendCaptcha").on("click", function() {
            var t = $(this);
            $GH.mobileCode.basic($("#J_HiddenMobile").val(), "PWD_RESET_MOBILE", function() {
                t.countdown(function() {
                    t.text("重发")
                }, 60, "time秒后重发")
            })
        }), $(".J_RestPwd").on("click", function() {
            var t = $(this), e = $GH.validate({"#pwd": {required: "请输入密码",password: "密码格式不正确，请输入6-16位数字字母组成的密码"},"#repwd": {required: "请再输入一次密码",equal: function() {
                return $("#pwd").val() !== $("#repwd").val() ? "两次输入的密码不一致" : !0
            }}}), i = $("#userId").val(), o = $("#J_HiddenImgCaptcha").val();
            return e && $.ajax({type: "post",dataType: "json",data: {userId: $("#userId").val(),newpassword: $("#pwd").val(),repassword: $("#repwd").val(),mobile: $("#J_HiddenMobile").val(),smsCaptcha: $("#J_HiddenSmsCaptcha").val(),imgCaptcha: o},cache: !1,url: t.attr("data-action"),success: function(e) {
                void 0 === e.hasError || e.hasError ? $GH.alert(e.message, "", function() {
                    e.returnUrl && (location.href = e.returnUrl + "?loginId=" + i + "&imgCaptcha=" + o)
                }) : location.href = t.attr("data-goto") + "1"
            },error: function(t, e) {
                return "abort" === e ? void $GH.alert("请求过于频繁，请求已中止") : void $GH.alert("操作失败，请稍后重试！")
            }}), !1
        }), $(".J_BackPwdEmailSecond").on("click", function() {
            var t = $(this);
            return $.ajax({dataType: "json",data: {email: $("#encodeEmail").val(),userId: $("#encodeUserId").val(),imgCaptcha: $("#J_HiddenImgCaptcha").val(),findPwdType: 2},cache: !1,url: t.attr("data-action"),success: function(e) {
                void 0 === e.hasError || e.hasError ? $GH.alert(e.message) : location.href = t.attr("data-goto") + "2"
            },error: function(t, e) {
                return "abort" === e ? void $GH.alert("请求过于频繁，请求已中止") : void $GH.alert("操作失败，请稍后重试！")
            }}), !1
        })
    }), $GH.module("#J_AccountBind", function() {
        function t(t) {
            $.ajax({type: "post",dataType: "json",data: t.serialize(),cache: !1,url: t.attr("action"),success: function(t) {
                $GH.alert(t.message, "", function() {
                    t.returnUrl && "" != t.returnUrl && location.replace(t.returnUrl)
                })
            },error: function(t, e) {
                "abort" !== e && $GH.alert("提交失败，请稍后重试！")
            }})
        }
        if ($("#J_Send").on("click", function() {
                var t = $(this);
                if (!t.hasClass("off")) {
                    var e = $GH.validate({"#J_mobileIpt": {required: "手机号码不能为空",mobile: "手机号码格式不正确"}});
                    if (e) {
                        var i = $.trim($("#J_mobileIpt").val());
                        $GH.mobileCode.basic(i, $("#smsTypeIpt").val(), function() {
                            t.addClass("off").html("重新获取(<span>60</span>S)");
                            var e = t.find("span"), i = 60, o = setInterval(function() {
                                i--, 0 == i ? (t.removeClass("off").html("获取验证码"), clearInterval(o)) : e.text(i)
                            }, 1e3)
                        })
                    }
                }
                return !1
            }), 0 == $("#sendIpt").val()) {
            var e = $.trim($("#beforeMobileIpt").val());
            $("#J_mobileIpt").on("input", function() {
                e == $.trim($(this).val()) ? $(".J_CodeLine").hide() : $(".J_CodeLine").show()
            })
        }
        $("#J_NextBtn").on("click", function() {
            var t = {"#J_mobileIpt": {required: "手机号码不能为空",mobile: "手机号码格式不正确"}};
            if ($(".J_CodeLine").is(":visible") && (t["#mobileCodeIpt"] = {required: "短信验证码不能为空"}), $GH.validate(t)) {
                var e = $(this), i = $("#J_mobileIpt").val(), o = $("#mobileCodeIpt").val();
                $.ajax({type: "post",dataType: "json",data: {mobile: i,smsCaptcha: o,secret: $("#secret").val(),time: $("#time").val()},cache: !1,url: "/json/white/partners/check",success: function(t) {
                    void 0 === t.hasError || t.hasError ? $GH.alert(t.message) : e.closest("form").submit()
                },error: function(t, e) {
                    "abort" !== e && $GH.alert("提交失败，请稍后重试！")
                }})
            }
            return !1
        }), $("#J_BindBtn").on("click", function() {
            return t($(this).closest("form")), !1
        }), $("#J_RegBtn").on("click", function() {
            var e = $GH.validate({"#password": {required: "密码不能为空",password: "密码格式不正确，请输入6-16位数字、字母组成的密码"},"#agreement": {required: "请先同意协议才能注册"}});
            return e && t($(this).closest("form")), !1
        }), $(".J_Check").on("click", function() {
            return $(this).toggleClass("g-checkbox-checked"), $(this).toggleClass("g-checkbox"), $("#agreement").val($(this).hasClass("g-checkbox-checked") ? "1" : ""), !1
        })
    })
}), $(function() {
    $GH.module("#J_DoctorRecruit", function() {
        $(".J_Check").off("click").on("click", function() {
            return $(this).toggleClass("g-checkbox-checked"), $(this).toggleClass("g-checkbox"), $("#agreement").val($(this).hasClass("g-checkbox-checked") ? "1" : ""), !1
        }), $("#J_Submit").on("click", function() {
            var t = $GH.validate({"#agreement": {required: "您需要同意“微医网络医生薪资协议”才能加入"}});
            return t && $.ajax({type: "post",dataType: "json",data: {id: $("#doctorId").val(),confirmStatus: 1},cache: !1,url: $("#recruitForm").attr("action"),success: function(t) {
                return t ? void (void 0 === t.hasError || t.hasError ? $GH.alert(t.message) : $GH.alert("申请成功，等待审核", "", function() {
                    document.location.href = "wydoctor:gotoRegSuccessPage"
                })) : void $GH.alert("操作失败，请稍后重试！")
            },error: function(t, e) {
                "abort" !== e && $GH.alert("操作失败，请稍后重试！")
            }}), !1
        }), $("#J_Cancel").on("click", function() {
            return $GH.confirm("确定取消加入<br/>执业医生咨询团队？", [{name: "取消",style: "btn",fn: function(t) {
                t()
            }}, {name: "确定",style: "btn",fn: function(t) {
                t(), $.ajax({type: "post",dataType: "json",data: {id: $("#doctorId").val(),confirmStatus: 0},cache: !1,url: $("#recruitForm").attr("action"),success: function(t) {
                    void 0 === t.hasError || t.hasError ? $GH.alert(t.message) : document.location.href = "wydoctor:gotoRegSuccessPage"
                },error: function(t, e) {
                    "abort" !== e && $GH.alert("操作失败，请稍后重试！")
                }})
            }}]), !1
        })
    })
}), $GH.module("#J_BookingDoctorList", function() {
    var t = {officeId: 0,init: function() {
        var t = this;
        $(".J_DoctorList").length && (this.officeId = $("#J_HiddenOfficeId").val(), $(document).on("click", ".J_DoctorList li", function() {
            location.href = $(this).parent().parent().data("page") + $(this).data("id")
        }), $Common.pullUpScroll.init({initScrollCfg: {top: 40},scrollSelector: ".J_DoctorScroller",listSelector: ".J_DoctorList",loadingData: function(e, i) {
            var o = this, n = $(".J_DoctorList");
            $.ajax({type: "get",dataType: "json",cache: !1,data: {o: $("#J_HiddenOpen").val(),hdi: t.officeId,hospitalId: $("#J_HiddenHospitalId").val(),type: $("#J_HiddenType").val(),pageNo: e},url: n.data("action"),success: function(t) {
                t && t.data && i ? (o.totalCount = t.data.totalCount, $(".J_TotalCount").html(t.data.totalCount), i(t.data.list)) : i([])
            },error: function(t, e) {
                return "abort" === e ? void $GH.alert("请求过于频繁，请求已中止") : void $GH.alert("操作失败，请稍后再试！")
            }})
        },buildHtml: function(t) {
            return $Common.buildDoctorItem(t)
        }}))
    }};
    t.init()
}), $GH.module("#J_BookingHospitalList", function() {
    var t = {officeId: 0,init: function() {
        $(document).on("click", ".J_HospitalList li", function() {
            location.href = $(this).parent().parent().data("page") + $(this).data("id")
        }), $Common.pullUpScroll.init({pageSize: 10,initScrollCfg: {top: 40},scrollSelector: ".J_HospitalScroller",listSelector: ".J_HospitalList",loadingData: function(t, e) {
            var i = this, o = $(".J_HospitalList");
            $.ajax({type: "get",dataType: "json",cache: !1,data: {pageNo: t},url: o.data("action"),success: function(t) {
                t && t.list && t.list.length > 0 ? (i.totalCount = t.totalCount, $(".J_TotalCount").html(t.totalCount), e(t.list)) : e([])
            },error: function(t, e) {
                return "abort" === e ? void $GH.alert("请求过于频繁，请求已中止") : void $GH.alert("操作失败，请稍后再试！")
            }})
        },buildHtml: function(t) {
            return $Common.buildHospitalItem(t)
        }})
    }};
    t.init()
}), $GH.module("#J_SelectOffice", function() {
    var t = {hospitalId: 0,mainOffice: "",subOfficeId: 0,cacheData: null,init: function() {
        var t = this;
        $GH.loading.show(), this.hospitalId = $("#J_HiddenHospital").val(), this.subOfficeId = $("#J_HiddenOffice").val(), $(".J_GoHospital").on("click", function() {
            location.href = $(this).data("page") + t.hospitalId
        }), this.initMainOffice(function() {
            t.initScroller(function() {
                $GH.loading.hide()
            })
        })
    },initScroller: function(t) {
        var e = this;
        $Common.mulLevelSelect.init({defaultSubItem: e.subOfficeId,top: 50,loadSubData: function(t) {
            if (e.cacheData)
                for (var i = $(this).data("id"), o = 0; o < e.cacheData.length; o++) {
                    var n = e.cacheData[o];
                    if (n.key === i)
                        return void t(n.obj)
                }
        },buildHtml: function(t) {
            var e = t.text;
            return e.length > 9 && (e = e.substr(0, 9) + "..."), '<li data-id="' + t.value + '">' + e + "</li>"
        },onSubSelect: function() {
            location.href = $(this).closest(".J_SubScroller").data("page") + "?hospitalId=" + e.hospitalId + "&deptId=" + $(this).data("id") + "&o=" + $("#J_HiddenOpen").val()
        }}), "function" == typeof t && t()
    },initMainOffice: function(t) {
        var e = this;
        this.loadOffice(function(i) {
            if (!i || 0 === i.length)
                return void ("function" == typeof t && ($GH.alert("抱歉，没有数据！"), t()));
            for (var o = [], n = 0; n < i.length; n++) {
                var a = i[n];
                o.push('<li data-id="' + a.key + '">' + a.key + "</li>")
            }
            if ($(".J_MainScroller").find("ul").append(o.join("")), e.cacheData = i, e.subOfficeId) {
                for (var s = 0; s < i.length; s++) {
                    var r = i[s];
                    if (e.mainOffice)
                        break;
                    if (r.obj && r.obj.length)
                        for (var l = 0; l < r.obj.length; l++)
                            if (r.obj[l].value === e.subOfficeId) {
                                e.mainOffice = r.key;
                                break
                            }
                }
                $('.J_MainScroller li[data-id="' + e.mainOffice + '"]').addClass("current")
            }
            "function" == typeof t && t()
        })
    },loadOffice: function(t) {
        $.ajax({type: "get",dataType: "json",cache: !1,data: {hospitalId: this.hospitalId},url: $(".J_MainScroller").data("action"),success: function(e) {
            t(e && e.hospDepts)
        },error: function(t, e) {
            return "abort" === e ? void $GH.alert("请求过于频繁，请求已中止") : void $GH.alert("操作失败，请稍后再试！")
        }})
    }};
    t.init()
}), $GH.module("#J_SelectCity", function() {
    var t = {init: function() {
        var t = this, e = $("#J_HiddenProvince").val();
        e && $('.J_MainScroller li[data-id="' + e + '"]').addClass("current"), $Common.mulLevelSelect.init({defaultSubItem: $("#J_HiddenCity").val(),loadSubData: function(e) {
            var i = $(".J_SubScroller"), o = $(this).data("id");
            if ("hot" === o)
                return void e(window.$hotCity);
            if ("all" === o) {
                var n = "全国", a = "全国", s = "all", r = "all";
                return $GH.cookie.set("_area_ids", s + "_" + r, 90), $GH.cookie.set("_area_strs", encodeURIComponent(n) + "_" + encodeURIComponent(a), 90), void t.redirect()
            }
            $.ajax({type: "get",dataType: "json",cache: !1,url: i.data("action"),data: {areaId: o},success: function(t) {
                t && t.data && (t.data.splice(0, 0, {id: "all",name: "不限"}), e(t.data))
            },error: function(t, e) {
                return "abort" === e ? void $GH.alert("请求过于频繁，请求已中止") : void $GH.alert("操作失败，请稍后再试！")
            }})
        },buildHtml: function(t) {
            return t.isHot ? '<li data-province="' + t.provinceId + '" data-city="' + t.cityId + '">' + t.name + "</li>" : '<li data-id="' + t.id + '">' + t.name + "</li>"
        },onSubSelect: function() {
            var e = $(".J_MainScroller li.current").data("id"), i = $(".J_MainScroller li.current").text(), o = $(this).data("id"), n = $(this).text();
            "hot" === e && (e = $(this).data("province"), o = $(this).data("city"), i = "all" === e ? "全国" : $('.J_MainScroller li[data-id="' + e + '"]').text()), $GH.cookie.set("_area_ids", e + "_" + o, 90), $GH.cookie.set("_area_strs", encodeURIComponent(i) + "_" + encodeURIComponent(n), 90), t.redirect()
        }})
    },redirect: function() {
        var t = function(t, e) {
            return t + "?q=" + encodeURIComponent($("#J_HiddenQuery").val()) + "&" + e
        };
        setTimeout(function() {
            var e = "_=" + (new Date).getTime();
            switch ($("#J_HiddenFrom").val()) {
                case "fo":
                    e = "/fastorder/hospital?" + e;
                    break;
                case "hpt":
                    e = t("/search/hospital", e);
                    break;
                case "gd":
                    e = t("/gd/search/expert", e);
                    break;
                case "yzwy":
                    e = t("/yzwy/search", e);
                    break;
                default:
                    e = t("/search/expert", e)
            }
            location.href = e
        }, 100)
    }};
    t.init()
}), $GH.module("#J_CommonHospitalList", function() {
    var t = {officeId: 0,init: function() {
        $(document).on("click", ".J_HospitalList li", function() {
            location.href = $(this).parent().parent().data("page") + $(this).data("id")
        }), $Common.pullUpScroll.init({pageSize: 10,initScrollCfg: {top: 40},scrollSelector: ".J_HospitalScroller",listSelector: ".J_HospitalList",loadingData: function(t, e) {
            var i = this, o = $(".J_HospitalList");
            $.ajax({type: "get",dataType: "json",cache: !1,data: {pageNo: t},url: o.data("action"),success: function(t) {
                t.data && e && (i.totalCount = t.totalCount, e(t.data))
            },error: function(t, e) {
                return "abort" === e ? void $GH.alert("请求过于频繁，请求已中止") : void $GH.alert("操作失败，请稍后再试！")
            }})
        },buildHtml: function(t) {
            return $Common.buildHospitalItem(t)
        },afterRendered: function() {
            $(".J_Tips").show()
        }})
    }};
    t.init()
}), $GH.module("#J_shoutao-home", function() {
    var t = (new Swiper(".swiper-container", {pagination: ".pagination",loop: !0}), window.YulorePage);
    t && t.enableOrderButton($GC.guahaoServer + "/my/order/list")
}), $GH.module("#J_Case_List", function(t, e) {
    e.jump = function(t) {
        location.href = t
    }
}), $GH.module("#J_Case_GuahaoInfo", function(t, e) {
    var i = t.find("form").first();
    e.submit = function(t) {
        t.preventDefault();
        var e = $GH.validate({"#clinicDate": {required: "请选择就诊日期"},"#hospitalName": {required: "请填写医院名称"},"#hospDeptName": {required: "请填写科室名称"},"#doctorName": {required: "请填写医生名称"}});
        e && $.post(i.attr("action"), i.serialize(), function(t) {
            return t.hasError ? void $GH.alert(t.message) : ($GH.alert(t.message), void setTimeout(function() {
                location.href = t.returnUrl
            }, 2e3))
        }, "json")
    }
}), $GH.module("#J_CaseZhusu", function(t, e) {
    var i = t.find("form").first();
    e.status = {}, e.selectStatus = function() {
        new $GH.ActionSheet("", [{name: "已确诊",styleClass: "option",fn: function() {
            e.status.name = "已确诊", e.status.val = 1, e.$scan(), this.close()
        }}, {name: "未确诊",styleClass: "option",fn: function() {
            e.status.name = "未确诊", e.status.val = 2, e.$scan(), this.close()
        }}, {name: "取消",styleClass: "cancel",fn: function() {
            this.close()
        }}]).open()
    }, $GH.ImageUploader($(".J_ImageUp"), {inputName: "imagePath",uploaderUrl: window.$GC ? $GC.guahaoServer + "/json/black/image/upload?type=1" : ""}), i.on("submit", function(t) {
        t.preventDefault();
        var e = $GH.validate({"#diagnose": {required: "医生诊断不能为空"}});
        e && $.post(i.attr("action"), i.serialize(), function(t) {
            return t.hasError ? void $GH.alert(t.message) : ($GH.alert(t.message), void setTimeout(function() {
                location.href = t.returnUrl
            }, 2e3))
        }, "json")
    })
}), $GH.module("#J_CaseDetail", function(t) {
    t.find(".g-image-upload-box .preview").on("click", function() {
        $GH.ImageUploader($(this).parent(), {onlySlider: this})
    })
}), $GH.module("#J_CaseAdd", function(t) {
    var e = t.find("form");
    e.on("submit", function(t) {
        t.preventDefault();
        var i = $GH.validate({"#diagnose": {required: "请填写: 医生诊断"},"#enjoin": {required: "请填写: 医生嘱咐"}});
        i && $.post(e.attr("action"), e.serialize(), function(t) {
            return t.hasError ? void $GH.alert(t.message) : ($GH.alert(t.message), void setTimeout(function() {
                location.href = t.returnUrl
            }, 2e3))
        }, "json")
    }), $GH.ImageUploader($(".J_ImageUp1"), {inputName: "imagePath",uploaderUrl: window.$GC ? $GC.guahaoServer + "/json/black/image/upload?type=1" : ""}), $GH.ImageUploader($(".J_ImageUp2"), {inputName: "imagePath2",uploaderUrl: window.$GC ? $GC.guahaoServer + "/json/black/image/upload?type=1" : ""})
}), $GH.module("#J_CaseComplete", function(t, e) {
    var i = t.find(".J_Toggler"), o = t.find("form");
    i.on("click", function() {
        var t = $(this), e = t.data("toggler");
        t.toggleClass("g-arrow-u"), $(this).next(e).toggle()
    }), $GH.ImageUploader($(".J_ImageUp1"), {inputName: "imagePath",uploaderUrl: window.$GC ? $GC.guahaoServer + "/json/black/image/upload?type=1" : ""}), $GH.ImageUploader($(".J_ImageUp2"), {inputName: "imagePath2",uploaderUrl: window.$GC ? $GC.guahaoServer + "/json/black/image/upload?type=1" : ""}), t.find(".g-image-upload-box .preview").on("click", function() {
        $GH.ImageUploader($(this).parent(), {onlySlider: this})
    }), e.submit = function(t) {
        t.preventDefault();
        var e = $GH.validate({"#diagnose": {required: "请填写: 医生诊断"},"#enjoin": {required: "请填写: 医生嘱咐"}});
        e && $.post(o.attr("action"), o.serialize(), function(t) {
            return t.hasError ? void $GH.alert(t.message) : ($GH.alert(t.message), void setTimeout(function() {
                location.href = t.returnUrl
            }, 2e3))
        }, "json")
    }
}), $GH.module("#J_CaseFeedback", function(t, e) {
    var i = t.find("form").first();
    $GH.ImageUploader($(".g-image-upload-box"), {inputName: "imagePath",uploaderUrl: window.$GC ? $GC.guahaoServer + "/json/black/image/upload?type=1" : ""}), t.find(".J_Status_Select > a").on("click", function() {
        var e = $(this);
        e.addClass("selected").siblings().removeClass("selected"), t.find(".J_Status_Select_Value").val(e.data("val"))
    }), e.submit = function(t) {
        t.preventDefault(), $.post(i.attr("action"), i.serialize(), function(t) {
            return t.hasError ? void $GH.alert(t.message) : ($GH.alert(t.message), void setTimeout(function() {
                location.href = t.returnUrl
            }, 2e3))
        }, "json")
    }
}), $GH.module("#J_CaseHistory", function(t) {
    var e = t.find(".J_Vline");
    e.css({height: document.body.scrollHeight})
});
var $GS = {};
$GS.searchSuggest = function(t) {
    var e = {contextParams: {},scroll: null,cacheHistory: [],init: function() {
        var e = this;
        this.initSearchBar(), this.contextParams = t || {}, this.scroll = $GH.iScroll(".J_ListScroll", {top: this.contextParams.top || $(".J_Input").height() - 1,zIndex: 999}), $(".J_ListScroll").hide(), $(".J_ListScroll").on("touchmove", function() {
            $("#J_Keyword").blur()
        }), $(document).on("tap", ".J_SuggestList li", function() {
            e.redirect($(this).text())
        }), $(".J_Clear").on("click", function() {
            $("#J_Keyword").val("").focus()
        })
    },initSearchBar: function() {
        var t = this, e = $("#J_Keyword").val();
        e && e.length && ($("#J_Keyword")[0].selectionStart = $("#J_Keyword")[0].selectionEnd = e.length, $(".J_Clear").show()), $(".J_Clear").on("click", function() {
            $("#J_Keyword").val("").focus()
        }), $(".J_Search").on("click", function() {
            t.redirect($("#J_Keyword").val())
        }), $("#J_SearchForm").on("submit", function() {
            return t.redirect($("#J_Keyword").val()), !1
        }), $(".J_Cancel").on("click", function() {
            window.history.back(-1)
        }), $("#J_Keyword").on("input focus", function() {
            var e = $.trim($(this).val());
            e ? ($(".J_Clear").show(), t.loadSuggest()) : ($(".J_Clear").hide(), $(".J_ListScroll").hide())
        }), $("#J_Keyword").on("keydown", function(e) {
            13 === e.which && t.redirect($(this).val())
        }), $("#J_Keyword").on("blur", function() {
            $(".J_ListScroll").hide()
        })
    },redirect: function(t) {
        return t ? void (location.href = $("#J_Keyword").data("goto") + "?q=" + encodeURIComponent(t)) : void $GH.alert("请输入搜索关键词")
    },loadSuggest: function() {
        var t = $("#J_Keyword");
        if (t.val()) {
            var e = this;
            $.ajax({type: "get",dataType: "json",cache: !1,url: t.data("action"),data: {q: t.val()},success: function(t) {
                if (t) {
                    var i = t.suggest;
                    i && (i = i.hospital || i.doctor || i.disease, e.showSuggest(i))
                }
            },error: function(t, e) {
                return "abort" === e ? void $GH.alert("请求过于频繁，请求已中止") : void $GH.alert("操作失败，请稍后再试！")
            }})
        }
    },showSuggest: function(t) {
        if (t && t.length) {
            for (var e = [], i = 0; i < t.length; i++)
                e.push("<li>" + t[i].name + "</li>");
            $(".J_ListScroll").show(), $(".J_SuggestList").show().find("ul").empty().append(e.join("")), this.scroll.refresh()
        }
    }};
    e.init()
}, $GS.searchResult = function(t) {
    var e = {context: "",contextParams: {},cacheArea: {},cacheSort: {},cacheFilter: {},init: function() {
        var e = this;
        if (this.contextParams = t || {}, this.context = $("#J_Context").val(), this.context) {
            var i = $(window).height() - $(".J_ConsContainer").offset().top;
            $(".J_Cons span").on("click", function() {
                if ($(this).data("sx"))
                    return !1;
                $(this).siblings().removeClass("current"), $(this).addClass("current");
                var t = $(this).data("id");
                return 1 === t ? location.href = $(this).data("page") : 2 === t ? ($(".J_" + e.context + "Complex").show(), $(".J_" + e.context + "Filter").hide(), $(".J_ConsContainer").height(i).show()) : ($(".J_" + e.context + "Complex").hide(), $(".J_" + e.context + "Filter").show(), $(".J_ConsContainer").height(i).show()), !1
            }), $(".J_ConsContainer").on("click", function(t) {
                return $(t.target).closest(".J_Complex").length || $(t.target).closest(".J_Filter").length ? void 0 : ($(this).hide(), !1)
            }), this.initParams(), this["init" + this.context + "List"](), this.initSort(), this.initFilter()
        }
    },initSort: function() {
        var t = this;
        $(".J_Complex li").on("click", function() {
            $(this).siblings().removeClass("selected"), $(this).addClass(" selected"), t.cacheSort[t.context] = $(this).data("id"), $(".J_ComplexName").html($(this).text()), $(".J_" + t.context + "List").trigger("refreshList"), $(".J_Complex").hide(), $(".J_ConsContainer").hide()
        })
    },initFilter: function() {
        var t = this;
        $(".J_Filter .cancel").on("click", function() {
            $(this).closest(".J_Filter").hide();
            var e = t.cacheFilter[t.context];
            "Doctor" === t.context ? (t.setFilterData(".J_Exist", e.es), t.setFilterData(".J_DoctorLevel", e.dt)) : t.setFilterData(".J_HospitalLevel", e.hl), $(".J_ConsContainer").hide()
        }), $(".J_Filter .ok").on("click", function() {
            $(this).closest(".J_Filter").hide(), t.cacheFilter[t.context] = "Doctor" === t.context ? {es: $(".J_Exist .selected").data("id") || "",dt: $(".J_DoctorLevel .selected").data("id") || ""} : {hl: $(".J_HospitalLevel .selected").data("id") || "all"}, $(".J_ConsContainer").hide(), $(".J_" + t.context + "List").trigger("refreshList")
        }), $(".J_Filter li").on("click", function() {
            $(this).siblings().removeClass("selected"), $(this).addClass("selected"), $(this).parent().parent().prev().find(".status").text($(this).text())
        })
    },setFilterData: function(t, e) {
        $(t).find("li").removeClass("selected");
        var i = $(t).find('li[data-id="' + e + '"]');
        i.addClass("selected"), $(t).prev().find(".status").text(i.text())
    },initParams: function() {
        this.cacheArea[this.context] = $("#J_HiddenArea").val() || "";
        var t = {};
        try {
            var e = window.localStorage;
            t = e.getItem("searchParams_" + this.context), t = JSON.parse(t)
        } catch (i) {
            return void console.log("获取搜索缓存异常")
        }
        this.cacheSort[this.context] = t && t.sort || "2";
        var o = $(".J_" + this.context + 'Complex li[data-id="' + this.cacheSort[this.context] + '"]');
        if (o.length > 0 && (o.addClass("selected"), $(".J_ComplexName").html(o.text())), "Doctor" === this.context) {
            var n = t && t.es || "", a = t && t.dt || "";
            this.cacheFilter.Doctor = {es: n,dt: a}, this.setFilterData(".J_Exist", n), this.setFilterData(".J_DoctorLevel", a)
        } else {
            var s = t && t.hl || "all";
            this.cacheFilter.Hospital = {hl: s}, this.setFilterData(".J_HospitalLevel", s)
        }
    },storeParams: function(t) {
        var e = window.localStorage;
        if (e)
            try {
                e.setItem("searchParams_" + this.context, JSON.stringify(t))
            } catch (i) {
            }
    },getParams: function() {
        var t = this.context, e = {hid: $("#J_HiddenHospital").val() || "",q: $("#J_Keyword").val(),sort: this.cacheSort[t]};
        return "Doctor" === t ? (e.es = this.cacheFilter[t].es, e.dt = this.cacheFilter[t].dt) : e.hl = this.cacheFilter[t].hl, this.storeParams(e), e
    },initDoctorList: function() {
        var t = this;
        $(document).on("click", ".J_DoctorList li", function() {
            location.href = $(this).parent().parent().data("page") + "?expertId=" + $(this).data("id")
        }), $Common.pullUpScroll.init({pageSize: 10,initScrollCfg: {top: this.contextParams.top || 120,bottom: this.contextParams.bottom || 0},scrollSelector: ".J_DoctorScroller",listSelector: ".J_DoctorList",loadingData: function(e, i) {
            var o = this;
            1 === e && ($(".J_MainContent").hide(), $(".J_Loading").show());
            var n = t.getParams();
            n.page = e;
            var a = $(".J_DoctorList");
            $.ajax({type: "get",dataType: "json",cache: !1,data: n,url: a.data("action"),success: function(t) {
                if (t.data && 0 !== t.data.totalCount) {
                    $(".J_EmptyTips").hide(), $(".J_MainContent").show();
                    var n = t.data.totalCount;
                    o.totalCount = n, $(".J_TotalCouont").text(n), i && i(t.data.list)
                } else
                    1 === e && ($(".J_EmptyTips").show(), $(".J_MainContent").hide()), i && i([])
            },error: function(t, e) {
                return "abort" === e ? void $GH.alert("请求过于频繁，请求已中止") : void $GH.alert("操作失败，请稍后再试！")
            }})
        },buildHtml: function(e) {
            return (t.contextParams.buildDoctorItem || $Common.buildDoctorItem)(e)
        }})
    }};
    e.init()
}, $GH.module(".gp-daozhen-select", function(t) {
    var e = Number(document.body.scrollHeight - window.screen.availHeight);
    if (e > 0) {
        var i = window.screen.availHeight / 2;
        t.find(".box").height(i), t.find(".box").next("p").css({top: window.screen.availHeight / 2})
    }
}), $GH.module("#J_Daozhen_JB_1", function(t) {
    t.find(".J_Select > a").on("click", function() {
        var e = $(this);
        t.find(".J_Select > a").removeClass("selected"), e.addClass("selected")
    }), $GH.iScroll(".J_ListScroll", {top: 85}), $(".J_ListScroll a").on("click", function() {
        location.href = $(".J_ListScroll").data("page") + $(this).text() + "&hospitalId=" + ($("#J_HiddenHospital").val() || "")
    }), $(".J_Search").on("click", function() {
        location.href = $("#J_Keyword").data("page")
    })
}), $GH.module("#J_Daozhen_2", function(t, e) {
    var i = $GC.guahaoServer + "/guide/chooseDiagnose";
    e.diagnose = {}, e.select = function(t) {
        e.loading = !0, $GH.loading.show(), e.$scan(), $.post(i, {isSelect: t,diagnoseUuid: $("#diagnoseUuid").val()}, function(t) {
            return t.hasError ? void $GH.alert(t.message) : (e.diagnose = t.data.diagnoseItem, e.loading = !1, $GH.loading.hide(), void e.$scan())
        }, "json")
    }
}), $GH.module("#J_Daozhen_1", function() {
    var t = "_dz_inf", e = $GH.cookie.get(t), i = function(e) {
        var o = $.extend({}, {sex: 1,age: 25}, e || {});
        $.pgwModal({close: !1,confirm: !0,content: '<p class="sex">        <a href="#" class="sex-sel male J_SexSel" data-val="1">男</a>        <a href="#" class="sex-sel female J_SexSel" data-val="2">女</a>      </p><p class="number">        <span class="light">年龄</span>        <input type="tel" id="v_age" class="J_Age" maxlength="2">      </p>',confirmButtons: [{name: "确定",style: "btn",fn: function(o) {
            var n = {sex: $(".J_SexSel.on").data("val"),age: $(".J_Age").val(),hospitalId: $("#hospitalId").val()}, a = $.param(n);
            return isNaN(Number(n.age)) ? (o(), $GH.alert("年龄必须为数字"), void setTimeout(function() {
                i(e)
            }, 2e3)) : ($GH.cookie.set(t, n.sex + "," + n.age), void (location.search = "?" + a))
        }}],afterRender: function() {
            var t = $(".sex > .J_SexSel");
            t.on("click", function() {
                {
                    var e = $(this);
                    e.data("val")
                }
                t.removeClass("on"), e.addClass("on")
            }), 1 === Number(o.sex) && $(".sex > .male").addClass("on"), 2 === Number(o.sex) && $(".sex > .female").addClass("on"), $(".J_Age").val(o.age)
        }})
    };
    e ? ($(".J_Confirm_Modal").on("click", function() {
        var t = {sex: e.split(",")[0],age: e.split(",")[1]};
        i(t)
    }), $(".J_Filter").show()) : (i(), $(".J_Filter").hide())
}), $(function() {
    var t = {initScroll: function(t, e, i) {
        return $(t).length ? $GH.iScroll(t, {top: e || 0,bottom: i || 0}) : void 0
    },initFavorite: function() {
        $(".J_FavorDoctor").on("click", function() {
            var t = $(this), i = e.data("is-login");
            if (!i)
                return void (location.href = e.data("login-page"));
            var o = e.data("has-followed");
            $GH.loading.show(), $.ajax(o ? {type: "post",dataType: "json",cache: !1,url: e.data("unfollow"),data: {expertId: e.data("expert")},success: function(i) {
                i.hasError || (e.data("has-followed", !1), $GH.loading.hide(), $GH.alert("已取消关注"), t.addClass("on").text("关注"))
            },error: function(t, e) {
                return $GH.loading.hide(), "abort" === e ? void $GH.alert("请求过于频繁，请求已中止") : void $GH.alert("操作失败，请稍后再试！")
            }} : {type: "post",dataType: "json",cache: !1,url: e.data("follow"),data: {expertId: e.data("expert")},success: function(i) {
                i.hasError ? $GH.alert(i.message) : (e.data("has-followed", !0), $GH.loading.hide(), $GH.alert("关注成功"), t.removeClass("on").text("已关注"))
            },error: function(t, e) {
                return $GH.loading.hide(), "abort" === e ? void $GH.alert("请求过于频繁，请求已中止") : void $GH.alert("操作失败，请稍后再试！")
            }})
        })
    }}, e = $("#dispatcher");
    $(".J_FavorDoctor").length > 0 && t.initFavorite(), $GH.module("#J_DoctorHomeLanding", function(t) {
        var e = {init: function() {
            t.find(".J_Weixin").on("click", function() {
                return $(".J_WeixinShare").show(), !1
            }), t.find(".J_WeixinShare").on("click", function() {
                return $(".J_WeixinShare").is(":visible") && $(".J_WeixinShare").hide(), !1
            })
        }};
        e.init()
    }), $GH.module("#J_DoctorConsult", function(t, i) {
        $(".J_DoConsult").on("click", function() {
            var t = e.data("is-login");
            return t ? "1" !== $(".J_HiddenConsultLimit").val() ? ($GH.alert("您今天咨询" + $(".J_ExpertName").html() + "医生的次数已满，明天再提问吧"), !1) : void 0 : !0
        }), alight.filters.subName = function() {
            return function(t) {
                return t ? $GH.maskStr(t, 2, 3) : ""
            }
        }, alight.filters.subDate = function() {
            return function(t) {
                return t.substr(0, 10)
            }
        };
        var o = $GH.iScroll(".wrapper", {top: $(".J_DoctorInfo").height()}, {probeType: 2});
        i.totalCount = 0, i.historyList = [], i.getHistoryList = function(t) {
            i.pageNo = t, i.loading = !0, $GH.loading.show(), $.ajax({dataType: "json",cache: !1,data: {doctorUserId: e.data("expert"),pageNo: t},url: $GC.guahaoServer + "/json/white/bconsult/list",type: "get",success: function(t) {
                $GH.loading.hide(), i.loading = !1, t.map && t.map.localPageModel.list && (i.historyList = i.historyList.concat(t.map.localPageModel.list)), i.totalCount = t.map.localPageModel.totalCount, i.$scan(), o.refresh()
            },error: function() {
                $GH.loading.hide()
            }})
        }, i.getHistoryList(1), o.on("scroll", function() {
            i.historyList.length < i.totalCount && this.maxScrollY > this.y && !i.loading && (i.loading = !0, i.$scan(), i.getHistoryList(i.pageNo + 1))
        }), i.go = function(t) {
            location.href = $GC.guahaoServer + t
        }, $(".J_Invite").on("click", function() {
            var i = e.data("is-login");
            return i ? ($.ajax({type: "get",dataType: "json",cache: !1,url: t.data("invite-action"),success: function(t) {
                t.hasError ? $GH.alert(t.message) : $(".J_InviteCount").text(parseInt($(".J_InviteCount").text(), 10) + 1)
            },error: function() {
                $GH.alert("操作失败，请稍后再试！")
            }}), !1) : (location.href = e.data("login-page"), !1)
        })
    }), $GH.module("#J_DoctorHomeIntro", function(i, o) {
        o.isFavor = e.data("has-followed") || !1;
        var n = {init: function() {
            var e = t.initScroll(".J_IntroScroll", $(".J_DoctorInfo").height() + $(".J_HospitalLine").height() + 10);
            $(".J_ShowVoteList").on("click", function() {
                location.href = $(this).attr("data-page")
            }), $(".J_ShowFull").on("click", function() {
                var t = $(this).find(".J_MarkIcon");
                if (t.length) {
                    var i = $(this).find(".J_Full");
                    return i.length && (i.is(":visible") ? (t.removeClass("arrow-up"), t.addClass("arrow-down"), i.hide(), $(this).find(".J_Summary").show()) : (t.removeClass("arrow-down"), t.addClass("arrow-up"), i.show(), $(this).find(".J_Summary").hide()), e && e.refresh()), !1
                }
            })
        }};
        n.init(o)
    }), $GH.module("#J_DoctorHomeBooking", function() {
        var t = {scroll: null,doctorId: 0,officeId: 0,init: function() {
            var t = this;
            $(".J_BookingList").length && (this.doctorId = $(".J_BookingList").data("doctor"), this.officeId = $(".J_OfficeList li.current").data("office"), $(".J_BookingScroll").length && this.initScroll(), $(".J_Rules").on("click", function() {
                $(".J_MoreRule").toggle(), $(".J_MoreIcon").toggleClass("arrow-down-thin"), $(".J_MoreIcon").toggleClass("arrow-up-thin"), t.scroll && t.scroll.refresh()
            }), $(document).on("click", ".J_BookingList li", function() {
                if ($(this).hasClass("enable")) {
                    var t = $(this).data("url");
                    location.href = t ? $GC.guahaoServer + $(this).data("url") : e.data("login-page")
                } else
                    $GH.alert("当前排班不可预约")
            }), $(".J_OfficeList li").on("click", function() {
                $(this).siblings().removeClass("current"), $(this).addClass("current"), t.officeId = $(this).data("office"), t.loadingSchedule(t.doctorId, t.officeId)
            }), this.loadingSchedule(t.doctorId, t.officeId))
        },loadingSchedule: function(t, e, i) {
            var o = this, n = $(".J_BookingList");
            $.ajax({type: "get",dataType: "json",cache: !1,data: {doctorId: t,officeId: e},url: n.data("action"),success: function(t) {
                t && ("99" === t.returnFlag ? $(".J_LoadingTip").html("您访问过于频繁，请5分钟后再试") : (o.renderContent(t.schedules), o.renderRules(t), o.scroll.refresh()), "function" == typeof i && i())
            },error: function(t, e) {
                return "abort" === e ? void $GH.alert("请求过于频繁，请求已中止") : void $GH.alert("操作失败，请稍后再试！")
            }})
        },renderContent: function(t) {
            var e = $(".J_BookingList"), i = e.find(".J_LoadingTip");
            if (i.show(), e.find("ul").remove(), !t || !t.length)
                return void i.text("暂无排班信息").show();
            for (var o = function(t, e, i) {
                var o = t[e];
                if (o) {
                    var a = ["截止", "停诊", "已满", "已满", "预约"];
                    n.push('<li class="' + (4 === o.status ? "enable" : "disable") + '" data-url="' + o.url + '">'), n.push('<div class="item-info">'), n.push('<div class="date">' + t.date + " " + t.week + " " + i + "</div>"), n.push('<div class="fee">' + o.clinicType + " " + o.price.toFixed(2) + "元</div>"), n.push("</div>"), n.push('<div class="action">' + a[o.status] + "</div>"), n.push("</li>")
                }
            }, n = ["<ul>"], a = 0; a < t.length; a++) {
                var s = t[a];
                o(s, "morning", "上午"), o(s, "afternoon", "下午"), o(s, "evening", "晚上"), o(s, "fl", "全天")
            }
            n.push("</ul>"), i.hide(), e.append(n.join(""))
        },renderRules: function(t) {
            $(".J_UpdateTime").html(t.openTime);
            var e = t.reaservationRule;
            if (e && e.length) {
                for (var i = [], o = [], n = [], a = 1, s = 0; s < e.length; s++) {
                    var r = e[s];
                    "医院规则：" !== r ? "科室规则：" !== r ? "医生规则：" !== r ? 1 === a ? i.push(r) : 2 === a ? o.push(r) : n.push(r) : a = 3 : a = 2 : a = 1
                }
                var l = "", c = function(t, e) {
                    if (!e.length)
                        return "";
                    var i = [];
                    return i.push('<div class="hospital-more">'), i.push('<div class="title">' + t + "</div>"), i.push('<div class="txt">' + e.join("") + "</div>"), i.push("</div>"), i.join("")
                };
                l += c("医院规则", i) + c("科室规则", o) + c("医生规则", n), $(".J_MoreRule").empty().append(l)
            }
        },initScroll: function() {
            var t, e = this, i = 0;
            t = document.querySelector(".g-pullDown"), i = t ? t.offsetHeight : 0, $(".J_Scroller").css({top: -1 * parseInt(i, 10)});
            var o = $(".J_BookingNotice").height();
            this.scroll = $GH.iScroll(".J_BookingScroll", {top: $(".J_DoctorInfo").height() + $(".J_HospitalLine").height() + (o ? o + 5 : 0)}, {probeType: 1,deceleration: 2e-4}), this.scroll.on("scroll", function() {
                this.y >= 50 && t && !t.className.match("flip") ? (t.className = "g-pullDown flip", t.querySelector(".g-pullDownLabel").innerHTML = "释放即可刷新...", this.minScrollY = 0) : this.y <= 50 && t && t.className.match("flip") && (t.className = "g-pullDown", t.querySelector(".g-pullDownLabel").innerHTML = "下拉即可刷新...", this.minScrollY = -i)
            }), this.scroll.on("scrollEnd", function() {
                t && t.className.match("flip") && ($(".J_Scroller").css({top: 0}), t.className = "g-pullDown g-loading", t.querySelector(".g-pullDownLabel").innerHTML = "正在努力加载...", e.loadingSchedule(e.doctorId, e.officeId, function() {
                    t && t.className.match("g-loading") && (t.className = "g-pullDown", t.querySelector(".g-pullDownLabel").innerHTML = "下拉即可刷新...", $(".J_Scroller").css({top: -1 * parseInt(i, 10)}))
                }))
            })
        }};
        t.init()
    }), $GH.module("#J_DoctorHomeExperience", function() {
        var t = {filterType: "",diseaseInited: !1,init: function() {
            var t = this;
            $Common.pullUpScroll.init({initScrollCfg: {top: $(".J_DoctorInfo").height() + $(".J_TotalInfo").height() + $(".J_Filters").height() + 10},scrollSelector: ".J_ExperienceScroll",listSelector: ".J_ExpList",loadingData: function(e, i) {
                var o = this, n = $(".J_ExpList"), a = t.getParams(e);
                $.ajax({type: "get",dataType: "json",cache: !1,data: a,url: n.data("action") + "/1-" + a.diseaseId,success: function(e) {
                    if (e.map && i) {
                        var n = e.map.localPageModel.totalCount;
                        0 === n ? ($(".J_EmptyTips").show(), $GH.loading.hide(), t.diseaseInited || $(".J_Cons span").addClass("disabled")) : ($(".J_EmptyTips").hide(), o.totalCount = n, $(".J_TotalCount").text(n), i(e.map.localPageModel.list), t.diseaseInited || t.initDiseaseList(e.map.searchCommentDO.searchCommentDiseaseDOs))
                    } else
                        $GH.loading.hide(), $(".J_EmptyTips").show()
                },error: function(t, e) {
                    return "abort" === e ? void $GH.alert("请求过于频繁，请求已中止") : void $GH.alert("操作失败，请稍后再试！")
                }})
            },buildHtml: function(t) {
                return $Common.buildVoteItem(t)
            }})
        },getParams: function(t) {
            var e = {page: t,diseaseId: this.diseaseId || "0",commentType: this.commentType || "all"};
            return e
        },initDiseaseList: function(t) {
            if (!this.diseaseInited) {
                var e = ['<li data-id="0" class="selected">全部疾病</li>'];
                if (t)
                    for (var i = t.length > 7 ? 7 : t.length, o = 0; i > o; o++) {
                        var n = t[o];
                        n.count < 3 || e.push('<li data-id="' + n.diseaseId + '">' + n.diseaseName + "</li>")
                    }
                $(".J_DiseaseList").append(e.join("")), this.diseaseInited = !0, this.initFilter()
            }
        },initFilter: function() {
            var t = this, e = $(window).height() - $(".J_ConsContainer").offset().top;
            $(".J_Cons span").on("click", function() {
                var i = $(this).data("type");
                return $(this).hasClass("arrow-up") ? ($(".J_" + i + "Complex").hide(), $(this).removeClass("arrow-up"), !1) : ($(this).siblings().removeClass("arrow-up"), $(this).addClass("arrow-up"), t.filterType = i, $(".J_Complex").hide(), $(".J_" + i + "Complex").show(), $(".J_ConsContainer").height(e).show(), !1)
            }), $(".J_Complex li").on("click", function() {
                $(this).siblings().removeClass("selected"), $(this).addClass(" selected");
                var e = $(this).data("id");
                return $(".J_Complex" + t.filterType + "Name").html($(this).text()).removeClass("arrow-up"), "Disease" === t.filterType ? t.diseaseId = e : t.commentType = e, $(".J_ExpList").trigger("refreshList"), $(".J_Complex").hide(), $(".J_ConsContainer").hide(), !1
            }), $(".J_ConsContainer").on("click", function(t) {
                return $(t.target).closest(".J_Complex").length || $(t.target).closest(".J_Filter").length ? void 0 : ($(this).hide(), !1)
            })
        }};
        t.init()
    }), $GH.module("#J_DoctorHomePublish", function() {
        $Common.pullUpScroll.init({initScrollCfg: {top: $(".J_DoctorInfo").height()},scrollSelector: ".J_PublishListScroll",listSelector: ".J_PublishList",loadingData: function(t, e) {
            var i = this, o = $(this.options.listSelector);
            $.ajax({type: "get",dataType: "json",cache: !1,data: {page: t},url: o.data("action"),success: function(t) {
                if (t.data && e) {
                    var o = t.data.totalCount;
                    0 === o ? ($(".J_EmptyTips").show(), e([])) : ($(".J_EmptyTips").hide(), e(t.data.items)), i.totalCount = o, $(".J_TotalCount").text(o)
                } else
                    $(".J_EmptyTips").show(), e([])
            },error: function(t, e) {
                return "abort" === e ? void $GH.alert("请求过于频繁，请求已中止") : void $GH.alert("操作失败，请稍后再试！")
            }})
        },buildHtml: function(t) {
            var i = [];
            i.push("<li>");
            var o = t.gmtModified;
            o = o.split("-");
            var n = ["一", "二", "三", "四", "五", "六", "七", "八", "九", "十", "十一", "十二"];
            i.push('<div class="date"><span class="month">' + n[parseInt(o[1], 10) - 1] + '月</span><span class="day">' + o[2] + "</span></div>"), i.push('<div class="message">');
            var a = t.content, s = !!t.expertArticleId;
            a.length > 75 || s ? (i.push('<div class="txt has-more">'), s && i.push('<span class="title">' + t.expertArticleTitle + "</span>"), i.push(s ? '<a href="/expert/article/detail/' + t.expertArticleId + '">' + a.substr(0, 75) + "...</a>" : '<a href="/expert/publishDetail/' + e.data("expert") + "?id=" + t.publishId + '">' + a.substr(0, 75) + "...</a>"), i.push("</div>")) : i.push('<div class="txt">' + a + "</div>"), i.push('<div class="imgs">');
            var r = t.imagePathList;
            if (r && r.length)
                for (var l = 0; l < r.length; l++)
                    i.push('<img class="preview" src="' + r[l] + '" data-index="' + l + '">');
            return i.push("</div>"), i.push("</div>"), i.push("</li>"), i.join("")
        },afterRendered: function() {
            $(".imgs").off("click", ".preview"), $(".imgs").on("click", ".preview", function() {
                $GH.ImageUploader($(this).parent(), {onlySlider: this})
            })
        }})
    }), $GH.module("#J_DoctorHomeVote", function() {
        var e = $(".J_DoVote").length ? $(".J_DoVote").height() : 0;
        t.initScroll(".J_VoteListScroll", 55, e)
    }), $GH.module("#J_DoctorVoteDetail", function() {
        $Common.pullUpScroll.init({scrollSelector: ".J_ExperienceScroll",listSelector: ".J_ExpList",loadingData: function(t, e) {
            var i = this, o = $(".J_ExpList");
            $.ajax({type: "get",dataType: "json",cache: !1,data: {page: t},url: o.data("action"),success: function(t) {
                if (t.map && e) {
                    var o = t.map.localPageModel.list;
                    if (!o.length)
                        return;
                    var n = t.map.localPageModel.totalCount;
                    i.totalCount = n, $(".J_DiseaseInfo").text(o[0].diseaseName + "(" + n + "票)"), e(o)
                }
            },error: function(t, e) {
                return "abort" === e ? void $GH.alert("请求过于频繁，请求已中止") : void $GH.alert("操作失败，请稍后再试！")
            }})
        },buildHtml: function(t) {
            return $Common.buildVoteItem(t)
        }})
    }), $GH.module("#J_DoctorVote", function() {
        $Common.doVote()
    }), $GH.module("#J_ShareExperience", function() {
        $Common.doVote(), $(".J_ReasonList a").on("click", function() {
            $(this).siblings().removeClass("current"), $(this).addClass("current"), 3 === $(this).data("id") ? ($(".J_OtherTip").hide(), $("#J_HiddenReason").val("").show(), setTimeout(function() {
                $("#J_HiddenReason").focus()
            }, 100)) : ($(".J_OtherTip").show(), $("#J_HiddenReason").hide().val($(this).text()))
        }), $(".J_SubmitReason").on("click", function() {
            return $("#J_HiddenReason").val() ? void $GH.formSubmit($("#J_ReasonForm")) : ($GH.alert("请填写未就医原因"), void (3 === $(".J_ReasonList a.current").data("id") && setTimeout(function() {
                $("#J_HiddenReason").focus()
            }, 100)))
        })
    }), $GH.module("#J_ConsultVote", function() {
        $Common.initStarsVote(), $(".J_Submit").on("click", function() {
            $("#J_DoVoteForm").submit()
        }), $("#J_DoVoteForm").on("submit", function() {
            var t = ($(this), $GH.validate({"#manner": {required: "请为医生态度评分"},"#effect": {required: "请为咨询效果评分"}}));
            return t && $("#J_DoVoteForm").submit(), !1
        })
    }), $GH.module("#J_PatientApply", function(t) {
        $(".J_PatientList a").on("click", function() {
            var t = $(this);
            if (!t.hasClass("J_DoAdd"))
                return t.hasClass("current") ? t.removeClass("current") : $.ajax({type: "get",dataType: "json",cache: !1,url: t.data("action"),success: function(e) {
                    if ("2" === e.data)
                        $GH.alert(t.text() + "已经是该医生患者");
                    else if ("1" === e.data) {
                        var i = t.data("id");
                        $GH.confirm(t.text() + "已提交过申请<br/>是否再次申请？", [{name: "取消",style: "btn",fn: function(t) {
                            t()
                        }}, {name: "再次申请",style: "btn",fn: function(t) {
                            t(), location.href = $(".J_Next").data("goto") + "?patientId=" + i
                        }}])
                    } else
                        t.siblings().removeClass("current"), t.addClass("current")
                },error: function(t, e) {
                    return "abort" === e ? void $GH.alert("请求过于频繁，请求已中止") : void $GH.alert("操作失败，请稍后再试！")
                }}), !1
        }), $(".J_Next").on("click", function() {
            var t = $(".J_PatientList a.current");
            return t.length ? void (location.href = $(this).data("goto") + "?patientId=" + t.data("id")) : void $GH.alert("请选择就诊人")
        });
        var e = function() {
            return t.find("img.preview").length
        };
        $GH.ImageUploader($(".g-image-upload-box"), {uploadBtn: ".upload-btn",fileInput: ".file-input",inputName: "imagePath",uploaderUrl: window.$GC.guahaoServer + "/json/black/image/upload?type=1",afterComplete: function() {
            e() > 0 && $(".J_Showmeonfileuploaded").hide(), 9 === e() && $(".upload-btn").hide()
        },afterDelete: function() {
            e() <= 9 && $(".upload-btn").show(), 1 === e() && $(".J_Showmeonfileuploaded").show()
        }}), $(".J_Save").on("click", function() {
            var t = $GH.validate({".GJ_DateValue": {required: "请选择就诊日期"},"#disease": {required: "请填写所患疾病"}});
            t && $("#J_ApplyForm").submit()
        }), $("#J_ApplyForm").on("submit", function() {
            return $.ajax({type: "post",dataType: "json",cache: !1,url: $(this).attr("action"),data: $(this).serialize(),success: function(t) {
                $GH.alert("提交成功，请耐心等待", null, function() {
                    location.href = $GC.guahaoServer + t.returnUrl
                })
            },error: function(t, e) {
                return "abort" === e ? void $GH.alert("请求过于频繁，请求已中止") : void $GH.alert("操作失败，请稍后再试！")
            }}), !1
        })
    }), $GH.module("#J_HospitalAppraise", function() {
        var t = {init: function() {
            $Common.pullUpScroll.init({initScrollCfg: {top: 70},scrollSelector: ".J_ExperienceScroll",listSelector: ".J_ExpList",loadingData: function(t, e) {
                var i = this, o = $(".J_ExpList");
                $.ajax({type: "get",dataType: "json",cache: !1,data: {page: t},url: o.data("action"),success: function(t) {
                    t.map && e && (i.totalCount = t.map.commentExpertQuery.totalRecord, e(t.map.commentExpertVOList))
                },error: function(t, e) {
                    return "abort" === e ? void $GH.alert("请求过于频繁，请求已中止") : void $GH.alert("操作失败，请稍后再试！")
                }})
            },buildHtml: function(t) {
                return $Common.buildVoteItem(t)
            }})
        }};
        t.init()
    })
}), function() {
    $GH.module("#J_EteamIntro", function() {
        $("#J_Swiper").height($(window).height() - $("#gh").height()), new Swiper("#J_Swiper", {mode: "vertical",onSlideChangeEnd: function(t) {
            t.activeIndex == t.slides.length - 1 && (t.destroy(), $("#J_Swiper").css("height", "auto"), $("#J_Swiper .swiper-wrapper").attr("style", ""), $("#J_Swiper .s1,#J_Swiper .s2,#J_Swiper .s3").remove(), $("#J_Swiper .s4").css("height", "auto"), $("#J_Nav").remove())
        }}), $("#J_Contact").on("click", function() {
            var t = $(this);
            return $GH.confirm("您确认要组建/加入专家团队吗？", [{name: "取消",style: "btn",fn: function(t) {
                t()
            }}, {name: "确定",style: "btn",fn: function(e) {
                e(), $.ajax({url: t.attr("href"),success: function() {
                    $.pgwModal({content: '<div class="g-msg"><h4>申请已提交</h4>稍后会有微医秘书与您取得联系</div>',popup: !0,close: !1,confirm: !0,customClass: "eteam-call-modal",confirmButtons: [{name: "取消",style: "btn",fn: function(t) {
                        t()
                    }}, {name: "确定",style: "btn",fn: function(t) {
                        t()
                    }}]})
                },error: function() {
                    $GH.alert("服务异常，稍后重试")
                }})
            }}]), !1
        })
    }), $GH.module("#J_EteamHome", function() {
        $("#J_Toggle").on("click", function() {
            return $(this).parent().toggleClass("expand"), !1
        }), $("#J_Join").on("click", function() {
            return $.ajax({url: $(this).attr("href"),success: function(t) {
                $GH.alert(t.message)
            },error: function() {
                $GH.alert("服务异常，稍后重试")
            }}), !1
        })
    })
}(), $GH.module("#J_Myzx", function(t, e) {
    $("body").css({backgroundColor: "#fff"}), e.source = t.find(".meta > .left"), e.source.text().length > 10 && e.source.text(e.source.text().replace(/[\S\s]+附属/, "")), e.showMore = function() {
        $("#sh-title").hide(), $("#sh-detail").hide(), $("#sh-content").show()
    }, alight.directives.al.autoSize = function(t, e) {
        var i = function() {
            var i = $(t).width(), o = $(t).height(), n = $(t).parent().width();
            "img" === e && i >= n && ($(t).css({marginRight: 0}), $(t).width(n).height(o * (n / i))), "img" === e && n > i && $(t).css({marginRight: "10px","float": "left"}), "video" === e && $(t).width(n).height(o * (n / i))
        };
        window.onresize = i, i()
    }
}), $GH.module("#J_FxYsdtPage", function() {
    var t = $("#J_YsdtTmpl").html();
    $Common.pullUpScroll.init({scrollSelector: ".J_YsdtScroller",pageSize: 6,listSelector: ".J_YsdtList",loadingData: function(t, e) {
        var i = this, o = $(".J_YsdtList");
        $.ajax({type: "get",dataType: "json",cache: !1,data: {pageNo: t},url: o.data("action"),success: function(t) {
            t.data.recordCount ? i.totalCount = t.data.recordCount : $(".J_Empty").show(), e && e(t.data.items)
        },error: function(t, e) {
            return "abort" === e ? void $GH.alert("请求过于频繁，请求已中止") : void $GH.alert("操作失败，请稍后再试！")
        }})
    },buildHtml: function(e) {
        return $GH.alTmpl(t, e)
    },afterRendered: function() {
        $(".g-image-upload-box").off("click", ".preview"), $(".g-image-upload-box").on("click", ".preview", function() {
            $GH.ImageUploader($(this).parent(), {onlySlider: this})
        })
    }})
}), $GH.module("#J_Homepage", function() {
    setTimeout(function() {
        var t = $(window).height() - $("#gh").height() - $("#gf").height() - $("#J_SearchEmbed").height() - $("#J_Modules").height() - 10;
        t > $("#J_Banner").height() && $("#J_Banner").css("height", t), $("#J_Banner").css("visibility", "visible"), $("#J_Modules").css("visibility", "visible").addClass("kf-zoomIn kf-animated")
    }, 10);
    var t = window.YulorePage;
    t && t.enableOrderButton($GC.guahaoServer + "/my/order/list")
}), $GH.module("#J_HomepageV1", function(t, e) {
    new Swiper("#J_Swiper", {pagination: ".pagination",visibilityFullFit: !0,calculateHeight: !0}), e.hospitalList = [], e.loading = !0, e.getHospitalList = function(t) {
        e.pageNo = t, $.ajax({url: $GC.guahaoServer + "/json/white/fastorder/hospitals",dataType: "json",data: {latitude: e.latitude,longitude: e.longitude,provinceId: "",cityId: "",sort: "distance",distance: 10,pageNo: t},error: function() {
            e.loading = !1, e.$scan()
        },success: function(t) {
            return e.loading = !1, t ? (e.hospitalList = t.list.slice(0, 3), void e.$scan()) : (e.loading = !1, void e.$scan())
        }})
    };
    var i = $GH.cookie.get("_latlong");
    if (i) {
        var o = i.split(",");
        e.latitude = o[0], e.longitude = o[1], e.getHospitalList(1)
    } else
        navigator.geolocation ? navigator.geolocation.getCurrentPosition(function(t) {
            e.latitude = t.coords.latitude, e.longitude = t.coords.longitude, e.getHospitalList(1), $GH.cookie.set("_latlong", e.latitude + "," + e.longitude, 5)
        }, function() {
            e.latitude = "", e.longitude = "", e.getHospitalList(1)
        }, {enableHighAccuracy: !0,timeout: 5e3,maximumAge: 0}) : (e.latitude = "", e.longitude = "", e.getHospitalList(1));
    var n = window.YulorePage;
    n && n.enableOrderButton($GC.guahaoServer + "/my/order/list")
}), $GH.module("#J_Hosp_Pos", function(t, e) {
    e.hospitalList = [], e.loading = !0, $GH.loading.show(), e.pageCount = 1, e.msg = "";
    var i = $GH.iScroll(".wrapper", {top: 0}, {probeType: 2});
    e.getHospitalList = function(t) {
        e.pageNo = t, $GH.loading.show(), $.ajax({url: $GC.guahaoServer + "/json/white/fastorder/hospitals",dataType: "json",data: {latitude: e.latitude,longitude: e.longitude,provinceId: "",cityId: "",sort: "distance",distance: 10,pageNo: t},error: function() {
            $GH.loading.hide(), e.loading = !1, e.$scan()
        },success: function(t) {
            return $GH.loading.hide(), e.loading = !1, t ? (e.hospitalList = e.hospitalList.concat(t.list), "" === e.msg && 0 == e.hospitalList.length && (e.msg = "附近暂无开通在线预约挂号的医院"), e.pageCount = t.pageCount, e.$scan(), void i.refresh()) : (e.loading = !1, void e.$scan())
        }})
    }, i.on("scroll", function() {
        e.pageNo < e.pageCount && this.maxScrollY > this.y && !e.loading && (e.loading = !0, e.$scan(), e.getHospitalList(e.pageNo + 1))
    }), navigator.geolocation ? navigator.geolocation.getCurrentPosition(function(t) {
        e.latitude = t.coords.latitude, e.longitude = t.coords.longitude, e.getHospitalList(1), $GH.cookie.set("_latlong", e.latitude + "," + e.longitude, 5)
    }, function() {
        e.msg = "无法获取定位，请检查网络和定位设置", e.latitude = "", e.longitude = "", e.getHospitalList(1)
    }, {enableHighAccuracy: !0,timeout: 5e3,maximumAge: 0}) : (e.msg = "无法获取定位", e.latitude = "", e.longitude = "", e.getHospitalList(1))
}), $GH.module("#J_EArticle_List", function(t, e) {
    e.expertId = t.data("eid"), e.loading = !0, e.articleList = [], e.pageNo = 1, e.pageCount = 1, $GH.loading.show(), e.page = function() {
        $.ajax({url: $GC.guahaoServer + "/json/white/expert/article/" + e.expertId,dataType: "json",data: {pageNo: e.pageNo},error: function() {
            $GH.loading.hide(), e.loading = !1
        },success: function(i) {
            return $GH.loading.hide(), e.loading = !1, i.hasError ? (e.$scan(), void $GH.alert(i.message)) : (e.pageCount = i.data.totalPage, e.articleList = e.articleList.concat(i.data.expertArticleList), e.$scan(), void (t.height() < window.screen.availHeight && e.pageCount > e.pageNo && (e.loading = !0, e.pageNo++, e.$scan(), e.page())))
        }})
    }, e.page(), window.onscroll = function() {
        this.scrollY + this.screen.availHeight + 20 >= document.body.scrollHeight && e.pageCount > e.pageNo && (e.loading = !0, e.pageNo++, e.$scan(), e.page())
    }
}), $GH.module("#J_Article_List", function(t, e) {
    alight.filters.snapshot = function() {
        return function(t) {
            return t.replace(/<\/?[^>]*>/g, "").substring(0, 30) + " .."
        }
    }, alight.filters.htmlentitiesDecode = function() {
        return function(t) {
            var e = document.createElement("textarea");
            return e.innerHTML = t, e.value
        }
    }, alight.filters.ts2date = function() {
        return function(t) {
            return new Date(t)
        }
    }, e.hospitalId = t.data("hid"), e.typeId = t.data("tid"), e.loading = !0, e.articleList = [], e.pageNo = 1, e.pageCount = 1, e.defaultImg = $GC.staticServer + "/h5/img/hos-article.png", $GH.loading.show(), e.detail = function(t) {
        location.href = $GC.guahaoServer + "/hospital/article/detail/" + t + "?type=" + e.typeId
    }, "0" === e.typeId && (document.title = "医院文章", $("#gh > h1").text("医院文章"), e.defaultImg = $GC.staticServer + "/h5/img/hos-article-jkjt.png"), e.page = function() {
        $.ajax({url: $GC.guahaoServer + "/json/white/hospital/article/" + e.hospitalId,dataType: "json",data: {pageNo: e.pageNo,type: e.typeId},error: function() {
            $GH.loading.hide(), e.loading = !1
        },success: function(i) {
            var o = [];
            return $GH.loading.hide(), e.loading = !1, i.hasError ? (e.$scan(), void $GH.alert(i.message)) : i.data && i.data.hospitalArticleList ? (e.pageCount = i.data.totalPage, $.each(i.data.hospitalArticleList, function(t, i) {
                i.pageNo = e.pageNo, i.picture = i.picture && "" != i.picture ? $GC.imageServer + i.picture : e.defaultImg, o.push(i)
            }), e.articleList = e.articleList.concat(o), e.$scan(), void (t.height() < window.screen.availHeight && e.pageCount > e.pageNo && (e.loading = !0, e.pageNo++, e.$scan(), e.page()))) : void e.$scan()
        }})
    }, e.page(), window.onscroll = function() {
        this.scrollY + this.screen.availHeight + 20 >= document.body.scrollHeight && e.pageCount > e.pageNo && (e.loading = !0, e.pageNo++, e.$scan(), e.page())
    }
}), $GH.module("#J_ReportSelectCase", function(t, e) {
    e.save = function(t) {
        $.get(t, function(t) {
            $GH.alert(t.message, 2e3, function() {
                location.href = t.returnUrl
            })
        }, "json")
    }
}), $GH.module("#J_DaohangMap", function(t) {
    var e, i = function() {
        t.find("lbs-map").css({height: document.body.scrollHeight - 45})
    };
    alight.filters.oneTel = function() {
        return function(t) {
            return -1 !== t.indexOf(",") ? t.split(",")[0] : t
        }
    }, window.onresize = i, i(), (e = function() {
        var i, o = t.find(".info-box"), n = t.find(".lbs-map-wrapper"), a = t.find(".J_Panel");
        o.length > 0 ? (o.hide(), n.css({opacity: 1}), i = o.find(".tohere").attr("href"), a.find(".J_BaiduNav").attr("href", i), a.show()) : setTimeout(function() {
            e()
        }, 500)
    })()
}), $GH.module("#J_AddCardPage", function(t) {
    function e(t) {
        var t = t || $("#J_PatientSel").val();
        $.ajax({url: "/json/black/getcardinfo?hospitalId=" + o + "&patientId=" + t,cache: !1,success: function(e) {
            i[t].init = !0, e.hasError ? (i[t].jzk = "", $("#J_CardTypeSel").trigger("change")) : (i[t].jzk = e.data.card_no ? e.data.card_no : "", $("#J_CardTypeSel").trigger("change"))
        }})
    }
    t.find(".J_PatientsDropDown").dropdownSheet($("#J_PatientSel option").length < 6 ? {name: "添加就诊人",fn: function() {
        return this.close(), location.href = $GC.guahaoServer + "/my/patient/add?backUrl=" + location.href, !1
    }} : null);
    var i = function() {
        var t = {};
        return $("#J_PatientSel").find("option").each(function() {
            var e = $(this);
            t[e.val()] = {init: !1,ybk: e.attr("data-values") ? e.attr("data-values") : ""}
        }), t
    }(), o = $("#hospitalIdIpt").val();
    e(), $("#J_CardTypeSel").on("change", function() {
        var t = $(this), e = $("#J_PatientSel").val(), o = $("#cardNoIpt");
        o.val(1 == t.val() ? i[e].ybk : i[e].jzk)
    }), $("#J_PatientSel").on("change", function() {
        var t = $(this);
        return i[t.val()].init ? $("#J_CardTypeSel").trigger("change") : e(t.val()), !1
    }), t.find("#J_Submit").on("click", function() {
        var t = $(this), e = t.closest("form"), i = $GH.validate({"#cardNoIpt": {required: "卡号不能为空"}});
        return i && $GH.formSubmit(e), !1
    })
}), $GH.module("#J_HospitalHomepage", function(t, e) {
    var i = t.find(".J_Marker");
    e.fid = null, e.favorite = function(t, o, n) {
        n && (e.fid = n, e.$scan()), i.hasClass("on") ? new $GH.ActionSheet("取消关注?", [{name: "确定",styleClass: "option",fn: function() {
            var t = this;
            $.ajax({url: $GC.guahaoServer + "/json/black/favorite/del/" + e.fid,dataType: "json",success: function(e) {
                e.hasError ? $GH.alert(e.message) : (i.removeClass("on").removeClass("active"), t.close())
            }})
        }}, {name: "取消",styleClass: "cancel",fn: function() {
            this.close()
        }}]).open() : $.get($GC.guahaoServer + "/json/black/favorite/hospital/" + t, {hospname: o}, function(t) {
            t.hasError ? $GH.alert(t.message) : (i.addClass("on"), e.fid = t.data.rid, e.$scan(), $GH.alert("关注成功"))
        }, "json")
    }
}), function() {
    $GH.module("#J_JiahaoAdd", function(t) {
        t.find(".J_AdjustWidth").each(function() {
            var t = $(this);
            t.find(".input-box").css("margin-left", t.find(".nowidth").width() + 5 + "px")
        }), t.find(".J_PatientsDropDown").dropdownSheet($("#J_PatientSel option").length < 6 ? {name: "添加就诊人",fn: function() {
            return this.close(), location.href = $GC.guahaoServer + "/my/patient/add?backUrl=" + location.href, !1
        }} : null);
        var e = ["周日", "周一", "周二", "周三", "周四", "周五", "周六"];
        t.find(".J_DP").each(function() {
            var t = $(this), i = t.find(".J_DPTxt"), o = t.find(".J_DPVal");
            t.datepicker({onSelect: function(t) {
                var n = new Date;
                n.setFullYear(t[0], t[1] - 1, t[2]), i.html(t[1] + "-" + t[2] + " " + e[n.getDay()]).removeClass("ph"), o.val(t.join("-"))
            }})
        }), $(".J_DatePicker").datepicker({onSelect: function(t) {
            $(".J_ShowDate").html(t[0] + "年" + t[1] + "月" + t[2] + "日").removeClass("ph"), $(".J_DateValue").val(t.join("-"))
        }}), $("#J_Submit").on("click", function() {
            function e() {
                var t = !0;
                if (from = $(".J_DPValFrom").val().split("-"), to = $(".J_DPValTo").val().split("-"), 3 == from.length && 3 == to.length) {
                    var e = new Date;
                    e.setFullYear(from[0], from[1] - 1, from[2]), toDate = new Date, toDate.setFullYear(to[0], to[1] - 1, to[2]), e.getTime() > toDate.getTime() && (t = !1, $GH.alert("期望就诊时间段不正确"))
                }
                return t
            }
            var i = {"#J_PatientSel": {required: "就诊人不能为空"},"#content": {required: "请输入您的病情",check: function(t) {
                return t.length < 10 || t.length > 500 ? "病情描述长度范围：10到500字" : !0
            }}};
            return $GH.validate(i) && e() && t.find("form")[0].submit(), !1
        });
        var i = function() {
            return t.find("img.preview").length
        };
        $GH.ImageUploader($(".g-image-upload-box"), {inputName: "imagePath",uploaderUrl: $GC.guahaoServer + "/json/black/image/upload?type=4",afterComplete: function() {
            i() > 0 && $(".J_Showmeonfileuploaded").hide(), 9 === i() && $(".upload-btn").hide()
        },afterDelete: function() {
            i() <= 9 && $(".upload-btn").show(), 1 === i() && $(".J_Showmeonfileuploaded").show()
        }})
    }), $GH.module("#J_JiahaoList", function(t, e) {
        e.loading = !0, e.itemList = [], $GH.loading.show(), $Common.pullUpAngularScroll.init({initScrollCfg: {top: 0},scrollSelector: ".J_Scroller",pageSize: 6,listSelector: ".J_ScrollerList",loadingData: function(t, i) {
            var o = this;
            $.get("/json/black/jiahao/list", {pageNo: t,pageSize: 6}, function(t) {
                return t.hasError ? void $GH.alert(t.message) : (t.map && t.map.localPageModel && (t.map.localPageModel.list && (e.itemList = e.itemList.concat(t.map.localPageModel.list)), o.pageCount = t.map.localPageModel.pageCount), e.loading = !1, $GH.loading.hide(), e.$scan(), void (i && i()))
            }, "json")
        }})
    })
}(), $GH.module("#J_Focus_Msg", function(t, e) {
    var i = {getList: $GC.guahaoServer + "/json/black/dpmessage/list",updateStatus: $GC.guahaoServer + "/json/black/dp/update"};
    e.pageNo = 1, e.loading = !0, e.pageCount = 1, e.itemList = [], e.$scan(), $GH.loading.show(), e.page = function() {
        $.get(i.getList, {pageNo: e.pageNo}, function(t) {
            return t.hasError ? void $GH.alert(t.message) : (e.itemList = e.itemList.concat(t.data.list), e.loading = !1, $GH.loading.hide(), e.pageCount = t.data.pageCount, void e.$scan())
        }, "json")
    }, e.clean = function() {
        $GH.confirm("是否清空所有消息", [{name: "取消",style: "btn",fn: function(t) {
            t()
        }}, {name: "确定",style: "btn",fn: function(t) {
            e.itemList = [], e.$scan(), t()
        }}])
    }, e.update = function(t, i, o) {
        $.get($GC.guahaoServer + "/json/black/dp/update", {expertId: t.expertId,patientId: t.patientId,applyId: t.id,applyStatus: i}, function(t) {
            return t.hasError ? void $GH.alert(t.message) : (e.itemList[o].applyStatus = i, void e.$scan())
        })
    }, $(window).on("scroll", function() {
        e.loading || document.body.scrollHeight == document.body.scrollTop + window.screen.availHeight && e.pageCount > e.pageNo && (e.loading = !0, e.pageNo++, e.$scan(), e.page())
    }), e.page()
}), $GH.module("#J_Focus", function(t, e) {
    var i, o = {doctorUrl: $GC.guahaoServer + "/json/black/follow/expertlist",hospitalUrl: $GC.guahaoServer + "/json/black/favorite/hospitallist"};
    $GH.loading.show(), e.pageNo = 1, e.loading = !0, e.pageCount = 1, e.itemList = [], e.recommendHospitalList = [], alight.filters.shortCount = function() {
        return function(t) {
            return $Common.shortCount(t)
        }
    }, e.page = function(t, o) {
        $.get(t, {pageNo: e.pageNo}, function(n) {
            return n.hasError ? void $GH.alert(n.message) : (e.loading = !1, $GH.loading.hide(), e.pageCount = n.map.pageCount ? n.map.pageCount : n.map.totalPage, n.map.followExpertList && (e.itemList = e.itemList.concat(n.map.followExpertList)), n.map.favoriteHospitalList && (e.itemList = e.itemList.concat(n.map.favoriteHospitalList)), n.map.recommendHospitalList && (e.recommendHospitalList = e.recommendHospitalList.concat(n.map.recommendHospitalList)), e.$scan(), e.itemList.length > 0 && (o && o(), i.on("scroll", function() {
                e.pageCount > e.pageNo && this.maxScrollY >= this.y && !e.loading && (e.loading = !0, e.pageNo++, e.$scan(), e.page(e.url, function() {
                    i.refresh()
                }))
            })), void (e.pageCount > e.pageNo && i.scrollerHeight == i.wrapperHeight && (e.loading = !0, e.pageNo++, e.$scan(), e.page(t, function() {
                i.refresh()
            }))))
        }, "json")
    }, -1 !== location.href.indexOf("expertlist") && (e.url = o.doctorUrl, e.page(o.doctorUrl, function() {
        i = $GH.iScroll(".g-doctor-list", {top: 45 + $(".msg-link").height()}, {probeType: 2})
    }), e.expert = function(t) {
        location.href = $GC.guahaoServer + "/expert/" + t
    }), -1 !== location.href.indexOf("hospitallist") && (e.url = o.hospitalUrl, e.page(o.hospitalUrl, function() {
        i = $GH.iScroll(".g-hospital-list", {top: 45}, {probeType: 2})
    }), e.hospital = function(t) {
        location.href = $GC.guahaoServer + "/hospital/" + t
    })
}), $GH.module("#J_Account_Info", function() {
    $GH.ImageUploader($(".avatar"), {inputName: "imagePath",uploaderUrl: $GC.guahaoServer + "/json/black/image/upload?type=3",uploadBtn: ".upload-btn",fileInput: ".file-input",beforeComplete: function() {
        $GH.alert("头像上传中请稍候..")
    },afterUpload: function(t) {
        return t.hasError ? void $GH.alert(t.message) : ($(".avatar").find("img")[0].src = t.map.imageServerPath + "/" + t.map.path + "?_=" + (new Date).getTime(), void $.post($GC.guahaoServer + "/json/black/headpicupload", {imgUrl: t.map.sourcePath}, function(t) {
            t.hasError || $GH.alert("头像上传成功！")
        }, "json"))
    }})
}), $GH.module("#J_BackclinicDetail", function(t, e) {
    var i = $GH.getQuery(location.search), o = i.mid, n = i.sid, a = t.data("did"), s = $GH.iScroll(".wrapper", {}, {probeType: 2});
    e.loading = !0, e.pageCount = 0, e.pageNo = 1, e.chatList = [], $GH.loading.show(), $("body").css({backgroundColor: "#fff"}), e.genDate = function(t) {
        return $GH.genDate(t)
    }, alight.filters.beauty = function() {
        var t = new Date;
        return function(i) {
            var o = new Date(i.split(" "));
            return o.getFullYear() == t.getFullYear() ? e.genDate(o) : i
        }
    }, e.page = function() {
        $.get($GC.guahaoServer + "/json/black/dconsult/detail", {pageNo: e.pageNo,sid: n,mid: o}, function(t) {
            return t.hasError ? void $GH.alert(t.message) : (e.chatList = t.map.localPageModel.list.concat(e.chatList), e.age = t.map.age, e.sex = t.map.sex, e.loading = !1, $GH.loading.hide(), e.pageCount = t.map.localPageModel.pageCount, e.$scan(), void e.refresh())
        })
    }, s.on("scroll", function() {
        e.pageNo < e.pageCount && this.y > 30 && !e.loading && (e.loading = !0, e.pageNo++, e.$scan(), e.page())
    }), e.refresh = function(i) {
        var o = t.find(".J_Input_Ctrl"), n = t.find(".wrapper"), a = n.find(".scroll");
        o.find(".text-input").css({width: document.body.scrollWidth - 170 + "px"}), o.find(".send-btn").attr("disabled", "disabled"), s.refresh(), e.pageNo > 1 && !i || s.scrollTo(0, n.height() - a.height(), 500)
    }, $GH.ImageUploader($(".J_Input_Ctrl"), {uploadBtn: ".upload-btn",fileInput: ".file-input",uploaderUrl: $GC.guahaoServer + "/json/black/image/upload?type=2",afterUpload: function(t) {
        r(t.map)
    }}), e.imageShow = function(t) {
        $GH.ImageUploader($(t.target).parent(), {onlySlider: t.target})
    };
    var r = function(i, o) {
        var n = t.find(".text-input");
        $.post($GC.guahaoServer + "/json/black/dconsult/todoctor", {content: o || "",imagePath: i ? i.sourcePath : "",doctorUserId: a,patientId: e.chatList[0].patientId,contentType: i ? 1 : 0}, function(t) {
            return t.hasError ? void $GH.alert(t.message) : (e.chatList = e.chatList.concat([{date: e.genDate(new Date),text: o || "",image: i ? i.imageServerPath + "/" + i.path : "",userType: 0}]), e.textMsg = "", e.$scan(), e.refresh(!0), void n.focus())
        }, "json")
    };
    e.inputText = function(i) {
        var o = t.find(".send-btn");
        e.textMsg && "" !== e.textMsg ? (o.removeAttr("disabled"), 13 === i.keyCode && r(null, e.textMsg)) : o.attr("disabled", "disabled")
    }, e.send = function(t) {
        r(null, t)
    }, e.page()
}), $GH.module("#J_Backclinic", function(t, e) {
    var i = $GH.iScroll(".wrapper", {}, {probeType: 2});
    e.loading = !0, e.pageCount = 0, e.itemList = [], e.pageNo = 1, e.page = function() {
        $.get($GC.guahaoServer + "/json/black/dconsult/list", {pageNo: e.pageNo}, function(t) {
            return t.hasError ? void $GH.alert(t.message) : void (t.map.localPageModel && (e.pageCount = t.map.localPageModel.pageCount, e.itemList = e.itemList.concat(t.map.localPageModel.list), e.loading = !1, e.$scan(), i.refresh()))
        }, "json")
    }, i.on("scroll", function() {
        e.pageCount > e.pageNo && this.maxScrollY > this.y && !e.loading && (e.loading = !0, e.pageNo++, e.$scan(), e.page())
    }), e.page()
}), $GH.module("#J_PatientPage", function(t) {
    t.find(".J_Submit").on("click", function() {
        var t = $(this), e = t.closest("form"), i = $GH.validate({"#patient_name": {required: "姓名不能为空",chinese: "姓名必须为中文"},"#patient_cert_no": {required: "身份证不能为空"},"#patient_sex": {required: "性别不能为空"},"#patient_birthday": {required: "年龄不能为空",check: function(t) {
            return 0 == /^([1-9]\d|\d)$/.test(t) ? "年龄只能输入数字0~99" : !0
        }},"#patient_mobile": {required: "手机号不能为空",mobile: "手机号格式不正确"},"#old_password": {required: "旧密码不能为空",password: "旧密码格式不正确"},"#new_password": {required: "新密码不能为空",password: "新密码格式不正确"}});
        return i && $GH.formSubmit(e), !1
    }), t.find(".J_Del").on("click", function() {
        var t = $(this), e = t.closest("form");
        $GH.confirm("确定删除该就诊人吗？", [{name: "是",style: "btn",fn: function(t) {
            t(), $GH.formSubmit(e)
        }}, {name: "否",style: "btn",fn: function(t) {
            t()
        }}])
    }), t.find(".J_AddDelDefault").on("click", function() {
        var t = $(this);
        form = t.closest("form"), t.hasClass("g-arrow-f") ? (t.removeClass("g-arrow-f"), t.addClass("g-arrow-s"), form.find("#IsDefault").val(!0)) : (t.removeClass("g-arrow-s"), t.addClass("g-arrow-f"), form.find("#IsDefault").val(!1))
    }), t.find(".J_setDefault").on("click", function() {
        var t = $(this);
        $.post($GC.guahaoServer + "/json/black/my/updateisdefault/" + t.data("patientid"), function(e) {
            if ("500" == e.code)
                $GH.alert(e.message);
            else {
                if (e.hasError)
                    return void $GH.alert(e.message);
                $GH.alert(e.message), t.off("click"), t.css({cursor: "default"}), t.removeClass("g-arrow-f J_setDefault").addClass("g-arrow-s")
            }
        }, "json")
    })
}), $GH.module("#J_AccountAuth", function(t) {
    t.find(".J_Submit").on("click", function() {
        var t = $(this), e = t.closest("form"), i = $GH.validate({"#patient_name": {required: "姓名不能为空",chinese: "姓名必须为中文"},"#patient_cert_no": {required: "身份证不能为空"}});
        return i && $GH.formSubmit(e), !1
    }), t.find(".J_Del").on("click", function() {
        var t = $(this), e = t.closest("form");
        $GH.confirm("确定删除该就诊人吗？", [{name: "是",style: "btn",fn: function(t) {
            t(), $GH.formSubmit(e)
        }}, {name: "否",style: "btn",fn: function(t) {
            t()
        }}])
    }), t.find(".J_AddDelDefault").on("click", function() {
        var t = $(this);
        form = t.closest("form"), t.hasClass("g-arrow-f") ? (t.removeClass("g-arrow-f"), t.addClass("g-arrow-s"), form.find("#IsDefault").val(!0)) : (t.removeClass("g-arrow-s"), t.addClass("g-arrow-f"), form.find("#IsDefault").val(!1))
    }), t.find(".J_setDefault").on("click", function() {
        var t = $(this);
        $.post($GC.guahaoServer + "/json/black/my/updateisdefault/" + t.data("patientid"), function(e) {
            if ("500" == e.code)
                $GH.alert(e.message);
            else {
                if (e.hasError)
                    return void $GH.alert(e.message);
                $GH.alert(e.message), t.off("click"), t.css({cursor: "default"}), t.removeClass("g-arrow-f J_setDefault").addClass("g-arrow-s")
            }
        }, "json")
    })
}), $GH.module("#J_MobileUpdatePage", function(t) {
    t.find(".J_MobileUpdate").on("click", function() {
        var e = $.trim($("#mobile").val()), i = $GH.validate({"#mobile": {required: "手机号不能为空",mobile: "手机号格式不正确"}});
        return i && $GH.mobileCode.updateProfile(e, function() {
            t.find("#J_Step1").hide(), t.find("#J_Step2").show(), t.find(".J_mobileTxt").text($GH.maskStr(e, 3, 7))
        }), !1
    }), t.find(".J_MobileSubmit").on("click", function() {
        var t = $(this), e = t.closest("form"), i = $GH.validate({"#code": {required: "验证码不能为空"}});
        return i && $GH.formSubmit(e), !1
    });
    var e = function() {
        $(".J_CountDownTip").show(), $(".J_CountDown").countdown(function() {
            $(".J_CountDownTip").hide(), $(".J_Resend").show()
        }, 60, "time")
    };
    e(), t.find(".J_Resend").on("click", function() {
        $GH.mobileCode.updateProfile($("#mobile").val(), function() {
            $(".J_Resend").hide(), e()
        })
    })
}), $GH.module("#J_FeedbackPage", function(t) {
    $(".J_ImgCaptcha").on("click", function() {
        return $GH.refreshCaptcha($(this).find("img")), !1
    }), t.find(".J_Submit").on("click", function() {
        var t = $(this), e = t.closest("form"), i = $GH.validate({"#frommail": {required: "邮箱地址不能为空",email: "邮箱地址格式不正确"},"#frommobile": {required: "手机号码不能为空",mobile: "手机号格式不正确"},"#content": {required: "意见内容不能为空"},"#validCode": {required: "验证码不能为空"}});
        return i && $GH.formSubmit(e, {error: function(t) {
            $GH.alert(t.message), $GH.refreshCaptcha($(".J_ImgCaptcha").find("img"))
        }}), !1
    })
}), function() {
    function t(t) {
        new $GH.ActionSheet("就医经验", [{name: "是，我已就诊",styleClass: "option",fn: function() {
            location.href = $GC.guahaoServer + "/commentexpert/orderconfirm/" + t.attr("data-id"), this.close()
        }}, {name: "否，还未就诊",styleClass: "option",fn: function() {
            location.href = $GC.guahaoServer + "/commentexpert/ordernotreated/" + t.attr("data-id"), this.close()
        }}, {name: "取消",styleClass: "cancel",fn: function() {
            this.close()
        }}]).open()
    }
    $GH.module("#J_OrderinfoPage", function(e) {
        e.find(".J_OrderCancel").on("click", function() {
            var t = $(this);
            return $GH.confirm("确定取消订单吗？", [{name: "是",style: "btn",fn: function(e) {
                $.ajax({dataType: "json",cache: !1,url: "/json/black/ordercancel/" + t.attr("data-id") + "/" + t.attr("data-pay"),success: function(t) {
                    e(), void 0 === t.hasError || t.hasError ? t.message && "" != t.message && $GH.alert(t.message) : window.location.reload(!0)
                },error: function(t, e) {
                    return "abort" === e ? void $GH.alert("请求过于频繁，请求已中止") : void $GH.alert("系统异常，请稍后重试！")
                }})
            }}, {name: "否",style: "btn",fn: function(t) {
                t()
            }}]), !1
        }), e.find(".J_Resend").on("click", function(t) {
            var e = $(this);
            return $GH.mobileMsg.orderResend(e.attr("data-id"), function() {
                $("<span class='g-gray'>已补发短信</span>").insertBefore(e), e.remove()
            }), t.stopPropagation(), !1
        }), e.find(".J_Share").on("click", function(e) {
            return t($(this)), e.stopPropagation(), !1
        })
    }), $GH.module("#J_OrdersPage", function() {
        $(".J_OrderList").on("click", "li", function(e) {
            var i = $(e.target);
            if (i.hasClass("J_Share"))
                t(i);
            else if (i.hasClass("J_Resend")) {
                var o = i;
                $GH.mobileMsg.orderResend(o.attr("data-id"), function() {
                    $("<label>已补发短信</label>").insertBefore(o), o.remove()
                })
            } else
                location.href = $(this).data("page");
            return !1
        });
        var e = $("#J_OrderTmpl").html();
        $Common.pullUpScroll.init({initScrollCfg: {top: 0},scrollSelector: ".J_OrdersScroller",pageSize: 6,listSelector: ".J_OrderList",loadingData: function(t, e) {
            var i = this, o = $(".J_OrderList");
            $.ajax({type: "get",dataType: "json",cache: !1,data: {pageNo: t},url: o.data("action"),success: function(t) {
                $(".J_NeedPay,.J_NotTreatment,.J_NotConfirm").find("span").remove(), t.map.needPay && "0" != t.map.needPay && $("<span/>", {text: t.map.needPay}).appendTo($(".J_NeedPay")), t.map.notTreatment && "0" != t.map.notTreatment && $("<span/>", {text: t.map.notTreatment}).appendTo($(".J_NotTreatment")), t.map.notConfirm && "0" != t.map.notConfirm && $("<span/>", {text: t.map.notConfirm}).appendTo($(".J_NotConfirm")), t.map.totalCount ? (i.pageCount = t.map.pageCount, e && e(t.map.orderList)) : ($(".J_Empty").show(), $GH.loading.hide())
            },error: function(t, e) {
                return "abort" === e ? void $GH.alert("请求过于频繁，请求已中止") : void $GH.alert("操作失败，请稍后再试！")
            }})
        },buildHtml: function(t) {
            return $GH.alTmpl(e, t)
        }})
    }), $GH.module("#J_BookOrderPage", function(t) {
        function e(t) {
            $.ajax({url: "/json/black/res/firsthosp/" + t + "/" + r,cache: !1,success: function(e) {
                if (!e.hasError) {
                    var i = e.data.visitType ? e.data.visitType : 0;
                    s[t].init = !0, s[t].jzk = e.data.carValue ? e.data.carValue : "", s[t].visitType = i, $("select#J_VisitType").val(i).trigger("change")
                }
            }})
        }
        function i(t) {
            var e = (new Date).getTime();
            return e - t >= 3e5 ? void $GH.alert("短信验证超时，请点击'重发短信'进行验证.") : (a = $("#J_Step2").find("#hdecodeIpt").val(), void $.ajax({dataType: "json",cache: !1,url: "/json/white/uplink/check/" + $("#J_PatientSel").val() + "/" + $("#shiftCaseIdIpt").val() + "/" + a,success: function(e) {
                e.hasError ? (3 == e.code && $GH.alert(e.message), 2 == e.code && setTimeout(function() {
                    i(t)
                }, 500)) : (e.data && e.data.hdecode3 && (a += md5(e.data.hdecode3)), n.find("input[name=hdecode]").val(a), setTimeout(function() {
                    n.submit()
                }, 100))
            },error: function() {
                $GH.alert("系统异常，请稍后重试")
            }}))
        }
        function o(t, e, o) {
            e.hasClass("off") || $.ajax({dataType: "json",cache: !1,url: t,success: function(t) {
                t.hasError ? ($GH.alert(t.message), o && o()) : ($GH.alert("短信发送成功！"), startTime = (new Date).getTime(), i(startTime), o && o())
            },error: function() {
                $GH.alert("下行短信接口不通畅！请点击重发短信"), o && o()
            }})
        }
        var n = t.find("form"), a = "";
        t.find(".J_PatientsDropDown").dropdownSheet($("#J_PatientSel option").length < 6 ? {name: "添加就诊人",fn: function() {
            return this.close(), location.href = $GC.guahaoServer + "/my/patient/add?backUrl=" + location.href, !1
        }} : null);
        var s = function() {
            var t = {};
            return $("#J_PatientSel").find("option").each(function() {
                var e = $(this), i = e.attr("data-values").split("|");
                t[e.val()] = {init: e.is(":selected") ? !0 : !1,mobile: i[0],ybk: i[1],jzk: i[2],visitType: i[3]}
            }), t
        }(), r = $("#hospitalIdIpt").val();
        t.find(".J_AdjustWidth").each(function() {
            var t = $(this);
            t.find(".input-box").css("margin-left", t.find(".nowidth").width() + 5 + "px")
        }), $("select#J_VisitType").on("change", function() {
            var t = $(this).val();
            return $(".J_CardInfo").hide(), $(".J_CardInfo_" + t).show().find(".J_CardTypeSel").val(1).trigger("change"), !1
        }).trigger("change"), $("#J_PatientSel").on("change", function() {
            var t = $(this);
            return s[t.val()].init ? $("select#J_VisitType").val(s[t.val()].visitType).trigger("change") : e(t.val()), !1
        }).trigger("change"), $(".J_CardTypeSel").on("change", function() {
            var t = $("#J_PatientSel").val(), e = $(this), i = $(".J_CardInfo_" + $("#J_VisitType").val()).find(".J_CardNo");
            1 == e.val() ? i.val(s[t].ybk) : "text" == i.attr("type") && i.val(s[t].jzk)
        }), $("#J_Submit1").on("click", function() {
            var t = $("#J_VisitType").val(), e = {"#agentNameIpt": {required: "陪同人姓名不能为空",chinese: "姓名必须为中文"},"#agentCardNOIpt": {required: "陪同人身份证不能为空"},"#agentTelNumberIpt": {required: "手机号不能为空",mobile: "手机号格式不正确"}}, o = ".J_ExtraField_" + t;
            if ($(o).each(function() {
                    var t = $(this), i = t.attr("data-label"), n = t.attr("data-tip") ? i + "：" + t.attr("data-tip") : i + "格式错误", a = t.attr("data-index");
                    e[o + "_" + a] = {}, t.attr("data-required") && (e[o + "_" + a].required = i + "不能为空"), t.attr("data-pattern") && (e[o + "_" + a].regex = function(e) {
                        return e && !new RegExp(t.attr("data-pattern")).test(e) ? n : !0
                    })
                }), !$GH.validate(e))
                return !1;
            var n = ($(this).closest("form"), "encodePatientId=" + $("#J_PatientSel").val());
            return $.each(["#J_VisitType", "#expertIdIpt", "#shiftCaseIdIpt", "#signdataIpt", "#hospitalIdIpt"], function() {
                var t = $(this);
                n += "&" + t.attr("name") + "=" + t.val()
            }), $(".J_CardInfo_" + t).find("input,select").each(function() {
                var t = $(this);
                "" != t.attr("name") && (n += "&" + t.attr("name") + "=" + encodeURIComponent(t.val()))
            }), $.ajax({dataType: "json",cache: !1,url: "/json/black/res/jumpto?" + n,success: function(t) {
                if (!t.hasError && t.data) {
                    if (t.data.mobile = s[$("#J_PatientSel").val()].mobile, t.data.hdecode = md5(t.data.hdecode || ""), $("#J_Step2").empty().append($GH.alTmpl($("#J_Step2Tmpl").html(), t.data)).show(), $("#J_Step2").find(".J_CountDown").countdown(function() {
                            var t = this.parent().empty();
                            t.text("获取验证码").removeClass("off")
                        }, 60, "time"), 1 == t.data.focusExpert && 1 == t.data.focusExpertVerify) {
                        var e = (new Date).getTime();
                        i(e)
                    }
                    $("#J_Step1").hide()
                } else
                    $GH.alert(t.message || "出错了！"), t.data && "Y" == t.data.over_max && (location.href = $GC.guahaoServer + "/my/reservation/failed?m=" + encodeURIComponent("该手机号当天接收挂号网下发的短信量已达上限，请次日尝试预约"))
            },error: function(t, e) {
                return "abort" === e ? void $GH.alert("请求过于频繁，请求已中止") : void $GH.alert("系统异常，请稍后重试！")
            }}), !1
        }), $("#J_Step2").on("click", ".J_SendXx", function() {
            var t = $(this);
            return t.hasClass("off") || $GH.mobileCode.book($("#J_PatientSel").val(), $("#shiftCaseIdIpt").val(), $("#J_Step2").find("#hdecodeIpt").val(), function() {
                t.empty().append('<em class="time J_CountDown">60</em>秒后重新发送').addClass("off"), t.find(".J_CountDown").countdown(function() {
                    var t = this.parent().empty();
                    t.text("获取验证码").removeClass("off")
                }, 60, "time")
            }), !1
        }), $("#J_Step2").on("click", ".J_SendVoice", function() {
            var t = $(this);
            return t.hasClass("off") || $GH.mobileCode.book($("#J_PatientSel").val(), $("#shiftCaseIdIpt").val(), $("#J_Step2").find("#hdecodeIpt").val(), function() {
                t.empty().append('<em class="time J_CountDown">60</em>秒后重新发送').addClass("off"), t.find(".J_CountDown").countdown(function() {
                    var t = this.parent().empty();
                    t.text("获取验证码").removeClass("off")
                }, 60, "time")
            }, "voice"), !1
        }), $("#J_Step2").on("click", ".J_SendSx", function() {
            var t = $(this), e = "/json/black/res/mobile/" + $("#J_PatientSel").val() + "/REG_MOBILE_UP/" + $("#shiftCaseIdIpt").val() + "/" + $("#J_Step2").find("#hdecodeIpt").val();
            return o(e, t, function() {
                t.empty().append('<em class="time J_CountDown">60</em>秒后重新发送').addClass("off"), t.find(".J_CountDown").countdown(function() {
                    var t = this.parent().empty();
                    t.text("重发短信").removeClass("off")
                }, 60, "time")
            }), !1
        }), $("#J_Step2").on("click", ".J_PaySel a", function() {
            var t = $(this), e = t.closest(".J_PaySel").find("input");
            return t.hasClass("on") || (t.closest(".J_PaySel").find("a").removeClass("on"), t.addClass("on"), e.val(t.attr("data-val"))), !1
        }), $("#J_Step2").on("click", "#J_Submit2", function() {
            var t = $(this), e = $(this).closest("form"), i = $("#J_Step2").find("#hdecodeIpt");
            if (valid = $GH.validate({"#codeIpt": {required: "手机验证码不能为空"}})) {
                params = "encodePatientId=" + $("#J_PatientSel").val() + "&hdecode=" + i.val(), $.each(["#codeIpt", "#expertIdIpt", "#shiftCaseIdIpt"], function() {
                    var t = $(this);
                    t.length && (params += "&" + t.attr("name") + "=" + encodeURIComponent(t.val()))
                });
                var o = "/json/black/res/checkcode?" + params;
                "voice" == t.data("type") && (o = "/json/black/res/voicecheckcode?" + params), $.ajax({dataType: "json",cache: !1,url: o,success: function(t) {
                    t.hasError ? ($GH.alert(t.message || "出错了！"), $GH.refreshCaptcha($("#J_Step2").find(".J_ImgCode")), t.map && t.map.errlimit && (location.href = $GC.guahaoServer + "/my/reservation/failed?m=" + encodeURIComponent("验证码输入错误次数过多，请重新预约!"))) : (t.map && t.map.hdecode2 && i.val(i.val() + md5(t.map.hdecode2)), e.submit())
                },error: function(t, e) {
                    return "abort" === e ? void $GH.alert("请求过于频繁，请求已中止") : ($GH.alert("系统异常，请稍后重试！"), void $GH.refreshCaptcha($("#J_Step2").find(".J_ImgCode")))
                }})
            }
            return !1
        }), t.find(".J_Resend").on("click", function(t) {
            var e = $(this);
            return $GH.mobileMsg.orderResend(e.attr("data-id"), function() {
                $("<span class='g-gray'>已补发短信</span>").insertBefore(e), e.remove()
            }), t.stopPropagation(), !1
        })
    })
}(), $GH.module("#J_ZixunHome", function(t, e) {
    new Swiper("#J_Swiper", {pagination: ".pagination",visibilityFullFit: !0,calculateHeight: !0}), $(".expert-list .wrapper").css({width: 71 * $(".expert").length + 15 + "px"}), e.go = function(t) {
        location.href = t
    }
}), $GH.module("#J_QK_List", function(t, e) {
    var i = $GH.iScroll(".wrapper", {bottom: 0}, {probeType: 2});
    e.loading = !0, e.pageCount = 0, e.itemList = [], e.pageNo = 1, $GH.loading.show(), e.page = function() {
        $.get($GC.guahaoServer + "/json/black/bconsult/list", {pageNo: e.pageNo}, function(t) {
            return t.hasError ? ($GH.alert(t.message), void e.$scan()) : t.map.localPageModel ? (e.pageCount = t.map.localPageModel.pageCount, e.itemList = e.itemList.concat(t.map.localPageModel.list), e.loading = !1, $GH.loading.hide(), e.$scan(), i.refresh(), void (e.pageCount > e.pageNo && i.scrollerHeight == i.wrapperHeight && (e.loading = !0, e.pageNo++, e.$scan(), e.page()))) : void e.$scan()
        }, "json")
    }, i.on("scroll", function() {
        e.pageCount > e.pageNo && this.maxScrollY > this.y && !e.loading && (e.loading = !0, e.pageNo++, e.$scan(), e.page())
    }), e.page()
}), $GH.module("#J_QK_detail", function(t, e) {
    $("body").bind("touchstart", function() {
    }), e.myself = !!t.data("myself"), e.asknum = t.data("asknum");
    var i = $GH.iScroll(".wrapper", {bottom: 0}, {probeType: 2});
    e.loading = !0, e.pageCount = 0, e.pageNo = 1, e.consultId = t.data("id"), e.chatList = [], e.status = {code: -1}, e.doctorPhoto = "", e.$scan(), $GH.loading.show(), $("body").css({backgroundColor: "#fff"}), e.genDate = function(t) {
        return $GH.genDate(t)
    }, e.scanAudioDuration = function() {
        $("audio").each(function(t, e) {
            e.addEventListener("canplaythrough", function() {
                var t = e.duration.toFixed(0);
                parseInt(t, 10) && $(e).next(".duration").text(t + "秒")
            }, !1)
        })
    }, e.playAudio = function(t) {
        var e = $(t.target);
        "DIV" !== e[0].tagName && (e = $(e.parent("div")));
        var i = e.find("audio"), o = e.find(".play").length;
        o ? (i[0].pause(), e.find(".icon").removeClass("play")) : (i[0].play(), e.find(".icon").addClass("play"), i[0].addEventListener("ended", function() {
            e.find(".icon").removeClass("play"), this.load()
        }, !1))
    }, alight.filters.beauty = function() {
        var t = new Date;
        return function(i) {
            var o = new Date(i.split(" "));
            return o.getFullYear() == t.getFullYear() ? e.genDate(o) : i
        }
    }, e.page = function() {
        $.get($GC.guahaoServer + "/json/bconsult/" + e.consultId, {pageNo: e.pageNo}, function(t) {
            return t.hasError ? void $GH.alert(t.message) : t.map.list && 0 !== t.map.list.length ? (e.chatList = 4 != t.map.status ? t.map.list.concat(e.chatList) : e.chatList.concat(t.map.list), e.status.code = t.map.status, t.map.status > 0 && 4 !== t.map.status && 2 !== t.map.status && (e.status.link = $GC.guahaoServer + "/my/bconsult/comment/" + e.chatList[0].consultId), e.doctorPhoto = t.map.doctorPhoto || $GC.staticServer + "/img/character/doc-unknow.png", e.loading = !1, $GH.loading.hide(), e.pageCount = t.map.pageCount, e.$scan(), e.refresh(), void e.scanAudioDuration()) : ($GH.alert("没有更多信息"), void $GH.loading.hide())
        }, "json")
    }, i.on("scroll", function() {
        e.pageNo < e.pageCount && (4 != e.status.code ? this.y > 30 && !e.loading && (e.loading = !0, e.pageNo++, e.$scan(), e.page()) : this.maxScrollY > this.y && !e.loading && (e.loading = !0, e.pageNo++, e.$scan(), e.page()))
    }), e.refresh = function(o) {
        var n = t.find(".J_Input_Ctrl"), a = t.find(".wrapper"), s = a.find(".scroll"), r = t.find(".wait-status");
        n.find(".text-input").css({width: document.body.scrollWidth - 154 + "px"}), n.find(".send-btn").attr("disabled", "disabled"), 4 != e.status.code ? (a.css({bottom: n.height()}), r.css({bottom: n.height()})) : r.css({bottom: 0}), e.myself || (a.css({bottom: 60}), r.css({bottom: 60})), i.refresh(), (1 == e.pageNo || o || 4 == e.status.code) && i.scrollTo(0, a.height() - s.height(), 500)
    }, $GH.ImageUploader($(".J_Input_Ctrl"), {uploadBtn: ".upload-btn",fileInput: ".file-input",uploaderUrl: $GC.guahaoServer + "/json/black/image/upload?type=2",beforeComplete: function() {
        $GH.loading.show()
    },afterUpload: function(t) {
        o(t.map)
    },afterComplete: function() {
        $GH.loading.hide()
    }}), e.imageShow = function(t) {
        $GH.ImageUploader($(t.target).parent(), {onlySlider: t.target})
    };
    var o = function(i, o) {
        var n = t.find(".text-input");
        return o = o || n.val(), !i && (o.length > 500 || o.length < 10) ? void $GH.alert("咨询内容字数长度范围: 10~500字") : void $.post($GC.guahaoServer + "/json/black/bconsult/reply", {consultId: e.chatList[0].consultId,consultContent: o || "",imagePath: i ? i.sourcePath : ""}, function(t) {
            return t.hasError ? void $GH.alert(t.message) : (e.chatList = e.chatList.concat([{age: -1,consultDate: e.genDate(new Date),consultReplayId: null,consultContent: o || "",imagePath: i ? i.imageServerPath + "/" + i.path : "",userType: 0}]), e.status.code = 0, e.textMsg = "", e.asknum--, e.$scan(), void e.refresh(!0))
        }, "json")
    };
    e.inputText = function(i) {
        var n = t.find(".send-btn");
        e.textMsg && "" !== e.textMsg ? (n.removeAttr("disabled"), 13 === i.keyCode && o(null, e.textMsg)) : n.attr("disabled", "disabled")
    }, e.send = function(t) {
        o(null, t)
    }, e.page()
}), $GH.module("#J_Zixun_Jinri", function(t, e) {
    var i = $GH.iScroll(".wrapper", {top: 10}, {probeType: 2});
    e.totalCount = 0, e.itemList = [], e.getExpertList = function(t, o) {
        e.pageNo = t, e.loading = !0, $GH.loading.show(), $.ajax({dataType: "json",cache: !1,data: {pageNo: t,pi: "all",p: "全国"},url: $GC.guahaoServer + "/json/white/consult/searchexpert",type: "get",success: function(t) {
            $GH.loading.hide(), e.loading = !1, t.data && t.data.list && (e.itemList = o ? t.data.list : e.itemList.concat(t.data.list)), e.totalCount = t.data.totalCount, e.$scan(), i.refresh()
        }})
    }, e.getExpertList(1), i.on("scroll", function() {
        e.itemList.length < e.totalCount && this.maxScrollY > this.y && !e.loading && (e.loading = !0, e.$scan(), e.getExpertList(e.pageNo + 1))
    })
}), $GH.module("#J_QK_ExpertList", function(t, e) {
    var i = 1 == t.data("isvolunteer") ? !0 : !1;
    e.totalCount = 0, e.itemList = [];
    var o = $GH.iScroll(".wrapper", {top: i ? 0 : 47}, {probeType: 2});
    e.getExpertList = function(t, n) {
        e.pageNo = t, e.loading = !0, $GH.loading.show();
        var a = {deptId: e.deptId,pageNo: t,pi: "all",p: "全国",sort: 6};
        i && (a.volunteerDoctor = 1, a.sort = 5), $.ajax({dataType: "json",cache: !1,data: a,url: $GC.guahaoServer + "/json/white/consult/searchexpert",type: "get",success: function(t) {
            $GH.loading.hide(), e.loading = !1, t.data && t.data.list && (e.itemList = n ? t.data.list : e.itemList.concat(t.data.list)), e.totalCount = t.data.totalCount, e.$scan(), o.refresh()
        }})
    }, e.selectDept = !1, e.deptName = "全科", e.deptId = 0, e.toggleSelectDept = function() {
        e.selectDept = !e.selectDept
    }, e.setDept = function(t, i) {
        e.deptName = i.target.innerText, e.deptId = t, e.toggleSelectDept(), e.getExpertList(1, !0)
    }, e.getExpertList(1), o.on("scroll", function() {
        e.itemList.length < e.totalCount && this.maxScrollY > this.y && !e.loading && (e.loading = !0, e.$scan(), e.getExpertList(e.pageNo + 1))
    })
}), $GH.module("#J_QK_zixun", function(t, e) {
    if ("1" !== $(".J_HiddenConsultLimit").val())
        return void $GH.alert("您今天咨询该医生的次数已满，明天再提问吧");
    t.find(".J_PatientsDropDown").dropdownSheet(), t.find(".J_AdjustWidth").each(function() {
        var t = $(this);
        t.find(".input-box").css("margin-left", t.find(".nowidth").width() + 5 + "px")
    }), e.selectDept = !1, e.deptName = "全科", e.deptId = 0, e.toggleSelectDept = function() {
        e.selectDept = !e.selectDept
    }, e.setDept = function(t, i) {
        e.deptName = i.target.innerText, e.deptId = t, e.toggleSelectDept()
    }, e.submit = function() {
        var e = $GH.validate({"#sex": {required: "请选择性别"},"#age": {required: "请输入年龄",check: function(t) {
            return 0 == /^([1-9]\d|\d)$/.test(t) ? "年龄只能输入数字0~99" : !0
        }},"#v_content": {required: "请输入您的病情",check: function(t) {
            return t.length < 10 || t.length > 500 ? "病情描述长度范围：10到500字" : !0
        }}});
        e && t.find("form")[0].submit()
    };
    var i = function() {
        return t.find("img.preview").length
    };
    $GH.ImageUploader($(".g-image-upload-box"), {inputName: "imagePath",uploaderUrl: $GC.guahaoServer + "/json/black/image/upload?type=2",afterComplete: function() {
        i() > 0 && $(".J_Showmeonfileuploaded").hide(), 9 === i() && $(".upload-btn").hide()
    },afterDelete: function() {
        i() <= 9 && $(".upload-btn").show(), 1 === i() && $(".J_Showmeonfileuploaded").show()
    }})
}), $GH.module("#J_SearchEmbed", function(t) {
    var e = {scroll: null,cacheHistory: [],init: function() {
        var e = this;
        this.initSearchBar(), this.scroll = $GH.iScroll(".J_ListScroll", {top: $("#J_SearchBox").height() - $("#gh").height(),zIndex: 999}), $(".J_ListScroll").on("touchmove", function() {
            $("#J_Keyword").blur()
        }), $(document).on("tap", ".J_HistoryList li", function() {
            e.redirect($(this).text())
        }), $(document).on("tap", ".J_SuggestList li", function() {
            e.redirect($(this).text())
        }), $(".J_ClearHistory").on("click", function() {
            $GH.confirm("确定清空吗？", [{name: "取消",style: "btn",fn: function(t) {
                t()
            }}, {name: "确定",style: "btn",fn: function(t) {
                t(), e.clearHistory(), $("#J_Keyword").focus()
            }}])
        }), $("#J_SearchBox .J_Input").click(function() {
            return $("#J_SearchBar").show(), $("#J_SearchBox").hide(), $("#J_Keyword").focus(), t.addClass("opening"), !1
        }), $("#J_Keyword").val(""), this.showHistory($.trim($("#J_Keyword").val()), function() {
            e.loadSuggest()
        })
    },initSearchBar: function() {
        function e() {
            $("#J_SearchBar").hide(), $("#J_SearchBox").show(), t.removeClass("opening")
        }
        var i = this;
        $("#J_Keyword").focus();
        var o = $("#J_Keyword").val();
        o && o.length && ($("#J_Keyword")[0].selectionStart = $("#J_Keyword")[0].selectionEnd = o.length, $(".J_Clear").show()), $(".J_Clear").on("click", function() {
            return $("#J_Keyword").val("").focus(), i.showHistory(), !1
        }), $(".J_Search").on("click", function() {
            return i.redirect($("#J_Keyword").val()), !1
        }), $("#J_SearchForm").on("submit", function() {
            return i.redirect($("#J_Keyword").val()), !1
        }), $(".J_Cancel").on("click", function() {
            return e(), !1
        }), $("#J_Keyword").on("input focus", function() {
            var t = $.trim($(this).val());
            t ? $(".J_Clear").show() : $(".J_Clear").hide(), $(".J_ListScroll").show(), i.showHistory(t, function() {
                i.loadSuggest()
            })
        }), $("#J_Keyword").on("blur", function() {
        }), $("#J_Keyword").on("keydown", function(t) {
            13 === t.which && i.redirect($(this).val())
        })
    },redirect: function(t) {
        return (t = $.trim(t)) ? void (this.isInHistory(t) ? location.href = $("#J_Keyword").data("goto") + "?q=" + encodeURIComponent(t) + "&hospitalId=" + $("#J_HiddenHospital").val() : this.addHistory(t, function() {
            location.href = $("#J_Keyword").data("goto") + "?q=" + encodeURIComponent(t) + "&hospitalId=" + $("#J_HiddenHospital").val()
        })) : void $GH.alert("请输入搜索关键词")
    },isInHistory: function(t) {
        for (var e = this.cacheHistory, i = 0; i < e.length; i++)
            if (e[i] === t)
                return !0;
        return !1
    },loadSuggest: function() {
        var t = $("#J_Keyword");
        if (t.val()) {
            var e = this;
            $.ajax({type: "get",dataType: "json",cache: !1,url: t.data("action"),data: {q: t.val()},success: function(t) {
                if (t) {
                    var i = t.suggest;
                    i && (i = i.hospital || i.doctor || i.disease, e.showSuggest(i))
                }
            },error: function(t, e) {
                return "abort" === e ? void $GH.alert("请求过于频繁，请求已中止") : void $GH.alert("操作失败，请稍后再试！")
            }})
        }
    },showSuggest: function(t) {
        if (t && t.length) {
            $(".J_HistoryList").hide();
            for (var e = [], i = 0; i < t.length; i++)
                e.push("<li>" + t[i].name + "</li>");
            $(".J_SuggestList").show().find("ul").empty().append(e.join("")), this.scroll.refresh()
        }
    },callbackAdjust: function(t, e) {
        var i = $(".J_HistoryList ul");
        void 0 !== t && ("" === t || this.isInHistory(t) ? i.find("li[data-temp]").remove() : i.find("li[data-temp]").length ? i.find("li[data-temp]").text(t) : i.prepend('<li data-temp="1">' + t + "</li>"), $(".J_HistoryList").show()), i.find("li").length - i.find("li[data-temp]").length > 0 ? $(".J_ClearHistory").show() : $(".J_ClearHistory").hide(), "function" == typeof e && e(), this.scroll.refresh()
    },showHistory: function(t, e) {
        if ($(".J_SuggestList").hide(), this.cacheHistory.length)
            return void this.callbackAdjust(t, e);
        var i;
        try {
            var o = window.localStorage;
            i = o.getItem("searchHistory"), i = JSON.parse(i)
        } catch (n) {
            return void this.callbackAdjust(t, e)
        }
        if (!i || !i.length)
            return void this.callbackAdjust(t, e);
        this.cacheHistory = i;
        for (var a = [], s = [], r = 0; r < i.length; r++)
            $.inArray(i[r], s) > -1 || (a.push("<li>" + i[r] + "</li>"), s.push(i[r]));
        $(".J_HistoryList").show().find("ul").append(a.join("")), this.scroll.refresh(), this.callbackAdjust(t, e)
    },addHistory: function(t, e) {
        if (t) {
            var i = window.localStorage;
            if (!i)
                return void e();
            var o = i.getItem("searchHistory");
            o = o ? JSON.parse(o) : [], o.unshift(t);
            try {
                i.setItem("searchHistory", JSON.stringify(o)), e()
            } catch (n) {
                e()
            }
        }
    },clearHistory: function() {
        var t = window.localStorage;
        t && (t.removeItem("searchHistory"), $(".J_HistoryList").hide().find("ul").empty())
    }};
    e.init()
}), $GH.module("#J_SearchIndex", function() {
    var t = {scroll: null,cacheHistory: [],init: function() {
        var t = this;
        this.initSearchBar(), this.scroll = $GH.iScroll(".J_ListScroll", {top: $(".J_Input").height() - 1,zIndex: 6666}), $(".J_ListScroll").on("touchmove", function() {
            $("#J_Keyword").blur()
        }), $(document).on("tap", ".J_HistoryList li", function() {
            t.redirect($(this).text())
        }), $(document).on("tap", ".J_SuggestList li", function() {
            t.redirect($(this).text())
        }), $(".J_ClearHistory").on("click", function() {
            $GH.confirm("确定清空吗？", [{name: "取消",style: "btn",fn: function(t) {
                t()
            }}, {name: "确定",style: "btn",fn: function(e) {
                e(), t.clearHistory(), $("#J_Keyword").focus()
            }}])
        }), this.showHistory($.trim($("#J_Keyword").val()), function() {
            t.loadSuggest()
        })
    },initSearchBar: function() {
        var t = this;
        $("#J_Keyword").focus();
        var e = $("#J_Keyword").val();
        e && e.length && ($("#J_Keyword")[0].selectionStart = $("#J_Keyword")[0].selectionEnd = e.length, $(".J_Clear").show()), $(".J_Clear").on("click", function() {
            $("#J_Keyword").val("").focus(), t.showHistory()
        }), $(".J_Search").on("click", function() {
            t.redirect($("#J_Keyword").val())
        }), $("#J_SearchForm").on("submit", function() {
            return t.redirect($("#J_Keyword").val()), !1
        }), $(".J_Cancel").on("click", function() {
            window.history.back(-1)
        }), $("#J_Keyword").on("input focus", function() {
            var e = $.trim($(this).val());
            e ? $(".J_Clear").show() : $(".J_Clear").hide(), t.showHistory(e, function() {
                t.loadSuggest()
            })
        }), $("#J_Keyword").on("keydown", function(e) {
            13 === e.which && t.redirect($(this).val())
        })
    },redirect: function(t) {
        return (t = $.trim(t)) ? void (this.isInHistory(t) ? location.href = $("#J_Keyword").data("goto") + "?q=" + encodeURIComponent(t) + "&hospitalId=" + $("#J_HiddenHospital").val() : this.addHistory(t, function() {
            location.href = $("#J_Keyword").data("goto") + "?q=" + encodeURIComponent(t) + "&hospitalId=" + $("#J_HiddenHospital").val()
        })) : void $GH.alert("请输入搜索关键词")
    },isInHistory: function(t) {
        for (var e = this.cacheHistory, i = 0; i < e.length; i++)
            if (e[i] === t)
                return !0;
        return !1
    },loadSuggest: function() {
        var t = $("#J_Keyword");
        if (t.val()) {
            var e = this;
            $.ajax({type: "get",dataType: "json",cache: !1,url: t.data("action"),data: {q: t.val()},success: function(t) {
                if (t) {
                    var i = t.suggest;
                    i && (i = i.hospital || i.doctor || i.disease, e.showSuggest(i))
                }
            },error: function(t, e) {
                return "abort" === e ? void $GH.alert("请求过于频繁，请求已中止") : void $GH.alert("操作失败，请稍后再试！")
            }})
        }
    },showSuggest: function(t) {
        if (t && t.length) {
            $(".J_HistoryList").hide();
            for (var e = [], i = 0; i < t.length; i++)
                e.push("<li>" + t[i].name + "</li>");
            $(".J_SuggestList").show().find("ul").empty().append(e.join("")), this.scroll.refresh()
        }
    },callbackAdjust: function(t, e) {
        var i = $(".J_HistoryList ul");
        void 0 !== t && ("" === t || this.isInHistory(t) ? i.find("li[data-temp]").remove() : i.find("li[data-temp]").length ? i.find("li[data-temp]").text(t) : i.prepend('<li data-temp="1">' + t + "</li>"), $(".J_HistoryList").show()), i.find("li").length - i.find("li[data-temp]").length > 0 ? $(".J_ClearHistory").show() : $(".J_ClearHistory").hide(), "function" == typeof e && e(), this.scroll.refresh()
    },showHistory: function(t, e) {
        if ($(".J_SuggestList").hide(), this.cacheHistory.length)
            return void this.callbackAdjust(t, e);
        var i;
        try {
            var o = window.localStorage;
            i = o.getItem("searchHistory"), i = JSON.parse(i)
        } catch (n) {
            return void this.callbackAdjust(t, e)
        }
        if (!i || !i.length)
            return void this.callbackAdjust(t, e);
        this.cacheHistory = i;
        for (var a = [], s = [], r = 0; r < i.length; r++)
            $.inArray(i[r], s) > -1 || (a.push("<li>" + i[r] + "</li>"), s.push(i[r]));
        $(".J_HistoryList").show().find("ul").append(a.join("")), this.scroll.refresh(), this.callbackAdjust(t, e)
    },addHistory: function(t, e) {
        if (t) {
            var i = window.localStorage;
            if (!i)
                return void $GH.alert("当前环境不支持保存搜索历史", "", function() {
                    e()
                });
            var o = i.getItem("searchHistory");
            o = o ? JSON.parse(o) : [], o.unshift(t);
            try {
                i.setItem("searchHistory", JSON.stringify(o)), e()
            } catch (n) {
                e()
            }
        }
    },clearHistory: function() {
        var t = window.localStorage;
        return t ? (t.removeItem("searchHistory"), void $(".J_HistoryList").hide().find("ul").empty()) : void $GH.alert("当前环境不支持保存搜索历史")
    }};
    t.init()
}), $GH.module("#J_SearchResult", function() {
    var t = {context: "",cacheArea: {},cacheSort: {},cacheFilter: {},init: function() {
        var t = this;
        this.context = $("#J_Context").val(), this.context && ($("#J_Keyword").on("input focus", function() {
            location.href = $(this).data("goto")
        }), $(".J_Search").on("click", function() {
            location.href = $("#J_Keyword").data("goto")
        }), $(".J_Clear").on("click", function() {
            var t = $("#J_Keyword").data("goto"), e = "";
            -1 !== t.indexOf("?q=") && (e = t.substring(0, t.indexOf("?q=")), -1 !== t.lastIndexOf("&") && (e += t.substring(t.lastIndexOf("&")))), e += e.indexOf("?") > -1 ? "&" : "?", location.href = e + "hospitalId=" + $("#J_HiddenHospital").val()
        }), $(".J_Cons span").on("click", function() {
            $(this).siblings().removeClass("current"), $(this).addClass("current");
            var e = $(this).data("id");
            1 === e ? location.href = $(this).data("page") : 2 === e ? ($(".J_" + t.context + "Complex").show(), $(".J_" + t.context + "Filter").hide(), $(".J_ConsContainer").show()) : ($(".J_" + t.context + "Complex").hide(), $(".J_" + t.context + "Filter").show(), $(".J_ConsContainer").show())
        }), $(".J_ConsContainer").on("click", function(t) {
            $(t.target).closest(".J_Complex").length || $(t.target).closest(".J_Filter").length || $(this).hide()
        }), this.initParams(), this["init" + this.context + "List"](), this.initSort(), this.initFilter())
    },initSort: function() {
        var t = this;
        $(".J_Complex li").on("click", function() {
            $(this).siblings().removeClass("selected"), $(this).addClass(" selected"), t.cacheSort[t.context] = $(this).data("id"), $(".J_ComplexName").html($(this).text()), $(".J_" + t.context + "List").trigger("refreshList"), $(".J_Complex").hide(), $(".J_ConsContainer").hide(), $(".J_Conditions").removeClass("fixed").show().css("top", "initial")
        })
    },initFilter: function() {
        var t = this;
        $(".J_Filter .cancel").on("click", function() {
            $(this).closest(".J_Filter").hide();
            var e = t.cacheFilter[t.context];
            "Doctor" === t.context ? (t.setFilterData(".J_Exist", e.es), t.setFilterData(".J_DoctorLevel", e.dt)) : t.setFilterData(".J_HospitalLevel", e.hl), $(".J_ConsContainer").hide()
        }), $(".J_Filter .ok").on("click", function() {
            $(this).closest(".J_Filter").hide(), t.cacheFilter[t.context] = "Doctor" === t.context ? {es: $(".J_Exist .selected").data("id") || "",dt: $(".J_DoctorLevel .selected").data("id") || ""} : {hl: $(".J_HospitalLevel .selected").data("id") || "all"}, $(".J_ConsContainer").hide(), $(".J_" + t.context + "List").trigger("refreshList"), $(".J_Conditions").removeClass("fixed").show().css("top", "initial")
        }), $(".J_Filter li").on("click", function() {
            $(this).siblings().removeClass("selected"), $(this).addClass("selected"), $(this).parent().parent().prev().find(".status").text($(this).text())
        })
    },setFilterData: function(t, e) {
        $(t).find("li").removeClass("selected");
        var i = $(t).find('li[data-id="' + e + '"]');
        i.addClass("selected"), $(t).prev().find(".status").text(i.text())
    },initParams: function() {
        this.cacheArea[this.context] = $("#J_HiddenArea").val() || "";
        var t = {};
        try {
            var e = window.localStorage;
            t = e.getItem("searchParams_" + this.context), t = JSON.parse(t)
        } catch (i) {
        }
        this.cacheSort[this.context] = t && t.sort || "2";
        var o = $(".J_" + this.context + 'Complex li[data-id="' + this.cacheSort[this.context] + '"]');
        if (o.length > 0 && (o.addClass("selected"), $(".J_ComplexName").html(o.text())), "Doctor" === this.context) {
            var n = t && t.es || "", a = t && t.dt || "";
            this.cacheFilter.Doctor = {es: n,dt: a}, this.setFilterData(".J_Exist", n), this.setFilterData(".J_DoctorLevel", a)
        } else {
            var s = t && t.hl || "all";
            this.cacheFilter.Hospital = {hl: s}, this.setFilterData(".J_HospitalLevel", s)
        }
    },storeParams: function(t) {
        var e = window.localStorage;
        if (e)
            try {
                e.setItem("searchParams_" + this.context, JSON.stringify(t))
            } catch (i) {
            }
    },getParams: function() {
        var t = this.context, e = {hid: $("#J_HiddenHospital").val() || "",q: $("#J_Keyword").val(),sort: this.cacheSort[t]};
        return "Doctor" === t ? (e.es = this.cacheFilter[t].es, e.dt = this.cacheFilter[t].dt) : e.hl = this.cacheFilter[t].hl, this.storeParams(e), e
    },initDoctorList: function() {
        var t = this;
        $(document).on("click", ".J_DoctorList li", function() {
            location.href = $(this).parent().parent().data("page") + "/" + $(this).data("id")
        }), $Common.pullUpScroll.init({pageSize: 10,initScrollCfg: {top: 0},scrollSelector: ".J_DoctorScroller",listSelector: ".J_DoctorList",customFunc: function() {
            var t = this, e = $("#J_SearchBar").height(), i = $(".J_Conditions").height();
            t.scroll.on("scroll", function() {
                -t.scroll.y <= e && $(".J_Conditions").removeClass("fixed").show().css("top", "initial")
            }), t.scroll.on("scrollEnd", function() {
                -t.scroll.y > e ? $(".J_Conditions").addClass("fixed").css("top", -t.scroll.y - i).show().animate({top: -t.scroll.y}, 300, "ease-out") : $(".J_Conditions").removeClass("fixed").show().css("top", "initial")
            }), t.scroll.on("scrollStart", function() {
                $(".J_ConsContainer").hide(), -t.scroll.y > e && $(".J_Conditions").hide()
            })
        },loadingData: function(e, i) {
            var o = this;
            1 === e && ($(".J_MainContent").hide(), $(".J_Loading").show());
            var n = t.getParams();
            n.page = e;
            var a = $(".J_DoctorList");
            $.ajax({type: "get",dataType: "json",cache: !1,data: n,url: a.data("action"),success: function(t) {
                if (t.data && 0 !== t.data.totalCount) {
                    $(".J_EmptyTips").hide(), $(".J_MainContent").show();
                    var n = t.data.totalCount;
                    o.totalCount = n, $(".J_TotalCouont").text(n), i && i(t.data.list)
                } else
                    1 === e && ($(".J_EmptyTips").show(), $(".J_MainContent").hide()), i && i([])
            },error: function(t, e) {
                return "abort" === e ? void $GH.alert("请求过于频繁，请求已中止") : void $GH.alert("操作失败，请稍后再试！")
            }})
        },buildHtml: function(t) {
            return $Common.buildDoctorItem(t)
        }})
    },initHospitalList: function() {
        var t = this;
        $(document).on("click", ".J_HospitalList li", function() {
            location.href = $(this).parent().parent().data("page") + "/" + $(this).data("id")
        }), $Common.pullUpScroll.init({pageSize: 10,initScrollCfg: {top: $("#J_SearchBar").height() + 40},scrollSelector: ".J_HospitalScroller",listSelector: ".J_HospitalList",loadingData: function(e, i) {
            var o = this;
            1 === e && ($(".J_MainContent").hide(), $(".J_Loading").show());
            var n = t.getParams();
            n.page = e;
            var a = $(".J_HospitalList");
            $.ajax({type: "get",dataType: "json",cache: !1,data: n,url: a.data("action"),success: function(t) {
                if (t.data && 0 !== t.data.totalCount) {
                    $(".J_EmptyTips").hide(), $(".J_MainContent").show();
                    var n = t.data.totalCount;
                    o.totalCount = n, $(".J_TotalCouont").text(n), i && i(t.data.list)
                } else
                    1 === e && ($(".J_EmptyTips").show(), $(".J_MainContent").hide()), i && i([])
            },error: function(t, e) {
                return "abort" === e ? void $GH.alert("请求过于频繁，请求已中止") : void $GH.alert("操作失败，请稍后再试！")
            }})
        },buildHtml: function(t) {
            return $Common.buildHospitalItem(t)
        }})
    }};
    t.init()
}), $GH.module("#J_SearchDoctor", function() {
    var t = {init: function() {
        var t = this;
        $("#J_Keyword").on("click", function() {
            location.href = $(this).data("goto")
        }), $(".J_Search").on("click", function() {
            t.search()
        }), $("#J_SearchForm").on("submit", function() {
            return t.search(), !1
        }), $(".J_Clear").on("click", function() {
            $("#J_Phone").val("").focus()
        }), $("#J_Phone").on("keydown", function(e) {
            return 13 === e.which ? (t.search(), !1) : void 0
        }), $("#J_Phone").on("input", function() {
            var t = $.trim($(this).val());
            t ? $(".J_Clear").show() : $(".J_Clear").hide()
        }), $("#J_Phone").focus()
    },search: function() {
        $GH.loading.show();
        var t = $("#J_Phone"), e = $GH.validate({"#J_Phone": {required: "手机号码不能为空",mobile: "手机号码格式不正确"}});
        e ? $.ajax({type: "get",dataType: "json",cache: !1,url: t.data("action"),data: {mobileNo: t.val()},success: function(e) {
            e && e.data ? location.href = t.data("goto") + e.data.expertUuid : $GH.alert("找不到该手机号对应的医生"), $GH.loading.hide()
        },error: function(t, e) {
            return "abort" === e ? void $GH.alert("请求过于频繁，请求已中止") : ($GH.alert("操作失败，请稍后再试！"), void $GH.loading.hide())
        }}) : $("#J_Phone").focus()
    }};
    t.init()
}), function(t) {
    "use strict";
    var e = {version: 2.6};
    t.WeixinApi = e, "function" == typeof define && (define.amd || define.cmd) && (define.amd ? define(function() {
        return e
    }) : define.cmd && define(function(t, i, o) {
        o.exports = e
    }));
    var i = function(t, i, o) {
        o = o || {};
        var n = function(t) {
            switch (!0) {
                case /\:cancel$/i.test(t.err_msg):
                    o.cancel && o.cancel(t);
                    break;
                case /\:(confirm|ok)$/i.test(t.err_msg):
                    o.confirm && o.confirm(t);
                    break;
                case /\:fail$/i.test(t.err_msg):
                default:
                    o.fail && o.fail(t)
            }
            o.all && o.all(t)
        }, a = function(e, i) {
            if ("menu:general:share" === t.menu)
                if ("timeline" == i.shareTo) {
                    var o = {appId: e.appId,img_url: e.img_url,link: e.link,desc: e.title,title: e.desc};
                    i.generalShare(o, n)
                } else
                    i.generalShare(e, n);
            else
                WeixinJSBridge.invoke(t.action, e, n)
        };
        WeixinJSBridge.on(t.menu, function(t) {
            if (o.async && o.ready) {
                var n = "_wx_loadedCb_";
                e[n] = o.dataLoaded || new Function, e[n].toString().indexOf(n) > 0 && (e[n] = new Function), o.dataLoaded = function(i) {
                    e[n](i), a(i, t)
                }, o.ready && o.ready(t)
            } else
                o.ready && o.ready(t), a(i, t)
        })
    };
    e.shareToTimeline = function(t, e) {
        i({menu: "menu:share:timeline",action: "shareTimeline"}, {appid: t.appId ? t.appId : "",img_url: t.img_url,link: t.link,desc: t.title,title: t.desc,img_width: "640",img_height: "640"}, e)
    }, e.shareToFriend = function(t, e) {
        i({menu: "menu:share:appmessage",action: "sendAppMessage"}, {appid: t.appId ? t.appId : "",img_url: t.img_url,link: t.link,desc: t.desc,title: t.title,img_width: "640",img_height: "640"}, e)
    }, e.shareToWeibo = function(t, e) {
        i({menu: "menu:share:weibo",action: "shareWeibo"}, {content: t.desc,url: t.link}, e)
    }, e.generalShare = function(t, e) {
        i({menu: "menu:general:share"}, t, e)
    }, e.addContact = function(t, e) {
        e = e || {}, WeixinJSBridge.invoke("addContact", {webtype: "1",username: t}, function(t) {
            var i = !t.err_msg || "add_contact:ok" == t.err_msg || "add_contact:added" == t.err_msg;
            i ? e.success && e.success(t) : e.fail && e.fail(t)
        })
    }, e.imagePreview = function(t, e) {
        t && e && 0 != e.length && WeixinJSBridge.invoke("imagePreview", {current: t,urls: e})
    }, e.showOptionMenu = function() {
        WeixinJSBridge.call("showOptionMenu")
    }, e.hideOptionMenu = function() {
        WeixinJSBridge.call("hideOptionMenu")
    }, e.showToolbar = function() {
        WeixinJSBridge.call("showToolbar")
    }, e.hideToolbar = function() {
        WeixinJSBridge.call("hideToolbar")
    }, e.getNetworkType = function(t) {
        t && "function" == typeof t && WeixinJSBridge.invoke("getNetworkType", {}, function(e) {
            t(e.err_msg)
        })
    }, e.closeWindow = function(t) {
        t = t || {}, WeixinJSBridge.invoke("closeWindow", {}, function(e) {
            switch (e.err_msg) {
                case "close_window:ok":
                    t.success && t.success(e);
                    break;
                default:
                    t.fail && t.fail(e)
            }
        })
    }, e.ready = function(e) {
        if (e && "function" == typeof e) {
            var i = this, o = function() {
                e(i)
            };
            "undefined" == typeof t.WeixinJSBridge ? document.addEventListener ? document.addEventListener("WeixinJSBridgeReady", o, !1) : document.attachEvent && (document.attachEvent("WeixinJSBridgeReady", o), document.attachEvent("onWeixinJSBridgeReady", o)) : o()
        }
    }, e.openInWeixin = function() {
        return /MicroMessenger/i.test(navigator.userAgent)
    }, e.scanQRCode = function(t) {
        t = t || {}, WeixinJSBridge.invoke("scanQRCode", {}, function(e) {
            switch (e.err_msg) {
                case "scan_qrcode:ok":
                    t.success && t.success(e);
                    break;
                default:
                    t.fail && t.fail(e)
            }
        })
    }, e.getInstallState = function(t, e) {
        e = e || {}, WeixinJSBridge.invoke("getInstallState", {packageUrl: t.packageUrl || "",packageName: t.packageName || ""}, function(t) {
            var i = t.err_msg, o = i.match(/state:yes_?(.*)$/);
            o ? (t.version = o[1] || "", e.success && e.success(t)) : e.fail && e.fail(t), e.all && e.all(t)
        })
    }, e.openLocation = function(t, e) {
        e = e || {}, WeixinJSBridge.invoke("openLocation", {latitude: t.latitude,longitude: t.longitude,name: t.name,address: t.address,scale: t.scale || 14,infoUrl: t.infoUrl || ""}, function(t) {
            "open_location:ok" === t.err_msg ? e.success && e.success(t) : e.fail && e.fail(t), e.all && e.all(t)
        })
    }, e.sendEmail = function(t, e) {
        e = e || {}, WeixinJSBridge.invoke("sendEmail", {title: t.subject,content: t.body}, function(t) {
            "send_email:sent" === t.err_msg ? e.success && e.success(t) : e.fail && e.fail(t), e.all && e.all(t)
        })
    }, e.enableDebugMode = function(e) {
        t.onerror = function(t, i, o, n) {
            if ("function" == typeof e)
                e({message: t,script: i,line: o,column: n});
            else {
                var a = [];
                a.push("额，代码有错。。。"), a.push("\n错误信息：", t), a.push("\n出错文件：", i), a.push("\n出错位置：", o + "行，" + n + "列"), alert(a.join(""))
            }
        }
    }
}(window), $(function() {
    var t = function(t) {
        var e = function() {
            $(".J_CountDownTip").show(), $(".J_CountDown").countdown(function() {
                $(".J_CountDownTip").hide(), $(".J_GetCaptcha").show()
            }, 60, "time秒后重发")
        };
        $(".J_GetCaptcha").on("click", function() {
            var i = $("#mobile").val();
            return i ? void $GH.mobileCode.basic(i, t, function() {
                $(".J_GetCaptcha").hide(), e()
            }) : void $GH.alert("请输入手机号")
        })
    };
    $GH.module("#J_DoctorRegister", function(e) {
        var i = {init: function() {
            this.registerInit(), this.completeInfo()
        },registerInit: function() {
            $(".J_Check").on("click", function() {
                return $(this).toggleClass("g-checkbox-checked"), $(this).toggleClass("g-checkbox"), $("#agreement").val($(this).hasClass("g-checkbox-checked") ? "1" : ""), !1
            }), t("REG_MOBILE"), $(".J_RegisterFirst").on("click", function() {
                var t = $(this), e = $GH.validate({"#mobile": {required: "请输入手机号"},"#captcha": {required: "请输入验证码"},"#password": {required: "请输入密码"},"#agreement": {required: "请先同意协议才能注册"}});
                return e && $.ajax({type: "post",dataType: "json",data: {mobile: $("#mobile").val(),password: $("#password").val(),code: $("#captcha").val()},cache: !1,url: t.data("action"),success: function(e) {
                    void 0 === e.hasError || e.hasError ? $GH.alert(e.message) : location.href = t.data("goto") + "?loginId=" + e.data
                },error: function(t, e) {
                    "abort" !== e && $GH.alert("操作失败，请稍后重试！")
                }}), !1
            })
        },completeInfo: function() {
            var t = function() {
                return e.find("img.preview").length
            };
            $GH.ImageUploader($(".g-image-upload-box"), {uploadBtn: ".upload-btn",fileInput: ".file-input",inputName: "certificateImage",uploaderUrl: window.$GC.guahaoServer + "/json/white/doctor/image/upload",afterComplete: function() {
                t() > 0 && $(".J_Showmeonfileuploaded").hide(), 2 === t() && $(".upload-btn").hide()
            },afterDelete: function() {
                t() <= 2 && $(".upload-btn").show(), 1 === t() && $(".J_Showmeonfileuploaded").show()
            }}), $(".J_RegisterSecond").on("click", function() {
                var t = $(this), e = $GH.validate({"#doctorName": {required: "请输入真实姓名"},"#hospitalName": {required: "请输入所在医院"},"#hospdeptName": {required: "请输入所在科室"},"#telephoneNo": {required: "请输入医院电话"}});
                if (e) {
                    var i = $("#doctorSecondForm").serializeToObj();
                    if ($.isArray(i.certificateImage))
                        i.certificateImage = i.certificateImage.join(",");
                    else if (!i.certificateImage || 0 === i.certificateImage.length)
                        return $GH.alert("请上传执业证书照片"), !1;
                    $.ajax({type: "post",dataType: "json",data: i,cache: !1,url: t.data("action"),success: function(e) {
                        void 0 === e.hasError || e.hasError ? $GH.alert(e.message) : location.href = t.data("goto")
                    },error: function(t, e) {
                        "abort" !== e && $GH.alert("操作失败，请稍后重试！")
                    }})
                }
                return !1
            })
        }};
        i.init()
    }), $GH.module("#J_DoctorLogin", function() {
        var t = {init: function() {
            $(".J_ImgCaptcha").on("click", function() {
                return $GH.refreshCaptcha($(this).find("img")), !1
            }), $(".J_Login").on("click", function() {
                var t = $(this), e = $GH.validate({"#username": {required: "用户名不能为空"},"#password": {required: "请输入密码"},"#captcha": {required: "请输入验证码"}});
                return e && $.ajax({type: "post",dataType: "json",data: {loginId: $("#username").val(),password: window.md5($("#password").val()),validCode: $("#captcha").val()},cache: !1,url: t.attr("data-action"),success: function(e) {
                    void 0 === e.hasError || e.hasError ? ($GH.alert(e.message), $("#captcha").val("").focus(), $GH.refreshCaptcha($(".J_ImgCaptcha").find("img"))) : location.href = t.data("goto")
                },error: function(t, e) {
                    "abort" !== e && $GH.alert("登录失败，请稍后重试！")
                }}), !1
            })
        }};
        t.init()
    }), $GH.module("#J_GetInsurance", function() {
        var t = {init: function() {
            $(".J_Submit").on("click", function() {
                var t = $(this), e = $GH.validate({"#cardNo": {required: "身份证号码不能为空"},"#agreement": {required: "请先选择同意投保医者无忧产品"}});
                return e && $.ajax({type: "get",dataType: "json",data: {cardNo: $("#cardNo").val()},cache: !1,url: t.attr("data-action"),success: function(e) {
                    void 0 === e.hasError || e.hasError ? $GH.alert(e.message) : location.href = t.data("goto")
                },error: function(t, e) {
                    "abort" !== e && $GH.alert("操作失败，请稍后重试！")
                }}), !1
            }), $(".J_Check").on("click", function() {
                return $(this).toggleClass("g-checkbox-checked"), $(this).toggleClass("g-checkbox"), $("#agreement").val($(this).hasClass("g-checkbox-checked") ? "1" : ""), !1
            })
        }};
        t.init()
    }), $GH.module("#J_InsuranceShare", function() {
        location.href.indexOf("flag=1") > -1 && $(".J_MainTips").text("您已经领取过医者无忧险！赶紧分享给小伙伴吧！")
    }), $GH.module("#J_DoctorAuth", function(t) {
        var e = {init: function() {
            this.initPreview(), this.initUpload(), this.initSubmit()
        },initPreview: function() {
            $(".lightbox").on("click", function() {
                var t = $(this).attr("href");
                return $(".J_LightBox").show().find(".J_Inner").html("<img src=" + t + ">"), !1
            }), $(".J_LightBox").on("click", function() {
                $(this).hide()
            })
        },initUpload: function() {
            var e = function() {
                return t.find("img.preview").length
            };
            $GH.ImageUploader($(".g-image-upload-box"), {uploadBtn: ".upload-btn",fileInput: ".file-input",inputName: "certificateImage",uploaderUrl: window.$GC.guahaoServer + "/json/black/doctor/image/upload",afterComplete: function() {
                e() > 0 && $(".J_Showmeonfileuploaded").hide(), 2 === e() && $(".upload-btn").hide()
            },afterDelete: function() {
                e() <= 2 && $(".upload-btn").show(), 1 === e() && $(".J_Showmeonfileuploaded").show()
            }})
        },initSubmit: function() {
            $(".J_Submit").on("click", function() {
                var t = $(this), e = $("#doctorAuthForm").serializeToObj();
                if ($.isArray(e.certificateImage))
                    e.certificateImage = e.certificateImage.join(",");
                else if (!e.certificateImage || 0 === e.certificateImage.length)
                    return $GH.alert("请上传医师执业证书或手持工牌照"), !1;
                return $.ajax({type: "post",dataType: "json",data: e,cache: !1,url: t.data("action"),success: function(e) {
                    void 0 === e.hasError || e.hasError ? $GH.alert(e.message) : $GH.alert("认证申请已提交，医生助理将在1-5个工作日完成审核，请您关注", "", function() {
                        location.href = t.data("goto")
                    })
                },error: function(t, e) {
                    "abort" !== e && $GH.alert("操作失败，请稍后重试！")
                }}), !1
            })
        }};
        e.init()
    }), $GH.module("#J_SendInsurance", function() {
        var t = {init: function() {
            var t = this, e = $(".J_HiddenCount").val();
            $(".J_SendCount li.current").removeClass("current");
            var i = $(".J_SendCount li.flag-" + e);
            i.addClass("current"), this.adjustInfo(e, i.text()), $(".J_Check").on("click", function() {
                return $(this).toggleClass("g-checkbox-checked"), $(this).toggleClass("g-checkbox"), $("#agreement").val($(this).hasClass("g-checkbox-checked") ? "1" : ""), !1
            }), $(".J_SendCount li").on("click", function() {
                $(".J_SendCount li").removeClass("current"), $(this).addClass("current");
                var e = parseInt($(this).data("count"), 10);
                t.adjustInfo(e, $(this).text())
            }), $(".J_Submit").on("click", function() {
                return "1" !== $("#agreement").val() ? ($GH.alert("需要同意医者无忧保险协议"), !1) : ($("#J_SendForm").submit(), !1)
            })
        },adjustInfo: function(t, e) {
            $(".J_HiddenCount").val(t), $(".J_FlagText").text(e), $(".J_MainCount").text(5 * t + "万元"), $(".J_ExtraCount").text(.5 * t + "万元"), $(".J_TotalMoney").text(20 * t + "元")
        }};
        t.init()
    })
});
