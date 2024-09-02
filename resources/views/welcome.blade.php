<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Products</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-200 p-6">
    @error('product_id')
        <div class="w-full px-4 py-2 mb-4 rounded bg-red-600 text-white">{{ $message }}</div>
    @enderror
    <div class="flex flex-col gap-4">
        @foreach ($products as $product)
            <form class="bg-white w-full p-6 rounded" method="POST" action="{{ url('buy-product') }}">
                @csrf
                <div class="max-w-2xl flex flex-col gap-2 items-start">
                    <div class="flex items-center gap-2 mt-3">
                        <h4 class="text-lg font-semibold">{{ $product->name }}</h4>
                        (<b>$ {{ $product->price }}</b>)
                    </div>

                    <p class="text-sm">{{ $product->description }}</p>
                    <input type="hidden" value="{{ $product->id }}" name="product_id" />
                    <button class="bg-blue-600 px-3 text-sm font-medium text-white rounded py-1" type="submit">Buy
                        Now</button>
                </div>
            </form>
        @endforeach
    </div>
</body>

</html>
