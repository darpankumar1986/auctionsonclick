<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class ElasticSearch {
    public $index = 'c1prop';
    public $type = '';
    function __construct()
    {
        $this->server = ELASTICSEARCH_URL;
    }
    function call($path, $method = 'GET', $data = NULL)
    {
        if (!$this->index) throw new Exception('$this->index needs a value');
        $url = $this->server . '/' . $this->index . '/' . $path;
        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
        );
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        switch($method)
        {
            case 'GET':
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            case 'POST':
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                break;
            case 'PUT':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                break;
            case 'DELETE':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
        }
        $response = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);        
        
        return json_decode($response);
    }
    //curl -X PUT http://localhost:9200/{INDEX}/
    //this function is to create an index
    function create()
    {
        $this->call(NULL, 'PUT');    
    }
    //curl -X GET http://localhost:9200/{INDEX}/_status
    function status()
    {
        return $this->call('_status');
    }
    //curl -X GET http://localhost:9200/{INDEX}/{TYPE}/_count -d {matchAll:{}}
    function count()
    {
        return $this->call($this->type . '/_count?' . http_build_query(array(NULL => '{matchAll:{}}')));
    }
    //curl -X PUT http://localhost:9200/{INDEX}/{TYPE}/_mapping -d ...
    function map($data)
    {
        return $this->call($this->type . '/_mapping', 'PUT', $data);
    }
    //curl -X PUT http://localhost:9200/{INDEX}/{TYPE}/{ID} -d ...
    function add($id, $data)
    {
        return $this->call($this->type . '/' . $id, 'PUT', $data);
    }
    //curl -X DELETE http://localhost:9200/{INDEX}/
    //delete an indexed item by ID
    function delete($id)
    {
        return $this->call($this->type . '/' . $id, 'DELETE');
    }
    
    function delete_product($id,$data)
    {
        return $this->call($this->type . '/' . $id, 'DELETE' ,$data);
    }
    //curl -X GET http://localhost:9200/{INDEX}/{TYPE}/_search?q= ...
    function query($q)
    {
        return $this->call($this->type . '/_search?' . http_build_query(array('q' => $q)));
    }
    function query_wresultSize($query, $size = 999)
    {
        return $this->call($this->type . '/_search?' . http_build_query(array('q' => $q, 'size' => $size)));
    }
    function query_all($query)
    {
        return $this->call('_search?' . http_build_query(array('q' => $q)));
    }
    function query_all_wresultSize($query, $size = 999)
    {
        return $this->call('_search?' . http_build_query(array('q' => $q, 'size' => $size)));     
    }
    function search_product($path,$data)
    {
			return $this->call($path, 'GET', $data);
	}
}
