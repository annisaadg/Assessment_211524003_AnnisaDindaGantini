@extends('template')

@section('content')
  <!-- Begin Page Content -->
  <div class="container-fluid">

      <!-- Page Heading -->
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h1 class="h3 mb-0 text-gray-800">History Order Transaction</h1>
          <a href="{{ route('order.add') }}" class="btn btn-sm btn-primary" type="button"><span class="fa fa-plus"></span> Tambah Data</a>
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
                    <th>Transaction ID</th>
                    <th>Kasir</th>
                    <th>Grand Total</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($list as $key => $item)
                    <tr>
                      <td>{{ $key+1 }}</td>
                      <td>{{ $item->transaction_id }}</td>
                      <td>{{ $item->kasir->fullname }}</td>
                      <td>{{ Helper::formatRupiah($item->grand_total) }}</td>
                      <td>
                        <button type="button" class="btn btn-primary btn-sm" onclick="editData({{ $item->id }})">Detail</button>
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
      <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="detailModalLabel">Detail Order</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="javascript:void(0)" method="POST" id="formUpdate">
              <input type="hidden" name="_method" value="PUT">
              <input type="hidden" required id="id" name="id">
              <div class="modal-body">
                <div class="row">
                  <div class="col-6">
                    <div class="form-group">
                      <label for="transaction_id">Transaksi ID</label>
                      <input type="text" class="form-control" id="transaction_id" placeholder="Input Kode Kasir" disabled readonly>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label for="kasir">Nama Kasir</label>
                      <input type="text" class="form-control" id="kasir" placeholder="Input Kode Kasir" disabled readonly>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label for="grand_total">Grand Total</label>
                      <input type="text" class="form-control" id="grand_total" placeholder="Input Kode Kasir" disabled readonly>
                    </div>
                  </div>
                </div>
                <table class="table">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Menu</th>
                      <th>Qty</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                  <tbody id="tableOrder">
                  </tbody>
                </table>
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
    function convertRupiah(angka) {
      var rupiah = '';
      var angkaStr = angka.toString();
      
      // Mengambil bagian desimal jika ada
      var desimal = '';
      if (angkaStr.indexOf('.') !== -1) {
          desimal = ',' + angkaStr.split('.')[1];
          angkaStr = angkaStr.split('.')[0];
      }

      // Mengonversi angka menjadi format ribuan
      var counter = 0;
      for (var i = angkaStr.length - 1; i >= 0; i--) {
          rupiah = angkaStr[i] + rupiah;
          counter++;
          if (counter % 3 === 0 && i !== 0) {
              rupiah = '.' + rupiah;
          }
      }

      return 'Rp ' + rupiah + desimal;
    }

    function editData(id) {
      $.LoadingOverlay("show");
      $.ajax({
        method  : 'GET',
        url     : "{{ url('orders') }}/"+id,
        success: function(dt, status, xhr) {
          var result = JSON.parse(xhr.responseText);
          if (result.status) {
            $('#kasir').val(result.data.kasir.fullname);
            $('#transaction_id').val(result.data.transaction_id);
            $('#grand_total').val(convertRupiah(result.data.grand_total));
            var html = '';

            result.data.detail.forEach((element, index) => {
              html += '<tr>';
              html += '<td>'+(index+1)+'</td>';
              html += '<td>'+element.barang.name+'</td>';
              html += '<td>'+element.qty+'</td>';
              html += '<td>'+convertRupiah(element.qty * element.barang.price)+'</td>';
              html += '</tr>';
            });

            $('#tableOrder').html(html);
            console.log(result);
            $('#detailModal').modal({backdrop: 'static', keyboard: false});
          } else {
            swal("Peringatan !", result.message, "warning");
          }
        }
      });
      $.LoadingOverlay("hide");
    }
  </script>
@endsection