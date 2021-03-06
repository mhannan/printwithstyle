// MSDropDown - jquery.dd.js
// author: Abu Safa - Search me on google
// Date: 20th Jun, 2012
// Version: 2.38.4
// Revision: 38

;;
(function ($) {
    var bB = "";
    var bC = function (s, u) {
        var v = s;
        var x = this;
        var u = $.extend({
            height: 120,
            visibleRows: 7,
            rowHeight: 23,
            showIcon: true,
            zIndex: 9999,
            mainCSS: 'dd',
            useSprite: false,
            animStyle: 'slideDown',
            onInit: '',
            jsonTitle: true,
            style: ''
        }, u);
        this.ddProp = new Object();
        var y = "";
        var z = {};
        z.insideWindow = true;
        z.keyboardAction = false;
        z.currentKey = null;
        var A = false;
        var B = {
            postElementHolder: '_msddHolder',
            postID: '_msdd',
            postTitleID: '_title',
            postTitleTextID: '_titletext',
            postChildID: '_child',
            postAID: '_msa',
            postOPTAID: '_msopta',
            postInputID: '_msinput',
            postArrowID: '_arrow',
            postInputhidden: '_inp'
        };
        var C = {
            dd: u.mainCSS,
            ddTitle: 'ddTitle',
            arrow: 'arrow',
            ddChild: 'ddChild',
            ddTitleText: 'ddTitleText',
            disabled: .30,
            ddOutOfVision: 'ddOutOfVision',
            borderTop: 'borderTop',
            noBorderTop: 'noBorderTop',
            selected: 'selected'
        };
        var D = {
            actions: "focus,blur,change,click,dblclick,mousedown,mouseup,mouseover,mousemove,mouseout,keypress,keydown,keyup",
            prop: "size,multiple,disabled,tabindex"
        };
        this.onActions = new Object();
        var E = $(v).prop("id");
        if (typeof (E) == "undefined" || E.length <= 0) {
            E = "msdrpdd" + $.msDropDown.counter++;
            $(v).attr("id", E)
        };
        var F = $(v).prop("style");
        u.style += (F == undefined) ? "" : F;
        var G = $(v).children();
        A = ($(v).prop("size") > 1 || $(v).prop("multiple") == true) ? true : false;
        if (A) {
            u.visibleRows = $(v).prop("size")
        };
        var H = {};
        var I = 0;
        var J = false;
        var K;
        var L = false;
        var M = {};
        var N = "";
        var O = function (a) {
            if (typeof (M[a]) == "undefined") {
                M[a] = document.getElementById(a)
            }
            return M[a]
        };
        var P = function (a) {
            return E + B[a]
        };
        var Q = function (a) {
            var b = a;
            var c = $(b).prop("style");
            return (typeof c == "undefined") ? "" : c.cssText
        };
        var R = function (a) {
            var b = $("#" + E + " option:selected");
            if (b.length > 1) {
                for (var i = 0; i < b.length; i++) {
                    if (a == b[i].index) {
                        return true
                    }
                }
            } else if (b.length == 1) {
                if (b[0].index == a) {
                    return true
                }
            };
            return false
        };
        var S = function (a, b, c, d) {
            var e = "";
            var f = (d == "opt") ? P("postOPTAID") : P("postAID");
            var g = (d == "opt") ? f + "_" + (b) + "_" + (c) : f + "_" + (b);
            var h = "";
            var t = "";
            var i = "";
            var j = "";
            if (u.useSprite != false) {
                i = ' ' + u.useSprite + ' ' + a.className
            } else {
                h = $(a).prop("title");
                var k = new RegExp(/^\{.*\}$/);
                var l = k.test(h);
                if (u.jsonTitle == true && l == true) {
                    if (h.length != 0) {
                        var m = eval("[" + h + "]");
                        img = (typeof m[0].image == "undefined") ? "" : m[0].image;
                        t = (typeof m[0].title == "undefined") ? "" : m[0].title;
                        j = (typeof m[0].postHTML == "undefined") ? "" : m[0].postHTML;
                        h = (img.length == 0) ? "" : '<img src="' + img + '" align="absmiddle" /> '
                    }
                } else {
                    h = (h.length == 0) ? "" : '<img src="' + h + '" align="absmiddle" /> '
                }
            };
            var n = $(a).text();
            var o = $(a).val();
            var p = ($(a).prop("disabled") == true) ? "disabled" : "enabled";
            H[g] = {
                html: h + n,
                value: o,
                text: n,
                index: a.index,
                id: g,
                title: t
            };
            var q = Q(a);
            if (R(a.index) == true) {
                e += '<a href="javascript:void(0);" class="' + C.selected + ' ' + p + i + '"'
            } else {
                e += '<a  href="javascript:void(0);" class="' + p + i + '"'
            };
            if (q !== false && q !== undefined && q.length != 0) {
                e += " style='" + q + "'"
            };
            if (t !== "") {
                e += " title='" + t + "'"
            };
            e += ' id="' + g + '">';
            e += h + '<span class="' + C.ddTitleText + '">' + n + '</span>';
            if (j !== "") {
                e += j
            };
            e += '</a>';
            return e
        };
        var T = function (t) {
            var b = t.toLowerCase();
            if (b.length == 0) return -1;
            var a = "";
            for (var i in H) {
                var c = H[i].text.toLowerCase();
                if (c.substr(0, b.length) == b) {
                    a += "#" + H[i].id + ", "
                }
            };
            return (a == "") ? -1 : a
        };
        var U = function () {
            var f = G;
            if (f.length == 0) return "";
            var g = "";
            var h = P("postAID");
            var i = P("postOPTAID");
            f.each(function (c) {
                var d = f[c];
                if (d.nodeName.toString().toLowerCase() == "optgroup") {
                    g += "<div class='opta'>";
                    g += "<span style='font-weight:bold;font-style:italic;clear:both;'>" + $(d).prop("label") + "</span>";
                    var e = $(d).children();
                    e.each(function (a) {
                        var b = e[a];
                        g += S(b, c, a, "opt")
                    });
                    g += "</div>"
                } else {
                    g += S(d, c, "", "")
                }
            });
            return g
        };
        var V = function () {
            var a = P("postID");
            var b = P("postChildID");
            var c = u.style;
            sDiv = "";
            sDiv += '<div id="' + b + '" class="' + C.ddChild + '"';
            if (!A) {
                sDiv += (c != "") ? ' style="' + c + '"' : ''
            } else {
                sDiv += (c != "") ? ' style="border-top:1px solid #c3c3c3;display:block;position:relative;' + c + '"' : ''
            };
            sDiv += '>';
            return sDiv
        };
        var W = function () {
            var a = P("postTitleID");
            var b = P("postArrowID");
            var c = P("postTitleTextID");
            var d = P("postInputhidden");
            var e = "";
            var f = "";
            if (O(E).options.length > 0) {
                e = $("#" + E + " option:selected").text();
                f = $("#" + E + " option:selected").prop("title")
            };
            var g = "";
            var t = "";
            var h = new RegExp(/^\{.*\}$/);
            var i = h.test(f);
            if (u.jsonTitle == true && i == true) {
                if (f.length != 0) {
                    var j = eval("[" + f + "]");
                    g = (typeof j[0].image == "undefined") ? "" : j[0].image;
                    t = (typeof j[0].title == "undefined") ? "" : j[0].title;
                    f = (g.length == 0 || u.showIcon == false || u.useSprite != false) ? "" : '<img src="' + g + '" align="absmiddle" /> '
                }
            } else {
                f = (f.length == 0 || f == undefined || u.showIcon == false || u.useSprite != false) ? "" : '<img src="' + f + '" align="absmiddle" /> '
            };
            var k = '<div id="' + a + '" class="' + C.ddTitle + '"';
            k += '>';
            k += '<span id="' + b + '" class="' + C.arrow + '"></span><span class="' + C.ddTitleText + '" id="' + c + '">' + f + '<span class="' + C.ddTitleText + '">' + e + '</span></span></div>';
            return k
        };
        var X = function () {
            var c = P("postChildID");
            $("#" + c + " a.enabled").unbind("click");
            $("#" + c + " a.enabled").bind("click", function (a) {
                a.preventDefault();
                bD(this);
                bO();
                if (!A) {
                    $("#" + c).unbind("mouseover");
                    bF(false);
                    var b = (u.showIcon == false) ? $(this).text() : $(this).html();
                    bJ(b);
                    x.close()
                }
            })
        };
        var Y = function () {
            var d = false;
            var e = P("postID");
            var f = P("postTitleID");
            var g = P("postTitleTextID");
            var h = P("postChildID");
            var i = P("postArrowID");
            var j = $("#" + E).outerWidth();
            var k = u.style;
            if ($("#" + e).length > 0) {
                $("#" + e).remove();
                d = true
            };
            var l = '<div id="' + e + '" class="' + C.dd + '"';
            l += (k != "") ? ' style="' + k + '"' : '';
            l += '>';
            l += W();
            l += V();
            l += U();
            l += "</div>";
            l += "</div>";
            if (d == true) {
                var m = P("postElementHolder");
                $("#" + m).after(l)
            } else {
                $("#" + E).after(l)
            };
            if (A) {
                var f = P("postTitleID");
                $("#" + f).hide()
            };
            $("#" + e).css("width", j + "px");
            $("#" + h).css("width", (j - 2) + "px");
            if (G.length > u.visibleRows) {
                var n = parseInt($("#" + h + " a:first").css("padding-bottom")) + parseInt($("#" + h + " a:first").css("padding-top"));
                var o = ((u.rowHeight) * u.visibleRows) - n;
                $("#" + h).css("height", o + "px")
            } else if (A) {
                var o = $("#" + E).height();
                $("#" + h).css("height", o + "px")
            };
            if (d == false) {
                bI();
                bE(E)
            };
            if ($("#" + E).prop("disabled") == true) {
                $("#" + e).css("opacity", C.disabled)
            };
            bH();
            $("#" + f).bind("mouseover", function (a) {
                bS(1)
            });
            $("#" + f).bind("mouseout", function (a) {
                bS(0)
            });
            X();
            $("#" + h + " a.disabled").css("opacity", C.disabled);
            if (A) {
                $("#" + h).bind("mouseover", function (c) {
                    if (!z.keyboardAction) {
                        z.keyboardAction = true;
                        $(document).bind("keydown", function (a) {
                            var b = a.keyCode;
                            z.currentKey = b;
                            if (b == 39 || b == 40) {
                                a.preventDefault();
                                a.stopPropagation();
                                bL();
                                bO()
                            };
                            if (b == 37 || b == 38) {
                                a.preventDefault();
                                a.stopPropagation();
                                bM();
                                bO()
                            }
                        })
                    }
                })
            };
            $("#" + h).bind("mouseout", function (a) {
                bF(false);
                $(document).unbind("keydown", bZ);
                z.keyboardAction = false;
                z.currentKey = null
            });
            $("#" + f).bind("click", function (b) {
                bF(false);
                if ($("#" + h + ":visible").length == 1) {
                    $("#" + h).unbind("mouseover")
                } else {
                    $("#" + h).bind("mouseover", function (a) {
                        bF(true)
                    });
                    x.open()
                }
            });
            $("#" + f).bind("mouseout", function (a) {
                bF(false)
            });
            if (u.showIcon && u.useSprite != false) {
                bN()
            }
        };
        var Z = function (a) {
            for (var i in H) {
                if (H[i].index == a) {
                    return H[i]
                }
            };
            return -1
        };
        var bD = function (a) {
            var b = P("postChildID");
            if ($("#" + b + " a." + C.selected).length == 1) {
                y = $("#" + b + " a." + C.selected).text()
            };
            if (!A) {
                $("#" + b + " a." + C.selected).removeClass(C.selected)
            };
            var c = $("#" + b + " a." + C.selected).prop("id");
            if (c != undefined) {
                var d = (z.oldIndex == undefined || z.oldIndex == null) ? H[c].index : z.oldIndex
            };
            if (a && !A) {
                $(a).addClass(C.selected)
            };
            if (A) {
                var e = z.currentKey;
                if ($("#" + E).prop("multiple") == true) {
                    if (e == 17) {
                        z.oldIndex = H[$(a).prop("id")].index;
                        $(a).toggleClass(C.selected)
                    } else if (e == 16) {
                        $("#" + b + " a." + C.selected).removeClass(C.selected);
                        $(a).addClass(C.selected);
                        var f = $(a).prop("id");
                        var g = H[f].index;
                        for (var i = Math.min(d, g); i <= Math.max(d, g); i++) {
                            $("#" + Z(i).id).addClass(C.selected)
                        }
                    } else {
                        $("#" + b + " a." + C.selected).removeClass(C.selected);
                        $(a).addClass(C.selected);
                        z.oldIndex = H[$(a).prop("id")].index
                    }
                } else {
                    $("#" + b + " a." + C.selected).removeClass(C.selected);
                    $(a).addClass(C.selected);
                    z.oldIndex = H[$(a).prop("id")].index
                }
            }
        };
        var bE = function (a) {
            var b = a;
            O(b).refresh = function (e) {
                $("#" + b).msDropDown(u)
            }
        };
        var bF = function (a) {
            z.insideWindow = a
        };
        var bG = function () {
            return z.insideWindow
        };
        var bH = function () {
            var b = P("postID");
            var c = D.actions.split(",");
            for (var d = 0; d < c.length; d++) {
                var e = c[d];
                var f = bP(e);
                if (f == true) {
                    switch (e) {
                        case "focus":
                            $("#" + b).bind("mouseenter", function (a) {
                                O(E).focus()
                            });
                            break;
                        case "click":
                            $("#" + b).bind("click", function (a) {
                                $("#" + E).trigger("click")
                            });
                            break;
                        case "dblclick":
                            $("#" + b).bind("dblclick", function (a) {
                                $("#" + E).trigger("dblclick")
                            });
                            break;
                        case "mousedown":
                            $("#" + b).bind("mousedown", function (a) {
                                $("#" + E).trigger("mousedown")
                            });
                            break;
                        case "mouseup":
                            $("#" + b).bind("mouseup", function (a) {
                                $("#" + E).trigger("mouseup")
                            });
                            break;
                        case "mouseover":
                            $("#" + b).bind("mouseover", function (a) {
                                $("#" + E).trigger("mouseover")
                            });
                            break;
                        case "mousemove":
                            $("#" + b).bind("mousemove", function (a) {
                                $("#" + E).trigger("mousemove")
                            });
                            break;
                        case "mouseout":
                            $("#" + b).bind("mouseout", function (a) {
                                $("#" + E).trigger("mouseout")
                            });
                            break
                    }
                }
            }
        };
        var bI = function () {
            var a = P("postElementHolder");
            $("#" + E).after("<div class='" + C.ddOutOfVision + "' style='height:0px;overflow:hidden;position:absolute;' id='" + a + "'></div>");
            $("#" + E).appendTo($("#" + a))
        };
        var bJ = function (a) {
            var b = P("postTitleTextID");
            $("#" + b).html(a)
        };
        var bK = function (w) {
            var a = w;
            var b = P("postChildID");
            var c = $("#" + b + " a:visible");
            var d = c.length;
            var e = $("#" + b + " a:visible").index($("#" + b + " a.selected:visible"));
            var f;
            switch (a) {
                case "next":
                    if (e < d - 1) {
                        e++;
                        f = c[e]
                    };
                    break;
                case "previous":
                    if (e < d && e > 0) {
                        e--;
                        f = c[e]
                    };
                    break
            };
            if (typeof (f) == "undefined") {
                return false
            };
            $("#" + b + " a." + C.selected).removeClass(C.selected);
            $(f).addClass(C.selected);
            var g = f.id;
            if (!A) {
                var h = (u.showIcon == false) ? H[g].text : $("#" + g).html();
                bJ(h);
                bN(H[g].index)
            };
            if (a == "next") {
                if (parseInt(($("#" + g).position().top + $("#" + g).height())) >= parseInt($("#" + b).height())) {
                    $("#" + b).scrollTop(($("#" + b).scrollTop()) + $("#" + g).height() + $("#" + g).height())
                }
            } else {
                if (parseInt(($("#" + g).position().top + $("#" + g).height())) <= 0) {
                    $("#" + b).scrollTop(($("#" + b).scrollTop() - $("#" + b).height()) - $("#" + g).height())
                }
            }
        };
        var bL = function () {
            bK("next")
        };
        var bM = function () {
            bK("previous")
        };
        var bN = function (i) {
            if (u.useSprite != false) {
                var a = P("postTitleTextID");
                var b = (typeof (i) == "undefined") ? O(E).selectedIndex : i;
                var c = O(E).options[b].className;
                if (c.length > 0) {
                    var d = P("postChildID");
                    var e = $("#" + d + " a." + c).prop("id");
                    var f = $("#" + e).css("background-image");
                    var g = $("#" + e).css("background-position");
                    if (g == undefined) {
                        g = $("#" + e).css("background-position-x") + " " + $("#" + e).css("background-position-y")
                    };
                    var h = $("#" + e).css("padding-left");
                    if (f != undefined) {
                        $("#" + a).find("." + C.ddTitleText).attr('style', "background:" + f)
                    };
                    if (g != undefined) {
                        $("#" + a).find("." + C.ddTitleText).css('background-position', g)
                    };
                    if (h != undefined) {
                        $("#" + a).find("." + C.ddTitleText).css('padding-left', h)
                    };
                    $("#" + a).find("." + C.ddTitleText).css('background-repeat', 'no-repeat');
                    $("#" + a).find("." + C.ddTitleText).css('padding-bottom', '2px')
                }
            }
        };
        var bO = function () {
            var a = P("postChildID");
            var b = $("#" + a + " a." + C.selected);
            if (b.length == 1) {
                var c = $("#" + a + " a." + C.selected).text();
                var d = $("#" + a + " a." + C.selected).prop("id");
                if (d != undefined) {
                    var e = H[d].value;
                    O(E).selectedIndex = H[d].index
                };
                if (u.showIcon && u.useSprite != false) bN()
            } else if (b.length > 1) {
                for (var i = 0; i < b.length; i++) {
                    var d = $(b[i]).prop("id");
                    var f = H[d].index;
                    O(E).options[f].selected = "selected"
                }
            };
            var g = O(E).selectedIndex;
            x.ddProp["selectedIndex"] = g
        };
        var bP = function (a) {
            if ($("#" + E).prop("on" + a) != undefined) {
                return true
            };
            var b = $("#" + E).data("events");
            if (b && b[a]) {
                return true
            };
            return false
        };
        var bQ = function (a) {
            $("#" + E).focus();
            $("#" + E)[0].blur();
            bO();
            $(document).unbind("mouseup", ca);
            $(document).unbind("mouseup", bQ)
        };
        var bR = function () {
            var a = P("postChildID");
            if (bP('change') == true) {
                var b = H[$("#" + a + " a.selected").prop("id")].text;
                if ($.trim(y) !== $.trim(b) && y !== "") {
                    $("#" + E).trigger("change")
                }
            };
            if (bP('mouseup') == true) {
                $("#" + E).trigger("mouseup")
            };
            if (bP('blur') == true) {
                $(document).bind("mouseup", bQ)
            };
            return false
        };
        var bS = function (a) {
            var b = P("postArrowID");
            if (a == 1) $("#" + b).css({
                backgroundPosition: '0 100%'
            });
            else $("#" + b).css({
                backgroundPosition: '0 0'
            })
        };
        var bT = function () {
            for (var i in O(E)) {
                if (typeof (O(E)[i]) !== 'function' && typeof (O(E)[i]) !== "undefined" && typeof (O(E)[i]) !== "null") {
                    x.set(i, O(E)[i], true)
                }
            }
        };
        var bU = function (a, b) {
            if (Z(b) != -1) {
                O(E)[a] = b;
                var c = P("postChildID");
                $("#" + c + " a." + C.selected).removeClass(C.selected);
                $("#" + Z(b).id).addClass(C.selected);
                var d = Z(O(E).selectedIndex).html;
                bJ(d)
            }
        };
        var bV = function (i, a) {
            if (a == 'd') {
                for (var b in H) {
                    if (H[b].index == i) {
                        delete H[b];
                        break
                    }
                }
            };
            var c = 0;
            for (var b in H) {
                H[b].index = c;
                c++
            }
        };
        var bW = function () {
            var a = P("postChildID");
            var b = P("postID");
            var c = $("#" + b).offset();
            var d = $("#" + b).height();
            var e = $(window).height();
            var f = $(window).scrollTop();
            var g = $("#" + a).height();
            var h = {
                zIndex: u.zIndex,
                top: (d) + "px",
                display: "none"
            };
            var i = u.animStyle;
            var j = false;
            var k = C.noBorderTop;
            $("#" + a).removeClass(C.noBorderTop);
            $("#" + a).removeClass(C.borderTop);
            if ((e + f) < Math.floor(g + d + c.top)) {
                var l = g;
                h = {
                    zIndex: u.zIndex,
                    top: "-" + l + "px",
                    display: "none"
                };
                i = "show";
                j = true;
                k = C.borderTop
            };
            return {
                opp: j,
                ani: i,
                css: h,
                border: k
            }
        };
        var bX = function () {
            if (x.onActions["onOpen"] != null) {
                eval(x.onActions["onOpen"])(x)
            }
        };
        var bY = function () {
            bR();
            if (x.onActions["onClose"] != null) {
                eval(x.onActions["onClose"])(x)
            }
        };
        var bZ = function (a) {
            var b = P("postChildID");
            var c = a.keyCode;
            if (c == 8) {
                a.preventDefault();
                a.stopPropagation();
                N = (N.length == 0) ? "" : N.substr(0, N.length - 1)
            };
            switch (c) {
                case 39:
                case 40:
                    a.preventDefault();
                    a.stopPropagation();
                    bL();
                    break;
                case 37:
                case 38:
                    a.preventDefault();
                    a.stopPropagation();
                    bM();
                    break;
                case 27:
                case 13:
                    x.close();
                    bO();
                    break;
                default:
                    if (c > 46) {
                        N += String.fromCharCode(c)
                    };
                    var d = T(N);
                    if (d != -1) {
                        $("#" + b).css({
                            height: 'auto'
                        });
                        $("#" + b + " a").hide();
                        $(d).show();
                        var e = bW();
                        $("#" + b).css(e.css);
                        $("#" + b).css({
                            display: 'block'
                        })
                    } else {
                        $("#" + b + " a").show();
                        $("#" + b).css({
                            height: K + 'px'
                        })
                    };
                    break
            };
            if (bP("keydown") == true) {
                O(E).onkeydown()
            };
            return false
        };
        var ca = function (a) {
            if (bG() == false) {
                x.close()
            };
            return false
        };
        var cb = function (a) {
            if ($("#" + E).prop("onkeyup") != undefined) {
                O(E).onkeyup()
            };
            return false
        };
        this.open = function () {
            if ((x.get("disabled", true) == true) || (x.get("options", true).length == 0)) return;
            var a = P("postChildID");
            if (bB != "" && a != bB) {
                $("#" + bB).slideUp("fast");
                $("#" + bB).css({
                    zIndex: '0'
                })
            };
            if ($("#" + a).css("display") == "none") {
                y = H[$("#" + a + " a.selected").prop("id")].text;
                N = "";
                K = $("#" + a).height();
                $("#" + a + " a").show();
                $(document).bind("keydown", bZ);
                $(document).bind("keyup", cb);
                $(document).bind("mouseup", ca);
                var b = bW();
                $("#" + a).css(b.css);
                if (b.opp == true) {
                    $("#" + a).css({
                        display: 'block'
                    });
                    $("#" + a).addClass(b.border);
                    bX()
                } else {
                    $("#" + a)[b.ani]("fast", function () {
                        $("#" + a).addClass(b.border);
                        bX()
                    })
                };
                if (a != bB) {
                    bB = a
                }
            }
        };
        this.close = function () {
            var b = P("postChildID");
            if (!$("#" + b).is(":visible") || L) return;
            L = true;
            if ($("#" + b).css("display") == "none") {
                return false
            };
            var c = $("#" + P("postTitleID")).position().top;
            var d = bW();
            J = false;
            if (d.opp == true) {
                $("#" + b).animate({
                    height: 0,
                    top: c
                }, function () {
                    $("#" + b).css({
                        height: K + 'px',
                        display: 'none'
                    });
                    bY();
                    L = false
                })
            } else {
                $("#" + b).slideUp("fast", function (a) {
                    bY();
                    $("#" + b).css({
                        zIndex: '0'
                    });
                    $("#" + b).css({
                        height: K + 'px'
                    });
                    L = false
                })
            };
            bN();
            $(document).unbind("keydown", bZ);
            $(document).unbind("keyup", cb);
            $(document).unbind("mouseup", ca)
        };
        this.selectedIndex = function (i) {
            if (typeof (i) == "undefined") {
                return x.get("selectedIndex")
            } else {
                x.set("selectedIndex", i)
            }
        };
        this.debug = function (a) {
            if (typeof (a) == "undefined" || a == true) {
                $("." + C.ddOutOfVision).removeAttr("style")
            } else {
                $("." + C.ddOutOfVision).attr("style", "height:0px;overflow:hidden;position:absolute")
            }
        };
        this.set = function (a, b, c) {
            if (typeof a == "undefined" || typeof b == "undefined") return false;
            x.ddProp[a] = b;
            if (c != true) {
                switch (a) {
                    case "selectedIndex":
                        bU(a, b);
                        break;
                    case "disabled":
                        x.disabled(b, true);
                        break;
                    case "multiple":
                        O(E)[a] = b;
                        A = ($(v).prop("size") > 0 || $(v).prop("multiple") == true) ? true : false;
                        if (A) {
                            var d = $("#" + E).height();
                            var f = P("postChildID");
                            $("#" + f).css("height", d + "px");
                            var g = P("postTitleID");
                            $("#" + g).hide();
                            var f = P("postChildID");
                            $("#" + f).css({
                                display: 'block',
                                position: 'relative'
                            });
                            X()
                        };
                        break;
                    case "size":
                        O(E)[a] = b;
                        if (b == 0) {
                            O(E).multiple = false
                        };
                        A = ($(v).prop("size") > 0 || $(v).prop("multiple") == true) ? true : false;
                        if (b == 0) {
                            var g = P("postTitleID");
                            $("#" + g).show();
                            var f = P("postChildID");
                            $("#" + f).css({
                                display: 'none',
                                position: 'absolute'
                            });
                            var h = "";
                            if (O(E).selectedIndex >= 0) {
                                var i = Z(O(E).selectedIndex);
                                h = i.html;
                                bD($("#" + i.id))
                            };
                            bJ(h)
                        } else {
                            var g = P("postTitleID");
                            $("#" + g).hide();
                            var f = P("postChildID");
                            $("#" + f).css({
                                display: 'block',
                                position: 'relative'
                            })
                        };
                        break;
                    default:
                        try {
                            O(E)[a] = b
                        } catch (e) {};
                        break
                }
            }
        };
        this.get = function (a, b) {
            if (a == undefined && b == undefined) {
                return x.ddProp
            };
            if (a != undefined && b == undefined) {
                return (x.ddProp[a] != undefined) ? x.ddProp[a] : null
            };
            if (a != undefined && b != undefined) {
                return O(E)[a]
            }
        };
        this.visible = function (a) {
            var b = P("postID");
            if (a == true) {
                $("#" + b).show()
            } else if (a == false) {
                $("#" + b).hide()
            } else {
                return $("#" + b).css("display")
            }
        };
        this.add = function (a, b) {
            var c = a;
            var d = c.text;
            var e = (c.value == undefined || c.value == null) ? d : c.value;
            var f = (c["title"] == undefined || c["title"] == null) ? '' : c["title"];
            var i = (b == undefined || b == null) ? O(E).options.length : b;
            O(E).options[i] = new Option(d, e);
            if (f != '') O(E).options[i]["title"] = f;
            var g = Z(i);
            if (g != -1) {
                var h = S(O(E).options[i], i, "", "");
                $("#" + g.id).html(h)
            } else {
                var h = S(O(E).options[i], i, "", "");
                var j = P("postChildID");
                $("#" + j).append(h);
                X()
            }
        };
        this.remove = function (i) {
            O(E).remove(i);
            if ((Z(i)) != -1) {
                $("#" + Z(i).id).remove();
                bV(i, 'd')
            };
            if (O(E).length == 0) {
                bJ("")
            } else {
                var a = Z(O(E).selectedIndex).html;
                bJ(a)
            };
            x.set("selectedIndex", O(E).selectedIndex)
        };
        this.disabled = function (a, b) {
            O(E).disabled = a;
            var c = P("postID");
            if (a == true) {
                $("#" + c).css("opacity", C.disabled);
                x.close()
            } else if (a == false) {
                $("#" + c).css("opacity", 1)
            };
            if (b != true) {
                x.set("disabled", a)
            }
        };
        this.form = function () {
            return (O(E).form == undefined) ? null : O(E).form
        };
        this.item = function () {
            if (arguments.length == 1) {
                return O(E).item(arguments[0])
            } else if (arguments.length == 2) {
                return O(E).item(arguments[0], arguments[1])
            } else {
                throw {
                    message: "An index is required!"
                }
            }
        };
        this.namedItem = function (a) {
            return O(E).namedItem(a)
        };
        this.multiple = function (a) {
            if (typeof (a) == "undefined") {
                return x.get("multiple")
            } else {
                x.set("multiple", a)
            }
        };
        this.size = function (a) {
            if (typeof (a) == "undefined") {
                return x.get("size")
            } else {
                x.set("size", a)
            }
        };
        this.addMyEvent = function (a, b) {
            x.onActions[a] = b
        };
        this.fireEvent = function (a) {
            eval(x.onActions[a])(x)
        };
        this.showRows = function (r) {
            if (typeof r == "undefined" || r == 0) {
                return false
            };
            var a = P("postChildID");
            var b = $("#" + a + " a:first").height();
            var c = (b == 0) ? u.rowHeight : b;
            var d = r * c;
            $("#" + a).css("height", d + "px")
        };
        var cc = function () {
            x.set("version", $.msDropDown.version);
            x.set("author", $.msDropDown.author)
        };
        var cd = function () {
            Y();
            bT();
            cc();
            if (u.onInit != '') {
                eval(u.onInit)(x)
            }
        };
        cd()
    };
    $.msDropDown = {
        version: '2.38.4',
        author: "Marghoob Suleman",
        counter: 20,
        debug: function (v) {
            if (v == true) {
                $(".ddOutOfVision").css({
                    height: '20px',
                    position: 'relative'
                })
            } else {
                $(".ddOutOfVision").css({
                    height: '0px',
                    position: 'absolute'
                })
            }
        },
        create: function (a, b) {
            return $(a).msDropDown(b).data("dd")
        }
    };
    $.fn.extend({
        msDropDown: function (b) {
            return this.each(function () {
                var a = new bC(this, b);
                $(this).data('dd', a)
            })
        }
    });
    if (typeof ($.fn.prop) == 'undefined') {
        $.fn.prop = function (w, v) {
            if (typeof v == "undefined") {
                return $(this).attr(w)
            };
            try {
                $(this).attr(w, v)
            } catch (e) {}
        }
    }
})(jQuery);;