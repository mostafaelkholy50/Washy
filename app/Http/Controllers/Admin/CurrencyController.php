<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function index(Request $request)
    {
        $query = Currency::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%")
                ->orWhere('code', 'like', "%{$request->search}%");
        }

        $currencies = $query->orderBy('is_favorite', 'desc')
            ->orderBy('name', 'asc')
            ->get();

        return view('admin.currencies.index', compact('currencies'));
    }

    public function create()
    {
        return view('admin.currencies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10',
            'symbol' => 'nullable|string|max:10',
        ]);

        $is_favorite = $request->has('is_favorite');

        if ($is_favorite) {
            Currency::where('is_favorite', true)->update(['is_favorite' => false]);
        }

        Currency::create([
            'name' => $request->name,
            'code' => $request->code,
            'symbol' => $request->symbol,
            'is_favorite' => $is_favorite,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.currencies.index')->with('success', 'تم إضافة العملة بنجاح.');
    }

    public function edit(Currency $currency)
    {
        return view('admin.currencies.edit', compact('currency'));
    }

    public function update(Request $request, Currency $currency)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10',
            'symbol' => 'nullable|string|max:10',
        ]);

        $is_favorite = $request->has('is_favorite');

        if ($is_favorite) {
            Currency::where('id', '!=', $currency->id)->update(['is_favorite' => false]);
        }

        $currency->update([
            'name' => $request->name,
            'code' => $request->code,
            'symbol' => $request->symbol,
            'is_favorite' => $is_favorite,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.currencies.index')->with('success', 'تم تحديث العملة بنجاح.');
    }

    public function destroy(Currency $currency)
    {
        if ($currency->is_favorite) {
            return redirect()->back()->with('error', 'لا يمكن حذف العملة المفضلة.');
        }

        $currency->delete();
        return redirect()->route('admin.currencies.index')->with('success', 'تم حذف العملة بنجاح.');
    }

    public function makeFavorite(Currency $currency)
    {
        Currency::where('is_favorite', true)->update(['is_favorite' => false]);
        $currency->update(['is_favorite' => true]);

        return redirect()->back()->with('success', 'تم تعيين العملة كعملة افتراضية.');
    }
}
