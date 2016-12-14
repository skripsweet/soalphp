CREATE TABLE IF NOT EXISTS `admin` (
  `nis` varchar(20) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(80) DEFAULT NULL,
  `agama` varchar(30) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `mapel` (
  `id_mp` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `nama_mp` varchar(50) NOT NULL,
  PRIMARY KEY (`id_mp`),
  UNIQUE KEY `nama_mp` (`nama_mp`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `nilai` (
  `id_nilai` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` varchar(30) NOT NULL,
  `id_ujian` varchar(20) NOT NULL,
  `nilai` float NOT NULL,
  `detail_jawaban` text,
  PRIMARY KEY (`id_nilai`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `pil_jawaban` (
  `id_jawaban` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_soal` varchar(10) NOT NULL,
  `jawaban` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_jawaban`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `siswa` (
  `nis` varchar(20) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(80) DEFAULT NULL,
  `agama` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`nis`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `soal` (
  `id_soal` varchar(10) NOT NULL,
  `id_ujian` varchar(8) NOT NULL,
  `isi_soal` text NOT NULL,
  PRIMARY KEY (`id_soal`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `ujian` (
  `id_ujian` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama_ujian` varchar(50) NOT NULL,
  `id_mp` varchar(10) NOT NULL,
  `tanggal` date NOT NULL,
  `waktu` varchar(8) NOT NULL,
  `keterangan` text NOT NULL,
  PRIMARY KEY (`id_ujian`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `user` (
  `id_user` varchar(30) NOT NULL,
  `password` varchar(40) NOT NULL,
  `level` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
