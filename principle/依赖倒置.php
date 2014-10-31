<?php

/**
 * 书面定义 高层模块不应该依赖底层模块，两者都应该依赖于抽象。
 * 我的理解这个原则就应该叫做依赖抽象 原则，倒置是什么意思一直也没太明白。
 * 如下例中 妈妈要给宝宝讲故事，妈妈先是从书里读内容。
 * 而后从报纸里读内容。
 * 妈妈是调用者也就是 之前说的高层模块，而书和报纸是被调用者也就是之前说的底层模块。
 * 在妈妈这个类里没有出现Book类 也没有出现NewsPaper类。而是依赖了IReader接口的getContent方法返回内容。
 * 而book和newspaper类也是依赖IReader来实现具体的功能的。
 * 这就是我理解的依赖倒置。
 */
interface IReader{
     function getContent();
}
class Book implements  IReader{
     function getContent(){
          return "\nThis is story from book,long long ago ……";
     }
}
class NewsPaper implements  IReader{
     function getContent(){
          return "\nThis is story from Newspaper,In Yan Zhao gates, Gillian promiscuous behavior, but it makes unsightly. ……";
     }
}


class Mother{
     function tellStoryToBaby(IReader $obj){
          $content = $obj->getContent();
          return $content;
     }
}

//-----------这里是客户端的调用--------------------------
$mother = new Mother();
$reader = new Book();
echo $mother->tellStoryToBaby($reader);
/*------------如果想要换成其他的媒介对象从报纸中获得数据的话 不需要修改服务器端------------------
--------------因为依赖倒置从而使得开闭原则能够更好的得到实现------------*/
$reader = new NewsPaper();
echo $mother->tellStoryToBaby($reader);
die;
