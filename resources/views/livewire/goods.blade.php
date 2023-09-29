<?php

use App\Actions\DeleteCommodity;
use function Livewire\Volt\{state};
use function Livewire\Volt\{rules};
use Masmerise\Toaster\Toaster;
use App\Actions\CreateNewCommodity;
use App\Models\Goods;
use Livewire\Volt\Component;
use Livewire\WithPagination;


new class extends Component {
    use WithPagination;

    public string $name;

    protected $rules = [
        'name' => 'required | max:255',
    ];

    public function with(): array
    {
        return [
            'commodities' => Goods::query()->orderByDesc('created_at')->paginate(10),
        ];
    }

    public function store() {
        $this->validate();
        CreateNewCommodity::make()->run($this->name);
        Toaster::success('New commodity added!');
        $this->name = '';
        return redirect('/goods');

    }

    public function destroy($commodity)
    {
        DeleteCommodity::make()->run($commodity['uuid']);
        Toaster::success('Commodity was deleted');
        return redirect('/goods');
    }

}
?>

<div>
    <div class="py-12">
        <div class="w-1/3 mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form wire:submit="store">
                        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Commodity
                            Name</label>
                        <div class="mt-2 flex flex-row justify-around ">
                            <input type="text" wire:model="name" id="name"
                                   class="block w-2/3 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            <button type="submit"
                            class="ml-2 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                                Submit
                            </button>
                        </div>
                        @error('name') <span class="error text-red-600 text-sm mt-2">{{ $message }}</span> @enderror
                    </form>
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
                            <h1 class="text-base font-semibold leading-6 text-white">Goods</h1>
                            <p class="mt-2 text-sm text-gray-300">By submitting goods you can manage them in the
                                warehouses</p>
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
                                            Name
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
                                    @foreach($commodities as $commodity)
                                        <tr>
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-white sm:pl-0">{{ $commodity->id }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-300">{{ $commodity->name }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-300">{{ $commodity->created_at }}</td>
                                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                                <a href="{{ route('goods.edit',$commodity->id) }}" class="text-indigo-400 hover:text-indigo-300">Edit<span
                                                        class="sr-only">, Lindsay Walton</span></a>
                                                <button wire:click="destroy({{ $commodity }})"
                                                   class="ml-2 text-red-600 hover:text-indigo-300">Delete</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if($commodities->count() === 0)
                                        <tr>
                                            <td colspan="4" class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-center  text-white sm:pl-0">No item!</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                                <div class="mt-3">
                                    {{ $commodities->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

