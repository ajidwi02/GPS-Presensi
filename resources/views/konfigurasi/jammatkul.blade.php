@extends('layouts.admin.tabler')
@section('content')
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <!-- Page pre-title -->
        <div class="page-pretitle">
          Konfigurasi
        </div>
        <h2 class="page-title">
          Jam MataKuliah
        </h2>
      </div>
    </div>
  </div>
</div>

<div class="page-body">
  <div class="container-xl">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-12">
              @if (Session::get('success'))
                  <div class="alert alert-success">
                    {{ Session::get('success') }}
                  </div>
              @endif

              @if (Session::get('warning'))
                  <div class="alert alert-warning">
                    {{ Session::get('warning') }}
                  </div>
              @endif
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <a href="#" id="btnTambahJammatkul" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                Tambah Data
              </a>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-12">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Kode Matkul</th>
                    <th>Nama Mata Kuliah</th>
                    <th>Awal Jam Masuk</th>
                    <th>Jam Masuk</th>
                    <th>Akhir Jam Masuk</th>
                    <th>Jam Pulang</th>
                    <th>Dosen Pengampu</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($jam_matkul as $d)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $d->kode_jam_matkul }}</td>
                        <td>{{ $d->nama_jam_matkul }}</td>
                        <td>{{ $d->awal_jam_masuk }}</td>
                        <td>{{ $d->jam_masuk }}</td>
                        <td>{{ $d->akhir_jam_masuk }}</td>
                        <td>{{ $d->jam_pulang }}</td>
                        <td>{{ $d->keterangan }}</td>
                        <td>
                          <div class="btn-group">
                              <div class="col-6">
                                <a href="#" class="edit btn btn-info btn-sm" kode_jam_matkul="{{ $d->kode_jam_matkul }}">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                </a>
                              </div>
                              <div class="col-6">
                                <form method="POST" action="/konfigurasi/{{ $d->kode_jam_matkul }}/delete">
                                  @csrf
                                  <a href="#" class="btn btn-danger btn-sm delete-confirm" id="">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="non e" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                  </a>
                                </form>
                              </div>
                          </div>
                        </td>
                      </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal modal-blur fade" id="modal-inputjm" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Data Jam Matkul</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="/konfigurasi/storejammatkul" method="POST" id="frmJM" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-12">
              <div class="input-icon mb-3">
                <span class="input-icon-addon">
                  <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-book-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19 4v16h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12z" /><path d="M19 16h-12a2 2 0 0 0 -2 2" /><path d="M9 8h6" /></svg>
                </span>
                <input type="text" value="" id="kode_jam_matkul" class="form-control" name="kode_jam_matkul" placeholder="Kode Jam Matkul">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <div class="input-icon mb-3">
                <span class="input-icon-addon">
                  <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-forms" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3a3 3 0 0 0 -3 3v12a3 3 0 0 0 3 3" /><path d="M6 3a3 3 0 0 1 3 3v12a3 3 0 0 1 -3 3" /><path d="M13 7h7a1 1 0 0 1 1 1v8a1 1 0 0 1 -1 1h-7" /><path d="M5 7h-1a1 1 0 0 0 -1 1v8a1 1 0 0 0 1 1h1" /><path d="M17 12h.01" /><path d="M13 12h.01" /></svg>
                </span>
                <input type="text" value="" id="nama_jam_matkul" class="form-control" name="nama_jam_matkul" placeholder="Nama Matkul">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <div class="input-icon mb-3">
                <span class="input-icon-addon">
                  <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clock" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 7v5l3 3" /></svg>
                </span>
                <input type="text" value="" id="awal_jam_masuk" class="form-control" name="awal_jam_masuk" placeholder="Awal Jam Masuk">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <div class="input-icon mb-3">
                <span class="input-icon-addon">
                  <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clock" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 7v5l3 3" /></svg>
                </span>
                <input type="text" value="" id="jam_masuk" class="form-control" name="jam_masuk" placeholder="Jam Masuk">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <div class="input-icon mb-3">
                <span class="input-icon-addon">
                  <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clock" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 7v5l3 3" /></svg>
                </span>
                <input type="text" value="" id="akhir_jam_masuk" class="form-control" name="akhir_jam_masuk" placeholder="Akhir Jam Masuk">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <div class="input-icon mb-3">
                <span class="input-icon-addon">
                  <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clock" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 7v5l3 3" /></svg>
                </span>
                <input type="text" value="" id="jam_pulang" class="form-control" name="jam_pulang" placeholder="Jam Pulang">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <div class="input-icon mb-3">
                <span class="input-icon-addon">
                  <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg>
                </span>
                <input type="text" value="" id="dosen_pengampu" class="form-control" name="dosen_pengampu" placeholder="Dosen Pengampu">
              </div>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-12">
              <div class="form-group">
                <button class="btn btn-primary w-100">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-check-filled" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 3.34a10 10 0 1 1 -14.995 8.984l-.005 -.324l.005 -.324a10 10 0 0 1 14.995 -8.336zm-1.293 5.953a1 1 0 0 0 -1.32 -.083l-.094 .083l-3.293 3.292l-1.293 -1.292l-.094 -.083a1 1 0 0 0 -1.403 1.403l.083 .094l2 2l.094 .083a1 1 0 0 0 1.226 0l.094 -.083l4 -4l.083 -.094a1 1 0 0 0 -.083 -1.32z" stroke-width="0" fill="currentColor" /></svg>
                  Simpan
                </button>
              </div>
            </div>
          </div>
          
        </form>
      </div>
    </div>
  </div>
