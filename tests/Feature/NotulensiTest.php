<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Rapat;
use App\Models\Notulensi;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NotulensiTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(\App\Http\Middleware\CheckMeetingRole::class);
    }

    public function test_user_bisa_membuat_notulensi()
    {
        $user = User::factory()->create();
        $rapat = Rapat::factory()->create();

        $this->actingAs($user);

        $data = [
            'id_rapat' => $rapat->id_rapat,
            'id_user' => $user->id,
            'judul_notulensi' => 'Judul Test Notulensi',
            'konten_notulensi' => 'Isi konten test notulensi',
        ];

        $response = $this->post(route('notulensi.store'), $data);

        $response->assertStatus(302); // redirect setelah simpan
        $this->assertDatabaseHas('notulensis', ['judul_notulensi' => 'Judul Test Notulensi']);
    }

    public function test_user_bisa_update_notulensi()
    {
        $user = User::factory()->create();
        $rapat = Rapat::factory()->create();

        $notulensi = Notulensi::create([
            'id_rapat' => $rapat->id_rapat,
           'id_user' => $user->id,
            'judul_notulensi' => 'Judul Lama',
            'konten_notulensi' => 'Isi lama',
        ]);

        $this->actingAs($user);

        $dataUpdate = [
            'judul_notulensi' => 'Judul Baru',
            'konten_notulensi' => 'Isi baru',
            'id_user' => $user->id,
            'id_rapat' => $rapat->id_rapat, 
        ];

        $response = $this->put(route('notulensi.update', $notulensi->id_notulensi), $dataUpdate);

        $response->assertStatus(302);
        $this->assertDatabaseHas('notulensis', ['judul_notulensi' => 'Judul Baru']);
    }

    public function test_user_bisa_hapus_notulensi()
    {
        $user = User::factory()->create();
        $rapat = Rapat::factory()->create();

        $notulensi = Notulensi::create([
            'id_rapat' => $rapat->id_rapat,
            'id_user' => $user->id,
            'judul_notulensi' => 'Judul Dihapus',
            'konten_notulensi' => 'Isi yang akan dihapus',
        ]);

        $this->actingAs($user);

        $response = $this->delete(route('notulensi.destroy', $notulensi->id_notulensi));

        $response->assertStatus(302);
        $this->assertDatabaseMissing('notulensis', ['id_notulensi' => $notulensi->id_notulensi]);
    }
}
