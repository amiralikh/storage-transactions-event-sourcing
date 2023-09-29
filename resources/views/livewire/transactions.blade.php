<?php

use function Livewire\Volt\{state};
use function Livewire\Volt\{rules};
use Masmerise\Toaster\Toaster;
use App\Actions\AddTransaction;
use App\Actions\DecreaseTransaction;
use Livewire\Volt\Component;
use App\Models\WarehouseGoods;
use App\Models\Warehouse;
use App\Models\Goods;
use Livewire\WithPagination;


new class extends Component {
    use WithPagination;

    public string $quantity = '';
    public string $warehouseUUID = '';
    public string $commodityUUID = '';

    protected $rules = [
        'quantity' => 'required |integer',
        'warehouseUUID' => 'required',
        'commodityUUID' => 'required',
    ];

    public function with(): array
    {
        return [
            'transactions' => WarehouseGoods::with('warehouse', 'commodity')->orderByDesc('created_at')->paginate(10),
            'goods' => Goods::query()->orderByDesc('name')->get(),
            'warehouses' => Warehouse::query()->orderByDesc('created_at')->get()
        ];
    }

    public function increase()
    {
        $this->validate();
        AddTransaction::make()->run($this->quantity, $this->warehouseUUID, $this->commodityUUID);
        Toaster::success('New transaction submitted!');
        $this->quantity = '';
        return redirect('/transactions');

    }

    public function decrease()
    {
        $this->validate();
        DecreaseTransaction::make()->run($this->quantity, $this->warehouseUUID, $this->commodityUUID);
        Toaster::success('New transaction submitted!');
        $this->quantity = '';
        return redirect('/transactions');

    }

}
?>

<div>
    <div class="py-12">
        <div class="w-1/3 mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div>
                        <label for="warehouse" class="block text-sm font-medium leading-6 text-gray-900">Choose warehouse</label>
                        <select id="warehouse" wire:model="warehouseUUID"
                                class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            <option >Choose Warehouse</option>
                            @foreach($warehouses as $warehouse)
                                <option value="{{ $warehouse->uuid }}">{{ $warehouse->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="commodity" class="block text-sm font-medium leading-6 text-gray-900">Choose Commodity</label>
                        <select id="commodity" wire:model="commodityUUID"
                                class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            <option>Choose Commodity</option>
                        @foreach($goods as $commodity)
                                <option value="{{ $commodity->uuid }}">{{ $commodity->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Quantity</label>
                        <div class="mt-2 flex flex-row justify-around ">
                            <input type="text" autocomplete="off" wire:model="quantity" id="quantity"
                                   class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                        <div class="flex flex-row justify-between mt-2">
                            <button type="button" wire:click="increase"
                                    class="rounded-md bg-green-500 px-3 py-2 text-sm font-semibold text-white shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                                Increase
                            </button>
                            <button type="button" wire:click="decrease"
                                    class="rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                                Decrease
                            </button>
                        </div>
                    </div>
                    @error('quantity') <span class="error text-red-600 text-sm mt-2">{{ $message }}</span> @enderror
                    @error('warehouseUUID') <span class="error text-red-600 text-sm mt-2">{{ $message }}</span> @enderror
                    @error('commodityUUID') <span class="error text-red-600 text-sm mt-2">{{ $message }}</span> @enderror

                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-900">
        <div class="mx-auto max-w-7xl">
            <div class="bg-gray-900 py-10">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h1 class="text-base font-semibold leading-6 text-white">Fast Look</h1>
                            <p class="mt-2 text-sm text-gray-300">take a fast look to what's we have</p>
                        </div>
                    </div>
                    <div class="mt-8 flow-root">
                        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                <table class="min-w-full divide-y divide-gray-700">
                                    <thead>
                                    <tr>
                                        <th scope="col"
                                            class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-white sm:pl-0">
                                            ID
                                        </th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">
                                            Warehouse Name
                                        </th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">
                                            Commodity Name
                                        </th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">
                                            Quantity
                                        </th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">
                                            Created @
                                        </th>
                                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                            <span class="sr-only">Edit</span>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-800">
                                    @foreach($transactions as $transaction)
                                        <tr>
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-white sm:pl-0">{{ $transaction->id }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-300">{{ optional($transaction->warehouse)->name }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-300">{{ optional($transaction->commodity)->name }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-300">{{ $transaction->quantity }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-300">{{ $transaction->created_at }}</td>
                                        </tr>
                                    @endforeach
                                    @if($transactions->count() === 0)
                                        <tr>
                                            <td colspan="5"
                                                class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-center  text-white sm:pl-0">
                                                No item!
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                                <div class="mt-2">
                                    {{ $transactions->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

