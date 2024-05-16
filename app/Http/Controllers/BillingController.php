<?php

namespace App\Http\Controllers;

class BillingController extends Controller
{
    public function show()
    {
        $person = auth('person')->user();
        $transactions = $person->transactions;
        return view('billing.show', get_defined_vars());
    }
}
