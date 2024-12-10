<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    //könyvtáros + admin
    public function index()
    {
        return Reservation::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $record = new Reservation();
        $record->fill($request->all());
        $record->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $user_id, string $book_id,string $start)
    {
        $reservation = Reservation::where('user_id', $user_id)
        ->where('book_id', $book_id)
        ->where('start', $start)
        //listát ad vissza:
        ->get();
        return $reservation[0];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,string $user_id,string $book_id,string $start)
    {
        $user = $this->show($user_id, $book_id, $start);
        $user->fill($request->all());
        $user->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $user_id,string $book_id,string $start)
    {
        $this->show($user_id, $book_id, $start)->delete();
    }

    //spec lekérdezések
    public function reservedBooks(){
        $user = Auth::user();
        return Reservation::with('books')
        ->where('user_id', $user->id)
        ->get();
    }

    //Hány darab előjegyzése van a bejelentkezett felhasználónak?
    public function reservedCount(){
        $user = Auth::user();
        $pieces = DB::table('reservations')
        ->where('user_id', $user->id)
        ->count();

        return $pieces;
    }

    public function getOldReservations()
    {
        $user = Auth::user();
        // A 3 napnál régebbi dátum kiszámítása
        $threeDaysAgo = Carbon::now()->subDays(3);
        // Lekérjük a 3 napnál régebbi előjegyzéseket
        $oldReservations = Reservation::where('user_id', $user->id)
            ->where('reservation_date', '<', $threeDaysAgo)
            ->get();

        return $oldReservations;
    }
}
