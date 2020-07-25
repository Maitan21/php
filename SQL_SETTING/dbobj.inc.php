<?php 
/*
=======================================================================================
= ** ++++                   ++++              ++++            ++++         ++++                   ++++        +++++    ++++ ** =
= ** ++++      ++++++++++++++++     ++++      +     +++     +    ++++++++    ++++++++    +    ++++    ++++  ** =
= ** ++++      ++++++++++++++++     ++++      ++    ++    ++    ++++++++    ++++++++    ++    +++    ++++ ** =
= ** ++++      ++++      ++++              ++++     +++    +   +++    ++++++++    ++++++++    +++    ++    ++++ ** =
= ** ++++      ++++      ++++       ++++++++     ++++     ++++    ++++++++    ++++++++    ++++    +    ++++ ** =
= ** ++++                   ++++              ++++     +++++++++++    ++++                  ++++    +++++        ++++ ** =
=======================================================================================
= @function       	: 데이터베이스 연결 설정 
= @file name	   	: dbobj.inc.php
= @program by   	: kikiv        
= @description		: 데이터베이스 연결 설정 관련 유틸 
=======================================================================================
*/

class ScSql
{
	var $pdo = null;
	var $isSqlDumpMode = false;
	var $lastPdoStatement = null;
	var $isTransactionOn = false;

	var $driver = null;
	var $host = null;
	var $port = null;
	var $id = null;
	var $pass = null;
	var $dbName = null;
	var $pdoOptions = null;

	/**
	 * 생성자
	 * @param string $driver 드라이버명 (mysql, ...)
	 * @param string $host   DB 서버의 IP 또는 도메인
	 * @param int    $port   DB 서버 포트
	 * @param string $id     DB 로그인 ID
	 * @param string $pass   DB 로그인 비밀번호
	 * @param string $dbName 기본 DB schema 명
	 */
	function __construct($driver = null, $host = null, $port = null, $id = null, $pass = null, $dbName = null)
	{
		global $__config;
		
		
		$this->driver = $driver ? $driver : $__config["dbDriver"];
		$this->host   = $host ? $host : $__config["dbHost"];
		$this->port   = $port ? $port : $__config["dbPort"];
		$this->id     = $id ? $id : $__config["dbId"];
		$this->pass   = $pass ? $pass : $__config["dbPassword"];
		$this->dbName = $dbName ? $dbName : $__config["dbName"];

		$options                               = array();
		$options[PDO::ATTR_ERRMODE]            = PDO::ERRMODE_EXCEPTION;
		$options[PDO::ATTR_DEFAULT_FETCH_MODE] = PDO::FETCH_ASSOC;
		// $options[PDO::ATTR_EMULATE_PREPARES]는 connect()에서 설정

		$this->pdoOptions = $options;
	}

	/**
	 * 유일한 ScSql 오브젝트 얻기
	 * @return ScSql
	 */
	static function getConnection()
	{
		global $__commonScSql;

		if (!$__commonScSql) {
			$__commonScSql = new ScSql();
		}

		return $__commonScSql;
	}

	/**
	 * 에러코드 얻기 PDO::errorCode와 동일
	 * @link http://kr1.php.net/manual/en/pdo.errorcode.php
	 * @return mixed
	 */
	function errorCode()
	{
		//return iconv("euc-kr", "utf-8", mysql_error());
		return $this->dbo->errorCode();
	}

	/**
	 * 에러정보 얻기 PDO::errorInfo와 동일
	 * @link http://kr1.php.net/manual/en/pdo.errorinfo.php
	 * @return mixed
	 */
	function errorInfo()
	{
		//return iconv("euc-kr", "utf-8", mysql_error());
		return $this->dbo->errorInfo();
	}

	/**
	 * 에러 메시지 얻기
	 * @return string 에러메시지. 에러가 없을 경우 null
	 */
	function getMessage()
	{
		$error = $this->dbo->errorInfo();

		if (is_array($error))
			return $error[2];
		else
			return null;
	}

