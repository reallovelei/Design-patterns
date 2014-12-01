<?php 
/**
 * 接口隔离原则 定义：客户端不应该依赖于它不需要的接口;一个类对另一个类的依赖应该建立在最小的接口上.
 * 以我的理解就是 把接口抽象的更细一些,而不是把一些无关的接口放在在一起。
 * 以下是一个不遵守接口隔离原则的接口
 * @author zhanglei5 <zhanglei5@group.com> 
 * @license PHP Version 3.0 {@link http://www.php.net/license/3_0.txt}
 */
interface All 
{
    function run();
    function eat();

    function getContent();
}

class Horse implements All
{
    function run(){
        echo  "\n A horse running!";
    }
    function eat(){
        echo  "\n A horse eatting!";
    }
    //   对于猫来说 是没有 getContent 的功能的所以是没有必要实现的
    function getContent(){
    }
} 

class Book implements All
{
   //   对于书来说 是没有run 和 eat的功能的所以是没有必要实现的 
    function run(){
    }
    function eat(){
    }

    function getContent(){
        echo  'A story from book!';
    }
} 

/**
 * TameHorser 驯马师
 * 
 * @package 
 * @version $id$
 * @copyright 1997-2005 The PHP Group
 * @author zhanglei5 <zhanglei5@group.com> 
 * @license PHP Version 3.0 {@link http://www.php.net/license/3_0.txt}
 */
class TameHorser {
    function takeHorseRun(All $horse) {
        $horse->run();
    }

    function takeHorseEat(All $horse) {
        $horse->eat();
    }
}

class Client {
    function run() {
        $horse = new Horse();
        $man = new TameHorser();
        $man->takeHorseRun($horse);
        $man->takeHorseEat($horse);
    }
}
$c = new Client();
$c->run();

/**
 * 显然上面的接口将不相关的功能封装在了一起,
 * 马对象实现的时候 也得实现一个与自己不相关的getContent.
 * 书类实现接口的时候 也得实现与自己不相关的eat  run方法.
 * 下面将其进行拆分。
 */

interface Animal 
{
    function run();
    function eat();
}

//出版物
interface Publication
{
    function getContent();
}

class Horse1 implements Animal
{
    function run(){
        echo  "\n A horse running!";
    }
    function eat(){
        echo  "\n A horse eatting!";
    }
} 

class Book1 implements Publication
{
    function getContent(){
        echo  'A story from book!';
    }
} 

class TameHorser1 {
    function takeHorseRun(Animal $horse) {
        $horse->run();
    }

    function takeHorseEat(Animal $horse) {
        $horse->eat();
    }
}

class Client1 {
    function run() {
        $horse = new Horse1();
        $man = new TameHorser();
        $man->takeHorseRun($horse);
        $man->takeHorseEat($horse);
    }
}
$c = new Client();
$c->run();

/**
 * 这样就可以不再看见上面那么臃肿的接口了。也不需要去实现与自己无关的功能了。就是尽量将接口细化,
 * 这只是我的个人愚见，本人功力尚浅。如有说的不对的地方还请指出.
 */

 ?>
