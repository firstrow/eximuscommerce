<?php

class m130504_170119_add_discout_to_order extends CDbMigration
{
	public function up()
	{
		$this->addColumn('Order','discount', 'string');
	}

	public function down()
	{
		$this->dropColumn('Order', 'discount');
	}

}