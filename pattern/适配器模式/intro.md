# 适配器模式

### 定义：
将已有的接口转换成客户端期望的接口，适配器使得原本由于接口不兼容而不能一起工作的一些类可以在一起工作。

### 角色
* **Target:** Client期望的接口。
* **Adaptee:** 已有的接口。通常能够满足客户端的需求，但是与客户端期望的接口有一定的出入，所以需要适配器来适配。
* **Adapter:** 实现Target接口，将Adpatee里的功能适配成Client需要的Target。



##认识适配器模式
1. **目的**  
主要功能是进行转换匹配,复用已有功能而不是新增功能。(但这并不是说适配器里就不能实现功能，一般实现功能的适配器叫智能适配器)
2. **Adaptee和Target之间的关系**  
可以理解成Adaptee是源,要把他转换成Target。是他们之间是没有任何关联。也就是说Adaptee和Target中的方法既可以相同也可以不同。  
极端情况下可能是完全相同的(这种时候的适配工作量较小的)。另一种极端情况下是完全不同的(这种时候适配工作量要大一些。)
这里说的相同与否包括 方法名、参数列表、返回值 以及方法本身的功能等。

### 举例
PHP操作mysql数据库一般有mysql、mysqli、pdo3种方式。但是这3种方式的接口不一致,所以可以用适配器统一成一致的接口。
类似的场景还有cache类 memcache,redis,apc等不同的函数统一成一致。还有日志系统由文件存储转换成db等其他的情况。
这里用rango教程中的 mysql链接举例.

先定义出客户端期望的接口 Target
```php
interface IDatabase {
    function connect($host, $user, $pwd, $dbname);
    function query($sql);
    function close();
}
```

下面就来实现约定的接口 这里实现3个Adapter 分别是Mysql/Mysqli/PDO.而Adaptee原有功能是PHP自带的所以这里就不展示了。
当然这里到底选择哪个Adapter对象 可以结合工厂模式来创建。
```php
Class Mysql implements IDatabase {
    protected $conn;
    function connect($host, $user, $pwd, $dbname) {
        $conn = mysql_connect($host, $user, $pwd);
        mysql_select_db($dbname, $conn);
        $this->conn = $conn;
    }

    function query($sql) {
        $res = mysql_query($sql, $this->conn);
        return $res;
    }

    function close() {
        mysql_close($this->conn);
    }
}

Class Mysqli implements IDatabase {
    protected $conn;
    function connect($host, $user, $pwd, $dbname) {
        $conn = mysqli_connect($host, $user, $pwd, $dbname);
        $this->conn = $conn;
    }

    function query($sql) {
        $res = mysqli_query($this->conn, $sql);
        return $res;
    }

    function close() {
        mysql_close($this->conn);
    }
}

Class PDO implements IDatabase {
    protected $conn;
    function connect($host, $user, $pwd, $dbname) {
        $conn = new \PDO("mysql:host={$host};dbname={$dbname}", $user, $pwd);
        $this->conn = $conn;
    }

    function query($sql) {
        return $this->conn->query($sql);
    }

    function close() {
        unset($this->conn);
    }
}
```

