<?php
header('Content-Type: text/html; charset=UTF-8');
require_once('sqlaction.php');
?>
<!doctype html>
<head>
  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
     .test{
       color:   #ffffff ;
     }  
        
        </style>
</header>
<?php
        try
        {
            $conn = OpenConnection();
           
            $tsql = "select Distinct angebotsnummer from tbl_zeiten ";
            $getangebotsnummer = sqlsrv_query($conn, $tsql);
           
            if ($getangebotsnummer == FALSE)
                die(FormatErrors(sqlsrv_errors()));
            $angebotsnummerCount = 0;
                  echo "<center><h1><label> Bitte eine Angebotsnummer auswählen: </label> </h1></center><br> ";
                  ?>
                  <html>
                   <form  action="" method="post">
                       <div align="center">
                  <select class="btn btn-secondary dropdown-toggle" type="button" name='Make'>
        </div>
                       </html>

                       <?php
                 
            while($row = sqlsrv_fetch_array($getangebotsnummer, SQLSRV_FETCH_ASSOC))
            {
               $erg= $row['angebotsnummer'];
                     echo "<option $value>$erg </option>";
                $angebotsnummerCount++;
            }
            echo "</select> <br> <br>";
            ?>
            <html >
            <div class="btn btn-primary btn-lg">
            <button  class="btn btn-primary"  type="submit" name="submit"   method="post">auswählen</button>
        </div>
        <br>
        <br>
</form>
                 </html>
                 <?php
                if(isset($_POST['submit'])){
                    if(!empty($_POST['Make'])) {
                        $selected = $_POST['Make'];
                       

                        sqlsrv_close($conn);
                    
                        $uebergabe = $_POST["Make"];
                        $tsql2 ="
                        Select Distinct kurzname, anfang, ende, angebotsnummer, arbeitszeit, kosten from tbl_Zeiten as z
    INNER JOIN tbl_Personal as p
    on z.pnr = p.pnr
    where z.angebotsnummer='$uebergabe'";
    $conn = OpenConnection();
    $getanfang = sqlsrv_query($conn, $tsql2);
    $anfangcount = 0;
    $rarbeitszeit =0;
    $kurzname= "";
    $kosten= 0;
    $kostengesamt=0;
    $summearbeitszeit=0;
    $counter =0;
    ?>
    <html>
         <table border="6" width="90%" height="50">
    <tr bgcolor=#0000FF class=test>
    <th> Kurzname </th>
    <th> Anfang </th>
    <th> Ende</th>
    <th>Angebotsnummer</th>
    <th> Arbeitszeit</th>
    <th>Kosten </th>
    </tr>
    
    </html>
    <?php
     while($row2 = sqlsrv_fetch_array($getanfang, SQLSRV_FETCH_ASSOC))
     {
      $kurzname=$row2['kurzname'];
      $erg2= $row2['anfang'] ->format('d.m.Y H:i');
      $ende= $row2['ende']->format('d.m.Y H:i');
      $arbeitszeit = $row2['arbeitszeit'];
      $kosten=$row2['kosten'];
      $kostengesamt= $kostengesamt+$row2['kosten'];
        $kurzname=utf8_encode($kurzname);
      $summearbeitszeit=$summearbeitszeit+ $arbeitszeit;
        
      $counter= $counter+1;
      
         $rarbeitszeit=round($arbeitszeit, $praezision=3, $mode=PHP_ROUND_HALF_UP);
         $kosten = round ($kosten, $praezision=3, $mode=PHP_ROUND_HALF_UP);
         if(($counter % 2) == 0){
            echo "
            
            <tr bgcolor=#5160EF
            class=test >
           
            <td>{$kurzname} </td>
            <td> {$erg2} </td> 
            <td>{$ende}  </td>
            <td>{$uebergabe}</td>
            <td> {$rarbeitszeit} </td>
            <td>{$kosten}</td>
          
            </tr> "
           ;
         }
         else{
            echo "
            <tr>
            <td>{$kurzname} </td>
            <td> {$erg2} </td> 
            <td>{$ende}  </td>
            <td>{$uebergabe}</td>
            <td> {$rarbeitszeit} </td>
            <td>{$kosten}</td>
            </tr> ";
           
         }
         
        
         $anfangcount++;
     } ?>
     <html>
     </table>
    </html>
    <?php
    echo "<br><h2>Die gesammten kosten betragen: $kostengesamt €</h1>";
    echo "<h2><br>Die gesammten Arbeitszeit beträgt: $summearbeitszeit Stunden </h1>";
    
     
                sqlsrv_free_stmt($getanfang);
                sqlsrv_close($conn);
            }
           
            ?>
         </select>
         </form>
    </html>

<?php
                    } else {
                        echo '<h3>Es wurde noch keine Angebotsnummer gewählt !';
                    }
                    }
                    catch(Exception $e)
                    {
                        echo("Error!");
                    }
                    ?>
              
                    </html>