<hr>
@php
    $pengajuan = App\Models\Abstrak::with(['mahasiswa', 'fakultas', 'file'])->where('id_mahasiswa', Auth::user()->id);

    $cek_pengajuan = $pengajuan->count();
    $abstrak = $pengajuan->latest()->first();
    if ($cek_pengajuan != 0) {
        $file_abstrak = $abstrak->file()->latest()->first();
        $latestFile = $abstrak->file()->latest()->first()->file;
        $pemeriksaan = App\Models\Pemeriksaan::where('id_abstrak', $abstrak->id)
            ->where('hasil', 'Selesai')
            ->latest()
            ->first();
        if ($file_abstrak) {
            $latestFileStatus = $file_abstrak->status;
        } else {
            $latestFileStatus = null;
        }
    }
@endphp
@if ($pengajuan->count() == 0 || $latestFileStatus == 1)
    <div class="container text-center ">

        <button class="btn btn-lg btn-primary w-50" type="button" data-toggle="modal" data-target="#pengajuan">
            <span>
                <i class="bx bx-plus"></i>
                <span class="d-none d-sm-inline-block">Buat Pengajuan Abstrak
                    {{ $pengajuan->count() != 0 && $latestFileStatus == 1 ? 'Baru' : '' }}</span>
            </span>
        </button>
    </div>
