<?php

class m130507_104810_unban_all_users extends CDbMigration
{
	public function up()
	{
		$this->dbConnection->createCommand('UPDATE `user` SET banned=0')->execute();
	}

	public function down()
	{
		echo "m130507_104810_unban_all_users does not support migration down.\n";
		return false;
	}
}