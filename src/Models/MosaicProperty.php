<?php
/**
 * Part of the evias/nem-php package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under MIT License.
 *
 * This source file is subject to the MIT License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    evias/nem-php
 * @version    1.0.0
 * @author     Grégory Saive <greg@evias.be>
 * @author     Robin Pedersen (https://github.com/RobertoSnap)
 * @license    MIT License
 * @copyright  (c) 2017, Grégory Saive <greg@evias.be>
 * @link       http://github.com/evias/nem-php
 */
namespace NEM\Models;

class MosaicProperty
    extends Model
{
    /**
     * List of fillable attributes
     *
     * @var array
     */
    protected $fillable = [
        "name",
        "value"
    ];

    /**
     * Address DTO automatically cleans address representation.
     *
     * @return  array       Associative array with key `address` containing a NIS *compliable* address representation.
     */
    public function toDTO($filterByKey = null)
    {
        return [
            "name" => $this->name,
            "value" => $this->value,
        ];
    }
}
