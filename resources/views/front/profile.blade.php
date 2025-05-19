@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
    @if (session('status'))
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                @if (session('status') === 'profile-updated')
                    پروفایل با موفقیت بروزرسانی شد
                @elseif (session('status') === 'password-updated')
                    رمز عبور با موفقیت تغییر کرد
                @endif
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <div class="w-full sm:max-w-4xl mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <div class="row">
            <!-- Profile Card -->
            <div class="col-md-4 mb-4">
                <div class="text-center">
                    <div class="position-relative d-inline-block mb-3">
                        @if(auth()->user()->avatar)
                            <img src="{{ Storage::url(auth()->user()->avatar) }}" 
                                 class="rounded-circle" 
                                 style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #fff; box-shadow: 0 0 10px rgba(0,0,0,0.1);" 
                                 alt="Profile Image">
                        @else
                            <img src="{{ asset('assets/images/user-avatar.png') }}" 
                                 class="rounded-circle" 
                                 style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #fff; box-shadow: 0 0 10px rgba(0,0,0,0.1);" 
                                 alt="Default Profile Image">
                        @endif
                    </div>
                    <h4 class="mb-1">{{ auth()->user()->full_name }}</h4>
                    <p class="text-muted mb-3">{{ auth()->user()->email }}</p>
                    <div class="d-flex justify-content-center gap-2">
                        <span class="badge bg-primary">کاربر</span>
                        @if(auth()->user()->is_admin)
                            <span class="badge bg-danger">مدیر</span>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Profile Settings -->
            <div class="col-md-8">
                <div class="d-flex gap-4 mb-4">
                    <button class="btn btn-link text-decoration-none p-0 fs-5 fw-bold text-primary" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab">
                        <i class="bi bi-person-circle me-2"></i>ویرایش پروفایل
                    </button>
                    <button class="btn btn-link text-decoration-none p-0 fs-5 fw-bold text-primary" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button" role="tab">
                        <i class="bi bi-key me-2"></i>تغییر رمز عبور
                    </button>
                    <button class="btn btn-link text-decoration-none p-0 fs-5 fw-bold text-danger" id="danger-tab" data-bs-toggle="tab" data-bs-target="#danger" type="button" role="tab">
                        <i class="bi bi-trash me-2"></i>حذف حساب
                    </button>
                </div>

                <div class="tab-content" id="profileTabsContent">
                    <!-- Profile Update Tab -->
                    <div class="tab-pane fade show active" id="profile" role="tabpanel">
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-3">
                                <x-input-label for="full_name" :value="__('نام کامل')" />
                                <x-text-input type="text" class="block mt-1 w-full @error('full_name') is-invalid @enderror" 
                                       id="full_name" name="full_name" :value="old('full_name', auth()->user()->full_name)" required />
                                <x-input-error :messages="$errors->get('full_name')" class="mt-2" />
                            </div>
                            
                            <div class="mb-3">
                                <x-input-label for="email" :value="__('ایمیل')" />
                                <x-text-input type="email" class="block mt-1 w-full @error('email') is-invalid @enderror" 
                                       id="email" name="email" :value="old('email', auth()->user()->email)" required />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                            
                            <div class="mb-3">
                                <x-input-label for="user_avatar" :value="__('تصویر پروفایل')" />
                                <input type="file" class="block mt-1 w-full @error('user_avatar') is-invalid @enderror" 
                                       id="user_avatar" name="user_avatar">
                                <x-input-error :messages="$errors->get('user_avatar')" class="mt-2" />
                                <div class="text-sm text-gray-600 mt-1">حداکثر حجم فایل: 1 مگابایت</div>
                            </div>
                            
                            <div class="flex items-center justify-end mt-4">
                                <x-primary-button>
                                    <i class="bi bi-save me-2"></i>بروزرسانی پروفایل
                                </x-primary-button>
                            </div>
                        </form>
                    </div>

                    <!-- Password Change Tab -->
                    <div class="tab-pane fade" id="password" role="tabpanel">
                        <form action="{{ route('password.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-3">
                                <x-input-label for="current_password" :value="__('رمز عبور فعلی')" />
                                <x-text-input type="password" class="block mt-1 w-full @error('current_password') is-invalid @enderror" 
                                       id="current_password" name="current_password" required />
                                <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
                            </div>
                            
                            <div class="mb-3">
                                <x-input-label for="password" :value="__('رمز عبور جدید')" />
                                <x-text-input type="password" class="block mt-1 w-full @error('password') is-invalid @enderror" 
                                       id="password" name="password" required />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                            
                            <div class="mb-3">
                                <x-input-label for="password_confirmation" :value="__('تکرار رمز عبور جدید')" />
                                <x-text-input type="password" class="block mt-1 w-full" 
                                       id="password_confirmation" name="password_confirmation" required />
                            </div>
                            
                            <div class="flex items-center justify-end mt-4">
                                <x-primary-button>
                                    <i class="bi bi-key me-2"></i>تغییر رمز عبور
                                </x-primary-button>
                            </div>
                        </form>
                    </div>

                    <!-- Delete Account Tab -->
                    <div class="tab-pane fade" id="danger" role="tabpanel">
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <h5 class="text-red-800 font-medium mb-3">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                حذف حساب کاربری
                            </h5>
                            <p class="text-red-600 mb-3">با حذف حساب کاربری، تمام اطلاعات شما برای همیشه پاک خواهد شد. این عمل غیرقابل بازگشت است.</p>
                            
                            <form action="{{ route('profile.destroy') }}" method="POST" 
                                  onsubmit="return confirm('آیا از حذف حساب کاربری خود اطمینان دارید؟');">
                                @csrf
                                @method('DELETE')
                                
                                <div class="mb-3">
                                    <x-input-label for="delete_password" :value="__('رمز عبور خود را وارد کنید')" />
                                    <x-text-input type="password" class="block mt-1 w-full @error('password') is-invalid @enderror" 
                                           id="delete_password" name="password" required />
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>
                                
                                <div class="flex items-center justify-end mt-4">
                                    <x-danger-button>
                                        <i class="bi bi-trash me-2"></i>حذف حساب کاربری
                                    </x-danger-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('[data-bs-toggle="tab"]');
    const tabContents = document.querySelectorAll('.tab-pane');

    // Function to update button styles
    function updateButtonStyles(activeButton) {
        buttons.forEach(button => {
            if (button === activeButton) {
                if (button.id === 'danger-tab') {
                    button.classList.add('border-bottom', 'border-danger', 'border-3');
                    button.classList.remove('border-primary');
                } else {
                    button.classList.add('border-bottom', 'border-primary', 'border-3');
                    button.classList.remove('border-danger');
                }
            } else {
                button.classList.remove('border-bottom', 'border-primary', 'border-danger', 'border-3');
            }
        });
    }

    // Add click event listeners to buttons
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            updateButtonStyles(this);
        });
    });

    // Set initial active state
    const activeTab = document.querySelector('.tab-pane.active');
    if (activeTab) {
        const activeButton = document.querySelector(`[data-bs-target="#${activeTab.id}"]`);
        if (activeButton) {
            updateButtonStyles(activeButton);
        }
    }
});
</script>
@endpush 