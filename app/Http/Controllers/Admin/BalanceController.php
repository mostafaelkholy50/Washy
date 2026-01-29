<?php

namespace App\Http\Controllers\Admin;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BalanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::with(['balance', 'currency'])
            ->select('customers.id', 'customers.name', 'customers.preferred_currency', 'customers.currency_id');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('customers.name', 'like', "%{$search}%");
        }

        // Sorting
        $sort = $request->get('sort', 'name');
        $direction = $request->get('direction', 'asc');
        $allowedSorts = ['name', 'balance'];

        if ($sort === 'balance') {
            $query->leftJoin('balances', 'customers.id', '=', 'balances.customer_id')
                ->orderBy('balances.amount', $direction);
        } elseif (in_array($sort, $allowedSorts)) {
            $query->orderBy('customers.' . $sort, $direction);
        } else {
            $query->orderBy('customers.name', 'asc');
        }

        $customers = $query->paginate(20)->withQueryString();

        return view('admin.balances.index', compact('customers'));
    }
}
