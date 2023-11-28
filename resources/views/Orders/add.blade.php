@extends('template')

@section('content')
  <script src="https://cdn.jsdelivr.net/npm/vue@2.6.11"></script>
  <div id="app">
    <!-- Begin Page Content -->
    <div class="container-fluid">
  
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Add Order Transaction</h1>
        </div>
  
        <!-- Content Row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <div class="form-group">
                  <label for="tenant">Tenan</label>
                  <select name="tenant" id="tenant" class="form-control" onchange="getMenu(this)">
                    <option value="">-- Pilih Tenan --</option>
                    @foreach ($tenant as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="menu">Menu</label>
                  <select name="menu" id="menu" class="form-control" disabled>
                    <option value="">-- Pilih Tenan --</option>
                    <option
                      v-for="(selectOption, indexOpt) in menu"
                      :key="indexOpt"
                      :value="selectOption.id">
                      @{{ selectOption.name }} | @{{ convertRupiah(selectOption.price )}}
                    </option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="qty">Qty</label>
                  <input type="number" min="1" class="form-control" value="0" name="qty" id="qty" disabled>
                </div>
                <button class="btn btn-primary" onclick="addToCart()"><span class="fa fa-plus"></span> Tambah Ke Pesanan</button>
                <hr>
                <table class="table">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Menu</th>
                      <th>Qty</th>
                      <th>Harga</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(item, index) in order">
                      <td>@{{ index+1 }}</td>
                      <td>@{{ item.menu.name }}</td>
                      <td>@{{ item.qty }} @{{ item.menu.unit }}</td>
                      <td>@{{ convertRupiah(item.qty * item.menu.price) }}</td>
                    </tr>
                    <tr>
                      <td colspan="3" class="text-right">Grand Total</td>
                      <td>@{{ getGrandTotal() }}</td>
                    </tr>
                  </tbody>
                </table>
                
                <button class="btn btn-primary float-right" onclick="submitOrder()"><span class="fa fa-save"></span> Selesai</button>
              </div>
            </div>
          </div>
        </div>
    </div>
    <!-- /.container-fluid -->
  </div>
@endsection

@section('script')
  <script>
    var app = new Vue({
      el: '#app',
      data: {
        menu: [],
        order: [],
        grandTotal: 0,
      },
      methods: {
        async getMenu(idTenant) {
          $.LoadingOverlay("show");
          this.menu = [];
          if (idTenant) {
            let dataMenu = null;
            await $.ajax({
              type  : 'GET',
              url     : "{{ url('inventory/get-menu-by-tenant') }}/"+idTenant,
              success: function(data, status, xhr) {
                $.LoadingOverlay("hide");
                try {
                  var result = JSON.parse(xhr.responseText);
                  if (result.status) {
                    /* SUCCESS */
                    dataMenu = result.data;
                  }
                } catch (e) {
                  /* NO DATA */
                }
              },
              error: function(data) {
                $.LoadingOverlay("hide");
                /* ERROR */
                swal("Warning!", "System Error.", "warning");
              }
            });
            this.menu = dataMenu;
            $('#menu').prop("disabled", false);
            $('#qty').prop("disabled", false);
          } else {
            $.LoadingOverlay("hide");
            $('#menu').prop("disabled", true);
            $('#qty').prop("disabled", true);
          }
        },
        convertRupiah(angka) {
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
        },
        getGrandTotal() {
          if (this.order.length) {
            let total = 0;
            for (let i = 0; i < this.order.length; i++) {
              total += Number(this.order[i].qty) * Number(this.order[i].menu.price);
            }
            this.grandTotal = total;
            return this.convertRupiah(total);
          } else {
            return this.convertRupiah(0);
          }
        }
      },
    });

    function getMenu(event) {
      const id = event.value;
      app.getMenu(id)
    }

    function addToCart() {
      const idTenant = $('#tenant').val();
      const idMenu = $('#menu').val();
      const qty = $('#qty').val();

      if (!idTenant || !idMenu || !qty) {
        swal("Warning!", "Silahkan lengkapi pesanan.", "warning");
      } else {
        const menu = {
          qty,
          idTenant,
          menu: app.menu.find((it) => (it.id == idMenu))
        };
  
        app.order.push(menu);
      }

    }

    function submitOrder() {
      if (app.order.length) {
        $.ajax({
          method  : 'POST',
          url     : "{{ route('order.insert') }}",
          data    : {
            data: app.order,
            grandTotal: app.grandTotal
          },
          success: function(data, status, xhr) {
            $.LoadingOverlay("hide");
            try {
                var result = JSON.parse(xhr.responseText);
                if (result.status == true) {
                  swal({
                    title: result.message,
                    icon: "success",
                  }).then((acc) => {
                    window.location.href = "{{ route('order') }}";
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
      } else {
        swal("Warning!", "Silahkan lengkapi pesanan.", "warning");
      }
    }
  </script>
@endsection