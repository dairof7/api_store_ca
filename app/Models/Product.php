<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Product Model
 *
 * This class represents the 'Product' model which is associated with the 'products' table.
 * It is used to interact with product data in the database using Eloquent ORM.
 */
class Product extends Model
{
    use HasFactory;

    // Define which attributes can be mass-assigned
    protected $fillable = ['name', 'description', 'price', 'category'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
}
