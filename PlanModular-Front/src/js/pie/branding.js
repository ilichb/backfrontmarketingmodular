import * as am5 from "@amcharts/amcharts5";
import * as am5percent from "@amcharts/amcharts5/percent";

let brandingPie = am5.Root.new('branding-pie')
brandingPie._logo.dispose();
export let brandingPieChart = brandingPie.container.children.push(
    am5percent.PieChart.new(brandingPie, {
        radius: am5.percent(90),
        innerRadius: am5.percent(50),
    })
);

export let brandingPieSeries = brandingPieChart.series.push(
    am5percent.PieSeries.new(brandingPie, {
        name: "Brand Recognition",
        categoryField: "branding",
        valueField: "recognitionPercentage",
    })
);

brandingPieSeries.slices.template.setAll({
    fill: am5.color(0x000000),
    stroke: am5.color(0x000000),
    strokeWidth: 2,
    strokeOpacity: 0.5,
});

brandingPieSeries.slices.template.set("toggleKey", "none");

brandingPieSeries.labels.template.adapters.add("text", function (text, target) {
    if (target.dataItem && target.dataItem.dataContext.branding === "filler") {
        return "";
    } else {
        return text;
    }
});

brandingPieSeries.slices.template.adapters.add("fill", function (fill, target) {
    if (target.dataItem.dataContext.branding === "filler") {
        return am5.color(0xffffff);
    } else {
        return fill;
    }
});

brandingPieSeries.data.setAll([{
    branding: "Recognition",
    recognitionPercentage: branding
}, {
    branding: "filler",
    recognitionPercentage: branding >= 100 ? 0 : 100-branding
}]);

brandingPieSeries.ticks.template.set("visible", false);
brandingPieSeries.slices.template.set("tooltipText", "");
brandingPieSeries.labels.template.set("visible", false);