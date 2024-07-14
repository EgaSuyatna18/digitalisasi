@extends('layouts.DashboardMaster')
@section('content')
@php
    use SimpleSoftwareIO\QrCode\Facades\QrCode;
@endphp
<div class="card-header">
    <h4 class="card-title">Table Item</h4>
</div>
<div class="card-body">
    <section id="content-types">
        <button type="button" class="btn btn-outline-success block mb-3" data-bs-toggle="modal" data-bs-target="#addModal">
            Tambah Item
        </button>
        <div class="row">
            
            @foreach ($items as $item)
                
                <div class="col-xl-4 col-md-6 col-sm-12">
                    <div class="card">
                        <div class="card-content">
                            <img src="{{ asset('storage/' . $item->foto) }}" class="card-img-top img-fluid" alt="singleminded">
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $item->nama }}</h5>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <button type="button" class="btn btn-light-info block btn-info" data-bs-toggle="modal" data-bs-target="#infoModal" style="width: 30%;"
                                onclick="setInfo(this, '{{ $item->info }}')" data-id="{{ $item->id }}" data-nama="{{ $item->nama }}" disabled>
                                Info
                            </button>
                            <button type="button" class="btn btn-light-warning block btn-update" data-bs-toggle="modal" data-bs-target="#updateModal" style="width: 30%;"
                                onclick="setUpdate(this, '{{ $item->info }}')" data-id="{{ $item->id }}" data-nama="{{ $item->nama }}" disabled>
                                Ubah
                            </button>
                            <button type="button" class="btn btn-light-danger block" data-bs-toggle="modal" data-bs-target="#destroyModal" style="width: 30%;"
                                onclick="setDestroy(this)" data-id="{{ $item->id }}" data-nama="{{ $item->nama }}">
                                Hapus
                            </button>
                        </div>
                    </div>
                </div>

            @endforeach
        </div>
    </section>
</div>

<div class="modal modal-xl fade text-left" id="addModal" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel1">Tambah Item</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('item_store') }}" method="post" id="tambahForm" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label>Foto</label>
                        <input type="file" name="foto" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="nama" minlength="6" maxlength="50" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Informasi</label>
                        <textarea id="editor" name="info"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Close</span>
                </button>
                <button type="submit" form="tambahForm" class="btn btn-success ms-1">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Tambah</span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade text-left" id="infoModal" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel1">Informasi</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div alt="errorImg" class="text-center bg-white p-4" id="foto"></div>
                <h3 class="text-center my-3" id="nama"></h3>
                <p id="info"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Close</span>
                </button>
            </div>
        </div>
    </div>
</div>

<form method="post" id="destroyForm">
    @csrf
    @method('delete')
</form>

<div class="modal fade text-left" id="destroyModal" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel1">Hapus Item</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <p>Hapus item dengan nama <span id="item_nama" class="text-danger"></span> ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Close</span>
                </button>
                <button type="submit" form="destroyForm" class="btn btn-danger ms-1">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Hapus</span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-xl fade text-left" id="updateModal" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel1">Ubah Item</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="updateForm" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <label>Foto</label>
                        <input type="file" name="foto" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="nama" id="updateNama" minlength="6" maxlength="50" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Informasi</label>
                        <textarea id="editor2" name="info"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Close</span>
                </button>
                <button type="submit" form="updateForm" class="btn btn-warning ms-1">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Ubah</span>
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('foot')
    <script src="/assets/ckeditor.js"></script>
    <script src="/assets/mazer/static/js/pages/ckeditor.js"></script>
    <script src="/assets/mazer/extensions/jquery/jquery.min.js"></script>
    <script>
        function setInfo(btn, infoValue) {
            info.innerHTML = infoValue;
            nama.innerHTML = btn.getAttribute('data-nama');

            $.ajax({
                url: '/get_qr/' + btn.getAttribute('data-id'), // Route to the processData method
                type: 'POST',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(response) {
                    // Handle the response from the server
                    $('#foto').html(response);
                },
                error: function(xhr) {
                    // Handle errors
                    console.log(xhr.responseText);
                }
            });
        }

        function setDestroy(btn) {
            item_nama.innerHTML = btn.getAttribute('data-nama');
            destroyForm.action = '/item/' + btn.getAttribute('data-id');
        }

        function setUpdate(btn, info) {
            updateForm.action = '/item/' + btn.getAttribute('data-id');
            updateNama.value = btn.getAttribute('data-nama');
            ckEditor2.setData(info);
        }

        document.addEventListener('DOMContentLoaded', function() {
            $('.btn-update').removeAttr('disabled');
            $('.btn-info').removeAttr('disabled');
        });
    </script>
@endpush