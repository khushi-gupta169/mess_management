<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Config\Database;

class DropTables extends BaseCommand
{
    protected $group       = 'Database';
    protected $name        = 'db:drop';
    protected $description = 'Drops all application tables';

    public function run(array $params)
    {
        $db = Database::connect();
        $forge = Database::forge();
        
        // Disable foreign key checks
        $db->query('SET FOREIGN_KEY_CHECKS = 0');
        
        // Drop tables in reverse order
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

        CLI::write('Dropping tables...', 'yellow');
        
        foreach ($tables as $table) {
            if ($db->tableExists($table)) {
                $forge->dropTable($table, true);
                CLI::write("✓ Dropped table: $table", 'green');
            } else {
                CLI::write("- Table doesn't exist: $table", 'white');
            }
        }
        
        // Re-enable foreign key checks
        $db->query('SET FOREIGN_KEY_CHECKS = 1');

        CLI::newLine();
        CLI::write('All tables dropped successfully!', 'green');
        CLI::write('Now run: php spark migrate', 'yellow');
    }
}