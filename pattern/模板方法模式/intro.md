# 模板方法模式
### 定义
定义一个操作中的算法骨架，而将一些步骤延迟到子类中。模板方法使得子类可以不改变整个算法的结构就可以以重定义该算法的某些特定步骤。

### 角色
* 抽象类:主要是用于定义算法骨架和原语句操作，具体的子类通过重定义这些原语句操作来实现一个算法的各个步骤。同时，也可以实现一些算法中通用的方法。有差异的交由子类去具体实现。
* 具体实现类: 一般有2个以上(要是一个就没必要了)。用来实现算法骨架中的某些步骤，完成与特定子类相关的功能。

### 认识模板方法模式
1. **功能**
主要在于固定算法骨架，让具体算法实现可扩展。  
    这在实际应用中非常广泛，尤其是在设计框架级功能的时候非常有用。框架定义好算法的步骤。在合适的点让开发人员进行扩展，实现具体的算法。比如在DAO中实现通用的CURD功能，在Controller 基类中定义每次处理的顺序逻辑，如:beforeInvoke(),invoke(),afterinvoke()之类。  
    模板方法还有一个好处就是可以控制子类的扩展。因为在父类中的算法骨架中只有某些固定的点才会用到被子类实现的方法。因此也就只允许在这几个点来扩展功能，这些可以被子类覆盖以扩展功能的方法通常被称为"钩子"。
2. **为何不是接口**
有同学可能会想现在都说是面向接口编程，为什么模板方法里却用了抽象类？先来看下抽象类和接口的关系  
1)接口是一种特殊的抽象类，接口中的属性自动是常量，也就是public final static的，接口中所有的方法都必须是抽象的。  
2)抽象类里要注意的是抽象类和抽象方法的关系，记住两句话：**抽象类不一定包含抽象方法，有抽象方法的一定是抽象类。**  
3)抽象类和接口相比较，最大的区别就是在于**抽象类中可以有具体的方法实现**。  
4)一般在**既要约束子类行为，又要为子类提供公共方法**的时候使用抽象类。  
3. **变与不变**
程序设计一个很重要的思考点就是变与不变，把不变的抽象出来，进行公共的实现，把变化的分离出去，用接口来封装隔离，或者用抽象类来约束子类行为。
4. **好莱坞法则**
简单的说就是"不要找我们，我们会联系你"  
模板方法很好的体现这一点，作为父类的模板会在需要的时候，调用子类相应的方法，也就是由父类去找子类，而不是子类找父类。

举例：
前台登录/后台登录 到不同的表中查找数据，后台用户密码是md5加密，前台密码是base64_encode加密。

```php
abstract class LoginTemplate
{
    public final function login($username,$pwd)
    {
        //找出用户
        UserModel $user = $this->findUserByUsername($username);
        if ($user != null) {
            // 对密码进行加密
            $encrypt_pwd = $this->encryptPwd($pwd);
            if ($encrypt_pwd == $user['pwd']) {
                echo '成功';
                return true;
            } else {
                echo '失败';
            }
        }
        return false;
    }

    public abstract function findUserByUsername($username);

    public abstract function encryptPwd($pwd) 
    {
        return base64_encode($pwd);
    };
}

class Client extends LoginTemplate
{
    public function findUserByUsername($username)
    {
        $cm = new ClientUser();
        // 找出前台用户表里username 这里仅做示意
        $client_user = $cm->find($username);
        return $client_user;
    }
}

class Admin extends LoginTemplate
{
    public function findUserByUsername($username)
    {
        $am = new AdminUser();
        // 找出前台用户表里username 这里仅做示意
        $admin_user = $am->find($username);
        return $admin_user;
    }

    public function encryptPwd($pwd)
    {
        return md5($pwd);
    }
}

```
这样在客户端只需要区别是该 new Admin这个子类还是new Client子类 来处理login就行了。两个子类实现的方法都是抽象类中login方法里用到的一些方法。
