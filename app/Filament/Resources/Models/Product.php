<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'sku',
        'price',
        'stock',
        'description',
        'status',
        'company_id',
        'category_id',
        'tax_id',
        'supplier_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'price' => 'decimal:2',
        'stock' => 'integer',
        'company_id' => 'integer',
        'category_id' => 'integer',
        'tax_id' => 'integer',
        'supplier_id' => 'integer',
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }
    public function tax(): BelongsTo
    {
        return $this->belongsTo(Tax::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function salesOrders(): BelongsToMany
    {
        return $this->belongsToMany(SalesOrder::class);
    }

    public function customers(): BelongsToMany
    {
        return $this->belongsToMany(Customer::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}
