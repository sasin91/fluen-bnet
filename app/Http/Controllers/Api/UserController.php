<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Auth\Access\Gate;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @var Gate
     */
    protected $gate;

    /**
     * UserController constructor.
     * @param Gate $gate
     */
    public function __construct(GateContract $gate)
    {
        $this->gate = $gate;
    }

    /**
     * Display the current user.
     *
     *
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        return $request->user();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return response()->json($this->formFields($request->user()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'email'     =>  'required|max:255|unique:users',
            'uid'       =>  'required|integer|unique:users',
            'battleTag' =>  'required|max:255|unique:users',
            'name'      =>  'required|max:255',
            'password'  =>  'required|max:255|confirmed',
        ]);

        $created = User::create($this->fillable($request, $request->user()));

        return response()->json(json_encode(compact('created')));
    }

    /**
     * Display the specified resource.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        abort_unless($this->gate->allows('view', $user), 403);

        return response()->json($user->toJson());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        abort_unless($this->gate->allows('edit', $user), 403);

        return response()->json($this->formFields($user));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        abort_unless($this->gate->allows('update', $user), 403);

        $updated = $user->update($this->fillable($request, $user));

        return response()->json(compact('updated'));
    }

    /**
     * Destroy the current User.
     *
     *
     * @param User $user
     * @return mixed
     */
    public function destroy(User $user)
    {
        abort_unless($this->gate->allows('delete', $user), 403);

        $deleted = $user->delete();

        return response()->json(compact('deleted'));
    }

    /**
     * Filters the request input by whats fillable on the model.
     *
     * @param User $user
     * @param Request $request
     * @return array
     */
    protected function fillable(Request $request, User $user)
    {
        return $request->only(
            $user->getFillable()
        );
    }

    /**
     * returns the form fields
     *
     * @param User $user
     * @return string
     */
    protected function formFields(User $user) : string
    {
        return json_encode([
            'form_fields'   =>  $user->getFillable()
        ]);
    }
}
