import * as am5 from "@amcharts/amcharts5";
import * as am5xy from "@amcharts/amcharts5/xy";

let bounceRateBar = am5.Root.new("bounce-bar");
bounceRateBar._logo.dispose();
export let bounceRateBarChart = bounceRateBar.container.children.push(
    am5xy.XYChart.new(bounceRateBar, {})
);

let yAxis = bounceRateBarChart.yAxes.push(
    am5xy.ValueAxis.new(bounceRateBar, {
        max: 100,
        min: 0,
        strictMinMax: true,
        renderer: am5xy.AxisRendererY.new(bounceRateBar, {})
    })
);

let xAxis = bounceRateBarChart.xAxes.push(
    am5xy.CategoryAxis.new(bounceRateBar, {
        startLocation: 0.5,
        endLocation: 0.5,
        renderer: am5xy.AxisRendererX.new(bounceRateBar, {}),
        categoryField: "month",
    })
);


let data = [
    { month: 'Jan', value: 65 },
    { month: 'Feb', value: 59 },
    { month: 'March', value: 80 },
    { month: 'April', value: 81 },
    { month: 'May', value: 56 },
    { month: 'June', value: 55 },
    { month: 'July', value: 40 }
]

xAxis.data.setAll(data);

let bounceRateBarSeries = bounceRateBarChart.series.push(
    am5xy.ColumnSeries.new(bounceRateBar, {
        name: "Series",
        xAxis: xAxis,
        yAxis: yAxis,
        valueYField: "value",
        categoryXField: "month",
        stroke: am5.color(0xffffff),
        fill: am5.color(0x000000),
    })
);
bounceRateBarSeries.data.setAll(data);

