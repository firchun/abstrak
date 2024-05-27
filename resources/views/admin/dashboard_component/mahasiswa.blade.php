<hr>
@php
    $pengajuan = App\Models\Abstrak::with(['mahasiswa','fakultas','file'])->where('id_mahasiswa', Auth::user()->id);
    $abstrak = $pengajuan->first();
    $file_abstrak = $abstrak->file()->latest()->first();
    $latestFile = $abstrak->file()->latest()->first()->file;
@endphp
@if ($pengajuan->count() == 0)
    <div class="container text-center ">

        <button class="btn btn-lg btn-primary w-50" type="button" data-toggle="modal" data-target="#pengajuan">
            <span>
                <i class="bx bx-plus"></i>
                <span class="d-none d-sm-inline-block">Buat Pengajuan abstrak</span>
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
                            <p>File Abstrak :</p>
                            <p><input type="file" name="file" class="form-control mb-3" required>
                            <button type="submit" class="btn btn-sm btn-warning">Upload Ulang</button></p>
                            @if($file_abstrak->status == 2)
                           <p>File sebelumnya</p>
                            @endif
                            <p><a href="{{ Storage::url($latestFile) }}" target="__blank"
                                    class="btn btn-sm btn-success">Lihat
                                    Abstrak</a></p>
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
            <form action="{{route('abstrak.store')}}" enctype="multipart/form-data" method="POST">
                @csrf
            <div class="modal-body">
                <!-- Form for Create and Edit -->
                    <input type="hidden"  name="id_mahasiswa" value="{{Auth::id()}}">
                    <div class="mb-3">
                        <label>Judul Penelitian</label>
                        <input type="text" name="judul" class="form-control" placeholder="Judul Penelitian" required>
                    </div>
                    <div class="mb-3">
                        <label for="formFakultas" class="form-label">Pilih Fakultas</label>
                        <select name="id_fakultas" class="form-control" required>
                            @foreach(App\Models\Fakultas::all() as $item)
                             <option value="{{$item->id}}"> 
                                {{$item->fakultas}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>File Abstrak <small>Upload file PDF</small></label>
                        <input type="file" name="file" class="form-control" accept="application/pdf" required>
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