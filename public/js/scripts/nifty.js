!function (n, t, e) {
    "use strict";
    var i, a, o, s, l, r, c, f, d, u, h, v, p, g, m, y, C, b, w, T, S, x, N, k, A, E, H, O, I, M, $;
    N = {
        paneClass: "nano-pane",
        sliderClass: "nano-slider",
        contentClass: "nano-content",
        iOSNativeScrolling: !1,
        preventPageScrolling: !1,
        disableResize: !1,
        alwaysVisible: !1,
        flashDelay: 1500,
        sliderMinHeight: 20,
        sliderMaxHeight: null,
        documentContext: null,
        windowContext: null
    }, b = "scrollbar", C = "scroll", d = "mousedown", u = "mouseenter", h = "mousemove", p = "mousewheel", v = "mouseup", y = "resize", l = "drag", r = "enter", T = "up", m = "panedown", o = "DOMMouseScroll", s = "down", S = "wheel", c = "keydown", f = "keyup", w = "touchmove", i = "Microsoft Internet Explorer" === t.navigator.appName && /msie 7./i.test(t.navigator.appVersion) && t.ActiveXObject, a = null, H = t.requestAnimationFrame, x = t.cancelAnimationFrame, I = e.createElement("div").style, $ = function () {
        var n, t, e, i, a, o;
        for (i = ["t", "webkitT", "MozT", "msT", "OT"], n = a = 0, o = i.length; o > a; n = ++a)if (e = i[n], t = i[n] + "ransform", t in I)return i[n].substr(0, i[n].length - 1);
        return !1
    }(), M = function (n) {
        return $ === !1 ? !1 : "" === $ ? n : $ + n.charAt(0).toUpperCase() + n.substr(1)
    }, O = M("transform"), A = O !== !1, k = function () {
        var n, t, i;
        return n = e.createElement("div"), t = n.style, t.position = "absolute", t.width = "100px", t.height = "100px", t.overflow = C, t.top = "-9999px", e.body.appendChild(n), i = n.offsetWidth - n.clientWidth, e.body.removeChild(n), i
    }, E = function () {
        var n, e, i;
        return e = t.navigator.userAgent, (n = /(?=.+Mac OS X)(?=.+Firefox)/.test(e)) ? (i = /Firefox\/\d{2}\./.exec(e), i && (i = i[0].replace(/\D+/g, "")), n && +i > 23) : !1
    }, g = function () {
        function c(i, o) {
            this.el = i, this.options = o, a || (a = k()), this.$el = n(this.el), this.doc = n(this.options.documentContext || e), this.win = n(this.options.windowContext || t), this.body = this.doc.find("body"), this.$content = this.$el.children("." + o.contentClass), this.$content.attr("tabindex", this.options.tabIndex || 0), this.content = this.$content[0], this.previousPosition = 0, this.options.iOSNativeScrolling && null != this.el.style.WebkitOverflowScrolling ? this.nativeScrolling() : this.generate(), this.createEvents(), this.addEvents(), this.reset()
        }

        return c.prototype.preventScrolling = function (n, t) {
            if (this.isActive)if (n.type === o)(t === s && n.originalEvent.detail > 0 || t === T && n.originalEvent.detail < 0) && n.preventDefault(); else if (n.type === p) {
                if (!n.originalEvent || !n.originalEvent.wheelDelta)return;
                (t === s && n.originalEvent.wheelDelta < 0 || t === T && n.originalEvent.wheelDelta > 0) && n.preventDefault()
            }
        }, c.prototype.nativeScrolling = function () {
            this.$content.css({WebkitOverflowScrolling: "touch"}), this.iOSNativeScrolling = !0, this.isActive = !0
        }, c.prototype.updateScrollValues = function () {
            var n, t;
            n = this.content, this.maxScrollTop = n.scrollHeight - n.clientHeight, this.prevScrollTop = this.contentScrollTop || 0, this.contentScrollTop = n.scrollTop, t = this.contentScrollTop > this.previousPosition ? "down" : this.contentScrollTop < this.previousPosition ? "up" : "same", this.previousPosition = this.contentScrollTop, "same" !== t && this.$el.trigger("update", {
                position: this.contentScrollTop,
                maximum: this.maxScrollTop,
                direction: t
            }), this.iOSNativeScrolling || (this.maxSliderTop = this.paneHeight - this.sliderHeight, this.sliderTop = 0 === this.maxScrollTop ? 0 : this.contentScrollTop * this.maxSliderTop / this.maxScrollTop)
        }, c.prototype.setOnScrollStyles = function () {
            var n;
            A ? (n = {}, n[O] = "translate(0, " + this.sliderTop + "px)") : n = {top: this.sliderTop}, H ? (x && this.scrollRAF && x(this.scrollRAF), this.scrollRAF = H(function (t) {
                return function () {
                    return t.scrollRAF = null, t.slider.css(n)
                }
            }(this))) : this.slider.css(n)
        }, c.prototype.createEvents = function () {
            this.events = {
                down: function (n) {
                    return function (t) {
                        return n.isBeingDragged = !0, n.offsetY = t.pageY - n.slider.offset().top, n.slider.is(t.target) || (n.offsetY = 0), n.pane.addClass("active"), n.doc.bind(h, n.events[l]).bind(v, n.events[T]), n.body.bind(u, n.events[r]), !1
                    }
                }(this), drag: function (n) {
                    return function (t) {
                        return n.sliderY = t.pageY - n.$el.offset().top - n.paneTop - (n.offsetY || .5 * n.sliderHeight), n.scroll(), n.contentScrollTop >= n.maxScrollTop && n.prevScrollTop !== n.maxScrollTop ? n.$el.trigger("scrollend") : 0 === n.contentScrollTop && 0 !== n.prevScrollTop && n.$el.trigger("scrolltop"), !1
                    }
                }(this), up: function (n) {
                    return function () {
                        return n.isBeingDragged = !1, n.pane.removeClass("active"), n.doc.unbind(h, n.events[l]).unbind(v, n.events[T]), n.body.unbind(u, n.events[r]), !1
                    }
                }(this), resize: function (n) {
                    return function () {
                        n.reset()
                    }
                }(this), panedown: function (n) {
                    return function (t) {
                        return n.sliderY = (t.offsetY || t.originalEvent.layerY) - .5 * n.sliderHeight, n.scroll(), n.events.down(t), !1
                    }
                }(this), scroll: function (n) {
                    return function (t) {
                        n.updateScrollValues(), n.isBeingDragged || (n.iOSNativeScrolling || (n.sliderY = n.sliderTop, n.setOnScrollStyles()), null != t && (n.contentScrollTop >= n.maxScrollTop ? (n.options.preventPageScrolling && n.preventScrolling(t, s), n.prevScrollTop !== n.maxScrollTop && n.$el.trigger("scrollend")) : 0 === n.contentScrollTop && (n.options.preventPageScrolling && n.preventScrolling(t, T), 0 !== n.prevScrollTop && n.$el.trigger("scrolltop"))))
                    }
                }(this), wheel: function (n) {
                    return function (t) {
                        var e;
                        return null != t ? (e = t.delta || t.wheelDelta || t.originalEvent && t.originalEvent.wheelDelta || -t.detail || t.originalEvent && -t.originalEvent.detail, e && (n.sliderY += -e / 3), n.scroll(), !1) : void 0
                    }
                }(this), enter: function (n) {
                    return function (t) {
                        var e;
                        return n.isBeingDragged && 1 !== (t.buttons || t.which) ? (e = n.events)[T].apply(e, arguments) : void 0
                    }
                }(this)
            }
        }, c.prototype.addEvents = function () {
            var n;
            this.removeEvents(), n = this.events, this.options.disableResize || this.win.bind(y, n[y]), this.iOSNativeScrolling || (this.slider.bind(d, n[s]), this.pane.bind(d, n[m]).bind("" + p + " " + o, n[S])), this.$content.bind("" + C + " " + p + " " + o + " " + w, n[C])
        }, c.prototype.removeEvents = function () {
            var n;
            n = this.events, this.win.unbind(y, n[y]), this.iOSNativeScrolling || (this.slider.unbind(), this.pane.unbind()), this.$content.unbind("" + C + " " + p + " " + o + " " + w, n[C])
        }, c.prototype.generate = function () {
            var n, e, i, o, s, l, r;
            return o = this.options, l = o.paneClass, r = o.sliderClass, n = o.contentClass, (s = this.$el.children("." + l)).length || s.children("." + r).length || this.$el.append('<div class="' + l + '"><div class="' + r + '" /></div>'), this.pane = this.$el.children("." + l), this.slider = this.pane.find("." + r), 0 === a && E() ? (i = t.getComputedStyle(this.content, null).getPropertyValue("padding-right").replace(/[^0-9.]+/g, ""), e = {
                right: -14,
                paddingRight: +i + 14
            }) : a && (e = {right: -a}, this.$el.addClass("has-scrollbar")), null != e && this.$content.css(e), this
        }, c.prototype.restore = function () {
            this.stopped = !1, this.iOSNativeScrolling || this.pane.show(), this.addEvents()
        }, c.prototype.reset = function () {
            var n, t, e, o, s, l, r, c, f, d, u, h;
            return this.iOSNativeScrolling ? void(this.contentHeight = this.content.scrollHeight) : (this.$el.find("." + this.options.paneClass).length || this.generate().stop(), this.stopped && this.restore(), n = this.content, o = n.style, s = o.overflowY, i && this.$content.css({height: this.$content.height()}), t = n.scrollHeight + a, d = parseInt(this.$el.css("max-height"), 10), d > 0 && (this.$el.height(""), this.$el.height(n.scrollHeight > d ? d : n.scrollHeight)), r = this.pane.outerHeight(!1), f = parseInt(this.pane.css("top"), 10), l = parseInt(this.pane.css("bottom"), 10), c = r + f + l, h = Math.round(c / t * c), h < this.options.sliderMinHeight ? h = this.options.sliderMinHeight : null != this.options.sliderMaxHeight && h > this.options.sliderMaxHeight && (h = this.options.sliderMaxHeight), s === C && o.overflowX !== C && (h += a), this.maxSliderTop = c - h, this.contentHeight = t, this.paneHeight = r, this.paneOuterHeight = c, this.sliderHeight = h, this.paneTop = f, this.slider.height(h), this.events.scroll(), this.pane.show(), this.isActive = !0, n.scrollHeight === n.clientHeight || this.pane.outerHeight(!0) >= n.scrollHeight && s !== C ? (this.pane.hide(), this.isActive = !1) : this.el.clientHeight === n.scrollHeight && s === C ? this.slider.hide() : this.slider.show(), this.pane.css({
                opacity: this.options.alwaysVisible ? 1 : "",
                visibility: this.options.alwaysVisible ? "visible" : ""
            }), e = this.$content.css("position"), ("static" === e || "relative" === e) && (u = parseInt(this.$content.css("right"), 10), u && this.$content.css({
                right: "",
                marginRight: u
            })), this)
        }, c.prototype.scroll = function () {
            return this.isActive ? (this.sliderY = Math.max(0, this.sliderY), this.sliderY = Math.min(this.maxSliderTop, this.sliderY), this.$content.scrollTop(this.maxScrollTop * this.sliderY / this.maxSliderTop), this.iOSNativeScrolling || (this.updateScrollValues(), this.setOnScrollStyles()), this) : void 0
        }, c.prototype.scrollBottom = function (n) {
            return this.isActive ? (this.$content.scrollTop(this.contentHeight - this.$content.height() - n).trigger(p), this.stop().restore(), this) : void 0
        }, c.prototype.scrollTop = function (n) {
            return this.isActive ? (this.$content.scrollTop(+n).trigger(p), this.stop().restore(), this) : void 0
        }, c.prototype.scrollTo = function (n) {
            return this.isActive ? (this.scrollTop(this.$el.find(n).get(0).offsetTop), this) : void 0
        }, c.prototype.stop = function () {
            return x && this.scrollRAF && (x(this.scrollRAF), this.scrollRAF = null), this.stopped = !0, this.removeEvents(), this.iOSNativeScrolling || this.pane.hide(), this
        }, c.prototype.destroy = function () {
            return this.stopped || this.stop(), !this.iOSNativeScrolling && this.pane.length && this.pane.remove(), i && this.$content.height(""), this.$content.removeAttr("tabindex"), this.$el.hasClass("has-scrollbar") && (this.$el.removeClass("has-scrollbar"), this.$content.css({right: ""})), this
        }, c.prototype.flash = function () {
            return !this.iOSNativeScrolling && this.isActive ? (this.reset(), this.pane.addClass("flashed"), setTimeout(function (n) {
                return function () {
                    n.pane.removeClass("flashed")
                }
            }(this), this.options.flashDelay), this) : void 0
        }, c
    }(), n.fn.nanoScroller = function (t) {
        return this.each(function () {
            var e, i;
            if ((i = this.nanoscroller) || (e = n.extend({}, N, t), this.nanoscroller = i = new g(this, e)), t && "object" == typeof t) {
                if (n.extend(i.options, t), null != t.scrollBottom)return i.scrollBottom(t.scrollBottom);
                if (null != t.scrollTop)return i.scrollTop(t.scrollTop);
                if (t.scrollTo)return i.scrollTo(t.scrollTo);
                if ("bottom" === t.scroll)return i.scrollBottom(0);
                if ("top" === t.scroll)return i.scrollTop(0);
                if (t.scroll && t.scroll instanceof n)return i.scrollTo(t.scroll);
                if (t.stop)return i.stop();
                if (t.destroy)return i.destroy();
                if (t.flash)return i.flash()
            }
            return i.reset()
        })
    }, n.fn.nanoScroller.Constructor = g
}(jQuery, window, document), !function (n, t, e) {
    function i(t, e) {
        this.element = n(t), this.settings = n.extend({}, o, e), this._defaults = o, this._name = a, this.init()
    }

    var a = "metisMenu", o = {toggle: !0, doubleTapToGo: !1};
    i.prototype = {
        init: function () {
            var t = this.element, i = this.settings.toggle, o = this;
            this.isIE() <= 9 ? (t.find("li.active").has("ul").children("ul").collapse("show"), t.find("li").not(".active").has("ul").children("ul").collapse("hide")) : (t.find("li.active").has("ul").children("ul").addClass("collapse in"), t.find("li").not(".active").has("ul").children("ul").addClass("collapse")), o.settings.doubleTapToGo && t.find("li.active").has("ul").children("a").addClass("doubleTapToGo"), t.find("li").has("ul").children("a").on("click." + a, function (t) {
                return t.preventDefault(), o.settings.doubleTapToGo && o.doubleTapToGo(n(this)) && "#" !== n(this).attr("href") && "" !== n(this).attr("href") ? (t.stopPropagation(), void(e.location = n(this).attr("href"))) : (n(this).parent("li").toggleClass("active").children("ul").collapse("toggle"), void(i && n(this).parent("li").siblings().removeClass("active").children("ul.in").collapse("hide")))
            })
        }, isIE: function () {
            for (var n, t = 3, i = e.createElement("div"), a = i.getElementsByTagName("i"); i.innerHTML = "<!--[if gt IE " + ++t + "]><i></i><![endif]-->", a[0];)return t > 4 ? t : n
        }, doubleTapToGo: function (n) {
            var t = this.element;
            return n.hasClass("doubleTapToGo") ? (n.removeClass("doubleTapToGo"), !0) : n.parent().children("ul").length ? (t.find(".doubleTapToGo").removeClass("doubleTapToGo"), n.addClass("doubleTapToGo"), !1) : void 0
        }, remove: function () {
            this.element.off("." + a), this.element.removeData(a)
        }
    }, n.fn[a] = function (t) {
        return this.each(function () {
            var e = n(this);
            e.data(a) && e.data(a).remove(), e.data(a, new i(this, t))
        }), this
    }
}(jQuery, window, document), !function (n) {
    "use strict";
    window.nifty = {
        container: n("#container"),
        contentContainer: n("#content-container"),
        navbar: n("#navbar"),
        mainNav: n("#mainnav-container"),
        aside: n("#aside-container"),
        footer: n("#footer"),
        scrollTop: n("#scroll-top"),
        window: n(window),
        body: n("body"),
        bodyHtml: n("body, html"),
        document: n(document),
        screenSize: "",
        isMobile: function () {
            return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)
        }(),
        randomInt: function (n, t) {
            return Math.floor(Math.random() * (t - n + 1) + n)
        },
        transition: function () {
            var n = document.body || document.documentElement, t = n.style, e = void 0 !== t.transition || void 0 !== t.WebkitTransition;
            return e
        }()
    }, nifty.document.ready(function () {
        nifty.document.trigger("nifty.ready")
    }), nifty.document.on("nifty.ready", function () {
        var t = n(".add-tooltip");
        t.length && t.tooltip();
        var e = n(".add-popover");
        e.length && e.popover();
        var i = n(".nano");
        i.length && i.nanoScroller({preventPageScrolling: !0}), n("#navbar-container .navbar-top-links").on("shown.bs.dropdown", ".dropdown", function () {
            n(this).find(".nano").nanoScroller({preventPageScrolling: !0})
        }), nifty.body.addClass("nifty-ready")
    })
}(jQuery), !function (n) {
    "use strict";
    var t = null, e = function (n) {
        {
            var t = n.find(".mega-dropdown-toggle");
            n.find(".mega-dropdown-menu")
        }
        t.on("click", function (t) {
            t.preventDefault(), n.toggleClass("open")
        })
    }, i = {
        toggle: function () {
            return this.toggleClass("open"), null
        }, show: function () {
            return this.addClass("open"), null
        }, hide: function () {
            return this.removeClass("open"), null
        }
    };
    n.fn.niftyMega = function (t) {
        var a = !1;
        return this.each(function () {
            i[t] ? a = i[t].apply(n(this).find("input"), Array.prototype.slice.call(arguments, 1)) : "object" != typeof t && t || e(n(this))
        }), a
    }, nifty.document.on("nifty.ready", function () {
        t = n(".mega-dropdown"), t.length && t.niftyMega(), n("html").on("click", function (e) {
            t.length && (n(e.target).closest(".mega-dropdown").length || t.removeClass("open"))
        })
    })
}(jQuery), !function (n) {
    "use strict";
    nifty.document.on("nifty.ready", function () {
        var t = n('[data-dismiss="panel"]');
        t.length && t.one("click", function (t) {
            t.preventDefault();
            var e = n(this).parents(".panel");
            e.addClass("remove").on("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", function (n) {
                "opacity" == n.originalEvent.propertyName && e.remove()
            })
        })
    })
}(jQuery), !function () {
    "use strict";
    nifty.document.one("nifty.ready", function () {
        if (nifty.scrollTop.length && !nifty.isMobile) {
            var n = !0, t = 250;
            nifty.window.scroll(function () {
                nifty.window.scrollTop() > t && !n ? (nifty.navbar.addClass("shadow"), nifty.scrollTop.addClass("in"), n = !0) : nifty.window.scrollTop() < t && n && (nifty.navbar.removeClass("shadow"), nifty.scrollTop.removeClass("in"), n = !1)
            }), nifty.scrollTop.on("click", function (n) {
                n.preventDefault(), nifty.bodyHtml.animate({scrollTop: 0}, 500)
            })
        }
    })
}(jQuery), !function (n) {
    "use strict";
    var t = {
        displayIcon: !0,
        iconColor: "text-dark",
        iconClass: "fa fa-refresh fa-spin fa-2x",
        title: "",
        desc: ""
    }, e = function () {
        return (65536 * (1 + Math.random()) | 0).toString(16).substring(1)
    }, i = {
        show: function (t) {
            var i = n(t.attr("data-target")), a = "nifty-overlay-" + e() + e() + "-" + e(), o = n('<div id="' + a + '" class="panel-overlay"></div>');
            return t.prop("disabled", !0).data("niftyOverlay", a), i.addClass("panel-overlay-wrap"), o.appendTo(i).html(t.data("overlayTemplate")), null
        }, hide: function (t) {
            var e = n(t.attr("data-target")), i = n("#" + t.data("niftyOverlay"));
            return i.length && (t.prop("disabled", !1), e.removeClass("panel-overlay-wrap"), i.hide().remove()), null
        }
    }, a = function (e, i) {
        if (e.data("overlayTemplate"))return null;
        var a = n.extend({}, t, i), o = a.displayIcon ? '<span class="panel-overlay-icon ' + a.iconColor + '"><i class="' + a.iconClass + '"></i></span>' : "";
        return e.data("overlayTemplate", '<div class="panel-overlay-content pad-all unselectable">' + o + '<h4 class="panel-overlay-title">' + a.title + "</h4><p>" + a.desc + "</p></div>"), null
    };
    n.fn.niftyOverlay = function (t) {
        return i[t] ? i[t](this) : "object" != typeof t && t ? null : this.each(function () {
            a(n(this), t)
        })
    }
}(jQuery), !function (n) {
    "use strict";
    var t, i, e = {}, a = !1;
    n.niftyNoty = function (o) {
        {
            var f, s = {
                type: "primary",
                icon: "",
                title: "",
                message: "",
                closeBtn: !0,
                container: "page",
                floating: {position: "top-right", animationIn: "jellyIn", animationOut: "fadeOut"},
                html: null,
                focus: !0,
                timer: 0
            }, l = n.extend({}, s, o), r = n('<div class="alert-wrap"></div>'), c = function () {
                var n = "";
                return o && o.icon && (n = '<div class="media-left"><span class="icon-wrap icon-wrap-xs icon-circle alert-icon"><i class="' + l.icon + '"></i></span></div>'), n
            }, d = function () {
                var n = l.closeBtn ? '<button class="close" type="button"><i class="fa fa-times-circle"></i></button>' : "", t = '<div class="alert alert-' + l.type + '" role="alert">' + n + '<div class="media">';
                return l.html ? t + l.html + "</div></div>" : t + c() + '<div class="media-body"><h4 class="alert-title">' + l.title + '</h4><p class="alert-message">' + l.message + "</p></div></div>"
            }(), u = function () {
                return "floating" === l.container && l.floating.animationOut && (r.removeClass(l.floating.animationIn).addClass(l.floating.animationOut), nifty.transition || r.remove()), r.removeClass("in").on("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", function (n) {
                    "max-height" == n.originalEvent.propertyName && r.remove()
                }), clearInterval(f), null
            }, h = function (n) {
                nifty.bodyHtml.animate({scrollTop: n}, 300, function () {
                    r.addClass("in")
                })
            };
            !function () {
                if ("page" === l.container)t || (t = n('<div id="page-alert"></div>'), nifty.contentContainer.prepend(t)), i = t, l.focus && h(0); else if ("floating" === l.container)e[l.floating.position] || (e[l.floating.position] = n('<div id="floating-' + l.floating.position + '" class="floating-container"></div>'), nifty.container.append(e[l.floating.position])), i = e[l.floating.position], l.floating.animationIn && r.addClass("in animated " + l.floating.animationIn), l.focus = !1; else {
                    var o = n(l.container), s = o.children(".panel-alert"), c = o.children(".panel-heading");
                    if (!o.length)return a = !1, !1;
                    s.length ? i = s : (i = n('<div class="panel-alert"></div>'), c.length ? c.after(i) : o.prepend(i)), l.focus && h(o.offset().top - 30)
                }
                return a = !0, !1
            }()
        }
        if (a && (i.append(r.html(d)), r.find('[data-dismiss="noty"]').one("click", u), l.closeBtn && r.find(".close").one("click", u), l.timer > 0 && (f = setInterval(u, l.timer)), !l.focus))var p = setInterval(function () {
            r.addClass("in"), clearInterval(p)
        }, 200)
    }
}(jQuery), !function (n) {
    "use strict";
    var t, e = function (t) {
        if (!t.data("nifty-check")) {
            t.data("nifty-check", !0), t.text().trim().length ? t.addClass("form-text") : t.removeClass("form-text");
            var e = t.find("input")[0], i = e.name, a = function () {
                return "radio" == e.type && i ? n(".form-radio").not(t).find("input").filter('input[name="' + i + '"]').parent() : !1
            }(), o = function () {
                "radio" == e.type && a.length && a.each(function () {
                    var t = n(this);
                    t.hasClass("active") && t.trigger("nifty.ch.unchecked"), t.removeClass("active")
                }), e.checked ? t.addClass("active").trigger("nifty.ch.checked") : t.removeClass("active").trigger("nifty.ch.unchecked")
            };
            e.checked ? t.addClass("active") : t.removeClass("active"), n(e).on("change", o)
        }
    }, i = {
        isChecked: function () {
            return this[0].checked
        }, toggle: function () {
            return this[0].checked = !this[0].checked, this.trigger("change"), null
        }, toggleOn: function () {
            return this[0].checked || (this[0].checked = !0, this.trigger("change")), null
        }, toggleOff: function () {
            return this[0].checked && "checkbox" == this[0].type && (this[0].checked = !1, this.trigger("change")), null
        }
    }, a = function () {
        t = n(".form-checkbox, .form-radio"), t.length && t.niftyCheck()
    };
    n.fn.niftyCheck = function (t) {
        var a = !1;
        return this.each(function () {
            i[t] ? a = i[t].apply(n(this).find("input"), Array.prototype.slice.call(arguments, 1)) : "object" != typeof t && t || e(n(this))
        }), a
    }, nifty.document.on("nifty.ready", a).on("change", ".form-checkbox, .form-radio", a), nifty.document.on("change", ".btn-file :file", function () {
        var t = n(this), e = t.get(0).files ? t.get(0).files.length : 1, i = t.val().replace(/\\/g, "/").replace(/.*\//, ""), a = function () {
            try {
                return t[0].files[0].size
            } catch (n) {
                return "Nan"
            }
        }(), o = function () {
            if ("Nan" == a)return "Unknown";
            var n = Math.floor(Math.log(a) / Math.log(1024));
            return 1 * (a / Math.pow(1024, n)).toFixed(2) + " " + ["B", "kB", "MB", "GB", "TB"][n]
        }();
        t.trigger("fileselect", [e, i, o])
    })
}(jQuery), !function (n) {
    nifty.document.on("nifty.ready", function () {
        var t = n("#mainnav-shortcut");
        t.length && t.find("li").each(function () {
            var t = n(this);
            t.popover({
                animation: !1,
                trigger: "hover focus",
                placement: "bottom",
                container: "#mainnav-container",
                template: '<div class="popover mainnav-shortcut"><div class="arrow"></div><div class="popover-content"></div>'
            })
        })
    })
}(jQuery), !function (n, t) {
    var e = {};
    e.eventName = "resizeEnd", e.delay = 250, e.poll = function () {
        var i = n(this), a = i.data(e.eventName);
        a.timeoutId && t.clearTimeout(a.timeoutId), a.timeoutId = t.setTimeout(function () {
            i.trigger(e.eventName)
        }, e.delay)
    }, n.event.special[e.eventName] = {
        setup: function () {
            var t = n(this);
            t.data(e.eventName, {}), t.on("resize", e.poll)
        }, teardown: function () {
            var i = n(this), a = i.data(e.eventName);
            a.timeoutId && t.clearTimeout(a.timeoutId), i.removeData(e.eventName), i.off("resize", e.poll)
        }
    }, n.fn[e.eventName] = function (n, t) {
        return arguments.length > 0 ? this.on(e.eventName, null, n, t) : this.trigger(e.eventName)
    }
}(jQuery, this), !function (n) {
    "use strict";
    var t = n('#mainnav-menu > li > a, #mainnav-menu-wrap .mainnav-widget a[data-toggle="menu-widget"]'), e = n("#mainnav").height(), i = null, a = !1, o = !1, s = null, r = function () {
        var t, e = n('#mainnav-menu > li > a, #mainnav-menu-wrap .mainnav-widget a[data-toggle="menu-widget"]');
        e.each(function () {
            var i = n(this), a = i.children(".menu-title"), o = i.siblings(".collapse"), s = n(i.attr("data-target")), l = s.length ? s.parent() : null, r = null, c = null, f = null, d = null, g = (i.outerHeight() - i.height() / 4, function () {
                return s.length && i.on("click", function (n) {
                    n.preventDefault()
                }), o.length ? (i.on("click", function (n) {
                    n.preventDefault()
                }).parent("li").removeClass("active"), !0) : !1
            }()), m = null, y = function (n) {
                clearInterval(m), m = setInterval(function () {
                    n.nanoScroller({preventPageScrolling: !0, alwaysVisible: !0}), clearInterval(m)
                }, 700)
            };
            n(document).click(function (t) {
                n(t.target).closest("#mainnav-container").length || i.removeClass("hover").popover("hide")
            }), n("#mainnav-menu-wrap > .nano").on("update", function () {
                i.removeClass("hover").popover("hide")
            }), i.popover({
                animation: !1,
                trigger: "manual",
                container: "#mainnav",
                viewport: i,
                html: !0,
                title: function () {
                    return g ? a.html() : null
                },
                content: function () {
                    var t;
                    return g ? (t = n('<div class="sub-menu"></div>'), o.addClass("pop-in").wrap('<div class="nano-content"></div>').parent().appendTo(t)) : s.length ? (t = n('<div class="sidebar-widget-popover"></div>'), s.wrap('<div class="nano-content"></div>').parent().appendTo(t)) : t = '<span class="single-content">' + a.html() + "</span>", t
                },
                template: '<div class="popover menu-popover"><h4 class="popover-title"></h4><div class="popover-content"></div></div>'
            }).on("show.bs.popover", function () {
                if (!r) {
                    if (r = i.data("bs.popover").tip(), c = r.find(".popover-title"), f = r.children(".popover-content"), !g && 0 == s.length)return;
                    d = f.children(".sub-menu")
                }
                !g && 0 == s.length
            }).on("shown.bs.popover", function () {
                if (!g && 0 == s.length) {
                    var t = 0 - .5 * i.outerHeight();
                    return void f.css({"margin-top": t + "px", width: "auto"})
                }
                var e = parseInt(r.css("top")), a = i.outerHeight(), o = function () {
                    return nifty.container.hasClass("mainnav-fixed") ? n(window).outerHeight() - e - a : n(document).height() - e - a
                }(), l = f.find(".nano-content").children().css("height", "auto").outerHeight();
                f.find(".nano-content").children().css("height", ""), e > o ? (c.length && !c.is(":visible") && (a = Math.round(0 - .5 * a)), e -= 5, f.css({
                    top: "",
                    bottom: a + "px",
                    height: e
                }).children().addClass("nano").css({width: "100%"}).nanoScroller({preventPageScrolling: !0}), y(f.find(".nano"))) : (!nifty.container.hasClass("navbar-fixed") && nifty.mainNav.hasClass("affix-top") && (o -= 50), l > o ? ((nifty.container.hasClass("navbar-fixed") || nifty.mainNav.hasClass("affix-top")) && (o -= a + 5), o -= 5, f.css({
                    top: a + "px",
                    bottom: "",
                    height: o
                }).children().addClass("nano").css({width: "100%"}).nanoScroller({preventPageScrolling: !0}), y(f.find(".nano"))) : (c.length && !c.is(":visible") && (a = Math.round(0 - .5 * a)), f.css({
                    top: a + "px",
                    bottom: "",
                    height: "auto"
                }))), c.length && c.css("height", i.outerHeight()), f.on("click", function () {
                    f.find(".nano-pane").hide(), y(f.find(".nano"))
                })
            }).on("hidden.bs.popover", function () {
                i.removeClass("hover"), g ? o.removeAttr("style").appendTo(i.parent()) : s.length && s.appendTo(l), clearInterval(t)
            }).on("click", function () {
                nifty.container.hasClass("mainnav-sm") && (e.popover("hide"), i.addClass("hover").popover("show"))
            }).hover(function () {
                e.popover("hide"), i.addClass("hover").popover("show")
            }, function () {
                clearInterval(t), t = setInterval(function () {
                    r && (r.one("mouseleave", function () {
                        i.removeClass("hover").popover("hide")
                    }), r.is(":hover") || i.removeClass("hover").popover("hide")), clearInterval(t)
                }, 500)
            })
        }), o = !0
    }, c = function () {
        var e = n("#mainnav-menu").find(".collapse");
        e.length && e.each(function () {
            var t = n(this);
            t.hasClass("in") ? t.parent("li").addClass("active") : t.parent("li").removeClass("active")
        }), null != i && i.length && i.nanoScroller({stop: !0}), t.popover("destroy").unbind("mouseenter mouseleave"), o = !1
    }, f = function () {
        var e, t = nifty.container.width();
        e = 740 >= t ? "xs" : t > 740 && 992 > t ? "sm" : t >= 992 && 1200 >= t ? "md" : "lg", s != e && (s = e, nifty.screenSize = e, "sm" == nifty.screenSize && nifty.container.hasClass("mainnav-lg") && n.niftyNav("collapse"))
    }, d = function () {
        return nifty.mainNav.niftyAffix("update"), c(), f(), ("collapse" == a || nifty.container.hasClass("mainnav-sm")) && (nifty.container.removeClass("mainnav-in mainnav-out mainnav-lg"), r()), e = n("#mainnav").height(), a = !1, null
    }, h = {
        revealToggle: function () {
            nifty.container.hasClass("reveal") || nifty.container.addClass("reveal"), nifty.container.toggleClass("mainnav-in mainnav-out").removeClass("mainnav-lg mainnav-sm"), o && c()
        }, revealIn: function () {
            nifty.container.hasClass("reveal") || nifty.container.addClass("reveal"), nifty.container.addClass("mainnav-in").removeClass("mainnav-out mainnav-lg mainnav-sm"), o && c()
        }, revealOut: function () {
            nifty.container.hasClass("reveal") || nifty.container.addClass("reveal"), nifty.container.removeClass("mainnav-in mainnav-lg mainnav-sm").addClass("mainnav-out"), o && c()
        }, slideToggle: function () {
            nifty.container.hasClass("slide") || nifty.container.addClass("slide"), nifty.container.toggleClass("mainnav-in mainnav-out").removeClass("mainnav-lg mainnav-sm"), o && c()
        }, slideIn: function () {
            nifty.container.hasClass("slide") || nifty.container.addClass("slide"), nifty.container.addClass("mainnav-in").removeClass("mainnav-out mainnav-lg mainnav-sm"), o && c()
        }, slideOut: function () {
            nifty.container.hasClass("slide") || nifty.container.addClass("slide"), nifty.container.removeClass("mainnav-in mainnav-lg mainnav-sm").addClass("mainnav-out"), o && c()
        }, pushToggle: function () {
            nifty.container.toggleClass("mainnav-in mainnav-out").removeClass("mainnav-lg mainnav-sm"), nifty.container.hasClass("mainnav-in mainnav-out") && nifty.container.removeClass("mainnav-in"), o && c()
        }, pushIn: function () {
            nifty.container.addClass("mainnav-in").removeClass("mainnav-out mainnav-lg mainnav-sm"), o && c()
        }, pushOut: function () {
            nifty.container.removeClass("mainnav-in mainnav-lg mainnav-sm").addClass("mainnav-out"), o && c()
        }, colExpToggle: function () {
            return nifty.container.hasClass("mainnav-lg mainnav-sm") && nifty.container.removeClass("mainnav-lg"), nifty.container.toggleClass("mainnav-lg mainnav-sm").removeClass("mainnav-in mainnav-out"), nifty.window.trigger("resize")
        }, collapse: function () {
            return nifty.container.addClass("mainnav-sm").removeClass("mainnav-lg mainnav-in mainnav-out"), a = "collapse", nifty.window.trigger("resize")
        }, expand: function () {
            return nifty.container.removeClass("mainnav-sm mainnav-in mainnav-out").addClass("mainnav-lg"), nifty.window.trigger("resize")
        }, togglePosition: function () {
            nifty.container.toggleClass("mainnav-fixed"), nifty.mainNav.niftyAffix("update")
        }, fixedPosition: function () {
            nifty.container.addClass("mainnav-fixed"), nifty.mainNav.niftyAffix("update")
        }, staticPosition: function () {
            nifty.container.removeClass("mainnav-fixed"), nifty.mainNav.niftyAffix("update")
        }, update: d, forceUpdate: f, getScreenSize: function () {
            return s
        }
    };
    n.niftyNav = function (n, t) {
        if (h[n]) {
            ("colExpToggle" == n || "expand" == n || "collapse" == n) && ("xs" == nifty.screenSize && "collapse" == n ? n = "pushOut" : "xs" != nifty.screenSize && "sm" != nifty.screenSize || "colExpToggle" != n && "expand" != n || !nifty.container.hasClass("mainnav-sm") || (n = "pushIn"));
            var e = h[n].apply(this, Array.prototype.slice.call(arguments, 1));
            if (t)return t();
            if (e)return e
        }
        return null
    }, n.fn.isOnScreen = function () {
        var n = {top: nifty.window.scrollTop(), left: nifty.window.scrollLeft()};
        n.right = n.left + nifty.window.width(), n.bottom = n.top + nifty.window.height();
        var t = this.offset();
        return t.right = t.left + this.outerWidth(), t.bottom = t.top + this.outerHeight(), !(n.right < t.left || n.left > t.right || n.bottom < t.bottom || n.top > t.top)
    }, nifty.window.on("resizeEnd", d).trigger("resize"), nifty.document.on("nifty.ready", function () {
        var t = n(".mainnav-toggle");
        t.length && t.on("click", function (e) {
            e.preventDefault(), n.niftyNav(t.hasClass("push") ? "pushToggle" : t.hasClass("slide") ? "slideToggle" : t.hasClass("reveal") ? "revealToggle" : "colExpToggle")
        });
        var e = n("#mainnav-menu");
        e.length && (n("#mainnav-menu").metisMenu({toggle: !0}), i = nifty.mainNav.find(".nano"), i.length && i.nanoScroller({preventPageScrolling: !0}))
    })
}(jQuery), !function (n) {
    "use strict";
    var t = {
        toggleHideShow: function () {
            nifty.container.toggleClass("aside-in"), nifty.window.trigger("resize"), nifty.container.hasClass("aside-in") && e()
        }, show: function () {
            nifty.container.addClass("aside-in"), nifty.window.trigger("resize"), e()
        }, hide: function () {
            nifty.container.removeClass("aside-in"), nifty.window.trigger("resize")
        }, toggleAlign: function () {
            nifty.container.toggleClass("aside-left"), nifty.aside.niftyAffix("update")
        }, alignLeft: function () {
            nifty.container.addClass("aside-left"), nifty.aside.niftyAffix("update")
        }, alignRight: function () {
            nifty.container.removeClass("aside-left"), nifty.aside.niftyAffix("update")
        }, togglePosition: function () {
            nifty.container.toggleClass("aside-fixed"), nifty.aside.niftyAffix("update")
        }, fixedPosition: function () {
            nifty.container.addClass("aside-fixed"), nifty.aside.niftyAffix("update")
        }, staticPosition: function () {
            nifty.container.removeClass("aside-fixed"), nifty.aside.niftyAffix("update")
        }, toggleTheme: function () {
            nifty.container.toggleClass("aside-bright")
        }, brightTheme: function () {
            nifty.container.addClass("aside-bright")
        }, darkTheme: function () {
            nifty.container.removeClass("aside-bright")
        }
    }, e = function () {
        nifty.container.hasClass("mainnav-in") && "xs" != nifty.screenSize && ("sm" == nifty.screenSize ? n.niftyNav("collapse") : nifty.container.removeClass("mainnav-in mainnav-lg mainnav-sm").addClass("mainnav-out"))
    };
    n.niftyAside = function (n, e) {
        return t[n] && (t[n].apply(this, Array.prototype.slice.call(arguments, 1)), e) ? e() : null
    }, nifty.document.on("nifty.ready", function () {
        if (nifty.aside.length) {
            nifty.aside.find(".nano").nanoScroller({preventPageScrolling: !0, alwaysVisible: !1});
            var t = n(".aside-toggle");
            t.length && t.on("click", function () {
                n.niftyAside("toggleHideShow")
            })
        }
    })
}(jQuery), !function (n) {
    "use strict";
    var t = {dynamicMode: !0, selectedOn: null, onChange: null}, e = function (e, i) {
        var a = n.extend({}, t, i), o = e.find(".lang-selected"), s = o.parent(".lang-selector").siblings(".dropdown-menu"), l = s.find("a"), r = l.filter(".active").find(".lang-id").text(), c = l.filter(".active").find(".lang-name").text(), f = function (n) {
            l.removeClass("active"), n.addClass("active"), o.html(n.html()), r = n.find(".lang-id").text(), c = n.find(".lang-name").text(), e.trigger("onChange", [{
                id: r,
                name: c
            }]), "function" == typeof a.onChange && a.onChange.call(this, {id: r, name: c})
        };
        l.on("click", function (t) {
            a.dynamicMode && (t.preventDefault(), t.stopPropagation()), e.dropdown("toggle"), f(n(this))
        }), a.selectedOn && f(n(a.selectedOn))
    }, i = {
        getSelectedID: function () {
            return n(this).find(".lang-id").text()
        }, getSelectedName: function () {
            return n(this).find(".lang-name").text()
        }, getSelected: function () {
            var t = n(this);
            return {id: t.find(".lang-id").text(), name: t.find(".lang-name").text()}
        }, setDisable: function () {
            return n(this).addClass("disabled"), null
        }, setEnable: function () {
            return n(this).removeClass("disabled"), null
        }
    };
    n.fn.niftyLanguage = function (t) {
        var a = !1;
        return this.each(function () {
            i[t] ? a = i[t].apply(this, Array.prototype.slice.call(arguments, 1)) : "object" != typeof t && t || e(n(this), t)
        }), a
    }
}(jQuery), !function (n) {
    "use strict";
    n.fn.niftyAffix = function (t) {
        return this.each(function () {
            var i, e = n(this);
            "object" != typeof t && t ? "update" == t && (i = e.data("nifty.af.class")) : (i = t.className, e.data("nifty.af.class", t.className)), nifty.container.hasClass(i) && !nifty.container.hasClass("navbar-fixed") ? e.affix({offset: {top: n("#navbar").outerHeight()}}) : (!nifty.container.hasClass(i) || nifty.container.hasClass("navbar-fixed")) && (nifty.window.off(e.attr("id") + ".affix"), e.removeClass("affix affix-top affix-bottom").removeData("bs.affix"))
        })
    }, nifty.document.on("nifty.ready", function () {
        nifty.mainNav.length && nifty.mainNav.niftyAffix({className: "mainnav-fixed"}), nifty.aside.length && nifty.aside.niftyAffix({className: "aside-fixed"})
    })
}(jQuery);
