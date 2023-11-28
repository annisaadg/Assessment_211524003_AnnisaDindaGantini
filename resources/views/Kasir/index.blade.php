@extends('template')

@section('content')
  <!-- Begin Page Content -->
  <div class="container-fluid">

      <!-- Page Heading -->
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h1 class="h3 mb-0 text-gray-800">Kasir Management</h1>
          <button class="btn btn-sm btn-primary" type="button" data-toggle="modal" data-target="#addModal"><span class="fa fa-plus"></span> Tambah Data</button>
      </div>

      <!-- Content Row -->
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <table class="table" id="tableData">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Nomor Telepon</th>
                    <th>Status</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($list as $key => $item)
                    <tr>
                      <td>{{ $key+1 }}</td>
                      <td>{{ $item->code }}</td>
                      <td>{{ $item->fullname }}</td>
                      <td>{{ $item->phone_number }}</td>
                      <td>{{ $item->is_active ? 'Aktif' : 'Tidak Aktif' }}</td>
                      <td>
                        <button type="button" class="btn btn-primary btn-sm" onclick="editData({{ $item }})"><span class="fa fa-pencil-alt"></span></button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="deleteData({{ $item->id }})"><span class="fa fa-trash"></span></button>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal -->
      <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="addModalLabel">Tambah Data</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="javascript:void(0)" method="POST" id="formInsert">
              <div class="modal-body">
                <div class="form-group">
                  <label for="code">Kode Kasir</label>
                  <input type="text" class="form-control" id="code" name="code" placeholder="Input Kode Kasir" required>
                </div>
                <div class="form-group">
                  <label for="fullname">Nama Kasir</label>
                  <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Input Nama Kasir" required>
                </div>
                <div class="form-group">
                  <label for="phone_number">Nomor Telepon</label>
                  <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Input Nomor Telepon" required>
                </div>
                <div class="form-group">
                  <label for="username">Username</label>
                  <input type="text" class="form-control" id="username" name="username" placeholder="Input Username" required>
                </div>
                <div class="form-group">
                  <label for="password">Password</label>
                  <input type="password" class="form-control" id="password" name="password" placeholder="Input Password" required>
                </div>
                <div class="form-group">
                  <label for="is_active">Status</label>
                  <select name="is_active" id="is_active" class="form-control" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="1">Aktif</option>
                    <option value="0">Tidak Aktif</option>
                  </select>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      
      <!-- Modal -->
      <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="updateModalLabel">Ubah Data</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="javascript:void(0)" method="POST" id="formUpdate">
              <input type="hidden" name="_method" value="PUT">
              <input type="hidden" required id="id" name="id">
              <div class="modal-body">
                <div class="form-group">
                  <label for="codeUpdate">Kode Kasir</label>
                  <input type="text" class="form-control" id="codeUpdate" name="code" placeholder="Input Kode Kasir" required>
                </div>
                <div class="form-group">
                  <label for="fullnameUpdate">Nama Kasir</label>
                  <input type="text" class="form-control" id="fullnameUpdate" name="fullname" placeholder="Input Nama Kasir" required>
                </div>
                <div class="form-group">
                  <label for="phone_numberUpdate">Nomor Telepon</label>
                  <input type="text" class="form-control" id="phone_numberUpdate" name="phone_number" placeholder="Input Nomor Telepon" required>
                </div>
                <div class="form-group">
                  <label for="usernameUpdate">Username</label>
                  <input type="text" class="form-control" id="usernameUpdate" name="username" placeholder="Input Username" required>
                </div>
                <div class="form-group">
                  <label for="passwordUpdate">Password <span class="text-danger" style="font-size: 10px">Kosongkan jika tidak akan mengubah password</span></label>
                  <input type="password" class="form-control" id="passwordUpdate" name="password" placeholder="Input Password">
                </div>
                <div class="form-group">
                  <label for="is_activeUpdate">Status</label>
                  <select name="is_active" id="is_activeUpdate" class="form-control" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="1">Aktif</option>
                    <option value="0">Tidak Aktif</option>
                  </select>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
              </div>
            </form>
          </div>
        </div>
      </div>
  </div>
  <!-- /.container-fluid -->
@endsection

@section('script')
  <script>
    $(document).ready(() => {
      $('#formInsert').on('submit',(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.LoadingOverlay("show");

        $.ajax({
          method  : 'POST',
          url     : "{{ route('kasir.add') }}",
          data    : formData,
          contentType: false,
          processData: false,
          success: function(data, status, xhr) {
            $.LoadingOverlay("hide");
            try {
                var result = JSON.parse(xhr.responseText);
                if (result.status == true) {
                  swal({
                    title: result.message,
                    icon: "success",
                  }).then((acc) => {
                    location.reload();
                  });
                } else {
                  swal({
                    icon: "warning",
                    title: "Warning",
                    text: result.message,
                  });
                }
            } catch (e) {
              swal({
                title: "Warning !",
                text: "Sistem error.",
                icon: "warning"
              });
            }
          },
          error: function(data) {
            $.LoadingOverlay("hide");
            swal({
              title: "Warning !",
              text: "A system error has occurred.",
              icon: "warning"
            });
          }
        });
      }));

      $('#formUpdate').on('submit',(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.LoadingOverlay("show");

        $.ajax({
          method  : 'POST',
          url     : "{{ route('kasir.update') }}",
          data    : formData,
          contentType: false,
          processData: false,
          success: function(data, status, xhr) {
            $.LoadingOverlay("hide");
            try {
                var result = JSON.parse(xhr.responseText);
                if (result.status == true) {
                  swal({
                    title: result.message,
                    icon: "success",
                  }).then((acc) => {
                    location.reload();
                  });
                } else {
                  swal({
                    icon: "warning",
                    title: "Warning",
                    text: result.message,
                  });
                }
            } catch (e) {
              swal({
                title: "Warning !",
                text: "Sistem error.",
                icon: "warning"
              });
            }
          },
          error: function(data) {
            $.LoadingOverlay("hide");
            swal({
              title: "Warning !",
              text: "A system error has occurred.",
              icon: "warning"
            });
          }
        });
      }));
    });

    function deleteData(id) {
      swal({
      title: "Anda yakin?",
      text: "Setelah dihapus, data tidak dapat dikembalikan!",
      icon: "warning",
      buttons: true,
      dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.LoadingOverlay("show");
          $.ajax({
            method  : 'DELETE',
            url     : "{{ route('kasir.delete') }}",
            data    : {
                id
            },
            success: function(data, status, xhr) {
              $.LoadingOverlay("hide");
              try {
                var result = JSON.parse(xhr.responseText);
                if (result.status) {
                  swal(result.message, {
                    icon: "success",
                    title: "Success",
                    text: result.message,
                  }).then((acc) => {
                  location.reload();
                  });
                } else {
                  swal("Peringatan !", result.message, "warning");
                }
              } catch (e) {
                swal("Peringatan !", "Terjadi kesalahan sistem", "warning");
              }
            },
            error: function(data) {
              $.LoadingOverlay("hide");
              swal("Peringatan !", "Terjadi kesalahan sistem", "warning");
            }
          });
        }
      });
    }

    function editData(data) {
      $.LoadingOverlay("show");
      $('#id').val(data.id);
      $('#codeUpdate').val(data.code);
      $('#fullnameUpdate').val(data.fullname);
      $('#phone_numberUpdate').val(data.phone_number);
      $('#usernameUpdate').val(data.username);
      $('#is_activeUpdate').val(data.is_active);
      $('#updateModal').modal({backdrop: 'static', keyboard: false});
      $.LoadingOverlay("hide");
    }
  </script>
@endsection