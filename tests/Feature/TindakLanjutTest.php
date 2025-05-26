<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Rapat;
use App\Models\TindakLanjut;
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

        public function test_user_bisa_mengedit_tindak_lanjut()
    {
        $user = User::factory()->create();
        $rapat = Rapat::factory()->create();
        $tindakLanjut = TindakLanjut::factory()->create(['id_rapat' => $rapat->id_rapat]);
    
        $tindakLanjut->users()->attach($user->id);
        $tindakLanjut->refresh(); // tambahkan ini
    
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
