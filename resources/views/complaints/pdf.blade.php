<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pengaduan</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
        th, td {
            border: 1px solid black;
            padding: 5px;
            text-align: left;
            word-wrap: break-word;
        }
        th {
            background-color: #f2f2f2;
        }
        .col-nama { width: 15%; }
        .col-whatsapp { width: 12%; }
        .col-kategori { width: 13%; }
        .col-isi { width: 20%; }
        .col-alamat { width: 20%; }
        .col-rt { width: 5%; }
        .col-bukti { width: 10%; }
        .col-tanggal { width: 15%; }
        .col-bukti img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <h1>Laporan Pengaduan</h1>

    <table>
        <thead>
            <tr>
                <th class="col-nama">Nama Lengkap</th>
                <th class="col-whatsapp">Nomor Whatsapp</th>
                <th class="col-kategori">Kategori Pengaduan</th>
                <th class="col-isi">Isi Pengaduan</th>
                <th class="col-alamat">Alamat Lengkap</th>
                <th class="col-rt">RT</th>
                <th class="col-bukti">Bukti</th>
                <th class="col-tanggal">Tanggal Laporan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($complaints as $complaint)
                <tr>
                    <td class="col-nama">{{ $complaint->nama_lengkap }}</td>
                    <td class="col-whatsapp">{{ $complaint->nomor_whatsapp }}</td>
                    <td class="col-kategori">{{ $complaint->kategori_pengaduan }}</td>
                    <td class="col-isi">{{ $complaint->isi_pengaduan }}</td>
                    <td class="col-alamat">{{ $complaint->alamat_lengkap }}</td>
                    <td class="col-rt">{{ $complaint->rt }}</td>
                    <td class="col-bukti">
                        @if($complaint->bukti)
                            <img src="{{ public_path('storage/' . $complaint->bukti) }}" alt="Bukti" width="100">
                        @else
                            Tidak Ada
                        @endif
                    </td>
                    <td class="col-tanggal">{{ $complaint->created_at->format('d-m-Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>