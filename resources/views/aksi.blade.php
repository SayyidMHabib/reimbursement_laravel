@if (!$data->aju_approve_direktur && !$data->aju_approve_finance && !$data->aju_tolak)
    @if ($data->aju_user_id == auth()->user()->id)
        <div class="text-center">
            <a href="#" data-id="{{ $data->id }}" onclick="edit({{ $data->id }})" class="badge bg-warning"><i
                    class="feather icon-edit-2 text-white"></i></a>
            <a href="#" data-id="{{ $data->id }}" onclick="detele({{ $data->id }})"
                class="badge bg-danger delete"><i class="feather icon-trash-2 text-white"></i></a>
        </div>
    @endif
@endif
