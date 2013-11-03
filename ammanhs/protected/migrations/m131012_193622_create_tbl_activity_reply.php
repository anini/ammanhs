<?php

class m131012_193622_create_tbl_activity_reply extends CDbMigration
{
    public function up()
    {
		$transaction=$this->getDbConnection()->beginTransaction();
		try
		{
			$this->createTable('tbl_activity_reply', array(
				'id'=>'int(11) NOT NULL AUTO_INCREMENT',
                'user_id'=>'int(11) NOT NULL',
                'activity_id'=>'int(11) NOT NULL',
                'content'=>'text',
                'created_at'=>'int(11) DEFAULT NULL',
                'updated_at'=>'int(11) DEFAULT NULL',
                'publish_status'=>'int(11) NOT NULL DEFAULT 0',
                'PRIMARY KEY(`id`)'),
                'ENGINE=InnoDB CHARSET=utf8'
            );

            $this->createIndex('ix_tbl_activity_reply_user_id', 'tbl_activity_reply', 'user_id', false);
            $this->createIndex('ix_tbl_activity_reply_activity_id', 'tbl_activity_reply', 'activity_id', false);
            $this->createIndex('ix_tbl_activity_reply_created_at', 'tbl_activity_reply', 'created_at', false);
            $this->createIndex('ix_tbl_activity_reply_updated_at', 'tbl_activity_reply', 'updated_at', false);
            $this->createIndex('ix_tbl_activity_reply_publish_status', 'tbl_activity_reply', 'publish_status', false);
            $this->addForeignKey('fk_tbl_activity_reply_user_id', 'tbl_activity_reply', 'user_id', 'tbl_user', 'id', 'RESTRICT', 'CASCADE');
            $this->addForeignKey('fk_tbl_activity_reply_activity_id', 'tbl_activity_reply', 'activity_id','tbl_activity', 'id', 'RESTRICT', 'CASCADE');

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
			$this->dropTable('tbl_activity_reply');
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
