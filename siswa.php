<?php
// user login
require ( __DIR__ . '/init.php');
checkUserAuth();
checkUserRole(array(10,1,24));

// TEMPLATE CONTROL
$ui_register_page = 'siswa';

// LOAD HEADER
loadAssetsHead('Master Data Siswa');

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
			  <img class="uk-margin-bottom" width="500px" height="50px" src="assets/images/banner.png" alt="Sistem Informasi Akademik SD Negeri II Manangga" title="Sistem Informasi Akademik SD Negeri II Manangga">
		  </div>
 
		  <hr class="uk-article-divider">
          <h1 class="uk-article-title">Manajemen Siswa <span class="uk-text-large">
          <?php  if (isset($_SESSION['administrator'])) {?>
		  { Master Data }</span></h1>
          <?php  }?>
          <br>
          <?php if (isset($_SESSION['administrator'])) { ?>
          <a href="./siswa.tambah" class="uk-button uk-button-success" type="button" title="Tambah Data Siswa"><i class="uk-icon-plus"></i> Data Siswa</a>
		  <?php } ?>
		   <br><br>
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
          <table id="table" class="uk-table uk-table-hover uk-table-striped uk-table-condensed" width="100%" width="100%">
            <thead>
              <tr>
               
                <th><h3>NIS</h3></th>
                <th><h3>Nama Siswa</h3></th>
                
                <th><h3>Jenis Kelamin</h3></th>
                

                <th><h3>Aksi</h3></th>
                
              </tr>
            </thead>
              <tbody>
              <?php 
            
              $query="SELECT * from siswa order by nm_siswa asc";
              $exe=mysql_query($query);

              
              $no=0;
              while ($row=mysql_fetch_array($exe)) { $no++;?>

                <tr>
               
                <td ><?php echo $row[nis]?></td>
                <td ><?php echo $row[nm_siswa]?></td>
                <td ><?php echo $row[jns_kelamin]?></td>
        
                <td width="15%"><div class="uk-text-center">
                  <a href="siswa.lihat?id=<?php echo $row[id_siswa]?>" title="Lihat" data-uk-tooltip="{pos:'top-left'}" class="uk-button uk-button-small"><i class="uk-icon-search"></i></a>
                                  <?php if (isset($_SESSION['administrator'])) { ?>
                  <a href="siswa.update?id=<?php echo $row[id_siswa]?>" title="Sunting" data-uk-tooltip="{pos:'top-left'}" class="uk-button uk-button-small"><i class="uk-icon-pencil"></i></a>
                  <?php }?>
                </td>
                    
                </tr>
                <?php  } ?>
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
