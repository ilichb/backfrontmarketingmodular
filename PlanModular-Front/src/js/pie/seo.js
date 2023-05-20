import * as am5 from "@amcharts/amcharts5";
import * as am5percent from "@amcharts/amcharts5/percent";

let seoPie = am5.Root.new('seo-pie')
seoPie._logo.dispose();
export let seoPieChart = seoPie.container.children.push(
    am5percent.PieChart.new(seoPie, {
        radius: am5.percent(90),
        innerRadius: am5.percent(50),
    })
);

export let seoPieSeries = seoPieChart.series.push(
    am5percent.PieSeries.new(seoPie, {
        name: "SEO Level",
        categoryField: "seo",
        valueField: "seoPercentage",
    })
);

seoPieSeries.slices.template.setAll({
    fill: am5.color(0x000000),
    stroke: am5.color(0x000000),
    strokeWidth: 2,
    strokeOpacity: 0.5,
});

seoPieSeries.slices.template.set("toggleKey", "none");

seoPieSeries.labels.template.adapters.add("text", function (text, target) {
    if (target.dataItem && target.dataItem.dataContext.seo === "filler") {
        return "";
    } else {
        return text;
    }
});

seoPieSeries.slices.template.adapters.add("fill", function (fill, target) {
    if (target.dataItem.dataContext.seo === "filler") {
        return am5.color(0xffffff);
    } else {
        return fill;
    }
});

seoPieSeries.data.setAll([{
    seo: "SEO",
    seoPercentage: seoLevel
}, {
    seo: "filler",
    seoPercentage: seoLevel >= 100 ? 0 : 100-seoLevel
}]);

seoPieSeries.ticks.template.set("visible", false);
seoPieSeries.slices.template.set("tooltipText", "");
seoPieSeries.labels.template.set("visible", false);