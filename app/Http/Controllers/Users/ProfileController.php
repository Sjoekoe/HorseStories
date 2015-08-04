<?php
namespace EQM\Http\Controllers\Users;

use Auth;
use EQM\Http\Controllers\Controller;
use EQM\Http\Requests\UpdateUserProfile;
use EQM\Models\Users\UserRepository;
use Session;

class ProfileController extends  Controller
{
    /**
     * @var \EQM\Models\Users\UserRepository
     */
    private $users;

    /**
     * @param \EQM\Models\Users\UserRepository $users
     */
    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('users.profiles.edit');
    }

    /**
     * @param \EQM\Http\Requests\UpdateUserProfile $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateUserProfile $request)
    {
        $user = $this->users->findById(Auth::user()->id);

        $user->update($request->all());

        Session::put('success', 'Profile was updated');

        return back();
    }

    /**
     * @param int $userId
     * @return \Illuminate\View\View
     */
    public function show($userId)
    {
        $user = $this->users->findById($userId);

        return view('users.profiles.show', compact('user'));
    }
}
