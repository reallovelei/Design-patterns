import java.util.*;

// 类级别的单一职责
class Terrestrial{
    public void breathe(String animal){
        System.out.println(animal+"呼吸空气 class");
    }
}
class Aquatic{
    public void breathe(String animal){
        System.out.println(animal+"呼吸水 class");
    }
}

class Client{
    public static void main(String[] args){
      Terrestrial animal = new Terrestrial();
      animal.breathe("牛");
      animal.breathe("羊");
      animal.breathe("猪");

      Aquatic aquatic = new Aquatic();

      aquatic.breathe("鱼");
    }
}




















































