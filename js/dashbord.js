window.onload = function () {

var options = {
	title: {
		text: "ข้อมูลการมาพนักงาน"
	},
	animationEnabled: true,
	data: [{
		type: "pie",
		startAngle: 40,
		toolTipContent: "<b>{label}</b>: {y}%",
		showInLegend: "true",
		legendText: "{label}",
		indexLabelFontSize: 16,
		indexLabel: "{label} - {y}%",
		dataPoints: [
			{ y: 48.36, label: "นาย เอ" },
			{ y: 26.85, label: "นาย บี" },
			{ y: 1.49, label: "นางสาว ซี" },
			{ y: 6.98, label: "เด็กชาย ดี" },
			{ y: 6.53, label: "นาง อี" },
			{ y: 2.45, label: "นาย เอฟ" },
			{ y: 3.32, label: "นางสาว จี" },
			{ y: 4.03, label: "นางสาว เฮด" }
		]
	}]
};
$("#chartContainer").CanvasJSChart(options);

}