<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Rapat;
use App\Models\Dokumentasi;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DokumentasiTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
    parent::setUp();

    $this->withoutMiddleware();
    }

        public function test_user_can_create_dokumentasi()
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $rapat = Rapat::factory()->create();

        $this->actingAs($user);

        $response = $this->post(route('dokumentasi.store'), [
            'id_rapat' => $rapat->id_rapat,
            'judul_dokumentasi' => 'Test Dokumentasi',
            'deskripsi' => 'Ini deskripsi test',
            'file_path' => [UploadedFile::fake()->image('test.jpg')],
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('dokumentasis', [
            'id_rapat' => $rapat->id_rapat,
            'judul_dokumentasi' => 'Test Dokumentasi',
        ]);

        $dok = Dokumentasi::latest()->first();
        $file = $dok->files->first(); 
        Storage::disk('public')->assertExists($file->file_path);
    }

    public function test_user_can_update_dokumentasi()
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $this->actingAs($user);

        $dok = Dokumentasi::factory()
            ->hasFiles(1)
            ->create([
                'judul_dokumentasi' => 'Old Title',
            ]);

        $response = $this->put(route('dokumentasi.update', $dok->id_dokumentasi), [
            'judul_dokumentasi' => 'Updated Title',
            'deskripsi' => 'Deskripsi baru',
            'file_path' => [UploadedFile::fake()->image('new.jpg')],
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('dokumentasis', [
            'id_dokumentasi' => $dok->id_dokumentasi,
            'judul_dokumentasi' => 'Updated Title',
        ]);
    }

    public function test_user_can_delete_dokumentasi()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $dok = Dokumentasi::factory()->create();

        $response = $this->delete(route('dokumentasi.destroy', $dok->id_dokumentasi));

        $response->assertRedirect();
        $this->assertDatabaseMissing('dokumentasis', [
            'id_dokumentasi' => $dok->id_dokumentasi,
        ]);
    }
}
