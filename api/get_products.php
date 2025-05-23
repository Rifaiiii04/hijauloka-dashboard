<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json; charset=utf-8');

// Log the start of the request
error_log("Starting get_products.php request");

try {
    // Include database connection
    include 'koneksi.php';
    
    if (!isset($koneksi) || !$koneksi) {
        throw new Exception("Database connection failed: " . mysqli_connect_error());
    }
    
    error_log("Database connection successful");

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
    
    error_log("Executing query: " . $query);
    
    $result = mysqli_query($koneksi, $query);

    if (!$result) {
        throw new Exception("Query failed: " . mysqli_error($koneksi));
    }

    error_log("Query executed successfully. Number of rows: " . mysqli_num_rows($result));

    $products = array();
    while ($row = mysqli_fetch_assoc($result)) {
        try {
            // Convert numeric values to proper types
            $row['id_product'] = (int)$row['id_product'];
            $row['id_kategori'] = (int)$row['id_kategori'];
            $row['harga'] = (float)$row['harga'];
            $row['stok'] = (int)$row['stok'];
            $row['rating'] = (float)($row['rating'] ?? 0);
            
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
        } catch (Exception $e) {
            error_log("Error processing row: " . $e->getMessage());
            error_log("Problematic row data: " . print_r($row, true));
            // Continue with next row instead of failing completely
            continue;
        }
    }

    error_log("Successfully processed " . count($products) . " products");

    $response = [
        'status' => 'success',
        'data' => $products
    ];

    // Test JSON encoding before sending
    $json_response = json_encode($response, JSON_UNESCAPED_UNICODE);
    if ($json_response === false) {
        throw new Exception("JSON encoding failed: " . json_last_error_msg());
    }

    echo $json_response;

} catch (Exception $e) {
    error_log("Error in get_products.php: " . $e->getMessage());
    error_log("Stack trace: " . $e->getTraceAsString());
    
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Server error: ' . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
} finally {
    if (isset($koneksi) && $koneksi) {
        mysqli_close($koneksi);
        error_log("Database connection closed");
    }
}
?>
