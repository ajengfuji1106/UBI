<?php

namespace Tests\Feature;

use Tests\TestCase;

use App\Models\User;
use App\Models\Rapat;
use App\Models\Notulensi;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotulensiTest extends TestCase
{


    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(\App\Http\Middleware\CheckMeetingRole::class);
    }

    public function test_user_bisa_membuat_notulensi()
    {
        $user = User::findOrFail(1);
        // dd ($user);
        $rapat = Rapat::factory()->create();

        $this->actingAs($user);

        $data = [
            'id_rapat' => $rapat->id_rapat,
            'id_user' => $user->id_user,
            'judul_notulensi' => 'Judul Test Notulensi',
            'konten_notulensi' => 'Isi konten test notulensi',
        ];

        // dd(env('DB_CONNECTION'), config('database.default'));

        $response = $this->post(route('notulensi.store'), $data);

        $response->assertStatus(302); // redirect biasanya kalau berhasil simpan
        $this->assertDatabaseHas('notulensis', ['judul_notulensi' => 'Judul Test Notulensi']);
    }

    // public function test_user_bisa_lihat_detail_notulensi()
    // {
        // $user = User::factory()->create();
        // $rapat = Rapat::factory()->create();

        // $notulensi = Notulensi::create([
            // 'id_rapat' => $rapat->id_rapat,
            // 'id_user' => $user->id_user,
            // 'judul_notulensi' => 'Judul Notulensi',
            // 'konten_notulensi' => 'Isi konten notulensi',
        // ]);

        // $this->actingAs($user);

        // $response = $this->get(route('notulensi.show', $notulensi->id_notulensi));

        // $response->assertStatus(200);
        // $response->assertSee('Judul Notulensi');
    // }

    // public function test_user_bisa_update_notulensi()
    // {
        // $user = User::factory()->create();
        // $rapat = Rapat::factory()->create();

        // $notulensi = Notulensi::create([
            // 'id_rapat' => $rapat->id_rapat,
            // 'id_user' => $user->id_user,
            // 'judul_notulensi' => 'Judul Lama',
            // 'konten_notulensi' => 'Isi lama',
        // ]);

        // $this->actingAs($user);

        // $dataUpdate = [
            // 'judul_notulensi' => 'Judul Baru',
            // 'konten_notulensi' => 'Isi baru',
        // ];

        // $response = $this->put(route('notulensi.update', $notulensi->id_notulensi), $dataUpdate);

        // $response->assertStatus(302);
        // $this->assertDatabaseHas('notulensis', ['judul_notulensi' => 'Judul Baru']);
    // }

    // public function test_user_bisa_hapus_notulensi()
    // {
        // $user = User::factory()->create();
        // $rapat = Rapat::factory()->create();

        // $notulensi = Notulensi::create([
            // 'id_rapat' => $rapat->id_rapat,
            // 'id_user' => $user->id_user,
            // 'judul_notulensi' => 'Judul Dihapus',
            // 'konten_notulensi' => 'Isi yang akan dihapus',
        // ]);

        // $this->actingAs($user);

        // $response = $this->delete(route('notulensi.destroy', $notulensi->id_notulensi));

        // $response->assertStatus(302);
        // $this->assertDatabaseMissing('notulensis', ['id_notulensi' => $notulensi->id_notulensi]);
    // }
}
