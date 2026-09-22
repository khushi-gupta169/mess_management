<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStudentsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'student_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'unique'     => true,
            ],
            'enrollment_number' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'unique'     => true,
            ],
            'father_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'mother_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'date_of_birth' => [
                'type' => 'DATE',
            ],
            'gender' => [
                'type'       => 'ENUM',
                'constraint' => ['female'],
                'default'    => 'female',
            ],
            'mobile' => [
                'type'       => 'VARCHAR',
                'constraint' => 15,
            ],
            'course' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'branch' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'year' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'semester' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'college' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'hostel_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'room_number' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'admission_date' => [
                'type' => 'DATE',
            ],
            'address' => [
                'type' => 'TEXT',
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['active', 'inactive'],
                'default'    => 'active',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('students');
    }

    public function down()
    {
        $this->forge->dropTable('students');
    }
}