	/**
	 * DB 접속
	 * @return bool 접속 성공 여부
	 */
	function connect()
	{
		try {
			$dsn       = $this->driver . ":host=" . $this->host . ";dbname=" . $this->dbName . ";port=" . $this->port;
			$this->pdo = new PDO($dsn, $this->id, $this->pass, $this->pdoOptions);

			$serverVersion                       = $this->pdo->getAttribute(PDO::ATTR_SERVER_VERSION);
			$options[PDO::ATTR_EMULATE_PREPARES] = version_compare($serverVersion, "5.1.17", "<");

			$this->pdo->query("SET NAMES 'utf8'");

			/*$this->conn->query("SET NAMES '" . $__config['encoding'] . "'");
			$this->conn->query("SET CHARACTER SET '" . $__config['encoding'] . "'");
			$this->conn->query("SET CHARACTER_SET_RESULTS = '" . $__config['encoding'] . "'");
			$this->conn->query("SET CHARACTER_SET_CLIENT = '" . $__config['encoding'] . "'");
			$this->conn->query("SET CHARACTER_SET_CONNECTION = '" . $__config['encoding'] . "'");
			$this->conn->query("SET CHARACTER_SET_DATABASE = '" . $__config['encoding'] . "'");
			$this->conn->query("SET CHARACTER_SET_SERVER = '" . $__config['encoding'] . "'");*/

			unset($this->driver);
			unset($this->host);
			//unset($this->dbName);
			unset($this->id);
			unset($this->pass);
		} catch (PDOException $e) {
			
			
//연결 정보 노출 하면 안됨.			
//			echo $e;
echo  $_SERVER['REMOTE_ADDR'];

			if( $_SERVER['REMOTE_ADDR'] == "112.148.205.53" ) {
				echo $e;
			}
			
			$this->pdo = null;

			// DB가 연결 안 된 상태이기 때문에 로그를 남길 수 없다.
			die ("DB 연결 에러");
			//alert("DB 연결 에러");
			return false;
		}

		return true;
	}

	/**
	 * DB 연결해제
	 */
	function disconnect()
	{
		if (!$this->pdo) return;

		$this->pdo = null;
	}

	/**
	 * escape & 따옴표 처리
	 * @param $str
	 * @return mixed
	 */
	function quote($str)
	{
		return $this->pdo->quote($str);
	}

	//	/**
	//	 * 실제 PDO 얻기
	//	 * @return PDO PDO 오브젝트 리턴
	//	 */
	//	function getPDO()
	//	{
	//		return $this->pdo;
	//	}

	/**
	 * PDO의 prepare와 동일. ScSql의 query, execute를 쓰고 싶지 않고 PDO의 기능을 모두 쓰고 싶을때 사용
	 * @param       $query
	 * @param array $driver_options
	 * @return mixed
	 */
	function prepare($query, $driver_options = array())
	{
		try {
			$result = $this->pdo->prepare($query, $driver_options);

			$this->lastPdoStatement = $result;
			return $result;
		} catch (Exception $e) {
			//system_error_log("db.obj.php", "QE", "prepare()시 오류 발생", $e->getMessage());
			throw $e;
		}
	}

