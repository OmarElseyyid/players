<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreatePlayersTable extends AbstractMigration
{
    public function up()
    {
        // create a new table with a primary key auto-incrementing
        $this->table('players', ['id' => true, 'primary_key' => ['id'], ['identity' => true], ['auto_increment' => true]])
            // name is a string with a limit of 255 characters
            ->addColumn('name', 'string', ['limit' => 255])
            // group number is an integer
            ->addColumn('group_number', 'integer')
            // created_at is a datetime
            ->addColumn('created_at', 'datetime')
            // updated_at is a datetime
            ->addColumn('updated_at', 'datetime')
            // create the table
            ->create();        
    }
    public function down()
    {
        $this->dropTable('players');
    }
}
