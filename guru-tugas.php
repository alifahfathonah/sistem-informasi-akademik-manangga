<?php
// user login
require ( __DIR__ . '/init.php');
checkUserAuth();
checkUserRole(array(1));

// TEMPLATE CONTROL
$ui_register_page = 'guru-tugas';

// LOAD HEADER
loadAssetsHead('Master Data Tugas Guru');

?>

<link rel="stylesheet" href="assets/tablesorter/style.css" />

<body>

  <?php
  // LOAD MAIN MENU
  loadMainMenu();
  ?>

  <div class="uk-container uk-container-center">

    <div class="uk-grid uk-margin-large-top" data-uk-grid-margin data-uk-grid-match>

      <div class="uk-width-medium-1-6 uk-hidden-small">
        <?php loadSidebar() ?>
      </div>

      <div class="uk-width-medium-5-6 tm-article-side">
        <article class="uk-article">		
		
		  <div class="uk-vertical-align uk-text-right uk-height-1-1">
			  <img class="uk-margin-bottom" width="500px" height="50px" src="assets/images/banner.png" alt="E-Learning SMK N 4 Klaten" title="E-Learning SMK N 4 Klaten">
		  </div>
		  
		  <hr class="uk-article-divider">
          <h1 class="uk-article-title">Data Tugas <span class="uk-text-large">

		  { Master Data }</span></h1>
          <br>
		   <br><br>

		

  <table class="table table-nama" style="border: none; margin-bottom:2%;">
	<tbody>
	<tr><td class="table-nama-id">NIP.</td>
	<td>: <?php echo $_SESSION[usernameguru]?></td></tr>
	
	<tr><td class="table-nama-id">Nama Guru</td>
	<td>: <?php echo $_SESSION[nm_guru]?></td></tr>
		
	</tbody>
	</table>




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
		  <?php
      $usernameguru=$_SESSION['usernameguru'];
      $nip = "SELECT * from guru where usernameguru ='$usernameguru'";
      $query=mysql_query($nip);

      $cekguru=mysql_fetch_array($query);
      $user=$cekguru['nip'];
    
      $sql="SELECT * from mengajar, mapel where mapel.kd_mapel = mengajar.kd_mapel and nip='$usernameguru'";
      $hasil=mysql_query($sql);

    
   echo "<table cellpadding='0' cellspacing='0' border='0' id='table' class='tinytable'>";
	 echo "<thead>
			<tr>
								<th><h3 class='uk-text-center'>Kode Mata Pelajaran</h3></th>
								<th><h3 class='uk-text-center'>Nama Pelajaran</h3></th>
								<th><h3 class='uk-text-center'>Aksi</h3></th>
							</tr>
						</thead>";
        
      while ($data = mysql_fetch_array($hasil)) {
          
                $kd_mengajar=$data['kd_mengajar'];   
                $kd_mapel=$data['kd_mapel'];
                $nm_mapel=$data['nm_mapel'];
                $kd_kelas=$data['kd_kelas'];
                $nip=$data['nip'];
                $nm_guru=$data['nm_guru'];
        }
?>



<?php


          echo "<tr>";
          echo "<td><div class='uk-text-center'>$kd_mapel</td>"; 
          echo "<td><div class='uk-text-center'>$nm_mapel</td>";
          echo "<form method='POST' action='lihatsiswa' name='action'>
                <input type='hidden' value='$nip' name='nm_mapel'>
        
          <td align='center'>
         
            <a href='guru-lihat-tugas?id=$kd_mapel' class='uk-button'>Lihat Unggah</a>
            <a href='guru-tugas.tambah?id=$kd_mapel' class='btn btn-success'>Unggah Tugas</a>
           </form>";
           echo "</td>";
           echo "</tr>";
            
            echo "</tbody><br>";       
            echo "</table><br>";


?>
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
					
        </article>
		<br><br><br>
      </div>

    </div>
  </div>
  
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
			size:20,
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
			columns:[{index:7, format:' buah', decimals:1}],
			init:true
		});
	</script>
	<!-- END Table Sorter Script -->
	
</body>

<?php
// LOAD FOOTER
loadAssetsFoot();

ob_end_flush();
?>
