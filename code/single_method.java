import java.util.*;

// 方法级别的单一职责
class Animal{

    public void breathe(String animal){
            System.out.println(animal+"呼吸空气");
    }

    public void breathe_water(String animal){
        System.out.println(animal+"呼吸水");
    }
}

class Client{
    public static void main(String[] args){
      Animal animal = new Animal();
      animal.breathe("牛");
      animal.breathe("羊");
      animal.breathe("猪");
      animal.breathe_water("鱼");
    }
}




















































