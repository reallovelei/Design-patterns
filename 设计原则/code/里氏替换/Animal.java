import java.util.*;

class Animal{
    String name;
    public Animal(String name) {
        this.name = name;
    }
    public void printName(){
        try{
            System.out.println("I am a " + name + "!");
        }catch(Exception err){
            System.out.println("An error occured!");
        }
    }
}

class Cat extends Animal{
    public Cat(String name){
        super(name);
    }
    public void Mew(){
        try{
            System.out.println("Mew~~~ ");
        }catch(Exception err){
            System.out.println("An error occured!");
        }
    }
}

class Dog extends Animal {
    public Dog(String name) {
        super(name);
    }
    public void Bark(){
        try{
            System.out.println("Bark~~~ ");
        }catch(Exception err){
            System.out.println("An error occured!");
        }
    }
}

// 像这种代码明显不符合里氏替换原则,给使用者造成的巨大的麻烦。要根据子类 类型来 执行相应的动作代码
class TestAnimal {
   public void TestLSP(Animal animal){
       animal.printName();   // 这种是推荐的方法
     if (animal instanceof Cat ){
         Cat cat = (Cat)animal;
         cat.Mew();
     }
     if (animal instanceof Dog ){

       Dog dog = (Dog)animal;
       dog.Bark();
     }
 }
}

class Client {
    public static void main(String args[]) {
        TestAnimal test = new TestAnimal();
        Cat c = new Cat("喵星人");
        Dog d = new Dog("汪星人");
        test.TestLSP(c);
        test.TestLSP(d);
    }
}
