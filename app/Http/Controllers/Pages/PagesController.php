<?php
namespace EQM\Http\Controllers\Pages;

use DB;
use EQM\Http\Controllers\Controller;
use EQM\Models\Horses\HorseRepository;
use EQM\Models\HorseTeams\HorseTeamRepository;
use EQM\Models\Statuses\StatusRepository;

class PagesController extends Controller
{
    /**
     * @var \EQM\Models\Statuses\StatusRepository
     */
    private $statuses;

    /**
     * @var \EQM\Models\HorseTeams\HorseTeamRepository
     */
    private $horseTeams;
    /**
     * @var \EQM\Models\Horses\HorseRepository
     */
    private $horses;

    /**
     * @param \EQM\Models\Statuses\StatusRepository $statuses
     * @param \EQM\Models\HorseTeams\HorseTeamRepository $horseTeams
     * @param \EQM\Models\Horses\HorseRepository $horses
     */
    public function __construct(StatusRepository $statuses, HorseTeamRepository $horseTeams, HorseRepository $horses)
    {
        $this->statuses = $statuses;
        $this->horseTeams = $horseTeams;
        $this->horses = $horses;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function home()
    {
        if (auth()->check()) {
            $horses = $this->horses->findForUser(auth()->user());
            if (count($horses)) {
                $statuses = $this->statuses->findFeedForUser(auth()->user());
                $likes = DB::table('likes')->whereUserId(auth()->user()->id)->lists('status_id');
            } else {
                $statuses = [];
            }
        }

        return view('pages.home', compact('horses', 'statuses', 'likes'));
    }
}
