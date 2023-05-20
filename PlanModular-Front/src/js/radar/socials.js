import * as am5 from "@amcharts/amcharts5";
import * as am5xy from "@amcharts/amcharts5/xy";
import * as am5radar from "@amcharts/amcharts5/radar";

let socialsRadar = am5.Root.new("socials-radar");
socialsRadar._logo.dispose();
export let socialsRadarChart = socialsRadar.container.children.push(
    am5radar.RadarChart.new(socialsRadar, {
        startAngle: -180,
        endAngle: 0,
    })
);

let yAxis = socialsRadarChart.yAxes.push(
    am5xy.ValueAxis.new(socialsRadar, {
        max: 100,
        min: 0,
        strictMinMax: true,
        renderer: am5radar.AxisRendererRadial.new(socialsRadar, {})
    })
);

let xAxis = socialsRadarChart.xAxes.push(
    am5xy.CategoryAxis.new(socialsRadar, {
        startLocation: 0.5,
        endLocation: 0.5,
        renderer: am5radar.AxisRendererCircular.new(socialsRadar, {}),
        categoryField: "platform",
    })
);


let data = [
    { platform: 'Facebook', percentage: 54 },
    { platform: 'Tiktok', percentage: 38 },
    { platform: 'Youtube', percentage: 70 },
    { platform: 'LinkedIn', percentage: 65 }
]

xAxis.data.setAll(data);

let socialsRadarSeries = socialsRadarChart.series.push(
    am5radar.RadarColumnSeries.new(socialsRadar, {
        name: "Platforms",
        xAxis: xAxis,
        yAxis: yAxis,
        valueYField: "percentage",
        categoryXField: "platform",
        stroke: am5.color(0x000000),
        fill: am5.color(0x000000),
    })
);

xAxis.get('renderer').labels.template.setAll({
    fontSize: 20,
    textType: "adjusted",
    radius: 10,
    inside: true
});



// socialsRadarSeries.strokes.template.setAll({
//     strokeColor: am5.color(0x000000),
//     strokeWidth: 2
// });
//
// socialsRadarSeries.fills.template.set("fillGradient", am5.LinearGradient.new(socialsRadar, {
//     stops: [{
//         color: am5.color(0x000000),
//         opacity: 1
//     }, {
//         color: am5.color(0x000000),
//         opacity: 0.2
//     }],
//     rotation: 90
// }));
//
// socialsRadarSeries.fills.template.setAll({
//     fillOpacity: 1,
//     visible: true
// });
//
socialsRadarSeries.data.setAll(data);
//
// xAxis.hide();
yAxis.hide();
