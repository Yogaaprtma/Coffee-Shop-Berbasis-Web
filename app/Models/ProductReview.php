<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'rating',
        'comment',
        'verified_purchase',
        'helpful_count'
    ];

    protected $casts = [
        'rating' => 'integer',
        'verified_purchase' => 'boolean',
        'helpful_count' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeVerified($query)
    {
        return $query->where('verified_purchase', true);
    }

    public function scopeTopRated($query)
    {
        return $query->orderByDesc('rating')->orderByDesc('helpful_count');
    }

    // Methods
    public function isHelpful()
    {
        return $this->increment('helpful_count');
    }

    public function getAverageRatingAttribute()
    {
        return $this->rating . '.0/5.0';
    }
}
