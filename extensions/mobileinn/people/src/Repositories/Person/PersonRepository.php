<?php namespace Mobileinn\People\Repositories\Person;

use Firework\Common\Repositories\CrudTrait;
use Firework\Common\Repositories\HasOneTrait;
use Firework\Common\Repositories\BelongsToManyTrait;

class PersonRepository implements PersonRepositoryInterface {

	use CrudTrait, BelongsToManyTrait, HasOneTrait;

	public function bootPersonRepository()
	{
		$this->address   = app('mobileinn.people.address');
		$this->cities    = app('firework.locations.city');
		$this->states    = app('firework.locations.state');
		$this->countries = app('firework.locations.country');
		$this->users = app('platform.users');

		$this->apartmentComplexes = app('residencetech.apartmentcomplex.apartmentcomplex');
		$this->belongsToManyRelations[] = 'apartmentComplexes';

		$this->hasOneRelations[] = 'address';

		$this->addAfterSaveCallbacks('setUser');
	}

	public function getPreparedItem($id, $mode)
	{
		$data = $this->getPreparedItemTrait($id, $mode);

		$countries = $this->countries->findAll();
		$states    = [];
		$cities    = [];

		if (eloquent_get($data['item'], 'address'))
		{
			$states = $this->states->getByCountryIdOrCode($data['item']->address->country->id);
			$cities = $this->cities->getByStateIdOrCode($data['item']->address->state->id);
		}

		if (old('address.country_id'))
		{
			$states = $this->states->getByCountryIdOrCode(old('address.country_id'));
		}

		if (old('address.state_id'))
		{
			$cities = $this->cities->getByStateIdOrCode(old('address.state_id'));
		}

		$data['countries'] = $countries;
		$data['states']    = $states;
		$data['cities']    = $cities;

		return $data;
	}

	public function validForUpdate($data, array $input)
	{
		$bindings = [
			'email' => $data->email,
		];

		return $this->validator->on('update')->bind($bindings)->validate($input);
	}

	public function setUser($model, $data, $mode)
	{
		// Todo create a new role for this type of user :)
		$input = [
			'activated'  => true,
			'first_name' => $data['name'],
			'last_name'  => $data['name'],
			'email'      => $data['email'],
			'password'   => config('mobileinn-person.password'),
			'password_confirmation' => config('mobileinn-person.password'),
		];

		$this->users->create($input);

		return $model;
	}
}
