document.addEventListener("DOMContentLoaded", function () {
	const ctx = document.getElementById("myPieChart").getContext("2d");

	new Chart(ctx, {
		type: "pie",
		data: {
			labels: ["Produk A", "Produk B", "Produk C"],
			datasets: [
				{
					label: "Total Penjualan",
					data: [30, 50, 20], // Data bisa diubah sesuai kebutuhan
					backgroundColor: [
						"rgba(255, 99, 132, 0.7)",
						"rgba(54, 162, 235, 0.7)",
						"rgba(255, 206, 86, 0.7)",
					],
					borderColor: [
						"rgba(255, 99, 132, 1)",
						"rgba(54, 162, 235, 1)",
						"rgba(255, 206, 86, 1)",
					],
					borderWidth: 1,
				},
			],
		},
		options: {
			responsive: true,
			maintainAspectRatio: false,
			plugins: {
				legend: {
					position: "top",
				},
			},
		},
	});
});

// Ambil elemen canvas untuk Line Chart
const ctxLine = document.getElementById("lineChart").getContext("2d");

// Data Dummy (Gantilah dengan data dari server)
const dataLine = {
	labels: [
		"Jan",
		"Feb",
		"Mar",
		"Apr",
		"Mei",
		"Jun",
		"Jul",
		"Agu",
		"Sep",
		"Okt",
		"Nov",
		"Des",
	],
	datasets: [
		{
			label: "Total Penjualan",
			data: [50, 60, 80, 100, 120, 150, 170, 200, 220, 250, 270, 300], // Gantilah dengan data dari backend
			backgroundColor: "rgba(54, 162, 235, 0.2)",
			borderColor: "rgba(54, 162, 235, 1)",
			borderWidth: 2,
			fill: true, // Area di bawah garis akan diwarnai
		},
	],
};

// Konfigurasi Line Chart
const configLine = {
	type: "line",
	data: dataLine,
	options: {
		responsive: true,
		maintainAspectRatio: false,
		scales: {
			x: {
				grid: { display: false },
			},
			y: {
				beginAtZero: true,
			},
		},
	},
};

// Render Chart
new Chart(ctxLine, configLine);
