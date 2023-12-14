@php
    function selisih($jam_masuk, $jam_keluar)
    {
      list($h, $m, $s) = explode(":", $jam_masuk);
      $dtAwal = mktime($h, $m, $s, "1", "1", "1");
      list($h, $m, $s) = explode(":", $jam_keluar);
      $dtAkhir = mktime($h, $m, $s, "1", "1", "1");
      $dtSelisih = $dtAkhir - $dtAwal;
      $totalmenit = $dtSelisih / 60;
      $jam = explode(".", $totalmenit / 60);
      $sisamenit = ($totalmenit / 60) - $jam[0];
      $sisamenit2 = $sisamenit * 60;
      $jml_jam = $jam[0];
      return $jml_jam . " jam " . round($sisamenit2) . " menit";
    }
@endphp
@foreach ($presensi as $d)
@php
    $foto_in = Storage::url('public/upload/absensi'.$d->foto_in);
    $foto_out = Storage::url('public/upload/absensi'.$d->foto_out);
@endphp
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $d->nim }}</td>
      <td>{{ $d->nama_lengkap }}</td>
      <td>{{ $d->nama_prodi }}</td>
      <td>{{ $d->jam_in }}</td>
      <td>
        <img src="{{ url($foto_in) }}" class="avatar">
      </td>
      <td>{!! $d->jam_out != null ? $d->jam_out :  '<span class="badge bg-danger text-light">Belum Absen</span>' !!}</td>
      <td>
        @if ( $d->jam_out != null )
        <img src="{{ url($foto_out) }}" class="avatar">
        @else
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M10 10l4 4m0 -4l-4 4" /></svg>
        @endif
      </td>
      <td>
        @if ($d->jam_in >= '07:00')
        @php
            $jam_terlambat =  selisih('07:00:00', $d->jam_in);
        @endphp
            <span class="badge bg-danger text-light">Terlambat {{ $jam_terlambat }}</span>
        @else
            <span class="badge bg-success text-light">Tepat waktu</span>
        @endif
      </td>
      <td>
        <a href="#" class="btn btn-primary tampilkanpeta" id="{{ $d->id }}">
          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-map-pins" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.828 9.828a4 4 0 1 0 -5.656 0l2.828 2.829l2.828 -2.829z" /><path d="M8 7l0 .01" /><path d="M18.828 17.828a4 4 0 1 0 -5.656 0l2.828 2.829l2.828 -2.829z" /><path d="M16 15l0 .01" /></svg>
        </a>
      </td>
    </tr>
@endforeach

<script>
  $(function(){
    $(".tampilkanpeta").click(function(e){
      var id = $(this).attr("id");
      $.ajax({
        type: 'POST',
        url: '/tampilkanpeta',
        data: {
          _token: "{{ csrf_token() }}",
          id: id
        },
        success: function(respond){
          $('#loadmap').html(respond);
        },
        cache: false
      });
      $("#modal-tampilkanpeta").modal("show");
    });
  });
</script>