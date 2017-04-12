<?php

use yii\db\Migration;

/**
 * Handles the creation of table `junction`.
 * Has foreign keys to the tables:
 *
 * - `table`
 * - `table`
 */
class m170412_140827_create_junction_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('junction', [
            'id' => $this->primaryKey()->notNull()->unsigned(),
            't1' => $this->smallInteger()->notNull()->unsigned()->comment('Таблица1'),
            't2' => $this->smallInteger()->notNull()->unsigned()->comment('Таблица2'),
        ]);

        // creates index for column `t1`
        $this->createIndex(
            'idx-junction-t1',
            'junction',
            't1'
        );

        // add foreign key for table `table`
        $this->addForeignKey(
            'fk-junction-t1',
            'junction',
            't1',
            'table',
            'id',
            'CASCADE'
        );

        // creates index for column `t2`
        $this->createIndex(
            'idx-junction-t2',
            'junction',
            't2'
        );

        // add foreign key for table `table`
        $this->addForeignKey(
            'fk-junction-t2',
            'junction',
            't2',
            'table',
            'id',
            'CASCADE'
        );

        $this->addCommentOnTable('junction', 'Связь Many-to-many');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `table`
        $this->dropForeignKey(
            'fk-junction-t1',
            'junction'
        );

        // drops index for column `t1`
        $this->dropIndex(
            'idx-junction-t1',
            'junction'
        );

        // drops foreign key for table `table`
        $this->dropForeignKey(
            'fk-junction-t2',
            'junction'
        );

        // drops index for column `t2`
        $this->dropIndex(
            'idx-junction-t2',
            'junction'
        );

        $this->dropTable('junction');
    }
}
