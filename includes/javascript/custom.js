$(document).ready(function() {
	// jwg -- for benefit of css styling for IE
	var uA = navigator.userAgent;
	var browser = null;
	var ieVersion = null;

	if (uA.indexOf('MSIE 6') >= 0) {
		browser = 'IE';
		ieVersion = 6;
	}
	if (uA.indexOf('MSIE 7') >= 0) {
		browser = 'IE';
		ieVersion = 7;
	}
	if (document.documentMode) { // as of IE8
		browser = 'IE';
		ieVersion = document.documentMode;
	}
	if (browser == 'IE') {
		$('body').addClass('ie');
	}
});

function displayMessagePart() {
    alert("fs");
    setTimeout(function() {
        $("#msgPart").fadeOut(1200, "linear")
    }, 9000)
}
function initCorners() {}
if (curveyCornerFlag) {}(function(a) {
    a.fn.extend({
        donetyping: function(e, c) {
            c = c || 1000;
            var d, b = function(f) {
                if (!d) {
                    return
                }
                d = null;
                e.call(f)
            };
            return this.each(function(f, g) {
                var h = a(g);
                h.is(":input") && h.keypress(function() {
                    if (d) {
                        clearTimeout(d)
                    }
                    d = setTimeout(function() {
                        b(g)
                    }, c)
                }).blur(function() {
                    b(g)
                })
            })
        }
    })
})(jQuery);
var requests = new Array();

function kill_req() {
    if (requests != null) {
        for (var a = 0; a < requests.length; a++) {
            requests[a].abort()
        }
    }
}
$(function() {
    $("#closeMsgPart").click(function() {
		if ($('#msgPart').length) {
			$("#msgPart").fadeOut(1000, "linear");
		}
		if ($('#errorMessage').length) {
			$("#errorMessage").fadeOut(1000, "linear");
		}
    });
    setTimeout(function() {
        $("#msgPart").fadeOut(1200, "linear")
    }, 9000);
    var a;
    var b;
    var c;
    var d = false;
var theModelCarousel = null;
function modelCarousel_initCallback(carousel) {
theModelCarousel = carousel;
// Callback functuions if needed
};
    $("#searchInputBox").donetyping(function() {
        var e = $("#searchInputBox").val().length;
        if (e >= 4) {
            $.when(kill_req()).done(function(f) {
                requests.push($.ajax({
                    type: "POST",
                    url: application_path + "modules/search/index.php",
                    beforeSend: function() {
                        $(".cs_cont").hide();
                        $(".suggestion_loading").fadeIn(function() {
                            $("#search_results-wrap").removeClass("no_found");
                            if ($("#search_results-wrap").is(":hidden")) {
                                $("#search_results-wrap").slideDown("slow")
                            }
                            $("#SearchCarousel").removeData();
                            $("#SearchCarousel").html("")
                        })
                    },
                    data: {
                        term: $("#searchInputBox").val()
                    },
                    success: function(g) {
                        console.log("b");
						
                        if (g != 0 && g != "") {
							
                            $(".suggestion_loading").fadeOut(function() {
                                $("#SearchCarousel").removeData();
                                $("#SearchCarousel").html("");
                                $("#SearchCarousel").html(g);
                                $(".cs_cont").fadeIn();
                                c = $("#SearchCarousel").jcarousel({
									initCallback: modelCarousel_initCallback,
                                    auto: 0,
                                    scroll: 4
                                });
								
                               /* if (typeof(b) !== "undefined") {
                                    $("#SearchCarousel").data("jcarousel").reload()
                                }*/
								if (typeof(theModelCarousel) !== "undefined" && theModelCarousel!=null) {
                                  theModelCarousel.reload()
                                }
                                b = c;
                                initCorners()
                            })
                        } else {
                            $(".suggestion_loading").fadeOut(function() {
                                $(".cs_cont").fadeIn();
								
                                /*if (typeof(b) !== "undefined") {
                                    $("#SearchCarousel").data("jcarousel").reset()
                                }*/
								
								if (typeof(theModelCarousel) !== "undefined" && theModelCarousel!=null) {
                                    theModelCarousel.reset();
                               }
                                $("#SearchCarousel").removeData();
								$("#SearchCarousel").removeAttr('style');
                                $("#SearchCarousel").html("");
                                $("#search_results-wrap").addClass("no_found");
                                $("#SearchCarousel").html("<li><span>No Result Found.</span></li>")
                            })
                        }
                    }
                }))
            })
        }
    });
    $("#searchBoxFooter").keypress(function() {
        var e = $("#searchBoxFooter").val().length;
        if (e >= 3) {
            $.ajax({
                type: "POST",
                url: application_path + "modules/search/index.php",
                data: {
                    str: $("#searchBoxFooter").val()
                }
            }).done(function(f) {
                if (f != "0") {
                    $("#search_results-wrap").css("display", "block");
                    $("#SearchCarousel").fadeOut();
                    $("#SearchCarousel").data("jcarousel").reset();
                    $("#SearchCarousel").jcarousel({
                        auto: 0,
                        scroll: 4
                    });
                    initCorners()
                } else {
                    $("#search_results-wrap").css("display", "block");
                    $("#SearchCarousel").fadeOut();
                    $("#SearchCarousel").html("<li><span>No Result Found.</span></li>")
                }
            })
        }
    });
    $("#closeSearch").click(function() {
        $("#search_results-wrap").slideUp("slow", function() {
            $(".cs_cont").fadeOut();
            if (typeof(b) !== "undefined") {
                $("#SearchCarousel").data("jcarousel").reset()
            }
            $("#SearchCarousel").html("");
            $("#searchInputBox").val("")
        })
    })
});