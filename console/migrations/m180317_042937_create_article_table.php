<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article`.
 */
class m180317_042937_create_article_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('article', [
            'id' => $this->primaryKey(),
            'title'=>$this->string()->notNull()->comment("文章标题"),
            'introduce'=>$this->text()->comment("介绍"),
            'sort'=>$this->integer()->notNull()->defaultValue(100)->comment("排序"),
            'status'=>$this->smallInteger()->notNull()->defaultValue(1)->comment("状态"),
            'cate_id'=>$this->integer()->comment("分类id"),
            'create_time'=>$this->integer()->comment("创建时间"),
            'update_time'=>$this->integer()->comment("更新时间"),
        ]);
        $this->createTable('article_content', [
            'id' => $this->primaryKey(),
            'detail'=>$this->text()->comment("文章内容"),
            'article_id'=>$this->integer()->comment("文章id"),

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('article');
        $this->dropTable('article_content');
    }
}
