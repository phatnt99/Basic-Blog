<?php
class DB
{
    //properties
    
    private $hostname ='localhost';
    private $username='root';
    private $password='';
    private $dbname='newspaper';

    public $conn = NULL;
    public $rs = NULL;

    //methods

    public function connectDB()
    {
        $this->conn = mysqli_connect($this->hostname,$this->username,$this->password,$this->dbname);
        mysqli_set_charset($this->conn,"UTF8");
    }

    public function disconnectDB()
    {
        if($this->conn)
        {
            mysqli_close($this->conn);
        }
    }

    public function query($sql=NULL)
    {
        if($this->conn)
        {
            mysqli_query($this->conn,$sql);
        }
    }

    public function num_rows($sql=null)
    {
        if($this->conn)
        {
            $query =mysqli_query($this->conn,$sql);
            $row = mysqli_num_rows($query);
            return $row;
        }
    }

    //hàm lấy dữ liệu từng hàng
    public function fetch_assoc($sql=null,$type)
    {
        if($this->conn)
        {
            $query =mysqli_query($this->conn,$sql);
            if($type == 0)
            {
                while($row = mysqli_fetch_assoc($query))
                {
                    $data[] = $row;
                }
                return $data;
            } else if($type == 1)
            {
                $data = mysqli_fetch_assoc($query);
                return $data;
            }
        }
    }

    //xử lí chuỗi dữ liệu truy vấn - tránh SQL injection
    public function real_escape_string($string)
    {
        if($this->conn)
        {
            $string = mysqli_real_escape_string($this->conn,$string);
        }
        else
        {
            $string = $string;
        }
        return $string;
    }

    public function insert_ID()
    {
        if($this->conn)
        {
            return mysqli_insert_id($this->conn);
        }
    }
}

?>