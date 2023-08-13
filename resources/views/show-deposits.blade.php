<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased">
    <div>
        @if (session(RESPONSE_TYPE_SUCCESS))
        <div class="mb-4 flex items-center justify-center">
            <div class="bg-green-500 text-white py-2 px-4 rounded shadow-md">
                {{ session(RESPONSE_TYPE_SUCCESS) }}
            </div>
        </div>
        @endif

        @if (session(RESPONSE_TYPE_WARNING))
        <div class="mb-4 flex items-center justify-center">
            <div class="bg-yellow-500 text-white py-2 px-4 rounded shadow-md">
                {{ session(RESPONSE_TYPE_WARNING) }}
            </div>
        </div>
        @endif
        <div
            class="relative w-full flex justify-center   min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">

            <div class="w-full mt-20 max-w-screen-lg mx-auto p-4">
                <div class="my-4 flex justify-between">
                    <div>
                        @include('_navs')
                    </div>
                    <div class="text-white">{{ __("Current Balance :") }} {{ auth()->user()->balance }}</div>
                </div>
                <div>
                    <form action="{{ route('deposits.store') }}" method="POST">
                        @csrf
                        <div>
                            <div class="mb-4">
                                <input
                                    class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" placeholder="Enter your amount" name="amount"
                                    value="{{ old('amount')}}">
                                <button
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                                    type="submit">
                                    {{("Deposit")}}
                                </button>
                            </div>
                            <p class="text-red-500 mt-1">{{ $errors->first('amount') }}</p>
                        </div>
                    </form>
                </div>
                <h2 class="text-white text-lg">{{("Deposits")}}</h2>
                <table class="min-w-full border border-gray-300 divide-y divide-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-2 px-4 text-left">{{ __("Amount") }}</th>
                            <th class="py-2 px-4 text-left">{{ __("Fee") }}</th>
                            <th class="py-2 px-4 text-left">{{ __("Date") }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $deposit)
                        <tr class="">
                            <td class="py-2 px-4 text-white">{{ $deposit->amount }}</td>
                            <td class="py-2 px-4 text-white">{{ $deposit->fee }}</td>
                            <td class="py-2 px-4 text-white">{{ $deposit->date }}</td>
                        </tr>
                        @empty
                        <tr class="">
                            <td class="text-white">{{('No data found.') }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
