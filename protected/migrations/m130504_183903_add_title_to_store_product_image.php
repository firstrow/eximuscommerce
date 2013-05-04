<?php

class m130504_183903_add_title_to_store_product_image extends CDbMigration
{
	public function up()
	{
		$this->addColumn('StoreProductImage', 'title', 'string');
	}

	public function down()
	{
		$this->dropColumn('StoreProductImage', 'title');
	}

}