<?php include './partials/header.php'?>
<?php 


$sqlKecamatan = "SELECT * FROM kecamatan";
$resultKecamatan = $conn->query($sqlKecamatan);
$dataKecamatan = array(); // initialize an empty array to store the rows
while ($row = $resultKecamatan->fetch_assoc()) {
  $dataKecamatan[] = $row; // append each row to the data array
}

$id = isset($_GET['id']) ? $_GET['id'] : $dataKecamatan[0]['id'];

$sqlTPS = "SELECT * FROM tps";
$result = $conn->query($sqlTPS);
$dataTPS = array(); // initialize an empty array to store the rows
while ($row = $result->fetch_assoc()) {
    $dataTPS[] = $row; // append each row to the data array
}


$sql = "SELECT *, 
kecamatan.id as idKecamatan,
kecamatan.kecamatan as kecamatan,
pemilih.id as idPemilih,
pemilih.kelurahan as pemilihKelurahan,
pemilih.kecamatan as pemilihKecamatan,
pemilih.kota as pemilihKota,
tps_asal.id as tpsAsalId,
tps_asal.no_tps as tpsAsalNo,
tps_asal.kelurahan as tpsAsalKelurahan,
tps_asal.kecamatan as tpsAsalKecamatan,
tps_asal.kota as tpsAsalKota, 
tps_asal.provinsi as tpsAsalProvinsi,
tps_pindah.id as tpsPindahId,
tps_pindah.no_tps as tpsPindahNo,
tps_pindah.kelurahan as tpsPindahKelurahan,
tps_pindah.kecamatan as tpsPindahKecamatan,
tps_pindah.kota as tpsPindahKota, 
tps_pindah.provinsi as tpsPindahProvinsi,
kecamatanAsal.kecamatan as kecamatanAsal, 
kecamatanAsal.id as kecamatanAsalId,
kecamatanPindah.kecamatan as kecamatanPindah, 
kecamatanPindah.id as kecamatanPindahId
FROM pemilih 
LEFT JOIN kecamatan ON kecamatan.id=pemilih.kecamatan
LEFT JOIN tps as tps_asal ON pemilih.tps_asal=tps_asal.id
LEFT JOIN tps as tps_pindah ON pemilih.tps_tujuan_pindah=tps_pindah.id
LEFT JOIN kecamatan as kecamatanAsal ON tps_asal.kecamatan=kecamatanAsal.id
LEFT JOIN kecamatan as kecamatanPindah ON tps_pindah.kecamatan=kecamatanPindah.id
WHERE pemilih.kecamatan=$id";
$result = $conn->query($sql);
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$sqlPemilihSemua = "SELECT
k.kecamatan,
SUM(CASE WHEN p.status_pemilih = 'Khusus' THEN 1 ELSE 0 END) AS Khusus,
SUM(CASE WHEN p.status_pemilih = 'Pindah Tugas' THEN 1 ELSE 0 END) AS Pindah_Tugas,
SUM(CASE WHEN p.status_pemilih = 'Pindah Karena Sakit' THEN 1 ELSE 0 END) AS Pindah_Karena_Sakit,
SUM(CASE WHEN p.status_pemilih = 'Tahanan dan Pidana' THEN 1 ELSE 0 END) AS Tahanan_dan_Pidana,
SUM(CASE WHEN p.status_pemilih = 'Bencana' THEN 1 ELSE 0 END) AS Bencana,
SUM(CASE WHEN p.status_pemilih = 'Rawat Inap' THEN 1 ELSE 0 END) AS Rawat_Inap,
SUM(CASE WHEN p.status_pemilih = 'Mendampingi Keluarga Rawat Inap' THEN 1 ELSE 0 END) AS Mendampingi_Keluarga_Rawat_Inap,
SUM(CASE WHEN p.status_pemilih = 'Disabilitas' THEN 1 ELSE 0 END) AS Disabilitas,
SUM(CASE WHEN p.status_pemilih = 'Narkoba' THEN 1 ELSE 0 END) AS Narkoba,
SUM(CASE WHEN p.status_pemilih = 'Tugas Belajar' THEN 1 ELSE 0 END) AS Tugas_Belajar,
SUM(CASE WHEN p.status_pemilih = 'Pindah Domisili' THEN 1 ELSE 0 END) AS Pindah_Domisili,
SUM(CASE WHEN p.status_pemilih = 'Bekerja di Luar Domisili' THEN 1 ELSE 0 END) AS Bekerja_di_Luar_Domisili,
SUM(CASE WHEN p.status_pemilih = 'Lainnya' THEN 1 ELSE 0 END) AS Lainnya
FROM
pemilih AS p
JOIN
kecamatan AS k ON p.kecamatan = k.id
GROUP BY
k.kecamatan;";
$result = $conn->query($sqlPemilihSemua);
$dataJumlahPemilihSemua = array();
while ($row = $result->fetch_assoc()) {
  $dataJumlahPemilihSemua[] = $row;
}

$sqlPemilihSemuaKecamatan = "SELECT
k.kecamatan,
SUM(CASE WHEN p.status_pemilih = 'Khusus' THEN 1 ELSE 0 END) AS Khusus,
SUM(CASE WHEN p.status_pemilih = 'Pindah Tugas' THEN 1 ELSE 0 END) AS Pindah_Tugas,
SUM(CASE WHEN p.status_pemilih = 'Pindah Karena Sakit' THEN 1 ELSE 0 END) AS Pindah_Karena_Sakit,
SUM(CASE WHEN p.status_pemilih = 'Tahanan dan Pidana' THEN 1 ELSE 0 END) AS Tahanan_dan_Pidana,
SUM(CASE WHEN p.status_pemilih = 'Bencana' THEN 1 ELSE 0 END) AS Bencana,
SUM(CASE WHEN p.status_pemilih = 'Rawat Inap' THEN 1 ELSE 0 END) AS Rawat_Inap,
SUM(CASE WHEN p.status_pemilih = 'Mendampingi Keluarga Rawat Inap' THEN 1 ELSE 0 END) AS Mendampingi_Keluarga_Rawat_Inap,
SUM(CASE WHEN p.status_pemilih = 'Disabilitas' THEN 1 ELSE 0 END) AS Disabilitas,
SUM(CASE WHEN p.status_pemilih = 'Narkoba' THEN 1 ELSE 0 END) AS Narkoba,
SUM(CASE WHEN p.status_pemilih = 'Tugas Belajar' THEN 1 ELSE 0 END) AS Tugas_Belajar,
SUM(CASE WHEN p.status_pemilih = 'Pindah Domisili' THEN 1 ELSE 0 END) AS Pindah_Domisili,
SUM(CASE WHEN p.status_pemilih = 'Bekerja di Luar Domisili' THEN 1 ELSE 0 END) AS Bekerja_di_Luar_Domisili,
SUM(CASE WHEN p.status_pemilih = 'Lainnya' THEN 1 ELSE 0 END) AS Lainnya
FROM pemilih AS p
JOIN kecamatan AS k ON p.kecamatan = k.id
WHERE k.id='$id'
GROUP BY k.kecamatan
";
$result = $conn->query($sqlPemilihSemuaKecamatan);
$dataJumlahPemilihSemuaKecamatan = array();
while ($row = $result->fetch_assoc()) {
  $dataJumlahPemilihSemuaKecamatan[] = $row;
}

$sqlPemilihKhusus = "SELECT
*,
kecamatan.id as idKecamatan,
kecamatan.kecamatan as kecamatan,
pemilih.id as id,
pemilih.kelurahan as pemilihKelurahan,
pemilih.kecamatan as pemilihKecamatan,
pemilih.kota as pemilihKota,
tps_asal.id as tpsAsalId,
tps_asal.no_tps as tpsAsalNo,
tps_asal.kelurahan as tpsAsalKelurahan,
tps_asal.kecamatan as tpsAsalKecamatan,
tps_asal.kota as tpsAsalKota, 
tps_asal.provinsi as tpsAsalProvinsi,
kecamatanAsal.kecamatan as kecamatanAsal, 
kecamatanAsal.id as kecamatanAsalId
FROM pemilih
LEFT JOIN kecamatan ON pemilih.kecamatan = kecamatan.id
LEFT JOIN tps as tps_asal ON tps_asal.id=pemilih.tps_asal
LEFT JOIN kecamatan as kecamatanAsal ON tps_asal.kecamatan = kecamatanAsal.id
WHERE pemilih.status_pemilih = 'Khusus'
";
$result = $conn->query($sqlPemilihKhusus);
$dataPemilihKhusus = array();
while ($row = $result->fetch_assoc()) {
  $dataPemilihKhusus[] = $row;
}

