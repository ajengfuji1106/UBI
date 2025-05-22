<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Rapat;
use App\Models\Undangan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class UndanganTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function user_bisa_membuat_undangan_baru()
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('undangan.store'), [
            'judul_rapat' => 'Rapat Penting',
            'tanggal_rapat' => '2025-05-30',
            'waktu_rapat' => '09:00',
            'lokasi_rapat' => 'Ruang Rapat',
            'kategori_rapat' => 'Internal',
            'file_undangan' => UploadedFile::fake()->create('file.docx', 200),
        ]);

        // dd(config('database.default'));


        $response->assertRedirect(route('kelolarapat'));
        $this->assertDatabaseCount('rapats', 1);
        $this->assertDatabaseCount('undangans', 1);

        Storage::disk('public')->assertExists(Undangan::first()->file_undangan);
    }

    #[Test]
    public function user_bisa_mengedit_undangan()
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $this->actingAs($user);

        $rapat = Rapat::factory()->create(['id_user' => $user->id]);
        $undangan = Undangan::create([
            'id_rapat' => $rapat->id_rapat,
            'file_undangan' => 'undangan/file_lama.pdf',
        ]);

        $response = $this->put(route('undangan.update', $undangan->id_undangan), [
            'judul_rapat' => 'Rapat Diubah',
            'tanggal_rapat' => '2025-06-01',
            'waktu_rapat' => '13:00',
            'lokasi_rapat' => 'Ruang 2',
            'kategori_rapat' => 'Eksternal',
            'file_undangan' => UploadedFile::fake()->create('file_baru.doc', 200),
        ]);

        $response->assertRedirect(route('kelolarapat'));
        $this->assertEquals('Rapat Diubah', Rapat::first()->judul_rapat);
        Storage::disk('public')->assertExists(Undangan::first()->file_undangan);
    }

    #[Test]
    public function user_bisa_menghapus_undangan()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $rapat = Rapat::factory()->create(['id_user' => $user->id]);
        $response = $this->delete(route('rapat.delete', $rapat->id_rapat));

        $response->assertRedirect();
        $this->assertDatabaseMissing('rapats', ['id_rapat' => $rapat->id_rapat]);
    }
}
