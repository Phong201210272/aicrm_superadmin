@extends('superadmin.layout.index')
@section('content')
    <style>
        .breadcrumbs {
            background: #fff;
            padding: 0.75rem;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .breadcrumbs a {
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
        }

        .breadcrumbs i {
            color: #6c757d;
        }

        .card {
            border-radius: 15px;
            overflow: hidden;
        }

        .card-header {
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            background: linear-gradient(135deg, #6f42c1, #007bff);
        }

        .card-body {
            padding: 2rem;
            background-color: #f8f9fa;
        }

        .table th,
        .table td {
            vertical-align: middle;
            padding: 1rem;
            font-size: 1rem;
        }

        .table th {
            background-color: #e9ecef;
            font-weight: bold;
            color: #495057;
        }

        .table-hover tbody tr:hover {
            background-color: #dee2e6;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
            transform: translateY(-2px);
        }

        .text-primary {
            color: #007bff !important;
        }

        .nowrap {
            white-space: nowrap;
            display: flex;
            justify-content: space-between;
        }

        /* Custom styles for form decoration */
        .form-group {
            position: relative !important;
            margin-bottom: 1.5rem !important;
        }

        .form-control {
            border-radius: 10px !important;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1) !important;
            padding: 10px 15px !important;
            transition: all 0.3s ease-in-out !important;
        }

        .form-control:focus {
            box-shadow: 0 0 5px rgba(81, 203, 238, 1) !important;
            border-color: rgba(81, 203, 238, 1) !important;
        }

        .form-label {
            font-weight: bold !important;
            color: #333 !important;
            margin-bottom: 0.5rem !important;
        }

        .custom-file-input {
            display: none !important;
        }

        .custom-file-label {
            border-radius: 10px !important;
            background: #f8f9fa !important;
            padding: 10px 15px !important;
            cursor: pointer !important;
            transition: all 0.3s ease-in-out !important;
        }

        .custom-file-label:hover {
            background: #e2e6ea !important;
        }

        .btn-primary {
            background-color: #007bff !important;
            border-color: #007bff !important;
            border-radius: 10px !important;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1) !important;
            transition: all 0.3s ease-in-out !important;
        }

        .btn-primary:hover {
            background-color: #0056b3 !important;
            border-color: #004085 !important;
            transform: translateY(-2px) !important;
        }

        .avatar {
            width: 75px !important;
            height: 75px !important;
            border-radius: 50% !important;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1) !important;
        }

        /* Custom styles for modals */
        .modal-content {
            border-radius: 15px !important;
            overflow: hidden !important;
        }

        .modal-header {
            background-color: #007bff !important;
            color: white !important;
        }

        .modal-header .btn-close {
            color: white !important;
        }

        .modal-body {
            padding: 2rem !important;
        }

        /* Success and error message styling */
        .alert {
            transition: all 0.3s ease-in-out !important;
            margin-top: 1rem !important;
        }
    </style>
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center" style="color:white">Thông tin Super Admin</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('super.update', ['id' => $sa->id]) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
<<<<<<< HEAD
                                <div class="form-group col-lg-3">
=======
                                <div class="form-group col-lg-4">
>>>>>>> 0d6658eae0575da3f06b35dd224ccc62429babbf
                                    <label for="name" class="form-label">Tên</label>
                                    <input id="name" class="form-control @error('name') is-invalid @enderror"
                                        name="name" type="text" value="{{ old('name', $sa->name) }}">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
<<<<<<< HEAD

                                <div class="form-group col-lg-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input id="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" type="email" value="{{ old('email', $sa->email) }}">
                                    @error('email')