$sqlPemilihPindahTugas = "SELECT
*,
kecamatan.id as idKecamatan,
kecamatan.kecamatan as kecamatan,
pemilih.id as id,
pemilih.kelurahan as pemilihKelurahan,
pemilih.kecamatan as pemilihKecamatan,
pemilih.kota as pemilihKota,
tps_asal.id as tpsAsalId,
tps_asal.no_tps as tpsAsalNo,
tps_asal.kelurahan as tpsAsalKelurahan,
tps_asal.kecamatan as tpsAsalKecamatan,
tps_asal.kota as tpsAsalKota, 
tps_asal.provinsi as tpsAsalProvinsi,
kecamatanAsal.kecamatan as kecamatanAsal, 
kecamatanAsal.id as kecamatanAsalId,
tps_pindah.no_tps as tpsPindahNo,
tps_pindah.kelurahan as tpsPindahKelurahan,
tps_pindah.kecamatan as tpsPindahKecamatan,
tps_pindah.kota as tpsPindahKota, 
tps_pindah.provinsi as tpsPindahProvinsi,
kecamatanPindah.kecamatan as kecamatanPindah, 
kecamatanPindah.id as kecamatanPindahId
FROM pemilih
LEFT JOIN kecamatan ON pemilih.kecamatan = kecamatan.id
LEFT JOIN tps as tps_asal ON tps_asal.id=pemilih.tps_asal
LEFT JOIN tps as tps_pindah ON tps_pindah.id=pemilih.tps_tujuan_pindah
LEFT JOIN kecamatan as kecamatanAsal ON tps_asal.kecamatan = kecamatanAsal.id
LEFT JOIN kecamatan as kecamatanPindah ON tps_pindah.kecamatan = kecamatanPindah.id
WHERE pemilih.status_pemilih = 'Pindah Tugas'
";
$result = $conn->query($sqlPemilihPindahTugas);
while ($row = $result->fetch_assoc()) {
  $dataPemilihPindahTugas[] = $row;
}

$sqlPemilihPindahSakit = "SELECT
*,
kecamatan.id as idKecamatan,
kecamatan.kecamatan as kecamatan,
pemilih.id as id,
pemilih.kelurahan as pemilihKelurahan,
pemilih.kecamatan as pemilihKecamatan,
pemilih.kota as pemilihKota,
tps_asal.id as tpsAsalId,
tps_asal.no_tps as tpsAsalNo,
tps_asal.kelurahan as tpsAsalKelurahan,
tps_asal.kecamatan as tpsAsalKecamatan,
tps_asal.kota as tpsAsalKota, 
tps_asal.provinsi as tpsAsalProvinsi,
kecamatanAsal.kecamatan as kecamatanAsal, 
kecamatanAsal.id as kecamatanAsalId,
tps_pindah.no_tps as tpsPindahNo,
tps_pindah.kelurahan as tpsPindahKelurahan,
tps_pindah.kecamatan as tpsPindahKecamatan,
tps_pindah.kota as tpsPindahKota, 
tps_pindah.provinsi as tpsPindahProvinsi,
kecamatanPindah.kecamatan as kecamatanPindah, 
kecamatanPindah.id as kecamatanPindahId
FROM pemilih
LEFT JOIN kecamatan ON pemilih.kecamatan = kecamatan.id
LEFT JOIN tps as tps_asal ON tps_asal.id=pemilih.tps_asal
LEFT JOIN tps as tps_pindah ON tps_pindah.id=pemilih.tps_tujuan_pindah
LEFT JOIN kecamatan as kecamatanAsal ON tps_asal.kecamatan = kecamatanAsal.id
LEFT JOIN kecamatan as kecamatanPindah ON tps_pindah.kecamatan = kecamatanPindah.id
WHERE pemilih.status_pemilih = 'Pindah Karena Sakit'
";
$result = $conn->query($sqlPemilihPindahSakit);
$dataPemilihPindahSakit = array();
while ($row = $result->fetch_assoc()) {
  $dataPemilihPindahSakit[] = $row;
}

$sqlPemilihPindahPidana = "SELECT
*,
kecamatan.id as idKecamatan,
kecamatan.kecamatan as kecamatan,
pemilih.id as id,
pemilih.kelurahan as pemilihKelurahan,
pemilih.kecamatan as pemilihKecamatan,
pemilih.kota as pemilihKota,
tps_asal.id as tpsAsalId,
tps_asal.no_tps as tpsAsalNo,
tps_asal.kelurahan as tpsAsalKelurahan,
tps_asal.kecamatan as tpsAsalKecamatan,
tps_asal.kota as tpsAsalKota, 
tps_asal.provinsi as tpsAsalProvinsi,
kecamatanAsal.kecamatan as kecamatanAsal, 
kecamatanAsal.id as kecamatanAsalId,
tps_pindah.no_tps as tpsPindahNo,
tps_pindah.kelurahan as tpsPindahKelurahan,
tps_pindah.kecamatan as tpsPindahKecamatan,
tps_pindah.kota as tpsPindahKota, 
tps_pindah.provinsi as tpsPindahProvinsi,
kecamatanPindah.kecamatan as kecamatanPindah, 
kecamatanPindah.id as kecamatanPindahId
FROM pemilih
LEFT JOIN kecamatan ON pemilih.kecamatan = kecamatan.id
LEFT JOIN tps as tps_asal ON tps_asal.id=pemilih.tps_asal
LEFT JOIN tps as tps_pindah ON tps_pindah.id=pemilih.tps_tujuan_pindah
LEFT JOIN kecamatan as kecamatanAsal ON tps_asal.kecamatan = kecamatanAsal.id
LEFT JOIN kecamatan as kecamatanPindah ON tps_pindah.kecamatan = kecamatanPindah.id
WHERE pemilih.status_pemilih = 'Tahanan dan Pidana'
";
$result = $conn->query($sqlPemilihPindahPidana);
$dataPemilihPindahPidana = array();
while ($row = $result->fetch_assoc()) {
  $dataPemilihPindahPidana[] = $row;
}

$sqlPemilihPindahBencana = "SELECT
*,
kecamatan.id as idKecamatan,
kecamatan.kecamatan as kecamatan,
pemilih.id as id,
pemilih.kelurahan as pemilihKelurahan,
pemilih.kecamatan as pemilihKecamatan,
pemilih.kota as pemilihKota,
tps_asal.id as tpsAsalId,
tps_asal.no_tps as tpsAsalNo,
tps_asal.kelurahan as tpsAsalKelurahan,
tps_asal.kecamatan as tpsAsalKecamatan,
tps_asal.kota as tpsAsalKota, 
tps_asal.provinsi as tpsAsalProvinsi,
kecamatanAsal.kecamatan as kecamatanAsal, 
kecamatanAsal.id as kecamatanAsalId,
tps_pindah.no_tps as tpsPindahNo,
tps_pindah.kelurahan as tpsPindahKelurahan,
tps_pindah.kecamatan as tpsPindahKecamatan,
tps_pindah.kota as tpsPindahKota, 
tps_pindah.provinsi as tpsPindahProvinsi,
kecamatanPindah.kecamatan as kecamatanPindah, 
kecamatanPindah.id as kecamatanPindahId
FROM pemilih
LEFT JOIN kecamatan ON pemilih.kecamatan = kecamatan.id
LEFT JOIN tps as tps_asal ON tps_asal.id=pemilih.tps_asal
LEFT JOIN tps as tps_pindah ON tps_pindah.id=pemilih.tps_tujuan_pindah
LEFT JOIN kecamatan as kecamatanAsal ON tps_asal.kecamatan = kecamatanAsal.id
LEFT JOIN kecamatan as kecamatanPindah ON tps_pindah.kecamatan = kecamatanPindah.id
WHERE pemilih.status_pemilih = 'Bencana'
";
$result = $conn->query($sqlPemilihPindahBencana);
$dataPemilihPindahBencana = array();
while ($row = $result->fetch_assoc()) {
  $dataPemilihPindahBencana[] = $row;
}

$sqlPemilihPindahRawatInap = "SELECT
*,
kecamatan.id as idKecamatan,
kecamatan.kecamatan as kecamatan,
pemilih.id as id,
pemilih.kelurahan as pemilihKelurahan,
pemilih.kecamatan as pemilihKecamatan,
pemilih.kota as pemilihKota,
tps_asal.id as tpsAsalId,
tps_asal.no_tps as tpsAsalNo,
tps_asal.kelurahan as tpsAsalKelurahan,
tps_asal.kecamatan as tpsAsalKecamatan,
tps_asal.kota as tpsAsalKota, 
tps_asal.provinsi as tpsAsalProvinsi,
kecamatanAsal.kecamatan as kecamatanAsal, 
kecamatanAsal.id as kecamatanAsalId,
tps_pindah.no_tps as tpsPindahNo,
tps_pindah.kelurahan as tpsPindahKelurahan,
tps_pindah.kecamatan as tpsPindahKecamatan,
tps_pindah.kota as tpsPindahKota, 
tps_pindah.provinsi as tpsPindahProvinsi,
kecamatanPindah.kecamatan as kecamatanPindah, 
kecamatanPindah.id as kecamatanPindahId
FROM pemilih
LEFT JOIN kecamatan ON pemilih.kecamatan = kecamatan.id
LEFT JOIN tps as tps_asal ON tps_asal.id=pemilih.tps_asal
LEFT JOIN tps as tps_pindah ON tps_pindah.id=pemilih.tps_tujuan_pindah
LEFT JOIN kecamatan as kecamatanAsal ON tps_asal.kecamatan = kecamatanAsal.id
LEFT JOIN kecamatan as kecamatanPindah ON tps_pindah.kecamatan = kecamatanPindah.id
WHERE pemilih.status_pemilih = 'Rawat Inap' AND pemilih.status_pemilih = 'Mendampingi Keluarga Rawat Inap'
";
$result = $conn->query($sqlPemilihPindahRawatInap);
$dataPemilihPindahRawatInap = array();
while ($row = $result->fetch_assoc()) {
  $dataPemilihPindahRawatInap[] = $row;
}

