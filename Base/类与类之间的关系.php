<?php 
/**
* 类与类之间一般存在以下几种关系 所谓的耦合也就是指的这几种关系吧?
* 继承、关联、依赖、聚合、组合   一直对泛化这个概念不太了解
*/

/**
 * 继承一般是指子类继承父类,子类可以使用父类已经实现的 public 及 proteced的方法，也可以增加自己新的方法。
 * 这个大家应该都很熟悉
 */
class Animal{
    public function run() {
        echo "\n Animal running!";
    }
}

class Horse extends Animal {
    public function eat() {
        echo "\n Animal Horse eat!";
    }
}

/**
 * 下面来聊聊依赖:两个相对独立的类有调用关系 或者依赖于另一个对象的方法/属性,
 * 就是一个类A使用到了另一个类B，而这种使用关系是具有偶然性的、临时性的、非常弱的，但是B类的变化会影响到A
 * [具体表现]
 * 依赖关系表现在局部变量，方法的参数，以及对静态方法的调用
 * [例子]
 * 如人想在草原上快速移动,
 * 我们选择了骑马的方式,那就需要马的对象.这就是依赖于马了。
 * 当然你也可以选择车，那就依赖车了
 */
class Human {
    /**
     * moveOnGrassland  在草原上奔跑
     * 依赖例子使用
     * @date 2014-10-31
     * @param Animal $horse 
     * @access public
     * @return void
     */
    public function moveOnGrassland(Animal $horse) {
        $horse->run();
    }

    /**
     * startWorking 
     * 开始工作 聚合例子中使用
     * @date 2014-10-31
     * @access public
     * @return void
     */
    public function startWorking() {
        echo "\n start Working";
    }
}
$h = new Human();
$h->moveOnGrassland(new Horse());




/**
 * 关联:一个类的实例 与另一个类的 一些特定实例存在某种对应关系。关联可以单向/双向
 * [具体表现]
 * 关联关系一般 使用实例变量来实现
 * [举例]
 * 1、客户 与订单类 一个客户可以产生多个订单,订单类里应该有一个客户id 这样的对应关系。
 * 2、学生 与考试成绩 一个学生有很多科目的考试成绩, 考试成绩表里 应该有个学生id
 * 个人感觉类似 有明确关系 一对多  多对多  那种可以联表查询的就可以叫做关联。
 * 但是这种关系比依赖要强 但是比聚合 和 组合要弱,
 * 我觉得关联是再多的Order也组成不了Custom,也就是说他们之间的关系不是整体与部分的关系
 */
class Customer {
    private $_id;
    public function __construct($id) {
        $this->_id = $id;
    }

    /**
     * getInfo  获得客户信息
     * 
     * @date 2014-11-04
     * @access public
     * @return void
     */
    public function getInfo() {
        return array(
            'name'=>'customer1',
            'age'=>18
        );
    }
}

// 这里是单向关联  
class Order {
    private $_custom;    // 客户对象 当然我们这里依赖了客户对象，这种耦合程度是比较高的。

    public function __construct() {
        $this->_custom = new Customer();
    }

    public function getCustomInfo(){
        $info = $this->_custom->getInfo();
        echo "\n Order 关联 Customer ";
        return $info;
    }
}

/**
 * 聚合:是一种强关联,属于一种特殊的关联.是指整体与部分的关系,一般定义一个整体类,再分析整体类的组成结构.
 * 从而找出一些组成类,这个整体类与这些组成类的关系就是聚合关系.一般"包含","组成","分为...部分" 常意味着聚合.
 * 但是这里的组成类,不在整体类里也可以独立运行. 而组合的关系比聚合更强一些.组合整体与部分生命周期是一致的。
 *
 * [举例]
 * 员工与公司,员工可以离开公司独立存在.
 * 雁群于大雁,大雁离开雁群也可以独立存在不会受到任何影响.
 * 电脑与配件,内存离开电脑也是正常的 该是多少G还是多少G.
 */

class Company {
    private $_human;

    function setHuman($human) {
        $this->_human = $human;
    }
    //  上班
    public function run() {
        $this->_human->startWorking();
    }
}

$obj = new Company();
$obj->setHuman(new Human());
$obj->run();



/**
 * 组合:比聚合关系更强的一种关联,部分的生命周期不能超越整体，或者说不能脱离整体而存在。
 * 组合关系的"部分"是不能在整体之间进行共享的。
 * 与聚合的相同点在于 他们都属于关联,整体与部分的关系。
 * 不同点在于:生命周期不同,聚合是独立的。不随整体共存亡。组合相反,与整体共存亡。
 * 话说我认为这样是一种强耦合啊,为什么还有很多设计模式说组合比继承好呢?
 *
 * [举例]
 * 人用腿跑,用手拿东西,如果人挂了 他的手 和 腿也就没用了。(当然如今的科技能让刚挂的人 移植器官，这不在讨论范畴。)
 *
 */
class Leg {
    function run() {
        echo "Use leg run ....\n";
    }
}
class Handle {
    function hold() {
        echo "Use handle hold...\n";
    }
}
class Person {
    private $handle;
    private $leg;

    function __construct() {
        $this->handle = new Handle();
        $this->leg = new Leg();
    }

    function hold() {
        $this->handle->hold();
    }

    function run() {
        $this->leg->run();
    }
}
$obj = new Person();
$obj->run();
$obj->hold();


 ?>
