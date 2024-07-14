@extends('layouts.DashboardMaster')
@section('content')
<div class="card-header">
    <h4 class="card-title">Table User</h4>
</div>
<div class="card-body">
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <button type="button" class="btn btn-outline-success block" data-bs-toggle="modal" data-bs-target="#addModal">
                        Tambah User
                    </button>
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->username }}</td>
                                <td>
                                    <button type="button" class="btn btn-outline-warning block mb-1 mb-sm-0" data-bs-toggle="modal" data-bs-target="#updateModal"
                                        onclick="setUpdate(this)" data-name="{{ $user->name }}" data-username="{{ $user->username }}">
                                        Ubah User
                                    </button>
                                    <button type="button" class="btn btn-outline-danger block" data-bs-toggle="modal" data-bs-target="#destroyModal"
                                        onclick="setDestroy('{{ $user->username }}')">
                                        Hapus User
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</div>

<div class="modal fade text-left" id="addModal" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel1">Tambah User</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('user_store') }}" method="post" id="tambahForm">
                    @csrf
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="name" minlength="2" maxlength="50" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" minlength="6" maxlength="12" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="text" name="password" minlength="6" maxlength="20" class="form-control" required>
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

<form method="post" id="destroyForm">
    @csrf
    @method('delete')
</form>

<div class="modal fade text-left" id="destroyModal" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel1">Hapus User</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <p>Hapus akun dengan username <span id="username_info" class="text-danger"></span> ?</p>
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

<div class="modal fade text-left" id="updateModal" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel1">Ubah User</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="updateForm">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="name" id="updateName" minlength="2" maxlength="50" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" id="updateUsername" minlength="6" maxlength="12" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="text" name="password" minlength="6" maxlength="20" class="form-control" placeholder="kosongkan jika tidak ingin diubah">
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

@push('head')
    <link rel="stylesheet" href="/assets/mazer/extensions/simple-datatables/style.css">
    <link rel="stylesheet" href="/assets/mazer/compiled/css/table-datatable.css">
@endpush

@push('foot')
    <script src="/assets/mazer/extensions/simple-datatables/umd/simple-datatables.js"></script>
    <script src="/assets/mazer/static/js/pages/simple-datatables.js"></script>
    <script>
        function setDestroy(username) {
            username_info.innerHTML = username;
            destroyForm.action = '/user/' + username;
        }
        function setUpdate(btn) {
            updateForm.action = '/user/' + btn.getAttribute('data-username');
            updateName.value = btn.getAttribute('data-name');
            updateUsername.value = btn.getAttribute('data-username');
        }
    </script>
@endpush

