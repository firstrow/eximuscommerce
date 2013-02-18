<?php

class m130218_190341_add_description_to_store_category extends CDbMigration
{
	public function up()
	{
		$this->addColumn('StoreCategory', 'description', 'text');
	}

	public function down()
	{
		$this->dropColumn('StoreCategory', 'description');
	}

}