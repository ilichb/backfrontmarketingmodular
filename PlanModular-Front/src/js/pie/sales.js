import * as am5 from "@amcharts/amcharts5";
import * as am5percent from "@amcharts/amcharts5/percent";

let salesPie = am5.Root.new('sales-pie')
salesPie._logo.dispose();
export let salesPieChart = salesPie.container.children.push(
    am5percent.PieChart.new(salesPie, {
        radius: am5.percent(90),

        // innerRadius: am5.percent(50),
    })
);

let salesPieInsideSeries = salesPieChart.series.push(
    am5percent.PieSeries.new(salesPie, {
        name: "Sales Block",
        categoryField: "sales",
        valueField: "blockPercentage",
    })
);

let salesPieSeries = salesPieChart.series.push(
    am5percent.PieSeries.new(salesPie, {
        name: "Quarterly Sales",
        categoryField: "service",
        valueField: "servicePercentage",
    })
);


salesPieSeries.slices.template.setAll({
    fill: am5.color(0x000000),
    stroke: am5.color(0xffffff),
    strokeWidth: 5,
});

salesPieInsideSeries.slices.template.setAll({
    fill: am5.color(0x000000),
    stroke: am5.color(0xffffff),
    strokeWidth: 10,
});

salesPieSeries.slices.template.set("toggleKey", "none");

salesPieSeries.labels.template.adapters.add("text", function (text, target) {
    if (target.dataItem && target.dataItem.dataContext.service === "filler") {
        return "";
    } else {
        return text;
    }
});

salesPieSeries.slices.template.adapters.add("fill", function (fill, target) {
    if (target.dataItem.dataContext.service === "filler") {
        return am5.color(0xffffff);
    } else {
        return fill;
    }
});

salesPieInsideSeries.data.setAll([{
    sales: "BLOCK",
    blockPercentage: sales
}]);

salesPieSeries.data.setAll([
    { service: 'Service 1', servicePercentage: 3 },
    { service: 'Service 2', servicePercentage: 11 },
    { service: 'Service 3', servicePercentage: 8 },
    { service: 'Service 4', servicePercentage: 14 }
]);


salesPieSeries.ticks.template.set("visible", false);
salesPieSeries.slices.template.set("tooltipText", "");
salesPieSeries.labels.template.set("visible", false);

salesPieInsideSeries.ticks.template.set("visible", false);
salesPieInsideSeries.slices.template.set("tooltipText", "");
salesPieInsideSeries.labels.template.set("visible", false);