# 适配器模式

### 定义：
将已有的接口转换成客户端期望的接口，适配器使得原本由于接口不兼容而不能一起工作的一些类可以在一起工作。

### 角色
* **Target:** Client期望的接口。
* **Adaptee:** 已有的接口。通常能够满足客户端的需求，但是与客户端期望的接口有一定的出入，所以需要适配器来适配。
* **Adapter:** 实现Target接口，将Adpatee里的功能适配成Client需要的Target。



## 认识适配器模式
1. **目的**  
主要功能是进行转换匹配,复用已有功能而不是新增功能。(但这并不是说适配器里就不能实现功能，一般实现功能的适配器叫智能适配器)
2. **Adaptee和Target之间的关系**  
可以理解成Adaptee是源,要把他转换成Target。是他们之间是没有任何关联。也就是说Adaptee和Target中的方法既可以相同也可以不同。  
极端情况下可能是完全相同的(这种时候的适配工作量较小的)。另一种极端情况下是完全不同的(这种时候适配工作量要大一些。)
这里说的相同与否包括 方法名、参数列表、返回值 以及方法本身的功能等。

## 优点与缺点
### 优点
1. **更好的复用性**  
如果优点已经有了,只是与现有的接口不兼容。那么可以用适配器让这些已有功能得到更好的复用。
2. **更好的扩展性**  
实现适配器功能的时候，可以调用自己的开发的功能。从而更好的扩展了系统功能。  

### 缺点
* 过多的使用适配器，**会让系统非常零乱，不容易整体把控**  
比如明明看见是调用A接口，但实际上被适配成了B接口来实现。一个系统如果到处都是这种情况，无异于一场灾难。  
个人感觉适配器应该是封装在底层的，让上层的业务逻辑感知不到。

## 思考
1. 适配器模式的本质 **转换匹配，复用功能**
2. 何时选用适配器  
>
* 如果您想要使用一个已经存在的类,但是他的接口不符合您的需求，可以考虑用适配器来把已有接口转换成你需要的接口。  
* 如果您想创建一个可复用的类,这个类可能和一些不兼容的类一起工作，可以考虑适配器模式，需要什么就适配什么。  
* 如果您想使用一些已有的子类，但是子类太多，为避免每个子类都要适配，可直接适配父类。(说实话:这个场景我没太理解,如果子类里的功能是新增的不是父类有的呢)  


## 相关模式

* 适配器与桥接模式的区别  
这两个模式除了结构相似外，功能上完全不同。  
适配器是把两个以上接口功能进行转化匹配，而桥接模式是让接口和实现分离，以便他们可以相对独立的变化。
* 适配器与装饰模式的区别  
```php
function adapterA() {
    echo "调用前的一些处理 \n";
    adaptee->A();
    echo "调用后的一些处理 \n";
    }
```
上面代码看上去有点像装饰模式。因为这种适配后就不仅仅是单纯的调用adaptee的功能了。(智能适配器?)
两种模式在实现上都是使用的对象组合，都可以在转调对象的功能前后进行一些附加的处理。因此有些相似，但是他们的本质和目的是不一样的。
两种模式最大的区别：一般适配器适配后是要改变接口的，如果不用改变就没必要适配了；而装饰模式是不改变接口的，无论多少层装饰都是一个接口。因此装饰模式支持递归组合，而适配器就做不到，每次接口不同无法递归。
* 适配器和代理模式的组合  
在实现适配器的时候，可以通过代理来调用Adaptee，这样可获得更大的灵活性。
* 适配器和工厂的组合  
通常要得到一个被适配的对象，可以结合一些创建型的模式来得到被适配的对象。如抽象工厂，工厂方法，单例等。


### 举例
1. PHP操作mysql数据库一般有mysql、mysqli、pdo3种方式。但是这3种方式的接口不一致,所以可以用适配器统一成一致的接口。  
2. 类似的场景还有cache类 memcache,redis,apc等不同的函数统一成一致。  
3. 还有日志系统由文件存储转换成db等其他的情况。  
这里用[rango教程](http://www.imooc.com/video/4904)中的 mysql链接举例.

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

