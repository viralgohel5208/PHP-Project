'use strict';
var demoHighCharts = function () {
	var highColors = [bgWarning, bgPrimary, bgInfo, bgAlert, bgDanger, bgSuccess, bgSystem, bgDark];
	var demoHighCharts = function () {
		var demoHighColumns = function () {
			
			var column2 = $('#high-column2');
			if (column2.length) {
				$('#high-column2').highcharts({
					credits: false,
					colors: [bgPrimary, bgPrimary, bgWarning, bgWarning, bgInfo, bgInfo],
					chart: {
						padding: 0,
						marginTop: 25,
						marginLeft: 15,
						marginRight: 5,
						marginBottom: 30,
						type: 'column',
					},
					legend: {
						enabled: false
					},
					title: {
						text: null,
					},
					xAxis: {
						lineWidth: 0,
						tickLength: 6,
						title: {
							text: null
						},
						labels: {
							enabled: true
						}
					},
					yAxis: {
						max: 20,
						lineWidth: 0,
						gridLineWidth: 0,
						lineColor: '#EEE',
						gridLineColor: '#EEE',
						title: {
							text: null
						},
						labels: {
							enabled: false,
							style: {
								fontWeight: '400'
							}
						}
					},
					tooltip: {
						headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
						pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' + '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
						footerFormat: '</table>',
						shared: true,
						useHTML: true
					},
					plotOptions: {
						column: {
							colorByPoint: true,
						}
					},
					series: [{
						name: 'Tokyo',
						data: [12, 14, 20, 19, 8, 12, 14, 20, 5, 16, 8, 12, 14, 20, 19, 5, 16, 8, 12, 14, 20, 19, 5, 16, 8]
					}]
				});
			}
		}
		var demoHighLines = function () {
			var line3 = $('#high-line3');
			if (line3.length) {
				$('#high-line3').highcharts({
					credits: false,
					colors: highColors,
					chart: {
						backgroundColor: '#f9f9f9',
						className: 'br-r',
						type: 'line',
						zoomType: 'x',
						panning: true,
						panKey: 'shift',
						marginTop: 25,
						marginRight: 1,
					},
					title: {
						text: null
					},
					xAxis: {
						gridLineColor: '#EEE',
						lineColor: '#EEE',
						tickColor: '#EEE',
						categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
					},
					yAxis: {
						min: 0,
						tickInterval: 5,
						gridLineColor: '#EEE',
						title: {
							text: null,
						}
					},
					plotOptions: {
						spline: {
							lineWidth: 3,
						},
						area: {
							fillOpacity: 0.2
						}
					},
					legend: {
						enabled: false,
					},
					series: [{
						name: 'Yahoo',
						data: [7.0, 6, 9, 14, 18, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
					}, {
						name: 'CNN',
						data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
					}, {
						visible: false,
						name: 'Yahoo',
						data: [1, 5, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5]
					}, {
						visible: false,
						name: 'Facebook',
						data: [3, 1, 3.5, 8.4, 13.5, 17.0, 18.6, 17.9, 14.3, 9.0, 3.9, 1.0]
					}, {
						visible: false,
						name: 'Facebook',
						data: [7.0, 6, 9, 14, 18, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
					}, {
						visible: false,
						name: 'CNN',
						data: [1, 5, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5]
					}]
				});
			}
		}
		demoHighColumns();
		demoHighLines();
	}
	return {
		init: function () {
			demoHighCharts();
		}
	}
}();