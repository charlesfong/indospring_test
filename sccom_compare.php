<?php
/***************************************************************************
Version Note : My SC Commission
Last Update Date : 26-Feb-2018 17:00
Last Update By : himawan
Remark:
  - create new module
**************************************************************************
*/
include("../module/global.inc");
include("../module/global2_inc.php");
include("../module/global4_inc.php");
$debug=0;
if ($opnm=='hima') $debug=1;
check_login();
$shouldpriv=0;
check_access_page();
$xopnm="$opnm-$REMOTE_ADDR";
$result=pg_exec($db,"set datestyle to 'POSTGRES,EUROPEAN'");
// $blns_arr=array("January","February","March","April","May","June","July","August","September","October","November","December");


function getEntitled($xtype,$xcat,$xamt) {
    global $db,$debug;
    if ($debug) echo "getEntitled($xtype,$xcat,$xamt);<br/>";
    $result=0;
    if($xamt=='')$xamt=0;
    $xsc_sql2="select fentitled from sccom_setup_extra where ftype='$xtype' and fcategory='$xcat' and $xamt between fcondition3 and fcondition5 limit 1;";
    if ($debug) echo "$xsc_sql2<br/>";
    $xsc_res2=pg_exec($db, $xsc_sql2);
    if(pg_num_rows($xsc_res2)>0){
      $xsc_row=pg_fetch_row($xsc_res2, 0);
      $result=$xsc_row[0];
    }
    pg_free_result($xsc_res2);
    return $result;
}//end function getEntitled

function getSCdeduc($xscode,$xmonth) {
    global $db,$debug;
    $result=0;
    $xsc_sql2="select dec_amt from sccom_deduc where sccode='$xscode' and dec_month='$xmonth' limit 1";
    $xsc_res2=pg_exec($db, $xsc_sql2);
    if(pg_num_rows($xsc_res2)>0){
      $xsc_row=pg_fetch_row($xsc_res2, $i);
      $result = $xsc_row[0];
    }
    pg_free_result($xsc_res2);
    return $result;
}

function getSCadj($xscode,$xmonth) {
    global $db,$debug;
    $result=0;
    $xsc_sql2="select adj_amt from sccom_adjust where sccode='$xscode' and adj_month='$xmonth' limit 1";
    $xsc_res2=pg_exec($db, $xsc_sql2);
    if(pg_num_rows($xsc_res2)>0){
      $xsc_row=pg_fetch_row($xsc_res2, $i);
      $result = $xsc_row[0];
    }
    pg_free_result($xsc_res2);
    return $result;
}

