<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();

            // Kolom Dasar
            $table->string('name', 100);
            $table->string('slug', 150)->unique();

            // Kolom category dikembalikan ke tipe STRING
            $table->string('category', 100); // Contoh: Sirup, Tablet, Kapsul

            $table->integer('price')->unsigned();
            $table->integer('stock')->default(0)->unsigned();
            $table->string('image')->nullable(); // Path gambar

            // Kolom Detail Produk
            $table->text('description');
            $table->text('full_indication');
            $table->text('usage_detail');
            $table->text('side_effects');
            $table->text('contraindications');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medicines');
    }
};
