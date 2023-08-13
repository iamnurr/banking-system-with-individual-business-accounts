
<a href="{{ route('transactions') }}" class="{{ request()->routeIs('transactions') ? 'bg-green-300' : 'bg-white' }} inline-flex items-center rounded-md  px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
    {{("Transactions")}}
</a>
<a href="{{ route('deposits') }}" class="{{ request()->routeIs('deposits') ? 'bg-green-300' : 'bg-white' }} inline-flex items-center rounded-md px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
    {{("Deposits")}}
</a>
<a href="{{ route('withdrawals') }}" class="{{ request()->routeIs('withdrawals') ? 'bg-green-300' : 'bg-white' }} inline-flex items-center rounded-md px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
    {{("Withdrawals")}}
</a>
