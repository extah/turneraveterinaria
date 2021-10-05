<?php
namespace App\Libraries;
use App\Libraries\fpdf;

class invoice_listador extends FPDF {
	public $xpagina;

	function Head($titulo, $config) {	
		$path = app_path().'/Libraries/';
		//$this->Image($path.'33709967709.png', 10, 5);
		
		$this->SetY(10);
		$this->SetX($this->GetPageWidth()-25);
		$this->SetFontSize(12);
		$this->SetFont('Arial','',10, false);
		$hoy = getdate();
		$this->Cell($this->GetPageWidth()-20, 5, substr('0'.$hoy["mday"], -2).'/'.substr('0'.$hoy["mon"], -2).'/'.$hoy["year"],  0, 0, 'L');
		$this->SetY(5);
		$this->Cell(0, 10, 'Municipalidad de Berisso', 0, 0, 'L');
		$this->SetY(15);
		$this->SetX(5);
		$this->SetFontSize(12);
		$this->SetFont('Arial','',10, true);
		$this->MultiCell($this->GetPageWidth()-20, 5, $titulo,  0, 'C');
 		
 		$this->SetY($this->GetY());
 		$this->SetX(5);
 		$this->SetFontSize(8);
 		$this->Line(5, $this->GetY(), $this->GetPageWidth()-5, $this->GetY());
 		for ($i=0; $i<count($config); ++$i) {
 			if ($config[$i]['visible']=="S") { 
 				$this->Cell($config[$i]['wide'], 4, $config[$i]['titulo'], 0, 0, $config[$i]['alingtitu']);
 			}	
		}
		$this->Line(5, $this->GetY()+4, $this->GetPageWidth()-5, $this->GetY()+4);
		
	}	

	function Footer() {
		$this->Line(5, $this->GetPageHeight()-12, $this->GetPageWidth()-5, $this->GetPageHeight()-12);
		$this->SetY(-14);
		$this->xpagina +=1;
		
		$this->Cell(0, 10, 'Hoja '.$this->xpagina, 0, 0, 'R');
		//$this->Cell(0, 10, '56 Nro. 471 La Plata - Tel/Fax: 0221-489-4397 - 421-1516', 0, 0, 'C');

		$this->SetY(-10);
		//$this->Cell(0, 10, 'administracion@greenambiental.com.ar - contabilidad@greenambiental.com.ar - www.greenambiental.com.ar', 0, 0, 'C');
	}

	function listador($titulo, $config, $data, $campocorte, $titulocorte, $campototal, $orientacion = "P" )	{
		//Cabecera
		$this->Head($titulo, $config);
		$this->SetY($this->GetY()+5);
		$corte="";
		$total=0;
		$totalgral=0;
		$this->xpagina = 0;
		if ($campocorte !='') {
			$corte=$data[0]->$campocorte;
			$this->SetX(5);
			$this->SetFont('Arial','',8, true);
			$this->Cell(100, 5, $titulocorte.': '.$corte, 0, 0, 'L' , false);	
			$this->SetFont('Arial','',8, false);
			$this->ln(5);
		}
		
		for($i=0; $i<count($data); $i++) {
            $this->salto($titulo, $config, $orientacion);
            $this->SetFont('Arial','',8, false);
            $this->SetX(5);

            if ($campocorte !='') {
	    		if ($data[$i]->$campocorte !=$corte) {
	    			$this->SetFont('Arial','',8, true);
	    			if ($campototal !='') {
	    				$this->Cell($this->GetPageWidth()-5, 5, 'TOTAL DEL '.$titulocorte.': '.$corte.': '.number_format($total, 2, ',', '.'), 0, 0, 'L' , false);	
	    				$totalgral +=$total;
	    			}
	    			
	    			$this->Line(5,$this->GetY()+5, $this->GetPageWidth()-5, $this->GetY()+5);
	    			$this->ln();
	    			$this->salto($titulo, $config, $orientacion);	    			
	    			$total=0;
	    			$cuenta=0;
	    			$corte=$data[$i]->$campocorte;
					$this->SetX(5);
					$this->Cell(100, 5, $titulocorte.': '.$corte, 0, 0, 'L' , false);	
					$this->ln(5);
					$this->SetFont('Arial','',8, false);
	    		}	    		
	    	}
	    	if ($campototal !='') {
	    		$total +=$data[$i]->$campototal; 
	    	}
    		$j=0;
    		$posY=$this->GetY();
            $posFin=$posY;
            $posX=5;
            foreach($data[$i] as $campo=>$valor) { 
            	if ($j<count($config) && $config[$j]['visible']=="S") { 
            		$this->SetY($posY);
            		$this->SetX($posX);
            		$posX +=$config[$j]['wide'];

            		if($config[$j]['tipo'] == "D"){
            			if ($valor < 0){
            				$this->SetTextColor(255,0,0);
            			}
            			$valor = number_format($valor, 2, ',', '');
            		}

            		if ($this->GetStringWidth($valor)>$config[$j]['wide']) { 
	            		$this->MultiCell($config[$j]['wide'], 5, $valor, 0, $config[$j]['aling'], false);
	            		if ($posFin<$this->GetY()) {
	            			$posFin=$this->GetY(); 
	            		}
	            		
		            } 
	            	else{ 
						$this->Cell($config[$j]['wide'], 5, $valor, 0, 0, $config[$j]['aling'], false);					
					}
					$this->SetTextColor(0,0,0);
				}
				$j +=1;
			}
			if ($posFin==$posY) {
				$this->Ln(4);

			} else {
					$this->SetY($posFin);
			}
			
        }		
        if ($campocorte !='' && $campototal !='') {
        	$this->SetX(5);
        	$this->SetFont('Arial','',8, true);
	    	$this->Cell(100, 5, 'TOTAL DEL '.$titulocorte.': '.$corte.': '.number_format($total, 2, ',', '.'), 0, 0, 'L' , false);
	    	$this->Line(5,$this->GetY()+5, $this->GetPageWidth()-5, $this->GetY()+5);	
	    }

	    if ($campototal !='') {
	    	$totalgral +=$total;	    	
	    	$this->ln(5);
	    	$this->salto($titulo, $config, $orientacion);
	    	$this->SetFont('Arial','',10, true);
	    	$this->SetX(5);
	    	$this->Cell(100, 5, 'TOTAL GENERAL: '.number_format($totalgral, 2, ',', '.'), 0, 0, 'L' , false);
	    }
	}