$sqlPemilihPindahDisabilitas = "SELECT
*,
kecamatan.id as idKecamatan,
kecamatan.kecamatan as kecamatan,
pemilih.id as id,
pemilih.kelurahan as pemilihKelurahan,
pemilih.kecamatan as pemilihKecamatan,
pemilih.kota as pemilihKota,
tps_asal.id as tpsAsalId,
tps_asal.no_tps as tpsAsalNo,
tps_asal.kelurahan as tpsAsalKelurahan,
tps_asal.kecamatan as tpsAsalKecamatan,
tps_asal.kota as tpsAsalKota, 
tps_asal.provinsi as tpsAsalProvinsi,
kecamatanAsal.kecamatan as kecamatanAsal, 
kecamatanAsal.id as kecamatanAsalId,
tps_pindah.no_tps as tpsPindahNo,
tps_pindah.kelurahan as tpsPindahKelurahan,
tps_pindah.kecamatan as tpsPindahKecamatan,
tps_pindah.kota as tpsPindahKota, 
tps_pindah.provinsi as tpsPindahProvinsi,
kecamatanPindah.kecamatan as kecamatanPindah, 
kecamatanPindah.id as kecamatanPindahId
FROM pemilih
LEFT JOIN kecamatan ON pemilih.kecamatan = kecamatan.id
LEFT JOIN tps as tps_asal ON tps_asal.id=pemilih.tps_asal
LEFT JOIN tps as tps_pindah ON tps_pindah.id=pemilih.tps_tujuan_pindah
LEFT JOIN kecamatan as kecamatanAsal ON tps_asal.kecamatan = kecamatanAsal.id
LEFT JOIN kecamatan as kecamatanPindah ON tps_pindah.kecamatan = kecamatanPindah.id
WHERE pemilih.status_pemilih = 'Disabilitas'
";
$result = $conn->query($sqlPemilihPindahDisabilitas);
$dataPemilihPindahDisabilitas = array();
while ($row = $result->fetch_assoc()) {
  $dataPemilihPindahDisabilitas[] = $row;
}

$sqlPemilihPindahNarkoba = "SELECT
*,
kecamatan.id as idKecamatan,
kecamatan.kecamatan as kecamatan,
pemilih.id as id,
pemilih.kelurahan as pemilihKelurahan,
pemilih.kecamatan as pemilihKecamatan,
pemilih.kota as pemilihKota,
tps_asal.id as tpsAsalId,
tps_asal.no_tps as tpsAsalNo,
tps_asal.kelurahan as tpsAsalKelurahan,
tps_asal.kecamatan as tpsAsalKecamatan,
tps_asal.kota as tpsAsalKota, 
tps_asal.provinsi as tpsAsalProvinsi,
kecamatanAsal.kecamatan as kecamatanAsal, 
kecamatanAsal.id as kecamatanAsalId,
tps_pindah.no_tps as tpsPindahNo,
tps_pindah.kelurahan as tpsPindahKelurahan,
tps_pindah.kecamatan as tpsPindahKecamatan,
tps_pindah.kota as tpsPindahKota, 
tps_pindah.provinsi as tpsPindahProvinsi,
kecamatanPindah.kecamatan as kecamatanPindah, 
kecamatanPindah.id as kecamatanPindahId
FROM pemilih
LEFT JOIN kecamatan ON pemilih.kecamatan = kecamatan.id
LEFT JOIN tps as tps_asal ON tps_asal.id=pemilih.tps_asal
LEFT JOIN tps as tps_pindah ON tps_pindah.id=pemilih.tps_tujuan_pindah
LEFT JOIN kecamatan as kecamatanAsal ON tps_asal.kecamatan = kecamatanAsal.id
LEFT JOIN kecamatan as kecamatanPindah ON tps_pindah.kecamatan = kecamatanPindah.id
WHERE pemilih.status_pemilih = 'Narkoba'
";
$result = $conn->query($sqlPemilihPindahNarkoba);
$dataPemilihPindahNarkoba = array();
while ($row = $result->fetch_assoc()) {
  $dataPemilihPindahNarkoba[] = $row;
}

$sqlPemilihPindahTugasBelajar = "SELECT
*,
kecamatan.id as idKecamatan,
kecamatan.kecamatan as kecamatan,
pemilih.id as id,
pemilih.kelurahan as pemilihKelurahan,
pemilih.kecamatan as pemilihKecamatan,
pemilih.kota as pemilihKota,
tps_asal.id as tpsAsalId,
tps_asal.no_tps as tpsAsalNo,
tps_asal.kelurahan as tpsAsalKelurahan,
tps_asal.kecamatan as tpsAsalKecamatan,
tps_asal.kota as tpsAsalKota, 
tps_asal.provinsi as tpsAsalProvinsi,
kecamatanAsal.kecamatan as kecamatanAsal, 
kecamatanAsal.id as kecamatanAsalId,
tps_pindah.no_tps as tpsPindahNo,
tps_pindah.kelurahan as tpsPindahKelurahan,
tps_pindah.kecamatan as tpsPindahKecamatan,
tps_pindah.kota as tpsPindahKota, 
tps_pindah.provinsi as tpsPindahProvinsi,
kecamatanPindah.kecamatan as kecamatanPindah, 
kecamatanPindah.id as kecamatanPindahId
FROM pemilih
LEFT JOIN kecamatan ON pemilih.kecamatan = kecamatan.id
LEFT JOIN tps as tps_asal ON tps_asal.id=pemilih.tps_asal
LEFT JOIN tps as tps_pindah ON tps_pindah.id=pemilih.tps_tujuan_pindah
LEFT JOIN kecamatan as kecamatanAsal ON tps_asal.kecamatan = kecamatanAsal.id
LEFT JOIN kecamatan as kecamatanPindah ON tps_pindah.kecamatan = kecamatanPindah.id
WHERE pemilih.status_pemilih = 'Tugas Belajar'
";
$result = $conn->query($sqlPemilihPindahTugasBelajar);
$dataPemilihPindahTugasBelajar = array();
while ($row = $result->fetch_assoc()) {
  $dataPemilihPindahTugasBelajar[] = $row;
}

$sqlPemilihPindahDomisili = "SELECT
*,
kecamatan.id as idKecamatan,
kecamatan.kecamatan as kecamatan,
pemilih.id as id,
pemilih.kelurahan as pemilihKelurahan,
pemilih.kecamatan as pemilihKecamatan,
pemilih.kota as pemilihKota,
tps_asal.id as tpsAsalId,
tps_asal.no_tps as tpsAsalNo,
tps_asal.kelurahan as tpsAsalKelurahan,
tps_asal.kecamatan as tpsAsalKecamatan,
tps_asal.kota as tpsAsalKota, 
tps_asal.provinsi as tpsAsalProvinsi,
kecamatanAsal.kecamatan as kecamatanAsal, 
kecamatanAsal.id as kecamatanAsalId,
tps_pindah.no_tps as tpsPindahNo,
tps_pindah.kelurahan as tpsPindahKelurahan,
tps_pindah.kecamatan as tpsPindahKecamatan,
tps_pindah.kota as tpsPindahKota, 
tps_pindah.provinsi as tpsPindahProvinsi,
kecamatanPindah.kecamatan as kecamatanPindah, 
kecamatanPindah.id as kecamatanPindahId
FROM pemilih
LEFT JOIN kecamatan ON pemilih.kecamatan = kecamatan.id
LEFT JOIN tps as tps_asal ON tps_asal.id=pemilih.tps_asal
LEFT JOIN tps as tps_pindah ON tps_pindah.id=pemilih.tps_tujuan_pindah
LEFT JOIN kecamatan as kecamatanAsal ON tps_asal.kecamatan = kecamatanAsal.id
LEFT JOIN kecamatan as kecamatanPindah ON tps_pindah.kecamatan = kecamatanPindah.id
WHERE pemilih.status_pemilih = 'Pindah Domisili'
";
$result = $conn->query($sqlPemilihPindahDomisili);
$dataPemilihPindahDomisili = array();
while ($row = $result->fetch_assoc()) {
  $dataPemilihPindahDomisili[] = $row;
}

$sqlPemilihPindahBekerjaDiLuarDomisili = "SELECT
*,
kecamatan.id as idKecamatan,
kecamatan.kecamatan as kecamatan,
pemilih.id as id,
pemilih.kelurahan as pemilihKelurahan,
pemilih.kecamatan as pemilihKecamatan,
pemilih.kota as pemilihKota,
tps_asal.id as tpsAsalId,
tps_asal.no_tps as tpsAsalNo,
tps_asal.kelurahan as tpsAsalKelurahan,
tps_asal.kecamatan as tpsAsalKecamatan,
tps_asal.kota as tpsAsalKota, 
tps_asal.provinsi as tpsAsalProvinsi,
kecamatanAsal.kecamatan as kecamatanAsal, 
kecamatanAsal.id as kecamatanAsalId,
tps_pindah.no_tps as tpsPindahNo,
tps_pindah.kelurahan as tpsPindahKelurahan,
tps_pindah.kecamatan as tpsPindahKecamatan,
tps_pindah.kota as tpsPindahKota, 
tps_pindah.provinsi as tpsPindahProvinsi,
kecamatanPindah.kecamatan as kecamatanPindah, 
kecamatanPindah.id as kecamatanPindahId
FROM pemilih
LEFT JOIN kecamatan ON pemilih.kecamatan = kecamatan.id
LEFT JOIN tps as tps_asal ON tps_asal.id=pemilih.tps_asal
LEFT JOIN tps as tps_pindah ON tps_pindah.id=pemilih.tps_tujuan_pindah
LEFT JOIN kecamatan as kecamatanAsal ON tps_asal.kecamatan = kecamatanAsal.id
LEFT JOIN kecamatan as kecamatanPindah ON tps_pindah.kecamatan = kecamatanPindah.id
WHERE pemilih.status_pemilih = 'Bekerja di Luar Domisili'
";
$result = $conn->query($sqlPemilihPindahBekerjaDiLuarDomisili);
$dataPemilihPindahBekerjaDiLuarDomisili = array();
while ($row = $result->fetch_assoc()) {
  $dataPemilihPindahBekerjaDiLuarDomisili[] = $row;
}

