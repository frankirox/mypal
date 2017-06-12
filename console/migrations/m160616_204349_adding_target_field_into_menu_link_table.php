<?php

use yii\db\Migration;

class m160616_204349_adding_target_field_into_menu_link_table extends Migration
{
    const TABLE_NAME = '{{%menu_link}}';

    public function up()
    {
        $this->addColumn(self::TABLE_NAME, 'target', $this->string(255));
    }

    public function down()
    {
        $this->dropColumn(self::TABLE_NAME, 'target');
    }
}
