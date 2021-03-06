<?php
namespace Controllers\Horses;

use Carbon\Carbon;
use DB;
use EQM\Models\Horses\Horse;
use EQM\Models\HorseTeams\HorseTeam;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class HorsesTest extends \TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /** @test */
    function it_can_create_a_horse()
    {
        $user = $this->createUser();

        $this->actingAs($user)
            ->post('/horses/create', [
                'name' => 'Foo horse',
                'gender' => 1,
                'color' => 1,
                'date_of_birth' => '08/06/1982',
                'height' => 5,
                'breed' => 1,
                'life_number' => '1234'
            ]);

        $this->assertRedirectedTo('/');
        $this->seeInDatabase('horses', [
                'id' => DB::table(Horse::TABLE)->first()->id,
                'name' => 'Foo horse',
                'life_number' => '1234',
                'date_of_birth' => '1982-06-08 00:00:00',
                'height' => 5,
                'breed' => 1,
                'gender' => 1,
                'color' => 1
            ]);

        $this->seeInDatabase('horse_team', [
            'id' => DB::table(HorseTeam::TABLE)->first()->id,
            'user_id' => $user->id(),
            'horse_id' => DB::table(Horse::TABLE)->first()->id,
            'type' => 1,
        ]);
    }

    /** @test */
    function it_can_edit_a_horse()
    {
        $now = Carbon::createFromDate(2000, 10, 5)->startOfDay();

        $user = $this->createUser();
        $horse = $this->createHorse();
        $this->createHorseTeam([
            'user_id' => $user->id,
            'horse_id' => $horse->id(),
        ]);

        $this->actingAs($user)
            ->put('/horses/edit/' . $horse->slug(), [
                'name' => 'Foo horse',
                'gender' => 1,
                'color' => 1,
                'date_of_birth' => $now->format('d/m/Y'),
                'height' => 5,
                'breed' => 1,
                'life_number' => '1234'
            ]);

        $this->assertRedirectedTo('/horses/edit/' . $horse->slug());
        $this->seeInDatabase('horses', [
            'id' => $horse->id(),
            'name' => 'Foo horse',
            'life_number' => '1234',
            'date_of_birth' => $now->toIso8601String(),
            'height' => 5,
            'breed' => 1,
            'gender' => 1,
            'color' => 1
        ]);
    }
}
