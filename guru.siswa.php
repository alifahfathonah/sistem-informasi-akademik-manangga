<!-- user login -->
<?php
session_start();
require ( __DIR__ . '/init.php');
checkUserAuth();
checkUserRole(array(1));

// TEMPLATE CONTROL
$ui_register_page     = 'guru.siswa';
$ui_register_assets   = array('datepicker');

// LOAD HEADER
loadAssetsHead('Lihat Data Siswa');

// FORM PROCESSING
// ... code here ...
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
            <img class="uk-margin-bottom" width="500px" height="50px" src="assets/images/banner.png" alt="Sistem Informasi Akademik SDN II Manangga" title="Sistem Informasi Akademik SDN II Manangga">
          </div>

          <hr class="uk-article-divider">
          <h1 class="uk-article-title">Data Siswa <span class="uk-text-large">
           { Daftar Siswa Yang Diampu }                 
           </span></h1>
                    <br>
            <?php
            $sqll = "SELECT * FROM user, guru WHERE guru.id_user=user.id_user AND id_guru={$_SESSION['id_guru']}";
            $resultl = mysql_query($sqll);
            $rowsl=mysql_fetch_array($resultl); 
            ?> 
            <div class="uk-panel uk-panel-box">
              <div class="uk-overflow-container">
                <table class="uk-table uk-table-condensed uk-text-nowrap">
                  <thead>
                    <tr>
                      <th class="uk-width-1-4">Data </th>
                      <th class="uk-width-3-4"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>NIP.</td>
                      <td><?php echo $rowsl['nip'];?></td>
                    </tr>
                    <tr>
                      <td>Nama Guru</td>
                      <td><?php echo $rowsl['nm_guru'];?></td>
                    </tr>

                  </tbody>
                </table>
              </div>
            </div>
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

                   <th><h3 class="uk-text-center">NIS</th>
                   <th><h3 class="uk-text-center">Nama Siswa</th>
                   <th><h3 class="uk-text-center">Tahun Pelajaran</th>
                   <th><h3 class="uk-text-center">Kelas</th>

                   
                   <th><h3 class="uk-text-center">Aksi</h3></th>
                   
                 </tr>
               </thead>
               <tbody>
                <?php 
 $id_guru= $_SESSION['id_guru'];
                $query="SELECT DISTINCT * from (
