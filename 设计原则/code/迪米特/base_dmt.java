import java.util.*;
// 总公司
class Employee{
        private String id;
        public void setId(String id){
                this.id = id;
        }
        public String getId(){
                return id;
        }
}

// 分公司
class SubEmployee{
        private String id;
        public void setId(String id){
                this.id = id;
        }
        public String getId(){
                return id;
        }
}

class SubCompanyManager{
        public List<SubEmployee> getAllEmployee(){
                List<SubEmployee> list = new ArrayList<SubEmployee>();
                for(int i=1; i<=5; i++){
                        SubEmployee emp = new SubEmployee();
                        //为分公司人员按顺序分配一个ID
                        emp.setId("分公司"+i);
                        list.add(emp);
                }
                return list;
        }

        public void printAllEmployee(SubCompanyManager sub){
                List<SubEmployee> list1 = this.getAllEmployee();
                for(SubEmployee e:list1){
                        System.out.println(e.getId());
                }
        }
}

class CompanyManager{

        public List<Employee> getAllEmployee(){
            List<Employee> list = new ArrayList<Employee>();
            for(int i=1; i<=10; i++){
                    Employee emp = new Employee();
                    //为总公司人员按顺序分配一个ID
                    emp.setId("总公司"+i);
                    list.add(emp);
            }
            return list;
        }

        public void printAllEmployee(SubCompanyManager sub){
            // 主要就是这里变化了
            sub.printAllEmployee(sub);

            List<Employee> list2 = this.getAllEmployee();
            for(Employee e:list2){
                    System.out.println(e.getId());
            }
        }
}

class Client{
    public static void main(String[] args){
        CompanyManager e = new CompanyManager();
        e.printAllEmployee(new SubCompanyManager());
    }
}
