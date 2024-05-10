@if ($data->aju_approve_direktur)
    @if ($data->aju_approve_finance)
        <span class='badge bg-success' style='border-radius:5px;width:100px;font-size:12px;'>
            Pengajuan <br> sudah <br> dicair <br> finance di <br>
            {{ \Carbon\Carbon::parse($data->aju_tgl_approve_finance)->diffForHumans() }}
        </span>
    @else
        @if ($data->aju_tolak)
            <span class='badge bg-danger mb-3' style='border-radius:5px;width:100px;font-size:12px;'>
                Pengajuan <br> ditolak oleh <br> {{ $data->aju_user_tolak }} di <br>
                {{ \Carbon\Carbon::parse($data->aju_tgl_tolak)->diffForHumans() }}
            </span>
        @else
            <span class='badge bg-primary' style='border-radius:5px;width:100px;font-size:12px;'>
                Pengajuan <br> sudah <br> di approve <br> direktur di <br>
                {{ \Carbon\Carbon::parse($data->aju_tgl_approve_direktur)->diffForHumans() }}
            </span>
            @if (auth()->user()->status == 'Finance')
                <div class="mt-1">
                    <span class='badge bg-white'>
                        <div class='form-check'>
                            <input class='form-check-input' type='checkbox'
                                onChange='setujui_ceklis({{ $data->id }})' name='setujui_pengajuan'
                                id='setujui_pengajuan'>
                            <label class='form-check-label badge bg-success' for='setujui_pengajuan'>Setujui</label>
                        </div>
                        <div class='form-check'>
                            <input class='form-check-input' type='checkbox' onChange='tolak_ceklis({{ $data->id }})'
                                name='tolak_pengajuan' id='tolak_pengajuan'>
                            <label class='form-check-label badge bg-danger' for='tolak_pengajuan'>Tolak</label>
                        </div>
                    </span>
                </div>
            @endif
        @endif
    @endif
@else
    @if ($data->aju_tolak)
        <span class='badge bg-danger mb-3' style='border-radius:5px;width:100px;font-size:12px;'>
            Pengajuan <br> ditolak oleh <br> {{ $data->aju_user_tolak }} di <br>
            {{ \Carbon\Carbon::parse($data->aju_tgl_tolak)->diffForHumans() }}
        </span>
    @else
        <span class='badge bg-dark mb-3' style='border-radius:5px;width:100px;font-size:12px;'>
            Menunggu <br> diproses <br> direktur
        </span>
        @if (auth()->user()->status == 'Direktur')
            <div class="mt-1">
                <span class='badge bg-white'>
                    <div class='form-check'>
                        <input class='form-check-input' type='checkbox' onChange='setujui_ceklis({{ $data->id }})'
                            name='setujui_pengajuan' id='setujui_pengajuan'>
                        <label class='form-check-label badge bg-success' for='setujui_pengajuan'>Setujui</label>
                    </div>
                    <div class='form-check'>
                        <input class='form-check-input' type='checkbox' onChange='tolak_ceklis({{ $data->id }})'
                            name='tolak_pengajuan' id='tolak_pengajuan'>
                        <label class='form-check-label badge bg-danger' for='tolak_pengajuan'>Tolak</label>
                    </div>
                </span>
            </div>
        @endif
    @endif
@endif
