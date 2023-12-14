@extends('layouts.admin.tabler')
@section('content')
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <!-- Page pre-title -->
        <h2 class="page-title">
          Data Izin/Sakit
        </h2>
      </div>
    </div>
  </div>
</div>

<div class="page-body">
  <div class="container-xl">
    <div class="row">
      <div class="col-12">
        <form action="/epresensi/izinsakit" method="GET" autocomplete="off" >
          <div class="row">
            <div class="col-6">
              <div class="input-icon mb-3">
                <span class="input-icon-addon">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-event" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 5m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" /><path d="M16 3l0 4" /><path d="M8 3l0 4" /><path d="M4 11l16 0" /><path d="M8 15h2v2h-2z" /></svg>
                </span>
                <input type="text" value="{{ Request('dari') }}" id="dari" class="form-control" name="dari" placeholder="Dari Tanggal">
              </div>
            </div>
            <div class="col-6">
              <div class="input-icon mb-3">
                <span class="input-icon-addon">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-event" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 5m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" /><path d="M16 3l0 4" /><path d="M8 3l0 4" /><path d="M4 11l16 0" /><path d="M8 15h2v2h-2z" /></svg>
                </span>
                <input type="text" value="{{ Request('sampai') }}" id="sampai" class="form-control" name="sampai" placeholder="Sampai Tanggal">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-3">
              <div class="input-icon mb-3">
                <span class="input-icon-addon">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-forms" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3a3 3 0 0 0 -3 3v12a3 3 0 0 0 3 3" /><path d="M6 3a3 3 0 0 1 3 3v12a3 3 0 0 1 -3 3" /><path d="M13 7h7a1 1 0 0 1 1 1v8a1 1 0 0 1 -1 1h-7" /><path d="M5 7h-1a1 1 0 0 0 -1 1v8a1 1 0 0 0 1 1h1" /><path d="M17 12h.01" /><path d="M13 12h.01" /></svg>
                </span>
                <input type="text" value="{{ Request('nim') }}" id="nim" class="form-control" name="nim" placeholder="NIM">
              </div>
            </div>
            <div class="col-3">
              <div class="input-icon mb-3">
                <span class="input-icon-addon">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-circle" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" /></svg>
                </span>
                <input type="text" value="{{ Request('nama_mahasiswa') }}" id="nama_mahasiswa" class="form-control" name="nama_mahasiswa" placeholder="Nama Mahasiswa">
              </div>
            </div>
            <div class="col-3">
              <div class="form-group">
                <select name="status_approved" id="status_approved" class="form-select" >
                  <option value="">Pilih Status</option>
                  <option value="0" {{ Request('status_approved') === "0" ? 'selected' : ""}}>Pending</option>
                  <option value="1" {{ Request('status_approved') === "1" ? 'selected' : ""}}>Disetujui</option>
                  <option value="2" {{ Request('status_approved') === "2" ? 'selected' : ""}}>Ditolak</option>
                </select>
              </div>
            </div>
            <div class="col-3">
              <div class="form-group">
                <button class="btn btn-primary" type="submit">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
                  Cari
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>No</th>
              <th>Tanggal</th>
              <th>NIM</th>
              <th>Nama Mahasiswa</th>
              <th>Kelas</th>
              <th>Satus</th>
              <th>Keterangan</th>
              <th>Status Approve</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($izinsakit as $d)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ date('d-m-Y', strtotime($d->tgl_izin)) }}</td>
                  <td>{{ $d->nim }}</td>
                  <td>{{ $d->nama_lengkap }}</td>
                  <td>{{ $d->kelas }}</td>
                  <td>{{ $d->status == 'i' ? 'Izin' : 'Sakit' }}</td>
                  <td>{{ $d->keterangan }}</td>
                  <td>
                    @if ( $d->status_approved == 1 )
                        <span class="badge bg-success text-light">Disetujui</span>
                    @elseif( $d->status_approved == 2 )
                        <span class="badge bg-danger text-light">Ditolak</span>
                    @else
                        <span class="badge bg-warning text-light">Pending</span>
                    @endif
                  </td>
                  <td>
                    @if ($d->status_approved == 0)
                      <a href="#" class="btn btn-sm btn-primary" id="approve" id_izinsakit="{{ $d->id }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                        Edit
                      </a>
                    @else
                      <a href="/presensi/{{ $d->id }}/batalkanizinsakit" class="btn btn-sm btn-danger">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M10 10l4 4m0 -4l-4 4" /></svg>
                        Batalkan
                      </a>
                    @endif
                  </td>
                </tr>
            @endforeach
          </tbody>
        </table>
        {{ $izinsakit->links('vendor.pagination.bootstrap-5') }}
      </div>
    </div>
  </div>
</div>

{{-- Model Edit --}}
<div class="modal modal-blur fade" id="modal-izinsakit" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Data Izin/Sakit Mahasiswa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body " id="loadmap">
        <form action="/presensi/approveizinsakit" method="post">
          @csrf
          <input type="hidden" id="id_izinsakit_form" name="id_izinsakit_form">
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <select name="status_approved" id="status_approved" class="form-select">
                  <option value="1">Disetujui</option>
                  <option value="2">Ditolak</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row mt-1">
            <div class="col-12">
              <div class="form-group">
                <button class="btn btn-primary w-100" type="submit">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M9 12l2 2l4 -4" /></svg>
                  Submit
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection

@push('myscript')
    <script>
      $(function(){
        $("#approve").click(function(e){
          e.preventDefault();
          var id_izinsakit = $(this).attr('id_izinsakit');
          $('#id_izinsakit_form').val(id_izinsakit);
          $("#modal-izinsakit").modal("show");
        });

        $("#dari, #sampai").datepicker({ 
          autoclose: true, 
          todayHighlight: true,
          format: 'yyyy-mm-dd'
        });
      });
    </script>
@endpush
