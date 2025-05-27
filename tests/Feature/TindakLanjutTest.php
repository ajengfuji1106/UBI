<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Rapat;
use App\Models\TindakLanjut;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TindakLanjutTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
    parent::setUp();
    $this->withoutMiddleware();
    }

    public function test_user_bisa_membuat_tindak_lanjut()
    {
        $user = User::factory()->create();
        $rapat = Rapat::factory()->create();

        $this->actingAs($user);

        $response = $this->post(route('tindaklanjut.store'), [
            'id_rapat' => $rapat->id_rapat,
            'judul_tugas' => 'Judul Tugas Test',
            'deadline_tugas' => now()->addDays(7)->toDateString(),
            'deskripsi_tugas' => 'Deskripsi Tugas Test',
            'id_user' => [$user->id],
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('tindak_lanjuts', [
            'judul_tugas' => 'Judul Tugas Test',
            'deskripsi_tugas' => 'Deskripsi Tugas Test',
        ]);

        $this->assertDatabaseHas('tindak_lanjut_user', [
            'id_user' => $user->id,
        ]);
    }

        public function test_user_gagal_membuat_tindak_lanjut_jika_ada_field_kosong()
    {
        $user = \App\Models\User::factory()->create();
        $rapat = \App\Models\Rapat::factory()->create();

        $this->actingAs($user);

        $response = $this->post(route('tindaklanjut.store'), [
            'id_rapat' => $rapat->id_rapat,
            'judul_tugas' => '',
            'deadline_tugas' => now()->addDays(5)->toDateString(),
            'deskripsi_tugas' => 'Deskripsi tugas valid',
            'id_user' => [$user->id],
        ]);

        $response->assertSessionHasErrors(['judul_tugas']);
        $this->assertDatabaseMissing('tindak_lanjuts', ['deskripsi_tugas' => 'Deskripsi tugas valid']);
    }

        public function test_user_gagal_upload_file_tindak_lanjut_jika_ukuran_lebih_dari_50mb()
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $rapat = Rapat::factory()->create();

        $this->actingAs($user);

        // Buat file palsu berukuran 51MB (52000 KB)
        $fileBesar = UploadedFile::fake()->create('lampiran_besar.pdf', 52000);

        $response = $this->post(route('tindaklanjut.store'), [
            'id_rapat' => $rapat->id_rapat,
            'judul_tugas' => 'Tugas dengan file besar',
            'deadline_tugas' => now()->addDays(7)->toDateString(),
            'deskripsi_tugas' => 'Ada file terlalu besar',
            'id_user' => [$user->id],
            'file_path' => $fileBesar,
        ]);

        $response->assertSessionHasErrors(['file_path']);
        $this->assertDatabaseMissing('tindak_lanjuts', [
            'judul_tugas' => 'Tugas dengan file besar',
        ]);
    }

    public function test_user_gagal_upload_file_tindak_lanjut_jika_format_tidak_valid()
    {
        $user = \App\Models\User::factory()->create();
        $rapat = \App\Models\Rapat::factory()->create();
        $this->actingAs($user);
    
        // Bikin file fake dengan format JPG (yang tidak diizinkan)
        $fileInvalid = \Illuminate\Http\UploadedFile::fake()->create('gambar.jpg', 1000, 'image/jpeg');
    
        $response = $this->post(route('tindaklanjut.store'), [
            'id_rapat' => $rapat->id_rapat,
            'judul_tugas' => 'Tugas dengan file tidak valid',
            'deadline_tugas' => now()->addDays(5)->toDateString(),
            'deskripsi_tugas' => 'Deskripsi tugas',
            'id_user' => [$user->id],
            'file_path' => $fileInvalid,
        ]);
    
        $response->assertSessionHasErrors(['file_path']);
        $this->assertDatabaseMissing('tindak_lanjuts', [
            'judul_tugas' => 'Tugas dengan file tidak valid',
        ]);
    }
    
        public function test_user_bisa_mengedit_tindak_lanjut()
    {
        $user = User::factory()->create();
        $rapat = Rapat::factory()->create();
        $tindakLanjut = TindakLanjut::factory()->create(['id_rapat' => $rapat->id_rapat]);
    
        $tindakLanjut->users()->attach($user->id);
        $tindakLanjut->refresh(); 
    
        $this->actingAs($user);
    
        $response = $this->put(route('tindaklanjut.update', $tindakLanjut->id_tindaklanjut), [
            'judul_tugas' => 'Updated Judul',
            'deadline_tugas' => now()->addDays(10)->toDateString(),
            'deskripsi_tugas' => 'Updated Deskripsi',
            'id_user' => [$user->id],
        ]);
    
        $response->assertRedirect();
    
        $this->assertDatabaseHas('tindak_lanjuts', [
            'id_tindaklanjut' => $tindakLanjut->id_tindaklanjut,
            'judul_tugas' => 'Updated Judul',
        ]);
    }
    
        public function test_user_bisa_hapus_tindak_lanjut()
    {
        $user = User::factory()->create();
        $rapat = Rapat::factory()->create();
        $tindakLanjut = TindakLanjut::factory()->create(['id_rapat' => $rapat->id_rapat]);
    
    
        $tindakLanjut->users()->attach($user->id);
        $tindakLanjut->refresh(); 
    
        $this->actingAs($user);
    
        $response = $this->delete(route('tindaklanjut.destroy', $tindakLanjut->id_tindaklanjut));
    
        $response->assertRedirect();
    
        $this->assertDatabaseMissing('tindak_lanjuts', [
            'id_tindaklanjut' => $tindakLanjut->id_tindaklanjut,
        ]);
    }
    
}
