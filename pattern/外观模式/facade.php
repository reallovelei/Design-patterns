<?php
/**
 * Presentation 
 * 表现层代码生成 
 * @package 
 */
class Presentation {
    public function generate() {
        echo "正在生成表现层代码\n";
    }
}

class Business {
    public function generate() {
        echo "正在生成逻辑层代码\n";
    }
}

class DAO {
    public function generate() {
        echo "正在生成数据层代码\n";
    }
}
// 这是不使用外观模式的 实现方法 start
class Client {
    public function run() {
        $pre = new Presentation();
        $bus = new Business();
        $dao = new DAO();

        $pre->generate();
        $bus->generate();
        $dao->generate();

    }
}
$c = new Client();
$c->run();
// 不使用外观模式实现方法 end

/**
 * 引入外观类来实现  start
 * Facade 
 */
class Facade {
    public function generate() {
        $pre = new Presentation();
        $bus = new Business();
        $dao = new DAO();

        $pre->generate();
        $bus->generate();
        $dao->generate();
    }
}

/**
 * ClientFacade 
 * 客户端使用外观类 来实现
 */
class ClientFacade {
    public function run() {
        $facade = new Facade();
        $facade->generate();
    }
}
$c = new ClientFacade();
$c->run();
//  外观模式 end
?>
