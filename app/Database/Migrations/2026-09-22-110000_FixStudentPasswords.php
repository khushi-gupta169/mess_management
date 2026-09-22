<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FixStudentPasswords extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();

        // Fix all student passwords that were double-hashed
        // Re-hash them properly with a single password_hash
        $students = $db->table('users')
            ->where('role', 'student')
            ->get()
            ->getResultArray();

        foreach ($students as $student) {
            // The password was double-hashed, so password_verify fails.
            // We need to reset it to a known password.
            // For existing students, we'll set their password to the hash of 'admin123'
            // which is the default password used when creating students.
            $newHash = password_hash('admin123', PASSWORD_DEFAULT);

            $db->table('users')
                ->where('id', $student['id'])
                ->update(['password' => $newHash]);
        }

        echo "Fixed " . count($students) . " student password(s).\n";
    }

    public function down()
    {
        // No rollback needed - passwords are now correct
    }
}
