<?php 

namespace App\Controllers;
use App\Models\UserModel;
use App\Models\OfficeModel;
use App\Models\UserOfficeModel;
use App\Models\OrderModel;
use App\Models\OrderProductModel;
use App\Models\ConfigurationModel;
use CodeIgniter\I18n\Time;
use CodeIgniter\RESTful\ResourceController;
use App\Libraries\OrderTypesEnum;
use App\Libraries\OrderStatusEnum;
use CodeIgniter\HTTP\IncomingRequest;


class Orders extends BaseController
{
    protected $modelName = 'App\Models\Order';
    protected $format    = 'json';

    const OK_SUCCESS           =  0;
    const ERROR_UNKNOW         = -1;
    const ERROR_PASS_INCORRECT = -2;
    const ERROR_USER_INVALID   = -3;
    const ERROR_AUTH_NO_VALID  = -4;
    const ERROR_EMAIL_NO_VALID = -5;
    const ERROR_ORDER_INVALID  = -6;


    public function create(){
        $data_office  = [];
        $users        = new UserModel();
        $order        = new OrderModel();
        $orderProduct = new OrderProductModel();
        $orderTypes   = new OrderTypesEnum();
        $offices      = new OfficeModel();
        $orderTypes   = $orderTypes::getTypesOrder();
        $usersOffice  = new UserOfficeModel();
        $offices      = $offices->findAll();
        $id_order     = $this->request->getVar('id_order');
        $data['order_types'] = $orderTypes;
        $data['user']        = reset($users->where('id_user', $this->session)->find());
        $data['user_office'] = $usersOffice->where('id_t_user', $this->session)->find();
        $data['path']        = $this->path;
        $data['title']       = 'Creacion de pedidos';

        if($id_order){
            $data['order'] = reset($order->where('id_order', $id_order)->find());
            $orderProduct  = $orderProduct->where('id_order', $id_order)->find();
            $data['order_product'] = [];
            foreach ($orderProduct as $key_order => $order_product) {
                $data['order_product'][$order_product['product_code']] = $order_product;
            }
        }

        $office_ids = array_column($data['user_office'], 'id_t_office');
        array_push($office_ids, $data['order']['id_office']);

        foreach ($offices as $key_office => $office) {
            if(in_array($office['id_office'], $office_ids)){
                $data_office[$office['id_office']] = $office;
            }
        }

        $data['offices'] = $data_office;
        return view('orders/create', $data);
    }

    public function list(){
        $users         = new UserModel();
        $usersOffice   = new UserOfficeModel();
        $orders        = new OrderModel();
        $orderStatus   = new orderStatusEnum();
        $data['user']  = reset($users->where('id_user', $this->session)->find());
        $data['user_office'] = $usersOffice->where('id_t_user', $this->session)->find();
		$data['path']  = $this->path;
        $data['title'] = 'Lista de pedidos';
        $data['order_status'] = $orderStatus::getStatusOrder();

        if($data['user']['type'] == 2){
            $orders = $orders->join("t_order_product", "t_order_product.id_order = t_order.id_order", "left")
                                      ->join("t_user", "t_user.id_user = t_order.id_user", "left")
                                      ->join("t_office", "t_office.id_office = t_order.id_office", "left")->find();
        }else{
            $orders = $orders->whereIn('t_order.id_office', array_column($data['user_office'], 'id_t_office' ))
                             ->join("t_order_product", "t_order_product.id_order = t_order.id_order", "left")
                             ->join("t_user", "t_user.id_user = t_order.id_user", "left")
                             ->join("t_office", "t_office.id_office = t_order.id_office", "left")->find();
        }

        $data['orders'] = [];
        foreach ($orders as $key_order => $row_order) {

            if(!isset($data['orders'][$row_order['id_order']])) {
                $data['orders'][$row_order['id_order']] = $row_order;
            }

            $data['orders'][$row_order['id_order']]['products'][] = [
                "product_code" => $row_order["product_code"],
                "quantity"     => $row_order["quantity"]
            ];
        }

        return view('orders/list', $data);
    }