SELECT siswa.id_siswa, siswa.nis, siswa.nm_siswa, tahun_ajaran.thn_ajaran, kelas.nm_kelas  FROM mengajar, siswa, kelas_siswa, tahun_ajaran , kelas 
                WHERE kelas.id_kelas=kelas_siswa.id_kelas 
                and siswa.id_siswa=kelas_siswa.id_siswa 
                and tahun_ajaran.id_tahun=kelas_siswa.id_tahun
                and mengajar.id_kelas=kelas.id_kelas 
                and tahun_ajaran.status='1' 
                and mengajar.id_guru='$id_guru'
                order by kelas.nm_kelas asc
                ) sfds 
                order by nm_kelas asc
                ";
                $exe=mysql_query($query);


                $no=0;
                while ($row=mysql_fetch_array($exe)) { $no++;
                  $id_kelas_siswa= $row[id_kelas_siswa];
                  ?>
                  <div id="modal<?php echo $id_kelas_siswa ;?>" class="uk-modal">
                    <div class="uk-modal-dialog">
                      <button type="button" class="uk-modal-close uk-close"></button>
                      <div class="uk-modal-header">
                        <h2>Lihat Data Kelas Siswa</h2>
                      </div>

                      <div class="form-group">
                        <label>NIS</label>
                        <input class="form-control" name="nis" id="nis" value="<?php echo $row['nis']; ?>" readonly  required  />

                      </div>

                      <div class="form-group">
                        <label>Nama Siswa</label>
                        <input class="form-control" name="nm_siswa" id="nm_siswa" value="<?php echo $row['nm_siswa']; ?>" readonly required />
                      </div>

                      <div class="form-group">
                        <label>Tahun Ajaran</label>
                        <input class="form-control" name="thn_ajaran"  id="thn_ajaran" value="<?php echo $row['thn_ajaran']; ?>" readonly required  />
                      </div>
                      <div class="form-group">
                        <label>Kelas</label>
                        <select name="id_kelas"  id="id_kelas" value="" readonly disabled="disabled" class="form-control col-md-7 col-xs-12">
                        <option value="">--- Pilih Kelas --</option>
                          <?php
                      //MENGAMBIL NAMA PROVINSI YANG DI DATABASE
                          $kelas =mysql_query("SELECT * FROM kelas ORDER BY nm_kelas");
                          while ($datakelas=mysql_fetch_array($kelas)) {
                           if ($datakelas['id_kelas']==$row['id_kelas']) {
                             $cek ="selected";
                           }
                           else{
                            $cek= "";
                          }
                          echo "<option value=\"$datakelas[id_kelas]\" $cek>$datakelas[nm_kelas]</option>\n";
                        }
                        ?>
                      </select>
                    </div>

                    <div class="uk-modal-footer uk-text-right">
                      <button type="button" class="uk-button uk-modal-close ">Cancel</button>
                      <button data-uk-modal="{target:'#modaledit<?php echo $id_kelas_siswa ;?>'}" class="uk-button uk-button-primary">Edit</button>
                    </div>

                    
                  </div>
                </div>

                <div id="modaledit<?php echo $id_kelas_siswa ;?>" class="uk-modal">
                  <div class="uk-modal-dialog">
                    <button type="button" class="uk-modal-close uk-close"></button>
                    <div class="uk-modal-header">
                      <h2>Edit Data Kelas Siswa</h2>
                    </div>
                    <form role="form" method="post" action="kelas.siswa.action?act=update&&id_kelas_siswa=<?php echo $id_kelas_siswa;  ?>" enctype="multipart/form-data" >
                      <div class="form-group">
                        <label>NIS</label>
                        <input class="form-control" name="nis" id="nis" value="<?php echo $row['nis']; ?>"  readonly  required required  />
                     
                      </div>

                      <div class="form-group">
                        <label>Nama Siswa</label>
                        <input class="form-control" name="nm_siswa" id="nm_siswa" value="<?php echo $row['nm_siswa']; ?>" readonly  required required />
                        <div class="reg-info">Contoh: Bahasa Sunda</div>
                      </div>

                      <div class="form-group">
                        <label>Tahun Ajaran</label>
                        <input class="form-control" name="thn_ajaran"  id="thn_ajaran" value="<?php echo $row['thn_ajaran']; ?>"  readonly  required required  />
                        <div class="reg-info">Contoh: 65</div>
                      </div>
                       <div class="form-group">
                        <label>Kelas</label>
                        <select name="id_kelas"  id="id_kelas" value="" required class="form-control col-md-7 col-xs-12">
                        <option value="">--- Pilih Kelas --</option>
                          <?php
                      //MENGAMBIL NAMA PROVINSI YANG DI DATABASE
                          $kelas =mysql_query("SELECT * FROM kelas ORDER BY nm_kelas");
                          while ($datakelas=mysql_fetch_array($kelas)) {
                           if ($datakelas['id_kelas']==$row['id_kelas']) {
                             $cek ="selected";
                           }
                           else{
                            $cek= "";
                          }
                          echo "<option value=\"$datakelas[id_kelas]\" $cek>$datakelas[nm_kelas]</option>\n";
                        }
                        ?>
                      </select>
                    </div>

                      <div class="uk-modal-footer uk-text-right">
                        <button type="button" class="uk-button uk-modal-close ">Cancel</button>
                        <button type="submit" class="uk-button uk-button-primary">Save</button>
                      </div>
                      <input type="hidden" name="edit" value="edit">
                    </form>

                  </div>
                </div>
                <tr>

                  <td><?php echo $row[nis]?></td>
                  <td><?php echo $row[nm_siswa]?></td>
                  <td><?php echo $row[thn_ajaran]?></td>
                  <td><?php echo $row[nm_kelas]?></td>
                  
                  <td width="15%"><div class="uk-text-center">
                    <a href="guru.siswa.lihat?id=<?php echo $row[id_siswa]?>" title="Lihat" data-uk-tooltip="{pos:'top-left'}" class="uk-button uk-button-small"><i class="uk-icon-search"></i></a>
           

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