	/**
	 * SELECT 등의 테이블을 결과로 출력하는 쿼리 호출
	 *
	 * 사용예)
	 *    방법 1) ? 와 배열 사용
	 *            $rs = $db->query("SELECT * FROM member WHERE id = ? AND password = ?", array($id, $pw));
	 *    방법 2) named parameter와 해시배열 사용
	 *            $rs = $db->query("SELECT * FROM member WHERE id = :id AND password = :id", array("id" => $id, "pw" => $pw));
	 *            while ($row = $rs.fetch()) {
	 *                echo $row['id'];
	 *            }
	 *
	 * !!주의사항!!
	 * 1. $query에 바로 php변수를 넣지 말것
	 *    bad) $db->query("SELECT * FROM member WHERE id = '$id' AND password = '$pw'");
	 *    good) $db->query("SELECT * FROM member WHERE id = ? AND password = ?", array($id, $pw));
	 * 2. insert, update, delete 구문에는 사용하지 말 것
	 * 3. $rs = $db->query("..."); 의 결과에서 $rs->rowCount()는 SELECT 된 행의 수를 리턴하지 않는다.
	 *      알고싶다면 COUNT(*)쿼리를 보내거나 $rs->fetchAll()로 결과값을 모두 배열로 받은 다음 배열의 크기를 갖고 계산
	 * @param       $query  쿼리
	 *                      ex) "SELECT * FROM member WHERE uid = ? AND level = ? AND status = ?"
	 *                      ex) "SELECT * FROM member WHERE id = :id AND password = :pw"
	 * @param array $_params 파라메타
	 *                      ex) array(1,2,3) or array("id" => $admin, "pw" => $adminpw)
	 * @return ScSqlResult or PDOStatement 개발모드일때는 ScSqlResult를 리턴함. fetch(), fetchAll(), fetchColumn() 등을 사용해서 실제 값을 얻는다.
	 */
	function query($query, $_params = null, $page = null, $rows_per_page = null)
	{
		global $_page;

		if ($page !== null) {
			if ($rows_per_page === null) {
				$rows_per_page = $_page["rows_per_page"];
			}

			$query .= " LIMIT " . (($page - 1) * $rows_per_page) . ", " . $rows_per_page;
		}

		try {
			if ($_params == null) {
				$result = $this->pdo->query($query);
			} else {
				$result = $this->pdo->prepare($query);
				$result->execute($_params);
			}
		} catch (Exception $e) {
			//system_error_log("db.obj.php", "QE", "query()시 에러발생", $e->getMessage());

			throw $e;
		}

		$this->lastPdoStatement = $result;

		if (!$result) {
			return new ScSqlResult(null);
		}

		/**if (_DEVELOPMENT) {
			return new ScSqlResult($result);
		} else {
			return $result;
		}**/
		return $result;
	}

	/**
	 * SELECT 쿼리로 한 행만 얻을 때 사용
	 * 해시로 바로 행의 값이 넘어옴
	 *
	 * !!!주의!!!
	 * 결과가 없을시 비어있는 해시배열을 리턴함에 주의
	 *
	 * ex) $row = $db->queryOneRow("SELECT * FROM member WHERE uid = 1"); echo $row['name'];
	 * @param string $query  ScSql::query의 $query 파라메터 참조
	 * @param array $_params ScSql::query의 $_params 파라메터 참조
	 * @return array 쿼리의 결과가 해시배열로 리턴되며 첫 행의 값만 리턴됨
	 */
	function queryOneRow($query, $_params = null)
	{
		try {
			$rs     = $this->query($query, $_params);
			$result = $rs->fetch();
			$rs->closeCursor();
		} catch (Exception $e) {
			//system_error_log("db.obj.php", "QE", "queryOneRow()시 에러발생", $e->getMessage());
			throw $e;
		}

		return $result ? $result : array();
	}

	/**
	 * SELECT 쿼리로 첫 행의 첫 번째 컬럼값만 얻을 때 사용
	 * ex) $count = $db->queryOneRow("SELECT COUNT(*) FROM member WHERE uid = 1"); echo $count;
	 * @param string $query  ScSql::query의 $query 파라메터 참조
	 * @param null $_params ScSql::query의 $_params 파라메터 참조
	 * @throws Exception
	 * @return mixed 첫 행의 첫 번째 컬럼값
	 */
	function queryValue($query, $_params = null)
	{
		try {
			$rs     = $this->query($query, $_params);
			$result = $rs->fetchColumn(0);
			$rs->closeCursor();
		} catch (Exception $e) {
			//system_error_log("db.obj.php", "QE", "queryValue()시 에러발생", $e->getMessage());

			throw $e;
		}

		return $result;
	}

