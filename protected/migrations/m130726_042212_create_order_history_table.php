<?php

class m130726_042212_create_order_history_table extends CDbMigration
{
	private $t='OrderHistory';

	public function up()
	{
		$this->createTable($this->t, array(
			'id'          => 'pk',
			'order_id'    => 'integer',
			'user_id'     => 'integer',
			'username'    => 'string',
			'handler'     => 'string',
			'data_before' => 'text',
			'data_after'  => 'text',
			'created'     => 'datetime',
		));

		$this->createIndex('order_index', $this->t,'order_id');
		$this->createIndex('created_index', $this->t,'created');
	}

	public function down()
	{
		$this->dropTable($this->t);
	}
}