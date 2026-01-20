<?php
$configPath = __DIR__ . '/config.php';

if (file_exists($configPath)) {
    $config = require $configPath;
} else {
    // Fallback or error. For now, let's error to encourage setting up config.
    die('Configuration file not found. Please create config.php based on config.sample.php');
}

$conn = new mysqli($config['host'], $config['username'], $config['password'], $config['database']);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
