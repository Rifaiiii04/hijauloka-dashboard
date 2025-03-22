document.addEventListener("DOMContentLoaded", function () {
    if (chartData.products.length > 0) {
        let ctx1 = document.getElementById("myPieChart").getContext("2d");
        new Chart(ctx1, {
            type: "pie",
            data: {
                labels: chartData.products.map(p => p.nama_product), // Nama produk dari database
                datasets: [{
                    data: chartData.products.map(p => p.stok), // Gunakan stok dari database
                    backgroundColor: chartData.products.map(() => 
                        `#${Math.floor(Math.random()*16777215).toString(16)}` // Warna random
                    ),
                }]
            }
        });
    }
});
