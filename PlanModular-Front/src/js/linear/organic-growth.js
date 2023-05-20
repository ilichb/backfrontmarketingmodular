import * as am5 from "@amcharts/amcharts5";
import * as am5xy from "@amcharts/amcharts5/xy";

let organicGrowthLinear = am5.Root.new("organic-growth-linear");
organicGrowthLinear._logo.dispose();
export let organicGrowthLinearChart = organicGrowthLinear.container.children.push(
    am5xy.XYChart.new(organicGrowthLinear, {})
);

let yAxis = organicGrowthLinearChart.yAxes.push(
    am5xy.ValueAxis.new(organicGrowthLinear, {
        max: 100,
        min: 0,
        strictMinMax: true,
        renderer: am5xy.AxisRendererY.new(organicGrowthLinear, {})
    })
);

let xAxis = organicGrowthLinearChart.xAxes.push(
    am5xy.CategoryAxis.new(organicGrowthLinear, {
        startLocation: 0.5,
        endLocation: 0.5,
        renderer: am5xy.AxisRendererX.new(organicGrowthLinear, {}),
        categoryField: "category",
    })
);


let data = [
    { category: "8jrtu", value: 5 },
    { category: "v73xp", value: 12 },
    { category: "q1vkg", value: 28 },
    { category: "oemfx", value: 51 },
    { category: "bns7t", value: 71 },
    { category: "pm9xl", value: 87 },
    { category: "utgdr", value: 96 }
]

xAxis.data.setAll(data);

let organicGrowthLinearSeries = organicGrowthLinearChart.series.push(
    am5xy.LineSeries.new(organicGrowthLinear, {
        name: "Series",
        xAxis: xAxis,
        yAxis: yAxis,
        valueYField: "value",
        categoryXField: "category",
        stroke: am5.color(0x000000),
    })
);

organicGrowthLinearSeries.strokes.template.setAll({
    strokeColor: am5.color(0x000000),
    strokeWidth: 2
});

organicGrowthLinearSeries.fills.template.set("fillGradient", am5.LinearGradient.new(organicGrowthLinear, {
    stops: [{
        color: am5.color(0x000000),
        opacity: 1
    }, {
        color: am5.color(0x000000),
        opacity: 0.2
    }],
    rotation: 90
}));

organicGrowthLinearSeries.fills.template.setAll({
    fillOpacity: 1,
    visible: true
});

organicGrowthLinearSeries.data.setAll(data);

xAxis.hide();
yAxis.hide();