$sqlPemilihPindahLainnya = "SELECT
*,
kecamatan.id as idKecamatan,
kecamatan.kecamatan as kecamatan,
pemilih.id as id,
pemilih.kelurahan as pemilihKelurahan,
pemilih.kecamatan as pemilihKecamatan,
pemilih.kota as pemilihKota,
tps_asal.id as tpsAsalId,
tps_asal.no_tps as tpsAsalNo,
tps_asal.kelurahan as tpsAsalKelurahan,
tps_asal.kecamatan as tpsAsalKecamatan,
tps_asal.kota as tpsAsalKota, 
tps_asal.provinsi as tpsAsalProvinsi,
kecamatanAsal.kecamatan as kecamatanAsal, 
kecamatanAsal.id as kecamatanAsalId,
tps_pindah.no_tps as tpsPindahNo,
tps_pindah.kelurahan as tpsPindahKelurahan,
tps_pindah.kecamatan as tpsPindahKecamatan,
tps_pindah.kota as tpsPindahKota, 
tps_pindah.provinsi as tpsPindahProvinsi,
kecamatanPindah.kecamatan as kecamatanPindah, 
kecamatanPindah.id as kecamatanPindahId
FROM pemilih
LEFT JOIN kecamatan ON pemilih.kecamatan = kecamatan.id
LEFT JOIN tps as tps_asal ON tps_asal.id=pemilih.tps_asal
LEFT JOIN tps as tps_pindah ON tps_pindah.id=pemilih.tps_tujuan_pindah
LEFT JOIN kecamatan as kecamatanAsal ON tps_asal.kecamatan = kecamatanAsal.id
LEFT JOIN kecamatan as kecamatanPindah ON tps_pindah.kecamatan = kecamatanPindah.id
WHERE pemilih.status_pemilih = 'Lainnya'
";
$result = $conn->query($sqlPemilihPindahLainnya);
$dataPemilihPindahLainnya = array();
while ($row = $result->fetch_assoc()) {
  $dataPemilihPindahLainnya[] = $row;
}

$conn->close();

function calculateAge($birthdate) {
  // Create DateTime objects for the birthdate and current date
  $birthDateObj = new DateTime($birthdate);
  $currentDateObj = new DateTime();

  // Calculate the difference between the two dates
  $interval = $birthDateObj->diff($currentDateObj);

  // Get the years from the interval
  $age = $interval->y;

  return $age;
}

?>

<?php

require './vendor/autoload.php';

// use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('./alat_kerja.xlsx');
$sheet1 = $spreadsheet->setActiveSheetIndex(0);
$sheet1->getCell('C7')->setValue($user['name']);
$sheet1->getCell('C8')->setValue($user['jabatan']);
$sheet1->getCell('C9')->setValue($user['no_hp']);
$sheet1->getCell('C10')->setValue($user['kota']);
$sheet1->getCell('C11')->setValue($user['provinsi']);

$i = 15;
  $no = 1;
  foreach ($dataJumlahPemilihSemua as $d) {
    $sheet1->getCell('A'.$i)->setValue($no++);
    $sheet1->getCell('B'.$i)->setValue($d['kecamatan']);
    $i++;
  }

  $spreadsheet->getActiveSheet()->getStyle('A15:E'.((count($data) - 1) + $i ))->getBorders()->getAllBorders()
    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

$sheet5 = $spreadsheet->setActiveSheetIndex(3);
$i = 3;
  $no = 1;
  foreach ($dataJumlahPemilihSemua as $d) {
    $sheet5->getCell('A'.$i)->setValue($no++);
    $sheet5->getCell('B'.$i)->setValue($d['kecamatan']);
    $sheet5->getCell('C'.$i)->setValue($d['Khusus']);
    $i++;
  }

$sheet7 = $spreadsheet->setActiveSheetIndex(5);
$i = 4;
  foreach ($dataPemilihKhusus as $d) {
    $sheet7->getCell('A'.$i)->setValue($d['no_kk']);
    $sheet7->getCell('B'.$i)->setValue($d['nik']);
    $sheet7->getCell('C'.$i)->setValue($d['nama']);
    $sheet7->getCell('D'.$i)->setValue($d['tempat_lahir']);
    $sheet7->getCell('E'.$i)->setValue($d['tanggal_lahir']);
    $sheet7->getCell('F'.$i)->setValue(calculateAge($d['tanggal_lahir']));
    $sheet7->getCell('G'.$i)->setValue($d['jenis_kelamin']);
    $sheet7->getCell('H'.$i)->setValue($d['pekerjaan']);
    $sheet7->getCell('I'.$i)->setValue($d['status_perkawinan']);
    $sheet7->getCell('J'.$i)->setValue($d['alamat']);
    $sheet7->getCell('K'.$i)->setValue($d['pemilihKelurahan']);
    $sheet7->getCell('L'.$i)->setValue($d['kecamatan']);
    $sheet7->getCell('M'.$i)->setValue($d['pemilihKota']);
    $sheet7->getCell('N'.$i)->setValue($d['tpsAsalNo']);
    $sheet7->getCell('O'.$i)->setValue($d['tpsAsalKelurahan']);
    $sheet7->getCell('P'.$i)->setValue($d['kecamatanAsal']);
    $sheet7->getCell('Q'.$i)->setValue($d['tpsAsalKota']);
    $sheet7->getCell('R'.$i)->setValue($d['tpsAsalProvinsi']);
    $i++;
  }
  $spreadsheet->getActiveSheet()->getStyle('A4:R'.((count($data) - 1) + $i ))->getBorders()->getAllBorders()
    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    
$sheet8 = $spreadsheet->setActiveSheetIndex(6);
$i = 5;
  foreach ($dataPemilihPindahTugas ?? [] as $d) {
    $sheet8->getCell('A'.$i)->setValue($d['nama']);
    $sheet8->getCell('B'.$i)->setValue(calculateAge($d['tanggal_lahir']));
    $sheet8->getCell('C'.$i)->setValue($d['jenis_kelamin']);
    $sheet8->getCell('D'.$i)->setValue($d['pekerjaan']);
    $sheet8->getCell('E'.$i)->setValue($d['status_perkawinan']);
    $sheet8->getCell('F'.$i)->setValue(($d['alamat']));
    $sheet8->getCell('G'.$i)->setValue($d['pemilihKelurahan']);
    $sheet8->getCell('H'.$i)->setValue($d['kecamatan']);
    $sheet8->getCell('I'.$i)->setValue($d['pemilihKota']);
    $sheet8->getCell('J'.$i)->setValue($d['tanggal_pindah_memilih']);
    $sheet8->getCell('K'.$i)->setValue($d['tpsAsalNo']);
    $sheet8->getCell('L'.$i)->setValue($d['tpsAsalKelurahan']);
    $sheet8->getCell('M'.$i)->setValue($d['kecamatanAsal']);
    $sheet8->getCell('N'.$i)->setValue($d['tpsAsalKota']);
    $sheet8->getCell('O'.$i)->setValue($d['tpsAsalProvinsi']);
    $sheet8->getCell('P'.$i)->setValue($d['tpsPindahNo']);
    $sheet8->getCell('Q'.$i)->setValue($d['tpsPindahKelurahan']);
    $sheet8->getCell('R'.$i)->setValue($d['kecamatanPindah']);
    $sheet8->getCell('S'.$i)->setValue($d['tpsPindahKota']);
    $sheet8->getCell('T'.$i)->setValue($d['tpsPindahProvinsi']);
    $i++;
  }
  $spreadsheet->getActiveSheet()->getStyle('A5:T'.((count($data) - 1) + $i ))->getBorders()->getAllBorders()
    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

$sheet9 = $spreadsheet->setActiveSheetIndex(7);
$i = 6;
  foreach ($dataPemilihPindahSakit as $d) {
    $sheet9->getCell('A'.$i)->setValue($d['nama']);
    $sheet9->getCell('B'.$i)->setValue(calculateAge($d['tanggal_lahir']));
    $sheet9->getCell('C'.$i)->setValue($d['jenis_kelamin']);
    $sheet9->getCell('D'.$i)->setValue($d['pekerjaan']);
    $sheet9->getCell('E'.$i)->setValue($d['status_perkawinan']);
    $sheet9->getCell('F'.$i)->setValue(($d['alamat']));
    $sheet9->getCell('G'.$i)->setValue($d['pemilihKelurahan']);
    $sheet9->getCell('H'.$i)->setValue($d['kecamatan']);
    $sheet9->getCell('I'.$i)->setValue($d['pemilihKota']);
    $sheet9->getCell('J'.$i)->setValue($d['tanggal_pindah_memilih']);
    $sheet9->getCell('K'.$i)->setValue($d['tpsAsalNo']);
    $sheet9->getCell('L'.$i)->setValue($d['tpsAsalKelurahan']);
    $sheet9->getCell('M'.$i)->setValue($d['kecamatanAsal']);
    $sheet9->getCell('N'.$i)->setValue($d['tpsAsalKota']);
    $sheet9->getCell('O'.$i)->setValue($d['tpsAsalProvinsi']);
    $sheet9->getCell('P'.$i)->setValue($d['tpsPindahNo']);
    $sheet9->getCell('Q'.$i)->setValue($d['tpsPindahKelurahan']);
    $sheet9->getCell('R'.$i)->setValue($d['kecamatanPindah']);
    $sheet9->getCell('S'.$i)->setValue($d['tpsPindahKota']);
    $sheet9->getCell('T'.$i)->setValue($d['tpsPindahProvinsi']);
    $i++;
  }
  $spreadsheet->getActiveSheet()->getStyle('A6:T'.((count($data) - 1) + $i ))->getBorders()->getAllBorders()
    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

