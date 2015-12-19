<?php
namespace EQM\Http\Controllers\Horses;

use Carbon\Carbon;
use EQM\Http\Controllers\Controller;
use EQM\Models\Horses\Horse;
use EQM\Models\Horses\HorseRepository;
use EQM\Models\Pedigrees\Pedigree;
use EQM\Models\Pedigrees\PedigreeCreator;
use EQM\Models\Pedigrees\PedigreeRepository;
use EQM\Models\Pedigrees\Requests\CreateFamilyMember;
use Illuminate\Http\Request;

class PedigreeController extends Controller
{
    /**
     * @var \EQM\Models\Pedigrees\PedigreeCreator
     */
    private $pedigreeCreator;

    /**
     * @var \EQM\Models\Pedigrees\PedigreeRepository
     */
    private $pedigrees;

    /**
     * @var \EQM\Models\Horses\HorseRepository
     */
    private $horses;

    public function __construct(
        PedigreeCreator $pedigreeCreator,
        PedigreeRepository $pedigrees,
        HorseRepository $horses
    ) {
        $this->pedigreeCreator = $pedigreeCreator;
        $this->pedigrees = $pedigrees;
        $this->horses = $horses;
    }

    public function index(Horse $horse)
    {
        return view('horses.pedigree.index', compact('horse'));
    }

    public function create(Horse $horse)
    {
        $this->authorize('create-pedigree', $horse);

        return view('horses.pedigree.create', compact('horse'));
    }

    public function store(CreateFamilyMember $request, Horse $horse)
    {
        $this->authorize('create-pedigree', $horse);

        if ($this->alReadyHasSpecificFamilyConnection($horse, $request)) {
            return back();
        }

        if ($request->has('life_number')) {
            if ($this->isIncorrectGender($request->get('life_number'), $request->get('type'))) {
                return back();
            }
        }

        if ($this->hasIncorrectAges($horse, $request)) {
            return back();
        }

        $this->pedigreeCreator->create($horse, $request->all());

        return redirect()->route('pedigree.index', $horse->slug);
    }

    public function delete(Pedigree $pedigree)
    {
        $horse = $pedigree->horse();

        $this->authorize('delete-pedigree', $horse);

        $this->pedigrees->delete($pedigree);

        return redirect()->route('pedigree.index', $horse->slug());
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    private function alReadyHasSpecificFamilyConnection(Horse $horse, Request $request)
    {
        $type = $request->get('type');
        $message = '';

        if ($type == Pedigree::FATHER && $horse->hasFather()) {
            $message = $horse->name() . ' already has a father defined.';
        }

        if ($type == Pedigree::MOTHER && $horse->hasMother()) {
            $message = $horse->name() . ' already has a mother defined.';
        }

        if ($message !== '') {
            session()->put('error', $message);

            return true;
        }

        return false;
    }

    /**
     * @param string $lifeNumber
     * @param int $type
     * @return bool
     */
    private function isIncorrectGender($lifeNumber, $type)
    {
        if ($this->horses->findByLifeNumber($lifeNumber) !== null) {
            $horse = $this->horses->findByLifeNumber($lifeNumber);
            if (($type == Pedigree::MOTHER || $type == Pedigree::DAUGHTER) && ! $horse->isFemale()) {
                session()->put('error', 'The family you wanted to enter is not female in our records');

                return true;
            }

            if (($type == Pedigree::FATHER || Pedigree::SON) && $horse->isFemale()) {
                session()->put('error', 'The family you wanted to enter is not a male in our records');

                return true;
            }
        }

        return false;
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    private function hasIncorrectAges(Horse $horse, Request $request)
    {
        $dateOfBirth = null;

        if ($request->has('life_number')) {
            if ($this->horses->findByLifeNumber($request->get('life_number')) !== null) {
                $relative = $this->horses->findByLifeNumber($request->get('life_number'));
                $dateOfBirth = $relative->dateOfBirth();
            }
        }

        if (! $dateOfBirth && $request->has('date_of_birth')) {
            $dateOfBirth = Carbon::createFromFormat('d/m/Y', $request->get('date_of_birth'));
        }

        if ($dateOfBirth) {
            return $this->ageDifference($horse, $request, $dateOfBirth);
        }

        return false;
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param \Illuminate\Http\Request $request
     * @param \DateTime $dateOfBirth
     * @return bool
     */
    private function ageDifference(Horse $horse, Request $request, $dateOfBirth)
    {
        return ($request->get('type') == Pedigree::DAUGHTER) || ($request->get('type') == Pedigree::SON)
            ? $dateOfBirth > $horse->dateOfBirth()
            : $dateOfBirth < $horse->dateOfBirth();
    }
}
