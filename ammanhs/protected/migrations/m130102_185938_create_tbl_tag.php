<?php

class m130102_185938_create_tbl_tag extends CDbMigration
{
    public function up()
    {
		$transaction=$this->getDbConnection()->beginTransaction();
		try
		{
			$this->createTable('tbl_tag', array(
				'id' => 'int(11) NOT NULL AUTO_INCREMENT',
                'name_ar' => 'varchar(128) NOT NULL',
                'name_en' => 'varchar(128) NOT NULL',
                'stat_threads' => 'int(11) NOT NULL DEFAULT 0',
                'PRIMARY KEY(`id`)'),
                'ENGINE=InnoDB CHARSET=utf8'
            );

            $this->createIndex('ix_tbl_tag_name_ar', 'tbl_tag', 'name_ar', true);
            $this->createIndex('ix_tbl_tag_name_en', 'tbl_tag', 'name_en', true);
            $this->createIndex('ix_tbl_tag_stat_threads', 'tbl_tag', 'stat_threads', false);

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
			$this->dropTable('tbl_tag');
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
