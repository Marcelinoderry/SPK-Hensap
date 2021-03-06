<?php
// untuk menghilangkan error
error_reporting(0);
// mengambil file kmeans buatanku
include_once "vendor/kmeans/kmeans.php";
// untuk menload class proses
$proses = new Proses;

$centroid = $proses->CentroidAwal($data, 3);

$keterangan_centroid = [
    '',
    'Tinggi',
    'Sedang',
    'Rendah',
];

$iterasi = 1;
while (true) {
    // variabel untuk menentukan masuk pada kelompok apa
    $cluster1 = 1;
    $cluster2 = 2;
    $cluster3 = 3;
    /* cara ini untuk mengubah data menjadi array atau mengambil data secara berurut pada kolom */
    // variabel array untuk jumlah kolom yang ada pada himpunan data
    $k1 = [];
    $k2 = [];
    $k3 = [];
    // variabel array untuk jumlah centroid
    $cnt1 = [];
    $cnt2 = [];
    $cnt3 = [];
    // mengambil hasil dari perhitungan persamaan ED dan mangambil hasil perhitungan
    $hasil_iterasi = $proses->RumusPersamaanED($data, $centroid);
    // untuk mengambil data dari himpunan data
    foreach ($data as $key1 => $value1) {
        $k1[] = $value1[0];
        $k2[] = $value1[1];
        $k3[] = $value1[2];
    }
    // hasil dari proses perhitungan
    foreach ($hasil_iterasi as $key2 => $value2) {
        $cnt1[] = $value2[0];
        $cnt2[] = $value2[1];
        $cnt3[] = $value2[2];
    }
    // mengubah data menjadi array hasil centroid
    $cluster = [$cnt1, $cnt2, $cnt3];
    // untuk mengambil hasil dari cluster
    $cls = [];
    // manampilkan data pada hasil iterasi
    for ($i = 0; $i < count($data); $i++) {
        // untuk proses pembagian cluster
        if ($cnt1[$i] < $cnt2[$i] && $cnt1[$i] < $cnt3[$i]) {
            $cls[] = $cluster1;
        } else if ($cnt2[$i] < $cnt1[$i] && $cnt2[$i] < $cnt3[$i]) {
            $cls[] = $cluster2;
        } else if ($cnt3[$i] < $cnt1[$i] && $cnt3[$i] < $cnt2[$i]) {
            $cls[] = $cluster3;
        }
    }
    // mengambil hasil untuk menentukan nilai terkecil atau jarak terdekat pada hasil cluster
    $hasil_minimal = $proses->NilaiTerkecil($cluster, $data);
    // untuk mengeksekusi apa bila terdapat nilai 0 pada index pertam
    if (!$k1[0] != 0) {
        $k1[0] = sprintf("%02d", 0);
    }
    if (!$k2[0] != 0) {
        $k2[0] = sprintf("%02d", 0);
    }
    if (!$k3[0] != 0) {
        $k3[0] = sprintf("%02d", 0);
    }
    /* mulai proses pencarian nilai rata - rata dari hasil pengelompokan untuk mengambil nilai yang masuk pada cluster */
    // kolom a
    $c1 = [];
    $c2 = [];
    $c3 = [];
    // kolom b
    $d1 = [];
    $d2 = [];
    $d3 = [];
    // kolom c
    $e1 = [];
    $e2 = [];
    $e3 = [];
    // untuk menentukan apa bila ada nilai yang memiliki cluster yang sama pada saat pembagian cluster
    for ($j = 0; $j < count($cls); $j++) {
        // menampilkan data menjadi 1
        for ($i = 0; $i < 1; $i++) {
            // kolom 1 pada a
            if ($k1[$i] and $cls[$j] == 1) {
                $c1[] = $k1[$j];
            } else if ($k1[$i] and $cls[$j] == 2) {
                $c2[] = $k1[$j];
            } else if ($k1[$i] and $cls[$j] == 3) {
                $c3[] = $k1[$j];
            }
            // kolom 2 pada b
            if ($k2[$i] and $cls[$j] == 1) {
                $d1[] = $k2[$j];
            } else if ($k2[$i] and $cls[$j] == 2) {
                $d2[] = $k2[$j];
            } else if ($k2[$i] and $cls[$j] == 3) {
                $d3[] = $k2[$j];
            }
            // kolom 3 pada c
            if ($k3[$i] and $cls[$j] == 1) {
                $e1[] = $k3[$j];
            } else if ($k3[$i] and $cls[$j] == 2) {
                $e2[] = $k3[$j];
            } else if ($k3[$i] and $cls[$j] == 3) {
                $e3[] = $k3[$j];
            }
        }
        // menampilkan data menjadi 1
    }
    // hasil penyamaan atara cluster dan data
    $cluster = [
        [$c1, $c2, $c3],
        [$d1, $d2, $d3],
        [$e1, $e2, $e3]
    ];
    // untuk mengambil hasil nilai rata rata
    $nilai_rata = $proses->NilaiRatarata($cluster);
    $nilrat1 = [];
    $nilrat2 = [];
    $nilrat3 = [];
    foreach ($nilai_rata as $key => $value) {
        $nilrat1[] = $value[0];
        $nilrat2[] = $value[1];
        $nilrat3[] = $value[2];
    }
    // hasil centroid baru
    $centroid_baru = [$nilrat1, $nilrat2, $nilrat3];
    // untuk mengambil hasil centroid baru
    $centroid = $proses->CentroidBaru($centroid_baru);
    $hasil_baru = [];
    $tabel_iterasi = array();
    // untuk mengambil nama penyakit
    foreach ($datacluster as $key => $value) {
        $tabel_iterasi[$key]['nama_produk'] = str_replace("_", " ", $value['nama_produk']);
    }
    // untuk mengambil data
    foreach ($data as $key => $value) {
        // untuk mengambil data berdasarkan baris
        $tabel_iterasi[$key]['data'] = $value;
    }
    // untuk mengambil hasil centroid c1, c2, c3
    foreach ($hasil_iterasi as $key => $value) {
        // untuk mengambil jarak centroid
        $tabel_iterasi[$key]['jarak_centroid'] = $value;
    }
    // untuk mengambil nilai terkecil atau jarak terdekat
    foreach ($hasil_minimal as $key => $value) {
        // untuk mengambil jarak centroid
        $tabel_iterasi[$key]['jarak_terdekat'] = $value;
    }
    // untuk mengambil cluster
    foreach ($cls as $key => $value) {
        // untuk mengambil clustering
        $tabel_iterasi[$key]['cluster'] = $value;
    }
    // untuk menghitung berapa jumlah penyakit setiap claster
    $pemb_clus = [];
    foreach ($tabel_iterasi as $key1 => $value1) {
        for ($i = 1; $i <= count($centroid); $i++) {
            if ($value1['cluster'] == $i) {
                $pemb_clus['cls' . $i][] = $value1['cluster'];
            }
        }
    }
    // untuk mengambil pembagian class pada penyakit
    $hasil_class = array();
    foreach ($tabel_iterasi as $key => $value) {
        for ($i = 1; $i <= count($centroid); $i++) {
            if ($value['data']['nama_produk'] and $value['cluster'] == $i) {
                $hasil_class[$key]["class" . $i] = $value['data']['nama_produk'];
            }
        }
    }
    // untuk menggabungkan kedua array
    array_push($hasil_baru, $tabel_iterasi);

    // memanggil function cluster baru
    $cluster_baru = $proses->ClusterBaru($cls, $iterasi);

    if (!$cluster_baru) {
        // berhenti
        break;
    }
}
?>
<!-- tabal untuk pembagian cluster penyakit -->
<br>
<h2>Hasil Perkebunan 3 Tahun Terakhir <?= $tahun1 ?>, <?= $tahun2 ?>, <?= $tahun3 ?>.</h2>
<div class="table-responsive">
    <table class="table table-bordered table-striped" id="datatabel">
        <thead>
            <tr>
                <th>No</th>
                <?php for ($i = 1; $i <= count($centroid); $i++) { ?>
                    <th><?= $keterangan_centroid[$i] ?></th>
                <?php } ?>
            </tr>
        </thead>
        <tbody align="center">
            <?php
            $no = 1;
            foreach ($hasil_class as $key => $value) {
                $hasil_tinggi[] = $value["class1"];
                $hasil_sedang[] = $value["class2"];
                $hasil_rendah[] = $value["class3"];
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <?php for ($i = 1; $i <= count($centroid); $i++) { ?>
                        <?= empty($value["class" . $i]) ? "<td align='center'> - </td>" : "<td>" . str_replace("_", " ", $value["class" . $i]) . "</td>" ?>
                    <?php } ?>
                <tr>
                <?php } ?>
        </tbody>
    </table>
