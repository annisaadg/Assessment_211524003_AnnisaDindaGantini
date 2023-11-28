@extends('template')

@section('content')
  <!-- Begin Page Content -->
  <div class="container-fluid">

      <!-- Page Heading -->
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h1 class="h3 mb-0 text-gray-800">Inventory Management</h1>
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
                    <th>Satuan</th>
                    <th>Harga</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Tenant</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($list as $key => $item)
                    <tr>
                      <td>{{ $key+1 }}</td>
                      <td>{{ $item->code }}</td>
                      <td>{{ $item->name }}</td>
                      <td>{{ $item->unit }}</td>
                      <td>{{ $item->price }}</td>
                      <td>{{ $item->stock }}</td>
                      <td>{{ $item->is_active ? 'Aktif' : 'Tidak Aktif' }}</td>
                      <td>{{ $item->tenant->name }}</td>
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
                  <label for="code">Kode Barang</label>
                  <input type="text" class="form-control" id="code" name="code" placeholder="Input Kode Barang" required>
                </div>
                <div class="form-group">
                  <label for="name">Nama Barang</label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="Input Nama Barang" required>
                </div>
                <div class="form-group">
                  <label for="unit">Satuan</label>
                  <select name="unit" id="unit" class="form-control" required>
                    <option value="">-- Pilih Satuan Barang --</option>
                    <option value="unit">Unit</option>
                    <option value="buah">Buah</option>
                    <option value="batang">Batang</option>
                    <option value="bungkus">Bungkus</option>
                    <option value="potong">Potong</option>
                    <option value="ekor">Ekor</option>
                    <option value="botol">Botol</option>
                    <option value="dus">Dus</option>
                    <option value="kaleng">Kaleng</option>
                    <option value="kilogram">Kilogram</option>
                    <option value="gram">Gram</option>
                    <option value="liter">Liter</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="price">Harga Satuan</label>
                  <input type="text" class="form-control" id="price" name="price" placeholder="Input Harga Satuan Barang" required>
                </div>
                <div class="form-group">
                  <label for="stock">Stok Barang</label>
                  <input type="number" class="form-control" id="stock" name="stock" placeholder="Input Stok Barang" required>
                </div>
                <div class="form-group">
                  <label for="id_tenant">Tenant</label>
                  <select name="id_tenant" id="id_tenant" class="form-control" required>
                    <option value="">-- Pilih Data Tenant --</option>
                    @foreach ($tenant as $tn1)
                        <option value="{{ $tn1->id }}">{{ $tn1->name }}</option>
                    @endforeach
                  </select>
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
                  <label for="codeUpdate">Kode Barang</label>
                  <input type="text" class="form-control" id="codeUpdate" name="code" placeholder="Input Kode Barang" required>
                </div>
                <div class="form-group">
                  <label for="nameUpdate">Nama Barang</label>
                  <input type="text" class="form-control" id="nameUpdate" name="name" placeholder="Input Nama Barang" required>
                </div>
                <div class="form-group">
                  <label for="unitUpdate">Satuan</label>
                  <select name="unit" id="unitUpdate" class="form-control" required>
                    <option value="">-- Pilih Satuan Barang --</option>
                    <option value="unit">Unit</option>
                    <option value="buah">Buah</option>
                    <option value="batang">Batang</option>
                    <option value="bungkus">Bungkus</option>
                    <option value="potong">Potong</option>
                    <option value="ekor">Ekor</option>
                    <option value="botol">Botol</option>
                    <option value="dus">Dus</option>
                    <option value="kaleng">Kaleng</option>
                    <option value="kilogram">Kilogram</option>
                    <option value="gram">Gram</option>
                    <option value="liter">Liter</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="priceUpdate">Harga Satuan</label>
                  <input type="text" class="form-control" id="priceUpdate" name="price" placeholder="Input Harga Satuan Barang" required>
                </div>
                <div class="form-group">
                  <label for="stockUpdate">Stok Barang</label>
                  <input type="number" class="form-control" id="stockUpdate" name="stock" placeholder="Input Stok Barang" required>
                </div>
                <div class="form-group">
                  <label for="id_tenantUpdate">Tenant</label>
                  <select name="id_tenant" id="id_tenantUpdate" class="form-control" required>
                    <option value="">-- Pilih Data Tenant --</option>
                    @foreach ($tenant as $tn)
                        <option value="{{ $tn->id }}">{{ $tn->name }}</option>
                    @endforeach
                  </select>
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
          url     : "{{ route('inventory.add') }}",
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
          url     : "{{ route('inventory.update') }}",
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
            url     : "{{ route('inventory.delete') }}",
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
      $('#nameUpdate').val(data.name);
      $('#unitUpdate').val(data.unit);
      $('#priceUpdate').val(data.price);
      $('#stockUpdate').val(data.stock);
      $('#is_activeUpdate').val(data.is_active);
      $('#id_tenantUpdate').val(data.id_tenant);
      $('#updateModal').modal({backdrop: 'static', keyboard: false});
      $.LoadingOverlay("hide");
    }
  </script>
@endsection