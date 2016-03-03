import java.util.*;

class Animal{
    public void breathe(String animal){
      System.out.println(animal+"呼吸空气");
    }
}

class Client{
    public static void main(String[] args){
      Animal animal = new Animal();
      animal.breathe("牛");
      animal.breathe("羊");
      animal.breathe("猪");
    }
}

// 上线后，发现我靠，还有不是所有物种都是呼吸空气的, 现在要增加水生动物
// 如果是你会怎么做。