function getSChold($xscode,$xmonth) {
    global $db,$debug;
    $result='';
    $xsc_sql2="select dec_hold from sccom_hold where sccode='$xscode' limit 1";//and dec_month='$xmonth'
    $xsc_res2=pg_exec($db, $xsc_sql2);
    if(pg_num_rows($xsc_res2)>0){
      $xsc_row=pg_fetch_row($xsc_res2, $i);
      if($xsc_row[0]!=''){
        $xsc_row[0] = ($xsc_row[0]=='1')?"T":"F";
        $result = $xsc_row[0];
      }
    }
    pg_free_result($xsc_res2);
    return $result;
}
function getSConline($xscode,$xmonth) {
    global $db,$debug;
    $result='';
    /*
    $xsc_sql2="select sc_payment from sccom_online where sccode='$xscode' and sc_month='$xmonth' limit 1";
    $xsc_res2=pg_exec($db, $xsc_sql2);
    if(pg_num_rows($xsc_res2)>0){
      $xsc_row=pg_fetch_row($xsc_res2, $i);
      if($xsc_row[0]!=''){
        $xsc_row[0] = ($xsc_row[0]=='1')?"T":"F";
        $result = $xsc_row[0];
      }
    }
    */
    $xsc_sql2="select crno from msmemb where code='$xscode' ";
    $xsc_res2=pg_exec($db, $xsc_sql2);
    if(pg_num_rows($xsc_res2)>0){
      $xsc_row=pg_fetch_row($xsc_res2, $i);
      if($xsc_row[0]!=''){
//         $xsc_row[0] = ($xsc_row[0]=='2')?"T":"F";
        $result = $xsc_row[0];
      }
    }
    pg_free_result($xsc_res2);
    return $result;
}
function getDecimalCom($xval) {
    $xarr_amt = preg_split('/[\.]/',$xval);
    $xval2=substr($xarr_amt[1],1,1);
    $xval3=substr($xarr_amt[1],0,1);
    if($xval2==1 || $xval2==2)
        $xval=$xarr_amt[0].".".substr($xarr_amt[1],0,1)."0";
    else if($xval2>=3 && $xval2<=7)
        $xval=$xarr_amt[0].".".substr($xarr_amt[1],0,1)."5";
    else if(($xval2==8 || $xval2==9) && $xval3<9)
        $xval=$xarr_amt[0].".".(substr($xarr_amt[1],0,1)+1)."0";
    else if(($xval2==8 || $xval2==9) && $xval3==9) {
            $intnetcom = floatval(str_replace(",", '' ,$xarr_amt[0]));
            $xval=floatval(($intnetcom+1).".00");
            $xval=number_format($xval,2, '.','');
    }
    return $xval;
}
if ($fnext=='1' || $fnext=='6') {
  $bresult=pg_exec($db,"begin transaction");

  $xtable_name="sccom";
  if ($fnext=='6') {
		$xtable_name="sccom_temp";
		pg_query($db, "delete from sccom_temp");
  }
  
  $xsubmonth=str_pad($fmonth, 2, '0', STR_PAD_LEFT).'-'.$fyear;
  $xmonth=str_pad($fmonth, 2, '0', STR_PAD_LEFT).$fyear;
  $xTgl1 = '01-'.$xsubmonth;
  $xTgl2 = $daysInMonth[$fmonth-1].'-'.$xsubmonth;

  if ($fmonth==2 && is_leapyear($fyear))
    $xTgl2 = ($daysInMonth[$fmonth-1]+1).'-'.$xsubmonth;


  $xsc_sql=
    "select a.code, c.name,b.stockist,b.fcat_sccom,s.st_name,
      b.fcat_sccom_ms,b.tax_id ".
    "from sub_mssc a, sub_mssc_extra b, msmemb c,state s ".
    "where a.code=b.scname and a.code=c.code and a.st_id=s.st_id ";
  if ($rdo_type=='MS') $xsc_sql.="and  b.stockist='0' ";
  if ($txt_scid!='x') $xsc_sql.="and  a.code='$txt_scid' ";
  $xsc_sql.="order by a.code ";

  if ($debug) {
    echo nl2br($xsc_sql)." <br/>\n";
  }
  $xsc_res=pg_exec($db, $xsc_sql);
  $no=0;
  for ($i=0; $i<pg_num_rows($xsc_res); $i++) {
//     $xsc_row=pg_fetch_assoc($xsc_res, $i);
//     if ($xsc_row['stockist']=='0') $xtype="MS";
//     if ($xsc_row['stockist']=='1') $xtype="SC";

      $xsc_row=pg_fetch_row($xsc_res, $i);
      //$xlevel_msid=check_level_ex($xsc_row[0]);
      if ($debug) {
        print_r($xsc_row);
        //echo "<br/>xlevel_msid=$xlevel_msid <br/>\n";
      }
      $xtotpv=0;
      $xtotsv=0;
      $xtotdp=0;
      $xtotpay=0;
      $xtotpv2=0;
      $xtotsv2=0;
      $xtotdp2=0;
      $xtotpay2=0;
      $xentitled2=0;
      $xentitled=0;
      if ($xsc_row[2]=='0') $xtype="MS";
      if ($xsc_row[2]=='1') $xtype="SC";
      //if($rdo_type=="SC" || $rdo_type=="ALL" || $rdo_type=="MS"){
        $querr=
          "select sum(a.tpv),sum(a.tbv),sum(a.ndp),sum(a.totpay) 
          from newsctrh a 
          where a.loccd ='$xsc_row[0]' 
          and a.bpdt>='$xTgl1' and a.bpdt<='$xTgl2' and a.post='1'
          and a.trtype in ('1','3','5')
          group by a.loccd ;";
        if ($debug) echo "$querr*<br>";

        $xres2 = pg_exec($db, $querr);
        if(pg_num_rows($xres2)>0){
          $xrow2=pg_fetch_row($xres2, 0);
          $xtotpv=$xrow2[0];
          $xtotsv=$xrow2[1];
          $xtotdp=$xrow2[2];
          $xtotpay=$xrow2[3];
        }
        $xsql3= "select sum(b.qty*b.dp),sum(b.qty*b.dp),
          sum(b.qty*b.dp)
          from newsctrd b left join msprd c on c.prdcd=b.prdcd,newsctrh a
          where a.trcd=b.trcd and a.loccd='$xsc_row[0]'
          and a.bpdt>='$xTgl1' and a.bpdt<='$xTgl2' and a.post='1'
          and a.trtype in ('1','3','5') and c.kit>='1'; ";
        if ($debug) echo "$xsql3**<br>";
        $xres3=pg_exec($db, $xsql3);
        $xtot_pv=0;
        $xtot_sv=0;
        $xtot_dp=0;
        if (pg_num_rows($xres3)>0) {
          for ($o=0;$o<pg_num_rows($xres3);$o++) {
            $xrow3=pg_fetch_row($xres3, $o);
            $xtot_pv+=$xrow3[0];
            $xtot_sv+=$xrow3[1];
            $xtot_dp+=$xrow3[2];
          }
        }
        pg_free_result($xres3);
        $xtotpv+=$xtot_pv;
        $xtotsv+=$xtot_sv;
    //    $xtotdp+=$xtot_dp;
        $xentitled=getEntitled("SC",$xsc_row[3],$xtotpay);
      //} 
      //if(($rdo_type=="MS" || $rdo_type=="ALL") && $xsc_row[2]=='0'){
        $querr="select sum(a.tpv),sum(a.tbv),sum(a.ndp),sum(a.totpay) 
          from newmsivtrh a 
          where a.loccd ='$xsc_row[0]' and a.trdt>='$xTgl1' and a.trdt<='$xTgl2' 
          and a.post='1'
          group by a.loccd ;";
          //and a.bpdt>='$xTgl1' and a.bpdt<='$xTgl2' 
        if ($debug) {
          echo nl2br($querr)."<br/>\n";
        }
        $xres2 = pg_exec($db, $querr);
        if(pg_num_rows($xres2)>0){
          $xrow2=pg_fetch_row($xres2, 0);
          $xtotpv2=$xrow2[0]+$xtotpv;
          $xtotsv2=$xrow2[1]+$xtotsv;
          $xtotdp2=$xrow2[2]+$xtotdp;
          $xtotpay2=$xrow2[3]+$xtotpay;
        } else {
          $xtotpv2=$xtotpv;
          $xtotsv2=$xtotsv;
          $xtotdp2=$xtotdp;
          $xtotpay2=$xtotpay;

        }
        $xsql3= "select sum(b.qty*b.dp),sum(b.qty*b.dp),
        sum(b.qty*b.dp)
        from newmsivtrd b 
        left join msprd c on c.prdcd=b.prdcd,newmsivtrh a
        where a.trivcd=b.trivcd and a.loccd='$xsc_row[0]'
        and a.trdt>='$xTgl1' and a.trdt<='$xTgl2'  and c.kit='1'; ";
        if ($debug) echo "$xsql3<br>";
        $xres3=pg_exec($db, $xsql3);
        $xtot_pv=0;
        $xtot_sv=0;
        $xtot_dp=0;
        if (pg_num_rows($xres3)>0) {
          for ($o=0;$o<pg_num_rows($xres3);$o++) {
            $xrow3=pg_fetch_row($xres3, $o);
            $xtot_pv+=$xrow3[0];
            $xtot_sv+=$xrow3[1];
            $xtot_dp+=$xrow3[2];
          }
        }
        pg_free_result($xres3);
        $xtotpv2+=$xtot_pv;
        $xtotsv2+=$xtot_sv;
    //    $xtotdp2+=$xtot_dp;
        $xentitled2=getEntitled("MS",$xsc_row[5],$xtotpay2);
      //}
      $xdeduc=getSCdeduc($xsc_row[0],$xmonth);
      $xadj=getSCadj($xsc_row[0],$xmonth);
      $xhold=getSChold($xsc_row[0],$xmonth);
      $xonline=getSConline($xsc_row[0],$xmonth);
      if($rdo_type=="ALL")  
        $xtotalcom = round((($xentitled*$xtotsv)/100),2) + round((($xentitled2*($xtotsv2))/100),2);
      else if ($rdo_type=="SC")
        $xtotalcom = round((($xentitled*$xtotsv)/100),2);
      else if ($rdo_type=="MS") 
        $xtotalcom = round((($xentitled2*($xtotsv2))/100),2);

      $netbefround=($xtotalcom-$xdeduc+($xadj));

      if ($debug)
      {
        echo "rdo_type=$rdo_type<br/>\n";
        echo "$netbefround=($xtotalcom-$xdeduc+($xadj)) <br/>\n";
      }

      if($netbefround<0)
        $xnetcom=number_format($netbefround,2,'.','');
      else
        $xnetcom=getDecimalCom(number_format(($xtotalcom-$xdeduc+($xadj)),2,'.',''));

      $intnetcom = floatval(str_replace(",", '' ,$xnetcom));
      $xrounding=($intnetcom-($xtotalcom-$xdeduc+($xadj)));
      $xrounding=number_format($xrounding,2,'.','');

      $disround=$xrounding;
      //if($xrounding<=0) $disround="(".number_format($xrounding*(-1),2).")";

      $xcat='';

      if($rdo_type=="ALL")
      {          
/*        $xcat=$xsc_row[3].",".$xsc_row[5];
        $diskon=number_format($xentitled,2)." , ".number_format($xentitled2,2);
        $ppv=number_format($xtotpv,2)." , ".number_format($xtotpv2,2);
        $psv=number_format($xtotsv,2)." , ".number_format($xtotsv2,2);
        $pdp=number_format($xtotdp,2)." , ".number_format($xtotdp2,2);
        $ptotpv=number_format($xgrandpv,2)." , ".number_format($xgrandpv2,2);
        $ptotsv=number_format($xgrandsv,2)." , ".number_format($xgrandsv2,2);
        $ptotdp=number_format($xgranddp,2)." , ".number_format($xgranddp2,2);*/
        //$xcat=$xsc_row[3];
        $diskon=number_format($xentitled,2);
        $ppv=number_format($xtotpv,2,'.','');
        $psv=number_format($xtotsv,2,'.','');
        $pdp=number_format($xtotdp,2,'.','');
        $ptotpv=number_format($xgrandpv,2,'.','');
        $ptotsv=number_format($xgrandsv,2,'.','');
        $ptotdp=number_format($xgranddp,2,'.','');
      }
      else if ($rdo_type=="SC")
      { 
        $diskon=number_format($xentitled,2);
        $ppv=number_format($xtotpv,2,'.','');
        $psv=number_format($xtotsv,2,'.','');
        $pdp=number_format($xtotdp,2,'.','');
        $ptotpv=number_format($xgrandpv,2,'.','');
        $ptotsv=number_format($xgrandsv,2,'.','');
        $ptotdp=number_format($xgranddp,2,'.','');
      }
      else if ($rdo_type=="MS") 
      {
        $diskon=number_format($xentitled2,2);
        $ppv=number_format($xtotpv2,2,'.','');
        $psv=number_format($xtotsv2,2,'.','');
        $pdp=number_format($xtotdp2,2,'.','');
        $ptotpv=number_format($xgrandpv2,2,'.','');
        $ptotsv=number_format($xgrandsv2,2,'.','');
        $ptotdp=number_format($xgranddp2,2,'.','');
      }
      $xcat=$xsc_row[3];
      $xcat_ms=$xsc_row[5];

//    $prin_dec=($rdo_type!="ALL")?number_format($xdeduc1,2):number_format($xdeduc1,2).",".number_format($xdeduc2,2);
//    $prin_adj=($rdo_type!="ALL")?number_format($xadj1,2):number_format($xadj1,2).",".number_format($xadj2,2);
			if ($debug) {
			  echo "xtotdp=$xtotdp && xtotdp2=$xtotdp2<br/>\n";
			}
      if($xtotdp==0 && $xtotdp2==0){ 
      }else {
//        if($rdo_type!="ALL") {
/*
?>
          <TR bgcolor="#FFFFFF">
            <td><?=$no+1?></td>
            <td><?=stripslashes($xsc_row[1])?></td>
            <td><?=$xsc_row[0]?></td>
            <td align="right"><?=$ppv?></td>
            <td align="right"><?=$psv?></td>
            <td align="right"><?=$pdp?></td>
            <td><?=($xcat==",")?"":$xcat;?></td>
            <td align="right"><?=$diskon?></td>
            <td align="right"><?=number_format($xtotalcom,2)?></td>
            <td align="right"><?=number_format($xdeduc,2)?></td>
            <td align="right"><?=number_format($xadj,2)?></td>
            <td align="right"><?=$disround?></td>
            <td align="right"><?=$xnetcom;?></td>
            <td><?=$xhold?></td>
            <td><?=$xonline?></td>
            <td><?=$xsc_row[4]?></td>
            <td ><input type='button' name='print_' value='<?=mxlang("406","")?>' onclick="valprint('<?=$xsc_row[0]?>','<?=$xTgl1?>','<?=$xTgl2?>','<?=$xtype?>','<?=$fmonth?>','<?=$fyear?>');"></td>
          </TR>

<?  
*/
          $xmonth=str_pad($fmonth, 2, '0', STR_PAD_LEFT).$fyear;

          $xarr_totalcom=fget4totalcom($xsc_row[0], $rdo_type, $xTgl1, $xTgl2, $xsc_row[2]);
          if ($debug) {
            echo "xarr_totalcom=";
            print_r($xarr_totalcom);
            echo "<br/>";
          }
          $xsub_total1=$xarr_totalcom['totalcom'];
/*
          if ($debug) print_r($xarr_sccom_deduction);
          $xarr_sccom_addition =
            db_select_record('sum(amount) as xsum_amt', 'sccom_addition', "where sccode='$xsc_row[0]' and fmonth='$xmonth'");
          if ($xarr_sccom_addition['xsum_amt']=='') $xarr_sccom_addition['xsum_amt']=0;
          $xarr_sccom_addition['gst']=($xarr_totalcom['totalcom']+$xarr_sccom_addition['xsum_amt'])*$xarr_cb_setup['vat_txt']/100;  
          if ($debug) {
            echo "xarr_sccom_addition=";print_r($xarr_sccom_addition);
          }
*/
          $xarr_mssc_extra = db_select_record('sc_vat_payer, tax_id, tax_effdt, tax_enddt', 'sub_mssc_extra', "where scname='$xsc_row[0]' ");
          $xarr_mssc_extra['tax_effdt_a'] = '01-'.substr($xarr_mssc_extra['tax_effdt'], 3, 8);

          $xbol_sc_gst=($xarr_mssc_extra['sc_vat_payer']=='t' && fdate_format($xarr_mssc_extra['tax_effdt_a'])<=fdate_format($xTgl1))?true:false;

          if ($debug) {
            echo "$xbol_sc_gst=".$xarr_mssc_extra['sc_vat_payer']."=='t' && ".fdate_format($xarr_mssc_extra['tax_effdt_a'])."<=".fdate_format($xTgl1)."<br/>\n";
            echo "xbol_sc_gst=$xbol_sc_gst $xsub_total1<br/>\n";
          }
          $xarr_gst_addit=fget_total_addit($xsc_row[0], $xmonth, $xarr_cb_setup['vat_txt'], $xbol_sc_gst, $xsub_total1);
          if ($debug) {
            print_r($xarr_gst_addit);
            echo "<br/>\n";
          }
          $xsub_total3=$xarr_gst_addit['xtotal1'];
/*
          $xarr_addition_fee=fpg_exec4("select sum(amount) as xsum_amt
            from sccom_addition x
            inner join add_deduct_setup a on a.title_id=x.title_id
            inner join item_setup b on b.item_id=x.item_id
            where x.sccode='$xsc_row[0]' and x.fmonth='$xmonth' and a.gst=TRUE and a.title like '%Fee%' ",1);
          if ($xarr_mssc_extra['sc_vat_payer']=='t' && $xarr_mssc_extra['tax_effdt']>=$xTgl1){
            $xarr_addition_fee['gst']=($xsub_total1+$xarr_addition_fee['xsum_amt'])*$xarr_cb_setup['vat_txt']/100;
            $xarr_addition_fee['gst']=number_format($xarr_addition_fee['gst'],2,'.','');
          }else{
            $xarr_addition_fee['gst']=0;
          }

          if ($debug) {
            print_r($xarr_addition_fee); 
            echo "xbol_sc_gst=$xbol_sc_gst $xsub_total1<br/>\n";
          }

          $xsub_total2 = $xsub_total1+$xarr_addition_fee['xsum_amt']+$xarr_addition_fee['gst'];
          if ($debug) {
            echo "xarr_addition_fee=";print_r($xarr_addition_fee);echo "<br/>xsub_total2=$xsub_total2;<br/>\n";
          }

          $xarr_addition_other=fpg_exec4("select sum(amount) as xsum_amt
            from sccom_addition x
            inner join add_deduct_setup a on a.title_id=x.title_id
            inner join item_setup b on b.item_id=x.item_id
            where x.sccode='$xsc_row[0]' and x.fmonth='$xmonth' and a.gst=TRUE and not a.title like '%Fee%' ",1);
          if ($debug) print_r($xarr_addition_other);
          
          $xsub_total3=$xsub_total2+$xarr_addition_other['xsum_amt'];

          if ($debug) {
            echo "xarr_addition_other=";print_r($xarr_addition_other);echo "<br/>xsub_total3=$xsub_total3;<br/>\n";
          }
*/
//begin gst deduction
          $xarr_gst_deduct=fget_total_deduct($xsc_row[0], $xmonth, $xarr_cb_setup['vat_txt'], $xbol_sc_gst);
//end gst deduction       

          $xsub_total4=$xsub_total3-$xarr_gst_deduct['total']-$xarr_gst_deduct['vat'];

          //$xsub_total4=$xsub_total3-$xarr_deduct_other['xsum_amt']-$xarr_deduct_fee['xsum_amt']-$xarr_deduct_fee['gst'];
          if ($debug) echo "xsub_total4=$xsub_total4<br/>\n";

          //89.6 + 2 + 5.5
          //- 6.1 - 0.25
          //$xnetcomx  = $xarr_totalcom['totalcom'] + $xarr_sccom_addition['xsum_amt'] + $xarr_sccom_addition['gst'] - $xarr_sccom_deduction['xsum_amt'] - $xarr_sccom_deduction['gst'];

          $xtotalcom=$xsub_total4;

          $netbefround=($xtotalcom);
          if ($debug) echo "netbefround=$netbefround=($xtotalcom); <br/>\n";

          if($netbefround<0)
            $xnetcom=number_format($netbefround,2,'.','');
          else
            $xnetcom=getDecimalCom(number_format(($xtotalcom),2,'.',''));

          if ($debug) echo "xnetcom=$xnetcom <br/>\n";

          $intnetcom = floatval(str_replace(",", '' ,$xnetcom));
          if ($debug) echo "intnetcom=$intnetcom <br/>\n";
          $xrounding=($intnetcom-($xtotalcom));
          if ($debug) echo "xrounding=$xrounding=($intnetcom-($xtotalcom)); <br/>\n";
          $disround=number_format($xrounding,2);
          if($disround=='-0.00') $disround='0.00';

          if ($debug) echo "disround=$disround=number_format($xrounding,2); <br/>\n";

          $xrow_sc_sales_cb  = fget_sc_sales_cb($xsc_row[0], $xTgl1, $xTgl2);
          $xrow_sc_sales_inv = fget_sc_sales_inv($xsc_row[0], $xTgl1, $xTgl2);

          $xrow_sc_purchase_br  = fget_sc_purchase($xsc_row[0], $xTgl1, $xTgl2, 'BR');
          $xrow_sc_purchase_ms  = fget_sc_purchase($xsc_row[0], $xTgl1, $xTgl2, 'MS');
          if ($debug) {
            print_r($xrow_sc_purchase_br);
            print_r($xrow_sc_purchase_ms);
            echo "<br/>\n";
          }
          $xtotal_cn = fget_total_cn($xsc_row[0], $xTgl1, $xTgl2);
					if ($debug) echo "xtotal_cn=$xtotal_cn<br/>\n";
          unset($xarr_data);
          $xarr_data = array (
            'sccode'      => $xsc_row[0],
            'scname'      => stripslashes($xsc_row[1]),
            'sc_gstno'    => (($xbol_sc_gst)?$xsc_row[6]:''),
            'totpv'       => $ppv, 
            'totsv'       => $psv, 
            'totdp'       => $pdp, 
            'stk_category'=> ($xcat==",")?"":$xcat,
            'stk_percent' => $xentitled,
            'fmonth'      => $xmonth,
            'state'       => $xsc_row[4],

            //'totcomm'     => number_format($xtotalcom,2,'.',''),
            'totcomm'     => number_format($xarr_totalcom['totalcom'],2,'.',''),

            'netcomm'     => $xnetcom,
            'gst_deduction'  => number_format($xarr_gst_deduct['vat'],2,'.',''),
            'deduction' => number_format($xarr_gst_deduct['total'],2,'.',''),
            'gst_addition'   => number_format($xarr_gst_addit['vat'],2,'.',''),
            'addition'  => number_format($xarr_gst_addit['total'],2,'.',''),

            
            'sc_type'     => $xsc_row[2],

            'rounding'    => $disround,

            'output_cb'   => number_format($xrow_sc_sales_cb['xsumtdp'],2,'.',''),
            'output_inv'  => number_format($xrow_sc_sales_inv['xsumtdp'],2,'.',''),

            //'input_br'    => number_format($xrow_sc_purchase_br['xsumtdp'],2,'.',''),//+$xrow_sc_purchase_br['xsumcost']
            //'input_br'    => number_format($xrow_sc_purchase_br['xsumtdp']+$xrow_sc_purchase_br['xsumcost']-$xrow_sc_purchase_br['xsumship_vat'],2,'.',''),//+$xrow_sc_purchase_br['xsumcost']
            'input_br'    => number_format($xrow_sc_purchase_br['xsumtdp']+$xrow_sc_purchase_br['xsumcost']-$xrow_sc_purchase_br['xsumship_vat'],2,'.','')-$xrow_sc_purchase_br['sv_exgst'],
            'input_ms'    => number_format($xrow_sc_purchase_ms['xsumtdp']+$xrow_sc_purchase_ms['xsumcost']-$xrow_sc_purchase_ms['xsumship_vat'],2,'.',''),//+$xrow_sc_purchase_ms['xsumcost']
            
            'totcn'       => $xtotal_cn,
            'vat'         => $xarr_cb_setup['vat_txt'],

            'output_cb_vat' => number_format($xrow_sc_sales_cb['xsumptax'],2,'.',''),
            'output_inv_vat'=> number_format($xrow_sc_sales_inv['xsumptax'],2,'.',''),
            //'input_br_vat'  => number_format($xrow_sc_purchase_br['xsumptax']+$xrow_sc_purchase_br['xsumship_vat'],2,'.',''),
            'input_br_vat'  => number_format($xrow_sc_purchase_br['xsumptax']+$xrow_sc_purchase_br['xsumship_vat'],2,'.','')-$xrow_sc_purchase_br['valgst'],
            'input_ms_vat'  => number_format($xrow_sc_purchase_ms['xsumptax']+$xrow_sc_purchase_ms['xsumship_vat'],2,'.',''),
            
            'hold'          => ($xhold=='T')?'true':'false',
            'fonline'       => ($xonline=='2')?'true':'false',

          );
          if ($xsc_row[2]=='0') {//if main stockist
            $xarr_data['ms_totpv']=$xarr_totalcom['xtotpv2'];
            $xarr_data['ms_totsv']=$xarr_totalcom['xtotsv2'];
            $xarr_data['ms_totdp']=$xtotdp2;
            $xarr_data['ms_category'] = ($xcat_ms==",")?"":$xcat_ms;
            $xarr_data['ms_percent']  = $xentitled2;
          }else{
            $xarr_data['ms_totpv']=0;
            $xarr_data['ms_totsv']=0;
            $xarr_data['ms_totdp']=0;
            $xarr_data['ms_category'] = '';
            $xarr_data['ms_percent']  = 0;
          }

					if ($fnext=='1') {
            $xarr_data['bns_country']   =$default_cnt;
            $xarr_data['origin_country']=$default_cnt;
            $xarr_data['btype']         ='27';
            $xarr_data['reason_type']   =null;
            $xarr_data['localtax']      ='0';
					}
          if ($debug) {
            print_r($xarr_data);
            echo "<br/>\n";
          }//end if 

          $xsqlc="select sccode from $xtable_name where sccode='$xsc_row[0]' and fmonth='$xmonth' ";
          $xresc=pg_exec($db, $xsqlc);
          if (pg_num_rows($xresc)>0) {
            $xarr_where['sccode']=$xsc_row[0];
            $xarr_where['fmonth']=$xmonth;
            db_update2($xtable_name, $xarr_data, $xarr_where);
          }else{
            db_insert($xtable_name, $xarr_data);
          }
          
          if ($fnext=='1') {
						$xarr_sccom_log_data = array (
							'sccode' =>$xsc_row[0],
							'fmonth' =>$xmonth, 
							'opnm'   =>$opnm,
							'lupddt' =>'now()',
							'lupdt'	 =>'now()',	
						);
						db_insert('sccom_log', $xarr_sccom_log_data);
          }
          
          if ($fnext=='1') {
						$msg="Generated data successfully !";
          }
/*
        } else {
?>

          <TR bgcolor="#FFFFFF">
            <td><?=$no+1?></td>
            <td><?=stripslashes($xsc_row[1])?></td>
            <td><?=$xsc_row[0]?></td>
            <td align="right"><?=number_format($xtotpv,2)?></td>
            <td align="right"><?=number_format($xtotsv,2)?></td>
            <td align="right"><?=number_format($xtotdp,2)?></td>
            <td><?=$xsc_row[3];?></td>
            <td align="right"><?=number_format($xentitled,2)?></td>

            <td align="right"><?=number_format($xtotpv2,2)?></td>
            <td align="right"><?=number_format($xtotsv2,2)?></td>
            <td align="right"><?=number_format($xtotdp2,2)?></td>
            <td><?=$xsc_row[5];?></td>
            <td align="right"><?=number_format($xentitled2,2)?></td>

            <td align="right"><?=number_format($xtotalcom,2)?></td>
            <td align="right"><?=number_format($xdeduc,2)?></td>
            <td align="right"><?=number_format($xadj,2)?></td>
            <td align="right"><?=$disround?></td>
            <td align="right"><?=$xnetcom?></td>
            <td><?=$xhold?></td>
            <td><?=$xonline?></td>
            <td><?=$xsc_row[4]?></td>
            <td ><input type='button' name='print_' value='<?=mxlang("406","")?>' onclick="valprint('<?=$xsc_row[0]?>','<?=$xTgl1?>','<?=$xTgl2?>','<?=$xtype?>','<?=$fmonth?>','<?=$fyear?>');"></td>
          </TR>
<?
        }
*/
        $no+=1;
      }

  }//end for
  if($debug==0) $bresult=pg_exec($db,"commit transaction");       

}//end if
include("../module/header.inc");
if ($fyear=='')  $fyear =$year1;
if ($fmonth=='') $fmonth=$month1-1;
if ($fmonth==12) $fyear=$year1-1;
?>
<script type="text/javascript" src="../module/prototype_151.js"></script>
<script language="JavaScript">
  function validcek(xnext) {
    var shortcut = document.frm_sccom;
    //if (shortcut.txt_scid.value!='x') {

    if (xnext=='1') {
      var xurl = "../sccom/ajax_checking_sccom.php?scid="+shortcut.txt_scid.value+'&fmonth='+shortcut.fmonth.value+'&fyear='+shortcut.fyear.value;
      new Ajax.Request(xurl, {
        method: 'get',
        onSuccess: function(transport) {
          var xdata = transport.responseText.evalJSON();
          //console.log(xdata);
          //return false;
          if (xdata.xstatus==true) {
            if (confirm('The data for the selected month has been generated, do you want to re-generate?')) {
              shortcut.fnext.value=xnext;
              shortcut.submit();
            }
          }else{
            shortcut.fnext.value=xnext;
            shortcut.submit();
          }
          //document.getElementById('id_deduct_item').innerHTML=xdata.xselect;
        }
      });
    }else{
      shortcut.fnext.value=xnext;
      shortcut.submit();
    }

  }
  
	function valprint(xcode,xtgl1,xtgl2,xtype,xfmonth,xfyear)	{
		var shortcut = document.frm_sccom;
		var win_items;
		var xtype='ALL';
		var dimensi="height=800,width=800,left=20,top=20,resizable=yes,scrollbars=yes";
		
		if(shortcut.rdo_type[1].checked) xtype='SC';
		if(shortcut.rdo_type[2].checked) xtype='MS';
		var xparam ="xcode="+xcode+"&xtgl1="+xtgl1+"&xtgl2="+xtgl2+"&xtype="+xtype+"&fmonth="+xfmonth+"&fyear="+xfyear;
		xparam+="&xmode=temp";
	//	var url="sccom_rep_popup.php?"+xparam;
		var url="sccom_rep_gst_popup.php?"+xparam;
		if (win_items!=null) {
			if (!win_items.closed) {
				win_items.focus();
			}else{
				win_items = window.open(url,"DO",dimensi);
			}
		}else{
			win_items = window.open(url,"DO",dimensi);
		}
	}
	
