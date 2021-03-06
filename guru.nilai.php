<?php
require ( __DIR__ . '/init.php');
checkUserAuth();
checkUserRole(array(1));

// TEMPLATE CONTROL
$ui_register_page = 'guru.nilai';

// LOAD HEADER
loadAssetsHead('Data Nilai');

if (isset ($_POST["nilai_tampilkan"]) ){ 


	$id_guru       = $_POST['id_guru'];
	
	$id_kelas       = $_POST['id_kelas'];
	
	$kd_mapel       = $_POST['kd_mapel'];
	

	$querytampil=mysql_query("SELECT * FROM nilai, siswa, kelas_siswa, kelas, mengajar 
		where nilai.id_kelas_siswa=kelas_siswa.id_kelas_siswa
		and kelas_siswa.id_siswa=siswa.id_siswa  
		and mengajar.id_kelas=kelas_siswa.id_kelas  
		and nilai.id_tahun='$_SESSION[id_tahun]'
		and nilai.kd_mapel='$kd_mapel'
		and kelas_siswa.id_kelas='$id_kelas'
		and mengajar.id_guru='$id_guru'
		order by siswa.nm_siswa asc");	


	$tampilketerangan=mysql_query("SELECT * FROM mengajar,mapel,kelas 
		where mengajar.id_kelas=kelas.id_kelas 
		and mengajar.kd_mapel=mapel.kd_mapel 
		and mengajar.kd_mapel='$kd_mapel'
		and mengajar.id_kelas='$id_kelas'
		");	
	

}

// FORM PROCESSING
// ... code here ...
    // validation form kosong
$pesanError= array();
if (trim($kd_mapel)=="") {
	$pesanError[]="Data <b>Kode Mata Pelajaran</b> Masih Kosong.";
}
if (trim($nm_mapel)=="") {
	$pesanError[]="Data <b>Nama Mata Pelajaran</b> Masih Kosong.";
}
if (trim($kkm)=="") {
	$pesanError[]="Data <b>KKM</b> Masih Kosong.";
}
?>
<script type="text/javascript">
	function convertAngka(objek) {

		a = objek.value;
		b = a.replace(/[^\d]/g,"");

		objek.value = b;

	}            
</script>

<link rel="stylesheet" href="assets/tablesorter/style.css" />
<body>

	<?php
  // LOAD MAIN MENU
	loadMainMenu();
	?>

	<div class="uk-container uk-container-center uk-margin-large-top">
		<div class="uk-grid" data-uk-grid-margin data-uk-grid-match>
			<div class="uk-width-medium-1-6 uk-hidden-small">
				<?php loadSidebar() ?>
			</div>
			<div class="uk-width-medium-5-6 tm-article-side">
				<article class="uk-article">
					<div class="uk-vertical-align uk-text-right uk-height-1-1">
						<img class="uk-margin-bottom" width="500px" height="50px" src="assets/images/banner.png" alt="SI Inventaris" title="SI Inventaris">
					</div>
					<hr class="uk-article-divider">
					<h1 class="uk-article-title">Data Nilai Siswa <span class="uk-text-large">{ Lihat Data Nilai }</span></h1>
					<br>
					<div class="uk-grid" data-uk-grid-margin>
						<div class="uk-width-medium-1-1">
							<form class="uk-form uk-form-stacked" method="POST" >
								<div class="uk-form-row">
									<div class="uk-progress uk-progress-mini uk-progress-primary uk-progress-striped uk-active">
										<div class="uk-progress-bar" id="nilai_progress" style="width: 0%;"></div>
									</div>
								</div>
								<input type="hidden" name="id_guru" id="id_guru" value="<?php echo $_SESSION['id_guru']; ?>">
								<div class="uk-form-row">
									<label class="uk-form-label" for="">Mata Pelajaran<span class="uk-text-danger"></span></label>
									<div class="uk-form-controls">
										<select name="kd_mapel" id="kd_mapel" class="uk-width-1-4" data-uk-tooltip="{pos:'bottom-left'}" title="Bulan inspeksi" required>                 
											<option value="">--- Pilih Mata Pelajaran---</option>
											<?php 
											$mapel = mysql_query("SELECT kd_mapel, nm_mapel FROM mapel where kd_mapel in (SELECT mapel.kd_mapel FROM mapel left join mengajar on mengajar.kd_mapel=mapel.kd_mapel 
												right join jadwal on jadwal.id_mengajar=mengajar.id_mengajar
												where mengajar.id_guru='$_SESSION[id_guru]' 
												) order by nm_mapel asc");
											
											while($k = mysql_fetch_array($mapel)){
												echo "<option value=\"".$k['kd_mapel']."\">".$k['nm_mapel']."</option>\n";
											}
											?>
										</select>
									</div>
								</div>
								
								<br>
								<div class="uk-form-row">
									<label class="uk-form-label" for="">Kelas<span class="uk-text-danger"></span></label>
									<div class="uk-form-controls">
										<select name="id_kelas" id="id_kelas" class="uk-width-1-4" data-uk-tooltip="{pos:'bottom-left'}" title="Bulan inspeksi" required>                 
											<option value="">--- Pilih Kelas ---</option>
											
										</select>

									</div>
								</div>
								<input type="hidden" name="id_guru" id="id_guru" value="<?php echo $_SESSION['id_guru']; ?>">
								<br>
								<div class="uk-form-row">
									<button type="submit" value="Lihat" name="nilai_tampilkan" id="nilai_tampilkan" class="uk-button uk-button-success" title="Tampilkan Laporan" disabled><i class="uk-icon-search"></i> Lihat</button>
								</div>
								<br><br>

								<?php if (isset ($_POST["nilai_tampilkan"]) ) : ?>
									<div class="uk-alert uk-alert-sucess">
									<div class="uk-form-row">
										<?php $exe123  = mysql_query("SELECT * FROM mengajar,mapel,kelas 
											where mengajar.id_kelas=kelas.id_kelas 
											and mengajar.kd_mapel=mapel.kd_mapel 
											and mengajar.kd_mapel='$kd_mapel'
											and mengajar.id_kelas='$id_kelas'"); 
											$keterangane=mysql_fetch_array($exe123); ?>
											<label class="uk-form-label">Mata Pelajaran : <span class="uk-text-success"><?php echo $keterangane[nm_mapel];?></span></label>
											<label class="uk-form-label">Kelas : <span class="uk-text-success"><?php echo $keterangane[nm_kelas];?></span></label>
											<label class="uk-form-label">KKM : <span class="uk-text-success"><?php echo $keterangane[kkm];?></span></label>
										</div>
										</div>
									</form>

									<div id="tablewrapper">
										<div id="tableheader">
											<div class="search">
												<select id="columns" onchange="sorter.search('query')"></select>
												<input type="text" id="query" onkeyup="sorter.search('query')" />
											</div>
											<span class="details">
												<div>Data <span id="startrecord"></span>-<span id="endrecord"></span> dari <span id="totalrecords"></span></div>
												<div><a href="javascript:sorter.reset()">(atur ulang)</a></div>
											</span>
										</div>
										<a href="guru.nilai.tambah"><button   class="uk-button uk-button-danger" type="button" title="Tambah Nilai">  <i class="uk-icon-pencil">   Input Nilai</i>  </button></a>
										<table id="table" class="uk-table uk-table-hover uk-table-striped uk-table-condensed" width="100%" width="100%">
											<thead>
												<tr>

													<th><h3 class="uk-text-center" >NO</h3></th>
													<th><h3 class="uk-text-center" >NIS</h3></th>
													<th><h3 class="uk-text-center" >Nama Siswa</h3></th>

													<th><h3 class="uk-text-center" >Jenis Kelamin</h3></th>
													<th><h3 class="uk-text-center" >Ulangan Harian</h3></th>
													<th><h3 class="uk-text-center" >Tugas</h3></th>
													<th><h3 class="uk-text-center" >UTS</h3></th>
													<th><h3 class="uk-text-center" >UAS</h3></th>
													<th><h3 class="uk-text-center" >Nilai Akhir</h3></th>

													<?php if (isset($_SESSION['id_guru'])) { ?>
													<th><h3 class="uk-text-center">Option</h3></th>
													<?php }?>
												</tr>
											</thead>
											<tbody>

											<?php 
												$exesetup  = mysql_query("SELECT * FROM setup_nilai WHERE 
													 id_tahun='$_SESSION[id_tahun]'
													and kd_mapel='$kd_mapel'
													and id_kelas='$id_kelas'
													and id_guru='$id_guru'
													");
												$rowsetup=mysql_fetch_array($exesetup);
												?>

												<?php 
												$no=0;
												$exes  = mysql_query("SELECT distinct * FROM ( SELECT distinct nilai.*, siswa.* FROM nilai, siswa, kelas_siswa, kelas, mengajar 
													where nilai.id_kelas_siswa=kelas_siswa.id_kelas_siswa
													and kelas_siswa.id_siswa=siswa.id_siswa  
													and mengajar.id_kelas=kelas_siswa.id_kelas  
													and nilai.id_tahun='$_SESSION[id_tahun]'
													and nilai.kd_mapel='$kd_mapel'
													and kelas_siswa.id_kelas='$id_kelas'
													and mengajar.id_guru='$id_guru'
													order by siswa.nm_siswa asc
													) 
												JSKDJS
												group by id_siswa order by nm_siswa asc
												");
												while($rows=mysql_fetch_array($exes)) {

													$id_nilai=$rows[id_nilai]; 

													$tugasakhir=($rows['t1']+$rows['t2']+$rows['t3']+$rows['t4']+$rows['t5']+$rows['t6']+$rows['t7'])/7;
													$uhakhir=($rows['uh1']+$rows['uh2']+$rows['uh3']+$rows['uh4']+$rows['uh5']+$rows['uh6']+$rows['uh7'])/7;

													$tugasakhirpersen=(($rows['t1']+$rows['t2']+$rows['t3']+$rows['t4']+$rows['t5']+$rows['t6']+$rows['t7'])/7) * $rowsetup[t]/100;
													$uhakhirpersen=(($rows['uh1']+$rows['uh2']+$rows['uh3']+$rows['uh4']+$rows['uh5']+$rows['uh6']+$rows['uh7'])/7 ) * $rowsetup[uh]/100;
													$utspersen=$rows[uts] * $rowsetup[uts]/100;
													$uaspersen=$rows[uas] * $rowsetup[uas]/100;

													$nilaiakhirfix=$tugasakhirpersen + $uhakhirpersen + $utspersen + $uaspersen;
													$nilaiakhirfix=round($nilaiakhirfix,2);
													$no++; ?>

										<div id="modaledit<?php echo $id_nilai ;?>" class="uk-modal">
											<div class="uk-modal-dialog">
												<button type="button" class="uk-modal-close uk-close"></button>
												<div class="uk-modal-header">
													<h2>Edit Data Nilai <?php echo $keterangane[nm_mapel];?></h2>
												</div>
												<form role="form" method="post" action="action.nilai?act=update&&id_nilai=<?php echo $id_nilai;  ?>" enctype="multipart/form-data" >
													<div class="form-group">
														<label>NIS</label>
														<input onkeyup="convertAngka(this);" class="form-control" readonly name="nis" id="nis" value="<?php echo $rows['nis']; ?>"   required  />
														
													</div>

													<div class="form-group">
														<label>Nama Siswa</label>
														<input class="form-control" name="nm_siswa" id="nm_siswa" readonly value="<?php echo $rows['nm_siswa']; ?>"  required />
      														
													</div>

													<div class="form-group">
														<label>Kelas</label>
														<input onkeyup="convertAngka(this);" class="form-control" name="nm_kelas" readonly="readonly"  id="nm_kelas" value="<?php echo $keterangane['nm_kelas']; ?>"  required  />
    														
													</div>
													<div class="form-group">
														<label>Ulangan Harian 1</label>
														<input onkeyup="convertAngka(this);" class="form-control" name="uh1"  id="uh1" value="<?php echo $rows['uh1']; ?>"    />
    														<div class="reg-info">Contoh: 80</div>
													</div>
													<div class="form-group">
														<label>Ulangan Harian 2</label>
														<input onkeyup="convertAngka(this);" class="form-control" name="uh1"  id="uh1" value="<?php echo $rows['uh1']; ?>"    />
    														<div class="reg-info">Contoh: 80</div>
													</div>
													<div class="form-group">
														<label>Ulangan Harian 2</label>
														<input onkeyup="convertAngka(this);" class="form-control" name="uh2"  id="uh2" value="<?php echo $rows['uh2']; ?>"    />
    														<div class="reg-info">Contoh: 80</div>
													</div>
													<div class="form-group">
														<label>Ulangan Harian 3</label>
														<input onkeyup="convertAngka(this);" class="form-control" name="uh3"  id="uh3" value="<?php echo $rows['uh3']; ?>"    />
    														<div class="reg-info">Contoh: 80</div>
													</div>
													<div class="form-group">
														<label>Ulangan Harian 4</label>
														<input onkeyup="convertAngka(this);" class="form-control" name="uh4"  id="uh4" value="<?php echo $rows['uh4']; ?>"    />
    														<div class="reg-info">Contoh: 80</div>
													</div>
													<div class="form-group">
														<label>Ulangan Harian 5</label>
														<input onkeyup="convertAngka(this);" class="form-control" name="uh5"  id="uh5" value="<?php echo $rows['uh5']; ?>"    />
    														<div class="reg-info">Contoh: 80</div>
													</div>
													<div class="form-group">
														<label>Ulangan Harian 6</label>
														<input onkeyup="convertAngka(this);" class="form-control" name="uh6"  id="uh6" value="<?php echo $rows['uh6']; ?>"    />
    														<div class="reg-info">Contoh: 80</div>
													</div>
													<div class="form-group">
														<label>Ulangan Harian 7</label>
														<input onkeyup="convertAngka(this);" class="form-control" name="uh7"  id="uh7" value="<?php echo $rows['uh7']; ?>"    />
    														<div class="reg-info">Contoh: 80</div>
													</div>
													<div class="form-group">
														<label>Tugas 1</label>
														<input onkeyup="convertAngka(this);" class="form-control" name="t1"  id="t1" value="<?php echo $rows['t1']; ?>"    />
    														<div class="reg-info">Contoh: 80</div>
													</div>
													<div class="form-group">
														<label>Tugas 2</label>
														<input onkeyup="convertAngka(this);" class="form-control" name="t2"  id="t2" value="<?php echo $rows['t2']; ?>"    />
    														<div class="reg-info">Contoh: 80</div>
													</div>
													<div class="form-group">
														<label>Tugas 3</label>
														<input onkeyup="convertAngka(this);" class="form-control" name="t3"  id="t3" value="<?php echo $rows['t3']; ?>"    />
    														<div class="reg-info">Contoh: 80</div>
													</div>
													<div class="form-group">
														<label>Tugas 4</label>
														<input onkeyup="convertAngka(this);" class="form-control" name="t4"  id="t4" value="<?php echo $rows['t4']; ?>"    />
    														<div class="reg-info">Contoh: 80</div>
													</div>
													<div class="form-group">
														<label>Tugas 5</label>
														<input onkeyup="convertAngka(this);" class="form-control" name="t5"  id="t5" value="<?php echo $rows['t5']; ?>"    />
    														<div class="reg-info">Contoh: 80</div>
													</div>
													<div class="form-group">
														<label>Tugas 6</label>
														<input onkeyup="convertAngka(this);" class="form-control" name="t6"  id="t6" value="<?php echo $rows['t6']; ?>"    />
    														<div class="reg-info">Contoh: 80</div>
													</div>
													<div class="form-group">
														<label>Tugas 7</label>
														<input onkeyup="convertAngka(this);" class="form-control" name="t7"  id="t7" value="<?php echo $rows['t7']; ?>"    />
    														<div class="reg-info">Contoh: 80</div>
													</div>
													<div class="form-group">
														<label>Ujian Tengah Semester</label>
														<input onkeyup="convertAngka(this);" class="form-control" name="uts"  id="uts" value="<?php echo $rows['uts']; ?>"    />
    														<div class="reg-info">Contoh: 80</div>
													</div>
													<div class="form-group">
														<label>Ujian Akhir Semester</label>
														<input onkeyup="convertAngka(this);" class="form-control" name="uas"  id="uas" value="<?php echo $rows['uas']; ?>"    />
    														<div class="reg-info">Contoh: 80</div>
													</div>

													<div class="uk-modal-footer uk-text-right">
														<button type="button" class="uk-button uk-modal-close ">Cancel</button>
														<button type="submit" class="uk-button uk-button-primary">Save</button>
													</div>
													<input type="hidden" name="edit" value="edit">
													<input type="hidden" name="id_kelas_siswa_edit" value="<?php echo $rows['id_kelas_siswa']; ?>">
													<input type="hidden" name="id_tahun_edit" value="<?php echo $rows['id_tahun']; ?>">
												</form>

											</div>
										</div>

										<div id="modal<?php echo $id_nilai ;?>" class="uk-modal">
											<div class="uk-modal-dialog">
												<button type="button" class="uk-modal-close uk-close"></button>
												<div class="uk-modal-header">
													<h2>Lihat Data Nilai <?php echo $keterangane[nm_mapel];?></h2>
												</div>
												
													<div class="form-group">
														<label>NIS</label>
														<input readonly onkeyup="convertAngka(this);" class="form-control" readonly name="nis" id="nis" value="<?php echo $rows['nis']; ?>"   required  />
														
													</div>

													<div class="form-group">
														<label>Nama Siswa</label>
														<input readonly class="form-control" name="nm_siswa" id="nm_siswa" readonly value="<?php echo $rows['nm_siswa']; ?>"  required />
      														
													</div>

													<div class="form-group">
														<label>Kelas</label>
														<input readonly onkeyup="convertAngka(this);" class="form-control" name="nm_kelas" readonly="readonly"  id="nm_kelas" value="<?php echo $keterangane['nm_kelas']; ?>"  required  />
    														
													</div>
													<div class="form-group">
														<label>Ulangan Harian 1</label>
														<input readonly onkeyup="convertAngka(this);" class="form-control" name="uh1"  id="uh1" value="<?php echo $rows['uh1']; ?>"  required  />
    														<div class="reg-info">Contoh: 80</div>
													</div>
													<div class="form-group">
														<label>Ulangan Harian 2</label>
														<input readonly onkeyup="convertAngka(this);" class="form-control" name="uh1"  id="uh1" value="<?php echo $rows['uh1']; ?>"  required  />
    														<div class="reg-info">Contoh: 80</div>
													</div>
													<div class="form-group">
														<label>Ulangan Harian 2</label>
														<input readonly onkeyup="convertAngka(this);" class="form-control" name="uh2"  id="uh2" value="<?php echo $rows['uh2']; ?>"  required  />
    														<div class="reg-info">Contoh: 80</div>
													</div>
													<div class="form-group">
														<label>Ulangan Harian 3</label>
														<input readonly onkeyup="convertAngka(this);" class="form-control" name="uh3"  id="uh3" value="<?php echo $rows['uh3']; ?>"  required  />
    														<div class="reg-info">Contoh: 80</div>
													</div>
													<div class="form-group">
														<label>Ulangan Harian 4</label>
														<input readonly onkeyup="convertAngka(this);" class="form-control" name="uh4"  id="uh4" value="<?php echo $rows['uh4']; ?>"  required  />
    														<div class="reg-info">Contoh: 80</div>
													</div>
													<div class="form-group">
														<label>Ulangan Harian 5</label>
														<input readonly onkeyup="convertAngka(this);" class="form-control" name="uh5"  id="uh5" value="<?php echo $rows['uh5']; ?>"  required  />
    														<div class="reg-info">Contoh: 80</div>
													</div>
													<div class="form-group">
														<label>Ulangan Harian 6</label>
														<input readonly onkeyup="convertAngka(this);" class="form-control" name="uh6"  id="uh6" value="<?php echo $rows['uh6']; ?>"  required  />
    														<div class="reg-info">Contoh: 80</div>
													</div>
													<div class="form-group">
														<label>Ulangan Harian 7</label>
														<input readonly onkeyup="convertAngka(this);" class="form-control" name="uh7"  id="uh7" value="<?php echo $rows['uh7']; ?>"  required  />
    														<div class="reg-info">Contoh: 80</div>
													</div>
													<div class="form-group">
														<label>Tugas 1</label>
														<input readonly onkeyup="convertAngka(this);" class="form-control" name="t1"  id="t1" value="<?php echo $rows['t1']; ?>"  required  />
    														<div class="reg-info">Contoh: 80</div>
													</div>
													<div class="form-group">
														<label>Tugas 2</label>
														<input readonly onkeyup="convertAngka(this);" class="form-control" name="t2"  id="t2" value="<?php echo $rows['t2']; ?>"  required  />
    														<div class="reg-info">Contoh: 80</div>
													</div>
													<div class="form-group">
														<label>Tugas 3</label>
														<input readonly onkeyup="convertAngka(this);" class="form-control" name="t3"  id="t3" value="<?php echo $rows['t3']; ?>"  required  />
    														<div class="reg-info">Contoh: 80</div>
													</div>
													<div class="form-group">
														<label>Tugas 4</label>
														<input readonly onkeyup="convertAngka(this);" class="form-control" name="t4"  id="t4" value="<?php echo $rows['t4']; ?>"  required  />
    														<div class="reg-info">Contoh: 80</div>
													</div>
													<div class="form-group">
														<label>Tugas 5</label>
														<input readonly onkeyup="convertAngka(this);" class="form-control" name="t5"  id="t5" value="<?php echo $rows['t5']; ?>"  required  />
    														<div class="reg-info">Contoh: 80</div>
													</div>
													<div class="form-group">
														<label>Tugas 6</label>
														<input readonly onkeyup="convertAngka(this);" class="form-control" name="t6"  id="t6" value="<?php echo $rows['t6']; ?>"  required  />
    														<div class="reg-info">Contoh: 80</div>
													</div>
													<div class="form-group">
														<label>Tugas 7</label>
														<input readonly onkeyup="convertAngka(this);" class="form-control" name="t7"  id="t7" value="<?php echo $rows['t7']; ?>"  required  />
    														<div class="reg-info">Contoh: 80</div>
													</div>
													<div class="form-group">
														<label>Ujian Tengah Semester</label>
														<input readonly onkeyup="convertAngka(this);" class="form-control" name="uts"  id="uts" value="<?php echo $rows['uts']; ?>"  required  />
    														<div class="reg-info">Contoh: 80</div>
													</div>
													<div class="form-group">
														<label>Ujian Akhir Semester</label>
														<input readonly onkeyup="convertAngka(this);" class="form-control" name="uas"  id="uas" value="<?php echo $rows['uas']; ?>"  required  />
    														<div class="reg-info">Contoh: 80</div>
													</div>

													<div class="uk-modal-footer uk-text-right">
														<button type="button" class="uk-button uk-modal-close ">Cancel</button>
														<button data-uk-modal="{target:'#modaledit<?php echo $id_nilai ;?>'}" class="uk-button uk-button-primary">Edit</button>
													</div>
													<input readonly type="hidden" name="edit" value="edit">
												

											</div>
										</div>
													<tr>

														<td><div class="uk-text-center"><?php echo $no?></div></td>
														<td><div class="uk-text-center"><?php echo $rows[nis]?></div></td>
														<td><div class="uk-text-left"><?php echo ucwords( strtolower($rows[nm_siswa]))?></div></td>
														<td><div class="uk-text-center"><?php echo $rows[jns_kelamin]?></div></td>
														<td><div class="uk-text-center"><?php echo $uhnopersen=round($uhakhir,2) ;?></div></td>
														<td><div class="uk-text-center"><?php echo round($tugasakhir,2);?></div></td>
														<td><div class="uk-text-center"><?php if($rows[uts]==''){echo "0"; }else{echo $rows[uts];}?></div></td>
														<td><div class="uk-text-center"><?php if($rows[uas]==''){echo "0"; }else{echo $rows[uas];}?></div></td>
														<?php 
														if ($nilaiakhirfix >= $keterangane[kkm]) {
															$warna='<span class="uk-badge uk-badge-notification uk-badge-success">'.$nilaiakhirfix.'</span>';
														}else{
															$warna='<span class="uk-badge uk-badge-notification uk-badge-danger">'.$nilaiakhirfix.'</span>';
														}
														?>

														<td><div class="uk-text-center"><?php echo $warna;?></div></td>

														<?php if (isset($_SESSION['id_guru'])) { ?>
														<td width="15%"><div class="uk-text-center">
															<button class="uk-button" data-uk-modal="{target:'#modal<?php echo $id_nilai ;?>'}"><i class="uk-icon-search"></i></button>
															<button class="uk-button uk-button-success" data-uk-modal="{target:'#modaledit<?php echo $id_nilai ;?>'}"><i class="uk-icon-pencil"></i></button>
															

														</td>
														<?php } ?>            
													</tr>
													<?php  } 
													
													?>
												</tbody>
											</table>
											<!-- PAGINATION -->
											<div id="tablefooter">
												<div id="tablenav">
													<div>
														<img src="assets/tablesorter/images/first.gif" width="16" height="16" alt="First Page" onclick="sorter.move(-1,true)" />
														<img src="assets/tablesorter/images/previous.gif" width="16" height="16" alt="First Page" onclick="sorter.move(-1)" />
														<img src="assets/tablesorter/images/next.gif" width="16" height="16" alt="First Page" onclick="sorter.move(1)" />
														<img src="assets/tablesorter/images/last.gif" width="16" height="16" alt="Last Page" onclick="sorter.move(1,true)" />
													</div>
													<div>
														<select id="pagedropdown"></select>
													</div>
													<div>
														<a href="javascript:sorter.showall()">Lihat semua</a>
													</div>
												</div>
												<div id="tablelocation">
													<div>
														<span>Tampilkan</span>
														<select onchange="sorter.size(this.value)">
															<option value="5">5</option>
															<option value="10" selected="selected">10</option>
															<option value="20">20</option>
															<option value="50">50</option>
															<option value="100">100</option>
														</select>
														<span>Data Per halaman</span>
													</div>
													<div class="page">(Halaman <span id="currentpage"></span> dari <span id="totalpages"></span>)</div>
												</div>
											</div>
											<!-- END Pagination -->
										</div>

										<hr class="uk-article-divider">
										<form class="uk-form uk-margin-top" method="post">
											<div class="uk-form-row">
												<button type="submit" id="tombolExport" value="Cetak Laporan" name="lap_cetak" class="uk-button uk-button-primary" title="Cetak Laporan"><i class="uk-icon-print"></i> Cetak Laporan</button>
											</div>
										</form>
									<?php endif; ?>
								</div>
							</div>
						</article>
					</div>
				</div>
			</div><br><br><br>




			<!-- Table Sorter Script -->
			<script type="text/javascript" src="assets/tablesorter/script.js"></script>
			<script type="text/javascript">
				var sorter = new TINY.table.sorter('sorter','table',{
					headclass:'head',
					ascclass:'asc',
					descclass:'desc',
					evenclass:'evenrow',
					oddclass:'oddrow',
					evenselclass:'evenselected',
					oddselclass:'oddselected',
					paginate:true,
					size:10,
					colddid:'columns',
					currentid:'currentpage',
					totalid:'totalpages',
					startingrecid:'startrecord',
					endingrecid:'endrecord',
					totalrecid:'totalrecords',
					hoverid:'selectedrow',
					pageddid:'pagedropdown',
					navid:'tablenav',
					sortcolumn:0,
					sortdir:0,
					sum:[3],
					columns:[{index:3, format:' unit', decimals:1}],
					init:true
				});
			</script>
			<!-- END Table Sorter Script -->



		</body>

		<script>
			$(document).ready(function (){
  // FORM SUBMIT and PROGRESS BAR CONTROL
  $('#kd_mapel').on('change', function(){
  	validate();
  	progress();
  	var id_guru = $("#id_guru").val();
  	var kd_mapel = $("#kd_mapel").val();
  	$.ajax({
  		url: "inc/jikuk_kelas_nilai.php",
  		data: "kd_mapel="+kd_mapel+"&id_guru="+id_guru,
  		cache: false,
  		success: function(msg){
  			$('select[name="id_kelas"]').html(msg);
  		}
  	});

  });

  $('#id_kelas').on('change', function(){
  	validate();
  	progress();
  });

  //download excel


});


			function validate(){
				if (
					$('#kd_mapel').val() != '' &&
					$('#id_kelas').val() != ''
					) {

					$('#nilai_tampilkan').prop('disabled', false);
			}
			else {
				$('#nilai_tampilkan').prop('disabled', true);
			}
		}

		function progress(){
			var w1 = ($('#kd_mapel').val() != '') ? 50 : 0;
			var w2 = ($('#id_kelas').val() != '') ? 50 : 0;
			wt = w1 + w2;
			$('#nilai_progress').css('width', wt+'%');
//	jikukkelas();
}




</script>

<?php

// LOAD FOOTER
loadAssetsFoot($scripts);

ob_end_flush();
?>

<script type="text/javascript" src="assets/exExcel/jquery.base64.js"></script>
<script type="text/javascript" src="assets/exExcel/jquery.btechco.excelexport.js"></script>
<script type="text/javascript">
	$(document).ready(function () {
		$("#tombolExport").click(function () {
			$("#exportTable").btechco_excelexport({
				containerid: "exportTable"
				, datatype: $datatype.Table
			});
		});
	});
</script>