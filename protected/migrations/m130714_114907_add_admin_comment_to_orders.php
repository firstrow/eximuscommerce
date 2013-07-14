<?php

class m130714_114907_add_admin_comment_to_orders extends CDbMigration
{
	public function up()
	{
		$this->addColumn('Order', 'admin_comment', 'text');
	}

	public function down()
	{
		$this->dropColumn('Order', 'admin_comment');
	}
}