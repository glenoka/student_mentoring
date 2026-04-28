<div class="space-y-6">

    {{-- Header --}}
    <div>
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
            Riwayat Mentoring
        </h2>

        <p class="text-sm text-gray-500">
            Catatan setiap sesi mentoring yang telah dilakukan
        </p>
    </div>

    {{-- Timeline --}}
    <div class="space-y-8">

        @forelse($this->sessions as $item)
            @php
                $badge = match ($item['progress_status']) {
                    'pending_support' => ['Perlu Pendampingan', 'danger'],
                    'developing' => ['Sedang Berkembang', 'gray'],
                    'reinforcement' => ['Perlu Penguatan', 'warning'],
                    'progressing' => ['Menunjukkan Perkembangan', 'info'],
                    'good' => ['Baik', 'success'],
                    'excellent' => ['Sangat Baik', 'primary'],
                    default => ['-', 'gray'],
                };

                $commentCount = $item['comments_count'] ?? 0;
            @endphp

            <div class="grid grid-cols-12 gap-4">

                {{-- Date --}}
                <div class="col-span-12 md:col-span-2">

                    <div class="text-primary-600 font-semibold text-sm leading-none">
                        {{ \Carbon\Carbon::parse($item['session_date'])->format('d M Y') }}
                    </div>

                    <div class="text-xs text-gray-500 mt-1">
                        {{ \Carbon\Carbon::parse($item['session_date'])->translatedFormat('l') }}
                    </div>

                </div>

                {{-- Timeline --}}
                <div class="hidden md:flex col-span-1 justify-center relative">

                    <div class="w-px bg-gray-200 dark:bg-gray-700 absolute top-0 bottom-0"></div>

                    <div
                        class="relative z-10 mt-1 w-6 h-6 rounded-full bg-success-500 text-white flex items-center justify-center shadow">
                        <x-heroicon-m-check class="w-3.5 h-3.5" />
                    </div>

                </div>

                {{-- Card --}}
                <div class="col-span-12 md:col-span-9">

                    <div
                        class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 overflow-hidden shadow-sm">

                        {{-- Header --}}
                        <div
                            class="px-5 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between gap-3">

                            <h3 class="font-semibold text-gray-900 dark:text-white">
                                Sesi Mentoring
                            </h3>

                            <div class="flex items-center gap-2">

                                <x-filament::badge :color="$badge[1]">
                                    {{ $badge[0] }}
                                </x-filament::badge>

                                {{-- More Actions --}}
                                <x-filament::dropdown placement="bottom-end">
                                    <x-slot name="trigger">
                                        <button type="button"
                                            class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                                            <x-heroicon-m-ellipsis-horizontal class="w-5 h-5" />
                                        </button>
                                    </x-slot>

                                    <x-filament::dropdown.list>

                                        <x-filament::dropdown.list.item icon="heroicon-o-pencil-square"
                                            wire:click="editSession({{ $item['id'] }})">
                                            Edit
                                        </x-filament::dropdown.list.item>

                                        <x-filament::dropdown.list.item icon="heroicon-o-trash" color="danger"
                                            wire:click="mountAction('deleteSession', { id: {{ $item['id'] }} })">
                                            Delete
                                        </x-filament::dropdown.list.item>

                                    </x-filament::dropdown.list>
                                </x-filament::dropdown>

                            </div>

                        </div>

                        {{-- Teacher Notes --}}
                        <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800">

                            <div class="text-sm font-semibold text-gray-900 dark:text-white mb-2">
                                Catatan
                            </div>

                            <div class="prose prose-sm max-w-none dark:prose-invert text-gray-700 dark:text-gray-300">
                                <div class="fi-prose">
                                    {{ \Filament\Forms\Components\RichEditor\RichContentRenderer::make($item['message']) }}
                                </div>


                            </div>

                        </div>

                        {{-- Comment --}}
                        <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800">

                            <div class="flex items-center justify-between">
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">
                                    Comment
                                </span>

                                <x-filament::badge color="info">
                                    {{ $commentCount }}
                                </x-filament::badge>
                            </div>

                        </div>

                        {{-- Footer --}}
                        <div class="px-5 py-3 flex justify-between text-sm text-gray-500">

                            <div class="flex items-center gap-1">
                                <x-heroicon-o-user class="w-4 h-4" />
                                <span>{{ $item['mentor'] }}</span>
                            </div>

                            <div class="flex items-center gap-1">
                                <x-heroicon-o-clock class="w-4 h-4" />
                                <span>{{ $item['duration'] }}</span>
                            </div>

                        </div>


                    </div>

                </div>

            </div>

        @empty
            <div class="rounded-2xl border border-dashed border-gray-300 p-8 text-center text-sm text-gray-500">
                Belum ada riwayat mentoring.
            </div>
        @endforelse

    </div>

</div>
