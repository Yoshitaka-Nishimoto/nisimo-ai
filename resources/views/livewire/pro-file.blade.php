<div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
    <div class="max-w-xl">
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Profile Information') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __("Update your account's profile information and email address.") }}
            </p>
        </header>

        <form wire:submit.prevent="updateProfile" class="mt-6 space-y-6">
            <div>
                <x-flux.field :label="__('Name')" for="name">
                    <x-flux.input id="name" type="text" wire:model="name" required autofocus autocomplete="name" />
                </x-flux.field>
                @error('name') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <x-flux.field :label="__('Email')" for="email">
                    <x-flux.input id="email" type="email" wire:model="email" required autocomplete="username" />
                </x-flux.field>
                @error('email') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>


            <div class="flex items-center gap-4">
                <x-flux.button variant="primary" type="submit">
                    <span wire:loading.remove>{{ __('Save') }}</span>
                    <span wire:loading>{{ __('Saving...') }}</span>
                </x-flux.button>

                @if (session('status'))
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-gray-600 dark:text-gray-400"
                    >{{ session('status') }}</p>
                @endif
            </div>
        </form>
    </div>
</div>
