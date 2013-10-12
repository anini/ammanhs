<?php

class m130102_151046_create_tbl_thread extends CDbMigration
{
    public function up()
    {
        $transaction=$this->getDbConnection()->beginTransaction();
        try
        {
            $this->createTable('tbl_thread', array(
                'id' => 'int(11) NOT NULL AUTO_INCREMENT',
                'user_id' => 'int(11) NOT NULL',
                'type' => 'enum("Question","Idea","Discussion","Announcement","Article") NOT NULL DEFAULT "Article"',
                'title' => 'varchar(256) NOT NULL',
                'content' => 'text',
                'tags' => 'varchar(128) NOT NULL DEFAULT ""',
                'stat_replies' => 'int(11) NOT NULL DEFAULT 0',
                'stat_votes' => 'int(11) NOT NULL DEFAULT 0',
                'stat_views' => 'int(11) NOT NULL DEFAULT 0',
                'created_at' => 'int(11) DEFAULT NULL',
                'updated_at' => 'int(11) DEFAULT NULL',
                'publish_status' => 'int(11) NOT NULL DEFAULT 0',
                'uq_title' => 'varchar(256) DEFAULT NULL',
                'PRIMARY KEY(`id`)'),
                'ENGINE=InnoDB CHARSET=utf8'
            );

            $this->createIndex('ix_tbl_thread_user_id', 'tbl_thread', 'user_id', false);
            $this->createIndex('ix_tbl_thread_type', 'tbl_thread', 'type', false);
            $this->createIndex('ix_tbl_thread_title', 'tbl_thread', 'title', false);
            $this->createIndex('ix_tbl_thread_tags', 'tbl_thread', 'tags', false);
            $this->createIndex('ix_tbl_thread_stat_replies', 'tbl_thread', 'stat_replies', false);
            $this->createIndex('ix_tbl_thread_stat_votes', 'tbl_thread', 'stat_votes', false);
            $this->createIndex('ix_tbl_thread_stat_views', 'tbl_thread', 'stat_views', false);
            $this->createIndex('ix_tbl_thread_created_at', 'tbl_thread', 'created_at', false);
            $this->createIndex('ix_tbl_thread_updated_at', 'tbl_thread', 'updated_at', false);
            $this->createIndex('ix_tbl_thread_publish_status', 'tbl_thread', 'publish_status', false);
            $this->createIndex('ix_tbl_thread_uq_title', 'tbl_thread', 'uq_title', true);
            $this->addForeignKey('fk_tbl_thread_user_id', 'tbl_thread', 'user_id', 'tbl_user', 'id', 'RESTRICT', 'CASCADE');

            $transaction->commit();
        }
        catch(Exception $e)
        {
            echo "Exception: ".$e->getMessage().' ('.$e->getFile().':'.$e->getLine().")\n";
            echo $e->getTraceAsString()."\n";
            echo "\n\n\nRollback:\n\n";
            $transaction->rollBack();
            return false;
        }
    }

    
    public function down()
    {
        
        $transaction=$this->getDbConnection()->beginTransaction();
        try
        {
            $this->dropTable('tbl_thread');
            $transaction->commit();
        
        }
        catch(Exception $e)
        {
            echo "Exception: ".$e->getMessage().' ('.$e->getFile().':'.$e->getLine().")\n";
            echo $e->getTraceAsString()."\n";
            echo "\n\n\nRollback:\n\n";
            $transaction->rollBack();
            return false;
        }
        
    }
    
}
