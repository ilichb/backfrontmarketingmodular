import * as am5 from "@amcharts/amcharts5";
import * as am5map from "@amcharts/amcharts5/map";
import am5geodata_worldLow from "@amcharts/amcharts5-geodata/worldLow";
import am5themes_Animated from "@amcharts/amcharts5/themes/Animated";

let root = am5.Root.new("potential-reach-map");
root._logo.dispose();

root.setThemes([
    am5themes_Animated.new(root)
]);

export let chart = root.container.children.push(am5map.MapChart.new(root, {
    panX: "translateX",
    panY: "translateY",
    projection: am5map.geoMercator()
}));

let polygonSeries = chart.series.push(am5map.MapPolygonSeries.new(root, {
    geoJSON: am5geodata_worldLow,
    exclude: ["AQ"],
    stroke: am5.color(0x000000),
    fill: am5.color(0xffffff),
}));

polygonSeries.mapPolygons.template.setAll({
    tooltipText: "{name}",
    toggleKey: "active",
    templateField: "polygonSettings",
    interactive: true
});

let countriesPolygonArray = []

for(let i = 0; i < countriesList.length; i++) {
    countriesPolygonArray.push({
        id: countriesList[i],
        polygonSettings: {
            fill: am5.color(0x000000),
            stroke: am5.color(0xffffff)
        }
    })
}

polygonSeries.data.setAll(countriesPolygonArray)

let previousPolygon;

polygonSeries.mapPolygons.template.on("active", function (active, target) {
    if (previousPolygon && previousPolygon != target) {
        previousPolygon.set("active", false);
    }
    if (target.get("active")) {
        polygonSeries.zoomToDataItem(target.dataItem );
    }
    else {
        chart.goHome();
    }
    previousPolygon = target;
});


// Add zoom control
// https://www.amcharts.com/docs/v5/charts/map-chart/map-pan-zoom/#Zoom_control
chart.set("zoomControl", am5map.ZoomControl.new(root, {}));


// Set clicking on "water" to zoom out
chart.chartContainer.get("background").events.on("click", function () {
    chart.goHome();
})


// Make stuff animate on load
chart.appear(1000, 100);