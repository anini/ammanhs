<?php

class m130525_174537_create_auth_tables extends CDbMigration
{
    public function up()
    {
		$transaction=$this->getDbConnection()->beginTransaction();
		try
		{
			$this->createTable('AuthAssignment', array(
				'id' => 'int(11) NOT NULL AUTO_INCREMENT',
                'itemname' => 'varchar(64) NOT NULL',
                'userid' => 'varchar(64) NOT NULL',
                'bizrule' => 'text',
                'data' => 'text',
                'PRIMARY KEY(`id`)'),
                'ENGINE=InnoDB CHARSET=utf8'
            );

            $this->createTable('AuthItem', array(
                'name' => 'varchar(64) NOT NULL',
                'type' => 'int(11) NOT NULL',
                'description' => 'text',
                'bizrule' => 'text',
                'data' => 'text',
                'PRIMARY KEY(`name`)'),
                'ENGINE=InnoDB CHARSET=utf8'
            );

            $this->createTable('AuthItemChild', array(
                'parent' => 'varchar(64) NOT NULL',
                'child' => 'varchar(64) NOT NULL',
                'PRIMARY KEY(`parent`, `child`)'),
                'ENGINE=InnoDB CHARSET=utf8'
            );

            $this->addForeignKey('fk_AuthAssignment_itemname', 'AuthAssignment', 'itemname', 'AuthItem', 'name', 'RESTRICT', 'CASCADE');
            $this->addForeignKey('fk_AuthItemChild_parent', 'AuthItemChild', 'parent', 'AuthItem', 'name', 'RESTRICT', 'CASCADE');
            $this->addForeignKey('fk_AuthItemChild_child', 'AuthItemChild', 'child', 'AuthItem', 'name', 'RESTRICT', 'CASCADE');
            
            $this->execute('INSERT INTO AuthItem (name, type, description) VALUES ("root", 2, "Responsible for the back end issues related to the system. Such as granting privileges to users, etc.")');
            $this->execute('INSERT INTO AuthItem (name, type, description) VALUES ("admin", 2, "Can edit threads, thread replies, users, etc.")');
            $this->execute('INSERT INTO AuthItemChild (parent, child) VALUES ("root", "admin")');

			//dont remove below
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
			$this->dropForeignKey('fk_AuthAssignment_userid', 'AuthAssignment');
			$this->dropForeignKey('fk_AuthAssignment_itemname', 'AuthAssignment');
			$this->dropForeignKey('fk_AuthItemChild_parent', 'AuthItemChild');
			$this->dropForeignKey('fk_AuthItemChild_child', 'AuthItemChild');

			$this->dropTable('AuthItemChild');
			$this->dropTable('AuthItem');
			$this->dropTable('AuthAssignment');

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
