@extends('layouts.app')

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
<style>
    #avatar_preview_container:hover #avatar_overlay { opacity: 1 !important; }
</style>
@endpush

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="fw-bold mb-0">إعدادات الملف الشخصي</h4>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-xl-8">
        
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="card-header bg-light border-bottom px-4 py-3 d-flex align-items-center gap-2">
                <span class="material-symbols-outlined text-muted">account_circle</span>
                <h6 class="mb-0 fw-bold">تحديث البيانات الشخصية</h6>
            </div>
            
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row g-4">
                        <div class="col-12 mb-4 d-flex flex-column align-items-center">
                            <input type="file" id="avatar_upload" accept="image/*" class="d-none">
                            <input type="hidden" name="cropped_avatar" id="cropped_avatar">
                            
                            <div class="position-relative shadow-sm" id="avatar_preview_container" style="width: 120px; height: 120px; border-radius: 50%; overflow: hidden; cursor: pointer;">
                                @if($user->avatar)
                                    <img id="avatar_preview" src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <img id="avatar_preview" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=f1f5f9&color=64748b" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                                @endif
                                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center bg-dark bg-opacity-50 text-white opacity-0 transition-opacity" id="avatar_overlay" style="transition: opacity 0.2s;">
                                    <span class="material-symbols-outlined fs-3">edit</span>
                                </div>
                            </div>
                            <small class="text-muted mt-2">انقر لتغيير الصورة</small>
                            @error('avatar') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            @if(in_array($user->role->name, ['Admin', 'Mod']))
                                <label for="name" class="form-label fw-bold">الاسم <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            @else
                                <label for="name" class="form-label fw-bold text-muted">الاسم <span class="material-symbols-outlined fs-6 align-middle" title="لا يمكن تغييره">lock</span></label>
                                <input type="text" class="form-control bg-light" id="name" name="name" value="{{ $user->name }}" readonly disabled>
                            @endif
                        </div>

                        <div class="col-md-6">
                            @if(in_array($user->role->name, ['Admin', 'Mod']))
                                <label for="username" class="form-label fw-bold">اسم المستخدم (Username) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username', $user->username) }}" dir="ltr" required>
                                @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            @else
                                <label for="username" class="form-label fw-bold text-muted">اسم المستخدم (Username) <span class="material-symbols-outlined fs-6 align-middle" title="لا يمكن تغييره">lock</span></label>
                                <input type="text" class="form-control bg-light" id="username" name="username" value="{{ $user->username }}" dir="ltr" readonly disabled>
                            @endif
                        </div>

                        <div class="col-12 mt-4">
                            <hr>
                            <h6 class="fw-bold mb-3 text-primary"><span class="material-symbols-outlined fs-6 align-middle me-1">lock</span> تحديث كلمة المرور</h6>
                            <p class="text-muted small">اترك هذه الحقول فارغة إذا كنت لا ترغب في تغيير كلمة المرور الخاصة بك.</p>
                        </div>

                        <div class="col-md-12 mt-2">
                            <label for="current_password" class="form-label fw-bold">كلمة المرور الحالية</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" dir="ltr">
                            @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 mt-3">
                            <label for="new_password" class="form-label fw-bold">كلمة المرور الجديدة</label>
                            <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password" dir="ltr">
                            @error('new_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 mt-3">
                            <label for="new_password_confirmation" class="form-label fw-bold">تأكيد كلمة المرور الجديدة</label>
                            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" dir="ltr">
                        </div>

                        <div class="col-12 text-start mt-5 d-flex gap-2 justify-content-end">
                            <a href="{{ route('dashboard') }}" class="btn btn-light px-4 py-2 fw-bold text-muted border">إلغاء</a>
                            <button type="submit" class="btn btn-primary-custom px-5 py-2 fw-bold">حفظ الإعدادات</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Crop Modal -->
<div class="modal fade" id="cropModal" tabindex="-1" aria-labelledby="cropModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cropModalLabel">قص الصورة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-0 bg-light">
                <div style="max-height: 400px; width: 100%;">
                    <img id="image_to_crop" src="" style="max-width: 100%; display: block;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-primary-custom" id="crop_save_btn">حفظ وتجهيز للرفع</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let cropper;
        const avatarInput = document.getElementById('avatar_upload');
        const imageToCrop = document.getElementById('image_to_crop');
        const cropModalEl = document.getElementById('cropModal');
        const cropModal = new bootstrap.Modal(cropModalEl);
        
        document.getElementById('avatar_preview_container').addEventListener('click', function() {
            avatarInput.click();
        });

        avatarInput.addEventListener('change', function(e) {
            const files = e.target.files;
            if (files && files.length > 0) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    imageToCrop.src = event.target.result;
                    cropModal.show();
                };
                reader.readAsDataURL(files[0]);
            }
        });

        cropModalEl.addEventListener('shown.bs.modal', function () {
            cropper = new Cropper(imageToCrop, {
                aspectRatio: 1,
                viewMode: 1,
                autoCropArea: 1,
            });
        });

        cropModalEl.addEventListener('hidden.bs.modal', function () {
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
            avatarInput.value = ''; 
        });

        document.getElementById('crop_save_btn').addEventListener('click', function() {
            if (cropper) {
                const canvas = cropper.getCroppedCanvas({
                    width: 400,
                    height: 400,
                });
                const base64Image = canvas.toDataURL('image/jpeg');
                
                document.getElementById('avatar_preview').src = base64Image;
                document.getElementById('cropped_avatar').value = base64Image;
                
                cropModal.hide();
            }
        });
    });
</script>
@endpush
