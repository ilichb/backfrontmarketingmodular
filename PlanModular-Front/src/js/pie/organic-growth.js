import * as am5 from "@amcharts/amcharts5";
import * as am5percent from "@amcharts/amcharts5/percent";

let organicGrowthPie = am5.Root.new('organic-growth-pie');
organicGrowthPie._logo.dispose()
export let organicGrowthPieChart = organicGrowthPie.container.children.push(
    am5percent.PieChart.new(organicGrowthPie, {
        radius: am5.percent(90),
        innerRadius: am5.percent(50),
    })
);

export let organicGrowthPieSeries = organicGrowthPieChart.series.push(
    am5percent.PieSeries.new(organicGrowthPie, {
        name: "Organic Growth",
        categoryField: "growth",
        valueField: "growthPercentage",
    })
);

organicGrowthPieSeries.slices.template.setAll({
    fill: am5.color(0x000000),
    stroke: am5.color(0x000000),
    strokeWidth: 2,
    strokeOpacity: 0.5,
});

organicGrowthPieSeries.slices.template.set("toggleKey", "none");

organicGrowthPieSeries.labels.template.adapters.add("text", function (text, target) {
    if (target.dataItem && target.dataItem.dataContext.branding === "filler") {
        return "";
    } else {
        return text;
    }
});

organicGrowthPieSeries.slices.template.adapters.add("fill", function (fill, target) {
    if (target.dataItem.dataContext.branding === "filler") {
        return am5.color(0xffffff);
    } else {
        return fill;
    }
});

organicGrowthPieSeries.data.setAll([{
    growth: "Growth",
    growthPercentage: organicGrowth
}, {
    branding: "filler",
    growthPercentage: organicGrowth >= 100 ? 0 : 100-organicGrowth
}]);

organicGrowthPieSeries.ticks.template.set("visible", false);
organicGrowthPieSeries.slices.template.set("tooltipText", "");
organicGrowthPieSeries.labels.template.set("visible", false);