$sheet10 = $spreadsheet->setActiveSheetIndex(8);
$i = 6;
  foreach ($dataPemilihPindahPidana as $d) {
    $sheet10->getCell('A'.$i)->setValue($d['nama']);
    $sheet10->getCell('B'.$i)->setValue(calculateAge($d['tanggal_lahir']));
    $sheet10->getCell('C'.$i)->setValue($d['jenis_kelamin']);
    $sheet10->getCell('D'.$i)->setValue($d['pekerjaan']);
    $sheet10->getCell('E'.$i)->setValue($d['status_perkawinan']);
    $sheet10->getCell('F'.$i)->setValue(($d['alamat']));
    $sheet10->getCell('G'.$i)->setValue($d['pemilihKelurahan']);
    $sheet10->getCell('H'.$i)->setValue($d['kecamatan']);
    $sheet10->getCell('I'.$i)->setValue($d['pemilihKota']);
    $sheet10->getCell('J'.$i)->setValue($d['tanggal_pindah_memilih']);
    $sheet10->getCell('K'.$i)->setValue($d['tpsAsalNo']);
    $sheet10->getCell('L'.$i)->setValue($d['tpsAsalKelurahan']);
    $sheet10->getCell('M'.$i)->setValue($d['kecamatanAsal']);
    $sheet10->getCell('N'.$i)->setValue($d['tpsAsalKota']);
    $sheet10->getCell('O'.$i)->setValue($d['tpsAsalProvinsi']);
    $sheet10->getCell('P'.$i)->setValue($d['tpsPindahNo']);
    $sheet10->getCell('Q'.$i)->setValue($d['tpsPindahKelurahan']);
    $sheet10->getCell('R'.$i)->setValue($d['kecamatanPindah']);
    $sheet10->getCell('S'.$i)->setValue($d['tpsPindahKota']);
    $sheet10->getCell('T'.$i)->setValue($d['tpsPindahProvinsi']);
    $i++;
  }
  $spreadsheet->getActiveSheet()->getStyle('A6:T'.((count($data) - 1) + $i ))->getBorders()->getAllBorders()
    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

$sheet11 = $spreadsheet->setActiveSheetIndex(9);
$i = 6;
  foreach ($dataPemilihPindahBencana as $d) {
    $sheet11->getCell('A'.$i)->setValue($d['nama']);
    $sheet11->getCell('B'.$i)->setValue(calculateAge($d['tanggal_lahir']));
    $sheet11->getCell('C'.$i)->setValue($d['jenis_kelamin']);
    $sheet11->getCell('D'.$i)->setValue($d['pekerjaan']);
    $sheet11->getCell('E'.$i)->setValue($d['status_perkawinan']);
    $sheet11->getCell('F'.$i)->setValue(($d['alamat']));
    $sheet11->getCell('G'.$i)->setValue($d['pemilihKelurahan']);
    $sheet11->getCell('H'.$i)->setValue($d['kecamatan']);
    $sheet11->getCell('I'.$i)->setValue($d['pemilihKota']);
    $sheet11->getCell('J'.$i)->setValue($d['tanggal_pindah_memilih']);
    $sheet11->getCell('K'.$i)->setValue($d['tpsAsalNo']);
    $sheet11->getCell('L'.$i)->setValue($d['tpsAsalKelurahan']);
    $sheet11->getCell('M'.$i)->setValue($d['kecamatanAsal']);
    $sheet11->getCell('N'.$i)->setValue($d['tpsAsalKota']);
    $sheet11->getCell('O'.$i)->setValue($d['tpsAsalProvinsi']);
    $sheet11->getCell('P'.$i)->setValue($d['tpsPindahNo']);
    $sheet11->getCell('Q'.$i)->setValue($d['tpsPindahKelurahan']);
    $sheet11->getCell('R'.$i)->setValue($d['kecamatanPindah']);
    $sheet11->getCell('S'.$i)->setValue($d['tpsPindahKota']);
    $sheet11->getCell('T'.$i)->setValue($d['tpsPindahProvinsi']);
    $i++;
  }
  $spreadsheet->getActiveSheet()->getStyle('A6:T'.((count($data) - 1) + $i ))->getBorders()->getAllBorders()
    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

$sheet12 = $spreadsheet->setActiveSheetIndex(10);
$i = 6;
  foreach ($dataPemilihPindahRawatInap as $d) {
    $sheet12->getCell('A'.$i)->setValue($d['nama']);
    $sheet12->getCell('B'.$i)->setValue(calculateAge($d['tanggal_lahir']));
    $sheet12->getCell('C'.$i)->setValue($d['jenis_kelamin']);
    $sheet12->getCell('D'.$i)->setValue($d['pekerjaan']);
    $sheet12->getCell('E'.$i)->setValue($d['status_perkawinan']);
    $sheet12->getCell('F'.$i)->setValue(($d['alamat']));
    $sheet12->getCell('G'.$i)->setValue($d['pemilihKelurahan']);
    $sheet12->getCell('H'.$i)->setValue($d['kecamatan']);
    $sheet12->getCell('I'.$i)->setValue($d['pemilihKota']);
    $sheet12->getCell('J'.$i)->setValue($d['tanggal_pindah_memilih']);
    $sheet12->getCell('K'.$i)->setValue($d['tpsAsalNo']);
    $sheet12->getCell('L'.$i)->setValue($d['tpsAsalKelurahan']);
    $sheet12->getCell('M'.$i)->setValue($d['kecamatanAsal']);
    $sheet12->getCell('N'.$i)->setValue($d['tpsAsalKota']);
    $sheet12->getCell('O'.$i)->setValue($d['tpsAsalProvinsi']);
    $sheet12->getCell('P'.$i)->setValue($d['tpsPindahNo']);
    $sheet12->getCell('Q'.$i)->setValue($d['tpsPindahKelurahan']);
    $sheet12->getCell('R'.$i)->setValue($d['kecamatanPindah']);
    $sheet12->getCell('S'.$i)->setValue($d['tpsPindahKota']);
    $sheet12->getCell('T'.$i)->setValue($d['tpsPindahProvinsi']);
    $i++;
  }
  $spreadsheet->getActiveSheet()->getStyle('A6:T'.((count($data) - 1) + $i ))->getBorders()->getAllBorders()
    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

$sheet13 = $spreadsheet->setActiveSheetIndex(11);
$i = 6;
  foreach ($dataPemilihPindahDisabilitas as $d) {
    $sheet13->getCell('A'.$i)->setValue($d['nama']);
    $sheet13->getCell('B'.$i)->setValue(calculateAge($d['tanggal_lahir']));
    $sheet13->getCell('C'.$i)->setValue($d['jenis_kelamin']);
    $sheet13->getCell('D'.$i)->setValue($d['pekerjaan']);
    $sheet13->getCell('E'.$i)->setValue($d['status_perkawinan']);
    $sheet13->getCell('F'.$i)->setValue(($d['alamat']));
    $sheet13->getCell('G'.$i)->setValue($d['pemilihKelurahan']);
    $sheet13->getCell('H'.$i)->setValue($d['kecamatan']);
    $sheet13->getCell('I'.$i)->setValue($d['pemilihKota']);
    $sheet13->getCell('J'.$i)->setValue($d['tanggal_pindah_memilih']);
    $sheet13->getCell('K'.$i)->setValue($d['tpsAsalNo']);
    $sheet13->getCell('L'.$i)->setValue($d['tpsAsalKelurahan']);
    $sheet13->getCell('M'.$i)->setValue($d['kecamatanAsal']);
    $sheet13->getCell('N'.$i)->setValue($d['tpsAsalKota']);
    $sheet13->getCell('O'.$i)->setValue($d['tpsAsalProvinsi']);
    $sheet13->getCell('P'.$i)->setValue($d['tpsPindahNo']);
    $sheet13->getCell('Q'.$i)->setValue($d['tpsPindahKelurahan']);
    $sheet13->getCell('R'.$i)->setValue($d['kecamatanPindah']);
    $sheet13->getCell('S'.$i)->setValue($d['tpsPindahKota']);
    $sheet13->getCell('T'.$i)->setValue($d['tpsPindahProvinsi']);
    $i++;
  }
  $spreadsheet->getActiveSheet()->getStyle('A6:T'.((count($data) - 1) + $i ))->getBorders()->getAllBorders()
    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

$sheet14 = $spreadsheet->setActiveSheetIndex(12);
$i = 6;
  foreach ($dataPemilihPindahNarkoba as $d) {
    $sheet14->getCell('A'.$i)->setValue($d['nama']);
    $sheet14->getCell('B'.$i)->setValue(calculateAge($d['tanggal_lahir']));
    $sheet14->getCell('C'.$i)->setValue($d['jenis_kelamin']);
    $sheet14->getCell('D'.$i)->setValue($d['pekerjaan']);
    $sheet14->getCell('E'.$i)->setValue($d['status_perkawinan']);
    $sheet14->getCell('F'.$i)->setValue(($d['alamat']));
    $sheet14->getCell('G'.$i)->setValue($d['pemilihKelurahan']);
    $sheet14->getCell('H'.$i)->setValue($d['kecamatan']);
    $sheet14->getCell('I'.$i)->setValue($d['pemilihKota']);
    $sheet14->getCell('J'.$i)->setValue($d['tanggal_pindah_memilih']);
    $sheet14->getCell('K'.$i)->setValue($d['tpsAsalNo']);
    $sheet14->getCell('L'.$i)->setValue($d['tpsAsalKelurahan']);
    $sheet14->getCell('M'.$i)->setValue($d['kecamatanAsal']);
    $sheet14->getCell('N'.$i)->setValue($d['tpsAsalKota']);
    $sheet14->getCell('O'.$i)->setValue($d['tpsAsalProvinsi']);
    $sheet14->getCell('P'.$i)->setValue($d['tpsPindahNo']);
    $sheet14->getCell('Q'.$i)->setValue($d['tpsPindahKelurahan']);
    $sheet14->getCell('R'.$i)->setValue($d['kecamatanPindah']);
    $sheet14->getCell('S'.$i)->setValue($d['tpsPindahKota']);
    $sheet14->getCell('T'.$i)->setValue($d['tpsPindahProvinsi']);
    $i++;
  }
  $spreadsheet->getActiveSheet()->getStyle('A6:T'.((count($data) - 1) + $i ))->getBorders()->getAllBorders()
    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

