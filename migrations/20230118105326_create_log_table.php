<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateLogTable extends AbstractMigration
{
    public function up()
    {
        $this->table('log')
            ->addColumn('player_name', 'string', ['limit' => 100])
            ->addColumn('action', 'string', ['limit' => 10])
            ->addColumn('time', 'datetime')
            ->create();
    }

    public function down()
    {
        $this->dropTable('log');
    }
}
