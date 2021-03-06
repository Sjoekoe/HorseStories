<?php
namespace EQM\Models\HorseTeams;

interface HorseTeam
{
    const TABLE = 'horse_team';
    const OWNER = 1;
    const RIDER = 2;
    const GROOM = 3;
    const TRAINER = 4;

    /**
     * @return int
     */
    public function id();

    /**
     * @return \EQM\Models\Users\User
     */
    public function user();

    /**
     * @return \EQM\Models\Horses\Horse
     */
    public function horse();

    /**
     * @return int
     */
    public function type();

    /**
     * @return \Carbon\Carbon
     */
    public function createdAt();

    /**
     * @return \Carbon\Carbon
     */
    public function updatedAt();
}