</div>
<br>
<!-- tabal untuk pembagian cluster penyakit -->
<h2>Hasil Perkebunan Tahun Akhir <?= ($tahun3 + 1) ?>.</h2>
<div class="table-responsive">
    <table class="table table-bordered table-striped" id="datatabel">
        <thead>
            <tr>
                <th>No</th>
                <th>Perkebunan</th>
                <th>Produksi</th>
            </tr>
        </thead>
        <tbody align="center">
            <?php
            $no = 1;
            foreach ($tahun4 as $key => $value) {
                $hasil_akhir[$value->perkebunan] = $value->produksi;
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $value->perkebunan ?></td>
                    <td><?= $value->produksi ?></td>
                <tr>
                <?php } ?>
        </tbody>
    </table>
</div>
<!-- untuk menampikan grafik dari hasil cluster -->
<br>
<div id="container"></div>
<br>
<!-- untuk menampikan grafik dari hasil cluster -->
<!-- untuk menampilkan kesimpulan -->
<br>
Dari hasil Clustering yang telah dibagi menjadi 3 Cluss yaitu :
<ul>
    <li>- Panen Perkebunan Tinggi</li>
    <li>- Panen Perkebunan Sedang</li>
    <li>- Panen Perkebunan Rendah</li>
</ul>
Terdapat, Jenis perkebunan tertinggi pada 3 tahun terakhir :
<ul>
    <li>
        - <b><?php echo count($pemb_clus['cls1']); ?></b> Jenis Perkebunan dengan jumlah Produksi Tinggi Pada Tahun <?= $tahun1 ?> berikut jenis perkebunanan :
        <ol type="number">
            <?php
            $filter_hasil_tinggi = array_values(array_filter($hasil_tinggi));
            for ($i = 0; $i < count($filter_hasil_tinggi); $i++) { ?>
                <li><?= $filter_hasil_tinggi[$i] ?></li>
            <?php } ?>
        </ol>
    </li>
    <li>
        - <b><?php echo count($pemb_clus['cls2']); ?></b> Jenis Perkebunan dengan jumlah Produksi Sedang Pada Tahun <?= $tahun2 ?> berikut jenis perkebunanan :
        <ol type="number">
            <?php
            $filter_hasil_sedang = array_values(array_filter($hasil_sedang));
            for ($i = 0; $i < count($filter_hasil_sedang); $i++) { ?>
                <li><?= $filter_hasil_sedang[$i] ?></li>
            <?php } ?>
        </ol>
    </li>
    <li>
        - <b><?php echo count($pemb_clus['cls3']); ?></b> Jenis Perkebunan dengan jumlah Produksi Rendah Pada Tahun <?= $tahun3 ?> berikut jenis perkebunanan :
        <ol type="number">
            <?php
            $filter_hasil_rendah = array_values(array_filter($hasil_rendah));
            for ($i = 0; $i < count($filter_hasil_rendah); $i++) { ?>
                <li><?= $filter_hasil_rendah[$i] ?></li>
            <?php } ?>
        </ol>
    </li>
