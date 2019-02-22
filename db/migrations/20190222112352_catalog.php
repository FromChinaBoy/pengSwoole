<?php


use Phinx\Migration\AbstractMigration;

class Catalog extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    addCustomColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Any other destructive changes will result in an error when trying to
     * rollback the migration.
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $table = $this->table('catalog', ['engine' => 'MyISAM','comment'=>'目录']);
        $table->addColumn('name','string',['limit' => 20,'comment'=>'上传目录名'])
            ->addColumn('parent_id','integer',['limit' => 11,'comment'=>'父级id，0为最高级别','default'=>0])
            ->addColumn('user_id','integer',['limit' => 11,'comment'=>'用户id'])
            ->addColumn('created_time', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('update_time', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('delete_time', 'timestamp', ['default' => NULL,'null'=>true])
            ->create();
    }
}