</div>

{{-- Modal Edit --}}
<div class="modal modal-blur fade" id="modal-editJM" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Data Jam Matkul</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body " id="loadeditform">
        
      </div>
    </div>
  </div>
</div>
@endsection

@push('myscript')
    <script>
      $(function(){
        $('#btnTambahJammatkul').click(function(){
          $("#modal-inputjm").modal('show');
        });

        $('.edit').click(function(){
          var kode_jam_matkul = $(this).attr('kode_jam_matkul');
          $.ajax({
            type: 'POST',
            url: '/konfigurasi/editjammatkul',
            cache: false,
            data:{
              _token: "{{ csrf_token(); }}",
              kode_jam_matkul: kode_jam_matkul
            },
            success:function(respond){
              $('#loadeditform').html(respond);
            }
          });
          $("#modal-editJM").modal('show');
        });

        $('.delete-confirm').click(function(e){
          var form = $(this).closest('form');
          e.preventDefault();
          Swal.fire({
            title: "Apakah data ingin dihapus?",
            text: "Pastikan cek terlebih dahulu!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Hapus!"
          }).then((result) => {
            if (result.isConfirmed) {
              form.submit();
              Swal.fire({
                title: "Deleted!",
                text: "Data berhasil dihapus.",
                icon: "success"
              });
            }
          });
        })

        $('#frmJM').submit(function(){
          var kode_jam_matkul = $("#kode_jam_matkul").val();
          var nama_jam_matkul = $("#nama_jam_matkul").val();
          var awal_jam_masuk = $("#awal_jam_masuk").val();
          var jam_masuk = $("#jam_masuk").val();
          var akhir_jam_masuk = $("#akhir_jam_masuk").val();
          var jam_pulang = $("#jam_pulang").val();
          var dosen_pengampu = $("#dosen_pengampu").val();

          if(kode_jam_matkul == ""){
            Swal.fire({
              title: "Perhatian",
              text: "Kode Jam Matkul harus diisi!",
              icon: "warning",
              confirmButtonText: "Ok"
            });
            
            $("#kode_jam_matkul").focus();
            return false;
          }

          if(nama_jam_matkul == ""){
            Swal.fire({
              title: "Perhatian",
              text: "Nama Jam Matkul harus diisi!",
              icon: "warning",
              confirmButtonText: "Ok"
            });

            $("#nama_jam_matkul").focus();
            return false;
          }
          
          if(awal_jam_masuk == ""){
            Swal.fire({
              title: "Perhatian",
              text: "Awal jam masuk harus diisi!",
              icon: "warning",
              confirmButtonText: "Ok"
            });

            $("#awal_jam_masuk").focus();
            return false;
          }

          if(akhir_jam_masuk == ""){
            Swal.fire({
              title: "Perhatian",
              text: "Akhir jam masuk harus diisi!",
              icon: "warning",
              confirmButtonText: "Ok"
            });

            $("#akhir_jam_masuk").focus();
            return false;
          }

          if(dosen_pengampu == ""){
            Swal.fire({
              title: "Perhatian",
              text: "Dosen pengampu harus diisi!",
              icon: "warning",
              confirmButtonText: "Ok"
            });

            $("#dosen_pengampu").focus();
            return false;
          }

          if(jam_pulang == ""){
            Swal.fire({
              title: "Perhatian",
              text: "Jam pulang harus diisi!",
              icon: "warning",
              confirmButtonText: "Ok"
            });

            $("#jam_pulang").focus();
            return false;
          }
        });
      });
    </script>
@endpush