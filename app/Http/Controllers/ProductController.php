<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Stripe\StripeClient;

class ProductController extends Controller
{
    protected $stripe;

    public function __construct(StripeClient $stripe)
    {
        $this->stripe = $stripe;
    }

    public function page()
    {
        $products = Product::all();
        return view('welcome', [
            'products' => $products
        ]);
    }

    public function buyProduct(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $product = Product::where('id', $request->product_id)->first();
        $session = $this->stripe->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $product->name,
                        ],
                        'unit_amount' => $product->price * 100, // Amount in cents
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => url('/checkout/success?session_id={CHECKOUT_SESSION_ID}'),
            'cancel_url' => route('products'),
        ]);

        return redirect()->away($session->url);
    }

    public function thankYou(Request $request)
    {
        if (!$request->query('session_id')) {
            return "Something went wrong!";
        }

        $response = $this->stripe->checkout->sessions->retrieve($request->query('session_id'));
        if ($response->payment_status === 'paid') {
            return view('success');
        }

        return "Something went wrong";
    }
}