	function impctacte($titulo, $config, $data, $campocorte, $titulocorte, $campototal )	{
		//Cabecera
		$this->Head($titulo, $config);
		$this->SetY($this->GetY()+5);
		$corte="";
		$total=0;
		$totalgral=0;
		if ($campocorte !='') {
			$corte=$data[0]->$campocorte;
			$this->SetX(5);
			$this->SetFont('Arial','',8, true);
			$this->Cell(100, 5, $titulocorte.': '.$corte, 0, 0, 'L' , false);	
			$this->SetFont('Arial','',8, false);
			$this->ln(5);
		}
		
		for($i=0; $i<count($data); $i++) {
            $this->salto($titulo, $config, $orientacion);
            $this->SetFont('Arial','',8, false);
            $this->SetX(5);

            if ($campocorte !='') {
	    		if ($data[$i]->$campocorte !=$corte) {
	    			$this->SetFont('Arial','',8, true);
	    			if ($campototal !='') {
	    				$this->Cell($this->GetPageWidth()-5, 5, 'TOTAL DEL '.$titulocorte.': '.$corte.': '.number_format($total, 2, ',', '.'), 0, 0, 'L' , false);	
	    				$totalgral +=$total;
	    			}
	    			
	    			$this->Line(5,$this->GetY()+5, $this->GetPageWidth()-5, $this->GetY()+5);
	    			$this->ln();
	    			$this->salto($titulo, $config, $orientacion);	    			
	    			$total=0;
	    			$cuenta=0;
	    			$corte=$data[$i]->$campocorte;
					$this->SetX(5);
					$this->Cell(100, 5, $titulocorte.': '.$corte, 0, 0, 'L' , false);	
					$this->ln(5);
					$this->SetFont('Arial','',8, false);
	    		}	    		
	    	}
	    	if ($campototal !='') {
	    		$total +=$data[$i]->$campototal; 
	    	}
    		$j=0;
    		$posY=$this->GetY();
            $posFin=$posY;
            $posX=5;
            //var_dump($i);
            //var_dump($data[$i]);
            if ($i<count($data)-1) {
            	if ($data[$i]->impaga!='S') {
            		$this->SetFont('Arial','',8, false);

            	} else {
            		$this->SetFont('Arial','BI',8, true);
            	}
            } else {
            		$this->SetFont('Arial','',8, false);
            }
           
            foreach($data[$i] as $campo=>$valor) { 
            	if ($j<count($config) && $config[$j]['visible']=="S") { 
            		$this->SetY($posY);
            		$this->SetX($posX);
            		$posX +=$config[$j]['wide'];	            	
            		if ($this->GetStringWidth($valor)>$config[$j]['wide']) { 
	            		$this->MultiCell($config[$j]['wide'], 5, $valor, 0, $config[$j]['aling'], false);
	            		if ($posFin<$this->GetY()) {
	            			$posFin=$this->GetY(); 
	            		}
	            		
		            	} else { 
								$this->Cell($config[$j]['wide'], 5, $valor, 0, 0, $config[$j]['aling'], false);					}
				}
				$j +=1;
			}
			if ($posFin==$posY) {
				$this->Ln(4);

			} else {
					$this->SetY($posFin);
			}
			
        }		
        if ($campocorte !='' && $campototal !='') {
        	$this->SetX(5);
        	$this->SetFont('Arial','',8, true);
	    	$this->Cell(100, 5, 'TOTAL DEL '.$titulocorte.': '.$corte.': '.number_format($total, 2, ',', '.'), 0, 0, 'L' , false);
	    	$this->Line(5,$this->GetY()+5, $this->GetPageWidth()-5, $this->GetY()+5);	
	    }

	    if ($campototal !='') {
	    	$totalgral +=$total;	    	
	    	$this->ln(5);
	    	$this->salto($titulo, $config, $orientacion);
	    	$this->SetFont('Arial','',10, true);
	    	$this->SetX(5);
	    	$this->Cell(100, 5, 'TOTAL GENERAL: '.number_format($totalgral, 2, ',', '.'), 0, 0, 'L' , false);
	    }
	}

	function salto($titulo, $config, $orientacion) {
		if ( $this->GetY()> $this->GetPageHeight()-22) {
        	$this->AddPage($orientacion);
        	$this->Head($titulo, $config);
        	$this->SetY($this->GetY()+5);
         }
	}
}