	/**
	 * INSERT, UPDATE, DELETE 등의 쿼리를 실행하겨 결과로 영향받은 행 수를 리턴
	 *
	 * 사용예)
	 *    방법 1) ? 와 배열 사용
	 *            $affectedRowCount = $db->execute("DELETE FROM member WHERE id = ? AND password = ?", array($id, $pw));
	 *    방법 2) named parameter와 해시배열 사용
	 *            $affectedRowCount = $db->execute("INSERT INTO member (id, password) VALUES (:id, :pw)", array("id" => $id, "pw" => $pw));
	 *
	 * !!주의사항!!
	 * 1. $query에 바로 php변수를 넣지 말것
	 *    bad) $db->execute("DELETE FROM member WHERE id = '$id' AND password = '$pw'");
	 *    good) $db->execute("DELETE FROM member WHERE id = ? AND password = ?", array($id, $pw));
	 * 2. SELECT 구문에는 사용하지 말 것. 결과값을 읽을 수 없음
	 * @param       $query  쿼리
	 *                      ex) "UPDATE member SET name = ? WHERE uid = ? AND level = ? AND status = ?"
	 *                      ex) "UPDATE member SET name = :name WHERE id = :id AND password = :pw"
	 * @param array $_params 파라메타
	 *                      ex) array($name, 1,2,3) or array("name" => $name, "id" => $admin, "pw" => $adminpw)
	 * @return int 영향받은 행 수를 리턴
	 */
	function execute($query, $_params = null)
	{
		try {
			if ($_params == null) {
				$count = $this->pdo->exec($query);
			} else {
				$result = $this->pdo->prepare($query);
				$result->execute($_params);

				// PDOStatement::rowCount()가 SELECT한 행 수를 리턴할지는 드라이버에 따라 다르므로 해당 용도로는 쓸 수 없다.
				$count = $result->rowCount();
			}
		} catch (Exception $e) {
			//system_error_log("db.obj.php", "QE", "execute()시 에러발생", $e->getMessage());

			throw $e;
		}

		$this->lastPdoStatement = null;
		return $count;
	}

	/**
	 * INSERT 쿼리에서 자동생성된 (AUTOINCREMENT) 값 얻기
	 *
	 * Postgresql과 같은 DB는 $sequenceName에 시퀸스명을 주어야 한다.
	 * @param null $sequenceName 시퀸스명. mysql에서는 넣을 필요 없음
	 * @return mixed 자동생성된 값
	 */
	function lastInsertId($sequenceName = null)
	{
		return $this->pdo->lastInsertId($sequenceName);
	}

	function insert($tableName, $columnValuePairs)
	{
		if (!is_array($columnValuePairs)) {
			//system_error_log($tableName, "QE", "insert()시 에러발생", "insert 호출시 값을 해시 배열로 넘겨주세요.");
			die("INSERT 실패 => " . "값을 해시 배열로 넘겨주세요.");
		}

		$query   = "INSERT INTO " . $tableName . " SET ";
		$isFirst = true;

		foreach (array_keys($columnValuePairs) as $column) {
			if ($isFirst) {
				$isFirst = false;
			} else {
				$query .= ", ";
			}

			$query .= "`" . $column . "` = :" . $column;
		}

		try {
			return $this->execute($query, $columnValuePairs);
		} catch (Exception $e) {
			//system_error_log($tableName, "QE", "insert()시 에러발생", $e->getMessage());
			throw $e;
		}
	}

	function update($tableName, $where, $columnValuePairs)
	{
		if (!is_array($columnValuePairs)) {
			//system_error_log($tableName, "QE", "update()시 에러발생", "update 호출시 컬럼명과 값을 배열로 넘겨주세요.");
			die("UPDATE 실패" . "컬럼명과 값을 배열로 넘겨주세요.");
		}

		$query = "UPDATE " . $tableName . " SET ";

		$_where_items = array();
		if (preg_match_all('/:(\w+)/', $where, $matches)) {
			foreach ($matches[1] as $_where_item) {
				$_where_items[$_where_item] = true;
			}
		}

		$isFirst = true;
		foreach (array_keys($columnValuePairs) as $column) {
			if (isset($_where_items[$column])) {
				// $where에서 사용된 항목들은 update 항목에서 제외
				continue;
			}

			if ($isFirst) {
				$isFirst = false;
			} else {
				$query .= ", ";
			}

			$query .= "`" . $column . "` = :" . $column;
		}

		if ($where != '') {
			$query .= ' WHERE ' . $where;
		}

		try {
			return $this->execute($query, $columnValuePairs);
		} catch (Exception $e) {
			//system_error_log($tableName, "QE", "update()시 에러발생", $e->getMessage());

			throw $e;
		}
	}

	function setSqlDumpMode($isSqlDumpMode = false)
	{
		$this->isSqlDumpMode = $isSqlDumpMode;
	}