    public function search(){
        $client = \Config\Services::curlrequest();
        $bodyRequest = json_decode($this->request->getBody());
        $options = [
            "headers" => [
                "Content-Type" => "application/json",
                "key"          =>  getenv('telares_api.key_url')
            ],
            "query" => [
                "nextOffset"    => 0,
                "limit"         => 100,
                "code"          => isset($bodyRequest->code)        ? $bodyRequest->code: null,
                "barcode"       => isset($bodyRequest->barcode)     ? $bodyRequest->barcode: null,
                "description"   => isset($bodyRequest->description) ? $bodyRequest->description: null,
                "warehouse"     => isset($bodyRequest->warehouse)   ? $bodyRequest->warehouse: null
            ]
        ];

        $response = $client->get(getenv('telares_api.url_products'), $options);

        if($response->getStatusCode() == 200) {
            $responseBody    = json_decode($response->getBody());
            $items           = (array) $responseBody->items;
            $data['items']   = $items;
            $product_content = view('orders/list_products', $data);

            return json_encode([
                "code"    => 0, 
                "data"    => $response->getBody(),
                "html"    => $product_content
                ]);
        }else{
            return json_encode([
                "code"       =>  $response->getBody()->erroCode    ?: self::ERROR_UNKNOW, 
                "message"    =>  $response->getBody()->description ?: "Error al realizar la solicitud de productos"
                ]);
        }
        
    }

    public function getProducts(){
        $bodyRequest = json_decode($this->request->getBody());
        $products    = new OrderProductModel();

        $products = $products->where('id_order', $bodyRequest->id_order)->find();

        if(!empty($products)) {
            $data['orders']   = $products;
            $product_content = view('orders/products', $data);

            return json_encode([
                "code"    => self::OK_SUCCESS, 
                "data"    => $products,
                "html"    => $product_content
            ]);
        }else{
            return json_encode([
                "code"       =>  self::ERROR_UNKNOW, 
                "data"       =>  $products,
                "message"    =>  "Error al realizar la solicitud de productos"
            ]);
        }
        
    }

    public function save(){
        $users         = new UserModel();
        $order         = new OrderModel();
        $configuration = new ConfigurationModel();
        $configuration = $configuration->where("active", 1)->find();
        $user_session  = reset($users->where('id_user', $this->session)->find());
        $requestBody   = json_decode($this->request->getBody());

        foreach ($configuration as $key_config => $config) {
            if($config['name'] == 'pedidos_requieren_autorizacion'){
                $required_approved = $config['value'];
            }
        }
        
        $row_order     = [
            "id_user"       => $user_session['id_user'],
            "id_office"     => $requestBody->office_order,
            "creation_date" => new Time('now', $requestBody->timezone),
            "status"        => $required_approved == 'NO' ? 'APROBADO' : 'CREADO',
            "pre_approved"  => $required_approved == 'NO' ? 1 : 0,
        ];

        $row_order = $this->insert($row_order);

        if(!$row_order['id_user']){
            return json_encode([
                "code"    => self::ERROR_UNKNOW, 
                "message" => "Ha ocurrido un error en la creación del pedido", 
                "data"    => $order_created
                
                ]);
        }else{
            foreach ($requestBody->products as $key_product => $product) {
                $order_product = new OrderProductModel();
                $row_order_product = [
                    "id_order"      => $row_order['id_order'],
                    "quantity"      => $product->quantity_product,
                    "product_code"  => $product->code,

                    "description"  => $product->description,
                    "price"  => $product->price,
                    "warehouse"  => $product->warehouse
                ];

                $order_product->insert($row_order_product);
                $row_order_product['id_order_product']  = $order_product->insertID();

                if(!$row_order_product['id_order_product']){
                    return json_encode([
                        "code"    => self::ERROR_UNKNOW, 
                        "message" => "Ha ocurrido un error en la creación del pedido", 
                        "data"    => $order_product
                    ]);
                }
            }
        }

        return json_encode([
            "code"    => self::OK_SUCCESS, 
            "message" => "El pedido fue creado exitosamente", 
            "data"    => $row_order 
        ]);

    }

