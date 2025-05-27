<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Rapat;
use App\Models\Undangan;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class UndanganTest extends TestCase
{

    use DatabaseTransactions;

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

        $response->assertRedirect(route('kelolarapat'));
        $this->assertDatabaseHas('rapats', [
        'judul_rapat' => 'Rapat Penting',
        ]);

        // Ambil id rapat yang baru saja dibuat
        $rapat = Rapat::where('judul_rapat', 'Rapat Penting')->first();

        // Pastikan data undangan masuk
        $this->assertDatabaseHas('undangans', [
            'id_rapat' => $rapat->id_rapat,
        ]);

        // Ambil undangan yang baru dibuat berdasarkan id rapat
        $undangan = Undangan::where('id_rapat', $rapat->id_rapat)->first();

        // Pastikan file undangan tersimpan
        Storage::disk('public')->assertExists($undangan->file_undangan);
    }

    #[Test]
    public function user_gagal_membuat_undangan_jika_ada_field_kosong()
    {
        Storage::fake('public');
        
        $user = User::factory()->create();
        $this->actingAs($user);

        // Coba buat undangan dengan field 'judul_rapat' kosong
        $response = $this->post(route('undangan.store'), [
            'judul_rapat' => '',  // Kosongkan judul_rapat
            'tanggal_rapat' => '2025-06-01',
            'waktu_rapat' => '10:00',
            'lokasi_rapat' => 'Ruang A',
            'kategori_rapat' => 'Eksternal',
            'file_undangan' => UploadedFile::fake()->create('file_valid.pdf', 100),
        ]);

        // Pastikan ada error untuk field 'judul_rapat'
        $response->assertSessionHasErrors(['judul_rapat']);
        
        // Pastikan data undangan tidak masuk ke database
        $this->assertDatabaseMissing('rapats', [
            'judul_rapat' => '',
        ]);
    }

    #[Test]
    public function user_gagal_upload_file_undangan_jika_ukuran_lebih_dari_5mb()
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $this->actingAs($user);

        // Buat file palsu berukuran 6000 KB (lebih dari 5MB = 5120 KB)
        $fileTerlaluBesar = UploadedFile::fake()->create('file_besar.pdf', 6000);

        $response = $this->post(route('undangan.store'), [
            'judul_rapat' => 'Rapat Dengan File Besar',
            'tanggal_rapat' => '2025-06-15',
            'waktu_rapat' => '14:00',
            'lokasi_rapat' => 'Ruang Besar',
            'kategori_rapat' => 'Internal',
            'file_undangan' => $fileTerlaluBesar,
        ]);

        $response->assertSessionHasErrors(['file_undangan']);
        $this->assertDatabaseMissing('rapats', [
            'judul_rapat' => 'Rapat Dengan File Besar',
        ]);
    }

        #[Test]
    public function user_gagal_upload_undangan_jika_format_file_tidak_sesuai()
    {
        Storage::fake('public');
        
        $user = User::factory()->create();
        $this->actingAs($user);

        // Buat file palsu dengan format yang bukan PDF (misalnya .jpg)
        $fileInvalid = UploadedFile::fake()->create('file_invalid.jpg', 1000);

        $response = $this->post(route('undangan.store'), [
            'judul_rapat' => 'Rapat Dengan File Format Invalid',
            'tanggal_rapat' => '2025-06-01',
            'waktu_rapat' => '10:00',
            'lokasi_rapat' => 'Ruang A',
            'kategori_rapat' => 'Eksternal',
            'file_undangan' => $fileInvalid,
        ]);

        // Pastikan ada error untuk file_undangan
        $response->assertSessionHasErrors(['file_undangan']);

        // Pastikan data tidak masuk ke database
        $this->assertDatabaseMissing('rapats', [
            'judul_rapat' => 'Rapat Dengan File Format Invalid',
        ]);
    }

    #[Test]
    public function user_bisa_mengedit_undangan()
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $this->actingAs($user);

        // Simpan file lama dulu
        $fileLama = UploadedFile::fake()->create('file_lama.pdf', 100);
        $pathLama = $fileLama->store('undangan', 'public');

        $rapat = Rapat::factory()->create(['id_user' => $user->id]); // Pastikan id_user ada
        $undangan = Undangan::create([
            'id_rapat' => $rapat->id_rapat,
            'file_undangan' => $pathLama,
        ]);

        Storage::disk('public')->assertExists($pathLama);

        // File baru
        $fileBaru = UploadedFile::fake()->create('file_baru.doc', 200);
        $pathBaru = $fileBaru->store('undangan', 'public');

        $response = $this->put(route('undangan.update', $undangan->id_undangan), [
            'judul_rapat' => 'Rapat Diubah',
            'tanggal_rapat' => '2025-06-01',
            'waktu_rapat' => '13:00',
            'lokasi_rapat' => 'Ruang 2',
            'kategori_rapat' => 'Eksternal',
            'file_undangan' => $fileBaru,
        ]);

        $response->assertRedirect(route('kelolarapat'));

        // Ambil ulang data undangan dari database
        $undanganBaru = Undangan::find($undangan->id_undangan);

        // Pastikan file baru ada, file lama hilang
        Storage::disk('public')->assertExists($undanganBaru->file_undangan);
        Storage::disk('public')->assertMissing($pathLama);

        // Pastikan judul rapat sudah diupdate
        $this->assertEquals('Rapat Diubah', $rapat->fresh()->judul_rapat);
    }

    #[Test]
    public function user_bisa_menghapus_undangan()
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $this->actingAs($user);

        $rapat = Rapat::factory()->create(['id_user' => $user->id]);

        // $rapat = Rapat::factory()->create(['id_user' => $user->id_user]);
        $response = $this->delete(route('rapat.delete', $rapat->id_rapat));

        $response->assertRedirect();
        $this->assertDatabaseMissing('rapats', ['id_rapat' => $rapat->id_rapat]);
    }
}
