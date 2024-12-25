<x-filament::widget>
    <x-filament::card>
        <h2 class="text-lg font-bold">Statistik Surat</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <div>
                <h3 class="text-sm font-semibold">Total Surat</h3>
                <p class="text-2xl">{{ $this->getStats()['totalSurat'] }}</p>
            </div>
            <div>
                <h3 class="text-sm font-semibold">Today's Letters</h3>
                <p class="text-2xl">{{ $this->getStats()['todayLetters'] }}</p>
            </div>
            <div>
                <h3 class="text-sm font-semibold">This Month's Letters</h3>
                <p class="text-2xl">{{ $this->getStats()['monthLetters'] }}</p>
            </div>
            
        </div>
    </x-filament::card>
</x-filament::widget>
