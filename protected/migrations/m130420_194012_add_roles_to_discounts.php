<?php

class m130420_194012_add_roles_to_discounts extends CDbMigration
{
	public function up()
	{
		$this->addColumn('Discount','roles', 'string');
	}

	public function down()
	{
		$this->dropColumn('Discount', 'roles');
	}
}