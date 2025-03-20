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
                        <h4 class="card-title" style="text-align: center; color:white">Danh sách Zalo OA</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div id="basic-datatables_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                                <div class="row">
                                    <div class="row align-items-center">
                                        <div class="col-sm-12 col-md-6 d-flex justify-content-start">
                                        </div>
                                        <div class="col-sm-12 col-md-6 d-flex justify-content-end">
                                            <form class="form-inline">
                                                <label class="mr-2" style="align-self: center">Tìm kiếm: </label>
                                                <input style="width: 170px" id="zalo-search-query" type="text"
                                                    name="query" class="form-control form-control-sm"
                                                    placeholder="Nhập OA ID hoặc tên OA" value="{{ old('query') }}">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12" id="table-content">
                                        <!-- Load bảng zaloOa ban đầu từ view `table.blade.php` -->
                                        @include('superadmin.zalo.table', ['zaloOas' => $zaloOas])
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12" id="pagination-links">
                                        <!-- Load phân trang ban đầu -->
                                        {{ $zaloOas->links('pagination::custom') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="clientModal" tabindex="-1" role="dialog" aria-labelledby="clientModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="clientModalLabel">Thông tin khách hàng</h5>
                </div>
                <div class="modal-body">
                    <p><strong>Họ và tên:</strong> <span id="client-name"></span></p>
                    <p><strong>Tên tài khoản:</strong> <span id="client-zaloOaname"></span></p>
                    <p><strong>Số điện thoại:</strong> <span id="client-phone"></span></p>
                    <p><strong>Tên công ty:</strong> <span id="client-company"></span></p>
                    <p><strong>Ngành nghề:</strong> <span id="client-field"></span></p>
                    <p><strong>Email:</strong> <span id="client-email"></span></p>
                    <p><strong>Địa chỉ:</strong> <span id="client-address"></span></p>
                    <p><strong>Mã số thuế:</strong> <span id="client-tax-number"></span></p>
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


            // Hiển thị thông tin khách hàng trong modal.
            $(document).on('click', '#user-detail', function(e) {
                e.preventDefault();
                const clientId = $(this).data('id');

                fetch(`/super-admin/user/detail/${clientId}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('client-name').textContent = data.name || '';
                        document.getElementById('client-username').textContent = data.zaloOaname ||
                            '';
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

                        $('#clientModal').modal('show');
                    });
            });

            // Ngăn chặn form gửi tự động khi nhấn Enter
            // Ngăn chặn form gửi tự động khi nhấn Enter
            $('#zalo-search-query').on('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault(); // Ngăn chặn hành động submit form mặc định
                    updateTableAndPagination(); // Gọi hàm AJAX để cập nhật bảng và phân trang
                }
            });

            // Cập nhật bảng và phân trang khi tìm kiếm
            function updateTableAndPagination(page = 1) {
                let query = $('#zalo-search-query').val().trim(); // Loại bỏ khoảng trắng đầu/cuối

                $.ajax({
                    url: "{{ route('super.zalo.search') }}", // URL tìm kiếm
                    type: 'GET',
                    data: {
                        query: query,
                        page: page // Gửi thêm tham số trang để có thể phân trang
                    },
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest' // Đảm bảo backend nhận diện AJAX
                    },
                    beforeSend: function() {
                        $('#table-content').html('<p>Đang tải...</p>'); // Hiển thị trạng thái loading
                    },
                    success: function(response) {
                        console.log('Response:', response); // Kiểm tra response trả về

                        if (response.html) {
                            $('#table-content').html(response.html); // Cập nhật bảng
                        }
                        if (response.pagination) {
                            console.log('Pagination:', response.pagination); // Kiểm tra pagination
                            $('#pagination-links').html(response.pagination); // Cập nhật pagination
                        } else {
                            console.warn('Pagination rỗng:', response.pagination);
                        }
                    },

                    error: function(xhr) {
                        console.error('Lỗi AJAX:', xhr.responseText);
                        $('#table-content').html(
                            '<p class="text-danger">Có lỗi xảy ra khi tìm kiếm.</p>');
                    }
                });

            }

            // Xử lý click phân trang
            $(document).on('click', '#pagination-links a', function(e) {
                e.preventDefault();
                let url = $(this).attr('href'); // Lấy URL từ liên kết phân trang
                let query = $('#zalo-search-query').val(); // Lấy giá trị tìm kiếm (nếu có)

                // Thêm tham số query vào URL nếu chưa có
                let newUrl = url + (url.includes('?') ? '&' : '?') + 'query=' + encodeURIComponent(query ||
                    '');

                $.ajax({
                    url: newUrl,
                    type: 'GET',
                    success: function(response) {
                        if (response.html && response.pagination) {
                            // Cập nhật bảng và phân trang
                            $('#table-content').html(response.html);
                            $('#pagination-links').html(response.pagination);
                        } else {
                            console.error('Lỗi: Dữ liệu phản hồi không hợp lệ.');
                        }
                    },
                    error: function(xhr) {
                        console.error('Lỗi AJAX:', xhr.responseText);
                    }
                });
            });
        })
    </script>
@endsection
