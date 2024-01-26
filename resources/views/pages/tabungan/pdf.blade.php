<!-- pages/kaskecil/pdf.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      font-size: 10px;
      font-family: Arial, Helvetica, sans-serif;
    }

    table {
      border-collapse: collapse;
      width: 100%;
    }

    table,
    th,
    td {
      border: 1px solid black;
    }

    th,
    td {
      padding: 10px;
    }

    th {

      background-color: cadetblue;
      font-size: 12px;

    }


    h1 {
      text-align: center;
      color: red;

    }

    h2 {
      text-align: center;
      text-decoration: underline;
    }
  </style>
</head>

<body>
  <h1>{{ $toko }}</h1>
  <h2>{{ $judul_laporan }}</h2>

  <table>
    <tr>
      <th>#</th>
      <th>Tanggal Trx</th>
      <th>Nomor Trx</th>
      <th>Nama Trx</th>
      <th>Debet</th>
      <th>Kredit</th>
      <th>Sisa Saldo</th>

    </tr>
    @foreach($tabungans as $tabungan)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $tabungan->tanggal_transaksi }}</td>
      <td>{{ $tabungan->no_transaksi }}</td>
      <td>{{ $tabungan->nama_transaksi }}</td>
      <td>{{ $tabungan->debet }}</td>
      <td>{{ $tabungan->kredit }}</td>
      <td>{{ $tabungan->saldo }}</td>

    </tr>
    @endforeach
  </table>
</body>

</html>