</script>

<table width="790" border="0" align="center" cellspacing="0" cellpadding="0">
  <tr>
    <td width="50%" valign="middle">
			<b><img src="../images/administration.gif" width="18" height="18" hspace="2" vspace="2" align="absmiddle" > Generate Stockist Commission</b>
		</td>
    <td align="right" class="red"><?=$msg?></td>
  </tr>
</table>
<form method="post" name="frm_sccom">
<table width="790" bgcolor="#cccccc" align="center" border="0" cellspacing="1" cellpadding="2">
<?
/*
  $xscsql ="SELECT a.sccode FROM users_extra a WHERE a.uname='$opnm'  ";
  //if ($debug) echo "$xscsql<br/>\n";
  $xscres =pg_exec($db, $xscsql);
  if (pg_num_rows($xscres)>0)
    $xscrow = pg_fetch_row($xscres, 0);
  if ($xscrow[0]==1) {
*/
?>
  <TR bgcolor="#FFFFFF">
    <TD width="15%" align="left" valign='top'>&nbsp;<?=mxlang("440","")?></TD>
    <TD width="83%" align="left" colspan='2'>
      <?if ($rdo_type=='') $rdo_type='ALL';?>
      <input type='radio' name='rdo_type' value='ALL' <?=($rdo_type=='ALL')?'checked':''?> onclick="validcek('0');"> All<br>
      <input type='radio' name='rdo_type' value='SC' <?=($rdo_type=='SC')?'checked':''?> onclick="validcek('0');"> <?=mxlang("59","")?><br>
      <input type='radio' name='rdo_type' value='MS' <?=($rdo_type=='MS')?'checked':''?> onclick="validcek('0');"> <?=mxlang("944","")?>
    </TD>
  </TR>
  <TR bgcolor="#FFFFFF">
    <TD width="15%" align="left" valign='top'>&nbsp;<?=mxlang("208","")?></TD>
    <TD width="83%" align="left" colspan='2'><?sel_stockist4_sccom('txt_scid',$txt_scid,$rdo_type)?>
    </TD>
  </TR>