$sheet15 = $spreadsheet->setActiveSheetIndex(13);
$i = 6;
  foreach ($dataPemilihPindahTugasBelajar as $d) {
    $sheet15->getCell('A'.$i)->setValue($d['nama']);
    $sheet15->getCell('B'.$i)->setValue(calculateAge($d['tanggal_lahir']));
    $sheet15->getCell('C'.$i)->setValue($d['jenis_kelamin']);
    $sheet15->getCell('D'.$i)->setValue($d['pekerjaan']);
    $sheet15->getCell('E'.$i)->setValue($d['status_perkawinan']);
    $sheet15->getCell('F'.$i)->setValue(($d['alamat']));
    $sheet15->getCell('G'.$i)->setValue($d['pemilihKelurahan']);
    $sheet15->getCell('H'.$i)->setValue($d['kecamatan']);
    $sheet15->getCell('I'.$i)->setValue($d['pemilihKota']);
    $sheet15->getCell('J'.$i)->setValue($d['tanggal_pindah_memilih']);
    $sheet15->getCell('K'.$i)->setValue($d['tpsAsalNo']);
    $sheet15->getCell('L'.$i)->setValue($d['tpsAsalKelurahan']);
    $sheet15->getCell('M'.$i)->setValue($d['kecamatanAsal']);
    $sheet15->getCell('N'.$i)->setValue($d['tpsAsalKota']);
    $sheet15->getCell('O'.$i)->setValue($d['tpsAsalProvinsi']);
    $sheet15->getCell('P'.$i)->setValue($d['tpsPindahNo']);
    $sheet15->getCell('Q'.$i)->setValue($d['tpsPindahKelurahan']);
    $sheet15->getCell('R'.$i)->setValue($d['kecamatanPindah']);
    $sheet15->getCell('S'.$i)->setValue($d['tpsPindahKota']);
    $sheet15->getCell('T'.$i)->setValue($d['tpsPindahProvinsi']);
    $i++;
  }
  $spreadsheet->getActiveSheet()->getStyle('A6:T'.((count($data) - 1) + $i ))->getBorders()->getAllBorders()
    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

$sheet16 = $spreadsheet->setActiveSheetIndex(14);
$i = 6;
  foreach ($dataPemilihPindahDomisili as $d) {
    $sheet16->getCell('A'.$i)->setValue($d['nama']);
    $sheet16->getCell('B'.$i)->setValue(calculateAge($d['tanggal_lahir']));
    $sheet16->getCell('C'.$i)->setValue($d['jenis_kelamin']);
    $sheet16->getCell('D'.$i)->setValue($d['pekerjaan']);
    $sheet16->getCell('E'.$i)->setValue($d['status_perkawinan']);
    $sheet16->getCell('F'.$i)->setValue(($d['alamat']));
    $sheet16->getCell('G'.$i)->setValue($d['pemilihKelurahan']);
    $sheet16->getCell('H'.$i)->setValue($d['kecamatan']);
    $sheet16->getCell('I'.$i)->setValue($d['pemilihKota']);
    $sheet16->getCell('J'.$i)->setValue($d['tanggal_pindah_memilih']);
    $sheet16->getCell('K'.$i)->setValue($d['tpsAsalNo']);
    $sheet16->getCell('L'.$i)->setValue($d['tpsAsalKelurahan']);
    $sheet16->getCell('M'.$i)->setValue($d['kecamatanAsal']);
    $sheet16->getCell('N'.$i)->setValue($d['tpsAsalKota']);
    $sheet16->getCell('O'.$i)->setValue($d['tpsAsalProvinsi']);
    $sheet16->getCell('P'.$i)->setValue($d['tpsPindahNo']);
    $sheet16->getCell('Q'.$i)->setValue($d['tpsPindahKelurahan']);
    $sheet16->getCell('R'.$i)->setValue($d['kecamatanPindah']);
    $sheet16->getCell('S'.$i)->setValue($d['tpsPindahKota']);
    $sheet16->getCell('T'.$i)->setValue($d['tpsPindahProvinsi']);
    $i++;
  }
  $spreadsheet->getActiveSheet()->getStyle('A6:T'.((count($data) - 1) + $i ))->getBorders()->getAllBorders()
    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

$sheet17 = $spreadsheet->setActiveSheetIndex(15);
$i = 6;
  foreach ($dataPemilihPindahBekerjaDiLuarDomisili as $d) {
    $sheet17->getCell('A'.$i)->setValue($d['nama']);
    $sheet17->getCell('B'.$i)->setValue(calculateAge($d['tanggal_lahir']));
    $sheet17->getCell('C'.$i)->setValue($d['jenis_kelamin']);
    $sheet17->getCell('D'.$i)->setValue($d['pekerjaan']);
    $sheet17->getCell('E'.$i)->setValue($d['status_perkawinan']);
    $sheet17->getCell('F'.$i)->setValue(($d['alamat']));
    $sheet17->getCell('G'.$i)->setValue($d['pemilihKelurahan']);
    $sheet17->getCell('H'.$i)->setValue($d['kecamatan']);
    $sheet17->getCell('I'.$i)->setValue($d['pemilihKota']);
    $sheet17->getCell('J'.$i)->setValue($d['tanggal_pindah_memilih']);
    $sheet17->getCell('K'.$i)->setValue($d['tpsAsalNo']);
    $sheet17->getCell('L'.$i)->setValue($d['tpsAsalKelurahan']);
    $sheet17->getCell('M'.$i)->setValue($d['kecamatanAsal']);
    $sheet17->getCell('N'.$i)->setValue($d['tpsAsalKota']);
    $sheet17->getCell('O'.$i)->setValue($d['tpsAsalProvinsi']);
    $sheet17->getCell('P'.$i)->setValue($d['tpsPindahNo']);
    $sheet17->getCell('Q'.$i)->setValue($d['tpsPindahKelurahan']);
    $sheet17->getCell('R'.$i)->setValue($d['kecamatanPindah']);
    $sheet17->getCell('S'.$i)->setValue($d['tpsPindahKota']);
    $sheet17->getCell('T'.$i)->setValue($d['tpsPindahProvinsi']);
    $i++;
  }
  $spreadsheet->getActiveSheet()->getStyle('A6:T'.((count($data) - 1) + $i ))->getBorders()->getAllBorders()
    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

$sheet18 = $spreadsheet->setActiveSheetIndex(16);
$i = 5;
  foreach ($dataPemilihPindahBekerjaDiLuarDomisili as $d) {
    $sheet18->getCell('A'.$i)->setValue($d['nama']);
    $sheet18->getCell('B'.$i)->setValue(calculateAge($d['tanggal_lahir']));
    $sheet18->getCell('C'.$i)->setValue($d['jenis_kelamin']);
    $sheet18->getCell('D'.$i)->setValue($d['pekerjaan']);
    $sheet18->getCell('E'.$i)->setValue($d['status_perkawinan']);
    $sheet18->getCell('F'.$i)->setValue(($d['alamat']));
    $sheet18->getCell('G'.$i)->setValue($d['pemilihKelurahan']);
    $sheet18->getCell('H'.$i)->setValue($d['kecamatan']);
    $sheet18->getCell('I'.$i)->setValue($d['pemilihKota']);
    $sheet18->getCell('J'.$i)->setValue($d['tanggal_pindah_memilih']);
    $sheet18->getCell('K'.$i)->setValue($d['alasan']);
    $sheet18->getCell('L'.$i)->setValue($d['tpsAsalNo']);
    $sheet18->getCell('M'.$i)->setValue($d['tpsAsalKelurahan']);
    $sheet18->getCell('N'.$i)->setValue($d['kecamatanAsal']);
    $sheet18->getCell('O'.$i)->setValue($d['tpsAsalKota']);
    $sheet18->getCell('P'.$i)->setValue($d['tpsAsalProvinsi']);
    $sheet18->getCell('Q'.$i)->setValue($d['tpsPindahNo']);
    $sheet18->getCell('R'.$i)->setValue($d['tpsPindahKelurahan']);
    $sheet18->getCell('S'.$i)->setValue($d['kecamatanPindah']);
    $sheet18->getCell('T'.$i)->setValue($d['tpsPindahKota']);
    $sheet18->getCell('U'.$i)->setValue($d['tpsPindahProvinsi']);
    $i++;
  }
  $spreadsheet->getActiveSheet()->getStyle('A5:W'.((count($data) - 1) + $i ))->getBorders()->getAllBorders()
    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

