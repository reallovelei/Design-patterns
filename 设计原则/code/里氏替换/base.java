import java.util.*;

class Bird
{

    double velocity;
    public void fly(){
        System.out.println("I am fly");
    }

    public void setVelocity(double velocity){
        this.velocity = velocity;
    }

    public double getVelocity(){
        return this.velocity;
    }
}

// 鸵鸟
class Ostrich extends Bird
{
    public void fly() {
        System.out.println("I am so big, I can't fly");
    }

    public void setVelocity(double velocity) {
        this.velocity = 0;
    }
    public double getVelocity() {
        return 0;
    }
}


// 计算鸟飞越黄河的时间
class TestBird
{
    public void calcFlyTime(Bird bird) {
       try{
         double riverWidth = 3000;
         System.out.println("飞越黄河需要"+riverWidth / bird.getVelocity());
       }catch(Exception err){
         System.out.println("An error occured!");
       }
   }
}
class Client
{
    public static void main(String[] args){
        //Bird sb = new Bird();
        //sb.setVelocity(10);
        Ostrich o = new Ostrich();
        o.setVelocity(10);

        TestBird tb = new TestBird();
        tb.calcFlyTime(o);
    }
}


