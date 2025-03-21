@extends('superadmin.layout.index')
@section('content')
    <!-- Styles are unchanged -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');

        .d-flex {
            display: flex;
            align-items: center;
        }

        .justify-content-start {
            justify-content: flex-start;
        }

        .justify-content-end {
            justify-content: flex-end;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .icon-bell:before {
            content: "\f0f3";
            font-family: FontAwesome;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            background-color: #fff;
            margin-bottom: 2rem;
        }

        .card-header {
            background: linear-gradient(135deg, #6f42c1, #007bff);
            color: white;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            padding: 1.5rem;
        }

        .card-title {
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0;
        }

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

        .table-responsive {
            margin-top: 1rem;
        }

        .table {
            margin-bottom: 0;
        }

        .table th,
        .table td {
            padding: 1rem;
            vertical-align: middle;
        }

        .table th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }

        .btn-warning,
        .btn-danger,
        .btn-primary {
            border-radius: 20px;
            padding: 5px 15px;
            font-size: 14px;
            font-weight: bold;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .btn-warning:hover,
        .btn-danger:hover,
        .btn-primary:hover {
            transform: scale(1.05);
        }

        .page-header {
            margin-bottom: 2rem;
        }

        .table-hover tbody tr:hover {
            background-color: #e9ecef;
        }

        .dataTables_info,
        .dataTables_paginate {
            margin-top: 1rem;
        }

        .pagination .page-link {
            color: #007bff;
        }

        .pagination .page-item.active .page-link {
            background-color: #007bff;
            border-color: #007bff;
        }

        .pagination .page-item:hover .page-link {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .pagination .page-item.active .page-link,
        .pagination .page-item .page-link {
            transition: all 0.3s ease;
        }
    </style>
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" style="text-align: center; color:white">Danh sách khách hàng</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div id="basic-datatables_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                                <div class="row">
                                    <div class="row align-items-center">
                                        <div class="col-sm-12 col-md-6 d-flex justify-content-start">
                                            <button id="open-add-modal" type="button" class="btn btn-primary">
                                                Thêm khách hàng
                                            </button>
                                        </div>
                                        <div class="col-sm-12 col-md-6 d-flex justify-content-end">
                                            <form class="d-flex">
                                                <label class="mr-2" style="align-self: center;">Tìm kiếm:</label>
                                                <input id="search-query" type="text" name="phone"
                                                    class="form-control form-control-sm" placeholder="Nhập số điện thoại"
                                                    value="{{ old('phone') }}">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12" id="table-content">
                                        <!-- Load bảng user ban đầu từ view `table.blade.php` -->
                                        @include('superadmin.user.table', ['users' => $users])
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12" id="pagination-links">
                                        <!-- Load phân trang ban đầu -->
                                        {{ $users->links('vendor.pagination.custom') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal thêm khách hàng mới -->
    <div class="modal fade" id="addClientModal" tabindex="-1" aria-labelledby="addClientModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addClientModalLabel">Thêm khách hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="add-client-form">
                        @csrf
                        <!-- Họ tên -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Họ tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name">
<<<<<<< HEAD
                            <small id="name-error" class="text-danger"></small>
=======

                            <small id="name_error" class="text-danger error-text"></small>
>>>>>>> 0d6658eae0575da3f06b35dd224ccc62429babbf
                        </div>

                        <!-- Tiền tố -->
                        <div class="mb-3">
<<<<<<< HEAD
                            <label for="prefix" class="form-label">Tiền tố<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="prefix" name="prefix" maxlength="5">
                            <small id="prefix-error" class="text-danger"></small>
=======
                            <label for="name" class="form-label">Tên tài khoản <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="username" name="username">
                            <small id="username_error" class="text-danger error-text"></small>
                        </div>

                        <!-- Tiền tố -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Tiền tố <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="prefix" name="prefix" maxlength="5">
                            <small id="prefix_error" class="text-danger error-text"></small>
>>>>>>> 0d6658eae0575da3f06b35dd224ccc62429babbf
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
<<<<<<< HEAD
                            <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email">
                            <small id="email-error" class="text-danger"></small>
=======
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                            <small id="email_error" class="text-danger error-text"></small>
>>>>>>> 0d6658eae0575da3f06b35dd224ccc62429babbf
                        </div>

                        <!-- Số điện thoại -->
                        <div class="mb-3">
<<<<<<< HEAD
                            <label for="phone" class="form-label">Số điện thoại<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="phone" name="phone">
                            <small id="phone-error" class="text-danger"></small>
=======
                            <label for="phone" class="form-label">Số điện thoại <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="phone" name="phone">
                            <small id="phone_error" class="text-danger error-text"></small>
>>>>>>> 0d6658eae0575da3f06b35dd224ccc62429babbf
                        </div>

                        <!-- Địa chỉ -->
                        <div class="mb-3">
                            <label for="address" class="form-label">Địa chỉ <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="address" name="address">
                            <small id="address_error" class="text-danger error-text"></small>
                        </div>

                        <!-- Ngành nghề -->
                        <div class="mb-3">
                            <label for="field" class="form-label">Ngành nghề</label>
                            <input type="text" class="form-control" id="field" name="field">
                            <small id="field_error" class="text-danger error-text"></small>
                        </div>

                        <!-- Tên công ty -->
                        <div class="mb-3">
                            <label for="company_name" class="form-label">Tên công ty</label>
                            <input type="text" class="form-control" id="company_name" name="company_name">
                            <small id="company_name_error" class="text-danger error-text"></small>
                        </div>

                        <!-- Mã số thuế -->
                        <div class="mb-3">
                            <label for="tax_code" class="form-label">Mã số thuế</label>
                            <input type="text" class="form-control" id="tax_code" name="tax_code">
                            <small id="tax_code_error" class="text-danger error-text"></small>
                        </div>

                        <!-- Nạp tiền cho người dùng -->

                        <div class="mb-3">
                            <label for="wallet" class="form-label">Nạp tiền ví chính</label>
                            <input type="text" class="form-control" id="wallet" name="wallet">
                            <small id="wallet-error" class="text-danger"></small>
                        </div>
                        <div class="mb-3">
                            <label for="sub_wallet" class="form-label">Nạp tiền ví phụ</label>
                            <input type="text" class="form-control" id="sub_wallet" name="sub_wallet">
                            <small id="sub_wallet_error" class="text-danger error-text"></small>
                        </div>

                        {{-- Hạn sử dụng tài khoản --}}
                        <div class="mb-3">
                            <label for="expired_at" class="form-label">Hạn sử dụng</label>
                            <select name="expired_at" id="expired_at" class="form-select">
                                <option value="6">6 tháng</option>
                                <option value="12">12 tháng</option>
                                <option value="24">24 tháng</option>
                            </select>
                        </div>
                        <button type="submit" id="btn-submit-form-user" class="btn btn-primary">Xác nhận</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
<<<<<<< HEAD
    <div class="modal fade" id="editClientModal" tabindex="-1" aria-labelledby="editClientModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editClientModalLabel">Chỉnh sửa khách hàng khách hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-client-form">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit-client-id" name="id">
                        <!-- Họ tên -->
                        <div class="mb-3">
                            <label for="edit-name" class="form-label">Họ tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit-name" name="name">
                            <small id="edit-name-error" class="text-danger"></small>
                        </div>
                        <!-- Tiền tố -->
                        <div class="mb-3">
                            <label for="edit-prefix" class="form-label">Tiền tố<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit-prefix" name="prefix" maxlength="5">
                            <small id="edit-prefix-error" class="text-danger"></small>
=======

    {{-- modal edit người dùng start --}}
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        data-bs-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cập nhật khách hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit_user_form">
                        @csrf
                        <input type="hidden" name="user_id" id="user_id_edit">
                        <!-- Họ tên -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Họ tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nameEdit" name="name">
                            <small id="name_error" class="text-danger error-text"></small>
                        </div>

                        <!-- Tên tài khoản -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên tài khoản <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="usernameEdit" name="username">
                            <small id="username_error" class="text-danger error-text"></small>
                        </div>
                        <!-- Tiền tố -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Tiền tố <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="prefixEdit" name="prefix" maxlength="5">
                            <small id="prefix_error" class="text-danger error-text"></small>
>>>>>>> 0d6658eae0575da3f06b35dd224ccc62429babbf
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
<<<<<<< HEAD
                            <label for="edit-email" class="form-label">Email<span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="edit-email" name="email">
                            <small id="edit-email-error" class="text-danger"></small>
=======
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="emailEdit" name="email">
                            <small id="email_error" class="text-danger error-text"></small>
>>>>>>> 0d6658eae0575da3f06b35dd224ccc62429babbf
                        </div>

                        <!-- Số điện thoại -->
                        <div class="mb-3">
<<<<<<< HEAD
                            <label for="edit-phone" class="form-label">Số điện thoại<span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit-phone" name="phone">
                            <small id="phone-error" class="text-danger"></small>
=======
                            <label for="phone" class="form-label">Số điện thoại <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="phoneEdit" name="phone">
                            <small id="phone_error" class="text-danger error-text"></small>
>>>>>>> 0d6658eae0575da3f06b35dd224ccc62429babbf
                        </div>

                        <!-- Địa chỉ -->
                        <div class="mb-3">
<<<<<<< HEAD
                            <label for="edit-address" class="form-label">Địa chỉ <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit-address" name="address">
                            <small id="edit-address-error" class="text-danger"></small>
=======
                            <label for="address" class="form-label">Địa chỉ <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="addressEdit" name="address">
                            <small id="address_error" class="text-danger error-text"></small>
>>>>>>> 0d6658eae0575da3f06b35dd224ccc62429babbf
                        </div>

                        <!-- Ngành nghề -->
                        <div class="mb-3">
<<<<<<< HEAD
                            <label for="edit-field" class="form-label">Ngành nghề</label>
                            <input type="text" class="form-control" id="edit-field" name="field">
                            <small id="edit-field-error" class="text-danger"></small>
=======
                            <label for="field" class="form-label">Ngành nghề</label>
                            <input type="text" class="form-control" id="fieldEdit" name="field">
                            <small id="field_error" class="text-danger error-text"></small>
>>>>>>> 0d6658eae0575da3f06b35dd224ccc62429babbf
                        </div>

                        <!-- Tên công ty -->
                        <div class="mb-3">
<<<<<<< HEAD
                            <label for="edit-company_name" class="form-label">Tên công ty</label>
                            <input type="text" class="form-control" id="edit-company_name" name="company_name">
                            <small id="edit-company_name-error" class="text-danger"></small>
=======
                            <label for="company_name" class="form-label">Tên công ty</label>
                            <input type="text" class="form-control" id="company_nameEdit" name="company_name">
                            <small id="company_name_error" class="text-danger error-text"></small>
>>>>>>> 0d6658eae0575da3f06b35dd224ccc62429babbf
                        </div>

                        <!-- Mã số thuế -->
                        <div class="mb-3">
<<<<<<< HEAD
                            <label for="edit-tax_code" class="form-label">Mã số thuế</label>
                            <input type="text" class="form-control" id="edit-tax_code" name="tax_code">
                            <small id="edit-tax_code-error" class="text-danger"></small>
                        </div>

                        <!-- Nạp tiền cho người dùng -->

                        <div class="mb-3">
                            <label for="edit-wallet" class="form-label">Nạp tiền ví chính</label>
                            <input type="text" class="form-control" id="edit-wallet" name="wallet">
                            <small id="edit-wallet-error" class="text-danger"></small>
                        </div>
                        <div class="mb-3">
                            <label for="edit-sub_wallet" class="form-label">Nạp tiền ví phụ</label>
                            <input type="text" class="form-control" id="edit-sub_wallet" name="sub_wallet">
                            <small id="edit-sub_wallet-error" class="text-danger"></small>
                        </div>
                        <button type="submit" class="btn btn-primary">Xác nhận</button>
                    </form>

=======
                            <label for="tax_code" class="form-label">Mã số thuế</label>
                            <input type="text" class="form-control" id="tax_codeEdit" name="tax_code">
                            <small id="tax_code_error" class="text-danger error-text"></small>
                        </div>
                        <div class="mb-3">
                            <label for="expired_at" class="form-label">Hạn sử dụng</label>
                            <select name="expired_at" id="expired_atEdit" class="form-select">
                                <option value="6">6 tháng</option>
                                <option value="12">12 tháng</option>
                                <option value="24">24 tháng</option>
                            </select>
                        </div>
                        <button type="submit" id="edit_user_btn" class="btn btn-primary">Cập nhật</button>
                    </form>
>>>>>>> 0d6658eae0575da3f06b35dd224ccc62429babbf
                </div>
            </div>
        </div>
    </div>
<<<<<<< HEAD
=======
    {{-- modal edit người dùng end --}}
>>>>>>> 0d6658eae0575da3f06b35dd224ccc62429babbf
    <div class="modal fade" id="clientModal" tabindex="-1" role="dialog" aria-labelledby="clientModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="clientModalLabel">Thông tin khách hàng</h5>
                </div>
                <div class="modal-body">
                    <p><strong>Họ và tên:</strong> <span id="client-name"></span></p>
                    <p><strong>Tên tài khoản:</strong> <span id="client-username"></span></p>
                    <p><strong>Số điện thoại:</strong> <span id="client-phone"></span></p>
                    <p><strong>Tên công ty:</strong> <span id="client-company"></span></p>
                    <p><strong>Ngành nghề:</strong> <span id="client-field"></span></p>
                    <p><strong>Email:</strong> <span id="client-email"></span></p>
                    <p><strong>Địa chỉ:</strong> <span id="client-address"></span></p>
                    <p><strong>Mã số thuế:</strong> <span id="client-tax-number"></span></p>
                    <p><strong>Ví chính:</strong><span id="client-wallet"></span></p>
                    <p><strong>Ví phụ:</strong><span id="client-sub-wallet"></span></p>
                    <p><strong>Tiền tố:</strong><span id="client-prefix"></span></p>
                </div>
            </div>
        </div>
    </div>
    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-notify/0.2.0/js/bootstrap-notify.min.js"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('click', '.delete-user-btn', function() {
                let userId = $(this).data('id'); // Lấy ID của người dùng từ thuộc tính data-id
                let deleteUrl = "{{ route('super.user.delete', ':id') }}";
                deleteUrl = deleteUrl.replace(':id', userId); // URL API xóa người dùng

                if (confirm('Bạn có chắc chắn muốn xóa người dùng này không?')) {
                    $.ajax({
                        url: deleteUrl, // URL API
                        type: 'DELETE', // Phương thức HTTP
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Thành công',
                                    text: response.success,
                                });
                                // Cập nhật bảng người dùng
                                $('#table-content').html(response.html);
                                $('#pagination-links').html(response.pagination);
                            } else {
                                console.log('Response failed:', response);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Lỗi!',
                                    text: response.message ||
                                        'Có lỗi xảy ra, vui lòng thử lại',
                                });
                            }
                        },
                        error: function(xhr) {
                            let errorMessage = "Có lỗi xảy ra, vui lòng thử lại sau.";
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi!',
                                text: errorMessage,
                            });
                            console.error('AJAX Error:', xhr);
                        }
                    });
                }
            });

            //mở modal sửa thông tin người dùng
            $(document).on('click', '.open-edit-modal', function() {
                let clientId = $(this).data('id');
                let url = "{{ route('super.user.detail', ':id') }}";
                url = url.replace(':id', clientId);

                $.get(url, function(data) {
                    $('#edit-client-id').val(data.id);
                    $('#edit-name').val(data.name);
                    $('#edit-username').val(data.username);
                    $('#edit-prefix').val(data.prefix);
                    $('#edit-email').val(data.email);
                    $('#edit-phone').val(data.phone);
                    $('#edit-address').val(data.address);
                    $('#edit-field').val(data.field);
                    $('#edit-company_name').val(data.company_name);
                    $('#edit-tax_number').val(data.tax_number);
                    $('#edit-wallet').val(data.wallet);
                    $('#edit-sub_wallet').val(data.sub_wallet);

                    $('#editClientModal').modal('show');
                });
            });

            //Chỉnh sửa khách hàng
            $('#edit-client-form').on('submit', function(e) {
                e.preventDefault();
                let clientId = $('#edit-client-id').val();
                let url = "{{ route('super.user.update', ':id') }}";
                url = url.replace(':id', clientId);
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success) {
                            $('#editClientModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công',
                                text: response.success,
                            });
                            $('#table-content').html(response.html);
                            $('#pagination-links').html(response.pagination);
                        } else {
                            console.log('Response failed:', response);
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi!',
                                text: response.message ||
                                    'Có lỗi xảy ra, vui lòng thử lại',
                            });
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = "Có lỗi xảy ra, vui lòng thử lại sau.";
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: errorMessage,
                        });
                        console.error('AJAX Error:', xhr);
                    }
                });
            });

            $('#wallet').on('input', function() {
                let value = $(this).val();

                // Loại bỏ các ký tự không phải số
                value = value.replace(/[^\d]/g, '');

                // Định dạng số với dấu phẩy
                if (value) {
                    $(this).val(Number(value).toLocaleString());
                } else {
                    $(this).val(''); // Nếu không có giá trị, đặt lại ô input
                }
            });
            $('#sub_wallet').on('input', function() {
                let value = $(this).val();

                // Loại bỏ các ký tự không phải số
                value = value.replace(/[^\d]/g, '');

                // Định dạng số với dấu phẩy
                if (value) {
                    $(this).val(Number(value).toLocaleString());
                } else {
                    $(this).val(''); // Nếu không có giá trị, đặt lại ô input
                }
            });

            $('#prefix').on('input', function() {
                let value = $(this).val().toUpperCase();
                $(this).val(value);
            });

