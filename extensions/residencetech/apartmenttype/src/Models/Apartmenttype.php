<?php namespace Residencetech\Apartmenttype\Models;

use Cartalyst\Attributes\EntityInterface;
use Illuminate\Database\Eloquent\Model;
use Platform\Attributes\Traits\EntityTrait;
use Cartalyst\Support\Traits\NamespacedEntityTrait;

class Apartmenttype extends Model implements EntityInterface {

	use EntityTrait, NamespacedEntityTrait;

	protected $table = 'apartmenttypes';

	protected $guarded = [
		'id',
	];

	protected static $entityNamespace = 'residencetech/apartmenttype.apartmenttype';

}
