<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShowUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Support\Facades\ExchangeRate;

class UserController extends Controller
{
    /**
     * User model instance
     *
     * @var App\Models\User
     */
    protected $user;

    /**
     * Create a new controller instance.
     *
     * @param \App\Models\User $user [user model instance]
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->user->get();

        return view('executives.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('executives.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreUserRequest $request [request instance]
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $this->user->create($request->validated());

        return redirect()->route('users.index')
                         ->with('success', 'Executive profile created!');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Http\Requests\ShowUserRequest $request [request instance]
     * @param \App\Models\User                   $user    [user model instance]
     *
     * @return \Illuminate\Http\Response
     */
    public function show(ShowUserRequest $request, User $user)
    {
        $exchangeRates = ExchangeRate::fetchRates($user->currency);

        $convertedSalaryCurrency = $request->query('CUR');
            
        $exchangeRate = $exchangeRates[$convertedSalaryCurrency];

        $convertedSalary =
            ExchangeRate::convertCurrency($user->hourly_rate, $exchangeRate);

        return response()->json(
            compact(
                'user',
                'exchangeRate',
                'convertedSalary',
                'convertedSalaryCurrency'
            )
        );
    }
}
