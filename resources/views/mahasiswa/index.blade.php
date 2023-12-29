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
          Mahasiswa
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
                <a href="#" class="btn btn-primary" id="btntambahMahasiswa">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-square-rounded-plus-filled" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 2l.324 .001l.318 .004l.616 .017l.299 .013l.579 .034l.553 .046c4.785 .464 6.732 2.411 7.196 7.196l.046 .553l.034 .579c.005 .098 .01 .198 .013 .299l.017 .616l.005 .642l-.005 .642l-.017 .616l-.013 .299l-.034 .579l-.046 .553c-.464 4.785 -2.411 6.732 -7.196 7.196l-.553 .046l-.579 .034c-.098 .005 -.198 .01 -.299 .013l-.616 .017l-.642 .005l-.642 -.005l-.616 -.017l-.299 -.013l-.579 -.034l-.553 -.046c-4.785 -.464 -6.732 -2.411 -7.196 -7.196l-.046 -.553l-.034 -.579a28.058 28.058 0 0 1 -.013 -.299l-.017 -.616c-.003 -.21 -.005 -.424 -.005 -.642l.001 -.324l.004 -.318l.017 -.616l.013 -.299l.034 -.579l.046 -.553c.464 -4.785 2.411 -6.732 7.196 -7.196l.553 -.046l.579 -.034c.098 -.005 .198 -.01 .299 -.013l.616 -.017c.21 -.003 .424 -.005 .642 -.005zm0 6a1 1 0 0 0 -1 1v2h-2l-.117 .007a1 1 0 0 0 .117 1.993h2v2l.007 .117a1 1 0 0 0 1.993 -.117v-2h2l.117 -.007a1 1 0 0 0 -.117 -1.993h-2v-2l-.007 -.117a1 1 0 0 0 -.993 -.883z" fill="currentColor" stroke-width="0" /></svg>
                  Tambah Data
                </a> 
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-12">
                <form action="/mahasiswa" method="GET">
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group">
                        <input type="text" name="nama_mahasiswa" id="nama_mahasiswa" class="form-control" placeholder="Nama Mahasiswa" value="{{ Request('nama_mahasiswa') }}">
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="form-group">
                        <select name="kode_prodi" id="kode_prodi" class="form-select">
                          <option value="">Prodi</option>
                          @foreach ($prodi as $d)
                              <option {{ Request('kode_prodi')==$d->kode_prodi ? 'selected' : '' }} value="{{ $d->kode_prodi }}">{{ $d->nama_prodi }}</option>
                          @endforeach
                        </select>
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
                      <th>NIM</th>
                      <th>Nama</th>
                      <th>Kelas</th>
                      <th>Prodi</th>
                      <th>No HP</th>
                      <th>Foto</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($mahasiswa as $d)
                    @php
                        $path = Storage::url('upload/mahasiswa/'.$d->foto);
                    @endphp
                        <tr>
                          <td>{{ $loop->iteration + $mahasiswa->firstitem()-1 }}</td>
                          <td>{{ $d->nim }}</td>
                          <td>{{ $d->nama_lengkap }}</td>
                          <td>{{ $d->kelas }}</td>
                          <td>{{ $d->nama_prodi }}</td>
                          <td>{{ $d->no_hp }}</td>
                          <td>
                            @if (empty($d->foto))
                              <img src="{{ asset('assets/img/noimg.jpg') }}" class="avatar" alt="">
                            @else
                              <img src="{{ url($path) }}" class="avatar" alt="">
                            @endif
                          </td>
                          <td>
                            <div class="container">
                              <div class="col-12 d-flex justify-content-end">
                                <div class="col-6">
                                  <a href="#" class="edit btn btn-info btn-sm" nim="{{ $d->nim }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                  </a>
                                  <a href="/konfigurasi/{{ $d->nim }}/setjammatkul" class="btn btn-success btn-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-settings" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" /><path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" /></svg>
                                  </a>
                                </div>
                                <div class="col-6">
                                  <form method="POST" action="/mahasiswa/{{ $d->nim }}/delete">
                                    @csrf
                                    <a href="#" class="btn btn-danger btn-sm delete-confirm" id="">
                                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="non e" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                    </a>
                                  </form>
                                </div>
                              </div>
                            </div>
                          </td>
                        </tr>
                    @endforeach
                  </tbody>
                </table>
                {{ $mahasiswa->links('vendor.pagination.bootstrap-5') }}
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal modal-blur fade" id="modal-inputmahasiswa" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Data Mahasiswa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="/mahasiswa/store" method="POST" id="frmMahasiswa" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-12">
              <div class="input-icon mb-3">
                <span class="input-icon-addon">
                  <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-forms" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3a3 3 0 0 0 -3 3v12a3 3 0 0 0 3 3" /><path d="M6 3a3 3 0 0 1 3 3v12a3 3 0 0 1 -3 3" /><path d="M13 7h7a1 1 0 0 1 1 1v8a1 1 0 0 1 -1 1h-7" /><path d="M5 7h-1a1 1 0 0 0 -1 1v8a1 1 0 0 0 1 1h1" /><path d="M17 12h.01" /><path d="M13 12h.01" /></svg>
                </span>
                <input type="number" maxlength="8" value="" id="nim" class="form-control" name="nim" placeholder="NIM">
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
                <input type="text" value="" id="nama_lengkap" class="form-control" name="nama_lengkap" placeholder="Nama Mahasiswa">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="input-icon mb-3">
                <span class="input-icon-addon">
                  <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-book-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19 4v16h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12z" /><path d="M19 16h-12a2 2 0 0 0 -2 2" /><path d="M9 8h6" /></svg>
                </span>
                <input type="text" value="" id="kelas" class="form-control" name="kelas" placeholder="Kelas">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="input-icon mb-3">
                <span class="input-icon-addon">
                  <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-phone" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" /></svg>
                </span>
                <input type="text" value="" id="no_hp" class="form-control" name="no_hp" placeholder="No.Hp">
              </div>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-12">
              <select name="kode_prodi" id="kode_prodi" class="form-select">
                <option value="">Prodi</option>
                @foreach ($prodi as $d)
                    <option {{ Request('kode_prodi')==$d->kode_prodi ? 'selected' : '' }} value="{{ $d->kode_prodi }}">{{ $d->nama_prodi }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-12">
              <input type="file" name="foto" class="form-control">
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
<div class="modal modal-blur fade" id="modal-editmahasiswa" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Data Mahasiswa</h5>
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
      $('#nim').mask("00000000");
      $('#no_hp').mask("0000000000000");
      $(function(){
        $('#btntambahMahasiswa').click(function(){
          $("#modal-inputmahasiswa").modal('show');
        });

        $('.edit').click(function(){
          var nim = $(this).attr('nim');
          $.ajax({
            type: 'POST',
            url: '/mahasiswa/edit',
            cache: false,
            data:{
              _token: "{{ csrf_token(); }}",
              nim: nim
            },
            success:function(respond){
              $('#loadeditform').html(respond);
            }
          });
          $("#modal-editmahasiswa").modal('show');
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

