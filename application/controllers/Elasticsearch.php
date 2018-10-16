<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require dirname(__FILE__).'/../libraries/eslib/vendor/autoload.php';

use Elasticsearch\ClientBuilder;

class Elasticsearch extends CI_Controller {
    public $elasticclient = '' ;
    public function __construct(){
        parent::__construct();
        $hosts = [
        [
        'host' => ES_IP,
        'port' => ES_PORT,
        'scheme' => ES_SCHEME,
        'user' => ES_USER,
        'pass' => ES_PASS
        ]
        ];

        $this->elasticclient = ClientBuilder::create()->setHosts($hosts)->build();
        // $this->load->helper('elasticsearch_helper');
        $this->load->model('global_model');
    }

    function index(){
        echo 'welcome to simple elasticsearch module.';
    }

    /**
     * save to mysql
     */
    function save_to_db($name,$mark){
        $this->global_model->save_to_db($name,$mark);        
    }

    /**
     * save to es
     */
    function save_to_es($name,$mark){
        $params = [
        'index' => 'my_index_gobinda_nandi',
        'type' => 'my_type',
        // 'id' => 'my_id',
        'body' => [ 'name' =>  $name, 'mark' => $mark ]
        ];
        $response = $this->elasticclient->index($params);
        echo "<pre>";
        print_r ($response);
        echo "</pre>";
    }

    /**
     * normal insert to es
     * URL : http://127.0.0.1/es/Elasticsearch/insert
     */
    function insert() {
        $params = [
        'index' => 'my_index_gobinda_nandi',
        'type' => 'my_type',
        'id' => 'my_id',
        'body' => [ 'testField' => 'abc']
        ];

        $response = $this->elasticclient->index($params);

        /**
         * for view 
         localhost:9200/_cat/indices/
        */
     }

    /**
      * URL : http://127.0.0.1/es/Elasticsearch/search1
      */
    function search1($q=''){
        $param= 
        [
        'body' =>[
        'query'=>[
        'bool' => [
        'should' => [
        'match' => [
        'name' => $q]]]]]
        ];
        $response = $this->elasticclient->search($param);
        echo "<pre>";
        print_r ($response);
        echo "</pre>";
    }

    /**
      * URL : http://127.0.0.1/es/Elasticsearch/search_all_data
      */
    function search_all_data()
    {
        $response = $this->elasticclient->search();
        echo "<pre>";
        print_r ($response);
        echo "</pre>";
    }

    /**
      * URL : http://127.0.0.1/es/Elasticsearch/getData
      */
    function getData()
    {
        $params = [
        'index' => 'my_index_gobinda_nandi',
        'type' => 'my_type',
        'id' => 'my_id'
        ];

        
        $response = $this->elasticclient->get($params);
        echo "<pre>";
        print_r ($response);
        echo "</pre>";
    }

    /**
     * hardcoded : 'testField' => 'abc'
     * URL : http://127.0.0.1/es/Elasticsearch/search_doc
     */
    function search_doc()
    {
        $params = [
        'index' => 'my_index_gobinda_nandi',
        'type' => 'my_type',
        'body' => [
        'query' => [
        'match' => [
        'testField' => 'abc'
        ]
        ]
        ]
        ];

        $response = $this->elasticclient->search($params);
        echo "<pre>";
        print_r ($response);
        echo "</pre>";
    }

}

/* End of file Elasticsearch.php */
/* Location: ./application/controllers/Elasticsearch.php */