<?
/*
  }else{
    flist_scid_input('txt_scid');
  }
*/
?>
  <TR bgcolor="#FFFFFF">
    <TD width="15%" align="left" valign='top'>&nbsp;<?=mxlang("1045","")?></TD>
    <TD width="83%" align="left" colspan='2'>
      <select name='fmonth'>
        <option value='1' <?=($fmonth==1)?'selected':''?>>Jan</option>
        <option value='2' <?=($fmonth==2)?'selected':''?>>Feb</option>
        <option value='3' <?=($fmonth==3)?'selected':''?>>Mar</option>
        <option value='4' <?=($fmonth==4)?'selected':''?>>Apr</option>
        <option value='5' <?=($fmonth==5)?'selected':''?>>May</option>
        <option value='6' <?=($fmonth==6)?'selected':''?>>Jun</option>
        <option value='7' <?=($fmonth==7)?'selected':''?>>Jul</option>
        <option value='8' <?=($fmonth==8)?'selected':''?>>Aug</option>
        <option value='9' <?=($fmonth==9)?'selected':''?>>Sep</option>
        <option value='10' <?=($fmonth==10)?'selected':''?>>Oct</option>
        <option value='11' <?=($fmonth==11)?'selected':''?>>Nov</option>
        <option value='12' <?=($fmonth==12)?'selected':''?>>Dec</option>
      </select>
      <input type='text' size='5' maxlength='4' name='fyear' value='<?=$fyear?>'>
    </TD>
  </TR>
  <TR BGCOLOR="#E6E6E6">
    <td align="left" colspan="3" valign="top">&nbsp;
      <input type="button" name="btn_list" value="List" onclick="validcek('6');">
      <input type="button" name="btn_cancel" value="<?=mxlang("20","")?>" onclick="document.location.href='../member/menu.php'">
      <input type="button" name="btn_submit" value="<?=mxlang("19","")?>" onclick="validcek('1');" <?=($debug)?"":"style=\"display:none\""?>>
      <!--<input type="button" name="btn_gen" value="<?=mxlang("3110","")?>" onclick="validcek('5');">-->
      <input type='hidden' name='fnext'>
    </td>
  </TR>
