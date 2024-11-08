<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%offers}}`.
 */
class m241107_075145_create_offers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        // Создание таблицы offers
        $this->createTable('{{%offers}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->null(),
            'email' => $this->string(255)->null(),
            'phone' => $this->bigInteger()->null(),
            'created_at' => $this->integer()->null(),
            'updated_at' => $this->integer()->null(),
        ], $tableOptions);

        // Вставка 10 записей с разными значениями
        for ($i = 1; $i <= 10; $i++) {
            $this->insert('{{%offers}}', [
                'name' => 'Name ' . $i,
                'email' => 'email' . $i . '@example.com',
                'phone' => 81234567890 + $i,
                'created_at' => strtotime("+{$i} days"), // Пример: создаем дату через i дней
                'updated_at' => strtotime("+{$i} days"), // Пример: создаем дату через i дней
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%offers}}');
    }
}