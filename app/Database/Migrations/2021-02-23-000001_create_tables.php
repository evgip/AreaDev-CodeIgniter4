<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAuthTables extends Migration
{
    public function up()
    {
        /*
         * Users
         */
        $this->forge->addField([
            'id'       => ['type' => 'int', 'constraint' => 11, 'unsigned' => false, 'auto_increment' => true],
            'nickname' => ['type' => 'varchar', 'constraint' => 30, 'null' => false],
            'name'     => ['type' => 'varchar', 'constraint' => 30, 'null' => false],
            'email'    => ['type' => 'varchar', 'constraint' => 50, 'null' => false],
            'password' => ['type' => 'varchar', 'constraint' => 255, 'null' => false],
            'reset_token'  => ['type' => 'varchar', 'constraint' => 255, 'null' => false],
            'reset_expire' => ['type' => 'datetime', 'null' => true],
            'activated'    => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0],
            'activate_token' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'activate_expire'=> ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'role'          => ['type' => 'int', 'constraint' => 11, 'null' => 0],
            'created_at'    => ['type' => 'datetime', 'null' => 0],
            'updated_at'    => ['type' => 'datetime', 'null' => 0],
            'deleted_at'    => ['type' => 'datetime'],
            'avatar'        => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'rating'        => ['type' => 'int', 'constraint' => 11, 'null' => true],
            'status'        => ['type' => 'tinyint', 'constraint' => 1, 'null' => true],
            'my_blog'       => ['type' => 'int', 'constraint' => 11, 'null' => true],
            'color'         => ['type' => 'int', 'constraint' => 11, 'null' => true, 'default' => 0],
            'post_profile'  => ['type' => 'int', 'constraint' => 11, 'null' => true, 'default' => 0],
        ]);
  
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('email');
        $this->forge->addUniqueKey('username');

        $this->forge->createTable('users', true);
        
        /*
         * user_roles
         */
        $this->forge->addField([
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'role_name'             => ['type' => 'varchar', 'constraint' => 255, 'null' => false],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('user_roles', true);
        
        /*
         * auth_logins
         */
        $this->forge->addField([
            'id'   => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id'   => ['type' => 'int', 'constraint' => 30, 'null' => false],
            'nickname'  => ['type' => 'varchar', 'constraint' => 255, 'null' => false],
            'name'      => ['type' => 'varchar', 'constraint' => 30, 'null' => false],
            'role'      => ['type' => 'int', 'constraint' => 2, 'null' => false],
            'ip_address' => ['type' => 'varchar', 'constraint' => 255, 'null' => false],
            'date'       => ['type' => 'datetime', 'null' => false],
            'successfull'=> ['type' => 'int', 'constraint' => 2, 'null' => false],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('auth_logins', true);
        
        /*
         * auth_tokens
         */
        $this->forge->addField([
            'id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id'       => ['type' => 'int', 'constraint' => 11, 'null' => false],
            'selector'      => ['type' => 'varchar', 'constraint' => 255, 'null' => false],
            'hashedvalidator' => ['type' => 'varchar', 'constraint' => 255, 'null' => false],
            'expires'         => ['type' => 'datetime', 'null' => false],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('auth_tokens', true);
    }
 
    //--------------------------------------------------------------------

    public function down()
    {

		$this->forge->dropTable('users', true);
		$this->forge->dropTable('user_roles', true);
        $this->forge->dropTable('auth_logins', true);
        $this->forge->dropTable('auth_tokens', true);
    }
}
