import * as am5 from "@amcharts/amcharts5";
import * as am5xy from "@amcharts/amcharts5/xy";

let projectedEarningsLinear = am5.Root.new("projected-earnings-linear");
projectedEarningsLinear._logo.dispose();
export let projectedEarningsLinearChart = projectedEarningsLinear.container.children.push(
    am5xy.XYChart.new(projectedEarningsLinear, {})
);

let yAxis = projectedEarningsLinearChart.yAxes.push(
    am5xy.ValueAxis.new(projectedEarningsLinear, {
        max: 100,
        min: 0,
        strictMinMax: true,
        renderer: am5xy.AxisRendererY.new(projectedEarningsLinear, {})
    })
);

let xAxis = projectedEarningsLinearChart.xAxes.push(
    am5xy.CategoryAxis.new(projectedEarningsLinear, {
        startLocation: 0.5,
        endLocation: 0.5,
        renderer: am5xy.AxisRendererX.new(projectedEarningsLinear, {}),
        categoryField: "category",
    })
);


let data = [
    { category: "8jrtu", value: 2},
    { category: "v73xp", value: 9 },
    { category: "q1vkg", value: 17 },
    { category: "oemfx", value: 36 },
    { category: "bns7t", value: 20 },
    { category: "pm9xl", value: 69 },
    { category: "utgdr", value: 81 }
]

xAxis.data.setAll(data);

let projectedEarningsLinearSeries = projectedEarningsLinearChart.series.push(
    am5xy.LineSeries.new(projectedEarningsLinear, {
        name: "Series",
        xAxis: xAxis,
        yAxis: yAxis,
        valueYField: "value",
        categoryXField: "category",
        stroke: am5.color(0x000000),
    })
);

projectedEarningsLinearSeries.strokes.template.setAll({
    strokeColor: am5.color(0x000000),
    strokeWidth: 2
});

projectedEarningsLinearSeries.fills.template.set("fillGradient", am5.LinearGradient.new(projectedEarningsLinear, {
    stops: [{
        color: am5.color(0x000000),
        opacity: 1
    }, {
        color: am5.color(0x000000),
        opacity: 0.2
    }],
    rotation: 90
}));

projectedEarningsLinearSeries.fills.template.setAll({
    fillOpacity: 1,
    visible: true
});

projectedEarningsLinearSeries.data.setAll(data);

xAxis.hide();
yAxis.hide();
