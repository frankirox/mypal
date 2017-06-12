<?php

use yii\db\Migration;

class m161115_185738_session_table_core extends Migration
{

    const SESSION_TABLE = '{{%session}}';

    public function up()
    {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(self::SESSION_TABLE, [
            'id'            => $this->primaryKey()->unsigned(),
            'expire'        => $this->integer(10),
            'data'          => $this->binary(),
        ], $tableOptions);


    }

    public function down()
    {
        $this->dropTable(self::SESSION_TABLE);

    }

}