</ul>
Jenis perkebunan tertinggi pada tahun ke 4 :
<ul>
    <li>
        <?php
        arsort($hasil_akhir);
        $filter_hasil_akhir = array_filter($hasil_akhir)
        ?>
        - <b><?= count($filter_hasil_akhir) ?></b> Jenis Perkebunan dengan jumlah Produksi Tertinggi Pada Tahun <?= ($tahun3 + 1) ?> berikut jenis perkebunanan :
        <ol type="number">
            <?php
            foreach ($filter_hasil_akhir as $key => $value) {
            ?>
                <li><?= $key ?> (<?= $value ?>)</li>
            <?php } ?>
        </ol>
    </li>
</ul>
<p>
    Berdasarkan data diatas dapat ditarik kesimpulan bahwa dalam proses produksi hasil perkebunan terbanyak yang terdapat pada Kabupaten Mamasa, dari hasil perbandingan 3 tahun terakhir dengan 1 tahun selanjutnya sebagai berikut :
</p>
<ul>
    <?php
    reset($filter_hasil_akhir);
    $first_key = key($filter_hasil_akhir);
    ?>
    <li>3 Tahun Terakhir : <b><?= $filter_hasil_tinggi[0] ?></b></li>
    <li>1 Tahun Selanjutnya : <b><?= $first_key ?></b></li>
</ul>
<!-- untuk menampilkan kesimpulan -->

<script>
    // untuk chart
    Highcharts.chart('container', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Jumlah Panen Perkebunan Tinggi, Sedang, dan Rendah'
        },
        subtitle: {
            text: 'Basis Data Statistik Perkebunan'
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Hasil Jumlah (ton)'
            }
        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.f}'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.f}</b> of total<br/>'
        },

        series: [{
            name: "Browsers",
            colorByPoint: true,
            data: [{
                    name: "Panen Perkebunan Tinggi",
                    y: parseInt($('#cls1').val()),
                },
                {
                    name: "Panen Perkebunan Sedang",
                    y: parseInt($('#cls2').val()),
                },
                {
                    name: "Panen Perkebunan Rendah",
                    y: parseInt($('#cls3').val()),
                }
            ]
        }]
    });
</script>