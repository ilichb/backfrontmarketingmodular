import * as am5 from "@amcharts/amcharts5";
import * as am5xy from "@amcharts/amcharts5/xy";

let salesBar = am5.Root.new("sales-bar");
salesBar._logo.dispose();
export let salesBarChart = salesBar.container.children.push(
    am5xy.XYChart.new(salesBar, {})
);

let yAxis = salesBarChart.yAxes.push(
    am5xy.ValueAxis.new(salesBar, {
        max: 100,
        min: 0,
        strictMinMax: true,
        renderer: am5xy.AxisRendererY.new(salesBar, {})
    })
);

let xAxis = salesBarChart.xAxes.push(
    am5xy.CategoryAxis.new(salesBar, {
        startLocation: 0.5,
        endLocation: 0.5,
        renderer: am5xy.AxisRendererX.new(salesBar, {}),
        categoryField: "day",
    })
);


let data = [
    { day: 'Mon', value: 17 },
    { day: 'Tue', value: 9 },
    { day: 'Wed', value: 26 },
    { day: 'Thu', value: 4 },
    { day: 'Fri', value: 31 }
]

xAxis.data.setAll(data);

let salesBarSeries = salesBarChart.series.push(
    am5xy.ColumnSeries.new(salesBar, {
        name: "Last 5 Days",
        xAxis: xAxis,
        yAxis: yAxis,
        valueYField: "value",
        categoryXField: "day",
        stroke: am5.color(0xffffff),
        fill: am5.color(0x000000),
        stacked: true
    })
);

salesBarSeries.data.setAll(data);

salesBarChart.children.unshift(am5.Label.new(salesBar, {
    text: "Ultimos 5 dias",
    fontSize: 20,
    fontWeight: "500",
    textAlign: "center",
    x: am5.percent(50),
    y: am5.percent(95),
    centerX: am5.percent(50),
    paddingTop: 5,
    paddingBottom: 0,
}));