<?php

use yii\db\Migration;

class m150630_121101_create_pet_table extends Migration
{

    const PET_TABLE = '{{%pet}}';

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }


        $this->createTable(self::PET_TABLE, [
            'id' => $this->primaryKey()->unsigned(),
            'status' => $this->boolean()->notNull()->defaultValue(false),
            'breed' => $this->string(255)->notNull(),
            'age' => $this->integer()->unsigned()->notNull(),
            'name' => $this->string(255),
            'price' => $this->decimal(15, 2)->unsigned()->notNull(),
            'sold_at' => $this->dateTime(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime(),
            'created_by' => $this->integer()->unsigned(),
            'updated_by' => $this->integer()->unsigned(),
        ], $tableOptions);

        $this->createIndex('pet_breed_index', self::PET_TABLE, 'breed');
        $this->createIndex('pet_age_index', self::PET_TABLE, 'age');
        $this->createIndex('name', self::PET_TABLE, 'name');

        $this->insert(self::PET_TABLE, [
            'status' => 0,
            'breed' => 'TestBreed1',
            'age' => '3',
            'name' => 'Rex',
            'price' => '231',
            'created_at' => '2017-06-11 23:31:50',
            'created_by' => 1
        ]);
        $this->insert(self::PET_TABLE, [
            'status' => 0,
            'breed' => 'TestBreed2',
            'age' => '2',
            'name' => 'Max',
            'price' => '321',
            'created_at' => '2017-06-11 23:31:50',
            'created_by' => 1
        ]);
        $this->insert(self::PET_TABLE, [
            'status' => 0,
            'breed' => 'TestBreed3',
            'age' => '6',
            'name' => 'Punisher',
            'price' => '765',
            'created_at' => '2017-06-11 23:31:50',
            'created_by' => 1
        ]);
        $this->insert(self::PET_TABLE, [
            'status' => 1,
            'breed' => 'TestBreed2',
            'age' => '6',
            'name' => 'Gustav',
            'price' => '480.50',
            'sold_at' => '2017-06-12 20:30:00',
            'created_at' => '2017-06-11 23:31:50',
            'created_by' => 1
        ]);
        $this->insert(self::PET_TABLE, [
            'status' => 0,
            'breed' => 'TestBreed4',
            'age' => '6',
            'name' => 'May',
            'price' => '231',
            'created_at' => '2017-06-11 23:31:50',
            'created_by' => 1
        ]);
        $this->insert(self::PET_TABLE, [
            'status' => 0,
            'breed' => 'TestBreed5',
            'age' => '6',
            'name' => 'Root',
            'price' => '711',
            'created_at' => '2017-06-11 23:31:50',
            'created_by' => 1
        ]);
        $this->insert(self::PET_TABLE, [
            'status' => 1,
            'breed' => 'TestBreed2',
            'age' => '6',
            'name' => 'Bellatrix',
            'price' => '455',
            'sold_at' => '2017-06-12 20:30:00',
            'created_at' => '2017-06-11 23:31:50',
            'created_by' => 1
        ]);


    }

    public function safeDown()
    {

        $this->dropTable(self::PET_TABLE);
    }
}
