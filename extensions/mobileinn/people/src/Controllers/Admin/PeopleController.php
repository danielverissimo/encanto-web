<?php namespace Mobileinn\People\Controllers\Admin;

use Mobileinn\People\Repositories\Person\PersonRepositoryInterface;
use Platform\Access\Controllers\AdminController;
use Firework\Common\Controllers\CrudTrait;
use Residencetech\Apartmentcomplex\Repositories\Apartmentcomplex\ApartmentcomplexRepositoryInterface;
use Residencetech\Apartmentcomplex\Models\Apartmentcomplex;
use Input;

class PeopleController extends AdminController {

	use CrudTrait
	{
		showForm as showFormTrait;
		processForm as processFormTrait;
	}

	protected $csrfWhitelist = [
		'executeAction',
	];

	protected $columns = [
		'name',
		'gender',
		'cpf',
		'telephone',
	];

	protected $settings = [
		'sort'      => 'id',
		'direction' => 'asc',
	];

	protected $actions = [
		'delete',
	];

	protected $langPrefix = 'mobileinn/people::people/';

	protected $viewPrefix = 'mobileinn/people::people/';

	protected $uri = 'people/people';

	protected $route = 'admin.mobileinn.people.people';



	public function __construct(PersonRepositoryInterface $items, ApartmentcomplexRepositoryInterface $apartmentComplexes)
	{
		parent::__construct();
		$this->items          = $items;
		$this->apartmentComplexes    = $apartmentComplexes;
	}

	protected function showForm($mode, $id = null)
	{

		$item = null;
		if ( ! is_null($id)) {
			$item = $this->items->find($id);
		} else {
			$item = $this->items->createModel();
		}

		$allApartmentComplex = Input::old('apartmentComplexes');
		if ($allApartmentComplex) {
			foreach ($allApartmentComplex as $key => $value) {
				$allApartmentComplex[$key] = $this->apartmentComplexes->find($value);
			}
		} else {
			$allApartmentComplex = $item->exists ? $item->apartmentComplexes : array();
		}

		$this->extraVars(compact('allApartmentComplex'));

		return $this->showFormTrait($mode, $id);
	}

	public function update($id)
	{

		return $this->processFormTrait('update', $id);
	}
}
