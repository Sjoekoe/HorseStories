<?php
namespace HorseStories\Http\Controllers\Horses;

use Auth;
use DB;
use Flash;
use HorseStories\Core\Files\Uploader;
use HorseStories\Http\Requests\CreateHorse;
use HorseStories\Http\Requests\UpdateHorse;
use HorseStories\Models\Horses\Horse;
use HorseStories\Models\Horses\HorseCreator;
use HorseStories\Models\Horses\HorseRepository;
use HorseStories\Models\Horses\HorseUpdater;
use HorseStories\Models\Users\User;
use Illuminate\Routing\Controller;
use Request;

class HorseController extends Controller
{
    /**
     * @var \HorseStories\Models\Horses\HorseCreator
     */
    private $horseCreator;

    /**
     * @var \HorseStories\Core\Files\Uploader
     */
    private $uploader;

    /**
     * @var \HorseStories\Models\Horses\HorseUpdater
     */
    private $horseUpdater;

    /**
     * @var \HorseStories\Models\Horses\HorseRepository
     */
    private $horses;

    /**
     * @param \HorseStories\Models\Horses\HorseCreator $horseCreator
     * @param \HorseStories\Core\Files\Uploader $uploader
     * @param \HorseStories\Models\Horses\HorseUpdater $horseUpdater
     * @param \HorseStories\Models\Horses\HorseRepository $horses
     */
    public function __construct(HorseCreator $horseCreator, Uploader $uploader, HorseUpdater $horseUpdater, HorseRepository $horses)
    {
        $this->horseCreator = $horseCreator;
        $this->uploader = $uploader;
        $this->horseUpdater = $horseUpdater;
        $this->horses = $horses;
    }

    /**
     * @param int $userId
     * @return \Illuminate\View\View
     */
    public function index($userId)
    {
        $user = User::with('horses')->where('id', $userId)->firstOrFail();

        return view('horses.index', compact('user'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('horses.create');
    }

    /**
     * @param \HorseStories\Http\Requests\CreateHorse $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateHorse $request)
    {
        $horse = $this->horseCreator->create(Auth::user(), $request->all());

        if (Request::hasFile('profile_pic')) {
            $this->uploader->uploadPicture(Request::file('profile_pic'), $horse, true);
        }

        Flash::success($horse->name . ' was successfully created.');

        return redirect()->route('horses.index', Auth::user()->id);
    }

    /**
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        $horse = Horse::where('slug', '=', $slug)->with('statuses')->firstOrFail();

        $likes = DB::table('likes')->whereUserId(Auth::user()->id)->lists('status_id');

        return view('horses.show', compact('horse', 'likes'));
    }

    /**
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function edit($slug)
    {
        $horse = $this->initHorse($slug);

        return view('horses.edit', compact('horse'));
    }

    /**
     * @param string $slug
     * @param \HorseStories\Http\Requests\UpdateHorse $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($slug, UpdateHorse $request)
    {
        $horse = $this->initHorse($slug);

        $this->horseUpdater->update($horse, $request->all());

        Flash::success($horse->name . ' was updated');

        return redirect()->route('horses.show', $horse->slug);
    }

    /**
     * @param int $horseId
     * @return \HorseStories\Models\Horses\Horse
     */
    private function initHorse($horseId)
    {
        $horse = $this->horses->findBySlug($horseId);

        if ($horse->owner()->first()->id !== Auth::user()->id) {
            abort(403);
        }

        return $horse;
    }
}
