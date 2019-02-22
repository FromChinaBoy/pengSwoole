<?php


use Phinx\Migration\AbstractMigration;

class User extends AbstractMigration
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
     * 'limit',
    //            'default',
    //            'null',
    //            'identity',
    //            'precision',
    //            'scale',
    //            'after',
    //            'update',
    //            'comment',
    //            'signed',
    //            'timezone',
    //            'properties',
    //            'values',
    //            'collation',
    //            'encoding',
     */
    public function change()
    {
        $table = $this->table('user', ['engine' => 'MyISAM','comment'=>'用户表']);
        $table->addColumn('phone','string',['limit' => 11,'comment'=>'电话'])
            ->addColumn('password','string',['limit' => 32,'comment'=>'用户密码'])
            ->addColumn('nickname','string',['limit' => 50,'comment'=>'用户昵称'])
            ->addColumn('avatar','string',['limit' => 255,'comment'=>'用户头像'])
            ->addColumn('sex','integer',['limit' => 255,'comment'=>'性别：0未知，1男性，2女性','default'=>0])
            ->addColumn('created_time', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('update_time', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('delete_time', 'timestamp', ['default' => NULL,'null'=>true])
            ->addColumn('birthday','timestamp',['default' => NULL,'null'=>true])
            ->create();
    }
}
