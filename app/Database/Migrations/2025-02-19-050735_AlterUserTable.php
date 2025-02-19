<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterUserTable extends Migration
{
    public function up()
    {
        $this->db->query("ALTER TABLE `users`
        ADD `name` varchar(255) COLLATE 'utf8mb4_general_ci' NULL AFTER `id`,
        ADD `phone` varchar(15) COLLATE 'utf8mb4_general_ci' NULL AFTER `name`,
        ADD `avatar` varchar(255) COLLATE 'utf8mb4_general_ci' NULL AFTER `phone`;");
    }

    public function down()
    {
        $this->db->query("ALTER TABLE `users`
        DROP `name`,
        DROP `phone`,
        DROP `avatar`;");
    }
}
