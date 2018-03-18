<?php

use yii\db\Migration;

/**
 * Handles the creation of table `category`.
 */
class m180318_032254_create_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('category', [
            'id' => $this->primaryKey(),
            'tree' => $this->integer()->notNull()->comment("分类"),
            'lft' => $this->integer()->notNull()->comment("左值"),
            'rgt' => $this->integer()->notNull()->comment("右值"),
            'depth' => $this->integer()->notNull()->comment("深度"),
            'name' => $this->string()->notNull()->comment("名称"),
            'introduce' => $this->string()->notNull()->comment("简介"),
            'parend_id' => $this->integer()->notNull()->defaultValue(0)->comment("父级id"),

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('category');
    }
}
