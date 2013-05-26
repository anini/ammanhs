<?php

class m130102_190954_create_tbl_thread_reply extends CDbMigration
{
    public function up()
    {
		$transaction=$this->getDbConnection()->beginTransaction();
		try
		{
			$this->createTable('tbl_thread_reply', array(
				'id' => 'int(11) NOT NULL AUTO_INCREMENT',
                'user_id' => 'int(11) NOT NULL',
                'thread_id' => 'int(11) NOT NULL',
                'stat_votes' => 'int(11) NOT NULL DEFAULT 0',
                'content' => 'text',
                'created_at' => 'int(11) DEFAULT NULL',
                'updated_at' => 'int(11) DEFAULT NULL',
                'publish_status' => 'int(11) NOT NULL DEFAULT 0',
                'PRIMARY KEY(`id`)'),
                'ENGINE=InnoDB CHARSET=utf8'
            );

            $this->createIndex('ix_tbl_thread_reply_user_id', 'tbl_thread_reply', 'user_id', false);
            $this->createIndex('ix_tbl_thread_reply_thread_id', 'tbl_thread_reply', 'thread_id', false);
            $this->createIndex('ix_tbl_thread_reply_stat_votes', 'tbl_thread_reply', 'stat_votes', false);
            $this->createIndex('ix_tbl_thread_reply_created_at', 'tbl_thread_reply', 'created_at', false);
            $this->createIndex('ix_tbl_thread_reply_updated_at', 'tbl_thread_reply', 'updated_at', false);
            $this->createIndex('ix_tbl_thread_reply_publish_status', 'tbl_thread_reply', 'publish_status', false);
            $this->addForeignKey('fk_tbl_thread_reply_user_id', 'tbl_thread_reply', 'user_id', 'tbl_user', 'id', 'RESTRICT', 'CASCADE');
            $this->addForeignKey('fk_tbl_thread_reply_thread_id', 'tbl_thread_reply', 'thread_id','tbl_thread', 'id', 'RESTRICT', 'CASCADE');

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
			$this->dropTable('tbl_thread_reply');
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
