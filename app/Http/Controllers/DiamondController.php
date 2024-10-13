<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\DiamondPurchase;

class DiamondController extends Controller
{
    public function index()
    {
        // Grid data (prices and diamonds)
        $grid = [
            ['diamonds' => 78, 'price' => 1.50],
            ['diamonds' => 100, 'price' => 2.00],
            ['diamonds' => 150, 'price' => 3.50],
            ['diamonds' => 200, 'price' => 5.00],
            ['diamonds' => 250, 'price' => 6.50],
            ['diamonds' => 300, 'price' => 8.00],
            ['diamonds' => 350, 'price' => 9.50],
            ['diamonds' => 400, 'price' => 11.00],
            ['diamonds' => 450, 'price' => 12.50],
            ['diamonds' => 500, 'price' => 15.00],
            ['bonus_diamonds' => 8, 'price' => 1.50], // Bonus price
        ];

        return view('diamond.index', ['grid' => $grid]);
    }

    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'square' => 'required|numeric',
            'field1' => 'required',
            'field2' => 'required',
        ]);

        // Get selected square details
        $selected = $request->input('square');
        $grid = [
            ['diamonds' => 78, 'price' => 1.50],
            ['diamonds' => 100, 'price' => 2.00],
            ['diamonds' => 150, 'price' => 3.50],
            ['diamonds' => 200, 'price' => 5.00],
            ['diamonds' => 250, 'price' => 6.50],
            ['diamonds' => 300, 'price' => 8.00],
            ['diamonds' => 350, 'price' => 9.50],
            ['diamonds' => 400, 'price' => 11.00],
            ['diamonds' => 450, 'price' => 12.50],
            ['diamonds' => 500, 'price' => 15.00],
            ['bonus_diamonds' => 8, 'price' => 1.50], // Bonus price
        ];

        $diamonds = $grid[$selected]['diamonds'];
        $price = $grid[$selected]['price'];

        // Store session values
        Session::put('diamonds', $diamonds);
        Session::put('price', $price);

        // Insert into MySQL database
        $purchase = new DiamondPurchase();
        $purchase->field1 = $request->input('field1');
        $purchase->field2 = $request->input('field2');
        $purchase->total_price = $price;
        $purchase->total_diamonds = $diamonds;
        $purchase->save();

        return redirect()->back()->with('success', 'Purchase stored successfully!');
    }
}

