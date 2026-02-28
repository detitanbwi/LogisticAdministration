@extends('back.layouts.app')

@section('title', 'Profile Details')

@section('page_title', 'Profile Details')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.profile.edit') }}">Profile Details</a></li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8 col-xl-6">
            <div class="card stretch stretch-full">
                <div class="card-header">
                    <h5 class="card-title">Update Profile Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4 text-center">
                            <div class="position-relative d-inline-block">
                                @if($user->photo)
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($user->photo) }}" id="avatar-preview"
                                        class="rounded-circle border border-2 border-primary"
                                        style="width: 120px; height: 120px; object-fit: cover;">
                                @else
                                    <div id="avatar-preview"
                                        class="avatar-text avatar-xl bg-soft-primary text-primary border border-2 border-primary rounded-circle d-flex align-items-center justify-content-center"
                                        style="width: 120px; height: 120px; font-size: 40px;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif
                                <label for="upload-photo"
                                    class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-2 cursor-pointer"
                                    style="cursor: pointer; transform: translate(25%, 25%);">
                                    <i class="feather-camera"></i>
                                </label>
                                <input type="file" id="upload-photo" class="d-none"
                                    accept="image/png, image/jpeg, image/jpg">
                                <input type="hidden" name="cropped_photo" id="cropped_photo">
                            </div>
                        </div>

                        <div class="mb-4">
                            <x-back.text-input label="Nama Lengkap" name="name" :value="$user->name" required />
                        </div>

                        <div class="mb-4">
                            <x-back.text-input type="email" label="Email Address" name="email" :value="$user->email"
                                required />
                        </div>

                        <div class="mb-4">
                            <x-back.text-input type="password" label="New Password (kosongkan jika tidak ingin merubah)"
                                name="password" />
                            <small class="text-muted">Minimum 8 characters</small>
                        </div>

                        <div class="mb-4">
                            <x-back.text-input type="password" label="Confirm New Password" name="password_confirmation" />
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="reset" class="btn btn-light">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('modals')
    <!-- Modal for Cropper -->
    <div class="modal fade" id="cropperModal" tabindex="-1" aria-labelledby="cropperModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cropperModalLabel">Crop Profile Picture</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div style="max-height: 400px; width: 100%; overflow: hidden;">
                        <img id="image-to-crop" src="" style="max-width: 100%;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="crop-btn">Crop & Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let cropper;
            const input = document.getElementById('upload-photo');
            const imageToCrop = document.getElementById('image-to-crop');
            const cropperModal = new bootstrap.Modal(document.getElementById('cropperModal'));

            input.addEventListener('change', function (e) {
                const files = e.target.files;
                if (files && files.length > 0) {
                    const reader = new FileReader();
                    reader.onload = function (event) {
                        imageToCrop.src = event.target.result;
                        cropperModal.show();
                    };
                    reader.readAsDataURL(files[0]);
                }
            });

            document.getElementById('cropperModal').addEventListener('shown.bs.modal', function () {
                cropper = new Cropper(imageToCrop, {
                    aspectRatio: 1,
                    viewMode: 2,
                    autoCropArea: 1,
                });
            });

            document.getElementById('cropperModal').addEventListener('hidden.bs.modal', function () {
                if (cropper) {
                    cropper.destroy();
                    cropper = null;
                }
                input.value = '';
            });

            document.getElementById('crop-btn').addEventListener('click', function () {
                if (cropper) {
                    const canvas = cropper.getCroppedCanvas({
                        width: 400,
                        height: 400,
                    });

                    const base64Canvas = canvas.toDataURL('image/jpeg');

                    document.getElementById('cropped_photo').value = base64Canvas;

                    const preview = document.getElementById('avatar-preview');
                    if (preview.tagName === 'IMG') {
                        preview.src = base64Canvas;
                    } else {
                        const newImg = document.createElement('img');
                        newImg.src = base64Canvas;
                        newImg.id = 'avatar-preview';
                        newImg.className = 'rounded-circle border border-2 border-primary';
                        newImg.style.width = '120px';
                        newImg.style.height = '120px';
                        newImg.style.objectFit = 'cover';
                        preview.parentNode.replaceChild(newImg, preview);
                    }

                    cropperModal.hide();
                }
            });
        });
    </script>
@endpush