<?php

use yii\db\Migration;

/**
 * Class m210127_125840_m210127_155101_create_job
 */
class m210127_125840_m210127_155101_create_job extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //$options = 'character set utf8 collate utf8_unicode_ci engine=InnoDB';
        $options = '';
        $this->createTable('{{job}}', [
            'id' => $this->primaryKey(),
            'add_at' => $this->timestamp()->notNull()->defaultExpression('current_timestamp'),
            'work_at' => $this->timestamp(),
            'done_at' => $this->timestamp(),
            'job_name' => $this->string(50)->notNull()
        ], $options);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{job}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210127_125840_m210127_155101_create_job cannot be reverted.\n";

        return false;
    }
    */
}
