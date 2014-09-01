<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
    * bus model
    * 
    * @author: $Author: rainyang $
    * @copyright: HRB Max Company
    * @version: $Id$
*/
class Bus_Model extends CI_Model{
    

    /**
     * 定义表
     * @const TBL_SITE	站点
     * @const TBL_TRADE	行业
     * @const TBL_THEME	模版
     */
	const TBL_LINE = 'line';
	const TBL_ROUTEINFO = 'routeinfo';
	const TBL_STATION = 'station';
	const TBL_ORDER = 'b_order';
	const TBL_CUSTOMER = 'customer';
	const TBL_PRICE = 'ticket_price';
	const TBL_ADMIN = 'admin';
	const TBL_SITEINFO = 'siteinfo';

    function __construct(){
        parent::__construct();
    }

    
    /**
     * 查询station信息 
     */
    public function get_station_by_name($name)
    {
    	$this->db->order_by('id asc');
    	$this->db->like('name', $name);
        $rs = $this->db->get(self::TBL_STATION);
        return $rs->result_array();
    }

    public function get_customers(){
        $sql = "select * from " . self::TBL_CUSTOMER . " order by id desc";
        $query = $this->db->query($sql);
        $rs = $query->result_array();
        foreach($rs  as $val){
            $nrs[$val['id']] = $val;
        }
        //print_r($nrs);
        return $nrs;

    }

    public function update_customer($c_id, $data){
        $this->db->where('id', $c_id);
        $this->db->update(self::TBL_CUSTOMER, $data); 
    }

    public function get_customer_by_username($username, $password = null){
        $data = (!empty($password)) ?  array('username' => $username, 'password' => $password) :  array('username' => $username);
    	$query = $this->db->get_where(self::TBL_CUSTOMER, $data);
        return $query->row_array();
    }
    
    public function get_customers_num($where = null)
    {
    	if($where) $this->db->where($where);
    	$query = $this->db->get(self::TBL_CUSTOMER);
    	return $query->num_rows();
    }

    public function get_lines(){
    	$this->db->order_by('id desc');
        $rs = $this->db->get(self::TBL_LINE);
        return $rs->result_array();
    }

    function get_line_by_id($line_id){
    	$query = $this->db->get_where(self::TBL_LINE, array('id' => $line_id));
        return $query->row_array();
    }


    public function get_orders(){
    	$this->db->order_by('id desc');
        $rs = $this->db->get(self::TBL_ORDER);
        return $rs->result_array();
    }
    
	public function get_orders_num($where = null)
	{
        if($where) $this->db->where($where);
    	$query = $this->db->get(self::TBL_ORDER);
    	return $query->num_rows();
    }

