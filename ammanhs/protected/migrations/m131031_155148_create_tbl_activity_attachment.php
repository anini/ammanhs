<?php

class m131031_155148_create_tbl_activity_attachment extends CDbMigration
{
    public function up()
    {
		$transaction=$this->getDbConnection()->beginTransaction();
		try
		{
			$this->createTable('tbl_activity_attachment', array(
				'id'=>'int(11) NOT NULL AUTO_INCREMENT',
                'activity_id'=>'int(11) NOT NULL',
                'name'=>'varchar(256) NOT NULL DEFAULT ""',
                'type' => 'enum("Presentation","PDF","Code","Compressed") NOT NULL DEFAULT "Presentation"',
                'uri'=>'varchar(256) NOT NULL',
                'updated_at'=>'int(11) DEFAULT NULL',
                'created_at'=>'int(11) DEFAULT NULL',
                'PRIMARY KEY(`id`)'),
                'ENGINE=InnoDB CHARSET=utf8'
            );

			$this->createIndex('ix_tbl_activity_attachment_activity_id', 'tbl_activity_attachment', 'activity_id', false);
            $this->addForeignKey('fk_tbl_activity_attachment_activity_id', 'tbl_activity_attachment', 'activity_id', 'tbl_activity', 'id', 'RESTRICT', 'CASCADE');
			
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
			$this->dropTable('tbl_activity_attachment');
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
