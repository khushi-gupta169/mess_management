<?php

// Load CodeIgniter
require __DIR__ . '/vendor/autoload.php';

$pathsConfig = new Config\Paths();
$bootstrap = \CodeIgniter\Boot::bootWeb($pathsConfig);
$app = $bootstrap->getApp();

// Get database instance
$db = \Config\Database::connect();

// Drop tables in reverse order (to handle foreign keys)
$tables = [
    'notifications',
    'payments',
    'fee_records',
    'extra_meals',
    'holidays',
    'menu_items',
    'menus',
    'kyc_documents',
    'parents',
    'students',
    'users',
    'migrations'
];

echo "Dropping tables...\n";
foreach ($tables as $table) {
    if ($db->tableExists($table)) {
        $db->forge->dropTable($table, true);
        echo "✓ Dropped table: $table\n";
    } else {
        echo "- Table doesn't exist: $table\n";
    }
}

echo "\nAll tables dropped successfully!\n";
echo "Now run: php spark migrate\n";