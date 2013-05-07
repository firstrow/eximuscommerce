<?php

class m130507_103455_add_banned_to_user extends CDbMigration
{
	public function up()
	{
		$this->addColumn('user', 'banned', 'boolean');
		$this->dbConnection->createCommand("ALTER TABLE  `user` CHANGE  `banned`  `banned` TINYINT( 1 ) NULL DEFAULT '0'");
	}

	public function down()
	{
		$this->dropColumn('user', 'banned');
	}

}