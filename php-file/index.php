<?php
$host = 'mysql-database'; 
$db   = 'test_database';
$user = 'root';
$pass = 'root';
$charset = 'utf8mb4';

// Data Source Name
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// PDO options
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, 
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       
    PDO::ATTR_EMULATE_PREPARES   => false,                  
];

try {
    // Create PDO instance
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "✅ Connected to MySQL successfully!<br>";

    // Create a sample table
    $createTableSQL = "
        CREATE TABLE IF NOT EXISTS employees (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            position VARCHAR(100) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=INNODB;
    ";

    $pdo->exec($createTableSQL);
    echo "✅ Table 'employees' is ready.<br>";

    // Insert sample data
    $insertSQL = "
    INSERT IGNORE INTO employees (name, email, position) VALUES
    ('John Doe', 'john.doe@example.com', 'Developer'),
    ('Jane Smith', 'jane.smith@example.com', 'Designer'),
    ('Alice Johnson', 'alice.johnson@example.com', 'Manager')
";


    $pdo->exec($insertSQL);
    echo "✅ Sample data inserted into 'employees'.<br>";

    // Fetch and display data
    $stmt = $pdo->query("SELECT * FROM employees");
    $employees = $stmt->fetchAll();

    echo "<h3>Employees List:</h3><ul>";
    foreach ($employees as $employee) {
        echo "<li>ID: {$employee['id']} - Name: {$employee['name']} - Email: {$employee['email']} - Position: {$employee['position']} - Created At: {$employee['created_at']}</li>";
    }
    echo "</ul>";

} catch (PDOException $e) {
    // Handle connection errors
    echo "❌ Connection failed: " . $e->getMessage();
}
?>
