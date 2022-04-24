<?php
    if(!function_exists("validar_sesion")){
        function validar_sesion($id_usuario){
            if($id_usuario == ""){
                redirect("login","refresh");
            }
        }
    }
    if(!function_exists("quitar_tildes")){
        function quitar_tildes($cadena)
        {
            $no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹"," ");
            $permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E","_");
            $texto = str_replace($no_permitidas, $permitidas ,$cadena);
            return $texto;
        }
    }
    if(!function_exists("get_name_script")){
        function get_name_script($url){
            //metodo para obtener el nombre del file:
            $nombre_archivo = $url;
            //verificamos si en la ruta nos han indicado el directorio en el que se encuentra
            if ( strpos($url, '/') !== FALSE ){
                //de ser asi, lo eliminamos, y solamente nos quedamos con el nombre y su extension
                $nombre_archivo_tmp = explode('/', $url);
                $nombre_archivo= array_pop($nombre_archivo_tmp );
                return  $nombre_archivo;
            }  
        }
    }
    

    function ED($fecha){
        $dia = substr($fecha,8,2);
        $mes = substr($fecha,5,2);
        $a = substr($fecha,0,4);
        $fecha = "$dia-$mes-$a";
        return $fecha;
    }
    function MD($fecha){
        $dia = substr($fecha,0,2);
        $mes = substr($fecha,3,2);
        $a = substr($fecha,6,4);
        $fecha = "$a-$mes-$dia";
        return $fecha;
    }

    function restar_meses($fecha, $nmeses)
    {
        $nuevafecha = strtotime ( '-'.$nmeses.' month' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
        return $nuevafecha;
    }
    function sumar_meses($fecha, $nmeses)
    {
        $nuevafecha = strtotime ( '+'.$nmeses.' month' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
        return $nuevafecha;
    }
    function meses($n)
    {
        $mes = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
        return $mes[$n-1];
    }
    function _hora_media_encode($hora){
        $var1=preg_match('/((1[0-2]|0?[1-9]):([0-5][0-9]) ?([AaPp][Mm]))/', $hora);
        if($var1){
            $hora_final = strftime('%H:%M:%S', strtotime($hora));
              return $hora_final;
        }
        else{
            return "00:00:00";
        }

    }
    function _hora_media_decode($hora){
        $hora_n = explode(":", $hora);
        $sentido="";   
        if($hora_n[0] < 12){
            $sentido = "AM";
        }
        if($hora_n[0] > 12){
            $hora_n[0]= $hora_n[0]-12;
            $sentido ="PM";
        }
        if($hora_n[0] == 12){
            $sentido = "PM";
        }
        if($hora_n[0] == "00"){
            $hora_n[0] = 12;
        }
        $hora_final = $hora_n[0].":".$hora_n[1]." $sentido";
        return $hora_final;
    }

    
    function linewriteb($array, $pdf)
    {
      $ygg=0;
      $maxlines=1;
      $array_a_retornar=array();
      $array_max= array();
      foreach ($array as $key => $value) {
        // /Descripcion/
        $nombr=$value[0];
        // /fpdf width/
        $size=$value[1];
        // /fpdf alignt/
        $aling=$value[2];
        $jk=0;
        $w = $size;
        $h  = 0;
        $txt=$nombr;
        $border=0;
        if(!isset($pdf->CurrentFont))
          $pdf->Error('No font has been set');
        $cw = &$pdf->CurrentFont['cw'];
        if($w==0)
          $w = $pdf->w-$pdf->rMargin-$pdf->x;
        $wmax = ($w-2*$pdf->cMargin)*1000/$pdf->FontSize;
        $s = str_replace("\r",'',$txt);
        $nb = strlen($s);
        if($nb>0 && $s[$nb-1]=="\n")
          $nb--;
        $b = 1;

        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $ns = 0;
        $nl = 1;
        while($i<$nb)
        {
          // Get next character
          $c = $s[$i];
          if($c=="\n")
          {
            $array_a_retornar[$ygg]["valor"][]=substr($s,$j,$i-$j);
            $array_a_retornar[$ygg]["size"][]=$size;
            $array_a_retornar[$ygg]["aling"][]=$aling;
            $jk++;

            $i++;
            $sep = -1;
            $j = $i;
            $l = 0;
            $ns = 0;
            $nl++;
            $b2=0;
            if($border && $nl==2){
                $b = $b2;
            }
              
            continue;
          }
          if($c==' ')
          {
            $sep = $i;
            $ls = $l;
            $ns++;
          }
          $l += $cw[$c];
          if($l>$wmax)
          {
            // Automatic line break
            if($sep==-1)
            {
              if($i==$j)
                $i++;
              $array_a_retornar[$ygg]["valor"][]=substr($s,$j,$i-$j);
              $array_a_retornar[$ygg]["size"][]=$size;
              $array_a_retornar[$ygg]["aling"][]=$aling;
              $jk++;
            }
            else
            {
              $array_a_retornar[$ygg]["valor"][]=substr($s,$j,$sep-$j);
              $array_a_retornar[$ygg]["size"][]=$size;
              $array_a_retornar[$ygg]["aling"][]=$aling;
              $jk++;

              $i = $sep+1;
            }
            $sep = -1;
            $j = $i;
            $l = 0;
            $ns = 0;
            $nl++;
            if($border && $nl==2)
              $b = $b2;
          }
          else
            $i++;
        }
        // Last chunk
        if($pdf->ws>0)
        {
          $pdf->ws = 0;
        }
        if($border && strpos($border,'B')!==false)
          $b .= 'B';
        $array_a_retornar[$ygg]["valor"][]=substr($s,$j,$i-$j);
        $array_a_retornar[$ygg]["size"][]=$size;
        $array_a_retornar[$ygg]["aling"][]=$aling;
        $jk++;
        $ygg++;
        if ($jk>$maxlines) {
          // code...
          $maxlines=$jk;
        }
      }

      $ygg=0;
      foreach($array_a_retornar as $keys)
      {
        for ($i=count($keys["valor"]); $i <$maxlines ; $i++) {
          // code...
          $array_a_retornar[$ygg]["valor"][]="";
          $array_a_retornar[$ygg]["size"][]=$array_a_retornar[$ygg]["size"][0];
          $array_a_retornar[$ygg]["aling"][]=$array_a_retornar[$ygg]["aling"][0];
        }
        $ygg++;
      }
      $data=$array_a_retornar;
      $total_lineas=count($data[0]["valor"]);
      $total_columnas=count($data);


      $he = 4*$total_lineas;
      for ($i=0; $i < $total_lineas; $i++) {
        // code...
        $y = $pdf->GetY();
        if($y + $he > 274){
            $pdf-> AddPage();
        }
        for ($j=0; $j < $total_columnas; $j++) {
          // code...
          $salto=0;
          $abajo="LR";
          if ($i==0) {
            // code...
            $abajo="TLR";
          }
          if ($j==$total_columnas-1) {
            // code...
            $salto=1;
          }
          if ($i==$total_lineas-1) {
            // code...
            $abajo="BLR";
          }
          if ($i==$total_lineas-1&&$i==0) {
            // code...
            $abajo="1";
          }
          // if ($j==0) {
          //   // code...
          //   $abajo="0";
          // }
          $str = $data[$j]["valor"][$i];
          if ($str=="\b")
          {
            $abajo="0";
            $str="";
          }
          $pdf->Cell($data[$j]["size"][$i],4,$str,$abajo,$salto,$data[$j]["aling"][$i],1);
        }

        $pdf->setX(10);
      }
      /*
      $arreglo_valores = array();
      $hei = 4 * $total_lineas;
        for($i = 0; $i < $total_columnas ; $i++){
            $valor_p="";
            $size_p = 0;
            for($j = 0; $j < $total_lineas; $j++){
                $valor_p.=" ".$data[$i]["valor"][$j];
                $size_p=$data[$i]["size"][$j];
            }
            $arreglo_valores[] = array(
                'valor' => $valor_p,
                'size' => $size_p
            );
        }
        $count = 0;
        $y = $pdf->GetY();
        if($y + $hei > 274){
            $pdf-> AddPage();
        }
        foreach ($arreglo_valores as $key => $value) {
            if($count == 0){
                $pdf->drawTextBox($value['valor'], $value['size'], $hei, "C", 'M',1,1);
            }
            else{

                $pdf->drawTextBox($value['valor'], $value['size'], $hei, "C", 'M',1,0);
            }
            $count++;
        }

        $pdf->Ln($hei);
        */
    }



    function footer_pagina($pdf,$nombre_direccion,$direccion)
    {
        
        $actual_font = $pdf->CurrentFont;
        // Posición: a 1,5 cm del final
        $pdf->SetY(190);
        // Arial italic 8
        $pdf->SetFont('Arial','I',8);        // Número de página
        $pdf->Cell(0,10,'Pagina '.$pdf->PageNo().'/{nb}',0,1,'C');

        $pdf->SetY(185);
        // Arial italic 8
        $pdf->SetFont('Arial','I',8);
        // Número de página
        $pdf->Cell(0,10,utf8_decode($nombre_direccion),0,1,'C');

        $pdf->SetY(180);
        // Arial italic 8
        $pdf->SetFont('Arial','I',8);
        // Número de página
        $pdf->Cell(0,10,utf8_decode($direccion),0,1,'C');
        $_SESSION['nombre_direccion_footer'] = $nombre_direccion;
        $_SESSION['direccion_footer'] = $direccion;
        $pdf->CurrentFont = $actual_font;

    }

    function header_pagina($pdf,$logo,$nombre_empresa,$nrc,$telefono,$nit,$titulo_reporte,$tamanio_titulo_reporte)
    {
        //$pdf->Image("img/fondo_reporte.png",0,0,220,280);
        if ($pdf->PageNo() == 1){
            $set_x = $pdf->getX();
            $set_y = 2;
            $pdf->SetLineWidth(.5);
            $pdf->SetFillColor(255,255,255);
            $pdf->setX(5);
            $pdf->Image(base_url("")."/assets/".$logo,12,5,20,20);
            $pdf->Image(base_url("")."/assets/".$logo,245,5,20,20);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFont('Courier', 'B', 19);
            $pdf->SetTextColor(25, 65, 96);
            //$pdf->Cell(160,7,utf8_decode($pdf->infoext['nombre_empresa']),0,1,'L');
            $set_y +=5;
            $pdf->setY($set_y);
            $pdf->setX(16);
            $pdf->SetFont('Courier', 'B', 26);
            $pdf->Cell(0,7,utf8_decode($nombre_empresa),0,1,'C');
            $pdf->setY($pdf->getY());
            $pdf->SetFont('Courier', 'B', 12);
            $pdf->Cell(0,7,utf8_decode("NRC: ".$nrc."     TELEFONO: ".$telefono),0,1,'C');  
            
            $pdf->setY($pdf->getY()-1); 
            $pdf->Cell(0,7,utf8_decode("NIT: ".$nit),0,1,'C');  
            $pdf->SetDrawColor(25,65,96);
            $pdf->Line(0,28,280,28);            
            $pdf->SetFont('Courier', 'B', $tamanio_titulo_reporte);
            $pdf->setY($pdf->getY()+2);
            $pdf->Cell(0,7,utf8_decode($titulo_reporte),0,1,'C');  
        }
    }

    /* ESTA FUNCION SIRVE PARA INSERTAR ESPACIOS EN BLANCO */
    function espacios_blanco($cantidad){
        $cadena_retornar = "";
        if($cantidad > 0){
            for ($i=0; $i <$cantidad ; $i++) { 
                $cadena_retornar.=" ";
            }
            return $cadena_retornar;
        }
        else{
            return '';
        }
    }
    /* FUNCION PARA CALCULAR EL TOTAL EN TEXTO */
    function num2letras($num, $fem = true, $dec = true) {
        $matuni[0]  = "cero";
       $matuni[2]  = "dos";
       $matuni[3]  = "tres";
       $matuni[4]  = "cuatro";
       $matuni[5]  = "cinco";
       $matuni[6]  = "seis";
       $matuni[7]  = "siete";
       $matuni[8]  = "ocho";
       $matuni[9]  = "nueve";
       $matuni[10] = "diez";
       $matuni[11] = "once";
       $matuni[12] = "doce";
       $matuni[13] = "trece";
       $matuni[14] = "catorce";
       $matuni[15] = "quince";
       $matuni[16] = "dieciseis";
       $matuni[17] = "diecisiete";
       $matuni[18] = "dieciocho";
       $matuni[19] = "diecinueve";
       $matuni[20] = "veinte";
       $matunisub[2] = "dos";
       $matunisub[3] = "tres";
       $matunisub[4] = "cuatro";
       $matunisub[5] = "quin";
       $matunisub[6] = "seis";
       $matunisub[7] = "sete";
       $matunisub[8] = "ocho";
       $matunisub[9] = "nove";
    
       $matdec[2] = "veint";
       $matdec[3] = "treinta";
       $matdec[4] = "cuarenta";
       $matdec[5] = "cincuenta";
       $matdec[6] = "sesenta";
       $matdec[7] = "setenta";
       $matdec[8] = "ochenta";
       $matdec[9] = "noventa";
       $matsub[3]  = 'mill';
       $matsub[5]  = 'bill';
       $matsub[7]  = 'mill';
       $matsub[9]  = 'trill';
       $matsub[11] = 'mill';
       $matsub[13] = 'bill';
       $matsub[15] = 'mill';
       $matmil[4]  = 'millones';
       $matmil[6]  = 'billones';
       $matmil[7]  = 'de billones';
       $matmil[8]  = 'millones de billones';
       $matmil[10] = 'trillones';
       $matmil[11] = 'de trillones';
       $matmil[12] = 'millones de trillones';
       $matmil[13] = 'de trillones';
       $matmil[14] = 'billones de trillones';
       $matmil[15] = 'de billones de trillones';
       $matmil[16] = 'millones de billones de trillones';
    
       $num = str_split($num);
       if ($num[0] == '-') {
          $neg = 'menos ';
          $num = substr($num, 1);
       }else
          $neg = '';
      while ($num[0] == '0') $num[0] = substr($num[0], 1);
    
       if ($num[0] < '1' or $num[0] > 9) $num[0] = '0' . $num[0];
       $zeros = true;
       $punt = false;
       $ent = '';
       $fra = '';
       for ($c = 0; $c < count($num); $c++) {
          $n = $num[$c];
          if (! (strpos(".,'''", $n) === false)) {
             if ($punt) break;
             else{
                $punt = true;
                continue;
             }
    
          }elseif (! (strpos('0123456789', $n) === false)) {
             if ($punt) {
                if ($n != '0') $zeros = false;
                $fra .= $n;
             }else
    
                $ent .= $n;
          }else
    
             break;
    
       }
       $ent = '     ' . $ent;
       if ($dec and $fra and ! $zeros) {
          $fin = ' coma';
          for ($n = 0; $n < strlen($fra); $n++) {
             if (($s = $fra[$n]) == '0')
                $fin .= ' cero';
             elseif ($s == '1')
                $fin .= $fem ? ' un' : ' un';
             else
                $fin .= ' ' . $matuni[$s];
          }
       }else
          $fin = '';
       if ((int)$ent === 0) return 'cero ' . $fin;
       $tex = '';
       $sub = 0;
       $mils = 0;
    
       $neutro = false;
       while ( ($num = substr($ent, -3)) != '   ') {
          $ent = substr($ent, 0, -3);
          if (++$sub < 3 and $fem) {
             $matuni[1] = 'uno';
             $subcent = 'os';
          }else{
             $matuni[1] = $neutro ? 'un' : 'uno';
             $subcent = 'os';
          }
          $t = '';
          $n2 = substr($num, 1);
          if ($n2 == '00') {
          }elseif ($n2 < 21)
             $t = ' ' . $matuni[(int)$n2];
          elseif ($n2 < 30) {
             $n3 = $num[2];
             if ($n3 != 0) $t = 'i' . $matuni[$n3];
             $n2 = $num[1];
             $t = ' ' . $matdec[$n2] . $t;
          }else{
             $n3 = $num[2];
             if ($n3 != 0) $t = ' y ' . $matuni[$n3];
             $n2 = $num[1];
             $t = ' ' . $matdec[$n2] . $t;
          }
          $n = $num[0];
          if ($n == 1) {
             $t = ' ciento' . $t;
          }elseif ($n == 5){
             $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t;
          }elseif ($n != 0 && $n != " "){
                $var_nueva = $n;
                $var_nueva = intval($var_nueva);
             $t =" " . $matunisub[$var_nueva] . 'cient' . $subcent . $t;
          }
          if ($sub == 1) {
          }elseif (! isset($matsub[$sub])) {
             if ($num == 1) {
                $t = ' mil';
             }elseif ($num > 1){
                $t .= ' mil';
             }
          }elseif ($num == 1) {
             $t .= ' ' . $matsub[$sub] . 'on';
          }elseif ($num > 1){
             $t .= ' ' . $matsub[$sub] . 'ones';
          }
          if ($num == '000') $mils ++;
          elseif ($mils != 0) {
             if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub];
             $mils = 0;
          }
          $neutro = true;
          $tex = $t . $tex;
       }
       $tex = $neg . substr($tex, 1) . $fin;
       return ($tex);
    }
    /* ESTA FUNCION SIRVE PARA SEPARAR PARTES POR LINEAS */
    function lineas($cantidad){
        $cadena_retornar = "";
        if($cantidad > 0){         
            for ($i=0; $i <$cantidad ; $i++) { 
                $cadena_retornar.="_";
            }
            return $cadena_retornar;
        }
        else{
            return '';
        }
    }
?>