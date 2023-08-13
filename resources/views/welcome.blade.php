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
            class="relative flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
            <div class="lg:flex lg:items-center lg:justify-between">
                @if (!auth()->check())
                <div class="mt-5 flex lg:ml-4 lg:mt-0 mx-3">
                    <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" action="{{ route('store-user') }}"
                        method="POST">
                        @csrf
                        <h3 class=" text-gray-700 text-lg font-bold mb-2">{{ __('Create User') }}</h3>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                                {{ __("Name") }}
                            </label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="name" type="text" placeholder="Enter user name" name="name"
                                value="{{ old('name')}}">
                            <p class="text-red-500 mt-1">{{ $errors->first('name') }}</p>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                                {{ __("Email") }}
                            </label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="name" type="text" placeholder="Enter user email" name="email"
                                value="{{ old('email')}}">
                            <p class="text-red-500 mt-1">{{ $errors->first('email') }}</p>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                                {{ __("Password") }}
                            </label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="name" type="text" placeholder="Enter user password" name="password"
                                value="{{ old('password')}}">
                            <p class="text-red-500 mt-1">{{ $errors->first('password') }}</p>
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="Account">
                                {{ __("Account Type") }}
                            </label>
                            <div class="relative">
                                <select
                                    class="block appearance-none w-full bg-white border text-gray-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:shadow-outline"
                                    id="" name="account_type">
                                    <option value="">{{ __("Select a type") }}</option>
                                    @foreach (get_account_types() as $key => $type)
                                    <option {{ $key==old('account_type') ? 'selected' : '' }} value="{{ $key}}">{{ $type
                                        }}
                                    </option>
                                    @endforeach
                                </select>
                                <p class="text-red-500 mt-1">{{ $errors->first('account_type') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-center">
                            <button
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                                type="submit">
                                {{("Create a new user")}}
                            </button>
                        </div>
                    </form>
                </div>

                <div class="mt-5 flex lg:ml-4 lg:mt-0 mx-3">
                    <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" action="{{ route('login') }}"
                        method="POST">
                        @csrf
                        <h3 class=" text-gray-700 text-lg font-bold mb-2">{{ __('Login User') }}</h3>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                                {{ __("Email") }}
                            </label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="name" type="text" placeholder="Enter user email" name="email"
                                value="{{ old('email')}}">
                            <p class="text-red-500 mt-1">{{ $errors->first('email') }}</p>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                                {{ __("Password") }}
                            </label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="name" type="text" placeholder="Enter user password" name="password"
                                value="{{ old('password')}}">
                            <p class="text-red-500 mt-1">{{ $errors->first('password') }}</p>
                        </div>
                        <div class="flex items-center justify-center">
                            <button
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                                type="submit">
                                {{("Login")}}
                            </button>
                        </div>
                    </form>
                </div>
                @else
                    <div class="mt-5 flex lg:ml-4 lg:mt-0 mx-3">
                        <form action="{{route('logout')}}" method="POST">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                                <svg class="-ml-0.5 mr-1.5 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path
                                        d="M12.232 4.232a2.5 2.5 0 013.536 3.536l-1.225 1.224a.75.75 0 001.061 1.06l1.224-1.224a4 4 0 00-5.656-5.656l-3 3a4 4 0 00.225 5.865.75.75 0 00.977-1.138 2.5 2.5 0 01-.142-3.667l3-3z" />
                                    <path
                                        d="M11.603 7.963a.75.75 0 00-.977 1.138 2.5 2.5 0 01.142 3.667l-3 3a2.5 2.5 0 01-3.536-3.536l1.225-1.224a.75.75 0 00-1.061-1.06l-1.224 1.224a4 4 0 105.656 5.656l3-3a4 4 0 00-.225-5.865z" />
                                </svg>
                                {{ __("logout") }}
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>

</html>
