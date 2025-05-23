<?php
header('Content-Type: application/json; charset=utf-8');
// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Methods: GET');

include 'koneksi.php';

try {
    $query = "SELECT 
        p.id_product,
        p.nama_product,
        p.desk_product,
        p.harga,
        p.stok,
        p.gambar,
        p.rating,
        p.cara_rawat_video,
        c.id_kategori,
        c.nama_kategori
    FROM product p
    LEFT JOIN category c ON p.id_kategori = c.id_kategori
    ORDER BY p.id_product DESC";
    
    $result = mysqli_query($koneksi, $query);

    if (!$result) {
        throw new Exception(mysqli_error($koneksi));
    }

    $products = array();
    while ($row = mysqli_fetch_assoc($result)) {
        // Convert numeric values to proper types
        $row['id_product'] = (int)$row['id_product'];
        $row['id_kategori'] = (int)$row['id_kategori'];
        $row['harga'] = (float)$row['harga'];
        $row['stok'] = (int)$row['stok'];
        $row['rating'] = (float)$row['rating'];
        
        // Map the database fields to match the expected API response
        $formattedRow = array(
            'id' => $row['id_product'],
            'name' => $row['nama_product'],
            'description' => $row['desk_product'],
            'price' => $row['harga'],
            'stock' => $row['stok'],
            'image' => $row['gambar'],
            'rating' => $row['rating'],
            'category' => $row['nama_kategori'] ?? 'Uncategorized',
            'category_id' => $row['id_kategori'],
            'care_video' => $row['cara_rawat_video']
        );
        
        $products[] = $formattedRow;
    }

    echo json_encode([
        'status' => 'success',
        'data' => $products
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}

mysqli_close($koneksi);
?>
