CREATE TABLE `rtik_peserta_pelatihan` (
  `id` int(11) NOT NULL,
  `id_peserta` int(11) NOT NULL,
  `id_pelatihan` int(11) NOT NULL,
  `waktu_daftar` datetime DEFAULT NULL,
  `waktu_daftar_ulang` datetime DEFAULT NULL,
  `konfirmasi_hadir` text DEFAULT null,
  `harapan` text DEFAULT null,
  `saran` text DEFAULT null,
  `lolos` tinyint(2) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
ALTER TABLE `rtik_peserta_pelatihan`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `rtik_peserta_pelatihan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;