$sheet3 = $spreadsheet->setActiveSheetIndex(1);
$no = 1;
$i = 4;
  foreach ($dataJumlahPemilihSemua as $d) {
    $sheet3->getCell('A'.$i)->setValue($no++);
    $sheet3->getCell('B'.$i)->setValue($d['kecamatan']);
    $sheet3->getCell('C'.$i)->setValue($d['Pindah_Tugas']);
    $sheet3->getCell('D'.$i)->setValue($d['Rawat_Inap']);
    $sheet3->getCell('E'.$i)->setValue($d['Mendampingi_Keluarga_Rawat_Inap']);
    $sheet3->getCell('F'.$i)->setValue(($d['Disabilitas']));
    $sheet3->getCell('G'.$i)->setValue($d['Narkoba']);
    $sheet3->getCell('H'.$i)->setValue($d['Tahanan_dan_Pidana']);
    $sheet3->getCell('I'.$i)->setValue($d['Tugas_Belajar']);
    $sheet3->getCell('J'.$i)->setValue($d['Pindah_Domisili']);
    $sheet3->getCell('K'.$i)->setValue($d['Bencana']);
    $sheet3->getCell('L'.$i)->setValue($d['Bekerja_di_Luar_Domisili']);
    $i++;
  }
  $spreadsheet->getActiveSheet()->getStyle('A4:L'.((count($data) - 1) + $i ))->getBorders()->getAllBorders()
    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

$sheet4 = $spreadsheet->setActiveSheetIndex(2);
$no = 1;
$i = 3;
  foreach ($dataJumlahPemilihSemua as $d) {
    $sheet4->getCell('A'.$i)->setValue($no++);
    $sheet4->getCell('B'.$i)->setValue($d['kecamatan']);
    $sheet4->getCell('C'.$i)->setValue($d['Lainnya']);
    $i++;
  }
  $spreadsheet->getActiveSheet()->getStyle('A3:I'.((count($data) - 1) + $i ))->getBorders()->getAllBorders()
    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

$writer = new Xlsx($spreadsheet);
$writer->save('./rekapan.xlsx');


