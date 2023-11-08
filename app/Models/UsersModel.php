<?php

namespace App\Models;

use CodeIgniter\Model;
/**
 * Users Model
 * 
 * Model for standardization.
 */
class UsersModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['username', 'password', 'email', 'gsecret', 'role_id'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    /**
     * Basic Model Function. Get data by primary key.
     * 
     * @param mixed $data IF param is null, gets all rows. ex: get_data(). IF param is int, returns row where primary key is matched ex: get_data(1). IF array, returns data based on values passed in array. ex: get_data([1, 3, 5])
     * 
     * @return array 
     */
    public function get_data($data = null)
    {
        $dataset = $this->find($data);
        return $dataset;
    }

    /**
     * Basic Model Function. Get data by setting parameters.
     * 
     * @param array $data Array key value pairs you wish to use to filter data.
     * @param int $limit Number of records to return
     * @param int $offset Offset of records to return
     * 
     * @return array
     */
    public function get_data_params(array $data = [], int $limit = 0, int $offset = 0)
    {
        $dataset = $this;
        foreach( $data as $key => $value )
        {
            $dataset->where($key, $value);
        }
        return $dataset->findAll($limit, $offset);
    }

    /**
     * Basic Model Function. Insert data to table.
     * 
     * @param array $data Array with key value pair to insert to table
     * 
     * @return array Array containing message [success|error] and id of inserted data.
     */
    public function insert_data(array $data = [])
    {
        $dataset = $this;
        if( $dataset->insert($data, false) )
        {
            return [ 'message' => 'success', 'id' => $dataset->getInsertID() ];
        } else {
            return [ 'message' => 'error', 'id' => null ];
        }
    }

    /**
     * Basic Model Function. Update data in table.
     * 
     * @param int $id Primary key of the item to update.
     * @param array $data Key value pair to be updated.
     * 
     * @return array 
     */
    public function update_data(int $id = 0, array $data = [])
    {
        $dataset = $this;
        if( $dataset->update($id, $data) )
        {
            return [ 'message' => 'success', 'id' => $id ];
        } else {
            return [ 'message' => 'error', 'id' => $id ];
        }
    }

    /**
     * Basic Model Function. Updata data in table based on custom filters
     * 
     * @param array $filters Key value pair filters to use in update.
     * @param array $data Key value pair of data to update.
     * 
     * @return array
     */
    public function update_data_params(array $filters = null, array $data = [])
    {
        $dataset = $this;
        foreach( $filters as $key => $value )
        {
            $dataset->where($key, $value);
        }

        if( $dataset->set($data)->update() )
        {
            return [ 'message' => 'success' ];
        } else {
            return [ 'message' => 'error' ];
        }
    }

    /**
     * Basic Model Function. Delete data from table [soft delete|hard delete]
     * 
     * @param mixed $data Primary key or array of primary keys to delete.
     * @param bool IF $useSoftDeletes is true, false is 'soft delete'. Setting this to true results in 'hard delete'.
     * 
     * @return array
     */
    public function delete_data($data = null, bool $purge = false)
    {
        $dataset = $this;
        if($dataset->delete($data, $purge))
        {
            return [ 'message' => 'success', 'id' => $data];
        } else {
            return [ 'message' => 'error', 'id' => $data];
        }
    }

    /**
     * Basic Model Function. Delete data from table using parameters.
     * 
     * @param array $data Key value pair to identify row to delete
     * 
     * @return array
     */
    public function delete_data_params(array $data = [])
    {
        $dataset = $this;
        foreach( $data as $key => $value )
        {
            $dataset->where($key, $value);
        }
        if( $dataset->delete() )
        {
            return [ 'message' => 'success', 'id' => $data];
        } else {
            return [ 'message' => 'error', 'id' => $data];
        }
    }

    public function get_datatable_data(int $limit = 0, int $offset = 0, string $orderby = null, string $orderdir = 'ASC', string $search = null )
    {
        $dataset = $this;
        
        $dataset->select('id, username, email, gsecret, role_id, created_at, updated_at');

        if($search != null)
        {
            $dataset->groupStart();
            $dataset->like('id', $search);
            $dataset->orLike('username', $search);
            $dataset->orLike('email', $search);
            $dataset->orLike('gsecret', $search);
            $dataset->orLike('created_at', $search);
            $dataset->orLike('updated_at', $search);
            $dataset->groupEnd();
        }
        $dataset->where('deleted_at', null);
        $dataset->orderBy( $orderby, strtoupper($orderdir) );  

        return [
            'data' => $dataset->findAll($limit, $offset),
            'recordsFiltered' => $this->get_datatable_recordsFiltered($search), //total filtered data for paging
            'recordsTotal' => $this->countAll(), //total of all records in table
        ];
    }

    private function get_datatable_recordsFiltered(string $search)
    {
        $dataset = $this;
        if($search != null)
        {
            $dataset->groupStart();
            $dataset->like('id', $search);
            $dataset->orLike('username', $search);
            $dataset->orLike('email', $search);
            $dataset->orLike('gsecret', $search);
            $dataset->orLike('created_at', $search);
            $dataset->orLike('updated_at', $search);
            $dataset->groupEnd();
        }
        $dataset->where('deleted_at', null);
        return $dataset->countAllResults();
    }
}