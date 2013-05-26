<?php

class {ClassName} extends CDbMigration
{
    public function up()
    {
		$transaction=$this->getDbConnection()->beginTransaction();
		try
		{
			# Some Positive DDL Examples
			# $this->createTable('tbl_name', array('id'=>'INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL', 'foo'=>'TEXT'), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');
			# $this->createIndex(string $name, string $table, string $column, boolean $unique=false);
			# $this->addColumn('tbl_name', 'column_name', 'integer(11)');
			# $this->addForeignKey('mysql_fk_name', 'tbl_name', 'fk_field', 'referance_tbl', 'referance_tbl_id', 'RESTRICT', 'CASCADE');
			# $this->createIndex('index_name', 'tbl_name', 'column_name', (boolean){{is_unique}});
			# $sql="UPDATE tbl_name SET user_id=0 WHERE id>:id";
			# $this->execute($sql, array(':id'=>9000));
            # many queries
            # $sqls=array();
            # $sqls[]=array('INSERT INTO tbl_name (id, content) VALUES (:id, :content)', array(':id'=>$id, ':content'=>$content));
            # foreach($sqls as $sql){
            #     list($q, $p)=$sql;
            #     $this->execute($q, $p);
            # }

			# Dont remove below
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
			# Some Negative DDL Examples
			# $this->dropTable('tbl_name');
			# $this->dropColumn('tbl_name', 'column_name');
			# $this->dropForeignKey('mysql_fk_name', 'tbl_name');

			# NOTE: remove line below if no down
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
