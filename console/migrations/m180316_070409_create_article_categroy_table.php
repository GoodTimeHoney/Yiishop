<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article_categroy`.
 */
class m180316_070409_create_article_categroy_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('article_categroy', [
            'id' => $this->primaryKey(),
            'name'=>$this->string()->notNull()->comment("名称"),
            'introduce'=>$this->string()->comment("简历"),
            'sort'=>$this->integer()->notNull()->defaultValue(100)->comment("排序"),
            'status'=>$this->smallInteger()->notNull()->defaultValue(1)->comment("状态"),
            "is_help"=>$this->smallInteger()->defaultValue(0)->comment("是否帮助")
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('article_categroy');
    }
}
