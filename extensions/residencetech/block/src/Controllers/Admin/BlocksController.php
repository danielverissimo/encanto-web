<?php namespace Residencetech\Block\Controllers\Admin;

use Platform\Access\Controllers\AdminController;
use Firework\Common\Controllers\CrudTrait;

class BlocksController extends AdminController {

	use CrudTrait;

	protected $csrfWhitelist = [
		'executeAction',
	];

	protected $columns = [
		'id',
			'name',
			'created_at',
	];

	protected $settings = [
		'sort'      => 'id',
		'direction' => 'asc',
	];

	protected $actions = [
		'delete',
	];

	protected $langPrefix = 'residencetech/block::blocks/';

	protected $viewPrefix = 'residencetech/block::blocks/';

	protected $uri = 'block/blocks';

	protected $route = 'admin.residencetech.block.blocks';

}
