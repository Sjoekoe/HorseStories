<?php
namespace EQM\Http\Controllers\Auth;

use EQM\Http\Controllers\Controller;
use EQM\Models\Users\UserCreator;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Validator;

class AuthController extends Controller {

	use AuthenticatesAndRegistersUsers;

    /**
     * @var string
     */
    public $redirectTo = '/';

    /**
     * @var string
     */
    public $loginPath = '/login';

    /**
     * @var \EQM\Models\Users\UserCreator
     */
    private $userCreator;

    /**
     * @param \EQM\Models\Users\UserCreator $userCreator
     */
    public function __construct(UserCreator $userCreator)
    {
        $this->middleware('guest', ['except' => 'getLogout']);
        $this->userCreator = $userCreator;
    }

    /**
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * @param  array $data
     * @return \EQM\Models\Users\EloquentUser
     */
    public function create(array $data)
    {
        $user = $this->userCreator->create($data);

        return $user;
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            $this->loginUsername() => 'required', 'password' => 'required',
        ]);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        if (auth()->attempt(['email' => $request->email, 'password' => $request->password, 'activated' => true], $request->has('remember'))) {
            return $this->handleUserWasAuthenticated($request, $throttles);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles) {
            $this->incrementLoginAttempts($request);
        }

        return redirect($this->loginPath())
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => $this->getFailedLoginMessage(),
            ]);
    }

    /**
     * Get the failed login message.
     *
     * @return string
     */
    protected function getFailedLoginMessage()
    {
        return trans()->has('auth.failed')
            ? trans('auth.failed')
            : 'These credentials do not match our records, or your account has not been activated.';
    }
}
