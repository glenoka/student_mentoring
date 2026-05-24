<x-filament-panels::page>

    <div class="w-full">

        <!-- WRAPPER -->
        <section class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-white/10 rounded-3xl p-6 shadow-sm">

            <!-- HEADER -->
            <div class="flex flex-col xl:flex-row gap-4 xl:items-center xl:justify-between mb-6">

                <!-- SEARCH -->
                <div class="relative w-full xl:max-w-xl">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 dark:text-gray-500"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>

                    <input
    type="text"
    wire:model.live.debounce.500ms="search"
    placeholder="Cari materi..."
    class="w-full h-12 pl-12 pr-4 rounded-2xl border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-800 text-sm text-gray-700 dark:text-white placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition"
/>

                </div>

                <!-- FILTER -->
               <select
    wire:model.live="type"
    class="h-12 px-4 rounded-2xl border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-800 text-sm text-gray-700 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition"
>
    <option value="">Semua Type</option>
    <option value="document">Document</option>
    <option value="video">Video</option>
    <option value="image">Image</option>
    <option value="game">Game</option>
</select>

            </div>

            <!-- GRID -->
     <div class="grid gap-5 [grid-template-columns:repeat(auto-fill,minmax(280px,1fr))]">

                <!-- CARD -->
                @foreach($this->getMaterialsProperty() as $m)
                <div class="flex flex-col overflow-hidden rounded-3xl border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-800 shadow-sm hover:shadow-lg transition duration-300">

                    <!-- IMAGE -->
                    <div class="relative">

                        <img src="{{ $m->thumbnail }}"
                            alt="Materi" class="w-full h-48 object-cover" />

                        <!-- TYPE -->
                        <div class="absolute top-4 right-4">

                          @php
    $typeConfig = match(strtolower($m->type)) {
        'document' => [
            'icon' => 'heroicon-m-document-text',
            'class' => 'text-blue-600 dark:text-blue-400',
        ],

        'image' => [
            'icon' => 'heroicon-m-photo',
            'class' => 'text-pink-600 dark:text-pink-400',
        ],

        'video' => [
            'icon' => 'heroicon-m-play-circle',
            'class' => 'text-purple-600 dark:text-purple-400',
        ],

        'game' => [
            'icon' => 'heroicon-m-cpu-chip',
            'class' => 'text-emerald-600 dark:text-emerald-400',
        ],

        default => [
            'icon' => 'heroicon-m-squares-2x2',
            'class' => 'text-gray-600 dark:text-gray-400',
        ],
    };
@endphp

<span
    class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-medium bg-white/90 dark:bg-gray-900/90 backdrop-blur shadow-sm {{ $typeConfig['class'] }}"
>
    <x-filament::icon
        :icon="$typeConfig['icon']"
        class="w-3.5 h-3.5"
    />

    {{ ucfirst($m->type) }}
</span>

                        </div>

                    </div>

                    <!-- CONTENT -->
                    <div class="flex flex-col flex-1 p-5">

                        <!-- TOP -->
                        <div class="flex items-start justify-between gap-3 mb-4">

                            <div>

                                <!-- TITLE -->
                                <h2 class="text-lg font-bold leading-snug text-gray-900 dark:text-white mb-1">
                                   {{$m->title}}
                                </h2>


                            </div>

                            <!-- SHARE -->
                            <button type="button"
                                class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-white/5 transition shrink-0">
                                <x-heroicon-m-share class="w-3.5 h-3.5 text-gray-400 dark:text-gray-500" />
                            </button>

                        </div>

                        <!-- DESCRIPTION -->
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed text-sm line-clamp-3 mb-5">
                           {{$m->description}}
                        </p>

                        <!-- INFO -->
                        <div class="grid grid-cols-2 gap-3 mb-5">

                            <div>

                                <p class="text-[11px] text-gray-400 dark:text-gray-500 mb-1">
                                    Upload By
                                </p>

                                <p class="text-sm font-semibold text-gray-800 dark:text-white">
                                   {{$m->teacher->name}}
                                </p>

                            </div>

                            <div>

                                <p class="text-[11px] text-gray-400 dark:text-gray-500 mb-1">
                                    Created At
                                </p>

                                <p class="text-sm font-semibold text-gray-800 dark:text-white">
                                    {{$m->created_at->format('d M Y')}}
                                </p>

                            </div>

                        </div>

                        <!-- FOOTER BUTTON -->
                        <div class="mt-auto pt-4 border-t border-gray-100 dark:border-white/10">

                            <button type="button"
                                 onclick="window.open('{{ $m->url }}', '_blank')"
                                class="w-full h-11 rounded-2xl bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium transition">
                                Lihat Materi
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
<x-filament::pagination
    :paginator="$this->getMaterialsProperty()"
        :page-options="[5, 10, 20, 50, 100, 'all']"
    current-page-option-property="perPage"

    class="mt-20"
/>
        </section>

    </div>

</x-filament-panels::page>
