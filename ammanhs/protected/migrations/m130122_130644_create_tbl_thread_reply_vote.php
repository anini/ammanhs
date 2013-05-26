<?php

class m130122_130644_create_tbl_thread_reply_vote extends CDbMigration
{
    public function up()
    {
		$transaction=$this->getDbConnection()->beginTransaction();
		try
		{
			$this->createTable('tbl_thread_reply_vote', array(
				'id' => 'int(11) NOT NULL AUTO_INCREMENT',
                'user_id' => 'int(11) NOT NULL',
                'thread_reply_id' => 'int(11) NOT NULL',
                'vote_type' => 'int(11) NOT NULL DEFAULT 1',
                'created_at' => 'int(11) DEFAULT NULL',
                'updated_at' => 'int(11) DEFAULT NULL',
                'PRIMARY KEY(`id`)'),
                'ENGINE=InnoDB CHARSET=utf8'
            );

            $this->createIndex('ix_tbl_thread_reply_vote_user_id', 'tbl_thread_reply_vote', 'user_id', false);
            $this->createIndex('ix_tbl_thread_reply_vote_thread_id', 'tbl_thread_reply_vote', 'thread_reply_id', false);
            $this->createIndex('ix_tbl_thread_reply_vote_vote_type', 'tbl_thread_reply_vote', 'vote_type', false);
            $this->addForeignKey('fk_tbl_thread_reply_vote_user_id', 'tbl_thread_reply_vote', 'user_id', 'tbl_user', 'id', 'RESTRICT', 'CASCADE');
            $this->addForeignKey('fk_tbl_thread_reply_vote_thread_id', 'tbl_thread_reply_vote', 'thread_reply_id','tbl_thread_reply', 'id', 'RESTRICT', 'CASCADE');

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
			$this->dropTable('tbl_thread_reply_vote');

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
