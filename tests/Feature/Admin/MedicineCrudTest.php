<?php

namespace Tests\Feature\Admin;

use App\Models\Medicine;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MedicineCrudTest extends TestCase
{
    use RefreshDatabase;

    private $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['role' => 'admin']);
    }

    public function test_admin_can_view_medicine_list()
    {
        Medicine::factory()->count(3)->create();

        $response = $this->actingAs($this->admin)->get(route('admin.medicines.index'));

        $response->assertStatus(200);
        $response->assertViewHas('medicines');
    }

    public function test_admin_can_create_medicine()
    {
        Storage::fake('public');

        $medicineData = [
            'name' => 'Paracetamol',
            'category' => 'Obat Sakit Kepala',
            'stock' => 100,
            'price' => 5000,
            'description' => 'Obat untuk sakit kepala',
            'full_indication' => 'Indikasi lengkap...',
            'usage_detail' => 'Detail penggunaan...',
            'side_effects' => 'Efek samping...',
            'contraindications' => 'Kontraindikasi...',
            'image' => UploadedFile::fake()->create('medicine.jpg', 100) // Use create() to avoid GD requirement
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.medicines.store'), $medicineData);

        // Check for validation errors if it fails validation
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('admin.medicines.index'));
        $this->assertDatabaseHas('medicines', ['name' => 'Paracetamol']);
    }

    public function test_admin_can_update_medicine()
    {
        $medicine = Medicine::factory()->create();

        $updateData = [
            'name' => 'Updated Medicine',
            'category' => $medicine->category,
            'stock' => 50,
            'price' => 10000,
            'description' => 'Updated description',
            'full_indication' => 'Updated Indikasi',
            'usage_detail' => 'Updated Usage',
            'side_effects' => 'Updated Side Effects',
            'contraindications' => 'Updated Contraindications',
        ];

        $response = $this->actingAs($this->admin)->put(route('admin.medicines.update', $medicine->id), $updateData);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('admin.medicines.index'));
        $this->assertDatabaseHas('medicines', ['id' => $medicine->id, 'name' => 'Updated Medicine']);
    }

    public function test_admin_can_delete_medicine()
    {
        $medicine = Medicine::factory()->create();

        $response = $this->actingAs($this->admin)->delete(route('admin.medicines.destroy', $medicine->id));

        $response->assertStatus(302); // Redirect back
        $this->assertDatabaseMissing('medicines', ['id' => $medicine->id]);
    }
}
