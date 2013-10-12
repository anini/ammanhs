<?php

class m130309_192033_create_tbl_user_log extends CDbMigration
{
    public function up()
    {
		$transaction=$this->getDbConnection()->beginTransaction();
		try
		{
            $this->createTable('tbl_user_log', array(
				'id' => 'int(11) NOT NULL AUTO_INCREMENT',
                'user_id' => 'int(11) NOT NULL',
                'action' => 'enum("Add","Edit","VoteUp","VoteDown","Follow","Join","Unsubscribe") NOT NULL DEFAULT "Add"',
                'thread_id' => 'int(11) DEFAULT NULL',
                'thread_reply_id' => 'int(11) DEFAULT NULL',
                'activity_reply_id' => 'int(11) DEFAULT NULL',
                'targeted_user_id' => 'int(11) DEFAULT NULL',
                'uri' => 'varchar(256) DEFAULT NULL',
                'points_earned' => 'int(11) NOT NULL DEFAULT 0',
                'created_at' => 'int(11) DEFAULT NULL',
                'PRIMARY KEY(`id`)'),
                'ENGINE=InnoDB CHARSET=utf8'
            );
            
            $this->createIndex('ix_tbl_user_log_user_id', 'tbl_user_log', 'user_id', false);
            $this->createIndex('ix_tbl_user_log_action', 'tbl_user_log', 'action', false);
            $this->createIndex('ix_tbl_user_log_thread_id', 'tbl_user_log', 'thread_id', false);
            $this->createIndex('ix_tbl_user_log_thread_reply_id', 'tbl_user_log', 'thread_reply_id', false);
            $this->createIndex('ix_tbl_user_log_activity_reply_id', 'tbl_user_log', 'activity_reply_id', false);
            $this->createIndex('ix_tbl_user_log_targeted_user_id', 'tbl_user_log', 'targeted_user_id', false);
            $this->createIndex('ix_tbl_user_log_created_at', 'tbl_user_log', 'created_at', false);

            $this->addForeignKey('fk_tbl_user_log_user_id', 'tbl_user_log', 'user_id', 'tbl_user', 'id', 'RESTRICT', 'CASCADE');
            $this->addForeignKey('fk_tbl_user_log_thread_id', 'tbl_user_log', 'thread_id', 'tbl_thread', 'id', 'RESTRICT', 'CASCADE');
            $this->addForeignKey('fk_tbl_user_log_thread_reply_id', 'tbl_user_log', 'thread_reply_id', 'tbl_thread_reply', 'id', 'RESTRICT', 'CASCADE');
            $this->addForeignKey('fk_tbl_user_log_activity_reply_id', 'tbl_user_log', 'activity_reply_id', 'tbl_activity_reply', 'id', 'RESTRICT', 'CASCADE');
            $this->addForeignKey('fk_tbl_user_log_targeted_user_id', 'tbl_user_log', 'targeted_user_id', 'tbl_user', 'id', 'RESTRICT', 'CASCADE');

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
			$this->dropTable('tbl_user_log');
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
