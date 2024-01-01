@extends('layouts.admin.tabler')
@section('content')
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <!-- Page pre-title -->
        <div class="page-pretitle">
          Data Master
        </div>
        <h2 class="page-title">
          Program Studi
        </h2>
      </div>
    </div>
  </div>
</div>

<div class="page-body">
  <div class="container-xl">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-12">
                @if (Session::get('success'))
                    <div class="alert alert-success">    
                      {{Session::get('success')}}
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
                <a href="#" class="btn btn-primary" id="btntambahProdi">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-square-rounded-plus-filled" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 2l.324 .001l.318 .004l.616 .017l.299 .013l.579 .034l.553 .046c4.785 .464 6.732 2.411 7.196 7.196l.046 .553l.034 .579c.005 .098 .01 .198 .013 .299l.017 .616l.005 .642l-.005 .642l-.017 .616l-.013 .299l-.034 .579l-.046 .553c-.464 4.785 -2.411 6.732 -7.196 7.196l-.553 .046l-.579 .034c-.098 .005 -.198 .01 -.299 .013l-.616 .017l-.642 .005l-.642 -.005l-.616 -.017l-.299 -.013l-.579 -.034l-.553 -.046c-4.785 -.464 -6.732 -2.411 -7.196 -7.196l-.046 -.553l-.034 -.579a28.058 28.058 0 0 1 -.013 -.299l-.017 -.616c-.003 -.21 -.005 -.424 -.005 -.642l.001 -.324l.004 -.318l.017 -.616l.013 -.299l.034 -.579l.046 -.553c.464 -4.785 2.411 -6.732 7.196 -7.196l.553 -.046l.579 -.034c.098 -.005 .198 -.01 .299 -.013l.616 -.017c.21 -.003 .424 -.005 .642 -.005zm0 6a1 1 0 0 0 -1 1v2h-2l-.117 .007a1 1 0 0 0 .117 1.993h2v2l.007 .117a1 1 0 0 0 1.993 -.117v-2h2l.117 -.007a1 1 0 0 0 -.117 -1.993h-2v-2l-.007 -.117a1 1 0 0 0 -.993 -.883z" fill="currentColor" stroke-width="0" /></svg>
                  Tambah Data
                </a> 
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-12">
                <form action="/prodi" method="GET">
                  <div class="row">
                    <div class="col-10">
                      <div class="form-group">
                        <input type="text" name="nama_prodi" id="nama_prodi" class="form-control" placeholder="Program Studi" value="{{ Request('nama_prodi') }}">
                      </div>
                    </div>
                    
                    <div class="col-2">
                      <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" />
                          </svg>
                          Cari
                        </button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-12">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Kode Prodi</th>
                      <th>Nama Prodi</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($prodi as $d)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $d->kode_prodi }}</td>
                          <td>{{ $d->nama_prodi }}</td>
                          <td>
                            
                              <div class="d-flex justify-content-between">
                                <div class="col-6">
                                  <a href="#" class="btn btn-info btn-icon" kode_prodi="{{ $d->kode_prodi }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                  </a>
                                </div>
                                <div class="col-6">
                                  <form method="POST" action="/prodi/{{ $d->kode_prodi }}/delete">
                                    @csrf
                                    <a href="#" class="btn btn-danger btn-icon delete-confirm" id="">
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
</div>

<div class="modal modal-blur fade" id="modal-inputprodi" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Data Program Studi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="/prodi/store" method="POST" id="frmProdi">
          @csrf
          <div class="row">
            <div class="col-12">
              <div class="input-icon mb-3">
                <span class="input-icon-addon">
                  <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-forms" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3a3 3 0 0 0 -3 3v12a3 3 0 0 0 3 3" /><path d="M6 3a3 3 0 0 1 3 3v12a3 3 0 0 1 -3 3" /><path d="M13 7h7a1 1 0 0 1 1 1v8a1 1 0 0 1 -1 1h-7" /><path d="M5 7h-1a1 1 0 0 0 -1 1v8a1 1 0 0 0 1 1h1" /><path d="M17 12h.01" /><path d="M13 12h.01" /></svg>
                </span>
                <input type="text" value="" id="nim" class="form-control" name="kode_prodi" placeholder="Kode Prodi">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="input-icon mb-3">
                <span class="input-icon-addon">
                  <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-circle" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" /></svg>
                </span>
                <input type="text" value="" id="nama_prodi" class="form-control" name="nama_prodi" placeholder="Nama Prodi">
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
<div class="modal modal-blur fade" id="modal-editprodi" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Data Prodi</h5>
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
        $('#btntambahProdi').click(function(){
          $("#modal-inputprodi").modal('show');
        });

        $('.edit').click(function(){
          var kode_prodi = $(this).attr('kode_prodi');
          $.ajax({
            type: 'POST',
            url: '/prodi/edit',
            cache: false,
            data:{
              _token: "{{ csrf_token(); }}",
              kode_prodi: kode_prodi
            },
            success:function(respond){
              $('#loadeditform').html(respond);
            }
          });
          $("#modal-editprodi").modal('show');
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

        $('#frmMahasiswa').submit(function(){
          var nim = $("#nim").val();
          var nama_lengkap = $("#nama_lengkap").val();
          var kelas = $("#kelas").val();
          var no_hp = $("#no_hp").val();
          var kode_prodi = $("frmMahasiswa").find("#kode_prodi").val();

          if(nim == ""){
            Swal.fire({
              title: "Perhatian",
              text: "NIM harus diisi!",
              icon: "warning",
              confirmButtonText: "Ok"
            });
            
            $("#nim").focus();
            return false;
          }

          if(nama_lengkap == ""){
            Swal.fire({
              title: "Perhatian",
              text: "Nama lengkap harus diisi!",
              icon: "warning",
              confirmButtonText: "Ok"
            });

            $("#nama_lengkap").focus();
            return false;
          }
          
          if(kelas == ""){
            Swal.fire({
              title: "Perhatian",
              text: "Kelas harus diisi!",
              icon: "warning",
              confirmButtonText: "Ok"
            });

            $("#kelas").focus();
            return false;
          }

          if(no_hp == ""){
            Swal.fire({
              title: "Perhatian",
              text: "No.Hp harus diisi!",
              icon: "warning",
              confirmButtonText: "Ok"
            });

            $("#no_hp").focus();
            return false;
          }
        });
      });
    </script>
@endpush

