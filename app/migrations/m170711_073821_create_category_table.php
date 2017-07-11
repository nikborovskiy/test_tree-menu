<?php

use yii\db\Migration;

/**
 * Handles the creation of table `category`.
 * Has foreign keys to the tables:
 *
 * - `category`
 */
class m170711_073821_create_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%category}}', [
            'id' => $this->primaryKey()->comment('#'),
            'name' => $this->string(255)->comment('Название категории'),
            'parent_id' => $this->integer()->comment('Родительская категория'),
        ]);

        // creates index for column `parent_id`
        $this->createIndex(
            'idx-category-parent_id',
            '{{%category}}',
            'parent_id'
        );

        // add foreign key for table `category`
        $this->addForeignKey(
            'fk-category-parent_id',
            '{{%category}}',
            'parent_id',
            '{{%category}}',
            'id',
            'CASCADE'
        );

        $data = [
            [
                'name' => 'category1',
                'parent_id' => null,
            ],
            [
                'name' => 'category2',
                'parent_id' => null,
            ],
            [
                'name' => 'category1_1',
                'parent_id' => 1,
            ],
            [
                'name' => 'category2_1',
                'parent_id' => 2,
            ],
            [
                'name' => 'category2_1_1',
                'parent_id' => 4,
            ],
            [
                'name' => 'category3',
                'parent_id' => null,
            ],
        ];

        foreach ($data as $item) {
            $this->insert('{{%category}}', [
                'name' => $item['name'],
                'parent_id' => $item['parent_id']
            ]);
        }
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `category`
        $this->dropForeignKey(
            'fk-category-parent_id',
            '{{%category}}'
        );

        // drops index for column `parent_id`
        $this->dropIndex(
            'idx-category-parent_id',
            '{{%category}}'
        );

        $this->dropTable('{{%category}}');
    }
}
