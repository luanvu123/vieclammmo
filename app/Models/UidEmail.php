<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UidEmail extends Model
{
    use HasFactory;

    protected $fillable = ['stock_id', 'email', 'value', 'status'];

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}

