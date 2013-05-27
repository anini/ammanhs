<?php

class m130527_161537_create_tbl_membership extends CDbMigration
{
    public function up()
    {
		$transaction=$this->getDbConnection()->beginTransaction();
		try
		{
			$this->createTable('tbl_membership', array(
				'id' => 'int(11) NOT NULL AUTO_INCREMENT',
                'user_id' => 'int(11) NOT NULL',
                'type' => 'enum("Premium","Golden","Free")',
                'status' => 'int(11) NOT NULL DEFAULT 0',
                'organization' => 'varchar(256)',
                'title' => 'varchar(128)',
                'created_at' => 'int(11) DEFAULT NULL',
                'updated_at' => 'int(11) DEFAULT NULL',
                'PRIMARY KEY(`id`)'),
                'ENGINE=InnoDB CHARSET=utf8'
            );

            $this->createIndex('ix_tbl_membership_type', 'tbl_membership', 'type', false);
            $this->addForeignKey('fk_tbl_membership_user_id', 'tbl_membership', 'user_id', 'tbl_user', 'id', 'RESTRICT', 'CASCADE');

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
			$this->dropTable('tbl_membership');
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