?>
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">
          <!-- <?php echo json_encode($dataJumlahPemilihSemuaKecamatan);?> -->
          <?php if(isset($_SESSION['success-alert'])):?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i>
            <?= $_SESSION['success-alert']; unset($_SESSION['success-alert'])?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php endif;?>
          <?php if(isset($_SESSION['failed-alert'])):?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-octagon me-1"></i>
            <?= $_SESSION['failed-alert']; unset($_SESSION['failed-alert'])?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php endif;?>
            <!-- Sales Card -->
            <div class="col-xxl-4 col-md-4">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">Jumlah Kecamatan</span></h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-map"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?= count($dataKecamatan)?></h6>
                      <!-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->
            <!-- Sales Card -->
            <div class="col-md-8">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">Pemilih Kecamatan <?=$dataJumlahPemilihSemuaKecamatan[0]['kecamatan'] ?? ''?></span></h5>
                  <div class="row">
                    <div class="col-md-4 d-flex flex-column">
                      <span style="font-size: 14px;">Khusus : <?=$dataJumlahPemilihSemuaKecamatan[0]['Khusus'] ?? '-'?></span>
                      <span style="font-size:14px;">Pindah Tugas : <?=$dataJumlahPemilihSemuaKecamatan[0]['Pindah_Tugas'] ?? '-'?></span>
                      <span style="font-size:14px;">Pindah Karena Sakit : <?=$dataJumlahPemilihSemuaKecamatan[0]['Pindah_Karena_Sakit'] ?? '-'?></span>
                      <span style="font-size:14px;">Tahanan dan Pidana : <?=$dataJumlahPemilihSemuaKecamatan[0]['Tahanan_dan_Pidana'] ?? '-'?></span>
                    </div>
                    <div class="col-md-4 d-flex flex-column">
                      <span style="font-size:14px;">Bencana : <?=$dataJumlahPemilihSemuaKecamatan[0]['Bencana'] ?? '-'?></span>
                      <span style="font-size:14px;">Rawat Inap : <?=$dataJumlahPemilihSemuaKecamatan[0]['Rawat_Inap'] ?? '-'?></span>
                      <span style="font-size:14px;">Mendampingi Rawat Inap : <?=$dataJumlahPemilihSemuaKecamatan[0]['Mendampingi_Keluarga_Rawat_Inap'] ?? '-'?></span>
                      <span style="font-size:14px;">Disabilitas : <?=$dataJumlahPemilihSemuaKecamatan[0]['Disabilitas'] ?? '-'?></span>
                    </div>
                    <div class="col-md-4 d-flex flex-column">
                      <span style="font-size:14px;">Narkoba : <?=$dataJumlahPemilihSemuaKecamatan[0]['Narkoba'] ?? '-'?></span>
                      <span style="font-size:14px;">Tugas Belajar : <?=$dataJumlahPemilihSemuaKecamatan[0]['Tugas_Belajar'] ?? '-'?></span>
                      <span style="font-size:14px;">Pindah Domisili : <?=$dataJumlahPemilihSemuaKecamatan[0]['Pindah_Domisili'] ?? '-'?></span>
                      <span style="font-size:14px;">Bekerja di Luar Domisili : <?=$dataJumlahPemilihSemuaKecamatan[0]['Bekerja_di_Luar_Domisili'] ?? '-'?></span>
                      <span style="font-size:14px;">Lainnya : <?=$dataJumlahPemilihSemuaKecamatan[0]['Lainnya'] ?? '-'?></span>
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->

            <!-- Revenue Card -->
            <!-- <div class="col-xxl-4 col-md-6">
              <div class="card info-card revenue-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Revenue <span>| This Month</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="ps-3">
                      <h6>$3,264</h6>
                      <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span>

                    </div>
                  </div>
                </div>

                

              </div>
            </div> -->

          </div>

          <div class="col-12">
              <div class="card recent-sales overflow-auto">

                <div class="p-3 d-flex align-items-center gap-3">
                  <h6>Pilih Kecamatan : </h6>
                  <select name="" class="form-select w-25" id="select">
                    <?php foreach($dataKecamatan as $row):?>
                    <option <?= $row['id'] == $id ? 'selected' : ''?> value="<?=$row['id']?>"><span class="text-uppercase"><?=$row['kecamatan']?></span></option>
                    <?php endforeach;?>
                  </select>
                </div>
                
                <!-- <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div> -->

                <div class="card-body">
                  <h5 class="card-title">Data Pemilih</h5>
                  <div class="d-flex align-items-center gap-3 mb-3">
                    <a href="./form-pemilih.php?id=<?=$id?>" class="btn btn-success btn-sm">
                      <i class="bi bi-plus"></i>
                      Tambah Data Pemilih
                    </a>
                    <a href="rekapan.xlsx" class="btn btn-outline-success btn-sm">
                      <i class="bi bi-file-earmark-excel-fill"></i>
                      Download Excel
                    </a>
                  </div>
                  <div class="overflow-auto">
                    <table class="table datatable table-hover compact">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>No KK</th>
                          <th>NIK</th>
                          <th>Nama</th>
                          <th>Tempat Lahir</th>
                          <th>Tgl Lahir</th>
                          <th>Usia</th>
                          <th>Jenis Kelamin</th>
                          <th>Pekerjaan</th>
                          <th>Status Perkawinan</th>
                          <th>Alamat</th>
                          <th>Kelurahan/Desa</th>
                          <th>Kecamatan</th>
                          <th>Kab/Kota</th>
                          <th>Status Pemilih</th>
                          <th>Tanggal Pindah Pemilih</th>
                          <th>TPS Asal</th>
                          <th>TPS Pindah</th>
                          <th>Alasan</th>
                          <th>Action</th>
                        </tr>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach($data as $key=>$row):?>
                        <tr>
                          <td><?= $key + 1?></td>
                          <td><?=$row['no_kk']?></td>
                          <td><?=$row['nik']?></td>
                          <td><span class="text-uppercase"><?=$row['nama']?></span></td>
                          <td><?=$row['tempat_lahir']?></td>
                          <td><?=$row['tanggal_lahir']?></td>
                          <td><?=calculateAge($row['tanggal_lahir'])?></td>
                          <td><?=$row['jenis_kelamin']?></td>
                          <td><?=$row['pekerjaan']?></td>
                          <td><?=$row['status_perkawinan']?></td>
                          <td><?=$row['alamat']?></td>
                          <td><?=$row['pemilihKelurahan']?></td>
                          <td><?=$row['kecamatan']?></td>
                          <td><?=$row['pemilihKota']?></td>
                          <td>
                            <?php if ($row['status_pemilih'] == 'Khusus' ):?>
                              <span class="badge bg-success"><?=$row['status_pemilih']?></span>
                            <?php elseif ($row['status_pemilih'] == 'Lainnya' ):?>
                              <span class="badge bg-warning"><?=$row['status_pemilih']?></span>
                            <?php else:?>
                              <span class="badge bg-primary"><?=$row['status_pemilih']?></span>
                            <?php endif;?>
  
                          </td>
                          <td><?=$row['tanggal_pindah_memilih'] == '0000-00-00' ? '-' : $row['tanggal_pindah_memilih']?></td>
                          <td><?=$row['tpsAsalNo'] != '' ? "{$row['tpsAsalNo']}, {$row['tpsAsalKelurahan']}, {$row['kecamatanAsal']}" : '-'?></td>
                          <td><?=$row['tpsPindahNo'] != '' ? "{$row['tpsPindahNo']}, {$row['tpsPindahKelurahan']}, {$row['kecamatanPindah']}" : '-' ?></td>
                          <td><?=$row['alasan'] == '' ? '-' : $row['alasan']?></td>
                          <td class="d-flex gap-2">

                          <?php if($user['administrator'] > 0){
                            echo ' <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editPemilih<?=$key?>">
                              <i class="bi bi-pencil-square"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusPemilih<?=$key?>">
                              <i class="bi bi-trash"></i>
                            </button> ';
                          }else{
                            echo "";
                          }?>
                            <div class="modal fade" id="editPemilih<?=$key?>" tabindex="-1" aria-labelledby="editPemilihLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="editPemilihLabel">Edit Pemilih</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                  <form action="./controllers/pemilihController.php?action=edit&id=<?=$row['idPemilih']?>" method="POST" class=" w-100 d-flex flex-column gap-3 bg-white rounded p-4">
                                    <div>
                                      <label for="no_kk" class="form-label">No. KK</label>
                                      <input value="<?=$row['no_kk']?>" type="text" autofocus name="no_kk" class="form-control">
                                    </div>
                                    <div>
                                      <label for="nik" class="form-label">NIK</label>
                                      <input value="<?=$row['nik']?>" type="text" name="nik" class="form-control">
                                    </div>
                                    <div>
                                      <label for="nama" class="form-label">Nama</label>
                                      <input value="<?=$row['nama']?>" type="text" name="nama" class="form-control">
                                    </div>
                                    <div>
                                      <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                      <input value="<?=$row['tempat_lahir']?>" type="text" name="tempat_lahir" class="form-control">
                                    </div>
                                    <div>
                                      <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                      <input value="<?=$row['tanggal_lahir']?>" type="date" name="tanggal_lahir" class="form-control">
                                    </div>
                                    <div>
                                      <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                      <select name="jenis_kelamin" id="" class="form-select">
                                        <option <?=$row['jenis_kelamin'] == 'Perempuan' ? 'selected' : ''?> value="Perempuan">Perempuan</option>
                                        <option <?=$row['jenis_kelamin'] == 'Laki-Laki' ? 'selected' : ''?> value="Laki-Laki">Laki-Laki</option>
                                      </select>
                                    </div>
                                    <div>
                                      <label for="pekerjaan" class="form-label">Pekerjaan</label>
                                      <input value="<?=$row['pekerjaan']?>" type="text" name="pekerjaan" class="form-control">
                                    </div>
                                    <div>
                                      <label for="status_perkawinan" class="form-label">Status Perkawinan</label>
                                      <select name="status_perkawinan" id="" class="form-select">
                                        <option <?=$row['status_perkawinan'] == 'Menikah' ? 'selected' : ''?> value="Menikah">Menikah</option>
                                        <option <?=$row['status_perkawinan'] == 'Belum Menikah' ? 'selected' : ''?> value="Belum Menikah">Belum Menikah</option>
                                      </select>
                                    </div>
                                    <div>
                                      <label for="alamat" class="form-label">Alamat</label>
                                      <input value="<?=$row['alamat']?>" type="text" name="alamat" class="form-control">
                                    </div>
                                    <div>
                                      <label for="kelurahan" class="form-label">Kelurahan</label>
                                      <input value="<?=$row['pemilihKelurahan']?>" type="text" name="kelurahan" class="form-control">
                                    </div>
                                    <div>
                                      <label for="kecamatan" class="form-label">Kecamatan</label>
                                      <select name="kecamatan" id="" class="form-select">
                                        <?php foreach($dataKecamatan as $value):?>
                                          <option <?=$row['idKecamatan'] == $value['id'] ? 'selected' : '' ?> value="<?=$value['id']?>"><?=$value['kecamatan']?></option>
                                        <?php endforeach;?>
                                      </select>
                                    </div>
                                    <div>
                                      <label for="kota" class="form-label">Kota</label>
                                      <input value="<?=$row['pemilihKota']?>" type="text" name="kota" class="form-control">
                                    </div>
                                    <div>
                                      <label for="status_pemilih" class="form-label">Status Pemilih</label>
                                      <select name="status_pemilih" id="status_pemilih" class="form-select">
                                        <option <?=$row['status_pemilih'] == 'Khusus' ? 'selected' : ''?> value="Khusus">Khusus</option>
                                        <option <?=$row['status_pemilih'] == 'Pindah Tugas' ? 'selected' : ''?> value="Pindah Tugas">Pindah Tugas</option>
                                        <option <?=$row['status_pemilih'] == 'Pindah Karena Sakit' ? 'selected' : ''?> value="Pindah Karena Sakit">Pindah Karena Sakit</option>
                                        <option <?=$row['status_pemilih'] == 'Tahanan dan Pidana' ? 'selected' : ''?> value="Tahanan dan Pidana">Tahanan dan Pidana</option>
                                        <option <?=$row['status_pemilih'] == 'Bencana' ? 'selected' : ''?> value="Bencana">Bencana</option>
                                        <option <?=$row['status_pemilih'] == 'Rawat Inap' ? 'selected' : ''?> value="Rawat Inap">Rawat Inap</option>
                                        <option <?=$row['status_pemilih'] == 'Mendampingi Keluarga Rawat Inap' ? 'selected' : ''?> value="Mendampingi Keluarga Rawat Inap">Mendampingi Keluarga Rawat Inap</option>
                                        <option <?=$row['status_pemilih'] == 'Disabilitas' ? 'selected' : ''?> value="Disabilitas">Disabilitas</option>
                                        <option <?=$row['status_pemilih'] == 'Narkoba' ? 'selected' : ''?> value="Narkoba">Narkoba</option>
                                        <option <?=$row['status_pemilih'] == 'Tugas Belajar' ? 'selected' : ''?> value="Tugas Belajar">Tugas Belajar</option>
                                        <option <?=$row['status_pemilih'] == 'Pindah Domisili' ? 'selected' : ''?> value="Pindah Domisili">Pindah Domisili</option>
                                        <option <?=$row['status_pemilih'] == 'Bekerja di Luar Domisili' ? 'selected' : ''?> value="Bekerja di Luar Domisili">Bekerja di Luar Domisili</option>
                                        <option <?=$row['status_pemilih'] == 'Lainnya' ? 'selected' : ''?> value="Lainnya">Lainnya</option>
                                      </select>
                                    </div>
                                    <div class="" id="tanggal_pindah">
                                      <label for="tanggal_pindah_memilih" class="form-label">Tanggal Pendaftaran Pindah Memilih</label>
                                      <input value="<?=$row['tanggal_pindah_memilih']?>" type="date" name="tanggal_pindah_memilih" class="form-control">
                                    </div>
                                    <div class="" id="alasan">
                                      <label for="inputZip" class="form-label">Alasan</label>
                                      <input type="text" value="<?=$row['alasan']?>" name="alasan" class="form-control" id="inputZip">
                                    </div>
                                    <div class="" id="tps_asal">
                                      <label for="inputZip" class="form-label">TPS Asal</label>
                                      <select name="tps_asal" class="form-select" id="">
                                        <option value="">--Pilih TPS Asal--</option>
                                        <?php foreach($dataTPS as $value):?>
                                          <option <?= $value['id'] == $row['tpsAsalId']? 'selected' : ''?> value="<?=$value['id']?>"><?=$value['no_tps']?></option>
                                        <?php endforeach?>
                                      </select>
                                    </div>
                                    <div class="" id="tps_pindah">
                                      <label for="inputZip" class="form-label">TPS Tujuan Pindah</label>
                                      <select name="tps_tujuan_pindah" class="form-select" id="">
                                        <option value="">--Pilih TPS Tujuan Pindah--</option>
                                        <?php foreach($dataTPS as $value):?>
                                          <option <?= $value['id'] == $row['tpsPindahId']? 'selected' : ''?> value="<?=$value['id']?>"><?=$value['no_tps']?></option>
                                        <?php endforeach?>
                                      </select>
                                    </div>
                                    <div class="modal-footer">
                                    <button type="submit" name="submit" class="btn btn-warning">Submit</button>
                                    </div>
                                  </form>
                                  </div>
                                </div>
                              </div>
                            </div>
      
                            <div class="modal fade" id="hapusPemilih<?=$key?>" tabindex="-1" aria-labelledby="hapusPemilihLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    <p>Anda yakin ingin menghapus ?</p>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <a class="btn btn-danger" href="./controllers/pemilihController.php?action=delete&id=<?=$row['idPemilih']?>">Hapus</a>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </td>
                        </tr>
  
  
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>

                </div>

              </div>
            </div><!-- End Recent Sales -->

        </div><!-- End Left side columns -->

      </div>
    </section>

  </main><!-- End #main -->

  <script>
    const select = document.getElementById('select')

    select.addEventListener('change', ()=>{
      let id = select?.value
      window.location=`index.php?id=${id}`
    })

    let statusPemilih = document.getElementById('status_pemilih')
    let tanggalPindah = document.getElementById('tanggal_pindah')
    let alasan = document.getElementById('alasan')
    let tps_asal = document.getElementById('tps_asal')
    let tps_pindah = document.getElementById('tps_pindah')

    // console.log(statusPemilih?.value);
    // statusPemilih.addEventListener('change', ()=>{
    //   if(statusPemilih?.value !== 'Khusus'){
    //     tanggalPindah.classList.remove('d-none')
    //     tps_pindah.classList.remove('d-none')
    //   }else{
    //     tanggalPindah.classList.add('d-none')
    //     tps_pindah.classList.add('d-none')
    //   }

    //   if(statusPemilih.value === 'Lainnya'){
    //     alasan.classList.remove('d-none')
    //   }else{
    //     alasan.classList.add('d-none')

    //   }
    // })

  </script>

  <?php include './partials/footer.php'?> 