    public function edit()
    {
        $orders        = new OrderModel();
        $users         = new UserModel();
        $orderStatus   = new OrderStatusEnum();
        $orderStatus   = $orderStatus::getStatusOrder();
        $user_session  = reset($users->where('id_user', $this->session)->find());
        $requestBody   = json_decode($this->request->getBody());

        if($user_session['type'] == 2){
            $order   = reset($orders->where('id_order', $requestBody->id_order)->find());
            $order['status']  = isset($requestBody->status) ? $orderStatus[$requestBody->status] : $order['status'];
        }else{
            return json_encode([
                "code"    => self::ERROR_AUTH_NO_VALID, 
                "message" => "No tiene permisos para editar el pedido", 
                "data"    => ""
                ]);
        }
        if(empty($order)){
            return json_encode([
                "code"    => self::ERROR_ORDER_INVALID, 
                "message" => "Pedido no encontrado", 
                "data"    => ""
                ]);  
        }
        
        $order_updated = $this->update($order);

        return json_encode([
                    "code"    => self::OK_SUCCESS, 
                    "message" => "La información fue actualizada exitosamente", 
                    "data"    => $order
                    ]);
    }

    public function send(){
        $users         = new UserModel();
        $order         = new OrderModel();
        $orderProducts = new OrderProductModel();
        $requestBody   = json_decode($this->request->getBody());
        $client        = \Config\Services::curlrequest();
        $bodyRequest   = json_decode($this->request->getBody());
        $order         = reset($order->where('id_order', $bodyRequest->id_order)
                        ->join("t_office", "t_office.id_office = t_order.id_office", "left")->find());
        $order_product = $orderProducts->where('id_order', $bodyRequest->id_order)->find();

        if ($requestBody->type_order == '2') {
            $is_warranty = 1;
        } else {
            $is_warranty = 0;
        }

        $options = [
            "headers" => [
                "Content-Type" => "application/json",
                "key"          =>  getenv('telares_api.key_url')
            ]
        ];

        $body = [
                "order" => [
                    "creation_date"   => date('Y-m-d'),
                    "id_order"        => $order['id_order']
                ],
                "configuration" => [
                    "RIF"         => $order['rif'],
                    "SALSTERR"    => $order['SALSTERR'],
                    "SLPRSNID"    => $order['SLPRSNID'],
                    "PRSTADCD"    => $order['PRSTADCD'],
                    "CUSTNAME"    => $order['CUSTNAME'],
                    "ISWARRANTY"  => $is_warranty,
                    "INI_FACT_GP" => $order['INI_FACT_GP'],
                    "DOCID"       => $order['DOCID'],
                    "PRCLEVEL"    => $order['PRCLEVEL'],
                    "UOFM"        => $order['UOFM'],
                    "CURNCYID"    => $order['CURNCYID'],
                    "CREATETAXES" => $order['CREATETAXES'],
                    "DEFTAXSCHDS" => $order['DEFTAXSCHDS'],
                    "DEFPRICING"  => $order['DEFPRICING']
                ],
            ];

        $body["items"] = [];
        foreach ($order_product as $key_product => $product) {
            $body["items"][] = [
                "product_code" => $product['product_code'],
                "quantity"     => (int) $product['quantity'],
                "description"  => $product['description'],
                "warehouse"        => $product['warehouse'],
                "price"    => (double) $product['price'],
            ];

        }

        $body = json_encode($body);

        $response = $client->setBody($body)->request('POST', getenv('telares_api.url_orders'), $options);

        if($response->getStatusCode() == 200) {
            $responseBody  = json_decode($response->getBody());

            $row_order = [
                "id_order"  => $order['id_order'],
                "status"    => "APROBADO",
                "return_id" => $responseBody->return_id,
            ];

            $order = $this->update($row_order);

            return json_encode([
                "code"    => self::OK_SUCCESS, 
                "data"    => $row_order
            ]);

        }else{
            $responseBody  = json_decode($response->getBody());

            $row_order = [
                "id_order"          => $order['id_order'],
                "status"            => "ERROR",
                "error_description" => $responseBody->description
            ];

            $order = $this->update($row_order);

            return json_encode([
                "code"       =>  $responseBody->errorCode,
                "message"    =>  $responseBody->description
            ]);
        }
    }

    public function insert($row_order){
        $order = new OrderModel();
        $order->insert($row_order); 
        $row_order['id_order'] = $order->insertID();
        return $row_order;
    }

    public function update($row_order){
        $order = new OrderModel();
        $order->set($row_order);
        $order->where('id_order', $row_order['id_order']);
        $order->update();
        return $row_order;
    }

}