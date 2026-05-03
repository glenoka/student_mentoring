<!DOCTYPE html>
<html>
<head>
    <style>
        /* Reset & Base Styles */
        body {
            font-family: 'Times New Roman', Times, serif; /* Font standar dokumen resmi */
            font-size: 12pt;
            line-height: 1.5;
            color: #333;
            margin: 0;
            padding:0;
        }

        @page {
    size: A4 portrait;
   margin: 4mm;
}
.container {
    width: 100%;
    padding: 0;
}

        /* Header / Kop Surat Styles */
        .header-container {
            display: table;
            width: 100%;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 2px;
        }

        .logo-cell {
            display: table-cell;
            width: 15%;
            vertical-align: middle;
            text-align: center;
        }

        .logo-cell svg {
            width: 80px;
            height: 80px;
        }

        .school-info-cell {
            display: table-cell;
            width: 85%;
            vertical-align: middle;
            text-align: center;
            padding-right: 80px; /* Offset for logo width to keep text centered */
        }

        .school-info-cell h3 {
            margin: 0;
            text-transform: uppercase;
            font-size: 14pt;
            letter-spacing: 1px;
        }

        .school-info-cell h2 {
            margin: 2px 0;
            text-transform: uppercase;
            font-size: 18pt;
            font-weight: bold;
        }

        .school-info-cell p {
            margin: 0;
            font-size: 10pt;
            font-style: italic;
        }

        .double-line {
            border-top: 1px solid #000;
            margin-top: 2px;
            margin-bottom: 20px;
        }

        /* Content Styles */
        .report-title {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            font-size: 14pt;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            background-color: #f2f2f2;
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10pt;
            border: 1.5px solid #000;
            padding: 10px 5px;
        }

        td {
            border: 1px solid #000;
            padding: 8px;
            font-size: 10pt;
            vertical-align: top;
        }

        .text-center {
            text-align: center;
        }

        /* Footer/Signatures */
        .footer-sign {
              margin-top: 20px;
    page-break-inside: avoid;
        }

        .sign-box {
            float: right;
            width: 250px;
            text-align: center;
        }

        .sign-space {
            height: 50px;
        }

        /* Print optimization */
        @media print {
            body { background-color: white; padding: 0; }
            .container { box-shadow: none; width: 100%; padding: 0; }
        }
    </style>
</head>
<body>

   <div class="container">
    <!-- KOP SURAT -->
    <div class="header-container">
        <div class="logo-cell">
            <!-- Placeholder Logo (Tunas Kelapa/Education Icon) -->
          <img src="{{ public_path('images/tutwuri.png') }}" width="60">
        </div>
        <div class="school-info-cell">
            <h3>Pemerintah Kabupaten Kupang</h3>
            <h3>Dinas Pendidikan dan Kebudayaan</h3>
            <h2>SMP NEGERI 10 TAKARI</h2>
            <p>Alamat: Jl. Pendidikan No. 10, Kec. Takari, Kab. Kupang</p>
            <p>Email: smpn10takari@email.com | Telp: 0812-3456-7890</p>
        </div>
    </div>
    <div class="double-line"></div>

    <!-- JUDUL LAPORAN -->
    <div class="report-title">
        Laporan Sesi Mentoring Siswa
    </div>

<div class="line"></div>


    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Siswa</th>
                <th>Topik</th>
                <th>Guru</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sessions as $index => $s)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($s->session_date)->format('d M Y') }}</td>
                    <td>{{ $s->studentTopic->student->name ?? '-' }}</td>
                    <td>{{ $s->studentTopic->topic->title ?? '-' }}</td>
                    <td>{{ $s->user->teacher->name ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer-sign">
        <div class="sign-box">
            <p>Takari, 22 Mei 2024</p>
            <p>Kepala Sekolah,</p>
            <div class="sign-space"></div>
            <p><strong><u>NAMA KEPALA SEKOLAH, M.Pd.</u></strong></p>
            <p>NIP. 19750101 200003 1 002</p>
        </div>
        <div style="clear: both;"></div>
    </div>
   </div>
</body>
</html>