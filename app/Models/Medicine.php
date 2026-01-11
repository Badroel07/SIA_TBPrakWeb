<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    // Menentukan nama tabel yang sesuai (drugs)
    protected $table = 'medicines';

    // Kolom yang boleh diisi (fillable)
    protected $fillable = [
        'name',
        'slug',
        'category',
        'price',
        'stock',
        'description',
        'full_indication',
        'usage_detail',
        'side_effects',
        'contraindications',
        'image',
        'total_sold'
    ];

    // Menambahkan kolom 'slug' ke fillable (diasumsikan Anda akan menambahkannya nanti untuk URL)
    // Jika Anda ingin menggunakan 'slug' seperti di view, Anda harus membuatnya di Controller.
}