<<<<<<< HEAD
            $('#edit-prefix').on('input', function() {
                let value = $(this).val().toUpperCase();
                $(this).val(value);
            });

=======
>>>>>>> 0d6658eae0575da3f06b35dd224ccc62429babbf

            // Mở modal thêm khách hàng
            $('#open-add-modal').on('click', function() {
                $('#add-client-form')[0].reset();
                $('.invalid-feedback').hide();
                $('#addClientModal').modal('show');
            });

            // Thêm khách hàng mới
            $('#add-client-form').on('submit', function(e) {
                e.preventDefault();

<<<<<<< HEAD
=======
                // Xóa thông báo lỗi trước đó (nếu có)
                $('small.text-danger').text('');
                $('#btn-submit-form-user').text('Đang thêm...')
                $('#btn-submit-form-user').prop('disabled', true);
>>>>>>> 0d6658eae0575da3f06b35dd224ccc62429babbf
                $.ajax({
                    url: "{{ route('super.user.store') }}",
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success) {
                            $('#addClientModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công',
                                text: response.success,
                            });
                            $('#table-content').html(response.html);
                            $('#pagination-links').html(response.pagination);
<<<<<<< HEAD
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) { // Lỗi Validation
                            const errors = xhr.responseJSON.errors;

                            // Xóa thông báo lỗi cũ
                            $('small.text-danger').text('');

                            // Hiển thị lỗi dưới mỗi input
                            $.each(errors, function(key, value) {
                                $('#' + key + '-error').text(value[0]);
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi Server',
                                text: xhr.responseJSON?.message ||
                                    'Có lỗi xảy ra, vui lòng thử lại.',
                            });
=======
                            $('#btn-submit-form-user').text('Thêm')
                            $('#btn-submit-form-user').prop('disabled', false);
                        } else if (response.error) {
                            printErrorMsg(response.validation_errors);
>>>>>>> 0d6658eae0575da3f06b35dd224ccc62429babbf
                        }
                    }
                });
            });


            // Hiển thị thông tin khách hàng trong modal.
            $(document).on('click', '#user-detail', function(e) {
                e.preventDefault();
                const clientId = $(this).data('id');

                fetch(`/super-admin/user/detail/${clientId}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('client-name').textContent = data.name || '';
                        document.getElementById('client-username').textContent = data.username || '';
                        document.getElementById('client-phone').textContent = data.phone || '';
                        document.getElementById('client-company').textContent = data.company_name ||
                            'Chưa có công ty';
                        document.getElementById('client-field').textContent = data.field ||
                            'Chưa có ngành nghề';
                        document.getElementById('client-email').textContent = data.email ||
                            'Chưa có email';
                        document.getElementById('client-address').textContent = data.address || '';
                        document.getElementById('client-tax-number').textContent = data.tax_number ||
                            'Chưa có mã số thuế';
                        document.getElementById('client-wallet').textContent = data.wallet ||
                            'Chưa nạp tiền ví chính';
                        document.getElementById('client-sub-wallet').textContent = data.sub_wallet ||
                            'Chưa nạp tiền ví phụ';
                        document.getElementById('client-prefix').textContent = data.prefix ||
                            'Chưa có tiền tố';

                        $('#clientModal').modal('show');
                    });
            });

            // Ngăn chặn việc form gửi tự động khi nhấn Enter
            $('#search-query').on('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault(); // Ngăn chặn hành động submit form mặc định
                    updateTableAndPagination(); // Gọi hàm AJAX để cập nhật bảng và phân trang
                }
            });

            // Cập nhật bảng và phân trang khi tìm kiếm
            function updateTableAndPagination() {
                let query = $('#search-query').val();
                $.ajax({
                    url: "{{ route('super.user.search') }}", // URL tìm kiếm
                    type: 'GET',
                    data: {
                        query: query
                    },
                    success: function(response) {
                        // Cập nhật nội dung bảng và phân trang
                        $('#table-content').html(response.html);
                        $('#pagination-links').html(response.pagination);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            }

            // Xử lý sự kiện click vào liên kết phân trang
            $(document).on('click', '#pagination-links a', function(e) {
                e.preventDefault();
                let url = $(this).attr('href'); // Lấy URL của trang phân trang
                let query = $('#search-query').val(); // Lấy giá trị tìm kiếm hiện tại
                let newUrl = url + (url.includes('?') ? '&' : '?') + 'query=' + encodeURIComponent(query);

                $.ajax({
                    url: newUrl, // Gửi yêu cầu AJAX với URL đã điều chỉnh
                    type: 'GET',
                    success: function(response) {
                        // Cập nhật nội dung bảng và phân trang
                        $('#table-content').html(response.html);
                        $('#pagination-links').html(response.pagination);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });
            //Sửa người dùng
            $(document).on('click', '.editUserIcon', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                $.ajax({
                    url: '{{ route('super.user.edit') }}',
                    method: 'GET',
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#nameEdit').val(response.user.name)
                        $('#usernameEdit').val(response.user.username)
                        $('#prefixEdit').val(response.user.prefix)
                        $('#emailEdit').val(response.user.email)
                        $('#phoneEdit').val(response.user.phone)
                        $('#addressEdit').val(response.user.address)
                        $('#company_nameEdit').val(response.user.company_name)
                        $('#fieldEdit').val(response.user.field)
                        $('#tax_codeEdit').val(response.user.tax_code)
                        $('#sub_walletEdit').val(response.user.sub_wallet)
                        $('#user_id_edit').val(response.user.id)
                        $('#expired_atEdit option').each(function() {
                            if ($(this).val() == response.months) {
                                $(this).prop('selected', true);
                            } else {
                                $(this).prop('selected', false);
                            }
                        });
                    }
                })
            })
            //Cập nhật người dùng
            $('#edit_user_btn').click(function(e) {
                e.preventDefault();
                var formData = new FormData($('#edit_user_form')[0]);
                $('#edit_user_btn').text('Đang cập nhật...')
                $('#edit_user_btn').prop('disabled', true);
                $.ajax({
                    url: '{{ route('super.user.update') }}',
                    method: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công!',
                                text: response.success,
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                $("#edit_user_form")[0].reset();
                                $("#editUserModal").modal('hide');
                                $('#edit_user_btn').text('Cập nhật')
                                $('#edit_user_btn').prop('disabled', false);
                                $('#table-content').html(response.html);
                                $('#pagination-links').html(response.pagination);
                            });
                        } else if (response.error) {
                            if (response.validation_errors) {
                                printErrorMsg(response.validation_errors);
                            } else if (response.api_errors) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Lỗi cập nhật',
                                    text: response.api_errors,
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                            }

                        }
                    }
                })
            })
            //Xóa người dùng
            $('.deleteUserButton').click(function(e) {
                e.preventDefault()
                let id = $(this).attr('id');
                Swal.fire({
                    title: 'Bạn chắc chắn chứ',
                    text: "Bạn sẽ không thể hoàn tác điều này!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Đúng, xóa nó đi!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('super.user.delete') }}',
                            method: 'delete',
                            data: {
                                id: id,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire(
                                        'Đã xóa',
                                        response.success,
                                        'success'
                                    )
                                    $('#table-content').html(response.html);
                                    $('#pagination-links').html(response.pagination);
                                } else if (response.error) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Xóa thất bại',
                                        text: data.error,
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                }


                            }
                        })
                    }

                })
            })
            //validate form
            function printErrorMsg(msg) {
                $('.error-text').text('')
                $.each(msg, function(key, value) {
                    $('#' + key + '_error').text(value[0])
                })
            }



        })
    </script>
@endsection