=======
                                <div class="form-group col-lg-4">
                                    <label for="email" class="form-label">Email</label>
                                    <input id="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" type="email" value="{{ old('email', $sa->email) }}">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="phone" class="form-label">Số điện thoại</label>
                                    <input id="phone" class="form-control @error('phone') is-invalid @enderror"
                                        name="phone" type="text" value="{{ old('phone', $sa->phone) }}">
                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>      
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <label for="bank_name" class="form-label">Ngân hàng</label>
                                    <select name="bank_id" id="bank" class="form-control">
                                        <option value="">-------- Chọn ngân hàng --------</option>
                                        @foreach ($bank as $item)
                                            <option @selected($sa->bank_id == $item->id) value="{{ $item->id }}">
                                                {{ $item->shortName . ' - ' . $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-lg-6">
                                    <label for="bank_account" class="form-label">Số tài khoản</label>
                                    <input id="bank_account"
                                        class="form-control @error('bank_account') is-invalid @enderror" name="bank_account"
                                        type="text"
                                        value="{{ old('bank_account', isset($sa) ? $sa->bank_account : '') }}">
                                    @error('bank_account')
>>>>>>> 0d6658eae0575da3f06b35dd224ccc62429babbf
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
<<<<<<< HEAD

                                <div class="form-group col-lg-3">
                                    <label for="phone" class="form-label">Số điện thoại</label>
                                    <input id="phone" class="form-control @error('phone') is-invalid @enderror"
                                        name="phone" type="text" value="{{ old('phone', $sa->phone) }}">
                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-3">
                                    <label for="phone" class="form-label">Tên công ty</label>
                                    <input id="company_name" class="form-control @error('company_name') is-invalid @enderror"
                                        name="company_name" type="text" value="{{ old('company_name', $sa->company_name) }}">
                                    @error('company_name')
=======
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <label for="bank_company_id" class="form-label">Ngân hàng</label>
                                    <select name="bank_company_id" id="bank" class="form-control">
                                        <option value="">-------- Chọn ngân hàng --------</option>
                                        @foreach ($bank as $item)
                                            <option @selected($sa->bank_company_id == $item->id) value="{{ $item->id }}">
                                                {{ $item->shortName . ' - ' . $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-lg-6">
                                    <label for="bank_company_account" class="form-label">Số tài khoản công ty</label>
                                    <input id="bank_company_account"
                                        class="form-control @error('bank_company_account') is-invalid @enderror" name="bank_company_account"
                                        type="text"
                                        value="{{ old('bank_company_account', isset($sa) ? $sa->bank_company_account : '') }}">
                                    @error('bank_company_account')
>>>>>>> 0d6658eae0575da3f06b35dd224ccc62429babbf
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
<<<<<<< HEAD

                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <label for="bank_name" class="form-label">Ngân hàng</label>
                                    <select name="bank_id" id="bank" class="form-control">
                                        <option value="">-------- Chọn ngân hàng --------</option>
                                        @foreach ($bank as $item)
                                            <option @selected($sa->bank_id == $item->id) value="{{ $item->id }}">
                                                {{ $item->shortName . ' - ' . $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-lg-6">
                                    <label for="bank_account" class="form-label">Số tài khoản</label>
                                    <input id="bank_account"
                                        class="form-control @error('bank_account') is-invalid @enderror" name="bank_account"
                                        type="text" value="{{ old('bank_account', $sa->bank_account) }}">
                                    @error('bank_account')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <label for="company_bank_id" class="form-label">Ngân hàng công ty</label>
                                    <select name="company_bank_id" id="company_bank" class="form-control">
                                        <option value="">-------- Chọn ngân hàng --------</option>
                                        @foreach ($bank as $item)
                                            <option @selected($sa->company_bank_id == $item->id) value="{{ $item->id }}">
                                                {{ $item->shortName . ' - ' . $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-lg-6">
                                    <label for="company_bank_account" class="form-label">Số tài khoản công ty</label>
                                    <input id="company_bank_account"
                                        class="form-control @error('company_bank_account') is-invalid @enderror"
                                        name="company_bank_account" type="text"
                                        value="{{ old('company_bank_account', $sa->company_bank_account) }}">
                                    @error('company_bank_account')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group mb-3">
                                    <label for="banner" class="form-label">Banner</label>
                                    <div class="input-images pb-3"></div>
                                </div>
                            </div>

=======
>>>>>>> 0d6658eae0575da3f06b35dd224ccc62429babbf
                            <div class="row">
                                <div class="col-lg-12 d-flex justify-content-between">
                                    <div>
                                        <button type="submit" class="btn btn-primary w-md">
                                            <i class="fas fa-check-circle"></i> Xác nhận
                                        </button>
                                        <button type="button" class="btn btn-primary w-md ms-2" data-bs-toggle="modal"
                                            data-bs-target="#changePasswordModal">
                                            <i class="fas fa-key"></i> Đổi mật khẩu
                                        </button>
                                    </div>
                                    <div>
                                        <form id="logoutForm" action="{{ route('super.logout') }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>
                                        <button class="btn btn-danger w-md"
                                            onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                                            <i class="fas fa-sign-out-alt"></i> Đăng xuất
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">Đổi mật khẩu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
<<<<<<< HEAD
                    <form method="POST" action="{{ route('super.update', ['id' => $sa->id]) }}"
                        enctype="multipart/form-data">
=======
                    <form id="changePasswordForm" action="" method="POST">
>>>>>>> 0d6658eae0575da3f06b35dd224ccc62429babbf
                        @csrf
                        @method('PUT') <!-- Sử dụng phương thức PUT nếu bạn đang cập nhật thông tin -->

                        <!-- Tên người quản trị -->
                        <div>
                            <label for="name">Tên</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $sa->name) }}"
                                required>
                            @error('name')
                                <div>{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email người quản trị -->
                        <div>
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $sa->email) }}"
                                required>
                            @error('email')
                                <div>{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Số điện thoại -->
                        <div>
                            <label for="phone">Số điện thoại</label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone', $sa->phone) }}"
                                required>
                            @error('phone')
                                <div>{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Số tài khoản ngân hàng -->
                        <div>
                            <label for="bank_account">Số tài khoản ngân hàng</label>
                            <input type="text" id="bank_account" name="bank_account"
                                value="{{ old('bank_account', $sa->bank_account) }}">
                        </div>

                        <!-- Tài khoản công ty -->
                        <div>
                            <label for="company_bank_account">Số tài khoản công ty</label>
                            <input type="text" id="company_bank_account" name="company_bank_account"
                                value="{{ old('company_bank_account', $sa->company_bank_account) }}">
                        </div>

                        <!-- Banners -->
                        <div>
                            <label for="banner">Banners</label>
                            <input type="file" id="banner" name="banner[]" multiple>
                            @error('banner')
                                <div>{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit button -->
                        <div>
                            <button type="submit">Cập nhật</button>
                        </div>
                    </form>

                    <!-- Display Server-Side Messages -->
                    <div id="changePasswordMessage"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            const preloaded = @json($banner);
            console.log(preloaded);
            $('.input-images').imageUploader({
                preloaded: preloaded, // Nếu có ảnh đã tải lên trước
                imagesInputName: 'banner', // Đảm bảo sử dụng đúng name của input
                preloadedInputName: 'old', // Input để xử lý ảnh cũ
                maxSize: 2 * 1024 * 1024, // Kích thước ảnh tối đa 2MB
                maxFiles: 15, // Số lượng ảnh tối đa
            });
            $('#changePasswordForm').submit(function(event) {
                event.preventDefault(); // Prevent default form submission

                var formData = $(this).serialize(); // Serialize form data

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#changePasswordMessage').html(
                                '<div class="alert alert-success mt-3">' + response
                                .message + '</div>');
                        } else {
                            $('#changePasswordMessage').html(
                                '<div class="alert alert-danger mt-3">' + response.message +
                                '</div>');
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr);
                        $('#changePasswordMessage').html(
                            '<div class="alert alert-danger mt-3">Đã xảy ra lỗi trong quá trình xử lý. Vui lòng thử lại sau.</div>'
                        );
                    },
                    complete: function() {
                        $('#changePasswordModal').modal('show');
                    }
                });
            });

            $('#img_url').change(function() {
                var fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });
        });
    </script>
    @if (session('success'))
        <script>
            $(document).ready(function() {
                $.notify({
                    icon: 'icon-bell',
                    title: 'Thông báo',
                    message: '{{ session('success') }}',
                }, {
                    type: 'secondary',
                    placement: {
                        from: "bottom",
                        align: "right"
                    },
                    time: 1000,
                });
            });
        </script>
    @endif
@endsection
