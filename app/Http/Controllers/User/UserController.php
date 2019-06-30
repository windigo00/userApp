<?php
namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Controller;
use App\User;

/**
 * User actions
 */
class UserController extends Controller
{

    /**
     * Login input validation rules
     * @var array
     */
    protected $loginValidation = [
        'email'     => 'required|string',
        'password'  => 'required|string',
    ];
    /**
     * Registration input validation rules
     * @var array
     */
    protected $regValidation = [
        'name'      => ['required', 'string', 'max:255'],
        'email'     => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password'  => ['required', 'string', 'min:8', 'confirmed'],
    ];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except([ 'logout', 'grid', 'update', 'destroy' ]);
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        $helpCrtl = app(LoginController::class);
        $attempt = $helpCrtl->login($request);

        if ($attempt) {
            return response()->json([
                'token'     => csrf_token(),
                'message'   => trans('auth.success'),
            ]);
        }
    }

    /**
     * Handle a auth check request to the application.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkAuth(Request $request)
    {
        $result = $this->guard()->check();
        if ($result) {
            $user = $this->guard()->user();
            $result = [
                'name' => $user->name,
                'email' => $user->email,
                'admin' => $user->is_admin
            ];
        }
        return response()->json($result);
    }

    /**
     * Handle a logout request to the application.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $helpCrtl = app(LoginController::class);
        $attempt = $helpCrtl->logout($request);

        if ($attempt) {
            $request->session()->regenerateToken();
            return response()->json([
                'token'     => csrf_token(),
                'message'   => trans('auth.Logout successful'),
            ]);
        }
    }

    /**
     * Handle a registration request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $helpCrtl = app(RegisterController::class);
        $attempt = $helpCrtl->register($request);

        if ($attempt) {
            return response()->json([
                'token'     => csrf_token(),
                'message'   => trans('auth.Registration successful'),
            ]);
        }
    }

    /**
     * Handle user list request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function grid(Request $request)
    {
        if (!Auth::user()->is_admin) {
            throw ValidationException::withMessages(['privilege' => [trans('auth.Access not allowed.')]]);
        }
        $perpage = $request->input('per_page', 5);
        $page = $request->input('page', 0)+1;
        $users = User::query()
            ->paginate($perpage == -1 ? PHP_INT_MAX: $perpage, '*', 'page', $perpage == -1 ? 1 : $page)
            ->toArray($request);
        if ($perpage == -1) {
            $users['per_page'] = $perpage;
        }

        return response()->json([
            'message' => '',
            'page' => $users
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    public function update(User $user, Request $request)
    {
        if (!Auth::user()->is_admin) {
            throw ValidationException::withMessages(['privilege' => [trans('auth.Access not allowed.')]]);
        }
        $user->update($request->all());
        return response()->json([
            'success' => '1',
            'message' => trans('user.Successfuly edited')
        ]);
    }

    public function destroy(User $user)
    {
        if (!Auth::user()->is_admin) {
            throw ValidationException::withMessages(['privilege' => [trans('auth.Access not allowed.')]]);
        }

        $user->delete();
        
        return response()->json([
            'success' => '1',
            'message' => trans('user.Successfuly deleted')
        ]);
    }
}
