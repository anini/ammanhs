<?php

class m130915_204225_create_tbl_activity extends CDbMigration
{
    public function up()
    {
		$transaction=$this->getDbConnection()->beginTransaction();
		try
		{
			$this->createTable('tbl_activity', array(
				'id'=>'int(11) NOT NULL AUTO_INCREMENT',
                'date'=>'int(11) NOT NULL',
                'title'=>'varchar(256) NOT NULL',
                'photo_uri'=>'varchar(256) DEFAULT NULL',
                'content'=>'text NOT NULL',
                'tags'=>'varchar(128) NOT NULL DEFAULT ""',
                'uq_title'=>'varchar(256) DEFAULT NULL',
                'stat_photos'=>'int(11) NOT NULL DEFAULT 0',
                'stat_attachments'=>'int(11) NOT NULL DEFAULT 0',
                'stat_replies'=>'int(11) NOT NULL DEFAULT 0',
                'stat_views'=>'int(11) NOT NULL DEFAULT 0',
                'publish_status' => 'int(11) NOT NULL DEFAULT 0',
                'created_at'=>'int(11) DEFAULT NULL',
                'updated_at'=>'int(11) DEFAULT NULL',
                'PRIMARY KEY(`id`)'),
                'ENGINE=InnoDB CHARSET=utf8'
            );
            
            $this->createIndex('ix_tbl_activity_date', 'tbl_activity', 'date', false);
            $this->createIndex('ix_tbl_activity_publish_status', 'tbl_activity', 'publish_status', false);
            $this->createIndex('ix_tbl_activity_uq_title', 'tbl_activity', 'uq_title', true);

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
			$this->dropTable('tbl_activity');
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
