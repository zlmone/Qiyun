<?php
header("Content-type: text/html;charset=utf-8");
/**
 *封装WS
 */
class Ws
{
    public static $HOST = '0.0.0.0';
    public static $PORT = 9501;
    public $ws = null;

    public function __construct()
    {
        $this->ws = new swoole_websocket_server(self::$HOST, self::$PORT);
        $this->init();
        $this->ws->on('WorkerStart', [$this, 'onWorkerStart']);
        $this->ws->on('open', [$this, 'onPen']);
        $this->ws->on('message', [$this, 'onMessage']);
        $this->ws->on('close', [$this, 'onClose']);
        $this->ws->on('request', [$this, 'onReuqest']);
        $this->ws->on('task', [$this, 'onTask']);
        $this->ws->on('finish', [$this, 'onFinish']);
        $this->ws->start();
    }
    public function onPen($ws, $request)
    {
//        var_dump($request->fd, $request->get, $request->server);
//        $GLOBALS['fd']['id'] = $request->fd;
//        $ws->push($request->fd, "hello, welcome\n");//发送消息
        $ws->push($request->fd, "hello, welcome\n");
        app\common\lib\util\RedisUtil::getInstance()->lpush('userlist',$request->fd);
    }
    public function onClose($ws, $fd)
    {
        echo "client-{$fd} is closed\n";
        app\common\lib\util\RedisUtil::getInstance()->ldel('userlist',$fd);
    }
    public function onMessage($ws, $frame)
    {
//        if(!empty($frame->data))
//            swoole_async_write(__DIR__."/access.log",$frame->data.PHP_EOL,-1,function($filename){
//            });
        echo "Message: {$frame->data} 数据类型: {$frame->opcode} 数据帧是否完整: {$frame->finish} \n";
        $taskdata=[
            'method'=>'pushMsg',
            'data'=>[
                'data'=>$frame->data,
                'fd'=>$frame->fd
            ]
        ];
        $ws->task($taskdata);
//        $ws->push($frame->fd, "server: {$frame->data} ");
    }
    /**
     * 配置静态文件根目录
     */
    public function init()
    {
        $this->ws->set([
            'reactor_num' => 4,
            'worker_num' => 4,
            'task_worker_num' => 4,//此参数很重要，如果不大于0,task方法将不执行
            'document_root' => __DIR__ . '/../../public/static/swoole_w',
            'enable_static_handler' => true,//设置为底层收到Http请求会先判断document_root路径下是否存在此文件，如果存在会直接发送文件内容给客户端，不再触发onRequest回调。
        ]);
    }

    public function onReuqest(swoole_http_request $request, swoole_http_response $response)
    {
        $response->header("Content-Type", "text/html; charset=utf-8");
        $_SERVER = [];
        $_GET = [];
        $_POST = [];
        $_COOKIE = [];
        $_FILES = [];
        print_r($request->get);
        if (isset($request->server)) {
            foreach ($request->server as $key => $val) {
                $_SERVER[strtoupper($key)] = $val;
            }
        }
        if (isset($request->header)) {
            foreach ($request->header as $key => $val) {
                $_SERVER[strtoupper($key)] = $val;
            }
        }
        if (isset($request->get)) {
            foreach ($request->get as $key => $val) {
                $_GET[$key] = $val;
            }
        }
        if (isset($request->post)) {
            foreach ($request->post as $key => $val) {
                $_POST[$key] = $val;
            }
        }
        if (isset($request->cookie)) {
            foreach ($request->cookie as $key => $val) {
                $_COOKIE[$key] = $val;
            }
        }
        if (isset($request->files)) {
            foreach ($request->files as $key => $val) {
                $_FILES[$key] = $val;
            }
        }
        $_POST['http_server'] = $this->ws;
        ob_start();
        try {// 2. 执行应用
            think\App::run()->send();
        } catch (Exception $e) {
        }
        $res = ob_get_contents();
        ob_end_clean();
        $response->end($res);//发送数据操作,只能执行一次
    }

    public function onWorkerStart($serv, $worker_id)
    {
        //导入框架基类
        // 定义应用目录
        define('APP_PATH', __DIR__ . '/../../application/');
        define('ROOT_PATH', __DIR__ . '/../../');
        define('SITE_URL', 'http://lo calhost');
        //开启调试模式
        require __DIR__ . '/../../thinkphp/base.php';
        think\App::run();
        app\common\lib\util\RedisUtil::getInstance()->lreset('userlist');
    }

    /**
     * 处理异步任务
     * @param $serv
     * @param $task_id
     * @param $from_id
     * @param $data
     */
    public function onTask($serv, $task_id, $from_id, $data)
    {
        if(!isset($data) || !isset($data['method'])){
            return "task参数传入错误";
        }
        echo "收到异步任务";
        print_r($data);
        $obj = new app\common\lib\util\Task($this->ws);
        $method = $data['method'];
        $flag = $obj->$method($data['data'],function($res){
            echo "回调函数".$res;
        });
        return $flag;
    }

    /**
     * @param $serv
     * @param $task_id
     * @param $data
     */
    public function onFinish($serv, $task_id, $data)
    {
        echo "结果处理完成：" . $data;
    }
}

new Ws();
