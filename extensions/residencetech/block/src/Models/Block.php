<?php namespace Residencetech\Block\Models;

use Cartalyst\Attributes\EntityInterface;
use Illuminate\Database\Eloquent\Model;
use Platform\Attributes\Traits\EntityTrait;
use Cartalyst\Support\Traits\NamespacedEntityTrait;

class Block extends Model implements EntityInterface {

	use EntityTrait, NamespacedEntityTrait;

	protected $table = 'blocks';

	protected $guarded = [
		'id',
	];

	protected static $entityNamespace = 'residencetech/block.block';

	public function apartmentComplex()
	{
		return $this->belongsTo('Residencetech\Apartmenttype\Models\Apartmentcomplex', 'apartment_complex_id', 'id');
	}
}
