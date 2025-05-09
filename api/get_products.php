<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database configuration
$host = 'localhost';
$dbname = 'hijauloka';
$username = 'root';
$password = '';

try {
    // Create database connection
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // First, let's check if we can get products at all
    $testStmt = $conn->query("SELECT COUNT(*) FROM product");
    $productCount = $testStmt->fetchColumn();
    error_log("Total products in database: " . $productCount);
    
    // Prepare and execute query
    $stmt = $conn->prepare("
        SELECT 
            p.id_product,
            p.nama_product,
            p.desk_product,
            p.harga,
            p.stok,
            p.gambar,
            p.rating,
            c.nama_kategori,
            p.id_kategori
        FROM product p
        LEFT JOIN category c ON p.id_kategori = c.id_kategori
        ORDER BY p.id_product DESC
    ");
    
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Debug: Print raw data
    error_log("Number of products fetched: " . count($products));
    error_log("Raw product data: " . print_r($products, true));
    
    // Base URL for images
    $base_img_url = "http://192.168.50.213/hijauloka/uploads/";
    
    // Format the response
    $response = array(
        'status' => 'success',
        'data' => array_map(function($product) use ($base_img_url) {
            // Handle multiple images - take only the first one
            $gambar = $product['gambar'];
            if (strpos($gambar, ',') !== false) {
                $gambar = explode(',', $gambar)[0];
            }
            
            // Clean the image path
            $gambar = trim($gambar);
            
            // Debug: Print detailed image information
            error_log("Product: {$product['nama_product']}");
            error_log("Original image path: {$product['gambar']}");
            error_log("Cleaned image path: $gambar");
            error_log("Full URL would be: $base_img_url$gambar");
            
            return array(
                'id' => $product['id_product'],
                'name' => $product['nama_product'],
                'description' => $product['desk_product'],
                'price' => number_format($product['harga'], 0, ',', '.'),
                'stock' => $product['stok'],
                'image' => $gambar,
                'rating' => floatval($product['rating']),
                'category' => $product['nama_kategori'] ?? 'Uncategorized',
                'category_id' => $product['id_kategori']
            );
        }, $products)
    );
    
    echo json_encode($response);
    
} catch(PDOException $e) {
    // Log the error
    error_log("Database Error: " . $e->getMessage());
    
    // Return detailed error response
    $response = array(
        'status' => 'error',
        'message' => 'Database error: ' . $e->getMessage(),
        'details' => array(
            'code' => $e->getCode(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        )
    );
    
    http_response_code(500);
    echo json_encode($response);
} catch(Exception $e) {
    // Log the error
    error_log("General Error: " . $e->getMessage());
    
    // Return detailed error response
    $response = array(
        'status' => 'error',
        'message' => 'General error: ' . $e->getMessage(),
        'details' => array(
            'file' => $e->getFile(),
            'line' => $e->getLine()
        )
    );
    
    http_response_code(500);
    echo json_encode($response);
}
?> 