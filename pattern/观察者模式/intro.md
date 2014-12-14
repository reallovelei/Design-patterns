# 观察者模式
------------
### 定义
定义对象间的一种一对多的关系，被观察的对象的状态发生改变时，所有依赖于他的对象(观察者)都会得到通知并被自动更新。

### 角色
* **Subject**: 目标对象，通常有如下功能：
> 1. 一个目标可以被多个观察者观察。
2. 目标提供观察者的注册和退订的维护(即对观察者对象队列的维护)。
3. 当目标状态发生改变时，负责通知所有注册的、有效的观察者。

* **Observer**: 定义观察者，
* **ConcreteSubject**: 具体的目标实现对象，
* **ConcreteObserver**: 定义具体观察者对象，

## 认识观察者模式

1. **功能**  
在事件发生后，目标对象通知所有符合规则 的观察者进行更新操作。并将事件与事件发生后的更新代码独立开来。
2. **单向依赖**  
观察者都是依赖于目标的，目标是不会依赖于观察者的。观察者一般都是被动等待目标的通知。
3. **基本实现说明**  
>> * 具体的目标对象要维护观察者的注册信息
* 具体的目标对象需要维护引起通知的状态(触发时机)。
4. **命名建议**  
5. **触发通知的时机**  
6. **相互观察**  

## 优点与缺点
### 优点
1. 将事件与事件发生后的更新代码独立开来。实现了观察者和目标之间的抽象耦合。  

2. 实现了动态联动  
3. **观察者模式支持广播通信** 

### 缺点
1. **可能会引起无谓的操作**

## 思考
1. 对设计原则的体现  

2. 何时选用观察者模式(场景)  
一个事件发生后，要执行一连串的更新操作。传统的编程方式就是在事件的代码之后直接加入处理逻辑。当更新的逻辑增加之后，代码会变的难以维护。这种方式的耦合的，侵入式的。增加新的逻辑需要修改事件主体的代码。
3. **如果观察者里的操作基本一致,如三八节找出所有的女性用户其账户里增加10元，岂不是一种资源浪费？如果不用模式 则一条sql语句搞定，如果用了则需要很多条语句来实现**。这是我个人的疑问 这种场景 是不是就不应该用模式 或者说是滥用模式了。


## 相关模式
* 观察者模式和状态模式的区别与结合  
观察者和状态有相似之处，观察者是当目标状态发生改变时，触发并通知观察者。让观察者去执行相应操作。  
状态模式是根据不同的状态选择不同的实现类。这个实现类的具体功能就是针对状态相应的操作。它不像观察者，观察者本身还有很多其他的功能，接收通知并执行相应处理只是观察者的部分功能。  
当然两者也可以结合使用，观察者的核心是在于触发联动。但是到底哪些观察者会被调用可以结合状态/策略来实现了。如三八妇女节只调用女性用户观察者。  

* 观察者和中介者的组合
例子中只是单纯的介绍了观察者的最简单使用场景，目标只是简单的通知观察者，所有符合规则的观察者简单调用更新方法。如果观察者和被观察者之间的关系很复杂可能用到中介者模式。如三级联动菜单。

## 举例
1. 读者订阅报刊。现在的微信关注公众号。
2. 代码以[rango教程](http://www.imooc.com/video/5037)为示例。后期会加入其它相对完整的。
3. 

先来定义策略接口(即角色 Strategy)
```php
Interface UserStrategy {
    function showAd();  //显示广告
    function showCategory();   //展示类目
    }
```
接下来要实现接口定义的算法/行为。(即角色 ConcreteStrategy)
```php
// 针对女性用户的具体策略实现
Class FemaleUserStrategy implements UserStrategy {
    function showAd() {
        echo "2014新款女装 \n";
    }

    function showCategory() {
        echo "女装 \n";
    }
}

// 针对男性用户的具体策略实现
Class MaleUserStrategy implements UserStrategy {
    function showAd() {
        echo "iPhone \n";
    }

    function showCategory() {
        echo "电子产品 \n";
    }
}
```

下面来实现上下文角色
```php
Class Context {
    private $_strategy;
    funciont setStrategy(Strategy $strategy) {
        $this->_strategy = $strategy;
    }

    function run () {
        echo "AD:";
        $this->strategy->showAd();
        echo "\n";
        
        echo "Category:";
        $this->strategy->showCategory();
        echo "\n";

    }
}

```
接下来是客户端 根据具体情况创建不同的具体策略类的对象。可以结合创建型模式来创建策略对象。
```php
if (isset($_GET['female'])) {
    $strategy = new FemaleUserStrategy();
} else {
    $strategy = new MaleUserStrategy();
}
$context = new Context();
$context->setStrategy($strategy);
$context->run();
```

Rango最后说的那段[IOC和DI](https://github.com/reallovelei/Design-patterns/blob/master/Base/IOC.md) 指的估计也就是以上这段吧。
将具体策略对象注入到上下文中。

