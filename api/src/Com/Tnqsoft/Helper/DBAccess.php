<?php

namespace Com\Tnqsoft\Helper;

use Com\Tnqsoft\Exceptions\ConnectDatabaseFailException;
use Com\Tnqsoft\Exceptions\QueryFailException;

/**
 * DBAccess class
 *
 * Ý tưởng tạo ra một lớp xử lý kết nối Database và thực hiện các truy vấn trên
 * database tập trung. Sử dụng kế thừa từ đối tượng mysqli của PHP chuẩn
 *
 * @author Nguyễn Như Tuấn <tuanquynh0508@gmail.com>
 * @link https://github.com/tuanquynh0508/phpstore
 * @copyright 2015 I-Designer
 * @license https://github.com/tuanquynh0508/phpstore/license/
 * @package classes
 * @see mysqli
 * @since 1.0
 */
class DBAccess extends \mysqli
{
    /**
     * {@inheritdoc}
     * @throws HttpException Lỗi xảy ra khi không kết nối được database
     */
    public function __construct()
    {
        //Kết nối đến db
        @parent::__construct(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
        //Kiểm tra xem có lỗi không
        if ($this->connect_errno) {
            $message = "Failed to connect to MySQL: (" . $this->connect_errno . ") " . $this->connect_error;
            throw new ConnectDatabaseFailException(500, $message);
        }
        //Set charset là UTF-8, tương đương với câu SET NAMES UTF-8; của mysql
        $this->set_charset("utf8");
    }

    /**
     * {@inheritdoc}
     * Hàm hủy, đóng kết nối tới db khi giải phóng class
     */
    public function __destruct()
    {
        $this->close();
    }

    /**
     * Xóa bản ghi theo id
     *
     * @param string $tableName Tên bảng
     * @param integer $id Id cần xóa
     * @return boolean
     * @throws HttpException Lỗi xảy ra khi không thực hiện được
     */
    public function deleteById($tableName, $id)
    {
        $tableName = DB_TABLE_PREFIX.$tableName;

        $value = false;
        //Tạo câu truy vấn sql xóa
        $sql = "DELETE FROM $tableName WHERE id=$id";
        if ($result = $this->query($sql)) {
            //Lấy ra số bản ghi đã được xóa
            if ($this->affected_rows > 0) {
                $value = true;
            }
        } else {
            throw new QueryFailException(501, "Query error: ".$this->error);
        }

        return $value;
    }

    /**
     * Xóa bản ghi theo trường
     *
     * @param string $tableName Tên bảng
     * @param string $field Field tìm xóa
     * @param string $fieldValue Giá trị tìm xóa
     * @return boolean
     * @throws HttpException Lỗi xảy ra khi không thực hiện được
     */
    public function deleteByField($tableName, $field, $fieldValue)
    {
        $tableName = DB_TABLE_PREFIX.$tableName;

        $value = false;
        //Tạo câu truy vấn sql xóa
        $sql = "DELETE FROM $tableName WHERE $field='$fieldValue'";
        if ($result = $this->query($sql)) {
            //Lấy ra số bản ghi đã được xóa
            $affectedRows = $this->affected_rows;
            if ($affectedRows > 0) {
                $value = true;
            }
        } else {
            throw new QueryFailException(501, "Query error: ".$this->error);
        }

        return $value;
    }

    /**
     * Lấy ra một bản ghi theo Id
     *
     * @param string $tableName Tên bảng
     * @param integer $id Id cần tìm
     * @return object
     * @throws HttpException Lỗi xảy ra khi không thực hiện được
     */
    public function findOneById($tableName, $id)
    {
        $tableName = DB_TABLE_PREFIX.$tableName;

        $record = null;
        //Tạo câu truy vấn sql tìm bản ghi
        $sql = "SELECT * FROM $tableName WHERE id=$id";
        if ($result = $this->query($sql)) {
            //Trả về kết quả dưới dạng object
            $record = $result->fetch_object();
            $result->close();
        } else {
            throw new QueryFailException(501, "Query error: ".$this->error);
        }

        return $record;
    }

    /**
     * Lấy ra một bản ghi theo Slug
     *
     * @param string $tableName Tên bảng
     * @param string $slug Slug cần tìm
     * @return object
     * @throws HttpException Lỗi xảy ra khi không thực hiện được
     */
    public function findOneBySlug($tableName, $slug)
    {
        $tableName = DB_TABLE_PREFIX.$tableName;

        $record = null;
        //Tạo câu truy vấn sql tìm bản ghi
        $sql = "SELECT * FROM $tableName WHERE slug='$slug'";
        if ($result = $this->query($sql)) {
            //Trả về kết quả dưới dạng object
            $record = $result->fetch_object();
            $result->close();
        } else {
            throw new QueryFailException(501, "Query error: ".$this->error);
        }

        return $record;
    }

    /**
     * Lấy ra một bản ghi theo Slug
     *
     * @param string $tableName Tên bảng
     * @param string $slug Slug cần tìm
     * @return object
     * @throws HttpException Lỗi xảy ra khi không thực hiện được
     */
    public function findOneBy($tableName, $criterias)
    {
        $tableName = DB_TABLE_PREFIX.$tableName;

        $wheres = [];
        foreach ($criterias as $field => $criteria) {
            $wheres[] = "{$field}='{$criteria}'";
        }

        $record = null;
        //Tạo câu truy vấn sql tìm bản ghi
        $sql = "SELECT * FROM $tableName WHERE ".implode(' AND ', $wheres);
        if ($result = $this->query($sql)) {
            //Trả về kết quả dưới dạng object
            $record = $result->fetch_object();
            $result->close();
        } else {
            throw new QueryFailException(501, "Query error: ".$this->error);
        }

        return $record;
    }

    /**
     * Lấy giá trị đầu tiên kết quả từ câu truy vấn COUNT, MAX..
     *
     * @param string $sql SQL truyền vào
     * @return string
     * @throws HttpException Lỗi xảy ra khi không thực hiện được
     */
    public function scalarBySQL($sql)
    {
        $value = null;
        if ($result = $this->query($sql)) {
            //Lấy kết quả trả về dưới dạng mảng
            $record = $result->fetch_row();
            //Lấy kết quả đầu tiên trả về
            if (!empty($record[0])) {
                $value = $record[0];
            }
            $result->close();
        } else {
            throw new QueryFailException(501, "Query error: ".$this->error);
        }

        return $value;
    }

    /**
     * Tìm tất cả các bản ghi theo SQL
     *
     * @param string $sql Câu truy vấn
     * @return array
     * @throws HttpException Lỗi xảy ra khi không thực hiện được
     */
    public function findAllBySql($sql)
    {
        $list = array();
        if ($result = $this->query($sql)) {
            //Lấy tất cả các bản ghi dưới dạng object và gán vào mảng trả về
            while ($obj = $result->fetch_object()) {
                $list[] = $obj;
            }
            $result->close();
        } else {
            throw new QueryFailException(501, "Query error: ".$this->error);
        }

        return $list;
    }

    /**
     * Thêm mới hoặc cập nhật bản ghi
     *
     * @param string $tableName Tên bảng
     * @param array $attributes Mảng giá trị thuộc tính
     * @param string $pkName Tên của khóa chính, truyền vào nếu thực hiện cập nhật
     * @return object
     * @throws HttpException Lỗi xảy ra khi không thực hiện được
     */
    public function save($tableName, $attributes, $pkName = null)
    {
        $record = null;
        //Kiểm tra xem có truyền vào tên khóa chính không
        //Nếu không có sẽ là thêm mới, nếu có sẽ là cập nhật
        $isAddNew = (null === $pkName)?true:false;

        if ($isAddNew) {
            //Tạo câu truy vấn thêm mới
            $sql = $this->buildInsertSql($tableName, $attributes);
        } else {
            //Tạo câu truy vấn cập nhật
            $sql = $this->buildUpdateSql($tableName, $attributes, $pkName);
        }

        try {
            //Khởi tạo một transaction
            $this->autocommit(false);

            //Thực hiện truy vấn
            if ($this->query($sql)) {
                if ($isAddNew) {
                    //Nếu thêm mới, thì lấy id mới nhất được thêm vào
                    $insertId = $this->insert_id;
                } else {
                    //Nếu cập nhật sẽ lấy id từ khóa chính truyền vào
                    $insertId = $attributes[$pkName];
                }

                if (0 !== $insertId) {
                    //Lấy ra bản ghi vừa thêm vào, với id
                    $record = $this->findOneById($tableName, $insertId);
                }
            } else {
                throw new QueryFailException(501, "Query error: ".$this->error);
            }

            //Kết thúc transaction
            $this->commit();
            $this->autocommit(true);

            return $record;
        } catch (\Exception $e) {
            //Nếu có lỗi thì rollback lại hết, coi như chưa thực hiện các bước trên
            $this->rollback();
            $this->autocommit(true);
            throw new QueryFailException(501, "Query error: ".$this->error);
        }
    }

    /**
     * Tạo câu truy vấn thêm mới
     *
     * @param string $tableName Tên bảng
     * @param array $attributes Mảng giá trị thuộc tính
     * @return string
     */
    public function buildInsertSql($tableName, $attributes)
    {
        $tableName = DB_TABLE_PREFIX.$tableName;

        //Danh sách các trường, là index của mảng giá trị thuộc tính
        $fields = array_keys($attributes);
        //Danh sách giá trị
        $values = array();

        foreach ($attributes as $value) {
            //Lấy giá trị và thực hiện escape các ký tự đặc biệt trước khi đưa vào sql
            if ($value instanceof \DateTime ) {
                $values[] = "'".$value->format('Y-m-d H:i:s')."'";
            } elseif(is_integer($value) || is_double($value) || is_bool($value) || trim(strtoupper($value)) === 'NOW()') {
                $values[] = $value;
            } else {
                $values[] = "'".$this->real_escape_string($value)."'";
            }
        }

        $sql = "INSERT INTO $tableName(".implode(",", $fields).") ";
        $sql .= "VALUES (".implode(",", $values).")";

        return $sql;
    }

    /**
     * Tạo câu truy vấn cập nhật
     *
     * @param string $tableName
     * @param array $attributes
     * @param string $pkName
     * @return string
     */
    public function buildUpdateSql($tableName, $attributes, $pkName = null)
    {
        $tableName = DB_TABLE_PREFIX.$tableName;

        //Danh sách các trường cập nhật
        $fields = array();

        foreach ($attributes as $key => $value) {
            if ($key !== $pkName) {
                //Lấy giá trị và thực hiện escape các ký tự đặc biệt trước khi đưa vào sql
                $field = $key."=";
                if ($value !== '') {
                    if ($value instanceof \DateTime ) {
                        $field .= "'".$value->format('Y-m-d H:i:s')."'";
                    } elseif(is_integer($value) || is_double($value) || is_bool($value) || trim(strtoupper($value)) === 'NOW()') {
                        $field .= $value;
                    } else {
                        $field .= "'".$this->real_escape_string($value)."'";
                    }
                } else {
                    $field .= 'NULL';
                }
                $fields[] = $field;
            }
        }

        $wheres = [];
        $pks = explode(',', $pkName);
        foreach ($pks as $pk) {
            $wheres[] = trim($pk)."='".$attributes[trim($pk)]."'";
        }

        $sql = "UPDATE $tableName SET ".implode(', ', $fields)." WHERE ".implode(' AND ', $wheres);

        return $sql;
    }
}
