<?php

use Phinx\Migration\AbstractMigration;

class TestMigration extends AbstractMigration
{

    public function up()
    {
        $this->table('users')
            ->addColumn('name','string', ['null' =>true])
            ->addColumn('email','string', ['null' =>true])
            ->addColumn('company','string', ['null' =>true])
            ->addColumn('likeability','string', ['null' =>true])
            ->save();
    }

    public function down()
    {
        $this->table('users')->drop();
    }
}
