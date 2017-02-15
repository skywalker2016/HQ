<?php
/**
 * Created by PhpStorm.
 * User: hongqiang
 * Date: 2017/1/5
 * Time: 9:38
 *
 *   1. 总数
 *   2. 每页显示多少条
 *
 *
 */

//分页类
class Page{
    private $total;   //总记录数
    private $nums;    //每页显示的条数
    private $pages;   //总页数
    private $cpage;   //当前页
    private $url;     //当前url

    public function __construct($total, $nums)
    {
        $this->total = $total;
        $this->nums = $nums;
        $this->pages = $this->getPages();
        $this->url = $this->setUrl();


        //获取当前页
        $this->cpage = !empty($_GET['page']) ? $_GET['page'] : $this->pages;
    }

    //获取URL
    private function setUrl(){
        $url = $_SERVER['REQUEST_URI'];    //获取当前url带参数的

        //判断是都有问号，有？说明有参数
        if (strstr($url, "?")){
            //使用parse_url函数将URL分成path和query两个部分
            $arr = parse_url($url);

            //如果有query下标在，说明有参数
            if (isset($arr['query'])){
                //使用parse_str函数将参数$page=5$page=6变成$output['page']=5  $output['page']=6
                parse_str($arr['query'], $output);
            }

            //删去数组中的下标是page的
            unset($output['page']);
            //再使用http_build_query将关联数组变成参数字符串
            $url = $arr['path'].'?'.http_build_query($output);
        }else{
            $url .= "?";
        }
        return $url;
    }

    //获取页数
    private function getPages(){
        return ceil($this->total/$this->nums);    //ceil函数为进1取整  ceil（3.1）=4
    }

    private function first(){
        //如果当前页是第一页，则不显示这些
        if ($this->cpage > 1){
            $prev = $this->cpage - 1;

            return '<a href="'.$this->url.'&page=1">首页</a>  <a href="'.$this->url.'&page='.$prev.'">上一页</a>';
        }else{
            return "";
        }
    }

    private function flist(){
        $list = "";
        $num = 4;
        //当前页之前的列表
        for ($i=$num; $i>=1; $i--){
            $page = $this->cpage - $i;

            if ($page >= 1){
                $list .= '&nbsp;<a href="'.$this->url.'&page='.$page.'">'.$page.'</a>&nbsp;';
            }else{
                continue;
            }
        }
        //当前页
        $list .= '&nbsp;';
        $list .= $this->cpage;
        $list .= '&nbsp;';
        //当前页之后的列表
        for ($i=1; $i<=$num; $i++){
            $page = $this->cpage + $i;
            //如果在页数之内的显示
            if ($page <= $this->pages){
                $list .= '&nbsp;<a href="'.$this->url.'&page='.$page.'">'.$page.'</a>&nbsp;';
            }else {
                break;
            }
        }

        return $list;
    }

    private function last(){
        if ($this->cpage < $this->pages){
            $next = $this->cpage + 1;

            return '<a href="'.$this->url.'&page='.$next.'">下一页</a>  <a href="'.$this->url.'&page='.$this->pages.'">末页</a>';
        }else{
            return "";
        }

    }

    //从多少条开始
    public function start(){
        if ($this->cpage >= 1) {
            return ($this->cpage - 1) * $this->nums + 1;
        }else{
            return 0;
        }
    }

    //从多少条结束
    private function end(){
        return min($this->cpage*$this->nums, $this->total);
    }

    //当前页显示的记录数
    private function currnum(){
        if ($this->start() == 0 && $this->end() == 0) {
            return 0;
        }else{
            return $this->end() - $this->start() + 1;
        }
    }

    //调用这条方法就可以使用分页
    function fpage(){
        $arr = func_get_args();  //获取所有的参数

        $fpage="";

        $list[0] = "&nbsp;总{$this->total}条记录&nbsp;";
        $list[1] = "&nbsp;本页显示".$this->currnum()."条记录&nbsp;";
        $list[2] = "&nbsp;从".$this->start()."-".$this->end()."条&nbsp;";
        $list[3] = "&nbsp;{$this->cpage}/{$this->pages}&nbsp;";
        $list[4] = "&nbsp;".$this->first()."&nbsp;";
        $list[5] = "&nbsp;".$this->flist()."&nbsp;";
        $list[6] = "&nbsp;".$this->last()."&nbsp;";

        if (count($arr) < 1){
            $arr = array(0, 1, 2, 3, 4, 5, 6);
        }

        foreach ($arr as $n){
            $fpage .= $list[$n];
        }

        return $fpage;
    }
}





?>