<!DOCTYPE html>
<html>

<head>
    <style>
        /* Reset & Base Styles */
        body {
            font-family: 'Times New Roman', Times, serif;
            /* Font standar dokumen resmi */
            font-size: 12pt;
            line-height: 1.5;
            color: #333;
            margin: 0;
            padding: 0;
        }

        @page {
            size: A4 portrait;
            margin: 10mm;
        }

        .container {
            width: 100%;
            padding: 0;
        }

        /* Header / Kop Surat Styles */
        /* Header / Kop Surat Styles */
        .header-container {
            display: table;
            width: 100%;
            table-layout: fixed;
            /* KUNCI: Memaksa lebar kolom konsisten */
            border-collapse: collapse;
        }

        .logo-cell {
            display: table-cell;
            width: 80px;
            /* Samakan lebar kiri dan kanan agar tengah seimbang */
            vertical-align: middle;
            text-align: center;
        }

        .logo-cell img {
            width: 70px;
            height: auto;
        }

        .school-info-cell {
            display: table-cell;
            width: 85%;
            vertical-align: middle;
            text-align: center;
            padding-right: 10px;
            /* Offset for logo width to keep text centered */
        }

        /* Menggunakan font Sans-Serif yang seragam untuk seluruh header sesuai gambar */
        .school-info-cell h3,
        .school-info-cell h2,
        .school-info-cell .address {
            font-family: Arial, Helvetica, sans-serif;
        }

        .school-info-cell h3 {
            margin: 0;
            text-transform: uppercase;
            font-size: 11pt;
            letter-spacing: 0.5px;
            font-weight: bold;
            line-height: 1.1;
            /* Membuat baris lebih mepet */
        }

        .school-info-cell h2 {
            margin: 0;
            text-transform: uppercase;
            font-size: 12pt;
            font-weight: bold;
            line-height: 1.1;
            /* Membuat baris lebih mepet */
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
            body {
                background-color: white;
                padding: 0;
            }

            .container {
                box-shadow: none;
                width: 100%;
                padding: 0;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <!-- KOP SURAT -->
        <div class="header-container">
            <!-- Logo Kiri (Kabupaten Kupang) -->
            <div class="logo-cell">
                <!-- Gunakan <img src="link_ke_logo_kupang.png"> jika sudah ada file -->
                <img src="{{ public_path('images/kupang.png') }}">
            </div>

            <!-- Informasi Sekolah Sesuai Teks Gambar -->
            <div class="school-info-cell">
                <h3>Pemerintah Kabupaten Kupang</h3>
                <h3>Dinas Pendidikan dan Kebudayaan</h3>
                <h2>UPTD SEKOLAH MENENGAH PERTAMA NEGERI 10 OESUSU TAKARI</h3>
                    <p class="address">Jln. Timor Raya km 66 Desa Oesusu, Kec. Takari NPSN 69752277</p>
            </div>

            <!-- Logo Kanan (Tut Wuri Handayani) -->
            <div class="logo-cell">
                <img src="{{ public_path('images/tutwuri.png') }}">
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
                    <th>Status</th>
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
                        @php
                            $statuses = [
                                'in_progress' => 'Sedang Berjalan',
                                'completed' => 'Selesai',
                            ];
                        @endphp

                        <td>
                            {{ $statuses[$s->studentTopic->status] ?? '-' }}
                        </td>
                        <td>{{ $s->user->teacher->name ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="footer-sign">
            <div class="sign-box">
                <div style="font-size: 10pt; line-height: 1;">
                  <p>Takari, {{ now()->translatedFormat('d F Y') }}</p>
                    <p>Kepala Sekolah,</p>
                    <br>
                    <p><strong>NAMA KEPALA SEKOLAH, M.Pd.</strong></p>
                    <p>NIP. 19750101 200003 1 002</p>
                </div>
            </div>
            <div style="clear: both;"></div>
        </div>
    </div>
</body>

</html>