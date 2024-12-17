<div class="mt-2 mb-2">
    <div>
        @if ($showPrompt)
            <div class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-75 z-50">
                <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-lg w-full max-w-3xl mx-4 sm:mx-6 lg:mx-12 lg:w-[80%]">
                    <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100 text-center">Continue or Start Fresh?</h2>

                    <div class="flex justify-center gap-6">
                        <button
                            wire:click="continueEditing"
                            class="px-6 py-3 bg-green-500 hover:bg-green-600 text-white rounded-lg text-lg transition duration-200"
                        >
                            Continue
                        </button>
                        <button
                            wire:click="startFresh"
                            class="px-6 py-3 bg-red-500 hover:bg-red-600 text-white rounded-lg text-lg transition duration-200"
                        >
                            Start Fresh
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <form wire:submit.prevent="save">
            @if (!$this->showPrompt)
                {{ $this->form }}
            @endif
            
        </form>
    </div>
</div>
