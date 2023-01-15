<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Cart;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class TransactionController extends Controller
{
   public function store(Request $request)
   {
  /*   DB::beginTransaction(); */

    /* try { */
      /*   Auth::user()
            ->transactions()
            ->create(request()->all())
            ->details()
            ->createMany(Cart::all()->map(function ($cart) {
                return [
                    'item_id' => $cart->item_id,
                    'quantity' => $cart->quantity,
                    'subtotal' => $cart->item->price * $cart->quantity
                ];
            })->toArray());

        DB::table('carts')->delete();

        DB::commit();
    } catch (Exception $e) {
        DB::rollBack();
    } */

    // return redirect()->route('transaction.show', Transaction::latest()->first());
    return Auth::user()->transactions();
   }

   public function index()
   {
    $transactions = Transaction::latest()->get();

    return view('transaction.index', compact('transactions'));
   }

   public function show(Transaction $transaction) 
   {
    return view('transaction.show', compact('transaction'));
   }
}