</table>
</form>
<?
	if ($fnext=='6') {
		$xmonth=str_pad($fmonth, 2, '0', STR_PAD_LEFT).$fyear;
		
		if($rdo_type!="ALL") {
			$xcolspan=21;
		}else{
			$xcolspan=26;
		}
		
?>
<br><br>
<table width="880" bgcolor="#cccccc" align="center" border="0" cellspacing="1" cellpadding="2">
	<? if($rdo_type!='ALL') {?>
	<TR BGCOLOR="#E6E6E6">
    <td align='center'><b><?=mxlang("1426","")?></b></td>
    <td align='center'><b><?=mxlang("438","")?></b></td>
    <td align='center'><b><?=mxlang("122","")?></b></td>
    <td align='center'><b>GST Number</b></td>
    <td align='center'><b><?=mxlang("1549","")?></b></td>
    <td align='center'><b><?=mxlang("1550","")?></b></td>
    <td align='center'><b><?=mxlang("3093","")?></b></td>
    <td align='center'><b><?=mxlang("1094","")?></b></td>
    <td align='center'><b>% <?=mxlang("3094","")?></b></td>
    <td align='center'><b>Total CN</b></td>
    <td align='center'><b><?=mxlang("3095","")?></b></td>
    <td align='center'><b><?=mxlang("3096","")?></b></td>
    <td align='center'><b>GST Deduction</b></td>
    <td align='center'><b>Addition</b></td>
    <td align='center'><b>GST Addition</b></td>
    <td align='center'><b>Rounding</b></td>
    <td align='center'><b><?=mxlang("3097","")?></b></td>
    <td align='center' width="20%"><b><?=mxlang("3098","")?></b></td>
    <td align='center' width="20%"><b><?=mxlang("2913","")?></b></td>
    <td align='center' width="20%"><b><?=mxlang("383","")?></b></td>
    <td align='center' width="20%"><b><?=mxlang("752","")?></b></td>
	</TR>
<? } else { ?>
  <TR BGCOLOR="#E6E6E6">
    <td align='center' rowspan="2"><b><?=mxlang("1426","")?></b></td>
    <td align='center' rowspan="2"><b><?=mxlang("438","")?></b></td>
    <td align='center' rowspan="2"><b><?=mxlang("122","")?></b></td>
    <td align='center' rowspan="2"><b>GST No.</b></td>
    <td align='center' colspan="5"><b><?=mxlang("59","")?></b></td>
    <td align='center' colspan="5"><b><?=mxlang("944","")?></b></td>
    <td align='center' rowspan="2"><b>Total CN</b></td>
    <td align='center' rowspan="2"><b><?=mxlang("3095","")?></b></td>
    <td align='center' rowspan="2"><b>Deduction</b></td>
    <td align='center' rowspan="2"><b>GST Deduction</b></td>
    <td align='center' rowspan="2"><b>Addition</b></td>
    <td align='center' rowspan="2"><b>GST Addition</b></td>
    <td align='center' rowspan="2"><b>Rounding</b></td>
    <td align='center' rowspan="2"><b><?=mxlang("3097","")?></b></td>
    <td align='center' width="20%" rowspan="2"><b><?=mxlang("3098","")?></b></td>
    <td align='center' width="20%" rowspan="2"><b><?=mxlang("2913","")?></b></td>
    <td align='center' width="20%" rowspan="2"><b><?=mxlang("383","")?></b></td>
    <td align='center' width="20%" rowspan="2"><b><?=mxlang("752","")?></b></td>
  </TR>
  <TR BGCOLOR="#E6E6E6">
    <td align='center'><b><?=mxlang("1549","")?></b></td>
    <td align='center'><b><?=mxlang("1550","")?></b></td>
    <td align='center'><b><?=mxlang("3093","")?></b></td>
    <td align='center'><b><?=mxlang("1094","")?></b></td>
    <td align='center'><b>% <?=mxlang("3094","")?></b></td>

    <td align='center'><b><?=mxlang("1549","")?></b></td>
    <td align='center'><b><?=mxlang("1550","")?></b></td>
    <td align='center'><b><?=mxlang("3093","")?></b></td>
    <td align='center'><b><?=mxlang("1094","")?></b></td>
    <td align='center'><b>% <?=mxlang("3094","")?></b></td>
  </TR>
<?	
		}

  $xsc_sql=
    "select ".
    "a.code, c.name,b.stockist,b.fcat_sccom,s.st_name,".
    "b.fcat_sccom_ms,b.tax_id, x.* ".
    "from sub_mssc a
    inner join sub_mssc_extra b on a.code=b.scname
    inner join msmemb c on a.code=c.code
    inner join state s on a.st_id=s.st_id 
    inner join sccom_temp x on x.sccode=a.code and x.fmonth='$xmonth'
    ";

		if ($rdo_type=='MS') $xsc_sql.="and  b.stockist='0' ";
		if ($txt_scid!='x') $xsc_sql.="and  a.code='$txt_scid' ";
		$xsc_sql.="order by a.code ";

    if ($debug) echo "$xsc_sql<br/>\n";
		$xsc_res=pg_exec($db, $xsc_sql);
		
		if (pg_num_rows($xsc_res)>0) {
		
			$no=0;
			for ($i=0; $i<pg_num_rows($xsc_res); $i++) {
				//$xsc_row=pg_fetch_row($xsc_res, $i);
				$xsc_row=pg_fetch_assoc($xsc_res, $i);
				if ($debug) {
					print_r($xsc_row);
					echo "<br/>\n";
				}

				if ($xsc_row['stockist']=='0') $xtype="MS";
				if ($xsc_row['stockist']=='1') $xtype="SC";
				
				$xtotpv  =0;
				$xtotsv  =0;
				$xtotdp  =0;
				$xtotpv2 =0;
				$xtotsv2 =0;
				$xtotdp2 =0;

				if($rdo_type=="SC" || $rdo_type=="ALL" || $rdo_type=="MS"){
					$ppv=$xsc_row['totpv'];
					$psv=$xsc_row['totsv'];
					$pdp=$xsc_row['totdp'];

					$xtotpv =$xsc_row['totpv'];
					$xtotsv =$xsc_row['totsv'];
					$xtotdp =$xsc_row['totdp'];
					//$xtotpay=$xrow2[3];
					if ($rdo_type=='MS')
						$xentitled=$xsc_row['ms_percent'];
					else
						$xentitled=$xsc_row['stk_percent'];
					
					$diskon =number_format($xentitled,2);
					if ($rdo_type=='SC' || $rdo_type=="ALL") {
						$xcat   =$xsc_row['fcat_sccom'];
					}elseif ($rdo_type=='MS') {
						$xcat   =$xsc_row['fcat_sccom_ms'];
					}
					$disround= number_format($xsc_row['rounding'],2);
					$xhold   = $xsc_row['hold'];
					$xonline = $xsc_row['online'];

					$xnetcom = number_format($xsc_row['netcomm'],2);
					$xtot_cn = number_format($xsc_row['totcn'],2);
				}

				if(($rdo_type=="MS" || $rdo_type=="ALL") && $xsc_row['stockist']=='0'){
					$xtotpv2 =$xsc_row['ms_totpv'];
					$xtotsv2 =$xsc_row['ms_totsv'];
					$xtotdp2 =$xsc_row['ms_totdp'];
				}

				$xtotalcom      =$xsc_row['totcomm'];
				$xtot_gst_deduct=$xsc_row['gst_deduction'];
				$xtot_gst_addit =$xsc_row['gst_addition'];
				$xrounding      =$xsc_row['rounding'];  

				$xdeduc         =$xsc_row['deduction'];
				$xadj           =$xsc_row['addition'];
				$intnetcom      =$xsc_row['netcomm'];

				$xgrandpv+=$xtotpv;
				$xgrandpv2+=$xtotpv2;
				$xgrandsv+=$xtotsv;
				$xgrandsv2+=$xtotsv2;
				$xgranddp+=$xtotdp;
				$xgranddp2+=$xtotdp2;
				$xgrandcom+=round($xtotalcom,2);
				$xgranddeduc+=$xdeduc;
				$xgrandadj+=$xadj;
				$xgrandround+=$xrounding;
				$xgrandnet+=round($intnetcom,2);

				$xgrand_cn += $xsc_row['totcn'];

				$xgrand_gst_deduc+=$xtot_gst_deduct;
				$xgrand_gst_addit+=$xtot_gst_addit;

// 				$xsc_row['rounding']=-0.01;

				if($xtotdp==0 && $xtotdp2==0){ 
				}else {
				
					if (trim($xsc_row['rounding'])=='')
						$xsc_row['rounding']=0;
					if($rdo_type!="ALL") {
			?>
				<TR bgcolor="#FFFFFF">
					<td><?=$no+1?></td>
					<td><?=stripslashes($xsc_row['name'])?></td>
					<td><?=$xsc_row['code']?></td>
					<td><?=$xsc_row['sc_gstno']?></td>
					<td align="right"><?=number_format($xtotpv,2)?></td>
					<td align="right"><?=number_format($xtotsv,2)?></td>
					<td align="right"><?=number_format($xtotdp,2)?></td>
					<td><?=($xcat==",")?"":$xcat;?></td>
					<td align="right"><?=$diskon?></td>
					<td align="right"><?=number_format($xtot_cn,2)?></td>
					<td align="right"><?=number_format($xtotalcom,2)?></td>
					<td align="right"><?=number_format($xdeduc,2)?></td>
					<td align="right"><?=number_format($xtot_gst_deduct,2)?></td>
					<td align="right"><?=number_format($xadj,2)?></td>
					<td align="right"><?=number_format($xtot_gst_addit,2)?></td>
					<td align="right"><?=number_format($xsc_row['rounding'],2);?></td>
					<td align="right"><?=$xnetcom;?></td>
					<td align="right"><?=($xsc_row['hold']=='t')?'TRUE':'FALSE'?></td>
					<td align="right"><?=($xsc_row['fonline']=='t')?'TRUE':'FALSE'?></td>
					<td align="right"><?=$xsc_row['st_name']?></td>
					<!--td>
						<input type='button' name='print_' value='Generate PDF<?/*mxlang("406","")*/?>' onclick="valprint('<?=$xsc_row['code']?>','<?=$xTgl1?>','<?=$xTgl2?>','<?=$xtype?>','<?=$fmonth?>','<?=$fyear?>');">
					</td-->
					<td >
            <input type='button' name='print_' value='<?=mxlang("406","")?>' onclick="valprint('<?=$xsc_row['code']?>','<?=$xTgl1?>','<?=$xTgl2?>','<?=$xtype?>','<?=$fmonth?>','<?=$fyear?>');">
					</td>
				</TR>

			<? 	} else { ?>

				<TR bgcolor="#FFFFFF">
					<td><?=$no+1?></td>
					<td><?=stripslashes($xsc_row['name'])?></td>
					<td><?=$xsc_row['code']?></td>
					<td><?=$xsc_row['sc_gstno']?></td>
					<td align="right"><?=number_format($xtotpv,2)?></td>
					<td align="right"><?=number_format($xtotsv,2)?></td>
					<td align="right"><?=number_format($xtotdp,2)?></td>
					<td><?=$xsc_row['fcat_sccom'];?></td>
					<td align="right"><?=$xsc_row['stk_percent']?></td>
					<td align="right"><?=number_format($xtotpv2,2)?></td>
					<td align="right"><?=number_format($xtotsv2,2)?></td>
					<td align="right"><?=number_format($xtotdp2,2)?></td>
					<td align="right"><?=$xsc_row['ms_category']?></td>
					<td align="right"><?=$xsc_row['ms_percent']?></td>
					<td align="right"><?=number_format($xsc_row['totcn'],2)?></td>
					<td align="right"><?=number_format($xsc_row['totcomm'],2)?></td>
					<td align="right"><?=number_format($xdeduc,2)?></td>
					<td align="right"><?=number_format($xsc_row['gst_deduction'],2)?></td>
					<td align="right"><?=number_format($xsc_row['addition'],2)?></td>
					<td align="right"><?=number_format($xsc_row['gst_addition'],2)?></td>
					<td align="right"><?=number_format($xsc_row['rounding'],2);?></td>
					<td align="right"><?=number_format($xsc_row['netcomm'],2)?></td>
					<td align="right"><?=($xsc_row['hold']=='t')?'TRUE':'FALSE'?></td>
					<td align="right"><?=($xsc_row['fonline']=='t')?'TRUE':'FALSE'?></td>
					<td><?=$xsc_row['st_name']?></td>
					<!--td >
						<input type='button' name='print_' value='Generate PDF<?/*mxlang("406","")*/?>' onclick="valprint('<?=$xsc_row['code']?>','<?=$xTgl1?>','<?=$xTgl2?>','<?=$xtype?>','<?=$fmonth?>','<?=$fyear?>');">
					</td-->
					<td >
            <input type='button' name='print_' value='<?=mxlang("406","")?>' onclick="valprint('<?=$xsc_row['code']?>','<?=$xTgl1?>','<?=$xTgl2?>','<?=$xtype?>','<?=$fmonth?>','<?=$fyear?>');">
					</td>
				</TR>
			<?
					}
					$no+=1;
				}
				//if ($opnm=='hima') echo $xgrandnet."===".$intnetcom."<br>";
			}//end for
		}else{
?>
			<tr>
				<td colspan="<?=$xcolspan?>" align="center" bgcolor="#FFFFFF"><?=mxlang('1661')?></td>
			</tr>
<?
		
		}//end if

// $prin_dec=($rdo_type!="ALL")?number_format($xgranddeduc,2):number_format($xgranddeduc1,2).",".number_format($xgranddeduc2,2);
// $prin_adj=($rdo_type!="ALL")?number_format($xgrandadj,2):number_format($xgrandadj1,2).",".number_format($xgrandadj2,2);
	if (pg_num_rows($xsc_res)>0) {
		if($rdo_type!="ALL") {
?>
	<TR bgcolor="#FFFFFF">
		<td colspan='3'>&nbsp;</td>
		<td><b>Total</b></td>
		<td align='right'><b><?=number_format($xgrandpv,2)?></b></td>
		<td align='right'><b><?=number_format($xgrandsv,2)?></b></td>
		<td align='right'><b><?=number_format($xgranddp,2)?></b></td>
		<td colspan='2'>&nbsp;</td>
    <td align='right'><b><?=number_format($xgrand_cn,2)?></b></td>
		<td align='right'><b><?=number_format($xgrandcom,2)?></b></td>
		<td align='right'><b><?=number_format($xgranddeduc,2)?></b></td>
    <td align='right'><b><?=number_format($xgrand_gst_deduc,2)?></b></td>
		<td align='right'><b><?=number_format($xgrandadj,2)?></b></td>
    <td align='right'><b><?=number_format($xgrand_gst_addit,2)?></b></td>
		<td align="right"><?=number_format($xgrandround,2);?></td>
		<td align='right'><b><?=number_format($xgrandnet,2)?></b></td>
		<td colspan='4'>&nbsp;
		</td>
	</TR>
<? } else { ?>
		<TR bgcolor="#FFFFFF">
		<td colspan='3'>&nbsp;</td>
		<td><b>Total</b></td>
		<td align='right'><b><?=number_format($xgrandpv,2)?></b></td>
		<td align='right'><b><?=number_format($xgrandsv,2)?></b></td>
		<td align='right'><b><?=number_format($xgranddp,2)?></b></td>
		<td colspan='2'>&nbsp;</td>
		<td align='right'><b><?=number_format($xgrandpv2,2)?></b></td>
		<td align='right'><b><?=number_format($xgrandsv2,2)?></b></td>
		<td align='right'><b><?=number_format($xgranddp2,2)?></b></td>
		<td colspan='2'>&nbsp;</td>
    <td align='right'><b><?=number_format($xgrand_cn,2)?></b></td>
		<td align='right'><b><?=number_format($xgrandcom,2)?></b></td>
		<td align='right'><b><?=number_format($xgranddeduc,2)?></b></td>
    <td align='right'><b><?=number_format($xgrand_gst_deduc,2)?></b></td>
		<td align='right'><b><?=number_format($xgrandadj,2)?></b></td>
    <td align='right'><b><?=number_format($xgrand_gst_addit,2)?></b></td>
		<td align="right"><?=number_format($xgrandround,2);?></td>
		<td align='right'><b><?=number_format($xgrandnet,2)?></b></td>
		<td colspan='4' align='center'>&nbsp;
		</td>
	</TR>
<? 
		}
	}	
?>

	<TR BGCOLOR="#E6E6E6">
		<td colspan="<?=$xcolspan?>">
			<?
			if (pg_num_rows($xsc_res)>0) {
			?>
      <input type="button" name="btn_submit" value="<?=mxlang("19","")?>" onclick="validcek('1');">
      <?
      }else{
				echo "&nbsp;";
      }
      ?>
		</td>
	</TR>
	<!--TR bgcolor="#FFFFFF">
		<td colspan='<?=($rdo_type=="ALL")?"26":"21";?>' align='right'>
      <input type='button' name='print' value='<?=mxlang("110","")?>' onclick="valprintPage('<?=$txt_scid?>','<?=$xTgl1?>','<?=$xTgl2?>','<?=$xtype?>','<?=$fmonth?>','<?=$fyear?>');">&nbsp;<input type='button' name='export' value='<?=mxlang("2902","")?>' onclick="validcek('4');">
		</td>
	</TR-->
</table>

<?
		pg_free_result($xsc_res);

	}//end if fnext==6
?>
<?php
if ($debug) {
  include("../module/postdebug.inc");
}
include("../module/footer.inc");
?>