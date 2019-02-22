<?php


use Phinx\Migration\AbstractMigration;

class File extends AbstractMigration
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
        $table = $this->table('file', ['engine' => 'MyISAM','comment'=>'文件']);
        $table->addColumn('catalog_id','integer',['limit' => 11,'comment'=>'目录id','default'=>0])
            ->addColumn('url','string',['limit' => 255])
            ->addColumn('host','string',['limit' => 255])
            ->addColumn('path','string',['limit' => 255])
            ->addColumn('user_id','integer',['limit' => 11,'comment'=>'用户id'])
            ->addColumn('created_time', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('update_time', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('delete_time', 'timestamp', ['default' => NULL,'null'=>true])
            ->create();
    }
}
