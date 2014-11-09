Raphael.fn.pieChart = function (cx, cy, r, values, labels, stroke, colors ,ids) {	
    var paper = this,
        rad = Math.PI / 180,
        chart = this.set();
    function sector(cx, cy, r, startAngle, endAngle, params) {
        var x1 = cx + r * Math.cos(-startAngle * rad),
            x2 = cx + r * Math.cos(-endAngle * rad),
            y1 = cy + r * Math.sin(-startAngle * rad),
            y2 = cy + r * Math.sin(-endAngle * rad);
        return paper.path(["M", cx, cy, "L", x1, y1, "A", r, r, 0, +(endAngle - startAngle > 180), 0, x2, y2, "z"]).attr(params);
    }
	
    var angle = 0,
        total = 0,
        start = 0,
        process = function (j) {
            var value = values[j],
                angleplus = 360 * value / total,
                popangle = angle + (angleplus / 2),
                color = colors[j],//Raphael.hsb(start, .75, 1),
                ms = 500,
                delta = 30,
                bcolor = colors[j],//Raphael.hsb(start, 1, 1),
                p = sector(cx, cy, r, angle, angle + angleplus, {fill: "90-" + bcolor + "-" + color, stroke: stroke, "stroke-width": 1}),
                txt = paper.text(cx + (r + delta + 30) * Math.cos(-popangle * rad), cy + (r + delta +10) * Math.sin(-popangle * rad), labels[j]).attr({fill: '#000', stroke: "none", opacity: 0, "font-size": 14});
            p.mouseover(function () {
                p.stop().animate({transform: "s1.0 1.1 " + cx + " " + cy}, ms, "elastic");
                txt.stop().animate({opacity: 1}, ms, "elastic");
            }).mouseout(function () {
                p.stop().animate({transform: ""}, ms, "elastic");
               txt.stop().animate({opacity: 0}, ms);
            }).click(function(){if (typeof ids != "undefined"){window.location = application_path+"modules/browse/category.php?catId="+ids[j];} });
            angle += angleplus;
            chart.push(p);
            chart.push(txt);
            start += .1;
        };
    for (var i = 0, ii = values.length; i < ii; i++) {
        total += values[i];
    }
    for (i = 0; i < ii; i++) {
        process(i);
    }
    return chart;
};
$(function () {
    var values = [],
		ids = [],
		color = [],
		dummycolor = [],
		blankLabels = [],
        labels = [];
    $("#categoryContainer tr").each(function () {
        values.push(parseInt($("td", this).text(), 10));
		color.push($("td", this).attr('class'));
		dummycolor.push('#ffffff');
        labels.push($("th", this).text());	
		blankLabels.push('');	
		ids.push($("th", this).attr('id'));
    });
    $("#categoryContainer").hide();
    Raphael("holder", 300, 300).pieChart(100, 120,93, values, blankLabels, "#000000",dummycolor);
	Raphael("bigHolder", 600, 600).pieChart(300,248,200, values, labels, "#000000",color,ids);
});
