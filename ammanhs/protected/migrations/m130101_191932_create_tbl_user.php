<?php

class m130101_191932_create_tbl_user extends CDbMigration
{
	public function up()
	{
		$transaction=$this->getDbConnection()->beginTransaction();
		try
		{
			$this->createTable('tbl_user', array(
				'id' => 'int(11) NOT NULL AUTO_INCREMENT',
                'username' => 'varchar(64) NOT NULL',
                'password' => 'varchar(64) NOT NULL',
                'email' => 'varchar(128) NOT NULL',
                'first_name' => 'varchar(64) NOT NULL DEFAULT ""',
                'last_name' => 'varchar(64) NOT NULL DEFAULT ""',
                'type' => 'enum("User","Member","Hacker","Admin") NOT NULL DEFAULT "User"',
                'gender' => 'int(11) DEFAULT NULL',
                'about' => 'text',
                'avatar_uri' => 'varchar(256) DEFAULT NULL',
                'created_at' => 'int(11) DEFAULT NULL',
                'last_login_at' => 'int(11) DEFAULT NULL',
                'mobile' => 'varchar(64) DEFAULT NULL',
                'website' => 'varchar(128) DEFAULT NULL',
                'twitter_uri' => 'varchar(128) DEFAULT NULL',
                'twitter_id' => 'int(11) DEFAULT NULL',
                'facebook_uri' => 'varchar(128) DEFAULT NULL',
                'facebook_id' => 'int(11) DEFAULT NULL',
                'google_uri' => 'varchar(128) DEFAULT NULL',
                'google_id' => 'int(11) DEFAULT NULL',
                'country' => 'varchar(64) DEFAULT NULL',
                'stat_threads' => 'int(11) NOT NULL DEFAULT 0',
                'stat_replies' => 'int(11) NOT NULL DEFAULT 0',
                'stat_votes' => 'int(11) NOT NULL DEFAULT 0',
                'stat_points' => 'int(11) NOT NULL DEFAULT 0',
                'stat_views' => 'int(11) NOT NULL DEFAULT 0',
                'signup_ref' => 'varchar(256) NOT NULL DEFAULT ""',
                'active' => 'int(11) NOT NULL DEFAULT 1',
                'ip_address' => 'varchar(64) NOT NULL DEFAULT ""',
                'PRIMARY KEY(`id`)'),
                'ENGINE=InnoDB CHARSET=utf8'
            );
            
            $this->createIndex('ix_tbl_user_username', 'tbl_user', 'username', true);
            $this->createIndex('ix_tbl_user_email', 'tbl_user', 'email', true);
            $this->createIndex('ix_tbl_user_type', 'tbl_user', 'type', false);
            $this->createIndex('ix_tbl_user_created_at', 'tbl_user', 'created_at', false);
            $this->createIndex('ix_tbl_user_last_login_at', 'tbl_user', 'last_login_at', false);
            $this->createIndex('ix_tbl_user_twitter_id', 'tbl_user', 'twitter_id', true);
            $this->createIndex('ix_tbl_user_facebook_id', 'tbl_user', 'facebook_id', true);
            $this->createIndex('ix_tbl_user_google_id', 'tbl_user', 'google_id', true);
            $this->createIndex('ix_tbl_user_twitter_uri', 'tbl_user', 'twitter_uri', false);
            $this->createIndex('ix_tbl_user_facebook_uri', 'tbl_user', 'facebook_uri', false);
            $this->createIndex('ix_tbl_user_google_uri', 'tbl_user', 'google_uri', false);

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
			$this->dropTable('tbl_user');
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

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}