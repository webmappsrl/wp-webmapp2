!function (e, t) {
  "object" == typeof exports && "object" == typeof module ? module.exports = t(require("leaflet")) : "function" == typeof define && define.amd ? define(["leaflet"], t) : "object" == typeof exports ? exports.VectorMarkers = t(require("leaflet")) : e.VectorMarkers = t(e.L)
}(this, function (e) {
  return function (e) {
    function t(n) {
      if (o[n]) {
        return o[n].exports;
      }
      var r = o[n] = {exports: {}, id: n, loaded: !1};
      return e[n].call(r.exports, r, r.exports, t), r.loaded = !0, r.exports
    }

    var o = {};
    return t.m = e, t.c = o, t.p = "", t(0)
  }([function (e, t, o) {
    "use strict";

    function n(e) {
      return e && e.__esModule ? e : {"default": e}
    }

    Object.defineProperty(t, "__esModule", {value: !0}), t.Icon = t.VectorMarkers = void 0;
    var r = o(2), i = n(r), s = o(3), a = n(s), c = o(1), l = n(c);
    t.VectorMarkers = a["default"], t.Icon = l["default"], i["default"].VectorMarkers = a["default"]
  }, function (e, t, o) {
    "use strict";

    function n(e) {
      return e && e.__esModule ? e : {"default": e}
    }

    function r(e, t) {
      if (!(e instanceof t)) {
        throw new TypeError("Cannot call a class as a function")
      }
    }

    function i(e, t) {
      if (!e) {
        throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
      }
      return !t || "object" != typeof t && "function" != typeof t ? e : t
    }

    function s(e, t) {
      if ("function" != typeof t && null !== t) {
        throw new TypeError("Super expression must either be null or a function, not " + typeof t);
      }
      e.prototype = Object.create(t && t.prototype, {
        constructor: {
          value: e,
          enumerable: !1,
          writable: !0,
          configurable: !0
        }
      }), t && (Object.setPrototypeOf ? Object.setPrototypeOf(e, t) : e.__proto__ = t)
    }

    Object.defineProperty(t, "__esModule", {value: !0});
    var a = function () {
          function e(e, t) {
            for (var o = 0; o < t.length; o++) {
              var n = t[o];
              n.enumerable = n.enumerable || !1, n.configurable = !0, "value" in n && (n.writable = !0), Object.defineProperty(e, n.key, n)
            }
          }

          return function (t, o, n) {
            return o && e(t.prototype, o), n && e(t, n), t
          }
        }(), c = o(2), l = n(c), u = {
          iconSize: [30, 30],
          iconAnchor: [15, 15],
          popupAnchor: [5, 0],
          shadowAnchor: [0, 0],
          shadowSize: [0, 0],
          className: "vector-marker",
          prefix: "fa",
          spinClass: "fa-spin",
          extraIconClasses: "",
          extraDivClasses: "",
          icon: "home",
          markerColor: "blue",
          iconColor: "white",
          viewBox: "0 0 32 52"
        },
        f = "M16,1 C7.7146,1 1,7.65636364 1,15.8648485 C1,24.0760606 16,51 16,51 C16,51 31,24.0760606 31,15.8648485 C31,7.65636364 24.2815,1 16,1 L16,1 Z",
        p = function (e) {
          function t(e) {
            r(this, t);
            var o = i(this, Object.getPrototypeOf(t).call(this, e));
            return l["default"].Util.setOptions(o, u), l["default"].Util.setOptions(o, e), o
          }

          return s(t, e), a(t, [{
            key: "createIcon", value: function (e) {
              var t = e && "DIV" === e.tagName ? e : document.createElement("div"),
                  o = this.options, n = o.map_pin || f;
              return t.innerHTML = '<svg width="40px" height="40px" viewBox="0 0 40 40" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">\n' +
                  '    <!-- Generator: Sketch 54.1 (76490) - https://sketchapp.com -->\n' +
                  '    <title>pin</title>\n' +
                  '    <desc>Created with Sketch.</desc>\n' +
                  '    <g id="-" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\n' +
                  '        <g id="03.01---POI---Lista" transform="translate(-755.000000, -2162.000000)" fill="'+o.markerColor+'">\n' + //'+o.markerColor+' //#D0021B
                  '            <g id="mappa" transform="translate(100.000000, 1877.000000)">\n' +
                  '                <g id="Group" transform="translate(535.000000, 125.000000)">\n' +
                  '                    <g id="Map/Pin" transform="translate(120.000000, 160.000000)">\n' +
                  '                        <g id="pin">\n' +
                  '                            <circle id="Oval-2" fill-rule="nonzero" opacity="0.18" cx="20" cy="20" r="20"></circle>\n' +
                  '                            <circle id="Oval-2" stroke="#FFFFFF" stroke-width="4" fill-rule="nonzero" cx="20" cy="20" r="12"></circle>\n' +
                  '                        </g>\n' +
                  '                    </g>\n' +
                  '                </g>\n' +
                  '            </g>\n' +
                  '        </g>\n' +
                  '    </g>\n' +
                  '</svg>', o.icon && t.appendChild(this._createInner()), o.className += o.className.length > 0 ? " " + o.extraDivClasses : o.extraDivClasses, this._setIconStyles(t, "icon"), this._setIconStyles(t, "icon-" + o.markerColor), t
            }
          }, {
            key: "createShadow", value: function () {
              var e = document.createElement("div");
              return this._setIconStyles(e, "shadow"), e
            }
          }, {
            key: "_createInner", value: function () {
              var e = document.createElement("i"), t = this.options;
              return e.classList.add(t.prefix), t.extraClasses && e.classList.add(t.extraClasses), t.icon.slice(0, t.prefix.length + 1) === t.prefix + "-" ? e.classList.add(t.icon) : e.classList.add(t.prefix + "-" + t.icon), t.spin && "string" == typeof t.spinClass && e.classList.add(t.spinClass), t.iconColor && ("white" === t.iconColor || "black" === t.iconColor ? e.classList.add("icon-" + t.iconColor) : e.style.color = t.iconColor), t.iconSize && (e.style.width = t.iconSize[0] + "px"), e
            }
          }, {
            key: "_setIconStyles", value: function (e, t) {
              var o = this.options,
                  n = l["default"].point(o["shadow" === t ? "shadowSize" : "iconSize"]),
                  r = void 0;
              r = "shadow" === t ? l["default"].point(o.shadowAnchor || o.iconAnchor) : l["default"].point(o.iconAnchor), !r && n && (r = n.divideBy(2, !0)), e.className = "vector-marker-" + t + " " + o.className, r && (e.style.marginLeft = -r.x + "px", e.style.marginTop = -r.y + "px"), n && (e.style.width = n.x + "px", e.style.height = n.y + "px")
            }
          }]), t
        }(l["default"].Icon);
    t["default"] = p
  }, function (t, o) {
    t.exports = e
  }, function (e, t, o) {
    "use strict";

    function n(e) {
      return e && e.__esModule ? e : {"default": e}
    }

    Object.defineProperty(t, "__esModule", {value: !0});
    var r = o(1), i = n(r);
    t["default"] = {
      version: "1.0.0", Icon: i["default"], icon: function (e) {
        return new i["default"](e)
      }
    }
  }])
});