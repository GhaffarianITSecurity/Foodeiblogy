<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            حذف اکانت
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            اکانت شما حذف شدو تمام اطلاعات از سرور حذف می شود
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >حذف اکانت</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                آیا مطمعن هستی که میخوای اکانت خودت رو حذف کنی؟
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    کنسل
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    حذف اکانت
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
