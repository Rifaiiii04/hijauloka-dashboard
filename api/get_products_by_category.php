<?php
header('Content-Type: application/json; charset=utf-8');

// Database connection
$host = "103.247.11.220";
$db_name = "hijc7862_hijauloka";
$username = "hijc7862_admin";
$password = "wyn[=?alPV%.";

// Create connection
$conn = new mysqli($host, $username, $password, $db_name);

// Check connection
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode([
        'success' => false, 
        'message' => 'Database connection failed: ' . $conn->connect_error
    ]);
    exit;
}
try {
    // Get category ID from query parameter
    $category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;

    if ($category_id <= 0) {
        throw new Exception('Invalid category ID');
    }

    // Prepare and execute the query
    $query = "SELECT p.*, c.name as category_name 
              FROM products p 
              LEFT JOIN categories c ON p.category_id = c.id 
              WHERE p.category_id = ? AND p.is_active = 1 
              ORDER BY p.created_at DESC";
              
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $products = array();
    while ($row = $result->fetch_assoc()) {
        // Format the product data
        $product = array(
            'id' => intval($row['id']),
            'name' => $row['name'],
            'description' => $row['description'],
            'price' => floatval($row['price']),
            'stock' => intval($row['stock']),
            'image' => $row['image'],
            'category_id' => intval($row['category_id']),
            'category_name' => $row['category_name'],
            'is_active' => (bool)$row['is_active'],
            'created_at' => $row['created_at'],
            'updated_at' => $row['updated_at']
        );
        $products[] = $product;
    }

    // Return success response
    echo json_encode([
        'success' => true,
        'data' => $products,
        'message' => 'Products retrieved successfully'
    ]);

} catch (Exception $e) {
    // Return error response
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

// Close the database connection
$stmt->close();
$conn->close();
?> 