<?php

class m130915_204311_create_tbl_activity_photo extends CDbMigration
{
    public function up()
    {
		$transaction=$this->getDbConnection()->beginTransaction();
		try
		{
			$this->createTable('tbl_activity_photo', array(
				'id'=>'int(11) NOT NULL AUTO_INCREMENT',
                'activity_id'=>'int(11) NOT NULL',
                'caption'=>'varchar(256) NOT NULL DEFAULT ""',
                'uri'=>'varchar(256) NOT NULL',
                'updated_at'=>'int(11) DEFAULT NULL',
                'created_at'=>'int(11) DEFAULT NULL',
                'PRIMARY KEY(`id`)'),
                'ENGINE=InnoDB CHARSET=utf8'
            );

			$this->createIndex('ix_tbl_activity_photo_activity_id', 'tbl_activity_photo', 'activity_id', false);
            $this->addForeignKey('fk_tbl_activity_photo_activity_id', 'tbl_activity_photo', 'activity_id', 'tbl_activity', 'id', 'RESTRICT', 'CASCADE');
			
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
			$this->dropTable('tbl_activity_photo');
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
