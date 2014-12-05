# 策略模式
### 定义
将一系列行为和算法封装成类，以适应某些特定的上下文环境，并且他们之间可以相互替换，策略模式使得算法可以独立于使用它的客户而变化。

### 角色
* **Strategy** 策略接口，用来约束一系列具体的策略算法。Context使用这个接口来调用具体的策略实现定义的算法。
* **ConcreteStrategy** 具体的策略实现(对Strategy接口的实现)，也就是具体的算法实现类(一般会有多个)
* **Context** 上下文，负责和具体的策略类(即ConcreteStrategy类)交互,通常上下文里会持有一个具体策略类的实现(即ConcreteStrategy类的对象)。上下文还可以让具体的策略类来获取上下文的数据。甚至让具体的策略类来调用上下文的方法。

## 认识策略模式
1. **功能**  
策略模式的功能是把具体的算法实现从具体的业务处理中独立出来，把他们实现成独立的算法，从而形成一系列算法类，并让这些算法可以平等替换。策略的中心不是如何来实现算法，而是如何组织和调用这些算法，从而让程序更加灵活有更好的扩展性。
2. **策略和if-else语句**  
多个if-elseif表达的就是一种平等的功能结构，而策略模式就是把各个平等的具体实现封装到单独的策略实现类中，然后通过上下文来与具体的策略实现类来进行交互。因此多个if-elseif-……-else语句可以考虑策略模式。
3. **谁来选择具体策略算法**  
可以在两个地方  
一个在客户端，当使用上下文的时候，由客户端来选择具体的策略算法，然后把这个具体算法实现对象，给上下文。  
一个在上下文中选择具体的策略算法。
4. **Strategy的技巧**  
之前都是说Strategy都是用接口来定义的，但如果多个算法中有公共功能的话，可以将Strategy定义成抽象类，将公共功能放到Strategy抽象类中。
5. **运行时策略的唯一性**  
程序运行期间，在每一个时刻只能使用一个具体的策略实现对象。
6. **增加新策略**  
只需要增加一个策略实现类供客户端/上下文使用即可。

## 优点与缺点
### 优点
1. 定义了算法接口/抽象类，以及一系列算法具体实现，可以**让这些算法互相替换**。
2. **避免了多重条件语句**(有些情况下的各种if-elseif-elseif-else).
3. **更好的扩展性** 新增算法只需要新增策略实现类，然后在使用的地方调用这个新增的策略类即可。

### 缺点
1. **客户要了解每种策略的不同**，这样才能知道选择哪个策略，这样也暴露了策略的具体实现。
2. **增加了对象数目** 每个算法一个策略类，如果算法很多，那策略实现类就……
3. **只适合扁平的算法结构** 策略模式中的算法都是平级的，相当于兄弟关系，且在同一时刻只能有一种算法被使用，这就限制了算法的使用层级，不能被嵌套使用。  
**对于出现需要嵌套使用多个算法的情况，如：折上折、折后返利等情况，需要组合或嵌套使用多个算法，可以考虑使用装饰模式或变形的职责链或AOP等方式来实现**。

## 思考
1. 对设计原则的体现  
通过新增算法可以看出策略模式很好的体现了**[开闭原则](https://github.com/reallovelei/Design-patterns/blob/master/principle/%E5%BC%80%E9%97%AD%E5%8E%9F%E5%88%99.md)**。  
由于算法间是平等可以互相替换的，都是实现同一个接口或继承同一个父类。从而也体现了**[里氏替换原则](https://github.com/reallovelei/Design-patterns/blob/master/principle/%E9%87%8C%E6%B0%8F%E6%9B%BF%E6%8D%A2%E5%8E%9F%E5%88%99.md)**。
2. 何时选用策略模式  
1)出现同一种算法，有很多不同的实现的情况下。如之前说的各种打折。  
2)需要封装算法中，有与算法相关数据的情况下，可以使用策略模式来避免暴露这些跟算法相关的数据结构。
3)出现抽象一个定义很多行为的类，并且是通过多个if-else来选择行为的情况下。
3. **既然在客户端已经确定了具体策略实现对象。那上下文还有什么用呢？这是我个人的疑问**。


## 相关模式
* 策略模式和状态模式的区别
* 策略和模板方法的组合
* 策略和享元的组合

## 举例
1. 电子商务中的打折算法，新用户全价，老用户9折，新增节假日各种折扣、满100减50。
2. 目前比较流行的互联网金融系统里有邀请码，使用不同类型用户的邀请码投资有不同的返利折扣等。
3. 代码以[rango教程](http://www.imooc.com/video/4905)中广告系统针对用户性别展示广告的策略。

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
