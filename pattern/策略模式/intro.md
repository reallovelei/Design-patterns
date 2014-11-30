# 策略模式
### 定义
将一系列行为和算法封装成类，以适应某些特定的上下文环境，并且他们之间可以相互替换，策略模式使得算法可以独立于使用它的客户而变化。

### 角色
* **Strategy** 策略接口，用来约束一系列具体的策略算法。Context使用这个接口来调用具体的策略实现定义的算法。
* **ConcreteStrategy** 具体的策略实现(对Strategy接口的实现)，也就是具体的算法实现类(一般会有多个)
* **Context** 上下文，负责和具体的策略类(即ConcreteStrategy类)交互,通常上下文里会持有一个具体策略类的实现(即ConcreteStrategy类的对象)。上下文还可以让具体的策略类来获取上下文的数据。甚至让具体的策略类来调用上下文的方法。

## 举例
1. 电子商务中的打折算法，新用户全价，老用户9折，新增节假日各种折扣、满100减50。
2. 目前比较流行的互联网金融系统里有邀请码，使用不同类型用户的邀请码投资有不同的返利折扣等。
3. 代码以rango教程中广告系统针对用户性别展示广告的策略。

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
    funciont __construct(Strategy $strategy) {
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
$context = new Context($strategy);
$context->run();
```