@endif
<div class="row justify-content-center">
    @if ($pengajuan->count() != 0)
        <div class="col-md-6">
            <div class="p-3 widget-account-invoice-one bg-white mt-4 border border-primary" style="border-radius: 20px;">

                <div class="widget-content">
                    <h5 class="">Detail Pengajuan</h5>
                    <div class="invoice-box">

                        <div class="acc-total-info">
                            <h5>{{ $abstrak->mahasiswa->name }}</h5>
                            <p class="acc-amount">{{ $abstrak->mahasiswa->identity }}</p>
                        </div>

                        <div class="inv-detail">
                            <p>Judul Penelitian :</p>
                            <div class="info-detail-1">
                                <p>Judul {{ $abstrak->judul }}</p>
                            </div>
                            <p>Fakultas :</p>
                            <div class="info-detail-1">
                                <p>Fakultas {{ $abstrak->fakultas->fakultas }}</p>
                            </div>
                            <p>Lembar Pengesahan :</p>
                            <a href="{{ Storage::url($abstrak->file_lembar_pengesahan) }}" target="__blank"
                                class="btn btn-primary btn-sm">File Lembar Pengesahan</a>
                            <p>File pengajuan Abstrak :</p>
                            @if ($file_abstrak->status == 2)
                                <form action="{{ route('abstrak.upload-revisi') }}" method="POST"
                                    enctype="multipart/form-data" class="mb-4">
                                    @csrf
                                    <input type="hidden" name="id_abstrak" value="{{ $abstrak->id }}">
                                    <p><input type="file" name="file" class="form-control mb-3" required
                                            accept="application/pdf">
                                        <button type="submit" class="btn btn-sm btn-warning">Upload Ulang</button>
                                    </p>
                                </form>
                            @else
                                <a href="{{ Storage::url($latestFile) }}" target="__blank"
                                    class="btn btn-success btn-sm">File Abstrak</a>
                            @endif
                            <p>File Hasil Abstrak :</p>
                            @if ($pemeriksaan)
                                <a href="{{ Storage::url($pemeriksaan->file) }}" target="__blank"
                                    class="btn btn-primary btn-sm">File Abstrak</a>
                            @else
                                <span class="text-muted">Menunggu Hasil pemeriksaan</span>
                            @endif
                        </div>
                        <div class="inv-detail">
                            <p>Status Pengajuan:</p>
                            {{-- <div class="info-detail-1">
                                <p>Pengajuan<br><small>Oleh : Anda</small></p>
                                <p>{{ $abstrak->created_at->format('d F Y') }}</p>
                            </div> --}}
                            @foreach (App\Models\StatusAbstrak::where('id_abstrak', $abstrak->id)->get() as $item)
                                <div class="info-detail-1">
                                    <p>{{ $item->status }}<br><small>Oleh : {{ $item->staff->name }}</small></p>
                                    <p>{{ $item->created_at->format('d F Y') }}</p>
                                </div>
                            @endforeach
                        </div>
                        {{-- 
                        <div class="inv-action">
                            <a href="" class="btn btn-outline-dark">Summary</a>
                            <a href="" class="btn btn-danger">Transfer</a>
                        </div> --}}
                    </div>
                </div>

            </div>
        </div>
    @endif
    <div class=" col-md-4">
        @if ($pengajuan->count() != 0)
            <div class="p-3 border border-secondary bg-white mb-3" style="border-radius:20px;margin-top:24px;">
                <h4>Pembayaran</h4>
                <hr>
                @php
                    $pembayaran = App\Models\Pembayaran::where('id_abstrak', $abstrak->id)->get();
                    $cek_lunas = App\Models\Pembayaran::where('id_abstrak', $abstrak->id)
                        ->whereIn('diterima', [0, 1])
                        ->latest()
                        ->first();
                @endphp
                @if (!$cek_lunas)
                    <form action="{{ route('pembayaran.store') }}" method="POST" enctype="multipart/form-data"
                        class="mb-4">
                        @csrf
                        <input type="hidden" name="id_abstrak" value="{{ $abstrak->id }}">
                        <div class="mb-3">
                            <label>Jumlah</label>
                            <input type="number" class="form-control form-control-sm" name="jumlah" required>
                        </div>
                        <div class="mb-3">
                            <label>Bukti Bayar (PDF)</label>
                            <input type="file" class="form-control" name="file" required accept="application/pdf">
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Kirim</button>
                    </form>
                @endif
                <table class="table">
                    <thead>
                        <th>Tanggal</th>
                        <th>Bukti</th>
                        <th>Status</th>
                    </thead>
                    <tbody>
                        @foreach ($pembayaran as $item)
                            <tr>
                                <td>{{ $item->created_at->format('d F Y') }}</td>
                                <td><a target="__blank" href="{{ Storage::url($item->file) }}"
                                        class="btn btn-success btn-sm">Lihat</a></td>
                                <td>
                                    @if ($item->diterima == 0)
                                        Menunggu Verifikasi
                                    @elseif($item->diterima == 1)
                                        Sukses
                                    @else
                                        Ditolak
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
        <div class="p-3 border border-secondary bg-white" style="border-radius:20px;margin-top:24px;">
            <h4>Identitas</h4>
            <hr>
            <table class="table">
                <tr>
                    <td style="font-weight: bold;">Nama Lengkap</td>
                    <td>{{ auth::user()->name }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">NPM</td>
                    <td>{{ auth::user()->identity }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">No. HP/WA</td>
                    <td>{{ auth::user()->no_hp }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
{{-- modal --}}
<div class="modal fade" id="pengajuan" tabindex="-1" aria-labelledby="UsersModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Formulir Pengajuan Abstrak</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i
                        class="bx bx-x"></i></button>
            </div>
            <form action="{{ route('abstrak.store') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- Form for Create and Edit -->
                    <input type="hidden" name="id_mahasiswa" value="{{ Auth::id() }}">
                    <div class="mb-3">
                        <label>Judul Penelitian <span class="text-danger">*</span></label>
                        <input type="text" name="judul" class="form-control" placeholder="Judul Penelitian"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="formFakultas" class="form-label">Pilih Fakultas <span
                                class="text-danger">*</span></label>
                        <select name="id_fakultas" class="form-control" required>
                            @foreach (App\Models\Fakultas::all() as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->fakultas }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>File Lembar Pengesahan <small>(Upload file PDF) <span
                                    class="text-danger">*</span></small></label>
                        <input type="file" name="file_lembar_pengesahan" class="form-control"
                            accept="application/pdf" required>
                    </div>
                    <div class="mb-3">
                        <label>File Abstrak <small>(Upload file PDF)</small><span class="text-danger">*</span></label>
                        <input type="file" name="file" class="form-control" accept="application/pdf" required>
                    </div>
                    <div class="mb-3">
                        <label>Bukti Pembayaran <small>(Upload file PDF)</small><span
                                class="text-danger">*</span></label>
                        <input type="file" name="file_pembayaran" class="form-control" accept="application/pdf"
                            required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="savePengajuanBtn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('js')
@endpush
