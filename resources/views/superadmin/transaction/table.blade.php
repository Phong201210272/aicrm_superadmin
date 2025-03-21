<div class="table-responsive">
    <table id="basic-datatables" class="table display table-striped table-hover">
        <thead>
            <tr>
                <th>STT</th>
                <th>Người gửi</th>
                <th>Số tiền</th>
                <th>Nội dung chuyển khoản</th>
                <th>Ngày gửi</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @if ($transactions && $transactions->count() > 0)
                @foreach ($transactions as $key => $value)
                    @if (is_object($value))
                        <tr>
                            <td>{{ ($transactions->currentPage() - 1) * $transactions->perPage() + $loop->index + 1 }}
                            </td>
                            <td>{{ $value->user->name ?? '' }}</td>
                            <td>{{ number_format($value->amount) ?? '' }}</td>
                            <td>{{ $value->description ?? '' }}</td>
                            <td>{{ $value->created_at ?? '' }}</td>
                            <td>
                                @if ($value->status == 1)
                                    <span class="badge bg-secondary">Đang chờ</span>
                                @elseif ($value->status == 2)
                                    <span class="badge bg-danger">Đã từ chối</span>
                                @else
                                    <span class="badge bg-success">Đã xác nhận</span>
                                @endif
                            </td>
                            <td>
                                @if ($value->status == 1)
                                    <a href="javascript:void(0)" class="btn btn-success confirm-transaction"
                                        data-id="{{ $value->id }}">Xác nhận</a>
                                    <a href="javascript:void(0)" class="btn btn-danger reject-transaction"
                                        data-id="{{ $value->id }}">Từ chối</a>
                                @endif
                            </td>
                        </tr>
                    @endif
                @endforeach
            @else
                <tr>
                    <td class="text-center" colspan="7">Chưa có giao dịch</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
