
document.addEventListener("DOMContentLoaded", function () {
    // Debug: cek data yang dikirim
    console.log(chartData.products);
    
    if (chartData.products && chartData.products.length > 0) {
        let canvas = document.getElementById("myPieChart");
        if (canvas) {
            let ctx1 = canvas.getContext("2d");
            new Chart(ctx1, {
                type: "pie",
                data: {
                    labels: chartData.products.map(p => p.nama_product), // Nama produk dari database
                    datasets: [{
                        data: chartData.products.map(p => p.stok), // Nilai stok dari database
                        backgroundColor: chartData.products.map(() =>
                            // Warna random dengan 6 digit hex
                            `#${Math.floor(Math.random() * 16777215).toString(16).padStart(6, '0')}`
                        ),
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });
        } else {
            console.error("Canvas dengan id 'myPieChart' tidak ditemukan!");
        }
    } else {
        console.log("Data produk kosong atau tidak tersedia.");
    }
});

