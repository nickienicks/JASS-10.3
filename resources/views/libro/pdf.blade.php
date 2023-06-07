<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
     
     <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>   
    
<style>
  .bg-gray-300 {
    background-color: #d1d5db;
  }
   .bg-balck {
    background-color: #0f172a;
  }

  .border-solid{
    border-style: solid;
  }
  html, body{
  height:100%;
  
}
  .div2{
  height:100%;
  
}
.jaa { outline: 2px blue; }
table {
  border-color: rgb(24, 23, 22);
  border-radius: 10% / 50%;
}
th {
  border-color: rgb(24, 23, 22);
  /* border-radius: 10% / 50%; */
}
tr {
  border-color: rgb(24, 23, 22);
  border-radius: 10% / 50%;
}
td {
  border-color: rgb(24, 23, 22);
  /* border-radius: 10% / 50%; */
}
tbody {
  border-color: rgb(24, 23, 22);
  border-radius: 10% / 50%;
}
#corte {
  font-weight: bolder;
}
#corte1 {
  font-weight: bolder;
  font-size: large;
}
#padi{
  padding-right:10px;
}
#corte2{
  padding-right:15px;
  font-weight: bolder;
  font-size: large;
}
#logo{
  width: 120px;

  
}
</style>
    
    <title>Document</title>
</head>
<body>
  
  
  
