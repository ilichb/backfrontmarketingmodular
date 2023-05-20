import * as am5 from "@amcharts/amcharts5";
import * as am5percent from "@amcharts/amcharts5/percent";

let totalGrowthPie = am5.Root.new('total-growth-pie');
totalGrowthPie._logo.dispose();
export let totalGrowthPieChart = totalGrowthPie.container.children.push(
    am5percent.PieChart.new(totalGrowthPie, {
        radius: am5.percent(90),
        innerRadius: am5.percent(50),
    })
);

export let totalGrowthPieSeries = totalGrowthPieChart.series.push(
    am5percent.PieSeries.new(totalGrowthPie, {
        name: "Brand Recognition",
        categoryField: "branding",
        valueField: "recognitionPercentage",
    })
);

totalGrowthPieSeries.slices.template.setAll({
    fill: am5.color(0x000000),
    stroke: am5.color(0x000000),
    strokeWidth: 2,
    strokeOpacity: 0.5,
});

totalGrowthPieSeries.slices.template.set("toggleKey", "none");

totalGrowthPieSeries.labels.template.adapters.add("text", function (text, target) {
    if (target.dataItem && target.dataItem.dataContext.branding === "filler") {
        return "";
    } else {
        return text;
    }
});

totalGrowthPieSeries.slices.template.adapters.add("fill", function (fill, target) {
    if (target.dataItem.dataContext.branding === "filler") {
        return am5.color(0xffffff);
    } else {
        return fill;
    }
});

totalGrowthPieSeries.data.setAll([{
    branding: "Recognition",
    recognitionPercentage: totalGrowth
}, {
    branding: "filler",
    recognitionPercentage: totalGrowth >= 100 ? 0 : 100-totalGrowth
}]);

totalGrowthPieSeries.ticks.template.set("visible", false);
totalGrowthPieSeries.slices.template.set("tooltipText", "");
totalGrowthPieSeries.labels.template.set("visible", false);