	function begin_tran()
	{
		if ($this->isTransactionOn) {
			$this->rollback();

			//system_error_log("DB", "QE", "begin_tran()시 에러발생", "이미 트랜잭션이 진행중입니다.");
			die ("BEGIN TRAN 실패" . "이미 트랜잭션이 진행중입니다.");
		}

		$this->isTransactionOn = true;
		$this->pdo->beginTransaction();
	}

	function commit()
	{
		$this->isTransactionOn = false;
		$this->pdo->commit();
	}

	function rollback()
	{
		$this->isTransactionOn = false;
		$this->pdo->rollback();
	}
}

/**
 * Class ScSqlResult
 * 개발 모드에서만 사용. 실제 서버에서는 사용하지 않고 PDOStatement를 사용한다.
 * 기본적으로 PDOStatement를 그대로 사용하며 실제 사용하는 함수만 등록한다.
 * 또한 PDOStatement에 없는 함수는 만들지 않는다!
 */
class ScSqlResult
{
	var $statement = null;

	function __construct($statement)
	{
		$this->statement = $statement;
	}

	function bindColumn($column, &$param, $type = null, $maxlen = null, $driverdata = null)
	{
		return $this->statement->bindColumn($column, $param, $type, $maxlen, $driverdata);
	}

	function bindParam($parameter, &$variable, $data_type = PDO::PARAM_STR, $length = null, $driver_options = null)
	{
		return $this->statement->bindParam($parameter, $variable, $data_type, $length, $driver_options);
	}

	function bindValue($parameter, $value, $data_type = PDO::PARAM_STR)
	{
		return $this->statement->bindValue($parameter, $value, $data_type);
	}

	function closeCursor()
	{
		if ($this->statement == null) return null;
		return $this->statement->closeCursor();
	}

	function columnCount()
	{
		if ($this->statement == null) return 0;
		return $this->statement->columnCount();
	}

	function debugDumpParams()
	{
		if ($this->statement == null) return null;
		return $this->statement->debugDumpParams();
	}

	function errorCode()
	{
		if ($this->statement == null) return 0;
		return $this->statement->errorCode();
	}

	function errorInfo()
	{
		if ($this->statement == null) return "";
		return $this->statement->errorInfo();
	}

	function execute($input_parameters = null)
	{
		return $this->statement->execute($input_parameters);
	}

	/**
	 * PDOStatement->fetch() 자체에는 여러 옵션이 있지만 사용을 불허한다.
	 * @return mixed
	 */
	function fetch()
	{
		if ($this->statement == null) return null;
		return $this->statement->fetch();
	}

	/**
	 * PDOStatement->fetchAll() 자체에는 여러 옵션이 있지만 사용을 불허한다.
	 * @return mixed
	 */
	function fetchAll()
	{
		if ($this->statement == null) return null;
		return $this->statement->fetchAll();
	}

	function fetchColumn($column_number)
	{
		if ($this->statement == null) return null;
		return $this->statement->fetchColumn($column_number);
	}

	/**
	 * SELECT 문의 결과에는 사용하지 않기
	 * @return mixed
	 */
	function rowCount()
	{
		if ($this->statement == null) return 0;
		return $this->statement->rowCount();
	}

	// 미사용 PDOStatement 함수들
	// function getAttribute() {}	// no generic attributes exist but only driver specific
	// function setAttribute() {}	// no generic attributes exist but only driver specific
	// function getColumnMeta() {}	// This function is EXPERIMENTAL. The behaviour of this function, its name, and surrounding documentation may change without notice in a future release of PHP. This function should be used at your own risk.
	// function setFetchMode() {}	// 기본으로 셋팅된 fetchmode만 사용
	// function nextRowset() {}		// 여러개의 SELECT 문을 돌려서 여러개의 결과 테이블을 받을때 쓰는 함수인데 이런 용도로는 쓰지 않기로 함

	/*
	function toJson($asArray = false)
	{
		global $__config;

		if ($asArray) {
			$rowList = array();

			while (($row = mysql_fetch_row($this->queryResult)) !== false) {
				array_push($rowList, $row);
			}

			return SeJson::encode($rowList, $__config['encoding']);
		} else {
			$rowList = array();

			while (($row = mysql_fetch_assoc($this->queryResult)) !== false) {
				array_push($rowList, $row);
			}

			return SeJson::encode($rowList, $__config['encoding']);
		}
	}
	*/
}