@foreach ($contacts as $contact)
    @php  $aea1 = 0;
          $cort=$contact->corte;
          $array=[];   
          
          $elo= $contact->deudas;

          $cortee=null;

          foreach ($elo as $key => $con) {
            if($con->type == true){
                $cortee= $con;
                unset($elo[$key]);
              }

          }
    @endphp
  @foreach ($contact->deudas as $key => $contac)
        
        
          @php
          
            if($contac->monto > 0 ){
              $obj = new stdClass();
              $obj->fecha=$contac->fecha;
              $obj->monto=$contac->monto;
              $obj->type=$contact->type;
              array_push($array,$obj);
            }
              
              
            
            
            
          @endphp
        
  @php
    $aea1 = $aea1 + $contac->monto;
  @endphp
  
   @if ($loop->last)
  {{-- <p>This is user {{ $contact->id }}</p> --}}
   @php
     $aea1 - $contac->monto;
   @endphp
  <div class="">
   <table class="border-b-4 border-l-4 border-t-4 border-r-4 border-color-black w-full mb-8 ">
    <thead>
      <tr>
        <th  class="text-2xl border-top " style="width:100%;" ><img id="logo" style="height:120px; width: 800px;" src="{{ asset('images/logo3.jpg') }}" ></th>
        <th  class=" text-2xl uppercase border-top  bg-gray-300 " style="width:70%;">
          Mes Facturado:
          <br>
          @php
            $date3=\Carbon\Carbon::parse($contac->fecha)->subDays(10)->translatedFormat(' F  Y');
          @endphp
          {{-- {{date('M',strtotime($contac->fecha))}} --}}
          {{$date3}}
          
        </th>
      </tr>
    </thead>
  </table>
  
   <table class="border w-full mb-6">
    <thead>
      <tr>
        <th class="">DATOS </th>
        <th class=""> CLIENTE</th>
        <th class=""></th>
        <th class=""></th>
      </tr>
    </thead>
    <tbody class="border">
      <tr class="">
        <td>Nombres:</td>
        <td >{{$contact->first_name}}</td>
        <td>Concepto: Agua Potable</td>
        <td></td> 
      </tr>
      <tr>
        <td>Apellidos:</td>
        <td > {{$contact->last_name}}</td>
        <td>Zona: {{$contact->zona}}</td>
        <td></td>
      </tr>
      <tr>
        <td>Direccion:</td>
        <td >{{$contact->direccion}}</td>
        <td></td>
        <td ></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    </tbody>
   </table>
  </table>
 
  <table class="border w-full mt-2">
    <thead>
      <tr class="border">
        <th style="width: 35%;"> Detalle</th>
        <th style="text-align: left;">Consumo</th>
        <th></th>
        <th></th>
      </tr>
    </thead>        
    <tbody class="border">
      @php
        $montoe1=0;
        $montoe2=0;
        
        $all=$contac->medida_act - $contac->medida_ant;
          if( $all <= 7 ){
            $montoe1=14;
          }else{
              $montoe1=14;
              
              if ($all> 20) {
                  $montoe = ($all-7) * 3;
                  $montoe2 = $montoe;
              } else {
                  $montoe = ($all-7) * 2;
                  $montoe2 = $montoe;
              }
          }
        @endphp
      <tr>
        <td class="">Lectura Anterior:</td>
        <td class="  text-left ">{{$contac->medida_ant}} m<sup>3</sup></td>
        <td class=" "></td>
        <td class="  "></td>
      </tr>
      <tr>
        <td class=" ">Lectura Actual:</td>
        <td class="  text-left "> {{$contac->medida_act}} m<sup>3</sup></td>
        <td class="   "></td>
        <td class="   "></td>
      </tr>
      <tr>
        <td class=" ">Consumo Facturado:</td>
        <td class="text-left"> 
          {{$contac->medida_act - $contac->medida_ant }} m<sup>3</sup>
        </td>
        <td id="corte1" class="text-center ">A Pagar:</td>
        <td id="corte1" class="text-center ">S/. {{$contac->monto}}.00</td>
       
        
      </tr>
      <tr>
        
        <td class=" ">Consumo mínimo :</td>
        <td class="  text-left ">S/. {{$montoe1}}.00 </td>
        <td class="   "></td>
        <td class="   "></td>
      </tr>
      <tr>
        <td class=" ">Consumo en exceso:</td>
        <td class="  text-left ">S/. {{$montoe2}}.00 </td>
        <td class="   "></td>
        <td class="  "></td>
      </tr>
     
    </tbody>

  </table>
  
  

    
  
      <table class="border-collapse w-full mt-8 mb-6">
        <thead>
          <tr class="border">
          <th >DEUDAS ANTERIORES</th>
            <th >
              
            </th>
          
          </tr>
        </thead>
        
        <tbody>
          @php
            $arre = array_pop($array); 
          @endphp
          @php
          @endphp
          @foreach ($array as $arra)
            @php
              $datemdf=\Carbon\Carbon::parse($arra->fecha)->subDays(15)->translatedFormat(' F  Y');
           
              
            
            @endphp
                <tr>
                  <td class="border border-slate-700 uppercase">{{$datemdf}}</td>
                  <td class="border border-slate-700  text-center ">S/. {{$arra->monto}}.00</td>
                </tr>
            
             
            
          @endforeach
          @if ( $cortee )
                @php
                  $monttt=0;
                  $monttt= $cortee->monto;
                  /* @dump($contact->deudas); */
                @endphp
            <tr>
              <td class="border border-slate-700 uppercase">Corte y reconexión</td>
              <td class="border border-slate-700  text-center ">S/. {{$cortee->monto}}.00</td>
            </tr>
           @else
           @php
             $monttt=0;
           @endphp 
          @endif
     
          <tr>
           
            <td id="padi" class="border border-slate-700 text-right  ">Total</td>
            <td id="corte" class="border border-slate-700  text-center ">S/. {{$aea1 - $contac->monto + $monttt}}.00</td>
          </tr>
        </tbody>
      </table>
 



  <table class="border w-full mt-8 ">
    <thead>
    <tr>
      <th class=" ">FECHA DE EMISION</th>
      <th class="">FECHA DE VENCIMIENTO</th>
      <th class="">TOTAL A PAGAR S/.</th>
    </tr>
    </thead>        
    <tbody class="border text-xl">
      <tr>
        <td  ><a style="visibility:hidden;">.</a></td>
        <td class=" text-center "></td>
        <td class=""></td>
      </tr>
      <tr style=" height:150px; ">
        @php
         $date4=\Carbon\Carbon::parse($contac->fecha)->translatedFormat('d F  Y');
         if($cort = '2001-01-01'){
          $date5=\Carbon\Carbon::parse($contac->fecha)->addDays(10)->modify('last day of this month')->translatedFormat('d F  Y');
         
         }else{
          $date5=\Carbon\Carbon::parse($cort)->translatedFormat('d F  Y');
         }
        @endphp
        
        <td class="text-center" >{{$date4}}</td>
        <td class=" text-center "> {{$date5}}</td>
        <td id="corte2" class="text-right">S/. {{$aea1+ $monttt}}.00</td>
      </tr>
      <tr>
        <td  ><a style="visibility:hidden;">.</a></td>
        <td class=" text-center "></td>
        <td class=""></td>
      </tr>
       
    </tbody>


  </table>
    <table class="border-collapse w-full mt-4 ">
    <thead>
    <tr>
      <th class=" mb-8">MENSAJES</th>
      <th class=""></th>
      
    </tr>
    </thead>        
    <tbody class="mt-8">
      <tr>
        <td class="border border-slate-700 " colspan="2" style="width:100%;">JASS ALEGRIA LE RECUERDA:</td>
     

      </tr>
      <tr>
        @php
          $estC='2001-01-01';
          $estd=$cort;
          $mensaje="";
          $sies= count($array);
          if($sies < 1){
            $mensaje="Cancele a tiempo";
          }else{
            $mensaje="Cancele a tiempo y evite el CORTE!!!";
          }
          if($cortee){
            $mensaje= "SU SERVICIO ESTÁ EN CORTE";
          }
        @endphp
        <td id="corte" class="border uppercase border-slate-700" colspan="2">{{$mensaje}}</td>
        
      </tr>  
      
      </tr>    
    </tbody>
  </table>
      </div>   
      
      @php
        $cortee=null;
      @endphp

      @endif

      
    
      @endforeach

      @if($loop->last)
            <div class=""></div>
      @else
          <div style="page-break-after:always;"></div>
      @endif

      


    @endforeach
     
    


      
</body>
</html>