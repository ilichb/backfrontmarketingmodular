import * as am5 from "@amcharts/amcharts5";
import * as am5xy from "@amcharts/amcharts5/xy";

let totalGrowthLinear = am5.Root.new("total-growth-linear");
totalGrowthLinear._logo.dispose();
export let totalGrowthLinearChart = totalGrowthLinear.container.children.push(
    am5xy.XYChart.new(totalGrowthLinear, {})
);

let yAxis = totalGrowthLinearChart.yAxes.push(
    am5xy.ValueAxis.new(totalGrowthLinear, {
        max: 100,
        min: 0,
        strictMinMax: true,
        renderer: am5xy.AxisRendererY.new(totalGrowthLinear, {})
    })
);

let xAxis = totalGrowthLinearChart.xAxes.push(
    am5xy.CategoryAxis.new(totalGrowthLinear, {
        startLocation: 0.5,
        endLocation: 0.5,
        renderer: am5xy.AxisRendererX.new(totalGrowthLinear, {}),
        categoryField: "category",
    })
);


let data = [
    { category: "ygdjg", value: 2 },
    { category: "mnsjw", value: 9 },
    { category: "7gtvw", value: 17 },
    { category: "5qkl7", value: 36 },
    { category: "zpy9v", value: 58 },
    { category: "1r3tu", value: 69 },
    { category: "mqfxm", value: 81 }
]

xAxis.data.setAll(data);

let totalGrowthLinearSeries = totalGrowthLinearChart.series.push(
    am5xy.LineSeries.new(totalGrowthLinear, {
        name: "Series",
        xAxis: xAxis,
        yAxis: yAxis,
        valueYField: "value",
        categoryXField: "category",
        stroke: am5.color(0x000000),
    })
);

totalGrowthLinearSeries.strokes.template.setAll({
    strokeColor: am5.color(0x000000),
    strokeWidth: 2
});

totalGrowthLinearSeries.fills.template.set("fillGradient", am5.LinearGradient.new(totalGrowthLinear, {
    stops: [{
        color: am5.color(0x000000),
        opacity: 1
    }, {
        color: am5.color(0x000000),
        opacity: 0.2
    }],
    rotation: 90
}));

totalGrowthLinearSeries.fills.template.setAll({
    fillOpacity: 1,
    visible: true
});

totalGrowthLinearSeries.data.setAll(data);

xAxis.hide();
yAxis.hide();
