<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'subcategory_id',
        'customer_id',
        'name',
        'image',
        'short_description',
        'cashback_percentage',
        'description',
        'is_hot',
        'status',
        'slug'
    ];

    public function productVariants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }


    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
// Tính tổng số đơn hoàn thành
public function completedOrders()
{
    return $this->productVariants()
        ->whereHas('orders', function ($query) {
            $query->where('status', 'complete');
        });
}

// Tính tổng số khiếu nại liên quan đến sản phẩm này
public function complaints()
{
    return $this->hasManyThrough(Complaint::class, ProductVariant::class, 'product_id', 'order_id', 'id', 'id');
}

// Tính tỷ lệ khiếu nại (Số khiếu nại / Tổng số đơn hoàn thành * 100)
public function complaintRate()
{
    $totalCompletedOrders = $this->completedOrders()->count();
    $totalComplaints = $this->complaints()->count();

    if ($totalCompletedOrders === 0) {
        return 0; // Tránh chia cho 0
    }

    return round(($totalComplaints / $totalCompletedOrders) * 100, 2);
}

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class);
    }
// Add this to your Product model
public function reviews()
{
    return $this->hasMany(Review::class);
}
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
    // Hàm tạo slug duy nhất
    public static function generateUniqueSlug($name, $excludeId = null)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        while (static::where('slug', $slug)
            ->when($excludeId, fn($query) => $query->where('id', '!=', $excludeId))
            ->exists()
        ) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->slug = static::generateUniqueSlug($product->name);
        });

        static::updating(function ($product) {
            if ($product->isDirty('name')) { // Chỉ cập nhật slug nếu tên thay đổi
                $product->slug = static::generateUniqueSlug($product->name, $product->id);
            }
        });
    }
}
