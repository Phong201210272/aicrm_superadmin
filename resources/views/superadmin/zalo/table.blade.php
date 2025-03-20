<table id="basic-datatables" class="display table table-striped table-hover dataTable" role="grid"
    aria-describedby="basic-datatables_info">
    <thead>
        <tr>
            <th>STT</th>
            <th>Mã Oa</th>
            <th>Tên Oa</th>
            <th>Chủ sở hữu</th>
            <th style="width: 10%">Số điện thoại</th>
            <th style="width: 10%; text-align:center">Số tin nhắn đã gửi</th>
        </tr>
    </thead>
    <tbody>
        @if ($zaloOas && $zaloOas->count() > 0)
            @foreach ($zaloOas as $key => $value)
                <tr>
                    <td>{{ ($zaloOas->currentPage() - 1) * $zaloOas->perPage() + $loop->index + 1 }}</td>
                    <td>{{ $value->oa_id ?? '' }}</td>
                    <td>{{ $value->name ?? '' }}</td>
                    <td>{{ $value->user->name ?? '' }}</td>
                    <td>{{ $value->user->phone ?? '' }}</td>
                    <td style="text-align: center">{{ $value->message_count ?? '' }}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td class="text-center" colspan="6">
                    <div class="">
                        Chưa có Zalo Oa
                    </div>
                </td>
            </tr>
        @endif
    </tbody>
</table>
