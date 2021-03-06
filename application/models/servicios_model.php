<?php
class servicios_model extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }
    public $CONDICION = '2015-06-01';
    public function Login($usuario,$pass){
        $i=0;
        $rtnUsuario = array();

        $this->db->where('Usuario',$usuario);
        $this->db->where('Activo',"1");
        $this->db->where('Password',$pass);
        $query = $this->db->get('usuarios');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $key) {
                $rtnUsuario['results'][$i]['mUser'] = $key['Usuario'];
                $rtnUsuario['results'][$i]['mNamv'] = $key['Nombre_visitador'];
                $rtnUsuario['results'][$i]['mPass'] = $key['Password'];
            }
        }else{
            $rtnUsuario['results'][$i]['mUser'] = $query->num_rows();
        }
        echo json_encode($rtnUsuario);
    }

    public function ROUND(){
        $i=0;
        $rtnUsuario = array();
        $query = $this->db->get('cuotasmes');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $key) {
                $this->db->where('RUTA', $key['RUTA']);
                $this->db->where('ARTICULO', $key['ARTICULO']);
                $this->db->update('cuotasmes', array(
                    'CANTIDAD' => $this->getRound($key['CANTIDAD'])           
                ));
                $rtnUsuario['results'][$i]['mRuta'] = $key['RUTA'];
                $rtnUsuario['results'][$i]['mArti'] = $key['ARTICULO'];
                $rtnUsuario['results'][$i]['mDesc'] = $key['DESCRIPCION'];
                $rtnUsuario['results'][$i]['mCant'] = $this->getRound($key['CANTIDAD']);
                $i++;                
            }
        }else{
            $rtnUsuario['results'][$i]['mUser'] = $query->num_rows();
        }
        echo json_encode($rtnUsuario);
    }
    public function Especialidades(){
        $i=0;
        $rtnUsuario = array();
        $query = $this->db->get('especialidad');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $key) {
                $rtnUsuario['results'][$i]['mUID'] = $key['IdEspecialidad'];
                $rtnUsuario['results'][$i]['mName'] = $key['Especialidad'];
                $i++;
            }
        }else{
            $rtnUsuario['results'][$i]['mUID'] = $query->num_rows();
        }
        echo json_encode($rtnUsuario);
    }
    function getRound($cantidad){        
        $query = $this->db->query("SELECT ROUND($cantidad, 0) valor");
        foreach ($query->result() as $row){
            return $row->valor;
        }

        return $cantidad;
    }

    public function Llaves($Vendedor,$Farmacias,$Medicos){
        $i=0;
        $rtnUsuario = array();



        $this->db->where('Ruta', $Vendedor);
        $this->db->update('llaves', array(
            'FARMACIA' => $Farmacias,
            'MEDICOS' => $Medicos
        ));


        $this->db->where('Ruta',$Vendedor);
        $query = $this->db->get('llaves');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $key) {
                $rtnUsuario['results'][$i]['mRut'] = $key['Ruta'];
                $rtnUsuario['results'][$i]['mFar'] = $key['FARMACIA'];
                $rtnUsuario['results'][$i]['mMed'] = $key['MEDICOS'];
                $rtnUsuario['results'][$i]['mRpt'] = $key['REPORTE'];
            }
        }else{
            $rtnUsuario['results'][$i]['mUser'] = $query->num_rows();
        }


        echo json_encode($rtnUsuario);
    }
    public function Farmacias($Ruta){
        $i=0;
        $arr = array();
        //$this->db->where('Ruta',$Ruta);
        $query = $this->db->get('farmacias');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $key) {
                $arr['results'][$i]['mUID'] = $key['IdMedico'];
                $arr['results'][$i]['mNFR'] = $key['NombreMedico'];
                $arr['results'][$i]['mNPR'] = $key['NombrePropietario'];
                $arr['results'][$i]['mDIR'] = $key['Direccion'];
                $arr['results'][$i]['mFAN'] = $key['FechaAniversario'];
                $arr['results'][$i]['mTFR'] = $key['TelfFarmacia'];
                $arr['results'][$i]['mTFP'] = $key['TelfPropietario'];
                $arr['results'][$i]['mHAT'] = $key['HorarioAtencion'];
                $arr['results'][$i]['mRCP'] = $key['ResponsableCompra'];
                $arr['results'][$i]['mTRC'] = $key['TelfRespCompra'];
                $arr['results'][$i]['mCDP'] = $key['CantDependiente'];
                $arr['results'][$i]['mPCP'] = $key['PotencialMensualCompra'];
                $arr['results'][$i]['mDPF'] = $key['DiasPagoFact'];
                $arr['results'][$i]['mRVC'] = $key['RespVencidos'];
                $arr['results'][$i]['mRCJ'] = $key['RespCanjes'];
                $arr['results'][$i]['mNDM'] = $key['NumDepMostrador'];
                $arr['results'][$i]['mPPP'] = $key['PartProgPuntos'];
                $arr['results'][$i]['mEBD'] = $key['EntregaBenefDepend'];
                $arr['results'][$i]['mPIP'] = $key['PermiteImpulsadoras'];
                $arr['results'][$i]['mCCO'] = $key['CadenaCooperativa'];
                $arr['results'][$i]['Ruta'] = $key['Ruta'];
                $i++;
            }
        }else{
            $arr['results'][$i]['mUser'] = $query->num_rows();
        }
        echo json_encode($arr);
    }
    public function Medicos($Ruta){
        $i=0;
        $arr = array();
        //$this->db->where('Ruta',$Ruta);
        $query = $this->db->get('medicos');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $key) {
                $arr['results'][$i]['mUID'] = $key['IdMedico'];
                $arr['results'][$i]['m01'] = $key['NombreMedico'];
                $arr['results'][$i]['m02'] = $key['FNacimiento'];
                $arr['results'][$i]['m03'] = $key['Especialidad'];
                $arr['results'][$i]['m04'] = $key['SubEspecialidad'];
                $arr['results'][$i]['m05'] = $key['Direccion'];
                $arr['results'][$i]['m06'] = $key['TelfClinica'];
                $arr['results'][$i]['m07'] = $key['Celular'];
                $arr['results'][$i]['m08'] = $key['Email'];
                $arr['results'][$i]['m09'] = $key['AUGraduacion'];
                $arr['results'][$i]['m10'] = $key['NEPSPrivado'];
                $arr['results'][$i]['m11'] = $key['MCMFrecuente'];
                $arr['results'][$i]['m12'] = $key['CConsulta'];
                $arr['results'][$i]['m13'] = $key['PFarmacia'];
                $arr['results'][$i]['m14'] = $key['SocioClinica'];
                $arr['results'][$i]['m15'] = $key['MCelular'];
                $arr['results'][$i]['m16'] = $key['MVehiculo'];
                $arr['results'][$i]['m17'] = $key['MReloj'];
                $arr['results'][$i]['m18'] = $key['MComputadora'];
                $arr['results'][$i]['m19'] = $key['NombreAsis'];
                $arr['results'][$i]['m20'] = $key['TExtensionAsis'];
                $arr['results'][$i]['m21'] = $key['CelularAsis'];
                $arr['results'][$i]['m22'] = $key['EmailAsis'];
                $arr['results'][$i]['m23'] = $key['FNacimientoAsis'];
                $arr['results'][$i]['m24'] = $key['ComputadoraAsis'];
                $arr['results'][$i]['m25'] = $key['OLBAMedica'];
                $arr['results'][$i]['m26'] = $key['DeportePractica'];
                $arr['results'][$i]['m27'] = $key['Pasatiempo'];
                $arr['results'][$i]['m28'] = $key['SMParticipa'];
                $arr['results'][$i]['m29'] = $key['Facebook'];
                $arr['results'][$i]['m30'] = $key['Twitter'];
                $arr['results'][$i]['m31'] = $key['Linkedin'];
                $arr['results'][$i]['m32'] = $key['Instagram'];
                $i++;
            }
        }else{
            $arr['results'][$i]['mUser'] = $query->num_rows();
        }
        echo json_encode($arr);
    }
    public function Mcuotas($vendedor){
        $i=0;
        $rtnUsuario = array();

        $this->db->where('RUTA',$vendedor);
        $query = $this->db->get('cuotasmes');

        $rtnUsuario['results'][$i]['mRuta'] = $vendedor;
        $rtnUsuario['results'][$i]['mArti'] = "";
        $rtnUsuario['results'][$i]['mDesc'] = "";
        $rtnUsuario['results'][$i]['mCant'] = "";
        $rtnUsuario['results'][$i]['mCnAc'] = "";

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $key) {
                $rtnUsuario['results'][$i]['mRuta'] = $key['RUTA'];
                $rtnUsuario['results'][$i]['mArti'] = $key['ARTICULO'];
                $rtnUsuario['results'][$i]['mDesc'] = $key['DESCRIPCION'];
                $rtnUsuario['results'][$i]['mCant'] = $key['CANTIDAD'];
                $rtnUsuario['results'][$i]['mCnAc'] = $this->Lleva($key['ARTICULO'],$key['RUTA']);
                $i++;
            }
        }else{
            $rtnUsuario['results'][$i]['mUser'] = "";
        }
        echo json_encode($rtnUsuario);
    }

    public function Articulos()
    {
        $i=0;
        $arr = array();
        $query = $this->sqlsrv->fetchArray("SELECT * FROM vm_Articulos",SQLSRV_FETCH_ASSOC);

        $arr['results'][$i]['mCod']     = "";
        $arr['results'][$i]['mNam']     = "";
        $arr['results'][$i]['mExi']     = 0;
        $arr['results'][$i]['mLab']     = "";
        $arr['results'][$i]['mUnd']     = "";
        $arr['results'][$i]['mPts']     = "";
        $arr['results'][$i]['mRgl']     = "";

        foreach($query as $key){
            $arr['results'][$i]['mCod']     = $key['ARTICULO'];
            $arr['results'][$i]['mNam']     = $key['DESCRIPCION'];
            $arr['results'][$i]['mExi']     = number_format($key['total'],2,'.','');
            $arr['results'][$i]['mLab']     = $key['LABORATORIO'];
            $arr['results'][$i]['mUnd']     = $key['UNIDAD_ALMACEN'];
            $arr['results'][$i]['mPts']     = $key['PUNTOS'];
            $arr['results'][$i]['mRgl']     = $key['REGLAS'];
            $i++;
        }
        echo json_encode($arr);
        $this->sqlsrv->close();
    }

    public function Lleva($Articulo,$Ruta){
       $Cantidad="0";
       
        $query = $this->sqlsrv->fetchArray("SELECT SUM(Cantidad) AS Cantidad FROM vm_Mensuales_vstCLA WHERE RUTA='".$Ruta."' AND ARTICULO='".$Articulo."' GROUP BY ARTICULO",SQLSRV_FETCH_ASSOC);
        foreach($query as $key){
            $retVal = ($key['Cantidad']=="") ? "0" : $key['Cantidad'] ;
            $Cantidad     = number_format($retVal,0);            
        }       
        
        return $Cantidad;

    }
    public function Clientes($Vendedor)
    {
        $i=0;
        $arr=array();
        $query = $this->sqlsrv->fetchArray("SELECT * FROM vm_Clientes WHERE VENDEDOR='".$Vendedor."'",SQLSRV_FETCH_ASSOC);

        $arr['results'][$i]['mCod']     = "";
        $arr['results'][$i]['mNam']     = "";
        $arr['results'][$i]['mDir']     = "";
        $arr['results'][$i]['mRuc']     = "";

        foreach($query as $key){
            $arr['results'][$i]['mCod']     = $key['CLIENTE'];
            $arr['results'][$i]['mNam']     = $key['NOMBRE'];
            $arr['results'][$i]['mDir']     = $key['DIRECCION'];
            $arr['results'][$i]['mRuc']     = $key['RUC'];
            $i++;
        }
        echo json_encode($arr);
        $this->sqlsrv->close();
    }
    public function vstCLA()
    {
        $i=0;
        $arr=array();
        $query = $this->sqlsrv->fetchArray("SELECT * FROM vm_3M_vstCLA",SQLSRV_FETCH_ASSOC);

        $arr['results'][$i]['mRut']     = "";
        $arr['results'][$i]['mCcl']     = "";
        $arr['results'][$i]['mArt']     = "";
        $arr['results'][$i]['mDec']     = "";
        $arr['results'][$i]['mDia']     = "";
        $arr['results'][$i]['mCnt']     = 0;
        $arr['results'][$i]['mClf']     = "";
        $arr['results'][$i]['mVnt']     = "";

        foreach($query as $key){
            $arr['results'][$i]['mRut']     = $key['RUTA'];
            $arr['results'][$i]['mCcl']     = $key['CCL'];
            $arr['results'][$i]['mArt']     = $key['ARTICULO'];
            $arr['results'][$i]['mDec']     = $key['DESCRIPCION'];
            $arr['results'][$i]['mDia']     = $key['Dia']->format('d-m-Y');
            $arr['results'][$i]['mCnt']     = number_format($key['Cantidad'],2);
            $arr['results'][$i]['mClf']     = $key['Clasificacion6'];
            $arr['results'][$i]['mVnt']     = number_format($key['Venta'],2);
            $i++;
        }
        echo json_encode($arr);
        $this->sqlsrv->close();
    }
    public function vtsArticulos($vendedor)
    {
        $i=0;
        $arr=array();
        $query = $this->sqlsrv->fetchArray("SELECT * FROM vm_3M_vtsArticulos WHERE RUTA='".$vendedor."'",SQLSRV_FETCH_ASSOC);

        $arr['results'][$i]['mRut']     = $vendedor;
        $arr['results'][$i]['mArt']     = "";
        $arr['results'][$i]['mDec']     = "";
        $arr['results'][$i]['mClf']     = "";
        $arr['results'][$i]['mCnt']     = 0;
        $arr['results'][$i]['mVnt']     = 0;
        $arr['results'][$i]['mHts']     = "";

        foreach($query as $key){
            $arr['results'][$i]['mRut']     = $key['RUTA'];
            $arr['results'][$i]['mArt']     = $key['ARTICULO'];
            $arr['results'][$i]['mDec']     = $key['DESCRIPCION'];
            $arr['results'][$i]['mClf']     = $key['Clasificacion6'];
            $arr['results'][$i]['mCnt']     = number_format($key['CANTIDAD'],2);
            $arr['results'][$i]['mVnt']     = number_format($key['Venta'],2);
            $arr['results'][$i]['mHts']     = $key['Hts'];
            $i++;
        }
        echo json_encode($arr);
        $this->sqlsrv->close();
    }
    public function vtsCliente($vendedor)
    {
        $i=0;
        $arr=array();
        $query = $this->sqlsrv->fetchArray("SELECT * FROM vm_3M_vtsCliente WHERE RUTA='".$vendedor."'",SQLSRV_FETCH_ASSOC);

        $arr['results'][$i]['mRut']     = $vendedor;
        $arr['results'][$i]['mCcl']     = "";
        $arr['results'][$i]['mNam']     = "";
        $arr['results'][$i]['mRuc']     = "";
        $arr['results'][$i]['mHts']     = "";
        $arr['results'][$i]['mVnt']     = 0;

        foreach($query as $key){
            $arr['results'][$i]['mRut']     = $key['RUTA'];
            $arr['results'][$i]['mCcl']     = $key['CCL'];
            $arr['results'][$i]['mNam']     = $key['NOMBRE'];
            $arr['results'][$i]['mRuc']     = $key['RUC'];
            $arr['results'][$i]['mHts']     = $key['hts'];
            $arr['results'][$i]['mVnt']     = number_format($key['Venta'],2);
            $i++;
        }
        echo json_encode($arr);
        $this->sqlsrv->close();
    }
   /* public function vtsTotales()
    {
        $i=0;
        $arr=array();
        $query = $this->sqlsrv->fetchArray("SELECT * FROM vm_3M_vtsTotales",SQLSRV_FETCH_ASSOC);
        foreach($query as $key){
            $arr['results'][$i]['mRut']     = $key['RUTA'];
            $arr['results'][$i]['mVnt']     = number_format($key['Venta'],2);

            $i++;
        }
        echo json_encode($arr);
        $this->sqlsrv->close();
    }*/
    public function MvstCLA($vendedor)
    {
        $i=0;
        $arr=array();
        $query = $this->sqlsrv->fetchArray("SELECT * FROM vm_Mensuales_vstCLA WHERE RUTA='".$vendedor."'",SQLSRV_FETCH_ASSOC);

        $arr['results'][$i]['mRut']     = $vendedor;
        $arr['results'][$i]['mCcl']     = "";
        $arr['results'][$i]['mNcl']     = "";
        $arr['results'][$i]['mArt']     = "";
        $arr['results'][$i]['mDec']     = "";
        $arr['results'][$i]['mDia']     = "";
        $arr['results'][$i]['mCnt']     = 0;
        $arr['results'][$i]['mClf']     = "";
        $arr['results'][$i]['mVnt']     = 0;

        foreach($query as $key){
            $arr['results'][$i]['mRut']     = $key['RUTA'];
            $arr['results'][$i]['mCcl']     = $key['CCL'];
            $arr['results'][$i]['mNcl']     = $key['NOMBRECL'];
            $arr['results'][$i]['mArt']     = $key['ARTICULO'];
            $arr['results'][$i]['mDec']     = $key['DESCRIPCION'];
            $arr['results'][$i]['mDia']     = $key['Dia']->format('d-m-Y');
            $arr['results'][$i]['mCnt']     = number_format($key['Cantidad'],2);
            $arr['results'][$i]['mClf']     = $key['Clasificacion6'];
            $arr['results'][$i]['mVnt']     = number_format($key['Venta'],2);
            $i++;
        }
        echo json_encode($arr);
        $this->sqlsrv->close();
    }
    public function MvtsArticulos($vendedor)
    {
        $i=0;
        $arr=array();
        $qMetas = $this->sqlsrv->fetchArray("SELECT * FROM vm_Mensuales_vtsTotales WHERE RUTA='".$vendedor."'",SQLSRV_FETCH_ASSOC);

        $arr['results'][$i]['mRut']     = $vendedor;
        $arr['results'][$i]['mventa']   = 0;
        $arr['results'][$i]['mV3m']     = 0;
        $arr['results'][$i]['mMeta']    = 0;

        foreach($qMetas as $key){
            $arr['results'][$i]['mRut']     = $key['RUTA'];
            $arr['results'][$i]['mventa']   = number_format($key['Venta'],2);
            $arr['results'][$i]['mV3m']     = number_format($key['vst_3m'],2);            
            $arr['results'][$i]['mMeta']    = number_format($key['metas'],2);
        }

        $i++;
        $qVstas = $this->sqlsrv->fetchArray("SELECT * FROM vm_Mensuales_vtsArticulos WHERE RUTA='".$vendedor."' ",SQLSRV_FETCH_ASSOC);

        $arr['results'][$i]['mRut']     = $vendedor;
        $arr['results'][$i]['mArt']     = "";
        $arr['results'][$i]['mDic']     = "";
        $arr['results'][$i]['mClf']     = "";
        $arr['results'][$i]['mCnt']     = 0;
        $arr['results'][$i]['mVnt']     = 0;
        $arr['results'][$i]['mHts']     = "";

        foreach($qVstas as $key){
            $arr['results'][$i]['mRut']     = $key['RUTA'];
            $arr['results'][$i]['mArt']     = $key['ARTICULO'];
            $arr['results'][$i]['mDic']     = $key['DESCRIPCION'];
            $arr['results'][$i]['mClf']     = $key['Clasificacion6'];
            $arr['results'][$i]['mCnt']     = number_format($key['CANTIDAD'],2);
            $arr['results'][$i]['mVnt']     = number_format($key['Venta'],2);
            $arr['results'][$i]['mHts']     = $key['Hts'];
            $i++;
        }
        echo json_encode($arr);
        $this->sqlsrv->close();
    }
    public function MvtsCliente($vendedor)
    {
        $i=0;
        $arr=array();
        $query = $this->sqlsrv->fetchArray("SELECT * FROM vm_Mensuales_vtsCliente WHERE RUTA='".$vendedor."'",SQLSRV_FETCH_ASSOC);

        $arr['results'][$i]['mRut']     = $vendedor;
        $arr['results'][$i]['mCcl']     = "";
        $arr['results'][$i]['mNam']     = "";
        $arr['results'][$i]['mRuc']     = "";
        $arr['results'][$i]['mHts']     = "";
        $arr['results'][$i]['mVnt']     = 0;

        foreach($query as $key){
            $arr['results'][$i]['mRut']     = $key['RUTA'];
            $arr['results'][$i]['mCcl']     = $key['CCL'];
            $arr['results'][$i]['mNam']     = $key['NOMBRE'];
            $arr['results'][$i]['mRuc']     = $key['RUC'];
            $arr['results'][$i]['mHts']     = $key['hts'];
            $arr['results'][$i]['mVnt']     = number_format($key['Venta'],2);
            $i++;
        }
        echo json_encode($arr);
        $this->sqlsrv->close();
    }
    public function HstItemFacturados($vendedor)
    {
        $i=0;
        $arr=array();
        $query = $this->sqlsrv->fetchArray("SELECT * FROM vm_HstItemFacturados WHERE RUTA='".$vendedor."'",SQLSRV_FETCH_ASSOC);

        $arr['results'][$i]['mCcl']     = $vendedor;
        $arr['results'][$i]['mArt']     = "";
        $arr['results'][$i]['mDes']     = "";
        $arr['results'][$i]['mCan']     = 0;
        $arr['results'][$i]['mVnt']     = 0;

        foreach($query as $key){
            $arr['results'][$i]['mCcl']     = $key['CCL'];
            $arr['results'][$i]['mArt']     = $key['ARTICULO'];
            $arr['results'][$i]['mDes']     = $key['DESCRIPCION'];
            $arr['results'][$i]['mCan']     = number_format($key['Cantidad'],2);
            $arr['results'][$i]['mVnt']     = number_format($key['Venta'],2);
            $i++;
        }
        echo json_encode($arr);
        $this->sqlsrv->close();
    }
    public function LOTES()
    {
        $i=0;
        $arr=array();
        $query = $this->sqlsrv->fetchArray("SELECT * FROM vm_Lotes",SQLSRV_FETCH_ASSOC);

        $arr['results'][$i]['mArt']     = "";
        $arr['results'][$i]['mLot']     = "";
        $arr['results'][$i]['mFvc']     = "";
        $arr['results'][$i]['mCds']     = 0;

        foreach($query as $key){
            $arr['results'][$i]['mArt']     = $key['ARTICULO'];
            $arr['results'][$i]['mLot']     = $key['LOTE'];
            $arr['results'][$i]['mFvc']     = $key['FECHA_VENCIMIENTO'];
            $arr['results'][$i]['mCds']     = number_format($key['CANT_DISPONIBLE'],2);
            $i++;
        }
        echo json_encode($arr);
        $this->sqlsrv->close();
    }
    public function FacturaPuntos($Vendedor)
    {
        $i=0;
        $rtnCliente=array();
        $query = $this->sqlsrv->fetchArray("SELECT CLIENTE,FECHA,FACTURA,SUM(TT_PUNTOS) AS TOTAL,RUTA FROM vtVS2_Facturas_CL WHERE RUTA = '".$Vendedor."'
                        GROUP BY FACTURA,FECHA,RUTA,CLIENTE",SQLSRV_FETCH_ASSOC);

        $rtnCliente['results'][$i]['mFch']  = "";
        $rtnCliente['results'][$i]['mClt']  = "";
        $rtnCliente['results'][$i]['mFct']  = "";
        $rtnCliente['results'][$i]['mPnt']  = 0;
        $rtnCliente['results'][$i]['mRmT']  = "";

        foreach($query as $key){
            $Remanente = number_format($this->FacturaSaldo($key['FACTURA'],$key['TOTAL']),2,'.','');
            if (intval($Remanente) > 0.00 ) {
                $rtnCliente['results'][$i]['mFch']  = $key['FECHA']->format('Y-m-d');
                $rtnCliente['results'][$i]['mClt']  = $key['CLIENTE'];
                $rtnCliente['results'][$i]['mFct']  = $key['FACTURA'];
                $rtnCliente['results'][$i]['mPnt']  = number_format($key['TOTAL'],2,'.','');
                $rtnCliente['results'][$i]['mRmT']  = $Remanente;
                $i++;
            }
        }
        echo json_encode($rtnCliente);
        $this->sqlsrv->close();
    }
    public function FacturaSaldo($id,$pts){
        $this->db->where('Factura',$id);
        $this->db->select('Puntos');
        $query = $this->db->get('visys.rfactura');
        if($query->num_rows() > 0){
            $parcial = $query->result_array()[0]['Puntos'];
        } else {
            $parcial = $pts;
        }
        return $parcial;
    }

    /*ADD-UPDATE FARMACIA*/
    public function guardandoCambiosFarmacia($data) {
        if (count($data)>0) {
            foreach(json_decode($data, true) as $key){
                $fecha = date('Y-m-d', strtotime($key['mFAN']));
                $result = $this->db->query("call sp_farmacias('".$key['mUID']."','".$key['mNFR']."','".$key['mNPR']."','".$key['mDIR']."','".$fecha."','".$key['mTFR']."','".$key['mTFP']."','".$key['mHAT']."','".$key['mRCP']."','".$key['mTRC']."','".$key['mCDP']."','".$key['mPCP']."','".$key['mDPF']."','".$key['mRVC']."','".$key['mRCJ']."','".$key['mNDM']."',".$key['mPPP'].",".$key['mEBD'].",".$key['mPIP'].",".$key['mCCO'].",'".$key['Ruta']."')");
            }
        }
    }


    /*ADD-UPDATE MEDICOS*/
    public function guardandoCambiosMedicos($data) {
        if (count($data)>0) {
            foreach (json_decode($data, true) as $key){
                $f1 = date('Y-m-d', strtotime($key['m02']));
                $f2 = date('Y-m-d', strtotime($key['m20']));
                
                $result = $this->db->query("call sp_medicos(
                '".$key['mUID']./*IdMedico*/"',
                '".$key['m01']./*Nombre medico*/"',
                '".$f1./*Fecha nacimiento*/"',
                '".$key['m31']./*Especialidad*/"',
                '".$key['m32']./*Sub especialidad*/"',
                '".$key['m03']./*Direccion*/"',
                '".$key['m04']./*Telefono Clinica*/"',
                '".$key['m05']./*Celular*/"',
                '".$key['m06']./*Email*/"',
                '".$key['m07']./*Año y uni de graduacion*/"',
                '".$key['m08']./*Numero Paciente Estimado*/"',
                '".$key['m09']./*Motivo consulta frecuente*/"',
                '".$key['m10']./*Costo consulta*/"',
                ".$key['m33']./*Propietario farmacia*/",
                '".$key['m11']./*Socio clinica*/"',
                '".$key['m12']./*Marca celular*/"',
                '".$key['m13']./*Marca vehiculo*/"',
                '".$key['m14']./*Marca reloj*/"',
                '".$key['m15']./*Marca computadora*/"',
                '".$key['m16']./*Nombre asistente*/"',
                '".$key['m17']./*Telef extension asistente*/"',
                '".$key['m18']./*Celular asistente*/"',
                '".$key['m19']./*Email asistente*/"',
                '".$f2./*Fecha nacimiento asistente*/"',
                '".$key['m21']./*Computadora asistente*/"',
                '".$key['m22']./*OLBA medica*/"',
                '".$key['m23']./*Deporte practica*/"',
                '".$key['m24']./*Pasatiempo*/"',
                '".$key['m25']./*Sociedad medica participa*/"',
                '".$key['m26']./*Facebook*/"',
                '".$key['m27']./*Twitter*/"',
                '".$key['m28']./*Linkedin*/"',
                '".$key['m29']./*Instagram*/"',
                '".$key['m30']./*Ruta*/"')");
            }

            if ($result) {
                echo true;
            }

    public function DeleteFarmacia($uID){
        $result = $this->db->delete('farmacias', array('IdFarmacia' => $uID));
        if ($result) {
            echo json_encode("OK");
        }
    }
    public function DeleteMedicos($uID){
        $result = $this->db->delete('medicos', array('IdMedico' => $uID));
        if ($result) {
            echo json_encode("OK");

        }
    }
}