    //总收入
    public function get_total_income($where = null){
    	if($where) $this->db->where($where);
        $sql = "select sum(pay_price) as price from " . self::TBL_ORDER . " where is_pay=1";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function getConfig(){
        $sql = "select * from bus_config limit 1";
        $query = $this->db->query($sql);
        return $query->row_array();
        
    }

    function get_route_by_rid($id){
    	$query = $this->db->get_where(self::TBL_ROUTEINFO, array('id' => $id));
        return $query->row_array();
    }

    public function get_route_by_id($station_id, $line_id)
    {
    	$query = $this->db->get_where(self::TBL_ROUTEINFO, array('station_id' => $station_id, 'line_id' => $line_id));
        return $query->result_array();
    }

    public function get_station($is_group = true){
        $group = ($is_group) ? "group by name" : "";
        $sql = "select * from " . self::TBL_STATION . " {$group}";
        $query = $this->db->query($sql);
        $rs = $query->result_array();
        foreach($rs  as $val){
            $nrs[$val['id']] = $val['name'];
        }
        //print_r($nrs);
        return $nrs;
    }
    
    public function get_station_num($where = null)
    {
    	if($where) $this->db->where($where);
    	$query = $this->db->get(self::TBL_STATION);
    	return $query->num_rows();
    }

    function get_station_by_id($id){
    	$query = $this->db->get_where(self::TBL_STATION, array('id' => $id));
        return $query->row_array();
    }

    public function get_station_by_line_id($line_id, $remove_transfer_station_id = 0){
    	$this->db->order_by('orderno asc');
        if($remove_transfer_station_id)
            $query = $this->db->get_where(self::TBL_STATION, array('line_id' => $line_id, 'is_transfer_station' => 0));
        else
            $query = $this->db->get_where(self::TBL_STATION, array('line_id' => $line_id));

        return $query->result_array();
    }

    public function add_customer($data){
    	$this->db->insert(self::TBL_CUSTOMER, $data);
        return $this->db->insert_id();
    }

    public function add_order($data){
    	$this->db->insert(self::TBL_ORDER, $data);
        return $this->db->insert_id();
    }

    public function update_order($id, $tid){
        $sql = "update ".self::TBL_ORDER. " set is_pay=1, transaction_id={$tid} where o_number ={$id}";
        $this->db->query($sql);
    }

    public function update_route($data, $id){
        $this->db->where('id', $id);
        $this->db->update(self::TBL_ROUTEINFO, $data); 
    }

    public function update_line($data, $id){
        $this->db->where('id', $id);
        $this->db->update(self::TBL_LINE, $data); 
    }

    public function update_station($data, $id){
        $this->db->where('id', $id);
        $this->db->update(self::TBL_STATION, $data); 
    }

    public function add_route($data){
    	return $this->db->insert(self::TBL_ROUTEINFO, $data);
    }

    public function add_price($data){
    	return $this->db->insert(self::TBL_PRICE, $data);
    }
    
    public function add_line($data){
    	$this->db->insert(self::TBL_LINE, $data);
        return $this->db->insert_id();
    }

    public function add_station($data){
    	$this->db->insert(self::TBL_STATION, $data);
        return $this->db->insert_id();
    }

    public function get_order_by_id($id){
        $rs = $this->db->get_where(self::TBL_ORDER, array('o_number'=>$id));
        return $rs->result_array();
    }

    public function get_customer_by_id($id){
        $rs = $this->db->get_where(self::TBL_CUSTOMER, array('id'=>$id));
        return $rs->row_array();
    }

    public function get_order_by_transaction_id($id){
        $rs = $this->db->get_where(self::TBL_ORDER, array('transaction_id'=>$id));
        return $rs->result_array();
    }

    public function getTotalPrice($o_number){
        $sql = "select sum(pay_price) as price from ".self::TBL_ORDER." where o_number = {$o_number}";
        $query = $this->db->query($sql);
        $rs = $query->row_array();
        return $rs['price'];
    }

    public function get_order_stat($cond = ''){
        $sql = "SELECT b.*,c.`first-name` as fname, c.`last-name` as lname FROM `b_order` as b inner join customer c on b.customer_id=c.id WHERE 1 {$cond} order by id desc";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function del_line($id){
        $this->db->delete(self::TBL_LINE, array('id' => $id)); 
    }

    function del_station_by_line_id($line_id){
        $this->db->delete(self::TBL_STATION, array('line_id' => $line_id)); 
    }

    function del_route_by_line_id($line_id){
        $this->db->delete(self::TBL_ROUTEINFO, array('line_id' => $line_id)); 
    }

    function del_ticket_price_by_line_id($line_id){
        $this->db->delete(self::TBL_PRICE, array('line_id' => $line_id)); 
    }

    function del_station_by_id($station_id){
        $this->db->delete(self::TBL_STATION, array('id' => $station_id)); 
    }

    function del_route_by_line_station_id($line_id, $station_id){
        $this->db->delete(self::TBL_ROUTEINFO, array('line_id' => $line_id, 'station_id' => $station_id)); 
    }

    function del_route_by_id($route_id){
        $this->db->delete(self::TBL_ROUTEINFO, array('id' => $route_id)); 
    }

    function del_ticket_price_by_station_id($station_id){
        $sql = "delete from ".self::TBL_PRICE. " where (from_station_id = {$station_id} or to_station_id = {$station_id})";
        $this->db->query($sql);
    }

    function del_ticket_price_by_line_station_id($line_id, $station_id){
        $sql = "delete from ".self::TBL_PRICE. " where line_id={$line_id} and (from_station_id = {$station_id} or to_station_id = {$station_id})";
        $this->db->query($sql);
    }

    function get_price_by_condition($cond){
        $sql = "SELECT * from ".self::TBL_PRICE. " where 1 {$cond} order by id";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    function update_price_by_condition($cond, $price, $discount = null){
        $wdiscount = ", discount='{$discount}'";
        $sql = "update ".self::TBL_PRICE. " set price='{$price}'".$wdiscount." where 1 {$cond}";
        $this->db->query($sql);
    }

    function get_going_station_by_name($name){
        $sql = "select * from station where line_id in (SELECT line_id FROM `station` WHERE name='{$name}') group by name";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    function get_transfer_line(){
        $sql = "select * from station where line_id in (SELECT id FROM `line` WHERE is_transfer=1) group by name";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function get_login($username, $password)
    {
    	$pss = md5($password);
    	$query = $this->db->get_where(self::TBL_ADMIN, array("username" => $username, "password" => $pss));
    	return $query->row_array();
    }
    
    function get_users($where = NULL)
    {
    	if($where) $this->db->where($where);
    	$query = $this->db->get(self::TBL_ADMIN);
    	return $query->result_array();
    }
    
    function save_user($data)
    {
    	$data['password'] = md5($data['password']);
    	return $this->db->insert(self::TBL_ADMIN, $data);
    }
    
    function edit_user($id, $data)
    {
    	return $this->db->update(self::TBL_ADMIN, $data, array('id' => $id));
    }
    
    function del_user($id)
    {
    	return $this->db->delete(self::TBL_ADMIN, array('id' => $id));
    }

    function get_siteinfo()
    {
    	$query = $this->db->query('select * from '.self::TBL_SITEINFO.' limit 1');
    	return $query->row_array();
    }

    function update_siteinfo($data){
    	return $this->db->update(self::TBL_SITEINFO, $data, array('id' => 1));
    }

}
