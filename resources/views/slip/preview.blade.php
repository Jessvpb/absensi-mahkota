<h2>Preview Gaji Bulan {{ $periode }}</h2>
<form method="GET" action="{{ route('slip.preview') }}">
    <label>Periode Gaji (YYYY-MM):</label>
    <input type="month" name="periode" value="{{ request('periode') ?? now()->format('Y-m') }}" required>

    <label>Pilih Cabang:</label>
    <select name="cabang_id">
        <option value="">Semua Cabang</option>
        @foreach(\App\Models\Cabang::all() as $cabang)
            <option value="{{ $cabang->id }}" {{ request('cabang_id') == $cabang->id ? 'selected' : '' }}>
                {{ $cabang->nama_cabang }}
            </option>
        @endforeach
    </select>

    <button type="submit">Lihat Gaji</button>
</form>

<table>
    <tr>
        <th>Nama</th>
        <th>Potongan Izin</th>
        <th>Potongan Denda</th>
        <th>Potongan Hutang</th>
        <th>Gaji Bersih</th>
    </tr>
    @foreach($data as $row)
    <tr>
        <td>{{ $row['staff']->nama }}</td>
        <td>{{ number_format($row['potongan_izin']) }}</td>
        <td>{{ number_format($row['potongan_kronologi']) }}</td>
        <td>{{ number_format($row['potongan_hutang']) }}</td>
        <td>{{ number_format($row['gaji_bersih']) }}</td>
    </tr>
    @endforeach
</table>

<form method="POST" action="{{ route('slip.jalankan') }}">
    @csrf
    <input type="hidden" name="periode" value="{{ $periode }}">
    <button type="submit">Jalankan Penggajian</button>
</form>
