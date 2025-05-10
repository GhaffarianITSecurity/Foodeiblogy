<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        از ساخت اکانت جدید خود متشکریم. برای فعال کردن اکانت خود به این آدرس ایمیل مراجعه کنید.
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            لینک جدید برای تایید اکانت شما ارسال شده است
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    ارسال لینک تایید
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                خروج
            </button>
        </form>
    </div>
</x-guest-layout>
