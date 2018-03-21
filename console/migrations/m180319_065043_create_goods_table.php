<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods`.
 */
class m180319_065043_create_goods_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('goods', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment("名称"),
            'sn'=>$this->integer()->notNull()->comment("货物"),
            'logo'=>$this->string()->notNull()->comment("图标"),
            'goods_category_id'=>$this->integer()->notNull()->defaultValue(0)->comment("商品分类"),
            'brand_id'=>$this->smallInteger(5)->notNull()->defaultValue(0)->comment("品牌"),
            'market_price'=>$this->decimal(10,2)->notNull()->defaultValue(0.00)->comment("市场价格"),
            'shop_price'=>$this->decimal(10,2)->notNull()->defaultValue(0.00)->comment("本店价格"),
            'stock'=>$this->integer(11)->notNull()->defaultValue(0)->comment("库存"),
            'is_on_sale'=>$this->tinyInteger(4)->notNull()->defaultValue(1)->comment("是否上架：1上架，0下架"),
            'sort'=>$this->tinyInteger(4)->notNull()->defaultValue(20)->comment("排序"),
            'create_time'=>$this->integer()->notNull()->comment("录入时间"),



        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('goods');
    }
}
