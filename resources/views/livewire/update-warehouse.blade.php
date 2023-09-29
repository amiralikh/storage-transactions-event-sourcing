<?php

use App\Actions\DeleteCommodity;
use function Livewire\Volt\{state};
use function Livewire\Volt\{rules};
use Masmerise\Toaster\Toaster;
use App\Actions\UpdateWarehouse;
use App\Models\Warehouse;
use Livewire\Volt\Component;


new class extends Component {

    public string $name;
    public int $id;
    public Warehouse $commodity;

    public function with(): array
    {
        $commodity = Warehouse::query()->where('id', $this->id)->firstOrFail();

        $this->name = $commodity->name;
        $this->commodity = $commodity;

        return [
        ];
    }

    protected $rules = [
        'name' => 'required | max:255',
    ];

    public function update()
    {
        $this->validate();
        UpdateWarehouse::make()->run($this->commodity->uuid, $this->name);
        Toaster::success('Commodity updated successfully!');
        return redirect('/warehouses');
    }

}
?>

<div>
    <div class="py-12">
        <div class="w-1/3 mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form wire:submit="update">
                        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Warehouse
                            Name</label>
                        <div class="mt-2 flex flex-row justify-around ">
                            <input type="text" wire:model="name" id="name"
                                   class="block w-2/3 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            @error('name') <span class="error">{{ $message }}</span> @enderror
                            <button type="submit"
                                    class="ml-2 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

