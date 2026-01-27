<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Payment;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function checkout($eventId)
{
    $event = Event::findOrFail($eventId);

    $payments = Payment::where('is_active', true)->get();

    return view('checkout.index', compact('event', 'payments'));
}
}       